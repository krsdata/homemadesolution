<?php

BF_Content_Inject::init();

/**
 * Class BF_Content_Inject
 *
 * Inject custom code into post content in single page
 *
 * @since 2.10.0
 */
class BF_Content_Inject {

	/**
	 * Store injections list
	 *
	 * @var array
	 *
	 * @since 2.10.0
	 */
	static $injections = array();


	/**
	 * Inject custom config
	 *
	 * @param array   $item        array {
	 *
	 * @type int      $priority    action priority.optional. default 10
	 * @type string   $position    top|middle|bottom|{Paragraph Number}
	 * @type string   $content     content to inject. optional if $content_cb set
	 * @type callable $content_cb  deferred content callback name. optional if $content set
	 *
	 * @type string   $user_status user sign-in status which is logged-in|guest. optional.
	 * @type callable $filter_cb   custom filter callback. optional.
	 * @type string   $post_type   post type filter. optional.
	 * @type array    $author      authors ID. optional.
	 * @type array    $taxonomies  terms ID. optional. array {
	 *
	 * @type string   $taxonomy    => @type array terms ID
	 *
	 * ...
	 * }
	 * }
	 *
	 * @since 2.10.0
	 */
	public static function inject( $item = array() ) {
		self::$injections[] = $item;
	}


	/**
	 * Initialize library
	 *
	 * @since 2.10.0
	 */
	public static function init() {
		add_action( 'the_content', 'BF_Content_Inject::the_content', 9 );
	}


	/**
	 * Modify post content and append custom codes
	 *
	 * @param string $content
	 *
	 * @since 2.10.0
	 * @return string
	 */
	public static function the_content( $content ) {

		$before = $after = '';

		$paragraph_changed = FALSE;

		usort( self::$injections, 'BF_Content_Inject::priority_sort' );
		usort( self::$injections, 'BF_Content_Inject::sort_config' );

		foreach ( self::$injections as $_inject ) {

			if ( ! self::can_inject( $_inject ) ) {
				continue;
			}

			if ( isset( $_inject['content_cb'] ) ) {

				$inject = call_user_func( $_inject['content_cb'], $_inject );
			} else {

				$inject = $_inject['content'];
			}


			if ( $_inject['position'] === 'top' ) {

				$before .= $inject;

			} else if ( $_inject['position'] === 'bottom' ) {

				$after .= $inject;

			} else {

				if ( ! isset( $html_blocks ) ) {
					$html_blocks       = self::get_html_blocks( $content );
					$html_blocks_count = count( $html_blocks );
				}

				if ( $_inject['position'] === 'middle' ) {

					$p = floor( $html_blocks_count / 2 );
					self::inject_after( $html_blocks, $inject, $p );
					$paragraph_changed = TRUE;

				} else if ( $p = intval( $_inject['position'] ) ) {

					if ( ! $after || ( $p !== $html_blocks_count ) ) {

						self::inject_after( $html_blocks, $inject, $p );
						$paragraph_changed = TRUE;
					}

				}
			}
		}

		if ( $paragraph_changed ) {
			$content = implode( ' ', $html_blocks );
		}

		return $before . $content . $after;

	} // the_content


	/**
	 * Whether to check can inject custom code or not
	 *
	 * @param array    $conf
	 *
	 * @global WP_Post $post Wordpress active post object
	 *
	 * @since 2.10.0
	 * @return bool true if possible
	 */
	public static function can_inject( $conf ) {

		global $post;

		$return = TRUE;


		//
		// Filter callback
		//
		if ( ! empty( $conf['filter_cb'] ) ) {
			$return = call_user_func( $conf['filter_cb'], $post->ID, $conf, $post );

			if ( ! $return ) {
				return $return;
			}
		}


		//
		// Post type filter
		//
		if ( ! empty( $conf['post_type'] ) ) {

			if ( is_string( $conf['post_type'] ) ) {
				if ( $conf['post_type'] !== $post->post_type ) {
					$return = FALSE;
				}
			} elseif ( is_array( $conf['post_type'] ) ) {
				if ( ! in_array( $post->post_type, $conf['post_type'] ) ) {
					$return = FALSE;
				}
			}

			if ( ! $return ) {
				return $return;
			}
		}


		//
		// User status
		//
		if ( ! empty( $conf['user_status'] ) ) {

			$return = is_user_logged_in() ? 'logged-in' === $conf['user_status'] : 'guest' === $conf['user_status'];

			if ( ! $return ) {
				return $return;
			}
		}


		//
		// Post Author
		//
		if ( ! empty( $conf['author'] ) ) {

			$return = in_array( $post->post_author, $conf['author'] );

			if ( ! $return ) {
				return $return;
			}
		}


		//
		// Taxonomy
		//
		if ( ! empty( $conf['taxonomies'] ) ) {

			foreach ( $conf['taxonomies'] as $taxonomy => $IDs ) {

				$terms_id = wp_get_post_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );

				if ( is_wp_error( $terms_id ) || array_diff( $IDs, $terms_id ) ) {

					$return = FALSE;
					break;
				}
			}

		}


