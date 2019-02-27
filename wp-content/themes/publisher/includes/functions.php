<?php

$template_directory = trailingslashit( get_template_directory() );
$template_uri       = trailingslashit( get_template_directory_uri() );

if ( ! defined( 'PUBLISHER_THEME_ADMIN_ASSETS_URI' ) ) {
	define( 'PUBLISHER_THEME_ADMIN_ASSETS_URI', $template_uri . 'includes/admin-assets/' );
}

if ( ! defined( 'PUBLISHER_THEME_PATH' ) ) {
	define( 'PUBLISHER_THEME_PATH', $template_directory );
}

if ( ! defined( 'PUBLISHER_THEME_URI' ) ) {
	define( 'PUBLISHER_THEME_URI', $template_uri );
}

add_filter( 'publisher-theme-core/config', 'publisher_config_theme_core', 22 );

if ( ! function_exists( 'publisher_config_theme_core' ) ) {
	/**
	 * Callback: Config "Publisher Theme Core" library needle sections.
	 * Filter: publisher-theme-core/config
	 *
	 * @param array $config
	 *
	 * @return array
	 */
	function publisher_config_theme_core( $config = array() ) {

		$config['dir-path']   = PUBLISHER_THEME_PATH . 'includes/libs/bs-theme-core/';
		$config['dir-url']    = PUBLISHER_THEME_URI . 'includes/libs/bs-theme-core/';
		$config['theme-slug'] = 'publisher';
		$config['theme-name'] = __( 'Publisher', 'publisher' );

		$config['sections']['attr']                   = TRUE;
		$config['sections']['meta-tags']              = TRUE;
		$config['sections']['listing-pagin']          = TRUE;
		$config['sections']['translation']            = TRUE;
		$config['sections']['social-meta-tags']       = TRUE;
		$config['sections']['chat-format']            = TRUE;
		$config['sections']['duplicate-posts']        = TRUE;
		$config['sections']['gallery-slider']         = TRUE;
		$config['sections']['shortcodes-placeholder'] = is_user_logged_in();
		$config['sections']['editor-shortcodes']      = TRUE;
		$config['sections']['theme-helpers']          = TRUE;
		$config['sections']['vc-helpers']             = TRUE;
		$config['sections']['rebuild-thumbnails']     = TRUE;
		$config['sections']['page-templates']         = TRUE;
		$config['sections']['post-fields']            = TRUE;
		$config['sections']['lazy-load']              = TRUE;

		$config['vc-widgets-atts'] = array(
			'before_title'  => '<h5 class="widget-heading"><span class="h-text">',
			'after_title'   => '</span></h5>',
			'before_widget' => '<div id="%1$s" class="widget vc-widget %2$s">',
			'after_widget'  => '</div>',
		);

		return $config;
	}
}


// Init BetterTranslation for theme
add_filter( 'publisher-theme-core/translation/config', 'publisher_translations_config' );

if ( ! function_exists( 'publisher_translations_config' ) ) {
	/**
	 * Callback: Publisher Translation configurations
	 *
	 * Filter: better-translation/config
	 *
	 * @param $config
	 *
	 * @return mixed
	 */
	function publisher_translations_config( $config ) {

		$config['theme-id']      = 'publisher';
		$config['theme-name']    = 'Publisher';
		$config['notice-icon']   = PUBLISHER_THEME_URI . 'images/admin/notice-logo.png';
		$config['menu-parent']   = 'bs-product-pages-welcome';
		$config['menu-position'] = 55;

		return $config;
	} // publisher_translations_config
}


/**
 * functions.php
 *---------------------------
 * This file contains general functions that used inside theme to
 * do important sections.
 *
 * We create them in a way that you can override them in child them simply!
 * Simply copy the function into child theme and remove the "if( ! function_exists( '*****' ) ){".
 */

/**
 * Callback: Enable oculus error logging system for theme
 * Filter  : better-framework/oculus/logger/filter
 *
 * @access private
 *
 * @param boolean $bool previous value
 * @param string  $product_dir
 * @param string  $type_dir
 *
 * @return bool true if error belongs to theme, previous value otherwise.
 */
function publisher_enable_error_collector( $bool, $product_dir, $type_dir ) {
	if ( $type_dir === 'themes' ) {
		return $product_dir !== get_template();
	}

	return $bool;
}


add_filter( 'better-framework/oculus/logger/turn-off', 'publisher_enable_error_collector', 22, 3 );

if ( ! function_exists( 'publisher_get_theme_panel_id' ) ) {
	/**
	 * Used to get theme panel id
	 *
	 * @return string
	 */
	function publisher_get_theme_panel_id() {
		return 'bs_' . 'publisher_theme_options';
	}
}

// Config demos
include $template_directory . 'includes/demos/init.php';


// Initialize styles
include $template_directory . 'includes/styles/init.php';


if ( ! function_exists( 'publisher_cat_main_slider_config' ) ) {
	/**
	 * Deprecated function.
	 * Use publisher_main_slider_config
	 *
	 * @param null $term_id
	 *
	 * @return array|mixed
	 */
	function publisher_cat_main_slider_config( $term_id = NULL ) {
		return publisher_main_slider_config( array(
			'type'    => 'term',
			'term_id' => is_null( $term_id ) ? '' : $term_id,
		) );
	}
}


if ( ! function_exists( 'publisher_main_slider_config' ) ) {
	/**
	 * Prepare main slider config
	 *
	 * @param array $args
	 *
	 * @return array|mixed
	 */
	function publisher_main_slider_config( $args = array() ) {

		$args = bf_merge_args( $args, array(
			'type'    => 'term',
			'term_id' => '',
		) );


		// return from cache
		if ( publisher_get_global( $args['type'] . '-slider-config' ) != NULL ) {
			return publisher_get_global( $args['type'] . '-slider-config' );
		}

		//
		// Base config
		//
		$config = array(
			'type'      => 'default',
			'style'     => 'default',
			'overlay'   => 'default',
			'show'      => FALSE,
			'in-column' => FALSE,
		);

		//
		// Term Type
		//
		if ( $args['type'] === 'term' ) {

			if ( empty( $args['term_id'] ) ) {
				$queried_object = get_queried_object();

				if ( isset( $queried_object->term_id ) ) {
					$args['term_id'] = $queried_object->term_id;
				}
			}

			// get from current term
			if ( publisher_is_valid_tax() ) {
				$config['type'] = bf_get_term_meta( 'slider_type', $args['term_id'] );
			}

			// slider Type
			if ( $config['type'] == 'default' ) {
				$config['type'] = publisher_get_option( 'cat_slider' );
			}
		} elseif ( $args['type'] === 'home' ) {

			// slider Type
			$config['type'] = publisher_get_option( 'home_slider' );
		}

		if ( ! publisher_is_valid_slider_type( $config['type'] ) ) {
			$config['type'] = 'disable';
		}

		switch ( $config['type'] ) {

			case 'disable':
				$config['style']     = 'disable';
				$config['directory'] = '';
				$config['file']      = '';
				$config['show']      = FALSE;
				$config['posts']     = 0;
				break;

			case 'custom-blocks':

				//
				// Term type
				//
				if ( $args['type'] === 'term' ) {

					// get from current term
					if ( publisher_is_valid_tax() ) {
						$config['style']   = bf_get_term_meta( 'better_slider_style', $args['term_id'] );
						$config['overlay'] = bf_get_term_meta( 'better_slider_gradient', $args['term_id'] );
					}

					// Slider style
					if ( $config['style'] == 'default' ) {
						$config['style'] = publisher_get_option( 'cat_top_posts' );
					}

					// overlay
					if ( $config['overlay'] == 'default' ) {
						$config['overlay'] = publisher_get_option( 'cat_top_posts_gradient' );
					}
				}
				//
				// Home type
				//
				elseif ( $args['type'] === 'home' ) {

					// Slider style
					$config['style'] = publisher_get_option( 'home_top_posts' );

					// overlay
					$config['overlay'] = publisher_get_option( 'home_top_posts_gradient' );
				}

				// Validate it
				if ( ! publisher_is_valid_topposts_style( $config['style'] ) ) {
					$config['style'] = 'disable';
				}

				// Posts config
				switch ( $config['style'] ) {

					case 'style-1':
						$config['directory'] = 'loop';
						$config['file']      = 'listing-modern-grid-1';
						$config['show']      = TRUE;
						$config['posts']     = 4;
						$config['in-column'] = FALSE;
						break;

					case 'style-2':
						$config['directory'] = 'loop';
						$config['file']      = 'listing-modern-grid-1';
						$config['show']      = TRUE;
						$config['posts']     = 4;
						$config['in-column'] = TRUE;
						break;

					case 'style-3':
						$config['directory'] = 'loop';
						$config['file']      = 'listing-modern-grid-2';
						$config['show']      = TRUE;
						$config['posts']     = 5;
						$config['in-column'] = FALSE;
						break;

					case 'style-4':
						$config['directory'] = 'loop';
						$config['file']      = 'listing-modern-grid-2';
						$config['show']      = TRUE;
						$config['posts']     = 5;
						$config['in-column'] = TRUE;
						break;

					case 'style-5':
						$config['directory'] = 'loop';
						$config['file']      = 'listing-modern-grid-3';
						$config['show']      = TRUE;
						$config['posts']     = 3;
						$config['columns']   = 3;
						$config['in-column'] = FALSE;
						break;

					case 'style-6':
						$config['directory'] = 'loop';
						$config['file']      = 'listing-modern-grid-3';
						$config['show']      = TRUE;
						$config['posts']     = 2;
						$config['columns']   = 2;
						$config['in-column'] = TRUE;
						break;

					case 'style-7':
						$config['directory'] = 'loop';
						$config['file']      = 'listing-modern-grid-4';
						$config['show']      = TRUE;
						$config['posts']     = 4;
						$config['columns']   = 4;
						$config['in-column'] = FALSE;
						break;

					case 'style-8':
						$config['directory'] = 'loop';
						$config['file']      = 'listing-modern-grid-4';
						$config['show']      = TRUE;
						$config['posts']     = 3;
						$config['columns']   = 3;
						$config['in-column'] = TRUE;
						break;

					case 'style-9':
						$config['directory'] = 'shortcodes';
						$config['file']      = 'bs-slider-1';
						$config['show']      = TRUE;
						$config['posts']     = 3;
						$config['columns']   = '';
						$config['in-column'] = FALSE;
						break;

					case 'style-10':
						$config['directory'] = 'shortcodes';
						$config['file']      = 'bs-slider-1';
						$config['show']      = TRUE;
						$config['posts']     = 3;
						$config['columns']   = '';
						$config['in-column'] = TRUE;
						break;

					case 'style-11':
						$config['directory'] = 'shortcodes';
						$config['file']      = 'bs-slider-2';
						$config['show']      = TRUE;
						$config['posts']     = 3;
						$config['columns']   = '';
						$config['in-column'] = FALSE;
						break;

					case 'style-12':
						$config['directory'] = 'shortcodes';
						$config['file']      = 'bs-slider-2';
						$config['show']      = TRUE;
						$config['posts']     = 3;
						$config['columns']   = '';
						$config['in-column'] = TRUE;
						break;

					case 'style-13':
						$config['directory'] = 'shortcodes';
						$config['file']      = 'bs-slider-3';
						$config['show']      = TRUE;
						$config['posts']     = 3;
						$config['columns']   = '';
						$config['in-column'] = FALSE;
						break;

					case 'style-14':
						$config['directory'] = 'shortcodes';
						$config['file']      = 'bs-slider-3';
						$config['show']      = TRUE;
						$config['posts']     = 3;
						$config['columns']   = '';
						$config['in-column'] = TRUE;
						break;

					case 'style-15':
						$config['directory'] = 'loop';
						$config['file']      = 'listing-modern-grid-5';
						$config['show']      = TRUE;
						$config['posts']     = 5;
						$config['columns']   = '';
						$config['in-column'] = FALSE;
						break;

					case 'style-16':
						$config['directory'] = 'loop';
						$config['file']      = 'listing-modern-grid-5';
						$config['show']      = TRUE;
						$config['posts']     = 3;
						$config['columns']   = '';
						$config['in-column'] = TRUE;
						break;

					case 'style-17':
						$config['directory'] = 'loop';
						$config['file']      = 'listing-modern-grid-7';
						$config['show']      = TRUE;
						$config['posts']     = 5;
						$config['columns']   = '';
						$config['in-column'] = FALSE;
						break;

					case 'style-18':
						$config['directory'] = 'loop';
						$config['file']      = 'listing-modern-grid-7';
						$config['show']      = TRUE;
						$config['posts']     = 5;
						$config['columns']   = '';
						$config['in-column'] = TRUE;
						break;

					case 'style-19':
						$config['directory'] = 'loop';
						$config['file']      = 'listing-modern-grid-8';
						$config['show']      = TRUE;
						$config['posts']     = 5;
						$config['columns']   = '';
						$config['in-column'] = FALSE;
						break;

					case 'style-20':
						$config['directory'] = 'loop';
						$config['file']      = 'listing-modern-grid-9';
						$config['show']      = TRUE;
						$config['posts']     = 7;
						$config['columns']   = '';
						$config['in-column'] = FALSE;
						break;

					case 'style-21':
						$config['directory'] = 'loop';
						$config['file']      = 'listing-modern-grid-10';
						$config['show']      = TRUE;
						$config['posts']     = 6;
						$config['columns']   = '';
						$config['in-column'] = FALSE;
						break;

					default:
						$config['type']      = 'disable';
						$config['style']     = 'disable';
						$config['directory'] = '';
						$config['file']      = '';
						$config['show']      = FALSE;
						$config['posts']     = 0;

				}

				break;

			case 'rev_slider':

				//
				// Term type
				//
				if ( $args['type'] === 'term' ) {

					// get from current term
					if ( publisher_is_valid_tax() ) {
						$config['style'] = bf_get_term_meta( 'rev_slider_item', $args['term_id'], 'default' );
					}

					// Slider style
					if ( $config['style'] == 'default' || empty( $config['style'] ) ) {
						$config['style'] = publisher_get_option( 'cat_rev_slider_item' );
					}
				}
				//
				// Home type
				//
				elseif ( $args['type'] == 'home' ) {
					$config['style'] = publisher_get_option( 'home_rev_slider_item' );
				}


				// determine show
				if ( ! empty( $config['style'] ) && function_exists( 'putRevSlider' ) ) {
					$config['show'] = TRUE;
				}

				$config['in-column'] = FALSE;

				break;
		}

		// Save it to cache
		publisher_set_global( $args['type'] . '-slider-config', $config );

		return $config;

	} // publisher_main_slider_config

} // if


if ( ! function_exists( 'publisher_listing_social_share' ) ) {
	/**
	 * Prints listing share buttons
	 *
	 * @param array $args
	 */
	function publisher_listing_social_share( $args = array() ) {

		if ( ! isset( $args['type'] ) ) {
			$args['type'] = 'listing';
		}

		if ( ! isset( $args['class'] ) ) {
			$args['class'] = '';
		}

		if ( ! isset( $args['show_title'] ) ) {
			$args['show_title'] = FALSE;
		}

		if ( ! isset( $args['show_count'] ) ) {
			$args['show_count'] = FALSE;
		}

		if ( ! isset( $args['show_views'] ) ) {
			$args['show_views'] = FALSE;
		}

		if ( ! isset( $args['show_comments'] ) ) {
			$args['show_comments'] = FALSE;
		}

		$sites = publisher_get_option( 'social_share_sites' );

		if ( $args['type'] === 'single' && publisher_get_option( 'social_share_count' ) === 'total-and-site' ) {
			$site_share_count = TRUE;
		} else {
			$site_share_count = FALSE;
		}

		?>
		<div class="post-share <?php echo esc_attr( $args['class'] ); ?>">
			<?php


			if ( $args['type'] === 'single' && $args['show_comments'] && comments_open() ) {

				$title  = apply_filters( 'better-studio/theme/meta/comments/title', get_the_title() );
				$link   = apply_filters( 'better-studio/theme/meta/comments/link', get_comments_link() );
				$number = apply_filters( 'better-studio/theme/meta/comments/number', get_comments_number() );
				$text   = apply_filters( 'better-studio/themes/meta/comments/text', $number );

				printf( '<a href="%1$s" class="post-share-btn post-share-btn-comments comments" title="%2$s"><i class="fa fa-comments" aria-hidden="true"></i> <b class="number">%3$s</b></a>',
					esc_url( $link ),
					esc_attr( sprintf( publisher_translation_get( 'leave_comment_on' ), $title ) ),
					$text
				);

			}


			if ( $args['type'] === 'single' && $args['show_views'] && function_exists( 'The_Better_Views_Count' ) ) {

				$rank = publisher_get_ranking_icon( The_Better_Views_Count(), 'views_ranking', 'fa-eye', TRUE );

				if ( isset( $rank['show'] ) && $rank['show'] ) {
					The_Better_Views(
						TRUE,
						'<span class="views post-share-btn post-share-btn-views ' . $rank['id'] . '" data-bpv-post="' . get_the_ID() . '">' . $rank['icon'] . ' <b class="number">',
						'</b></span>',
						'show',
						'%VIEW_COUNT%'
					);
				}

			}


			if ( $args['type'] === 'single' ) {

			if ( $args['show_count'] ) {
				$count_labels = bf_social_shares_count( $sites );
			} else {
				$count_labels = array();
			}

			$total_count = array_sum( $count_labels );

			$rank = publisher_get_ranking_icon( $total_count, 'shares_ranking', 'fa-eye', TRUE );

			if ( empty( $rank['icon'] ) ) {
				$rank['icon'] = '<i class="fa fa-share-alt" aria-hidden="true"></i>';
			}

			if ( empty( $rank['id'] ) ) {
				$rank['id'] = 'rank-default';
			}

			?>
			<div class="share-handler-wrap">
				<span class="share-handler post-share-btn <?php echo $rank['id']; ?>">
					<?php

					echo $rank['icon'];

					if ( $total_count ) { ?>
						<b class="number"><?php echo bf_human_number_format( $total_count ) ?></b>
					<?php } else {
						?>
						<b class="text"><?php publisher_translation_echo( 'post_share' ); ?></b>
						<?php
					} ?>
				</span>
				<?php
				} elseif ( $args['type'] === 'listing' ) {
					//echo $label;
				}

				?>
				<ul class="social-share-list clearfix">
					<?php

					foreach ( (array) $sites as $site_key => $site ) {
						if ( $site ) {
							$count_label = $site_share_count && isset( $count_labels[ $site_key ] ) ? $count_labels[ $site_key ] : 0;
							echo publisher_shortcode_social_share_get_li( $site_key, $args['show_title'], $count_label );
						}
					}

					?>
				</ul>
				<?php

				if ( $args['type'] === 'single' ) {
				?></div><?php
		}
		?>
		</div>
		<?php

	} // publisher_listing_social_share
}


