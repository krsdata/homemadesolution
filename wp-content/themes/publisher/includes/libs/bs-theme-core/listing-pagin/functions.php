<?php
/***
 *  BetterStudio Themes Core.
 *
 *  ______  _____   _____ _                           _____
 *  | ___ \/  ___| |_   _| |                         /  __ \
 *  | |_/ /\ `--.    | | | |__   ___ _ __ ___   ___  | /  \/ ___  _ __ ___
 *  | ___ \ `--. \   | | | '_ \ / _ \ '_ ` _ \ / _ \ | |    / _ \| '__/ _ \
 *  | |_/ //\__/ /   | | | | | |  __/ | | | | |  __/ | \__/\ (_) | | |  __/
 *  \____/ \____/    \_/ |_| |_|\___|_| |_| |_|\___|  \____/\___/|_|  \___|
 *
 *  Copyright © 2017 Better Studio
 *
 *
 *  Our portfolio is here: http://themeforest.net/user/Better-Studio/portfolio
 *
 *  \--> BetterStudio, 2017 <--/
 */


if ( ! function_exists( 'publisher_pagin_filter_wp_query_args' ) ) {
	/**
	 * Filter $atts array and return only required index for ajax handler
	 * @see Publisher_Theme_Listing_Pagin_Manager::handle_ajax_response()
	 *
	 * @param array  $args BF_Shortcode Class $atts array
	 * @param string $view listing class name, otherwise or callback name
	 *
	 * @return array filtered $atts values
	 */
	function publisher_pagin_filter_wp_query_args( $args, $view ) {

		$query_fields = array(
			'category',
			'tag',
			'taxonomy',
			'post_ids',
			'post_type',
			'count',
			'order_by',
			'order',
			'time_filter',
			'offset',
			'post_status',

			// publisher_pagin_create_query_args() function also use style & columns index to generate query
			'style',

			'post__not_in',
			'category__in',

			'show_excerpt',
			'author',

			'cats-tags-condition',
			'cats-condition',
			'tags-condition',

			'featured_image',
			'ignore_sticky_posts',

			'author_ids',

			'tax_query'

		);

		$valid_indexes = apply_filters(
			'publisher-theme-core/pagination/filter-data/' . $view,
			Publisher_Theme_Listing_Pagin_Manager::get_valid_indexes_data()
		);

		$query_fields = array_merge( $query_fields, $valid_indexes );

		return wp_array_slice_assoc( $args, $query_fields );
	}
}


if ( ! function_exists( 'publisher_pagin_filter_pagin_args' ) ) {
	/**
	 * Filter $atts array and return only required index for ajax handler
	 * @see Publisher_Theme_Listing_Pagin_Manager::handle_ajax_response()
	 *
	 * @param array $args Custom function args
	 *
	 * @return array filtered $atts values
	 */
	function publisher_pagin_filter_pagin_args( $args ) {

		$pagin_fields = array(
			'have_pagination',
			'have_slider',
			'listing',
		);

		return array_diff_key( $args, array_flip( (array) $pagin_fields ) );
	}
}