		return $return;

	} // can_inject


	/**
	 * Divide html into several block
	 *
	 * @param string $html
	 *
	 * @since 2.10.0
	 * @return array|bool false on failure or array on success
	 */
	public static function get_html_blocks( $html ) {

		$block_level_elements = 'address|article|aside|blockquote|canvas|dd|div|dl|fieldset|figcaption|figure|footer|form|h1|h2|h3|h4|h5|h6|header|hgroup|hr|li|main|nav|ol|output|p|pre|section|table|tfoot|ul|video';

		preg_match_all( '/
			( # Capture Whole HTML or Text
				( < \s* (' . $block_level_elements . ')  (?=.*\>) )? # Select HTML Open Tag

				(?(2)  # IF Open Tag Exists
					.*?  # accept innerHTML
		             <\s*\/\s*(?:\\3) \s* > \s* # Select HTML Close Tag
				|  # Else
				[^\n]+  # Capture pain text
				)  #END Condition
			)
		 /six', $html, $match );

		if ( empty( $match ) ) {
			return FALSE;
		}

		if ( array_filter( $match[3] ) ) { // html tag exits

			/**
			 * Fix Nested HTML Tag
			 */
			$html_blocks = array( '' );
			$last_index  = 0;

			$mark_plain_text_as_new_block = TRUE;

			foreach ( $match[3] as $index => $tag ) {

				if ( $tag ) {
					$last_index ++;

					$html_blocks[ $last_index ]   = $match[0][ $index ];
					$mark_plain_text_as_new_block = TRUE;

				} else {

					$is_plain_text = ! strstr( $match[1][ $index ], '<' );

					if ( $is_plain_text && $mark_plain_text_as_new_block ) {

						$html_blocks[ ++ $last_index ] = $match[0][ $index ];
						$mark_plain_text_as_new_block  = FALSE;

					} else {

						$html_blocks[ $last_index ] .= $match[0][ $index ];
					}
				}
			}
		} else { // there is no html tag

			$html_blocks = array();

			$i = 0;
			foreach ( $match[0] as $text ) {

				if ( trim( $text ) === '' ) {
					$i ++;
					continue;
				}

				if ( ! isset( $html_blocks[ $i ] ) ) {
					$html_blocks[ $i ] = '';
				}

				$html_blocks[ $i ] .= "\n";
				$html_blocks[ $i ] .= $text;

			}
		}

		return $html_blocks;
	} // get_html_blocks


	/**
	 * Inject custom code after a paragraph
	 *
	 * @param array  $paragraphs
	 * @param string $content2inject content to inject into main
	 * @param int    $paragraph      paragraph number
	 *
	 * @since 2.10.0
	 * @return string content
	 */
	public static function inject_after( &$paragraphs, $content2inject, $paragraph ) {

		$paragraph --;
		if ( isset( $paragraphs[ $paragraph ] ) ) {
			$paragraphs[ $paragraph ] .= $content2inject;
		}
	}


	/**
	 * Move bottom position indexes up
	 *
	 * @param array  $a
	 * @param  array $b
	 *
	 * @since 2.10.0
	 * @return int
	 */
	public static function sort_config( $a, $b ) {

		if ( $a['position'] === 'bottom' ) {
			return - 1;
		}
		if ( $b['position'] === 'bottom' ) {
			return 1;
		}

		return 0;
	}


	/**
	 * Sort config array by priority
	 *
	 * @param array  $a
	 * @param  array $b
	 *
	 * @since 2.10.0
	 * @return int
	 */
	public static function priority_sort( $a, $b ) {

		$a_priority = isset( $a['priority'] ) ? $a['priority'] : 10;
		$b_priority = isset( $b['priority'] ) ? $b['priority'] : 10;

		if ( $a_priority == $b_priority ) {
			return 0;
		} else if ( $a_priority < $b_priority ) {
			return - 1;
		} else if ( $a_priority > $b_priority ) {
			return 1;
		}
	}
}


if ( ! function_exists( 'bf_content_inject' ) ) {

	/**
	 * Inject custom config
	 *
	 * @param array $inject
	 *
	 * @see BF_Content_Inject::inject
	 */
	function bf_content_inject( $inject = array() ) {
		BF_Content_Inject::inject( $inject );
	}
}