if ( ! function_exists( 'publisher_layout_option_list' ) ) {
	/**
	 * Panels layout field options
	 *
	 * @param bool $default
	 *
	 * @return array
	 */
	function publisher_layout_option_list( $default = FALSE ) {
		static $theme_version;

		if ( ! $theme_version ) {
			$theme = wp_get_theme();

			if ( $theme->get( 'Template' ) ) {
				$theme = wp_get_theme( $theme->get( 'Template' ) );
			}

			$theme_version = $theme->get( 'Version' );
		}

		$option = array();

		if ( $default ) {
			$option['default'] = array(
				'img'           => PUBLISHER_THEME_URI . 'images/options/layout-default.png?v=' . $theme_version,
				'label'         => __( 'Default', 'publisher' ),
				'current_label' => __( 'Default Layout', 'publisher' ),
			);
		}

		$option['1-col']   = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/layout-1-col.png?v=' . $theme_version,
			'label' => __( 'No Sidebar (1)', 'publisher' ),
			'info'  => array(
				'cat' => array(
					__( '1 Column', 'publisher' ),
				),
			),
		);
		$option['3-col-0'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/layout-3-col-0.png?v=' . $theme_version,
			'label' => __( 'No Sidebar (2)', 'publisher' ),
			'info'  => array(
				'cat' => array(
					__( '1 Column', 'publisher' ),
				),
			),
		);

		$option['2-col-right'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/layout-2-col-right.png?v=' . $theme_version,
			'label' => __( '2 Column (1)', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( '2 Column', 'publisher' ),
				),
			),
		);
		$option['2-col-left']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/layout-2-col-left.png?v=' . $theme_version,
			'label' => __( '2 Column (2)', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( '2 Column', 'publisher' ),
				),
			),
		);

		$option['3-col-1'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/layout-3-col-1.png?v=' . $theme_version,
			'label' => __( '3 Column (1)', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( '3 Column', 'publisher' ),
				),
			),
		);
		$option['3-col-2'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/layout-3-col-2.png?v=' . $theme_version,
			'label' => __( '3 Column (2)', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( '3 Column', 'publisher' ),
				),
			),
		);
		$option['3-col-3'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/layout-3-col-3.png?v=' . $theme_version,
			'label' => __( '3 Column (3)', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( '3 Column', 'publisher' ),
				),
			),
		);
		$option['3-col-4'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/layout-3-col-4.png?v=' . $theme_version,
			'label' => __( '3 Column (4)', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( '3 Column', 'publisher' ),
				),
			),
		);
		$option['3-col-5'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/layout-3-col-5.png?v=' . $theme_version,
			'label' => __( '3 Column (5)', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( '3 Column', 'publisher' ),
				),
			),
		);
		$option['3-col-6'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/layout-3-col-6.png?v=' . $theme_version,
			'label' => __( '3 Column (6)', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( '3 Column', 'publisher' ),
				),
			),
		);

		return $option;
	} // publisher_layout_option_list
} // if


if ( ! function_exists( 'publisher_is_valid_layout' ) ) {
	/**
	 * Check the parameter is theme valid layout or not!
	 *
	 * This is because of multiple theme that have same page_layout id for page layout
	 *
	 * @param $layout
	 *
	 * @return bool
	 */
	function publisher_is_valid_layout( $layout ) {

		$valid = array(
			'1-col'       => '',
			'2-col-left'  => '',
			'2-col-right' => '',
			'3-col-0'     => '',
			'3-col-1'     => '',
			'3-col-2'     => '',
			'3-col-3'     => '',
			'3-col-4'     => '',
			'3-col-5'     => '',
			'3-col-6'     => '',
		);

		return isset( $valid[ $layout ] );
	} // publisher_is_valid_layout
} // if


if ( ! function_exists( 'publisher_get_page_boxed_layout' ) ) {
	/**
	 * Used to get current page boxed layout
	 *
	 * @return bool|mixed|null|string|void
	 */
	function publisher_get_page_boxed_layout() {

		$layout = '';


		if ( publisher_is_valid_tax() ) {
			$layout = bf_get_term_meta( 'layout_style' );

			$bg_img = bf_get_term_meta( 'bg_image' );
			if ( ! empty( $bg_img['img'] ) ) {
				$layout = 'boxed';
			}
		}

		if ( empty( $layout ) || $layout == FALSE || $layout == 'default' ) {
			$layout = publisher_get_option( 'layout_style' );

			if ( $layout == 'full-width' ) {
				$bg_img = publisher_get_option( 'site_bg_image' );
				if ( ! empty( $bg_img['img'] ) ) {
					$layout = 'boxed';
				}
			}
		}

		return $layout;
	}
}


if ( ! function_exists( 'publisher_get_page_layout' ) ) {
	/**
	 * Used to get current page layout
	 *
	 * @return string
	 */
	function publisher_get_page_layout() {

		// Return from cache
		if ( publisher_get_global( 'page-layout' ) ) {
			return publisher_get_global( 'page-layout' );
		}

		$layout = 'default';

		// Homepage layout
		if ( is_home() ||
		     ( ( 'page' == get_option( 'show_on_front' ) ) && is_front_page() && bf_get_query_var_paged( 1 ) > 1 )
		) {
			$layout = publisher_get_option( 'home_layout' );
		} // Post, page and custom post types layout
		elseif ( publisher_is_valid_cpt() ) {

			$layout = bf_get_post_meta( 'page_layout' );

			if ( $layout == 'default' ) {
				if ( is_page() ) {
					$layout = publisher_get_option( 'page_layout' );
				} else {
					$layout = publisher_get_option( 'post_layout' );
				}
			}

		}  // Category Layout
		elseif ( publisher_is_valid_tax() ) {

			$layout = bf_get_term_meta( 'page_layout' );

			if ( $layout == 'default' ) {
				$layout = publisher_get_option( 'cat_layout' );
			}
		} // Tag Layout
		elseif ( publisher_is_valid_tax( 'tag' ) ) {

			$layout = bf_get_term_meta( 'page_layout' );

			if ( $layout == 'default' ) {
				$layout = publisher_get_option( 'tag_layout' );
			}
		} // Author Layout
		elseif ( is_author() ) {
			$layout = bf_get_user_meta( 'page_layout' );

			if ( $layout == 'default' ) {
				$layout = publisher_get_option( 'author_layout' );
			}
		} // Search Layout
		elseif ( is_search() ) {
			$layout = publisher_get_option( 'search_layout' );
		} // bbPress Layout
		elseif ( is_post_type_archive( 'forum' ) || is_singular( 'forum' ) || is_singular( 'topic' ) ) {
			$layout = publisher_get_option( 'bbpress_layout' );
		} // Attachments
		elseif ( is_attachment() ) {
			$layout = publisher_get_option( 'attachment_layout' );
		} // WooCommerce
		elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {

			if ( is_shop() ) {
				$layout = bf_get_post_meta( 'page_layout', wc_get_page_id( 'shop' ) );
			} elseif ( is_product() ) {
				$layout = bf_get_post_meta( 'page_layout', get_the_ID() );
			} elseif ( is_cart() ) {
				$layout = bf_get_post_meta( 'page_layout', wc_get_page_id( 'cart' ) );
			} elseif ( is_checkout() ) {
				$layout = bf_get_post_meta( 'page_layout', wc_get_page_id( 'checkout' ) );
			} elseif ( is_account_page() ) {
				$layout = bf_get_post_meta( 'page_layout', wc_get_page_id( 'myaccount' ) );
			} elseif ( is_product_category() || is_product_tag() ) {
				$layout = bf_get_term_meta( 'page_layout', get_queried_object()->term_id );
			}

			if ( $layout == 'default' ) {
				$layout = publisher_get_option( 'shop_layout' );
			}

		}

		// Return default
		if ( $layout == 'default' || ! publisher_is_valid_layout( $layout ) ) {
			$layout = publisher_get_option( 'general_layout' );
		}

		// Cache
		publisher_set_global( 'page-layout', $layout );

		return $layout;

	} // publisher_get_page_layout
}// if


if ( ! function_exists( 'publisher_get_page_layout_file' ) ) {
	/**
	 * Used to get current page layout file
	 *
	 * @return string
	 */
	function publisher_get_page_layout_file() {

		static $layout_file;

		if ( $layout_file ) {
			return $layout_file;
		}

		$layout_file = publisher_get_page_layout();
		$layout_file = $layout_file[0];

		if ( $layout_file === '2' ) {
			$layout_file = '2-col';
		} elseif ( $layout_file === '1' ) {
			$layout_file = '1-col';
		} elseif ( $layout_file === '3' ) {
			$layout_file = '3-col';
		} else {
			$layout_file = '2-col';
		}

		return $layout_file;

	} // publisher_get_page_layout
}// if


if ( ! function_exists( 'publisher_get_page_layout_setting' ) ) {
	/**
	 * Used to get current page layout columns setting
	 *
	 * @return array
	 */
	function publisher_get_page_layout_setting() {

		static $layout;

		if ( $layout ) {
			return $layout;
		}

		$layout['layout']    = publisher_get_page_layout();
		$layout['container'] = '';
		$layout['columns']   = array();

		switch ( $layout['layout'][0] ) {

			//
			// 2 Column layouts
			//
			case '2':

				if ( $layout['layout'] === '2-col-right' ) {
					$layout['container'] = 'layout-2-col layout-2-col-1 layout-right-sidebar';
					$layout['columns']   = array(
						array(
							'id'    => 'content',
							'class' => 'col-sm-8 content-column',
						),
						array(
							'id'    => 'primary',
							'class' => 'col-sm-4 sidebar-column sidebar-column-primary',
						),
					);
				} else {
					$layout['container'] = 'layout-2-col layout-2-col-2 layout-left-sidebar';
					$layout['columns']   = array(
						array(
							'id'    => 'content',
							'class' => 'col-sm-8 col-sm-push-4 content-column',
						),
						array(
							'id'    => 'primary',
							'class' => 'col-sm-4 col-sm-pull-8 sidebar-column sidebar-column-primary',
						),
					);
				}

				break;

			//
			// 3 Column layouts
			//
			case '3':

				$layout['container'] = 'layout-3-col layout-' . $layout['layout'];

				if ( $layout['layout'][6] == 0 ) {
					$layout['columns'] = array(
						array(
							'id'    => 'content',
							'class' => 'col-sm-12 content-column',
						),
					);
				} else {
					$layout['columns'] = array(
						array(
							'id'    => 'content',
							'class' => 'col-sm-7 content-column',
						),
						array(
							'id'    => 'primary',
							'class' => 'col-sm-3 sidebar-column sidebar-column-primary',
						),
						array(
							'id'    => 'secondary',
							'class' => 'col-sm-2 sidebar-column sidebar-column-secondary',
						),
					);
				}

				break;

			//
			// 1 Column layouts
			//
			case '1':
				$layout['container'] = 'layout-1-col layout-no-sidebar';
				$layout['columns']   = array(
					array(
						'id'    => 'content',
						'class' => 'col-sm-12 content-column',
					),
				);
				break;

		}

		return $layout;

	} // publisher_get_page_layout
}// if


if ( ! function_exists( 'publisher_listing_option_list' ) ) {
	/**
	 * Panels posts listing field option
	 *
	 * @param bool $default
	 *
	 * @return array
	 */
	function publisher_listing_option_list( $default = FALSE ) {
		static $theme_version;

		if ( ! $theme_version ) {
			$theme = wp_get_theme();

			if ( $theme->get( 'Template' ) ) {
				$theme = wp_get_theme( $theme->get( 'Template' ) );
			}

			$theme_version = $theme->get( 'Version' );
		}

		$option = array();

		if ( $default ) {
			$option['default'] = array(
				'img'           => PUBLISHER_THEME_URI . 'images/options/listing-default.png?v=' . $theme_version,
				'label'         => __( 'Default', 'publisher' ),
				'current_label' => __( 'Default Listing', 'publisher' ),
			);
		}

		$option['grid-1']    = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-grid-1.png?v=' . $theme_version,
			'label'         => __( 'Grid 1', 'publisher' ),
			'current_label' => __( 'Grid Listing 1', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Grid Listing', 'publisher' ),
				),
			),
		);
		$option['grid-1-3']  = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-grid-1-3.png?v=' . $theme_version,
			'label'         => __( 'Grid 1', 'publisher' ),
			'current_label' => __( 'Grid Listing 1 (3 column)', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Grid Listing', 'publisher' ),
				),
			),
			'badges'        => array(
				'3 Column',
			),
		);
		$option['grid-2']    = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-grid-2.png?v=' . $theme_version,
			'label'         => __( 'Grid 2', 'publisher' ),
			'current_label' => __( 'Grid Listing 2', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Grid Listing', 'publisher' ),
				),
			),
		);
		$option['grid-2-3']  = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-grid-2-3.png?v=' . $theme_version,
			'label'         => __( 'Grid 2', 'publisher' ),
			'current_label' => __( 'Grid Listing 2 (3 column)', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Grid Listing', 'publisher' ),
				),
			),
			'badges'        => array(
				'3 Column',
			),
		);
		$option['blog-1']    = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-blog-1.png?v=' . $theme_version,
			'label'         => __( 'Blog 1', 'publisher' ),
			'current_label' => __( 'Blog Listing 1', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Blog Listing', 'publisher' ),
				),
			),
		);
		$option['blog-2']    = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-blog-2.png?v=' . $theme_version,
			'label'         => __( 'Blog 2', 'publisher' ),
			'current_label' => __( 'Blog Listing 2', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Blog Listing', 'publisher' ),
				),
			),
		);
		$option['blog-3']    = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-blog-3.png?v=' . $theme_version,
			'label'         => __( 'Blog 3', 'publisher' ),
			'current_label' => __( 'Blog Listing 3', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Blog Listing', 'publisher' ),
				),
			),
		);
		$option['blog-4']    = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-blog-4.png?v=' . $theme_version,
			'label'         => __( 'Blog 4', 'publisher' ),
			'current_label' => __( 'Blog Listing 4', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Blog Listing', 'publisher' ),
				),
			),
		);
		$option['blog-5']    = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-blog-5.png?v=' . $theme_version,
			'label'         => __( 'Blog 5', 'publisher' ),
			'current_label' => __( 'Blog Listing 5', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Blog Listing', 'publisher' ),
				),
			),
		);
		$option['classic-1'] = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-classic-1.png?v=' . $theme_version,
			'label'         => __( 'Classic 1', 'publisher' ),
			'current_label' => __( 'Classic Listing 1', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Classic Listing', 'publisher' ),
				),
			),
		);
		$option['classic-2'] = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-classic-2.png?v=' . $theme_version,
			'label'         => __( 'Classic 2', 'publisher' ),
			'current_label' => __( 'Classic Listing 2', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Classic Listing', 'publisher' ),
				),
			),
		);
		$option['classic-3'] = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-classic-3.png?v=' . $theme_version,
			'label'         => __( 'Classic 3', 'publisher' ),
			'current_label' => __( 'Classic Listing 3', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Classic Listing', 'publisher' ),
				),
			),
		);
		$option['tall-1']    = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-tall-1.png?v=' . $theme_version,
			'label'         => __( 'Tall 1', 'publisher' ),
			'current_label' => __( 'Tall Listing 1', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Tall Listing', 'publisher' ),
				),
			),
		);
		$option['tall-1-4']  = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-tall-1-4.png?v=' . $theme_version,
			'label'         => __( 'Tall 1', 'publisher' ),
			'current_label' => __( 'Tall Listing 1 (4 column)', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Tall Listing', 'publisher' ),
				),
			),
			'badges'        => array(
				'4 Column',
			),
		);
		$option['tall-2']    = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-tall-2.png?v=' . $theme_version,
			'label'         => __( 'Tall 2', 'publisher' ),
			'current_label' => __( 'Tall Listing 2', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Tall Listing', 'publisher' ),
				),
			),
		);
		$option['tall-2-4']  = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-tall-2-4.png?v=' . $theme_version,
			'label'         => __( 'Tall 2', 'publisher' ),
			'current_label' => __( 'Tall Listing 2 (4 column)', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Tall Listing', 'publisher' ),
				),
			),
			'badges'        => array(
				'4 Column',
			),
		);
		$option['mix-4-1']   = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-mix-4-1.png?v=' . $theme_version,
			'label'         => __( 'Mix 11', 'publisher' ),
			'current_label' => __( 'Mix Listing 11', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Tall Listing', 'publisher' ),
				),
			),
		);
		$option['mix-4-2']   = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-mix-4-2.png?v=' . $theme_version,
			'label'         => __( 'Mix 12', 'publisher' ),
			'current_label' => __( 'Mix Listing 12', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Mix Listing', 'publisher' ),
				),
			),
		);
		$option['mix-4-3']   = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-mix-4-3.png?v=' . $theme_version,
			'label'         => __( 'Mix 13', 'publisher' ),
			'current_label' => __( 'Mix Listing 13', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Mix Listing', 'publisher' ),
				),
			),
		);
		$option['mix-4-4']   = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-mix-4-4.png?v=' . $theme_version,
			'label'         => __( 'Mix 14', 'publisher' ),
			'current_label' => __( 'Mix Listing 14', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Mix Listing', 'publisher' ),
				),
			),
		);
		$option['mix-4-5']   = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-mix-4-5.png?v=' . $theme_version,
			'label'         => __( 'Mix 15', 'publisher' ),
			'current_label' => __( 'Mix Listing 15', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Mix Listing', 'publisher' ),
				),
			),
		);
		$option['mix-4-6']   = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-mix-4-6.png?v=' . $theme_version,
			'label'         => __( 'Mix 16', 'publisher' ),
			'current_label' => __( 'Mix Listing 16', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Mix Listing', 'publisher' ),
				),
			),
		);
		$option['mix-4-7']   = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-mix-4-7.png?v=' . $theme_version,
			'label'         => __( 'Mix 17', 'publisher' ),
			'current_label' => __( 'Mix Listing 17', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Mix Listing', 'publisher' ),
				),
			),
		);
		$option['mix-4-8']   = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-mix-4-8.png?v=' . $theme_version,
			'label'         => __( 'Mix 18', 'publisher' ),
			'current_label' => __( 'Mix Listing 18', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Mix Listing', 'publisher' ),
				),
			),
		);
		$option['text-1-2']  = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-text-1-2.png?v=' . $theme_version,
			'label'         => __( 'Text 1', 'publisher' ),
			'current_label' => __( 'Text Listing 1 (2 column)', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Text Listing', 'publisher' ),
				),
			),
			'badges'        => array(
				'2 Column',
				'NEW',
			),
		);
		$option['text-1-3']  = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-text-1-3.png?v=' . $theme_version,
			'label'         => __( 'Text 1', 'publisher' ),
			'current_label' => __( 'Text Listing 1 (3 column)', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Text Listing', 'publisher' ),
				),
			),
			'badges'        => array(
				'3 Column',
				'NEW',
			),
		);
		$option['text-2-2']  = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-text-2-2.png?v=' . $theme_version,
			'label'         => __( 'Text 2', 'publisher' ),
			'current_label' => __( 'Text Listing 2 (2 column)', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Text Listing', 'publisher' ),
				),
			),
			'badges'        => array(
				'2 Column',
				'NEW',
			),
		);
		$option['text-2-3']  = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-text-2-3.png?v=' . $theme_version,
			'label'         => __( 'Text 2', 'publisher' ),
			'current_label' => __( 'Text Listing 2 (3 column)', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Text Listing', 'publisher' ),
				),
			),
			'badges'        => array(
				'3 Column',
				'NEW',
			),
		);
		$option['text-3']    = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-text-3.png?v=' . $theme_version,
			'label'         => __( 'Text 3', 'publisher' ),
			'current_label' => __( 'Text Listing 3 (1 column)', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Text Listing', 'publisher' ),
				),
			),
			'badges'        => array(
				'1 Column',
				'NEW',
			),
		);
		$option['text-3-2']  = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-text-3-2.png?v=' . $theme_version,
			'label'         => __( 'Text 3', 'publisher' ),
			'current_label' => __( 'Text Listing 3 (2 column)', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Text Listing', 'publisher' ),
				),
			),
			'badges'        => array(
				'2 Column',
				'NEW',
			),
		);
		$option['text-3-3']  = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-text-3-3.png?v=' . $theme_version,
			'label'         => __( 'Text 3', 'publisher' ),
			'current_label' => __( 'Text Listing 3 (3 column)', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Text Listing', 'publisher' ),
				),
			),
			'badges'        => array(
				'3 Column',
				'NEW',
			),
		);
		$option['text-4']    = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-text-4.png?v=' . $theme_version,
			'label'         => __( 'Text 4', 'publisher' ),
			'current_label' => __( 'Text Listing 4 (1 column)', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Text Listing', 'publisher' ),
				),
			),
			'badges'        => array(
				'1 Column',
				'NEW',
			),
		);
		$option['text-4-2']  = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-text-4-2.png?v=' . $theme_version,
			'label'         => __( 'Text 4', 'publisher' ),
			'current_label' => __( 'Text Listing 4 (2 column)', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Text Listing', 'publisher' ),
				),
			),
			'badges'        => array(
				'2 Column',
				'NEW',
			),
		);
		$option['text-4-3']  = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/listing-text-4-3.png?v=' . $theme_version,
			'label'         => __( 'Text 4', 'publisher' ),
			'current_label' => __( 'Text Listing 4 (3 column)', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Text Listing', 'publisher' ),
				),
			),
			'badges'        => array(
				'3 Column',
				'NEW',
			),
		);

		return $option;
	} // publisher_listing_option_list
} // if