if ( ! function_exists( 'publisher_pagin_create_query_args' ) ) {
	/**
	 * Handy function to create master listing query args
	 *
	 * @param array $atts
	 * @param int   $paged
	 *
	 * @return bool
	 */
	function publisher_pagin_create_query_args( &$atts, $paged = 1 ) {

		$args = array();

		// order_by
		if ( ! empty( $atts['order_by'] ) ) {
			$args = publisher_get_order_filter_query( $atts['order_by'] );
		}

		// order
		if ( ! empty( $atts['order'] ) ) {
			$args['order'] = $atts['order'];
		}

		// post type
		if ( ! empty( $atts['post_type'] ) ) {
			$args['post_type'] = $atts['post_type'];
		}

		// posts per page
		if ( ! empty( $atts['count'] ) && intval( $atts['count'] ) > 0 ) {
			$args['posts_per_page'] = $atts['count'];
		}

		// paged
		if ( isset( $atts['paginate'] ) && substr( $atts['paginate'], 0, 6 ) === 'simple' ) {
			$paged = $args['paged'] = bf_get_query_var_paged();
		}

		// offset
		if ( ! empty( $atts['offset'] ) ) {
			if ( $paged > 1 ) {
				$args['offset'] = intval( $atts['offset'] ) + ( ( $paged - 1 ) * $args['posts_per_page'] );
			} else {
				$args['offset'] = intval( $atts['offset'] );
			}
		}
		/*

		if ( ! empty( $atts['taxonomy'] ) ) {

			$tax_query = array();

			foreach ( explode( ',', $atts['taxonomy'] ) as $tax ) {

				$tax = explode( ':', $tax );

				if ( count( $tax ) >= 2 ) {
					$tax_term = get_term( $tax[1], $tax[0] );
					if ( ! is_wp_error( $tax_term ) ) {
						$tax_query[] = array(
							'taxonomy' => $tax[0],
							'field'    => 'term_id',
							'terms'    => array( $tax[1] ),
						);
					}
				}
			}

			if ( ! empty( $tax_query ) ) {
				$tax_query['relation'] = 'OR';
				$args['tax_query']     = $tax_query;
			}
		}


		// Category
		if ( ! empty( $atts['category'] ) ) {
			$args['cat'] = $atts['category'];
		}

		// Tag
		if ( ! empty( $atts['tag'] ) ) {

			if ( ! is_array( $atts['tag'] ) ) {
				$tags = explode( ',', $atts['tag'] );
			} else {
				$tags = $atts['tag'];
			}

			$args['tag__in'] = $tags;
		}
		*/

		// Post id filters
		if ( ! empty( $atts['post_ids'] ) ) {

			if ( is_array( $atts['post_ids'] ) ) {
				$post_id_array = $atts['post_ids'];
			} else {
				$post_id_array = explode( ',', $atts['post_ids'] );
			}

			$post_in     = array();
			$post_not_in = array();

			// Split ids into post_in and post_not_in
			foreach ( $post_id_array as $post_id ) {

				$post_id = trim( $post_id );

				// TODO: Refactor this!
				if ( is_numeric( $post_id ) ) {
					if ( intval( $post_id ) < 0 ) {
						$post_not_in[] = str_replace( '-', '', $post_id );
					} else {
						$post_in[] = $post_id;
					}
				}
			}

			if ( ! empty( $post_not_in ) ) {
				$args['post__not_in'] = $post_not_in;
			}

			if ( ! empty( $post_in ) ) {
				$args['post__in'] = $post_in;
				$args['orderby']  = 'post__in';
			}
		}

		// Custom post types
		if ( ! empty( $atts['post_type'] ) ) {
			if ( is_array( $atts['post_type'] ) ) {
				$args['post_type'] = $atts['post_type'];
			} else {
				$args['post_type'] = explode( ',', $atts['post_type'] );
			}
		}

		// Time filter
		if ( ! empty( $atts['time_filter'] ) ) {
			$args['date_query'] = publisher_get_time_filter_query( $atts['time_filter'] );
		}

		if ( ! isset( $atts['ignore_sticky_posts'] ) ) {
			$args['ignore_sticky_posts'] = TRUE;
		} else {
			$args['ignore_sticky_posts'] = $atts['ignore_sticky_posts'];
		}

		if ( isset( $atts['category__in'] ) ) {
			$args['category__in'] = array_map( 'absint', (array) $atts['category__in'] );
		}

		if ( isset( $atts['post__not_in'] ) ) {
			$args['post__not_in'] = array_map( 'absint', (array) $atts['post__not_in'] );
		}

		if ( isset( $atts['author'] ) ) {
			$args['author'] = intval( $atts['author'] );
		}

		if ( ! empty( $atts['author_ids'] ) ) {

			$author__in     = array();
			$author__not_in = array();

			foreach ( explode( ',', $atts['author_ids'] ) as $author_id ) {

				$author_id = intval( $author_id );

				if ( $author_id === 0 ) {
					continue;
				}

				if ( $author_id > 0 ) {

					$author__in[] = $author_id;
				} else {

					$author__not_in[] = $author_id;
				}
			}

			if ( $author__in ) {
				$args['author__in'] = $author__in;
			}

			if ( $author__not_in ) {
				$args['author__not_in'] = $author__not_in;
			}

		}


		/**
		 * Start Handle Query Conditions
		 */
		if ( empty( $args['tax_query'] ) ) {
			$args['tax_query'] = array();
		}

		if ( ! empty( $atts['category'] ) ) {

			$terms_id_include = array();
			$terms_id_exclude = array();

			foreach ( explode( ',', $atts['category'] ) as $term_id ) {
				if ( $term_id[0] === '-' ) {
					$terms_id_exclude[] = substr( $term_id, 1 );
				} else {
					$terms_id_include[] = $term_id;
				}
			}

			$args['tax_query'][] = array(
				'terms'            => bf_get_term_childs( $terms_id_include, $terms_id_exclude ),
				'taxonomy'         => 'category',
				'field'            => 'term_id',
				'operator'         => isset( $atts['cats-condition'] ) ? strtoupper( $atts['cats-condition'] ) : 'IN',
				'include_children' => FALSE,
			);

			if ( $terms_id_exclude ) {
				$args['tax_query'][] = array(
					'taxonomy'         => 'category',
					'field'            => 'term_id',
					'terms'            => $terms_id_exclude,
					'operator'         => 'NOT IN',
					'include_children' => FALSE,
				);
			}

		}

		if ( ! empty( $atts['taxonomy'] ) ) {
			$terms = array();

			if ( preg_match_all( '/  ([^:]+) : ([^,]+) \s* \,? /isx', $atts['taxonomy'], $matches ) ) {

				foreach ( $matches[1] as $idx => $taxonomy ) {
					$taxonomy = trim( $taxonomy );
					$term_id  = trim( $matches[2][ $idx ] );
					$section  = $term_id[0] === '-' ? 'exclude' : 'include';

					$terms[ $taxonomy ][ $section ][] = absint( $term_id );
				}
			}

			foreach ( $terms as $taxonomy => $terms ) {

				$terms_id_include = isset( $terms['include'] ) ? $terms['include'] : array();
				$terms_id_exclude = isset( $terms['exclude'] ) ? $terms['exclude'] : array();

				$args['tax_query'][] = array(
					'terms'            => bf_get_term_childs( $terms_id_include, $terms_id_exclude, $taxonomy ),
					'taxonomy'         => $taxonomy,
					'field'            => 'term_id',
					'operator'         => isset( $atts['cats-condition'] ) ? strtoupper( $atts['cats-condition'] ) : 'IN',
					'include_children' => FALSE,
				);

				if ( $terms_id_exclude ) {
					$args['tax_query'][] = array(
						'taxonomy'         => $taxonomy,
						'field'            => 'term_id',
						'terms'            => $terms_id_exclude,
						'operator'         => 'NOT IN',
						'include_children' => FALSE,
					);
				}
			}

		}

		if ( ! empty( $atts['tag'] ) ) {

			$args['tax_query'][] = array(
				'taxonomy'         => 'post_tag',
				'field'            => 'term_id',
				'terms'            => explode( ',', $atts['tag'] ),
				'operator'         => isset( $atts['tags-condition'] ) ? strtoupper( $atts['tags-condition'] ) : 'IN',
				'include_children' => FALSE,
			);
		}

		if ( $args['tax_query'] ) {
			$args['tax_query']['relation'] = isset( $atts['cats-tags-condition'] ) ? $atts['cats-tags-condition'] : 'AND';
		} else if ( ! empty( $atts['tax_query'] ) ) {
			$args['tax_query'] = $atts['tax_query']; // Ajax request pass tax_query
		}

		/**
		 * END Handle Query Conditions
		 */

		if ( ! empty( $atts['featured_image'] ) ) {
			if ( isset( $args['meta_query'] ) ) {
				$args['meta_query'][] = array(
					'key'     => '_thumbnail_id',
					'compare' => 'EXISTS'
				);
			} else {
				$args['meta_query'] = array(
					array(
						'key'     => '_thumbnail_id',
						'compare' => 'EXISTS'
					)
				);
			}
		}

		$args['post_status'] = 'publish';

		return $args;
	} // publisher_pagin_create_query_args
}