if ( ! function_exists( 'publisher_is_valid_listing' ) ) {
	/**
	 * Checks parameter to be a theme valid listing
	 *
	 * @param $listing
	 *
	 * @return bool
	 */
	function publisher_is_valid_listing( $listing ) {
		return array_key_exists( $listing, publisher_listing_option_list() );
	} // publisher_is_valid_listing

} // if


if ( ! function_exists( 'publisher_get_page_listing' ) ) {
	/**
	 * Used to get current page posts listing
	 *
	 * @param WP_Query|null $wp_query
	 *
	 * @return mixed|string
	 */
	function publisher_get_page_listing( $wp_query = NULL ) {

		if ( is_null( $wp_query ) ) {
			$wp_query = publisher_get_query();
		}

		// Return from cache
		if ( publisher_get_global( 'page-listing' ) ) {
			return publisher_get_global( 'page-listing' );
		}

		$listing = 'default';

		// Homepage listing
		if ( $wp_query->is_home ) {
			$listing = publisher_get_option( 'home_listing' );
		} // Category Layout
		elseif ( $wp_query->get_queried_object_id() > 0 && publisher_is_valid_tax( 'category', $wp_query->get_queried_object() ) ) {

			$listing = bf_get_term_meta( 'page_listing', $wp_query->get_queried_object_id() );

			if ( $listing == 'default' ) {
				$listing = publisher_get_option( 'cat_listing' );
			}
		} // Tag Layout
		elseif ( $wp_query->get_queried_object_id() > 0 && publisher_is_valid_tax( 'tag', $wp_query->get_queried_object() ) ) {
			$listing = bf_get_term_meta( 'page_listing', $wp_query->get_queried_object_id() );

			if ( $listing == 'default' ) {
				$listing = publisher_get_option( 'tag_listing' );
			}
		} // Author Layout
		elseif ( $wp_query->is_author ) {

			if ( $user = bf_get_author_archive_user() ) {
				$listing = bf_get_user_meta( 'page_listing', $user->ID );
			}

			if ( $listing == 'default' ) {
				$listing = publisher_get_option( 'author_listing' );
			}
		} // Search Layout
		elseif ( $wp_query->is_search ) {
			$listing = publisher_get_option( 'search_listing' );
		}

		// check to be valid theme listing or use default
		if ( $listing == 'default' || ! publisher_is_valid_listing( $listing ) ) {
			$listing = publisher_get_option( 'general_listing' );
		}

		switch ( $listing ) {

			case 'grid-1';
				publisher_set_prop( 'listing-class', 'columns-2' );
				break;

			case 'grid-1-3';
				publisher_set_prop( 'listing-class', 'columns-3' );
				$listing = 'grid-1';
				break;

			case 'grid-2';
				publisher_set_prop( 'listing-class', 'columns-2' );
				break;

			case 'grid-2-3';
				publisher_set_prop( 'listing-class', 'columns-3' );
				$listing = 'grid-2';
				break;

			case 'tall-1';
				publisher_set_prop( 'listing-class', 'columns-3' );
				break;

			case 'tall-1-4';
				publisher_set_prop( 'listing-class', 'columns-4' );
				$listing = 'tall-1';
				break;

			case 'tall-2';
				publisher_set_prop( 'listing-class', 'columns-3' );
				break;

			case 'tall-2-4';
				publisher_set_prop( 'listing-class', 'columns-4' );
				$listing = 'tall-2';
				break;

			case 'text-1-2';
				publisher_set_prop( 'listing-class', 'columns-2' );
				$listing = 'text-1';
				break;

			case 'text-1-3';
				publisher_set_prop( 'listing-class', 'columns-3' );
				$listing = 'text-1';
				break;

			case 'text-2-2';
				publisher_set_prop( 'listing-class', 'columns-2' );
				$listing = 'text-2';
				break;

			case 'text-2-3';
				publisher_set_prop( 'listing-class', 'columns-3' );
				$listing = 'text-2';
				break;

			case 'text-3-2';
				publisher_set_prop( 'listing-class', 'columns-2' );
				$listing = 'text-3';
				break;

			case 'text-3-3';
				publisher_set_prop( 'listing-class', 'columns-3' );
				$listing = 'text-3';
				break;

			case 'text-4-2';
				publisher_set_prop( 'listing-class', 'columns-2' );
				$listing = 'text-4';
				break;

			case 'text-4-3';
				publisher_set_prop( 'listing-class', 'columns-3' );
				$listing = 'text-4';
				break;

		}


		// Cache
		publisher_set_global( 'page-listing', 'listing-' . $listing );

		return 'listing-' . $listing;

	} // publisher_get_page_listing
} // if


if ( ! function_exists( 'publisher_get_show_page_listing_excerpt' ) ) {
	/**
	 * Used to get  show excerpt of current page posts listing
	 *
	 * @param WP_Query|null $wp_query
	 *
	 * @return mixed|string
	 */
	function publisher_get_show_page_listing_excerpt( $wp_query = NULL ) {

		if ( is_null( $wp_query ) ) {
			$wp_query = publisher_get_query();
		}

		// Return from cache
		if ( publisher_get_global( 'page-listing-excerpt' ) ) {
			return publisher_get_global( 'page-listing-excerpt' );
		}

		$excerpt = 'default';

		// Homepage listing
		if ( $wp_query->is_home ) {
			$excerpt = publisher_get_option( 'home_listing_excerpt' );
		} // Category Layout
		elseif ( $wp_query->get_queried_object_id() > 0 && publisher_is_valid_tax( 'category', $wp_query->get_queried_object() ) ) {

			$excerpt = bf_get_term_meta( 'page_listing_excerpt', $wp_query->get_queried_object_id() );

			if ( $excerpt == 'default' ) {
				$excerpt = publisher_get_option( 'cat_listing_excerpt' );
			}
		} // Tag Layout
		elseif ( $wp_query->get_queried_object_id() > 0 && publisher_is_valid_tax( 'tag', $wp_query->get_queried_object() ) ) {
			$excerpt = bf_get_term_meta( 'page_listing_excerpt', $wp_query->get_queried_object_id() );

			if ( $excerpt == 'default' ) {
				$excerpt = publisher_get_option( 'tag_listing_excerpt' );
			}
		} // Author Layout
		elseif ( $wp_query->is_author ) {
			if ( $user = bf_get_author_archive_user() ) {
				$excerpt = bf_get_user_meta( 'page_listing_excerpt', $user->ID );
			}

			if ( $excerpt == 'default' ) {
				$excerpt = publisher_get_option( 'author_listing_excerpt' );
			}
		} // Search Layout
		elseif ( $wp_query->is_search ) {
			$excerpt = publisher_get_option( 'search_listing_excerpt' );
		}

		// check to be valid theme listing or use default
		if ( $excerpt == 'default' || is_null( $excerpt ) ) {
			$excerpt = publisher_get_option( 'general_listing_excerpt' );
		}

		if ( $excerpt === 'hide' ) {
			$excerpt = FALSE;
		} else {
			$excerpt = TRUE;
		}

		// Cache
		publisher_set_global( 'page-listing-excerpt', $excerpt );

		return $excerpt;

	} // publisher_get_page_listing
} // if


if ( ! function_exists( 'publisher_pagination_option_list' ) ) {
	/**
	 * Panels archives pagination field options
	 *
	 * @param bool $default
	 *
	 * @return array
	 */
	function publisher_pagination_option_list( $default = FALSE ) {

		$option = array();

		if ( $default ) {
			$option['default'] = __( '-- Default pagination --', 'publisher' );
		}

		// simple paginations
		$option['numbered'] = __( 'Numbered pagination buttons', 'publisher' );
		$option['links']    = __( 'Newer & Older buttons', 'publisher' );

		// advanced ajax pagination
		$option['ajax_next_prev']         = __( 'Ajax - Next Prev buttons', 'publisher' );
		$option['ajax_more_btn']          = __( 'Ajax - Load more button', 'publisher' );
		$option['ajax_more_btn_infinity'] = __( 'Ajax - Load more button + Infinity loading', 'publisher' );
		$option['ajax_infinity']          = __( 'Ajax - Infinity loading', 'publisher' );

		return $option;

	} // publisher_pagination_option_list
} // if


if ( ! function_exists( 'publisher_is_valid_pagination' ) ) {
	/**
	 * Checks parameter to be a theme valid pagination
	 *
	 * @param $pagination
	 *
	 * @return bool
	 */
	function publisher_is_valid_pagination( $pagination ) {
		return array_key_exists( $pagination, publisher_pagination_option_list() );
	} // publisher_is_valid_pagination
} // if


if ( ! function_exists( 'publisher_get_pagination_style' ) ) {
	/**
	 * Used to get current page pagination style
	 */
	function publisher_get_pagination_style() {

		// Return from cache
		if ( publisher_get_global( 'page-pagination' ) ) {
			return publisher_get_global( 'page-pagination' );
		}

		$pagination = 'default';

		$paged = bf_get_query_var_paged();

		// Homepage pagination
		if ( is_home() || ( ( 'page' == get_option( 'show_on_front' ) ) && is_front_page() && bf_get_query_var_paged( 1 ) > 1 ) ) {
			$pagination = publisher_get_option( 'home_pagination_type' );
		} // Categories pagination
		elseif ( publisher_is_valid_tax() ) {

			$pagination = bf_get_term_meta( 'term_pagination_type' );

			if ( $pagination == 'default' ) {
				$pagination = publisher_get_option( 'cat_pagination_type' );
			}

		} // Tags pagination
		elseif ( publisher_is_valid_tax( 'tag' ) ) {

			$pagination = bf_get_term_meta( 'term_pagination_type' );

			if ( $pagination == 'default' ) {
				$pagination = publisher_get_option( 'tag_pagination_type' );
			}

		} // Author pagination
		elseif ( is_author() ) {
			$pagination = bf_get_user_meta( 'author_pagination_type' );

			if ( $pagination == 'default' ) {
				$pagination = publisher_get_option( 'author_pagination_type' );
			}
		} // Search page pagination
		elseif ( is_search() ) {
			$pagination = publisher_get_option( 'search_pagination_type' );
		}

		// fix for when request is from robots,
		// e.g. user agent: 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)'
		// fix for when paged and is ajax pagination then it should show simple numbered pagination
		$ajax_pagins = array(
			'ajax_infinity'          => '',
			'ajax_more_btn'          => '',
			'ajax_next_prev'         => '',
			'ajax_more_btn_infinity' => '',
		);

		if (
			( $paged > 1 && isset( $ajax_pagins[ $pagination ] ) ) ||
			( bf_is_crawler() && isset( $ajax_pagins[ $pagination ] ) )
		) {
			$pagination = 'numbered';
		}

		unset( $ajax_pagins ); // clear memory

		// get default pagination
		if ( $pagination == 'default' ) {
			$pagination = publisher_get_option( 'pagination_type' );
		}

		// check to be valid theme pagination
		if ( ! publisher_is_valid_pagination( $pagination ) ) {
			$pagination = key( publisher_pagination_option_list() );
		}

		// Cache
		publisher_set_global( 'page-pagination', $pagination );

		return $pagination;

	} // publisher_get_pagination_style
}


if ( ! function_exists( 'publisher_header_style_option_list' ) ) {
	/**
	 * Panels header style field options
	 *
	 * @param bool $default
	 *
	 * @param bool $disable
	 *
	 * @return array
	 */
	function publisher_header_style_option_list( $default = FALSE, $disable = TRUE ) {
		static $theme_version;

		if ( ! $theme_version ) {
			$theme = wp_get_theme();

			if ( $theme->get( 'Template' ) ) {
				$theme = wp_get_theme( $theme->get( 'Template' ) );
			}

			$theme_version = $theme->get( 'Version' );
		}

		$option = array();

		if ( $default ) {
			$option['default'] = array(
				'img'   => PUBLISHER_THEME_URI . 'images/options/header-default.png?v=' . $theme_version,
				'label' => __( '-- Default --', 'publisher' ),
			);
		}

		$option['style-1'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/header-style-1.png?v=' . $theme_version,
			'label' => __( 'Style 1', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
		);
		$option['style-2'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/header-style-2.png?v=' . $theme_version,
			'label' => __( 'Style 2', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
		);
		$option['style-3'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/header-style-3.png?v=' . $theme_version,
			'label' => __( 'Style 3', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
		);
		$option['style-4'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/header-style-4.png?v=' . $theme_version,
			'label' => __( 'Style 4', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
		);
		$option['style-5'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/header-style-5.png?v=' . $theme_version,
			'label' => __( 'Style 5', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
		);
		$option['style-6'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/header-style-6.png?v=' . $theme_version,
			'label' => __( 'Style 6', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
		);
		$option['style-7'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/header-style-7.png?v=' . $theme_version,
			'label' => __( 'Style 7', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
		);
		$option['style-8'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/header-style-8.png?v=' . $theme_version,
			'label' => __( 'Style 8', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
		);

		if ( $disable ) {
			$option['disable'] = array(
				'img'   => PUBLISHER_THEME_URI . 'images/options/header-disable.png?v=' . $theme_version,
				'label' => __( 'No Header', 'publisher' ),
				'class' => 'bf-flip-img-rtl',
			);
		}

		$option = apply_filters( 'publisher/headers/list', $option, $default, $disable );

		return $option;
	} // publisher_header_style_option_list
} // if


if ( ! function_exists( 'publisher_footer_style_option_list' ) ) {
	/**
	 * Panels footer style field options
	 *
	 * @param bool $default
	 *
	 * @return array
	 */
	function publisher_footer_style_option_list( $default = FALSE, $disable = TRUE ) {
		static $theme_version;

		if ( ! $theme_version ) {
			$theme = wp_get_theme();

			if ( $theme->get( 'Template' ) ) {
				$theme = wp_get_theme( $theme->get( 'Template' ) );
			}

			$theme_version = $theme->get( 'Version' );
		}

		$option = array();

		if ( $default ) {
			$option['default'] = array(
				'img'   => PUBLISHER_THEME_URI . 'images/options/footer-default.png?v=' . $theme_version,
				'label' => __( '-- Default --', 'publisher' ),
			);
		}

		if ( $disable ) {
			$option['disable'] = array(
				'img'   => PUBLISHER_THEME_URI . 'images/options/footer-disable.png?v=' . $theme_version,
				'label' => __( 'No Footer', 'publisher' ),
			);
		}

		return $option;
	} // publisher_footer_style_option_list
} // if


if ( ! function_exists( 'publisher_get_footer_style' ) ) {
	/**
	 * Used to get current page footer style
	 *
	 * @return string
	 */
	function publisher_get_footer_style() {

		static $style;

		if ( $style ) {
			return $style;
		}

		$style = 'show';

		if ( publisher_is_valid_cpt() ) {
			$style = bf_get_post_meta( 'footer_style' );
		} // WooCommerce
		elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {

			if ( is_shop() ) {
				$style = bf_get_post_meta( 'footer_style', wc_get_page_id( 'shop' ) );
			} elseif ( is_product() ) {
				$style = bf_get_post_meta( 'footer_style', get_the_ID() );
			} elseif ( is_cart() ) {
				$style = bf_get_post_meta( 'footer_style', wc_get_page_id( 'cart' ) );
			} elseif ( is_checkout() ) {
				$style = bf_get_post_meta( 'footer_style', wc_get_page_id( 'checkout' ) );
			} elseif ( is_account_page() ) {
				$style = bf_get_post_meta( 'footer_style', wc_get_page_id( 'myaccount' ) );
			} elseif ( is_product_category() || is_product_tag() ) {
				$style = bf_get_term_meta( 'footer_style', get_queried_object()->term_id );
			}
		}

		if ( $style === 'default' ) {
			$style = 'show';
		}

		return $style;

	} // publisher_get_footer_style
} // if


if ( ! function_exists( 'publisher_topposts_option_list' ) ) {
	/**
	 * Panels category toposts field options
	 *
	 * @param bool $default
	 *
	 * @return array
	 */
	function publisher_topposts_option_list( $default = FALSE ) {
		static $theme_version;

		if ( ! $theme_version ) {
			$theme = wp_get_theme();

			if ( $theme->get( 'Template' ) ) {
				$theme = wp_get_theme( $theme->get( 'Template' ) );
			}

			$theme_version = $theme->get( 'Version' );
		}

		$option = array();

		if ( $default ) {
			$option['default'] = array(
				'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-default.png?v=' . $theme_version,
				'label' => __( 'Default', 'publisher' ),
			);
		}

		$option['style-1']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-1.png?v=' . $theme_version,
			'label' => __( 'Style 1', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Large', 'publisher' ),
				),
			),
		);
		$option['style-2']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-2.png?v=' . $theme_version,
			'label' => __( 'Style 2', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Small', 'publisher' ),
				),
			),
		);
		$option['style-3']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-3.png?v=' . $theme_version,
			'label' => __( 'Style 3', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Large', 'publisher' ),
				),
			),
		);
		$option['style-4']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-4.png?v=' . $theme_version,
			'label' => __( 'Style 4', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Small', 'publisher' ),
				),
			),
		);
		$option['style-5']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-5.png?v=' . $theme_version,
			'label' => __( 'Style 5', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Large', 'publisher' ),
				),
			),
		);
		$option['style-6']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-6.png?v=' . $theme_version,
			'label' => __( 'Style 6', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Small', 'publisher' ),
				),
			),
		);
		$option['style-7']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-7.png?v=' . $theme_version,
			'label' => __( 'Style 7', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Large', 'publisher' ),
				),
			),
		);
		$option['style-8']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-8.png?v=' . $theme_version,
			'label' => __( 'Style 8', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Small', 'publisher' ),
				),
			),
		);
		$option['style-9']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-9.png?v=' . $theme_version,
			'label' => __( 'Style 9', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Large', 'publisher' ),
				),
			),
		);
		$option['style-10'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-10.png?v=' . $theme_version,
			'label' => __( 'Style 10', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Small', 'publisher' ),
				),
			),
		);
		$option['style-11'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-11.png?v=' . $theme_version,
			'label' => __( 'Style 11', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Large', 'publisher' ),
				),
			),
		);
		$option['style-12'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-12.png?v=' . $theme_version,
			'label' => __( 'Style 12', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Small', 'publisher' ),
				),
			),
		);
		$option['style-13'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-13.png?v=' . $theme_version,
			'label' => __( 'Style 13', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Large', 'publisher' ),
				),
			),
		);
		$option['style-14'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-14.png?v=' . $theme_version,
			'label' => __( 'Style 14', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Small', 'publisher' ),
				),
			),
		);
		$option['style-15'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-15.png?v=' . $theme_version,
			'label' => __( 'Style 15', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Large', 'publisher' ),
				),
			),
		);
		$option['style-16'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-16.png?v=' . $theme_version,
			'label' => __( 'Style 16', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Small', 'publisher' ),
				),
			),
		);
		$option['style-17'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-17.png?v=' . $theme_version,
			'label' => __( 'Style 17', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Large', 'publisher' ),
				),
			),
		);
		$option['style-18'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-18.png?v=' . $theme_version,
			'label' => __( 'Style 18', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Small', 'publisher' ),
				),
			),
		);
		$option['style-19'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-19.png?v=' . $theme_version,
			'label' => __( 'Style 19', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Large', 'publisher' ),
				),
			),
		);
		$option['style-20'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-20.png?v=' . $theme_version,
			'label' => __( 'Style 20', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Large', 'publisher' ),
				),
			),
		);
		$option['style-21'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/cat-slider-style-21.png?v=' . $theme_version,
			'label' => __( 'Style 21', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Large', 'publisher' ),
				),
			),
		);

		return $option;
	} // publisher_topposts_option_list
} // if


if ( ! function_exists( 'publisher_is_valid_topposts_style' ) ) {
	/**
	 * Check the parameter is theme valid topposts style
	 *
	 * @param $layout
	 *
	 * @return bool
	 */
	function publisher_is_valid_topposts_style( $layout ) {
		return array_key_exists( $layout, publisher_topposts_option_list() );
	} // publisher_is_valid_topposts_style
} // if


if ( ! function_exists( 'publisher_slider_types_option_list' ) ) {
	/**
	 * Panels category slider field options
	 *
	 * @param bool $default
	 *
	 * @return array
	 */
	function publisher_slider_types_option_list( $default = FALSE ) {

		$option = array();

		if ( $default ) {
			$option['default'] = __( '-- Default --', 'publisher' );
		}

		$option['disable']       = __( 'Disabled', 'publisher' );
		$option['custom-blocks'] = __( 'Top posts', 'publisher' );
		$option['rev_slider']    = __( 'Slider Revolution', 'publisher' );

		return $option;
	} // publisher_slider_types_option_list
} // if


if ( ! function_exists( 'publisher_is_valid_slider_type' ) ) {
	/**
	 * Check the parameter is theme valid slider type
	 *
	 * @param $layout
	 *
	 * @return bool
	 */
	function publisher_is_valid_slider_type( $layout ) {
		return ( is_string( $layout ) || is_int( $layout ) ) &&
		       array_key_exists( $layout, publisher_slider_types_option_list() );
	} // publisher_is_valid_slider_type
} // if


if ( ! function_exists( 'publisher_get_header_style' ) ) {
	/**
	 * Used to get current page header style
	 *
	 * @return bool|mixed|null|string
	 */
	function publisher_get_header_style() {

		static $style;

		if ( $style ) {
			return $style;
		}

		$style = 'default';

		if ( publisher_is_valid_tax( 'category' ) ) {
			$style = bf_get_term_meta( 'header_style' );
		} elseif ( publisher_is_valid_cpt() ) {
			$style = bf_get_post_meta( 'header_style' );;
		}// WooCommerce
		elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {

			if ( is_shop() ) {
				$style = bf_get_post_meta( 'header_style', wc_get_page_id( 'shop' ) );
			} elseif ( is_product() ) {
				$style = bf_get_post_meta( 'header_style', get_the_ID() );
			} elseif ( is_cart() ) {
				$style = bf_get_post_meta( 'header_style', wc_get_page_id( 'cart' ) );
			} elseif ( is_checkout() ) {
				$style = bf_get_post_meta( 'header_style', wc_get_page_id( 'checkout' ) );
			} elseif ( is_account_page() ) {
				$style = bf_get_post_meta( 'header_style', wc_get_page_id( 'myaccount' ) );
			} elseif ( is_product_category() || is_product_tag() ) {
				$style = bf_get_term_meta( 'header_style', get_queried_object()->term_id );
			}

		}

		if ( $style == 'default' || ! publisher_is_valid_header_style( $style ) ) {
			$style = publisher_get_option( 'header_style' );
		}

		return $style;

	} // publisher_get_header_style
} // if


if ( ! function_exists( 'publisher_is_valid_header_style' ) ) {
	/**
	 * Check the parameter is theme valid layout or not!
	 *
	 * This is because of multiple theme that have same header_style id for page headers
	 *
	 * @param $layout
	 *
	 * @return bool
	 */
	function publisher_is_valid_header_style( $layout ) {

		return ( is_string( $layout ) || is_int( $layout ) ) &&
		       array_key_exists( $layout, publisher_header_style_option_list() );
	} // publisher_is_valid_header_style
} // if


if ( ! function_exists( 'publisher_get_header_layout' ) ) {
	/**
	 * Returns header layout for current page
	 *
	 * @return bool
	 */
	function publisher_get_header_layout() {

		// Return from cache
		if ( publisher_get_global( 'header-layout' ) ) {
			return publisher_get_global( 'header-layout' );
		}

		$layout = 'default';

		if ( publisher_is_valid_tax() ) {
			$layout = bf_get_term_meta( 'header_layout' );
		} elseif ( publisher_is_valid_cpt() ) {
			$layout = bf_get_post_meta( 'header_layout' );
		}

		if ( $layout == 'default' ) {
			$layout = publisher_get_option( 'header_layout' );
		}

		// Cache
		publisher_set_global( 'header-layout', $layout );

		return $layout;

	} // publisher_get_header_layout
}


if ( ! function_exists( 'publisher_get_header_layout_class' ) ) {
	/**
	 * Returns header layout class for current page
	 *
	 * @return bool
	 */
	function publisher_get_header_layout_class() {

		static $class;

		if ( $class ) {
			return $class;
		}

		$class = publisher_get_header_layout();

		if ( $class === 'stretched' ) {
			$class = 'full-width stretched';
		}

		return $class;

	} // publisher_get_header_layout_class
}


// Add filter for VC elements add-on
add_filter( 'better-framework/shortcodes/title', 'publisher_bf_shortcodes_title' );

if ( ! function_exists( 'publisher_bf_shortcodes_title' ) ) {
	/**
	 * Filter For Generating BetterFramework Shortcodes Title
	 *
	 * @param $atts
	 *
	 * @return mixed
	 */
	function publisher_bf_shortcodes_title( $atts ) {

		// Icon
		if ( ! empty( $atts['icon'] ) ) {
			$icon = bf_get_icon_tag( $atts['icon'] ) . ' ';
		} else {
			$icon = '';
		}

		// Title link
		if ( ! empty( $atts['title_link'] ) ) {
			$link = $atts['title_link'];
		} elseif ( ! empty( $atts['category'] ) ) {
			$link = get_category_link( $atts['category'] );
			if ( empty( $atts['title'] ) ) {
				$cat           = get_category( $atts['category'] );
				$atts['title'] = $cat->name;
			}
		} elseif ( ! empty( $atts['tag'] ) ) {
			$link = get_tag_link( $atts['tag'] );
			if ( empty( $atts['title'] ) ) {
				$tag           = get_tag( $atts['tag'] );
				$atts['title'] = $tag->name;
			}
		} else {
			$link = '';
		}

		if ( empty( $atts['title'] ) ) {
			$atts['title'] = publisher_translation_get( 'recent_posts' );
		}

		?>
		<h3 class="section-heading">
			<?php if ( ! empty( $link ) ){ ?>
			<a href="<?php echo esc_url( $link ); ?>">
				<?php } ?>
				<span class="h-text"><?php echo $icon . esc_html( $atts['title'] ); // $icon escaped before ?></span>
				<?php if ( ! empty( $link ) ){ ?>
			</a>
		<?php } ?>
		</h3>
		<?php
	}
} // if


if ( ! function_exists( 'publisher_block_create_query_args' ) ) {
	/**
	 * Handy function to create master listing query args
	 *
	 * todo remove this!
	 *
	 * @param $$atts
	 *
	 * @return bool
	 */
	function publisher_block_create_query_args( &$atts ) {

		$args = array(
			'post_type' => array( 'post' ),
			'order'     => $atts['order'],
			'orderby'   => $atts['order_by'],
		);

		// Category
		if ( ! empty( $atts['category'] ) ) {
			$args['cat'] = $atts['category'];
		}

		// Tag
		if ( $atts['tag'] ) {
			$args['tag__and'] = explode( ',', $atts['tag'] );
		}

		// Post id filters
		if ( ! empty( $atts['post_ids'] ) ) {

			$post_id_array = explode( ',', $atts['post_ids'] );
			$post_in       = array();
			$post_not_in   = array();

			// Split ids into post_in and post_not_in
			foreach ( $post_id_array as $post_id ) {

				$post_id = trim( $post_id );

				if ( is_numeric( $post_id ) ) {
					if ( intval( $post_id ) < 0 ) {
						$post_not_in[] = str_replace( '-', '', $post_id );
					} else {
						$post_in[] = $post_id;
					}
				}
			}

			if ( ! empty( $post_not_in ) ) {
				$wp_query_args['post__not_in'] = $post_not_in;
			}

			if ( ! empty( $post_in ) ) {
				$args['post__in'] = $post_in;
				$args['orderby']  = 'post__in';
			}
		}


		// Custom post types
		if ( $atts['post_type'] ) {
			$args['post_type'] = explode( ',', $atts['post_type'] );
		}

		if ( ! empty( $atts['count'] ) && intval( $atts['count'] ) > 0 ) {
			$args['posts_per_page'] = $atts['count'];
		} else {
			switch ( $atts['style'] ) {

				//
				// Grid Listing
				//
				case 'listing-grid':

					switch ( $atts['columns'] ) {

						case 1:
							$args['posts_per_page'] = 4;
							break;

						case 2:
							$args['posts_per_page'] = 4;
							break;

						case 3:
							$args['posts_per_page'] = 6;
							break;

						case 4:
							$args['posts_per_page'] = 8;
							break;

						default:
							$args['posts_per_page'] = 6;
							break;

					}
					break;

				//
				// Thumbnail Listing 1
				//
				case 'listing-thumbnail-1':
					switch ( $atts['columns'] ) {

						case 1:
							$args['posts_per_page'] = 4;
							break;

						case 2:
							$args['posts_per_page'] = 6;
							break;

						case 3:
							$args['posts_per_page'] = 9;
							break;

						case 4:
							$args['posts_per_page'] = 12;
							break;

						default:
							$args['posts_per_page'] = 6;
							break;
					}
					break;

				//
				// Thumbnail Listing 2
				//
				case 'listing-thumbnail-2':
					$args['posts_per_page'] = 4;
					break;


				//
				// Blog Listing
				//
				case 'listing-blog':
					switch ( $atts['columns'] ) {

						case 1:
							$args['posts_per_page'] = 4;
							break;

						case 2:
							$args['posts_per_page'] = 6;
							break;

						case 3:
							$args['posts_per_page'] = 9;
							break;

						case 4:
							$args['posts_per_page'] = 12;
							break;


						default:
							$args['posts_per_page'] = 6;
							break;
					}
					break;


				//
				// mix Listing
				//
				case 'listing-mix-1-1':
					$args['posts_per_page'] = 5;
					break;
				case 'listing-mix-1-2':
					$args['posts_per_page'] = 5;
					break;
				case 'listing-mix-1-3':
					$args['posts_per_page'] = 7;
					break;
				case 'listing-mix-2-1':
					$args['posts_per_page'] = 8;
					break;
				case 'listing-mix-2-2':
					$args['posts_per_page'] = 10;
					break;
				case 'listing-mix-3-1':
					$args['posts_per_page'] = 4;
					break;
				case 'listing-mix-3-2':
					$args['posts_per_page'] = 5;
					break;
				case 'listing-mix-3-3':
					$args['posts_per_page'] = 5;
					break;


				//
				// Text Listing 1
				//
				case 'listing-text-1':
					switch ( $atts['columns'] ) {

						case 1:
							$args['posts_per_page'] = 3;
							break;

						case 2:
							$args['posts_per_page'] = 6;
							break;

						case 3:
							$args['posts_per_page'] = 9;
							break;

						case 4:
							$args['posts_per_page'] = 12;
							break;

						default:
							$args['posts_per_page'] = 3;
							break;
					}
					break;

				//
				// Text Listing 2
				//
				case 'listing-text-2':
					switch ( $atts['columns'] ) {

						case 1:
							$args['posts_per_page'] = 4;
							break;

						case 2:
							$args['posts_per_page'] = 8;
							break;

						case 3:
							$args['posts_per_page'] = 12;
							break;

						case 4:
							$args['posts_per_page'] = 16;
							break;

						default:
							$args['posts_per_page'] = 4;
							break;
					}
					break;


				//
				// Modern Grid Listing
				//
				case 'modern-grid-listing-1':
					$args['posts_per_page'] = 4;
					break;

				case 'modern-grid-listing-2':
					$args['posts_per_page'] = 5;
					break;

				case 'modern-grid-listing-3':
					$args['posts_per_page'] = 3;
					break;


				default:
					$args['posts_per_page'] = 6;
			}
		}


		/*

		compatibility for better reviews

		if( $atts['order_by'] == 'reviews' ){
			$args['orderby'] = 'date';
			$args['meta_key'] = '_bs_review_enabled';
			$args['meta_value'] = '1';
		}

		*/

		// Order by views count
		if ( $atts['order_by'] == 'views' ) {
			$args['meta_key'] = 'better-views-count';
			$args['orderby']  = 'meta_value_num';
		}

		// Time filter
		if ( $atts['time_filter'] != '' ) {
			$args['date_query'] = publisher_get_time_filter_query( $atts['time_filter'] );
		}

		return $args;
	}
}