if ( ! function_exists( 'publisher_theme_pagin_manager' ) ) {

	/**
	 * Get Publisher_Theme_Listing_Pagin_Manager Class instance
	 *
	 * @return Publisher_Theme_Listing_Pagin_Manager
	 */
	function publisher_theme_pagin_manager() {
		return Publisher_Theme_Listing_Pagin_Manager::Run();
	}  // publisher_theme_pagin_manager
}


if ( ! function_exists( 'publisher_pagin_hash_generate' ) ) {

	/**
	 * Generate unique hash for input data
	 *
	 * @param array|object $array
	 *
	 * @return bool|string hash string on success or false otherwise
	 */
	function publisher_pagin_hash_generate( $array ) {

		if ( is_object( $array ) ) {
			$array = get_object_vars( $array );
		} else if ( ! is_array( $array ) ) {
			return FALSE;
		}
		$keys_to_remove = array(
			'paged' => '',
		);

		//remove some indexes
		$array = array_diff_key( $array, $keys_to_remove );
		$array = bf_map_deep( $array, 'publisher_pagin_hash_data_filter' );
		$array = array_filter( $array );
		ksort( $array );

		$hash = substr( wp_hash( serialize( $array ), 'nonce' ), 5, 7 );

		return $hash;
	}
}


if ( ! function_exists( 'publisher_pagin_hash_verify' ) ) {
	/**
	 * Verify Hash
	 *
	 * @param string       $hash
	 * @param array|object $data
	 *
	 * @return bool true on success or false on failure.
	 */
	function publisher_pagin_hash_verify( $hash, $data ) {
		return $hash === publisher_pagin_hash_generate( $data );
	}
}


if ( ! function_exists( 'publisher_pagin_hash_data_filter' ) ) {
	/**
	 * Filters data for making correct hash from it
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	function publisher_pagin_hash_data_filter( $data ) {
		$new_data = filter_var( $data, FILTER_VALIDATE_INT );

		return $new_data === FALSE ? $data : $new_data;
	}
}


if ( ! function_exists( 'publisher_pagin_js_data_filter' ) ) {
	/**
	 * Converts boolean values to it for JS of pagination
	 *
	 * @param $data
	 *
	 * @return string
	 */
	function publisher_pagin_js_data_filter( $data ) {
		return is_bool( $data ) ? (int) $data : $data;
	}
}