if ( ! function_exists( 'publisher_block_create_tabs' ) ) {
	/**
	 * Handy function to create master listing tabs
	 *
	 * @param $atts
	 *
	 * todo check time filter and order by
	 *
	 * @return array
	 */
	function publisher_block_create_tabs( &$atts ) {

		// 1. collect all tabs array
		// 2. chose to be tab or single column
		// 3. print it
		$tabs = array();

		$active = TRUE; // flag to identify the main tab

		$main_cat = FALSE;

		//
		// First tab ( main )
		//
		if ( ! empty( $atts['query-main-term'] ) ) {
			$main_cat = $atts['query-main-term'];
		} else if ( ! empty( $atts['category'] ) ) {
			$main_cat = $atts['category'];
		}

		if ( $main_cat ) {

			$cat = get_category( $main_cat );

			// is valid category
			if ( $cat && ! is_wp_error( $cat ) ) {

				if ( empty( $atts['title'] ) ) {
					$atts['title'] = $cat->name;
				}

				// Icon
				if ( ! empty( $atts['icon'] ) ) {
					$icon = bf_get_icon_tag( $atts['icon'] ) . ' ';
				} else {
					$icon = '';
				}

				$tabs[] = array(
					'title'   => $atts['title'],
					'link'    => get_category_link( $cat ),
					'type'    => 'category',
					'term_id' => $main_cat,
					'id'      => 'tab-' . mt_rand(),
					'icon'    => $icon,
					'class'   => 'main-term-' . $main_cat,
					'active'  => $active,
				);

				$active = FALSE; // only one active
			}

		} elseif ( ! empty( $atts['tag'] ) ) {

			$tags = explode( ',', $atts['tag'] );

			$tag = FALSE;

			foreach ( $tags as $_tag ) {
				$tag = get_tag( $_tag );
				if ( $tag && ! is_wp_error( $tag ) ) {
					break;
				}
			}

			if ( $tag && ! is_wp_error( $tag ) ) {

				if ( empty( $atts['title'] ) ) {
					$atts['title'] = $tag->name;
				}

				// Icon
				if ( ! empty( $atts['icon'] ) ) {
					$icon = bf_get_icon_tag( $atts['icon'] ) . ' ';
				} else {
					$icon = '';
				}

				$tabs[] = array(
					'title'   => $atts['title'],
					'link'    => get_tag_link( $tag->term_id ),
					'type'    => 'tag',
					'term_id' => $tag->term_id,
					'id'      => 'tab-' . mt_rand(),
					'icon'    => $icon,
					'class'   => 'main-term-none',
					'active'  => $active,
				);

				$active = FALSE; // only one active

			}
		} elseif ( ! empty( $atts['taxonomy'] ) ) {

			$tax = explode( ':', current( explode( ',', $atts['taxonomy'] ) ) );

			if ( count( $tax ) >= 2 ) {
				$tax_term = get_term( $tax[1], $tax[0] );

				if ( ! is_wp_error( $tax_term ) ) {

					if ( empty( $atts['title'] ) ) {
						$atts['title'] = $tax_term->name;
					}

					// Icon
					if ( ! empty( $atts['icon'] ) ) {
						$icon = bf_get_icon_tag( $atts['icon'] ) . ' ';
					} else {
						$icon = '';
					}

					$tabs[] = array(
						'title'   => $atts['title'],
						'link'    => get_tag_link( $tax_term ),
						'type'    => 'taxonomy',
						'term_id' => $tax_term->term_id,
						'id'      => 'tab-' . mt_rand(),
						'icon'    => $icon,
						'class'   => 'main-term-none',
						'active'  => $active,
					);

					$active = FALSE; // only one active
				}
			}
		}


		// Default tab for fallback
		if ( $active ) {
			$tabs[] = publisher_block_create_tabs_default_tab( $atts, $active );
			$active = FALSE;
		}

		// not return other tabs if they will not shown!
		if ( ( ! empty( $atts['hide_title'] ) && $atts['hide_title'] ) ||
		     ( ! empty( $atts['show_title'] ) && ! $atts['show_title'] )
		) {
			return $tabs;
		}

		//
		// Other Tabs
		//
		if ( isset( $atts['tabs'] ) && ! empty( $atts['tabs'] ) ) {

			$terms = array();
			switch ( $atts['tabs'] ) {

				//
				// Category tabs
				//
				case 'cat_filter':

					if ( empty( $atts['tabs_cat_filter'] ) ) {
						break;
					} else if ( is_string( $atts['tabs_cat_filter'] ) ) {
						$atts['tabs_cat_filter'] = explode( ',', $atts['tabs_cat_filter'] );
					}

					$terms = get_categories( array( 'include' => $atts['tabs_cat_filter'] ) );

					break;

				case 'sub_cat_filter':

					if ( $main_cat ) {
						$terms = get_categories( array( 'child_of' => $main_cat, 'number' => 20 ) );
					}

					break;

				case 'tax_filter':

					if ( ! empty( $atts['tabs_tax_filter'] ) ) {

						if ( preg_match_all( '/ (\w+) \s* : \s*  ([^,]+)/isx', $atts['tabs_tax_filter'], $matches ) ) {

							$_all_terms = array();
							foreach ( $matches[1] as $idx => $taxonomy ) {
								$term_id = $matches[2][ $idx ];
								$section = $term_id[0] === '-' ? 'exclude' : 'include';

								$_all_terms[ $taxonomy ][ $section ][] = absint( $term_id );
							}

							foreach ( $_all_terms as $taxonomy => $_terms ) {

								$terms_id_include = isset( $_terms['include'] ) ? $_terms['include'] : array();
								$terms_id_exclude = isset( $_terms['exclude'] ) ? $_terms['exclude'] : array();


								$terms = array_merge(
									$terms,
									get_terms(
										array(
											'include' => bf_get_term_childs( $terms_id_include, $terms_id_exclude, $taxonomy )
										)
									)
								);
							}
						}

					}

					break;
			}

			foreach ( $terms as $term ) {

				$tabs[] = array(
					'title'   => $term->name,
					'link'    => get_term_link( $term ),
					'type'    => 'category',
					'term_id' => $term->term_id,
					'id'      => 'tab-' . mt_rand(),
					'icon'    => '',
					'class'   => 'main-term-' . $term->term_id,
					'active'  => $active,
				);

				// only one active
				if ( $active ) {
					$active = FALSE;
				}
			}

		}

		return $tabs;
	} // publisher_block_create_tabs
}

if ( ! function_exists( 'publisher_block_create_tabs_default_tab' ) ) {
	/**
	 * Handy internal function to get default tab from atts
	 *
	 * @param      $atts
	 * @param bool $active
	 *
	 * @return array
	 */
	function publisher_block_create_tabs_default_tab( &$atts, $active = TRUE ) {

		if ( empty( $atts['title'] ) ) {
			$atts['title'] = publisher_translation_get( 'recent_posts' );
		}

		// Icon
		if ( ! empty( $atts['icon'] ) ) {
			$icon = bf_get_icon_tag( $atts['icon'] ) . ' ';
		} else {
			$icon = '';
		}

		return array(
			'title'   => $atts['title'],
			'link'    => '',
			'type'    => 'custom',
			'term_id' => '',
			'id'      => 'tab-' . mt_rand(),
			'icon'    => $icon,
			'class'   => 'main-term-none',
			'active'  => $active,
		);

	}
}

if ( ! function_exists( 'publisher_block_the_heading' ) ) {
	/**
	 * Handy function to create master listing tabs
	 *
	 * @param   $tabs
	 * @param   $multi_tab
	 *
	 * @return  bool
	 */
	function publisher_block_the_heading( &$atts, &$tabs, $multi_tab = FALSE ) {

		$show_title = TRUE;

		if ( ! Better_Framework::widget_manager()->get_current_sidebar() ) {

			if ( ! empty( $atts['hide_title'] ) && $atts['hide_title'] ) {
				$show_title = FALSE;
			}

			if ( ! empty( $atts['show_title'] ) && ! $atts['show_title'] ) {
				$show_title = FALSE;
			}

		}

		if ( $show_title ) { ?>
			<h3 class="section-heading <?php

			echo esc_attr( $tabs[0]['class'] );

			if ( ! empty( $atts['deferred_load_tabs'] ) ) {
				echo esc_attr( ' bs-deferred-tabs' );
			}

			if ( $multi_tab ) {
				echo esc_attr( ' multi-tab' );
			}

			?>">

				<?php if ( ! $multi_tab ) { ?>

					<?php if ( ! empty( $tabs[0]['link'] ) ) { ?>
						<a href="<?php echo esc_url( $tabs[0]['link'] ); ?>" class="main-link">
							<span
								class="h-text <?php echo esc_attr( $tabs[0]['class'] ); ?>"><?php echo $tabs[0]['icon'], esc_html( $tabs[0]['title'] ); // icon escaped before ?></span>
						</a>
					<?php } else { ?>
						<span
							class="h-text <?php echo esc_attr( $tabs[0]['class'] ); ?> main-link"><?php echo $tabs[0]['icon'], esc_html( $tabs[0]['title'] ); // icon escaped before ?></span>
					<?php } ?>

				<?php } else { ?>

					<?php foreach ( (array) $tabs as $tab ) { ?>
						<a href="#<?php echo esc_attr( $tab['id'] ) ?>" data-toggle="tab"
						   aria-expanded="<?php echo $tab['active'] ? 'true' : 'false'; ?>"
						   class="<?php echo $tab['active'] ? 'main-link active' : 'other-link'; ?>"
							<?php if ( isset( $tab['data'] ) ) {
								foreach ( $tab['data'] as $key => $value ) {
									printf( ' data-%s="%s"', sanitize_key( $key ), esc_attr( $value ) );
								}
							} ?>
						>
							<span
								class="h-text <?php echo esc_attr( $tab['class'] ); ?>"><?php echo $tab['icon'] . esc_html( $tab['title'] ); // icon escaped before ?></span>
						</a>
					<?php } ?>

				<?php } ?>

			</h3>
			<?php

		}


	}// publisher_block_the_heading
}


add_filter( 'wpb_widget_title', 'publisher_vc_block_the_heading', 100, 2 );

if ( ! function_exists( 'publisher_vc_block_the_heading' ) ) {
	/**
	 * Handy function to customize VC blocks headings
	 *
	 *
	 * @return string
	 */
	function publisher_vc_block_the_heading( $output = '', $atts = array() ) {

		if ( empty( $atts['title'] ) ) {
			return $output;
		}

		$class = '';

		if ( ! empty( $atts['extraclass'] ) ) {
			$class = $atts['extraclass'];
		}

		return '<h3 class="section-heading ' . $class . '">
			<span class="h-text main-link">' . esc_html( $atts['title'] ) . '</span>
		</h3>';

	}// publisher_block_the_heading
}

add_filter( 'vc_shortcodes_css_class', 'publisher_vc_block_class', 100, 2 );

if ( ! function_exists( 'publisher_vc_block_class' ) ) {
	/**
	 * Handy function to customize VC blocks classes
	 *
	 * @return string
	 */
	function publisher_vc_block_class( $class = '', $base = '', $atts = array() ) {

		$_check = array(
			'vc_gmaps'              => '',
			'vc_column_text'        => '',
			'vc_toggle'             => '',
			'vc_gallery'            => '',
			'vc_images_carousel'    => '',
			'vc_posts_slider'       => '',
			'vc_progress_bar'       => '',
			'vc_pie'                => '',
			'vc_round_chart'        => '',
			'vc_line_chart'         => '',
			'vc_media_grid'         => '',
			'vc_masonry_media_grid' => '',
		);

		if ( isset( $_check[ $base ] ) ) {
			$class .= ' bs-vc-block';
		}

		return $class;
	}// publisher_block_the_heading
}


if ( ! function_exists( 'publisher_format_icon' ) ) {
	/**
	 * Handy function used to get post format badge
	 *
	 * @param   bool $echo Echo or return
	 *
	 * @return string
	 */
	function publisher_format_icon( $echo = TRUE ) {

		$output = '';

		if ( get_post_type() == 'post' ) {

			$format = get_post_format();

			if ( $format ) {

				switch ( $format ) {

					case 'video':
						$output = '<span class="format-icon format-' . $format . '"><i class="fa fa-play"></i></span>';
						break;

					case 'aside':
						$output = '<span class="format-icon format-' . $format . '"><i class="fa fa-pencil"></i></span>';
						break;

					case 'quote':
						$output = '<span class="format-icon format-' . $format . '"><i class="fa fa-quote-left"></i></span>';
						break;

					case 'gallery':
					case 'image':
						$output = '<span class="format-icon format-' . $format . '"><i class="fa fa-camera"></i></span>';
						break;

					case 'status':
						$output = '<span class="format-icon format-' . $format . '"><i class="fa fa-refresh"></i></span>';
						break;

					case 'audio':
						$output = '<span class="format-icon format-' . $format . '"><i class="fa fa-music"></i></span>';
						break;

					case 'chat':
						$output = '<span class="format-icon format-' . $format . '"><i class="fa fa-coffee"></i></span>';
						break;

					case 'link':
						$output = '<span class="format-icon format-' . $format . '"><i class="fa fa-link"></i></span>';
						break;

				}

			}

		}

		if ( $echo ) {
			echo $output; // escaped before
		} else {
			return $output;
		}

	} // publisher_format_badge_code
} // if


if ( ! function_exists( 'publisher_get_links_pagination' ) ) {
	/**
	 * @param array $options
	 *
	 * @return string
	 */
	function publisher_get_links_pagination( $options = array() ) {

		// Default Options
		$default_options = array(
			'echo' => TRUE,
		);

		// Texts with RTL support
		if ( is_rtl() ) {
			$default_options['older-text'] = '<i class="fa fa-angle-double-right"></i> ' . publisher_translation_get( 'pagination_newer' );
			$default_options['next-text']  = publisher_translation_get( 'pagination_older' ) . ' <i class="fa fa-angle-double-left"></i>';
		} else {
			$default_options['next-text']  = '<i class="fa fa-angle-double-left"></i> ' . publisher_translation_get( 'pagination_older' );
			$default_options['older-text'] = publisher_translation_get( 'pagination_newer' ) . ' <i class="fa fa-angle-double-right"></i>';
		}

		// Merge default and passed options
		$options = bf_merge_args( $options, $default_options );

		if ( ! $options['echo'] ) {
			ob_start();
		}

		// fix category posts link because of offset
		if ( publisher_is_valid_tax() ) {
			$term_id       = get_queried_object()->term_id;
			$count         = bf_get_term_posts_count( $term_id, array( 'include_childs' => TRUE ) );
			$limit         = get_option( 'posts_per_page' );
			$slider_config = publisher_main_slider_config();

			// Custom count per category
			if ( bf_get_term_meta( 'term_posts_count', get_queried_object()->term_id, '' ) != '' ) {
				$limit = bf_get_term_meta( 'term_posts_count', get_queried_object()->term_id, '' );
			} // Custom count for all categories
			elseif ( publisher_get_option( 'cat_posts_count' ) != '' && intval( publisher_get_option( 'cat_posts_count' ) ) > 0 ) {
				$limit = publisher_get_option( 'cat_posts_count' );
			}

			if ( $slider_config['show'] && $slider_config['type'] == 'custom-blocks' ) {
				$max_items = ceil( ( $count - intval( $slider_config['posts'] ) ) / $limit );
			} else {
				$max_items = publisher_get_query()->max_num_pages;
			}

		} else {
			$max_items = publisher_get_query()->max_num_pages;
		}

		$paginated_front_page = ( 'page' == get_option( 'show_on_front' ) ) && is_front_page() && bf_get_query_var_paged( 1 ) > 1;

		// Change global $paged value to fix next_posts_link issue in static paginated homepages
		if ( $paginated_front_page ) {
			global $paged;
			$paged_c = $paged;
			$paged   = bf_get_query_var_paged();
		}

		if ( $max_items > 1 ) {
			?>
			<div <?php publisher_attr( 'pagination', 'bs-links-pagination clearfix' ) ?>>
				<div class="older"><?php next_posts_link( $options['next-text'], $max_items ); ?></div>
				<div class="newer"><?php previous_posts_link( $options['older-text'] ); ?></div>
			</div>
			<?php
		}

		// return bac the global $paged value
		if ( $paginated_front_page ) {
			$paged = $paged_c;
		}

		if ( ! $options['echo'] ) {
			return ob_get_clean();
		}

	} // publisher_get_links_pagination
} // if


if ( ! function_exists( 'publisher_get_pagination' ) ) {
	/**
	 * BetterTemplate Custom Pagination
	 *
	 * @param array $options extend options for paginate_links()
	 *
	 * @return array|mixed|string
	 *
	 * @see paginate_links()
	 */
	function publisher_get_pagination( $options = array() ) {

		global $wp_rewrite;

		// Default Options
		$default_options = array(
			'echo'            => TRUE,
			'use-wp_pagenavi' => TRUE,
			'users-per-page'  => 6,
		);

		// Prepare query
		if ( publisher_get_query() != NULL ) {
			$default_options['query'] = publisher_get_query();
		} else {
			global $wp_query;
			$default_options['query'] = $wp_query;
		}


		// Merge default and passed options
		$options = bf_merge_args( $options, $default_options );


		// Texts with RTL support
		if ( ! isset( $options['next-text'] ) && ! isset( $options['prev-text'] ) ) {
			if ( is_rtl() ) {
				$options['next-text'] = publisher_translation_get( 'pagination_next' ) . ' <i class="fa fa-angle-left"></i>';
				$options['prev-text'] = '<i class="fa fa-angle-right"></i> ' . publisher_translation_get( 'pagination_prev' );
			} else {
				$options['next-text'] = publisher_translation_get( 'pagination_next' ) . ' <i class="fa fa-angle-right"></i>';
				$options['prev-text'] = ' <i class="fa fa-angle-left"></i> ' . publisher_translation_get( 'pagination_prev' );
			}
		}


		// WP-PageNavi Plugin
		if ( $options['use-wp_pagenavi'] && function_exists( 'wp_pagenavi' ) && ! is_a( $options['query'], 'WP_User_Query' ) ) {

			ob_start();

			// Use WP-PageNavi plugin to generate pagination
			wp_pagenavi(
				array(
					'query' => $options['query']
				)
			);

			$pagination = ob_get_clean();

		} // Custom Pagination With WP Functionality
		else {

			$paged = $options['query']->get( 'paged', '' ) ? $options['query']->get( 'paged', '' ) : ( $options['query']->get( 'page', '' ) ? $options['query']->get( 'page', '' ) : 1 );

			if ( is_a( $options['query'], 'WP_User_Query' ) ) {

				$offset = $options['users-per-page'] * ( $paged - 1 );

				$total_pages = ceil( $options['query']->total_users / $options['users-per-page'] );

			} else {
				$total_pages = $options['query']->max_num_pages;

				// fix category posts link because of offset
				if ( publisher_is_valid_tax() ) {
					$term_id = get_queried_object()->term_id;
					$count   = bf_get_term_posts_count( $term_id, array( 'include_childs' => TRUE ) );

					$limit         = get_option( 'posts_per_page' );
					$slider_config = publisher_main_slider_config( array(
							'type'    => 'term',
							'term_id' => $term_id
						)
					);

					// Custom count per category
					if ( bf_get_term_meta( 'term_posts_count', $term_id, '' ) != '' ) {
						$limit = bf_get_term_meta( 'term_posts_count', $term_id, '' );
					} // Custom count for all categories
					elseif ( publisher_get_option( 'cat_posts_count' ) != '' && intval( publisher_get_option( 'cat_posts_count' ) ) > 0 ) {
						$limit = publisher_get_option( 'cat_posts_count' );
					}

					if ( $slider_config['show'] && $slider_config['type'] == 'custom-blocks' ) {
						$total_pages = ceil( ( $count - intval( $slider_config['posts'] ) ) / $limit );
					}
				}

			}

			if ( $total_pages <= 1 ) {
				return '';
			}

			$args = array(
				'base'      => add_query_arg( 'paged', '%#%' ),
				'current'   => max( 1, $paged ),
				'total'     => $total_pages,
				'next_text' => $options['next-text'],
				'prev_text' => $options['prev-text']
			);

			if ( is_a( $options['query'], 'WP_User_Query' ) ) {
				$args['offset'] = $offset;
			}

			if ( $wp_rewrite->using_permalinks() ) {
				$big          = 999999999;
				$args['base'] = str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) );
			}

			if ( is_search() ) {
				$args['add_args'] = array(
					's' => urlencode( get_query_var( 's' ) )
				);
			}

			$pagination = paginate_links( array_merge( $args, $options ) );

			$pagination = preg_replace( '/&#038;paged=1(\'|")/', '\\1', trim( $pagination ) );

		}

		$pagination = '<div ' . publisher_get_attr( 'pagination', 'bs-numbered-pagination' ) . '>' . $pagination . '</div>';

		if ( $options['echo'] ) {
			echo $pagination; // escaped before
		} else {
			return $pagination;
		}

	} // publisher_get_pagination
} // if


add_filter( 'publisher/archive/before-loop', 'publisher_archive_show_pagination' );
add_filter( 'publisher/archive/after-loop', 'publisher_archive_show_pagination' );
if ( ! function_exists( 'publisher_archive_show_pagination' ) ) {
	/**
	 * used to add pagination
	 *
	 * note: do not call this manually. it should be fire with following callbacks:
	 * 1. publisher/archive/before-loop
	 * 2. publisher/archive/after-loop
	 */
	function publisher_archive_show_pagination() {

		$wp_query = publisher_get_query();

		$pagination = publisher_get_pagination_style(); // determine current page pagination (with inner cache)

		$filter = current_filter();

		// Show/Hide excerpt
		if ( $filter === 'publisher/archive/before-loop' ) {

			$_check = array(
				'listing-mix-4-1' => '',
				'listing-mix-4-2' => '',
				'listing-mix-4-3' => '',
				'listing-mix-4-4' => '',
				'listing-mix-4-5' => '',
				'listing-mix-4-6' => '',
				'listing-mix-4-7' => '',
				'listing-mix-4-8' => ''
			);

			if ( isset( $_check[ publisher_get_page_listing() ] ) ) {
				publisher_set_prop( 'show-excerpt-small', publisher_get_show_page_listing_excerpt() );
				publisher_set_prop( 'show-excerpt-big', publisher_get_show_page_listing_excerpt() );
			} else {
				publisher_set_prop( 'show-excerpt', publisher_get_show_page_listing_excerpt() );
			}

		}

		// pagination
		switch ( TRUE ) {

			case $pagination == 'numbered' && $filter == 'publisher/archive/before-loop':
				return;
				break;

			case $pagination == 'numbered' && $filter == 'publisher/archive/after-loop':
				publisher_get_pagination();

				return;
				break;

			case $pagination == 'links' && $filter == 'publisher/archive/before-loop':
				return;
				break;

			case $pagination == 'links' && $filter == 'publisher/archive/after-loop':
				publisher_get_links_pagination();

				return;
				break;

			case $pagination == 'ajax_more_btn_infinity' && $filter == 'publisher/archive/before-loop':
			case $pagination == 'ajax_infinity' && $filter == 'publisher/archive/before-loop':
			case $pagination == 'ajax_more_btn' && $filter == 'publisher/archive/before-loop':
			case $pagination == 'ajax_next_prev' && $filter == 'publisher/archive/before-loop':

				$max_num_pages = bf_get_wp_query_total_pages( $wp_query );

				// fix for when there is no more pages
				if ( $max_num_pages <= 1 ) {
					return;
				}

				// Create valid name for BS_Pagination
				$pagin_style = str_replace( 'ajax_', '', $pagination );

				$atts = array(
					'paginate'        => $pagin_style,
					'have_pagination' => TRUE,
				);

				publisher_theme_pagin_manager()->wrapper_start( $atts );

				break;

			case $pagination == 'ajax_more_btn_infinity' && $filter == 'publisher/archive/after-loop':
			case $pagination == 'ajax_infinity' && $filter == 'publisher/archive/after-loop':
			case $pagination == 'ajax_more_btn' && $filter == 'publisher/archive/after-loop':
			case $pagination == 'ajax_next_prev' && $filter == 'publisher/archive/after-loop':

				$max_num_pages = bf_get_wp_query_total_pages( $wp_query );

				// fix for when there is no more pages
				if ( $max_num_pages <= 1 ) {
					return;
				}

				// Create valid name for BS_Pagination
				$pagin_style = str_replace( 'ajax_', '', $pagination );

				$atts = array(
					'paginate'        => $pagin_style,
					'have_pagination' => TRUE,
					'show_label'      => publisher_theme_pagin_manager()->get_pagination_label( 1, $max_num_pages ),
					'next_page_link'  => next_posts( 0, FALSE ), // next page link for better SEO
					'query_vars'      => bf_get_wp_query_vars( $wp_query ),
				);

				$atts['show_excerpt'] = publisher_get_prop( 'show-excerpt', FALSE );

				publisher_theme_pagin_manager()->wrapper_end();

				publisher_theme_pagin_manager()->display_pagination( $atts, $wp_query, 'Publisher::bs_pagin_ajax_archive', 'custom' );
		}

	} // publisher_archive_show_pagination
} // if


if ( ! function_exists( 'publisher_general_fix_shortcode_vc_style' ) ) {
	/**
	 * Fixes shortcode style for generated style from VC -> General fixes
	 *
	 * @param $atts
	 */
	function publisher_general_fix_shortcode_vc_style( &$atts ) {

		switch ( $atts['shortcode-id'] ) {

			case 'bs-modern-grid-listing-5':

				if ( empty( $atts['_style_bg_color'] ) ) {
					return;
				}

				bf_add_css( '.' . $atts['css-class'] . ' .listing-mg-5-item-big .content-container{ background-color:' . $atts['_style_bg_color'] . ' !important}', TRUE, TRUE );

				break;

			// Classic Listing 3 content BG Fix
			case 'bs-classic-listing-3':
			case 'bs-mix-listing-4-7':
			case 'bs-mix-listing-4-2':
			case 'bs-mix-listing-4-1':

				if ( empty( $atts['_style_bg_color'] ) ) {
					return;
				}

				bf_add_css( '.' . $atts['css-class'] . ' .listing-item-classic-3 .featured .title{ background-color:' . $atts['_style_bg_color'] . '}', TRUE, TRUE );

				break;

		}

		return; // It's for inner style!
	}
}// publisher_fix_shortcode_vc_style


if ( ! function_exists( 'publisher_fix_shortcode_vc_style' ) ) {
	/**
	 * Fixes shortcode style for generated style from VC
	 *
	 * @param $atts
	 */
	function publisher_fix_shortcode_vc_style( &$atts ) {

		publisher_general_fix_shortcode_vc_style( $atts ); // general fixes

		if ( ! empty( $atts['_style_bg_color'] ) ) {

			$class = '.' . $atts['css-class'];

			bf_add_css(
				$class . ' .section-heading .h-text,' .
				$class . ' .section-heading.multi-tab .bs-pretty-tabs-container,' .
				$class . ' .bs-pretty-tabs-container .bs-pretty-tabs-elements ,' .
				$class . ' .bs-pretty-tabs .bs-pretty-tabs-more.other-link .h-text:after' .
				'{ background-color:' . $atts['_style_bg_color'] . ' !important}',
				TRUE,
				TRUE
			);
		}

		return; // It's for inner style!
	}
}// publisher_fix_shortcode_vc_style


add_filter( 'better-framework/shortcodes/atts', 'publisher_fix_bs_listing_vc_atts' );

if ( ! function_exists( 'publisher_fix_bs_listing_vc_atts' ) ) {
	/**
	 * Used to customize bs listing atts for VC
	 *
	 * @param $atts
	 *
	 * @return mixed
	 */
	function publisher_fix_bs_listing_vc_atts( $atts ) {

		if ( empty( $atts['css'] ) ) {
			return $atts;
		}

		$atts['_style_bg_color'] = bf_shortcode_custom_css_prop( $atts['css'], 'background-color' );

		publisher_fix_shortcode_vc_style( $atts );

		if ( ! empty( $atts['_style_bg_color'] ) ) {
			$atts['css-class'] .= ' have_bg';
		}

		return $atts;
	}
}


if ( ! function_exists( 'publisher_is_valid_cpt' ) ) {
	/**
	 * Handy function to detect current post is valid post type for post options or not!
	 *
	 * @param string $type
	 *
	 * @since 1.7
	 * @return bool
	 */
	function publisher_is_valid_cpt( $type = 'both' ) {

		if ( ! is_singular() ) {
			return FALSE;
		}

		static $valid;

		if ( ! is_null( $valid ) && isset( $valid[ $type ] ) ) {
			return $valid[ $type ];
		}

		if ( publisher_get_option( 'advanced_post_options_types' ) ) {
			$post_types = array_flip( explode( ',', publisher_get_option( 'advanced_post_options_types' ) ) );
		} else {
			$post_types = array();
		}

		if ( $type === 'both' ) {
			$post_types['post'] = '';
			$post_types['page'] = '';
		} elseif ( $type === 'post' ) {
			$post_types['post'] = '';
		} elseif ( $type === 'page' ) {
			$post_types['page'] = '';
		}

		return $valid[ $type ] = isset( $post_types[ get_post_type() ] );

	}
}


if ( ! function_exists( 'publisher_is_valid_tax' ) ) {
	/**
	 * Handy function to detect current post is valid taxonomy for category options or not!
	 *
	 * @param string $type
	 * @param bool   $queried_object
	 *
	 * @since 1.7
	 * @return bool
	 */
	function publisher_is_valid_tax( $type = 'category', $queried_object = FALSE ) {

		static $valid;

		if ( ! is_null( $valid ) && isset( $valid[ $type ] ) ) {
			return $valid[ $type ];
		}

		if ( $type === 'category' ) {

			if ( ! $queried_object ) {
				if ( is_category() ) {
					return $valid[ $type ] = TRUE;
				} elseif ( ! is_tax() ) {
					return $valid[ $type ] = FALSE;
				}
			}

			if ( publisher_get_option( 'advanced_category_options_tax' ) ) {
				$taxonomies = array_flip( explode( ',', publisher_get_option( 'advanced_category_options_tax' ) ) );
			}

		} elseif ( $type === 'tag' ) {

			$type = 'post_tag'; // Tag taxonomy

			if ( ! $queried_object ) {
				if ( is_tag() ) {
					return $valid[ $type ] = TRUE;
				} elseif ( ! is_tax() ) {
					return $valid[ $type ] = FALSE;
				}
			}

			if ( publisher_get_option( 'advanced_tag_options_tax' ) ) {
				$taxonomies = array_flip( explode( ',', publisher_get_option( 'advanced_tag_options_tax' ) ) );
			}

		} else {
			return $valid[ $type ] = FALSE;
		}

		$taxonomies[ $type ] = '';

		if ( ! is_object( $queried_object ) ) {
			$queried_object = get_queried_object();
		}

		if ( ! isset( $queried_object->taxonomy ) ) {
			return $valid[ $type ] = FALSE;
		}

		return $valid[ $type ] = isset( $taxonomies[ $queried_object->taxonomy ] );

	}
}


if ( ! function_exists( 'publisher_get_single_template' ) ) {
	/**
	 * Used to get template for single page
	 *
	 * @return string
	 */
	function publisher_get_single_template() {

		static $template;

		if ( $template ) {
			return $template;
		}

		// default not valid post types
		if ( ! publisher_is_valid_cpt() ) {
			return $template = 'style-1';
		}

		$template = bf_get_post_meta( 'post_template' );

		if ( $template == 'default' ) {
			$template = publisher_get_option( 'post_template' );
		}

		// validate
		if ( $template != 'default' && ! publisher_is_valid_single_template( $template ) ) {
			$template = 'default';
		}

		// default is style-1
		if ( $template == 'default' ) {
			$template = 'style-1';
		}

		return $template;

	}
}// publisher_fix_shortcode_vc_style


if ( ! function_exists( 'publisher_get_single_template_option' ) ) {
	/**
	 * Used to get template for single page
	 *
	 * @return string
	 */
	function publisher_get_single_template_option( $default = FALSE ) {
		static $theme_version;

		if ( ! $theme_version ) {
			$theme = wp_get_theme();

			if ( $theme->get( 'Template' ) ) {
				$theme = wp_get_theme( $theme->get( 'Template' ) );
			}

			$theme_version = $theme->get( 'Version' );
		}

		$option = array();

		if ( $default ) {
			$option['default'] = array(
				'img'           => PUBLISHER_THEME_URI . 'images/options/post-default.png?v=' . $theme_version,
				'label'         => __( 'Default', 'publisher' ),
				'current_label' => __( 'Default Template', 'publisher' ),
			);
		}

		$option['style-1']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/post-style-1.png?v=' . $theme_version,
			'label' => __( 'Template 1', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Normal', 'publisher' ),
				),
			),
		);
		$option['style-2']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/post-style-2.png?v=' . $theme_version,
			'label' => __( 'Template 2', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Wide', 'publisher' ),
				),
			),
		);
		$option['style-3']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/post-style-3.png?v=' . $theme_version,
			'label' => __( 'Template 3', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Wide', 'publisher' ),
				),
			),
		);
		$option['style-4']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/post-style-4.png?v=' . $theme_version,
			'label' => __( 'Template 4', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Wide', 'publisher' ),
				),
			),
		);
		$option['style-5']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/post-style-5.png?v=' . $theme_version,
			'label' => __( 'Template 5', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Wide', 'publisher' ),
				),
			),
		);
		$option['style-6']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/post-style-6.png?v=' . $theme_version,
			'label' => __( 'Template 6', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Wide', 'publisher' ),
				),
			),
		);
		$option['style-7']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/post-style-7.png?v=' . $theme_version,
			'label' => __( 'Template 7', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Wide', 'publisher' ),
				),
			),
		);
		$option['style-8']  = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/post-style-8.png?v=' . $theme_version,
			'label' => __( 'Template 8', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Normal', 'publisher' ),
				),
			),
		);
		$option['style-9']  = array(
			'img'    => PUBLISHER_THEME_URI . 'images/options/post-style-9.png?v=' . $theme_version,
			'label'  => __( 'Template 9', 'publisher' ),
			'class'  => 'bf-flip-img-rtl',
			'info'   => array(
				'cat' => array(
					__( 'No Thumbnail', 'publisher' ),
				),
			),
			'Badges' => array(
				'cat' => array(
					__( 'No Thumbnail', 'publisher' ),
				),
			),
		);
		$option['style-10'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/post-style-10.png?v=' . $theme_version,
			'label' => __( 'Template 10', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Normal', 'publisher' ),
				),
			),
		);
		$option['style-11'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/post-style-11.png?v=' . $theme_version,
			'label' => __( 'Template 11', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Normal', 'publisher' ),
				),
			),
		);
		$option['style-12'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/post-style-12.png?v=' . $theme_version,
			'label' => __( 'Template 12', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Video', 'publisher' ),
				),
			),
		);
		$option['style-13'] = array(
			'img'   => PUBLISHER_THEME_URI . 'images/options/post-style-13.png?v=' . $theme_version,
			'label' => __( 'Template 13', 'publisher' ),
			'class' => 'bf-flip-img-rtl',
			'info'  => array(
				'cat' => array(
					__( 'Wide', 'publisher' ),
				),
			),
		);

		return $option;
	}
}// publisher_fix_shortcode_vc_style


if ( ! function_exists( 'publisher_is_valid_single_template' ) ) {
	/**
	 * Checks parameter to be a theme valid single template
	 *
	 * @param $template
	 *
	 * @return bool
	 */
	function publisher_is_valid_single_template( $template ) {
		return array_key_exists( $template, publisher_get_single_template_option() );
	} // publisher_is_valid_listing
}


if ( ! function_exists( 'publisher_social_counter_options_list_callback' ) ) {
	/**
	 * Handy deferred function for improving performance
	 *
	 * @return array
	 */
	function publisher_social_counter_options_list_callback() {

		if ( ! class_exists( 'Better_Social_Counter' ) ) {
			return array();
		} else {
			return Better_Social_Counter_Data_Manager::self()->get_widget_options_list();
		}

	}
}

if ( ! function_exists( 'publisher_is_animated_thumbnail_active' ) ) {
	/**
	 * Returns the condition of animated thumbnail activation
	 *
	 * @return bool
	 */
	function publisher_is_animated_thumbnail_active() {
		return TRUE;
	}
}


if ( ! function_exists( 'publisher_get_related_post_type' ) ) {
	/**
	 * Returns type of related posts for current page
	 *
	 * @return bool|mixed|null|string|void
	 */
	function publisher_get_related_post_type() {

		static $related_post;

		if ( $related_post ) {
			return $related_post;
		}

		$related_post = 'default';

		if ( publisher_is_valid_cpt() ) {
			$related_post = bf_get_post_meta( 'post_related' );
		}

		if ( $related_post == 'default' || $related_post == '' || $related_post == FALSE ) {
			$related_post = publisher_get_option( 'post_related' );
		}

		return $related_post;

	}
}


if ( ! function_exists( 'publisher_get_post_comments_type' ) ) {
	/**
	 * Returns type of comments for current page
	 *
	 * @return bool|mixed|null|string|void
	 */
	function publisher_get_post_comments_type() {

		// Return from cache
		if ( publisher_get_global( 'post-comments-type-' . get_the_ID(), FALSE ) ) {
			return publisher_get_global( 'post-comments-type-' . get_the_ID(), FALSE );
		}

		$type = 'default';

		// for pages and posts
		if ( publisher_is_valid_cpt() ) {
			$type = bf_get_post_meta( 'post_comments', get_the_ID(), 'default' );
		}


		// get default from panel
		if ( empty( $type ) || $type === FALSE || $type == 'default' ) {
			if ( is_singular( 'page' ) ) {
				$type = publisher_get_option( 'page_comments' );
			} else {
				$type = publisher_get_option( 'post_comments' );
			}
		}


		// if ajaxify is not enabled
		if ( $type === 'show-ajaxified' && ! publisher_is_ajaxified_comments_active() ) {
			$type = 'show-simple';
		}

		$_check = array(
			'show-ajaxified' => '',
			'show-simple'    => '',
			'hide'           => '',
		);

		// if type is not valid
		if ( ! isset( $_check[ $type ] ) ) {
			$type = 'show-simple';
		}

		unset( $_check ); // clear memory

		//
		// If related post is infinity then posts loaded from ajax should have show comments button
		//
		if ( ! is_page() && publisher_get_related_post_type() === 'infinity-related-post' || ( defined( 'PUBLISHER_THEME_AJAXIFIED_LOAD_POST' ) && PUBLISHER_THEME_AJAXIFIED_LOAD_POST ) ) {
			$type = 'show-ajaxified';
		}

		// Change ajaxified to show simple when user submitted an comment before
		if ( $type == 'show-ajaxified' && ! empty( $_GET['publisher-theme-comment-inserted'] ) && $_GET['publisher-theme-comment-inserted'] == '1' ) {
			$type = 'show-simple';
		}

		// Cache it
		publisher_set_global( 'post-comments-type-' . get_the_ID(), $type );

		return $type;
	}
}


if ( ! function_exists( 'publisher_comments_template' ) ) {
	/**
	 * Handy function to getting correct comments file
	 */
	function publisher_comments_template() {


		switch ( publisher_get_post_comments_type() ) {

			case 'show-simple':
				comments_template();
				break;

			case 'show-ajaxified':
				comments_template( '/comments-ajaxified.php' );
				break;

			case FALSE:
			case '':
			case 'hide':
				return;

		}

	}
}


if ( ! function_exists( 'publisher_is_review_active' ) ) {
	/**
	 * Returns state of review for current post
	 *
	 * Supported Plugins:
	 *
	 * - Better Reviews     : Not public
	 * - WP Reviews         : https://wordpress.org/plugins/wp-review/
	 *
	 * @since 1.7
	 */
	function publisher_is_review_active() {

		/**
		 * Better Reviews plugin
		 */
		if ( function_exists( 'Better_Reviews' ) ) {
			if ( function_exists( 'better_reviews_is_review_active' ) ) {
				return better_reviews_is_review_active();
			} // compatibility for Better Reviews before v1.2.0
			else {
				return Better_Reviews::get_meta( '_bs_review_enabled' );
			}
		}


		/**
		 * WP Reviews plugin
		 *
		 * https://wordpress.org/plugins/wp-review/
		 */
		if ( function_exists( 'wp_review_get_post_review_type' ) ) {
			return wp_review_get_post_review_type();
		}


		return FALSE;
	}
}


if ( ! function_exists( 'publisher_get_rating' ) ) {
	/**
	 * Shows rating bar
	 *
	 * Supported Plugins:
	 *
	 * - Better Reviews     : Not public
	 * - WP Reviews         : https://wordpress.org/plugins/wp-review/
	 *
	 * @param bool $show_rate
	 *
	 * @since 1.7
	 *
	 * @return string
	 */
	function publisher_get_rating( $show_rate = FALSE ) {

		if ( ! publisher_is_review_active() ) {
			return;
		}

		$rate = FALSE;
		$type = '';


		/**
		 * Better Reviews plugin
		 */
		if ( function_exists( 'better_reviews_is_review_active' ) ) {

			if ( function_exists( 'better_reviews_get_review_type' ) ) {
				$type = better_reviews_get_review_type();
				$rate = better_reviews_get_total_rate();
			} // compatibility for Better Reviews before v1.2.0
			else {
				$type = Better_Reviews::get_meta( '_bs_review_rating_type' );
				$rate = Better_Reviews()->generator()->calculate_overall_rate();
			}

		}


		/**
		 * WP Reviews plugin
		 *
		 * https://wordpress.org/plugins/wp-review/
		 */
		if ( $rate === FALSE && function_exists( 'wp_review_get_post_review_type' ) ) {

			$rate = get_post_meta( get_the_ID(), 'wp_review_total', TRUE );
			$type = wp_review_get_post_review_type();

			if ( $type === 'star' ) {
				$type = 'stars';
				$rate *= 20;
			} elseif ( $type === 'point' ) {
				$type = 'points';
				$rate *= 10;
			}

		}


		if ( $rate === FALSE ) {
			return;
		}


		if ( $show_rate ) {
			if ( $type == 'points' ) {
				$show_rate = '<span class="rate-number">' . round( $rate / 10, 1 ) . '</span>';
			} else {
				$show_rate = '<span class="rate-number">' . esc_html( $rate ) . '%</span>';
			}
		} else {
			$show_rate = '';
		}

		if ( $type == 'points' || $type == 'percentage' ) {
			$type = 'bar';
		}

		echo '<div class="rating rating-' . esc_attr( $type ) . '"><span style="width: ' . esc_attr( $rate ) . '%;"></span>' . $show_rate . '</div>';

	} // publisher_get_rating
}


if ( ! function_exists( 'publisher_vc_widgetised_sidebar_params' ) ) {
	/**
	 * Callback: Fixes widget params for Visual Composer sidebars that are custom sidebar!
	 * Filter: dynamic_sidebar_params
	 *
	 * @param $params
	 *
	 * @since 1.7.0.3
	 *
	 * @return mixed
	 */
	function publisher_vc_widgetised_sidebar_params( $params ) {

		if ( ! isset( $params[0] ) ) {
			return $params;
		}

		if ( empty( $params[0]['before_title'] ) ) {
			$params[0]['before_title'] = '<h5 class="widget-heading"><span class="h-text">';
		}

		if ( empty( $params[0]['after_title'] ) ) {
			$params[0]['after_title'] = '</span></h5>';
		}

		if ( empty( $params[0]['before_widget'] ) ) {

			$widget_class = '';
			$widget_id    = ! empty( $params[0]['widget_id'] ) ? $params[0]['widget_id'] : '';

			global $wp_registered_widgets;

			// Create class list for widget
			if ( isset( $wp_registered_widgets[ $params[0]['widget_id'] ] ) ) {
				foreach ( (array) $wp_registered_widgets[ $params[0]['widget_id'] ]['classname'] as $cn ) {
					if ( is_string( $cn ) ) {
						$widget_class .= '_' . $cn;
					} elseif ( is_object( $cn ) ) {
						$widget_class .= '_' . get_class( $cn );
					}
				}
				$widget_class = ltrim( $widget_class, '_' );
			}

			$params[0]['before_widget'] = '<div id="' . $widget_id . '" class="widget vc-widget ' . $widget_class . '">';
		}

		if ( empty( $params['after_widget'] ) ) {
			$params[0]['after_widget'] = '</div>';
		}

		return $params;
	}
}


if ( ! function_exists( 'publisher_show_breadcrumb' ) ) {
	/**
	 * Defines the breadcrumb should be shown or not
	 *
	 * @return bool
	 */
	function publisher_show_breadcrumb() {

		static $show;

		if ( ! is_null( $show ) ) {
			return $show;
		}

		$paginated_front_page = ( 'page' == get_option( 'show_on_front' ) ) && is_front_page() && bf_get_query_var_paged( 1 ) > 1;

		// hide breadcrumb in home
		if ( ( is_home() || is_front_page() ) && ! $paginated_front_page ) {
			return $show = FALSE;
		}

		$show = 'default';

		if ( is_singular() && ! $paginated_front_page ) {
			$show = bf_get_post_meta( 'post_breadcrumb', NULL, 'default' );
		}

		if ( $show === 'default' || empty( $show ) ) {
			$show = publisher_get_option( 'breadcrumb' );
		}

		$show = $show !== 'hide';

		return $show;

	} // publisher_show_breadcrumb
}


if ( ! function_exists( 'publisher_loop_meta' ) ) {
	/**
	 * Meta of loops
	 *
	 * @return bool
	 */
	function publisher_loop_meta() {

		$show_comments = TRUE;
		$show_reviews  = publisher_is_review_active();
		$show_author   = TRUE;
		$show_date     = TRUE;
		$show_view     = TRUE;
		$show_share    = TRUE;


		/**
		 *
		 * Single Logic Conditions
		 *
		 */

		if ( publisher_get_prop( 'hide-meta-date', FALSE ) ) {
			$show_date = FALSE;
		}

		if ( ! function_exists( 'The_Better_Views_Count' ) || publisher_get_prop( 'hide-meta-view', FALSE ) ) {
			$show_view = FALSE;
		}

		if ( publisher_get_prop( 'hide-meta-share', FALSE ) ) {
			$show_share = FALSE;
		}

		if ( publisher_get_prop( 'hide-meta-comment', FALSE ) || ! comments_open() ) {
			$show_comments = FALSE;
		}

		if ( publisher_get_prop( 'hide-meta-author', FALSE ) ) {
			$show_author = FALSE;
		}

		if ( $show_reviews && publisher_get_prop( 'hide-meta-review', FALSE ) ) {
			$show_reviews = FALSE;
		}


		/**
		 *
		 * Multiple Logic Conditions
		 *
		 */

		// Hide comments to make space for review
		if ( $show_reviews && $show_comments && publisher_get_prop( 'hide-meta-comment-if-review', FALSE ) ) {
			$show_comments = FALSE;
		}

		// Hide author to make space for review
		if ( $show_reviews && $show_author && publisher_get_prop( 'hide-meta-author-if-review', 0 ) ) {
			$show_author = FALSE;
		}

		?>
		<div class="post-meta">

			<?php if ( $show_author ) { ?>
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"
				   title="<?php echo publisher_translation_echo( 'browse_auth_articles' ); ?>"
				   class="post-author-a">
					<i class="post-author author">
						<?php the_author(); ?>
					</i>
				</a>
			<?php }


			if ( $show_date ) {

				global $post;

				?>
				<span class="time"><time class="post-published updated"
				                         datetime="<?php echo mysql2date( DATE_W3C, $post->post_date, FALSE ); ?>"><?php
						if ( publisher_get_prop( 'meta-date-format', 'standard' ) === 'standard' ) {
							the_time( publisher_translation_get( 'comment_time' ) );
						} else {
							echo publisher_get_readable_date();
						}

						?></time></span>
				<?php
			}


			if ( $show_view ) {

				$rank = publisher_get_ranking_icon( The_Better_Views_Count(), 'views_ranking', 'fa-eye' );

				if ( isset( $rank['show'] ) && $rank['show'] ) {
					The_Better_Views(
						TRUE,
						'<span class="views post-meta-views ' . $rank['id'] . '" data-bpv-post="' . get_the_ID() . '">' . $rank['icon'],
						'</span>',
						'show',
						'%VIEW_COUNT%'
					);
				}
			}


			if ( $show_share ) {

				$count = array_sum( bf_social_shares_count( publisher_get_option( 'social_share_sites' ) ) );
				$rank  = publisher_get_ranking_icon( $count, 'shares_ranking', 'fa-share-alt' );

				if ( isset( $rank['show'] ) && $rank['show'] ) {

					?>
					<span class="share <?php echo $rank['id']; ?>"><?php echo $rank['icon'], ' ', $count; ?></span>
					<?php

				}
			}


			if ( $show_reviews ) {
				publisher_get_rating();
			}


			if ( $show_comments ) {

				$title  = apply_filters( 'better-studio/theme/meta/comments/title', publisher_get_the_title() );
				$link   = apply_filters( 'better-studio/theme/meta/comments/link', publisher_get_comments_link() );
				$number = apply_filters( 'better-studio/theme/meta/comments/number', publisher_get_comments_number() );

				$text = '<i class="fa fa-comments-o"></i> ' . apply_filters( 'better-studio/themes/meta/comments/text', $number );

				echo sprintf( '<a href="%1$s" title="%2$s" class="comments">%3$s</a>',
					$link,
					esc_attr( sprintf( publisher_translation_get( 'leave_comment_on' ), $title ) ),
					$text
				);

			}

			?>
		</div>
		<?php

	} // publisher_loop_meta
}


if ( ! function_exists( 'publisher_setup_paged_frontpage_query' ) ) {
	/**
	 * Setups paged front page query
	 * -> When homepage is static but pagination used for next pages
	 *
	 * @return bool
	 */
	function publisher_setup_paged_frontpage_query() {

		$home_args = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 10,
			'paged'          => bf_get_query_var_paged( 1 ),
		);

		// Home posts count
		if ( publisher_get_option( 'home_posts_count' ) != '' ) {
			$home_args['posts_per_page'] = publisher_get_option( 'home_posts_count' );
		}

		// Home category filters
		if ( publisher_get_option( 'home_cat_include' ) != '' ) {
			$home_args['cat'] = publisher_get_option( 'home_cat_include' );
		}

		// Home exclude category filters
		if ( publisher_get_option( 'home_cat_exclude' ) != '' ) {
			$home_args['category__not_in'] = publisher_get_option( 'home_cat_exclude' );
		}

		// Home tag filters
		if ( publisher_get_option( 'home_tag_include' ) != '' ) {
			$home_args['tag__in'] = publisher_get_option( 'home_tag_include' );
		}

		$front_page_query = new WP_Query( $home_args );

		publisher_set_query( $front_page_query );

	} // publisher_setup_paged_frontpage_query
}


if ( ! function_exists( 'publisher_get_ranking_icon' ) ) {
	/**
	 * Returns icon of rank from panel
	 *
	 *
	 * @param int    $rank
	 * @param string $type
	 * @param string $default
	 * @param bool   $force_show
	 *
	 * @return array
	 * @since 1.8.0
	 *
	 */
	function publisher_get_ranking_icon( $rank = 0, $type = 'views_ranking', $default = 'fa-eye', $force_show = FALSE ) {

		static $ranks;

		if ( is_null( $ranks ) ) {
			$ranks = array();
		}

		// prepare ranks
		if ( ! isset( $ranks[ $type ] ) ) {

			$ranks[ $type ] = array();

			$field = publisher_get_option( $type );


			foreach ( $field as $_value ) {
				if ( $_value['rate'] == '' ) {
					continue;
				}

				$ranks[ $type ][ $_value['rate'] ]         = $_value;
				$ranks[ $type ][ $_value['rate'] ]['icon'] = bf_get_icon_tag( $_value['icon'] );
			}

			ksort( $ranks[ $type ] );

			$_ranks = array();

			foreach ( $ranks[ $type ] as $_rank => $_rank_v ) {

				$_ranks[ $_rank ]       = $_rank_v;
				$_ranks[ $_rank ]['id'] = 'rank-' . $_rank;
			}

			$ranks[ $type ] = $_ranks;

			$ranks[ $type ]['default'] = array(
				'rate' => '',
				'id'   => 'rank-default',
				'show' => TRUE,
				'icon' => bf_get_icon_tag( $default ),
			);

		}

		$icon = FALSE;

		// Check rank
		foreach ( $ranks[ $type ] as $_rank_i => $_rank ) {

			if ( $_rank_i === 'default' ) {
				continue;
			}

			if ( $_rank['rate'] > $rank &&
			     isset( $ranks[ $type ][ $_rank_i - 1 ] ) && $ranks[ $type ][ $_rank_i - 1 ]['rate'] < $rank
			) {
				$icon = $ranks[ $type ][ $_rank_i - 1 ];
				continue;
			}

			if ( $_rank['rate'] <= $rank &&
			     (
				     ( isset( $ranks[ $type ][ $_rank_i + 1 ] ) && $ranks[ $type ][ $_rank_i + 1 ]['rate'] > $rank ) ||
				     ! isset( $ranks[ $type ][ $_rank_i + 1 ] )
			     )
			) {
				$icon = $_rank;
			}

		}

		if ( $force_show ) {
			$icon['show'] = TRUE;
		}

		if ( $icon ) {
			return $icon;
		} else {
			return $ranks[ $type ]['default'];
		}

	}
}


if ( ! function_exists( 'publisher_social_login_providers' ) ) {
	/**
	 * Get social login providers urls
	 *
	 * Supported plugins:
	 * http://miled.github.io/wordpress-social-login/
	 *
	 *
	 * @since 1.8.0
	 *
	 * @return array
	 */
	function publisher_social_login_providers() {

		if ( ! defined( 'WORDPRESS_SOCIAL_LOGIN_ABS_PATH' ) ) {
			return array();
		}

		global $WORDPRESS_SOCIAL_LOGIN_PROVIDERS_CONFIG;

		if ( empty( $WORDPRESS_SOCIAL_LOGIN_PROVIDERS_CONFIG ) || ! is_array( $WORDPRESS_SOCIAL_LOGIN_PROVIDERS_CONFIG ) ) {
			return array();
		}

		$current_url = site_url( add_query_arg( FALSE, FALSE ) );

		$login_url = add_query_arg(
			array(
				'action'      => 'wordpress_social_authenticate',
				'mode'        => 'login',
				'redirect_to' => urlencode( $current_url ),
			),
			site_url( 'wp-login.php', 'login_post' )
		);

		$use_popup = function_exists( 'wp_is_mobile' ) && wp_is_mobile() ? 2 : get_option( 'wsl_settings_use_popup' );

		$providers = array();

		foreach ( $WORDPRESS_SOCIAL_LOGIN_PROVIDERS_CONFIG as $provider ) {

			$provider_id = isset( $provider["provider_id"] ) ? $provider["provider_id"] : '';
			$is_enable   = get_option( 'wsl_settings_' . $provider_id . '_enabled' );

			if ( ! $is_enable ) {
				continue;
			}

			$provider_url = add_query_arg( 'provider', $provider_id, $login_url );
			$provider_url = apply_filters( 'wsl_render_auth_widget_alter_authenticate_url', $provider_url, $provider_id, 'login', $current_url, $use_popup );

			$providers[ $provider_id ] = $provider_url;
		}

		return $providers;
	}
}


if ( $GLOBALS['pagenow'] !== 'wp-login.php' || ! empty( $_REQUEST['action'] ) && $_REQUEST['action'] !== 'register' ) {
	add_filter( 'wsl_render_auth_widget_alter_provider_icon_markup', 'publisher_wsl_get_button', 10, 3 );
}

if ( ! function_exists( 'publisher_wsl_get_button' ) ) {
	/**
	 * Used to change codes of WSL plugin to make it high compatible with Publisher
	 *
	 * @param      $provider_id
	 * @param      $provider_name
	 * @param      $authenticate_url
	 * @param bool $full
	 */
	function publisher_wsl_get_button( $provider_id, $provider_name, $authenticate_url, $full = TRUE ) {

		$icons = array(
			'foursquare'    => 'fa-foursquare',
			'reddit'        => 'fa-reddit-alien',
			'disqus'        => 'bsfi-disqus',
			'linkedin'      => 'bsfi-linkedin',
			'yahoo'         => 'fa-yahoo',
			'instagram'     => 'bsfi-instagram',
			'wordpress'     => 'fa-wordpress',
			'google'        => 'bsfi-gplus',
			'twitter'       => 'bsfi-twitter',
			'facebook'      => 'bsfi-facebook',
			'lastfm'        => 'fa-lastfm',
			'tumblr'        => 'bsfi-tumblr',
			'stackoverflow' => 'fa-stack-overflow',
			'github'        => 'bsfi-github',
			'Dribbble'      => 'bsfi-dribbble',
			'500px'         => 'fa-500px',
			'steam'         => 'bsfi-steam',
			'twitchtv'      => 'fa-twitch',
			'vkontakte'     => 'bsfi-vk',
			'odnoklassniki' => 'fa-odnoklassniki',
			'aol'           => 'fa-odnoklassniki',
		);

		$provider_id_lower = strtolower( $provider_id );

		$icon = FALSE;

		if ( isset( $icons[ $provider_id_lower ] ) ) {
			$icon = bf_get_icon_tag( $icons[ $provider_id_lower ] );
		}

		?>
		<a
			rel="nofollow"
			href="<?php echo $authenticate_url; ?>"
			data-provider="<?php echo $provider_id ?>"
			class="btn social-login-btn social-login-btn-<?php echo $provider_id_lower, ' ', ! empty( $icon ) ? 'with-icon' : ''; ?>"><?php

			if ( $full ) {
				echo $icon, sprintf( publisher_translation_get( 'login_with' ), ucfirst( $provider_name ) );
			} else {
				echo $icon, $provider_id;
			}

			?>
		</a>
		<?php

	} // publisher_wsl_get_button
}


if ( ! function_exists( 'publisher_wsl_disable_for_login_form' ) ) {
	/**
	 * Handy function used to disable WSL login buttons in bottom of login form.
	 *
	 * @param $settings
	 *
	 * @return int
	 */
	function publisher_wsl_disable_for_login_form( $settings ) {
		return 2;
	}
}


if ( ! function_exists( 'publisher_multiple_comments_choices' ) ) {
	/**
	 * Multiple comment option panel choices
	 *
	 * @todo  add disqus icon
	 *
	 * @since 1.8.0
	 * @return array
	 */
	function publisher_multiple_comments_choices() {

		return array(
			'wordpress' => array(
				'label'     => '<i class="fa fa-wordpress"></i> ' . __( 'WordPress', 'publisher' ),
				'css-class' => 'active-item'
			),
			'facebook'  => array(
				'label'     => '<i class="fa fa-facebook"></i> ' . __( 'Facebook', 'publisher' ),
				'css-class' => is_callable( 'Better_Facebook_Comments::factory' ) ? 'active-item' : 'disable-item',
			),
			'disqus'    => array(
				'label'     => '<i class="bf-icon bsfi-disqus"></i>' . __( 'Disqus', 'publisher' ),
				'css-class' => is_callable( 'Better_Disqus_Comments::factory' ) ? 'active-item' : 'disable-item',
			),
		);
	}
}


if ( ! function_exists( 'publisher_multiple_comments_form' ) ) {
	/**
	 * Multiple comment option panel choices
	 *
	 * @todo  add disqus icon
	 *
	 * @since 1.8.0
	 * @return array
	 */
	function publisher_multiple_comments_form() {
		Publisher_Comments::multiple_comments_form();
	}
}


if ( ! function_exists( 'publisher_more_stories_listing_option_list' ) ) {
	/**
	 * Panels more stories listing field option
	 *
	 * @param bool $default_choice
	 *
	 *
	 * @since 1.8.0
	 * @return array
	 */
	function publisher_more_stories_listing_option_list( $default_choice = FALSE ) {

		static $theme_version;

		if ( ! $theme_version ) {
			$theme = wp_get_theme();

			if ( $theme->get( 'Template' ) ) {
				$theme = wp_get_theme( $theme->get( 'Template' ) );
			}

			$theme_version = $theme->get( 'Version' );
		}

		$option = array();


		if ( $default_choice ) {
			$option['default'] = array(
				'img'           => PUBLISHER_THEME_URI . 'images/options/post-default.png?v=' . $theme_version,
				'label'         => __( 'Default', 'publisher' ),
				'current_label' => __( 'Default [ From Theme Panel ]', 'publisher' ),
			);
		}

		$option['thumbnail-1'] = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/ms-listing-thumbnail-1.png?v=' . $theme_version,
			'label'         => __( 'Thumbnail 1', 'publisher' ),
			'current_label' => __( 'Thumbnail Listing 1', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Thumbnail Listing', 'publisher' ),
				),
			),
		);
		$option['thumbnail-2'] = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/ms-listing-thumbnail-2.png?v=' . $theme_version,
			'label'         => __( 'Thumbnail 2', 'publisher' ),
			'current_label' => __( 'Thumbnail Listing 2', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Thumbnail Listing', 'publisher' ),
				),
			),
		);
		$option['thumbnail-3'] = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/ms-listing-thumbnail-3.png?v=' . $theme_version,
			'label'         => __( 'Thumbnail 3', 'publisher' ),
			'current_label' => __( 'Thumbnail Listing 3', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Thumbnail Listing', 'publisher' ),
				),
			),
		);

		$option['text-1'] = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/ms-listing-text-1.png?v=' . $theme_version,
			'label'         => __( 'Text 1', 'publisher' ),
			'current_label' => __( 'Text Listing 1', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Text Listing', 'publisher' ),
				),
			),
		);
		$option['text-2'] = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/ms-listing-text-2.png?v=' . $theme_version,
			'label'         => __( 'Text 2', 'publisher' ),
			'current_label' => __( 'Text Listing 2', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Text Listing', 'publisher' ),
				),
			),
		);
		$option['text-3'] = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/ms-listing-text-3.png?v=' . $theme_version,
			'label'         => __( 'Text 3', 'publisher' ),
			'current_label' => __( 'Text Listing 3', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Text Listing', 'publisher' ),
				),
			),
		);
		$option['text-4'] = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/ms-listing-text-4.png?v=' . $theme_version,
			'label'         => __( 'Text 4', 'publisher' ),
			'current_label' => __( 'Text Listing 4', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat' => array(
					__( 'Text Listing', 'publisher' ),
				),
			),
		);

		return $option;
	}
}


if ( ! function_exists( 'publisher_irp_listing_option_list' ) ) {
	/**
	 * Panels inline related posts listing field
	 *
	 * @param bool $default_choice
	 *
	 *
	 * @since 1.8.0
	 * @return array
	 */
	function publisher_irp_listing_option_list( $default_choice = FALSE ) {

		static $theme_version;

		if ( ! $theme_version ) {
			$theme = wp_get_theme();

			if ( $theme->get( 'Template' ) ) {
				$theme = wp_get_theme( $theme->get( 'Template' ) );
			}

			$theme_version = $theme->get( 'Version' );
		}

		$option = array();


		if ( $default_choice ) {
			$option['default'] = array(
				'img'           => PUBLISHER_THEME_URI . 'images/options/post-default.png?v=' . $theme_version,
				'label'         => __( 'Default', 'publisher' ),
				'current_label' => __( 'Default [ From Theme Panel ]', 'publisher' ),
			);
		}

		$option['thumbnail-1']      = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/irp-listing-thumbnail-1.png?v=' . $theme_version,
			'label'         => __( 'Thumbnail 1', 'publisher' ),
			'current_label' => __( 'Thumbnail Listing 1', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat'  => array(
					__( 'Thumbnail Listing', 'publisher' ),
				),
				'type' => array(
					__( 'Aligned', 'publisher' ),
				),
			),
		);
		$option['thumbnail-2']      = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/irp-listing-thumbnail-2.png?v=' . $theme_version,
			'label'         => __( 'Thumbnail 2', 'publisher' ),
			'current_label' => __( 'Thumbnail Listing 2', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat'  => array(
					__( 'Thumbnail Listing', 'publisher' ),
				),
				'type' => array(
					__( 'Aligned', 'publisher' ),
				),
			),
		);
		$option['thumbnail-3']      = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/irp-listing-thumbnail-3.png?v=' . $theme_version,
			'label'         => __( 'Thumbnail 3', 'publisher' ),
			'current_label' => __( 'Thumbnail Listing 3', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat'  => array(
					__( 'Thumbnail Listing', 'publisher' ),
				),
				'type' => array(
					__( 'Aligned', 'publisher' ),
				),
			),
		);
		$option['thumbnail-1-full'] = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/irp-listing-thumbnail-1-full.png?v=' . $theme_version,
			'label'         => __( 'Thumbnail 1 Full', 'publisher' ),
			'current_label' => __( 'Full Thumbnail Listing 1', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat'  => array(
					__( 'Thumbnail Listing', 'publisher' ),
				),
				'type' => array(
					__( 'Full', 'publisher' ),
				),
			),
		);
		$option['thumbnail-2-full'] = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/irp-listing-thumbnail-2-full.png?v=' . $theme_version,
			'label'         => __( 'Thumbnail 2 Full', 'publisher' ),
			'current_label' => __( 'Full Thumbnail Listing 2', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat'  => array(
					__( 'Thumbnail Listing', 'publisher' ),
				),
				'type' => array(
					__( 'Full', 'publisher' ),
				),
			),
		);
		$option['thumbnail-3-full'] = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/irp-listing-thumbnail-3-full.png?v=' . $theme_version,
			'label'         => __( 'Thumbnail 3 Full', 'publisher' ),
			'current_label' => __( 'Full Thumbnail Listing 3', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat'  => array(
					__( 'Thumbnail Listing', 'publisher' ),
				),
				'type' => array(
					__( 'Full', 'publisher' ),
				),
			),
		);
		$option['text-1']           = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/irp-listing-text-1.png?v=' . $theme_version,
			'label'         => __( 'Text 1', 'publisher' ),
			'current_label' => __( 'Text Listing 1', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat'  => array(
					__( 'Text Listing', 'publisher' ),
				),
				'type' => array(
					__( 'Aligned', 'publisher' ),
				),
			),
		);
		$option['text-2']           = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/irp-listing-text-2.png?v=' . $theme_version,
			'label'         => __( 'Text 2', 'publisher' ),
			'current_label' => __( 'Text Listing 2', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat'  => array(
					__( 'Text Listing', 'publisher' ),
				),
				'type' => array(
					__( 'Aligned', 'publisher' ),
				),
			),
		);
		$option['text-3']           = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/irp-listing-text-3.png?v=' . $theme_version,
			'label'         => __( 'Text 3', 'publisher' ),
			'current_label' => __( 'Text Listing 3', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat'  => array(
					__( 'Text Listing', 'publisher' ),
				),
				'type' => array(
					__( 'Aligned', 'publisher' ),
				),
			),
		);
		$option['text-4']           = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/irp-listing-text-4.png?v=' . $theme_version,
			'label'         => __( 'Text 4', 'publisher' ),
			'current_label' => __( 'Text Listing 4', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat'  => array(
					__( 'Text Listing', 'publisher' ),
				),
				'type' => array(
					__( 'Aligned', 'publisher' ),
				),
			),
		);
		$option['text-1-full']      = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/irp-listing-text-1-full.png?v=' . $theme_version,
			'label'         => __( 'Text 1 Full', 'publisher' ),
			'current_label' => __( 'Full Text Listing 1', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat'  => array(
					__( 'Text Listing', 'publisher' ),
				),
				'type' => array(
					__( 'Full', 'publisher' ),
				),
			),
		);
		$option['text-2-full']      = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/irp-listing-text-2-full.png?v=' . $theme_version,
			'label'         => __( 'Text 2 Full', 'publisher' ),
			'current_label' => __( 'Full Text Listing 2', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat'  => array(
					__( 'Text Listing', 'publisher' ),
				),
				'type' => array(
					__( 'Full', 'publisher' ),
				),
			),
		);
		$option['text-3-full']      = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/irp-listing-text-3-full.png?v=' . $theme_version,
			'label'         => __( 'Text 3 Full', 'publisher' ),
			'current_label' => __( 'Full Text Listing 3', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat'  => array(
					__( 'Text Listing', 'publisher' ),
				),
				'type' => array(
					__( 'Full', 'publisher' ),
				),
			),
		);
		$option['text-4-full']      = array(
			'img'           => PUBLISHER_THEME_URI . 'images/options/irp-listing-text-4-full.png?v=' . $theme_version,
			'label'         => __( 'Text 4 Full', 'publisher' ),
			'current_label' => __( 'Full Text Listing 4', 'publisher' ),
			'class'         => 'bf-flip-img-rtl',
			'info'          => array(
				'cat'  => array(
					__( 'Text Listing', 'publisher' ),
				),
				'type' => array(
					__( 'Full', 'publisher' ),
				),
			),
		);

		return $option;
	}
}


if ( ! function_exists( 'publisher_search_query' ) ) {

	/**
	 * Set Custom Search Query
	 *
	 * @param string $search search query string
	 * @param array  $args   additional query args
	 *
	 * @since 1.8.0
	 * @return WP_Query
	 */
	function publisher_search_query( $search = '', $args = array() ) {

		return Publisher_Search::set_search_page_query( $search, $args );
	}
}


if ( ! function_exists( 'publisher_search_terms' ) ) {

	/**
	 * Search terms
	 *
	 * @param string $query the search query
	 * @param string $taxonomy
	 * @param int    $max_items
	 *
	 * @since 1.8.0
	 * @return array
	 */
	function publisher_search_terms( $query, $taxonomy = 'category', $max_items = 4 ) {

		return Publisher_Search::search_terms( $query, $taxonomy, $max_items );
	}
}


if ( ! function_exists( 'publisher_mega_menus_list' ) ) {

	/**
	 * List of publisher mega menus
	 *
	 * @since 1.8.0
	 * @return array
	 */
	function publisher_mega_menus_list() {

		static $theme_version;

		if ( ! $theme_version ) {
			$theme = wp_get_theme();

			if ( $theme->get( 'Template' ) ) {
				$theme = wp_get_theme( $theme->get( 'Template' ) );
			}

			$theme_version = $theme->get( 'Version' );
		}

		return array(
			'disabled'          => array(
				'img'   => PUBLISHER_THEME_URI . 'images/options/mega-disable.png?v=' . $theme_version,
				'label' => __( '-- Disabled --', 'publisher' ),
			),
			'link-list'         => array(
				'img'   => PUBLISHER_THEME_URI . 'images/options/mega-link-list.png?v=' . $theme_version,
				'label' => __( 'Horizontal links', 'publisher' ),
				'depth' => 0,
				'info'  => array(
					'cat' => array(
						__( 'Link', 'publisher' ),
					),
				),
			),
			'link-2-column'     => array(
				'img'   => PUBLISHER_THEME_URI . 'images/options/mega-link-2-column.png?v=' . $theme_version,
				'label' => __( '2 Column links', 'publisher' ),
				'depth' => 0,
				'info'  => array(
					'cat' => array(
						__( 'Link', 'publisher' ),
					),
				),
			),
			'link-3-column'     => array(
				'img'   => PUBLISHER_THEME_URI . 'images/options/mega-link-3-column.png?v=' . $theme_version,
				'label' => __( '3 Column links', 'publisher' ),
				'depth' => 0,
				'info'  => array(
					'cat' => array(
						__( 'Link', 'publisher' ),
					),
				),
			),
			'link-4-column'     => array(
				'img'   => PUBLISHER_THEME_URI . 'images/options/mega-link-4-column.png?v=' . $theme_version,
				'label' => __( '4 Column links', 'publisher' ),
				'depth' => 0,
				'info'  => array(
					'cat' => array(
						__( 'Link', 'publisher' ),
					),
				),
			),
			'tabbed-grid-posts' => array(
				'img'   => PUBLISHER_THEME_URI . 'images/options/mega-tabbed-grid-posts.png?v=' . $theme_version,
				'label' => __( 'Tabbed sub categories with posts', 'publisher' ),
				'depth' => 0,
				'info'  => array(
					'cat' => array(
						__( 'Posts', 'publisher' ),
					),
				),
			),
			'grid-posts'        => array(
				'img'   => PUBLISHER_THEME_URI . 'images/options/mega-grid-posts.png?v=' . $theme_version,
				'label' => __( 'Latest posts with image', 'publisher' ),
				'depth' => 0,
				'info'  => array(
					'cat' => array(
						__( 'Posts', 'publisher' ),
					),
				),
			),
		);
	}
}


if ( ! function_exists( 'publisher_lazy_load_image_sizes' ) ) {
	/**
	 * Get image alternative sizes
	 *
	 * @since 1.8.0
	 *
	 * @return array
	 */
	function publisher_lazy_load_image_sizes() {

		return array(
			// Rectangle sizes
			'publisher-sm'       => array(
				'publisher-tb1',
				'publisher-md',
				'publisher-mg2',
				'publisher-lg',
			),
			'publisher-mg2'      => array(
				'publisher-sm',
				'publisher-mg2',
				'publisher-md',
				'publisher-lg',
			),
			'publisher-md'       => array(
				'publisher-sm',
				'publisher-mg2',
				'publisher-lg',
			),
			'publisher-lg'       => array(
				'publisher-sm',
				'publisher-mg2',
				'publisher-md',
				'publisher-lg',
			),
			// Tall sizes
			'publisher-tall-sm'  => array(
				'publisher-tall-lg',
				'publisher-tall-big',
			),
			'publisher-tall-lg'  => array(
				'publisher-tall-sm',
				'publisher-tall-big',
			),
			'publisher-tall-big' => array(
				'publisher-tall-sm',
				'publisher-tall-lg',
			),
		);
	}
}


// Includes panel blocks setting field generator callback only in admin
if ( is_admin() ) {
	include PUBLISHER_THEME_PATH . 'includes/options/fields-cb.php';
}

