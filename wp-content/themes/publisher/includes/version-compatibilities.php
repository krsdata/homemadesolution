<?php


/**
 * Compatibility for versions before 1.1
 *
 * @return bool
 */
function publisher_version_1_1_compatibility() {

	$sidebars = wp_get_sidebars_widgets();

	$widgets_in_sidebar = array();

	foreach ( $sidebars['aside-logo'] as $widget_numbers ) {
		if ( preg_match( "/^(.*?)\-(\d.*)+/i", $widget_numbers, $match ) ) {

			$widget_id_base = &$match[1];
			$widget_number  = &$match[2];

			$widgets_in_sidebar[ $widget_id_base ][] = $widget_number;
		}
	}

	foreach ( $widgets_in_sidebar as $id_base => $widget_numbers ) {

		if ( $id_base != 'better-ads' ) {
			continue;
		}

		$option_name = "widget_$id_base";

		$option = get_option( $option_name );

		if ( $option && is_array( $option ) ) {

			$ads_manager = get_option( 'better_ads_manager' );

			$fields = array(
				'type',
				'banner',
				'campaign',
				'count',
				'columns',
				'orderby',
				'order',
				'align',
			);

			foreach ( $fields as $id ) {
				if ( ! empty( $option[ $widget_numbers[0] ][ $id ] ) ) {
					$ads_manager[ 'header_aside_logo_' . $id ] = $option[ $widget_numbers[0] ][ $id ];
				}
			}

			update_option( 'better_ads_manager', $ads_manager );

			break; // only first ads widget

		}
	}

	return TRUE;
}


/**
 * Compatibility for versions before 1.4
 *
 * @return bool
 */
function publisher_version_1_4_compatibility() {

	$option = get_option( publisher_get_theme_panel_id() );

	$option['post-page-settings']['meta']['review']    = 1;
	$option['listing-modern-grid-1']['meta']['review'] = 1;
	$option['listing-modern-grid-2']['meta']['review'] = 1;
	$option['listing-modern-grid-3']['meta']['review'] = 1;
	$option['listing-modern-grid-4']['meta']['review'] = 1;
	$option['listing-modern-grid-5']['meta']['review'] = 1;
	$option['listing-modern-grid-6']['meta']['review'] = 1;
	$option['listing-mix-1-1']['meta']['review']       = 1;
	$option['listing-mix-1-2']['meta']['review']       = 1;
	$option['listing-mix-1-3']['meta']['review']       = 1;
	$option['listing-mix-1-4']['meta']['review']       = 1;
	$option['listing-mix-2-1']['meta']['review']       = 1;
	$option['listing-mix-2-2']['meta']['review']       = 1;
	$option['listing-mix-3-1']['meta']['review']       = 1;
	$option['listing-mix-3-2']['meta']['review']       = 1;
	$option['listing-mix-3-3']['meta']['review']       = 1;
	$option['listing-mix-3-4']['meta']['review']       = 1;
	$option['listing-mix-4-1']['meta']['review']       = 1;
	$option['listing-mix-4-2']['meta']['review']       = 1;
	$option['listing-mix-4-3']['meta']['review']       = 1;
	$option['listing-mix-4-4']['meta']['review']       = 1;
	$option['listing-mix-4-5']['meta']['review']       = 1;
	$option['listing-mix-4-6']['meta']['review']       = 1;
	$option['listing-mix-4-7']['meta']['review']       = 1;
	$option['listing-mix-4-8']['meta']['review']       = 1;
	$option['listing-grid-1']['meta']['review']        = 1;
	$option['listing-grid-2']['meta']['review']        = 1;
	$option['listing-blog-1']['meta']['review']        = 1;
	$option['listing-blog-2']['meta']['review']        = 1;
	$option['listing-blog-3']['meta']['review']        = 1;
	$option['listing-blog-4']['meta']['review']        = 1;
	$option['listing-blog-5']['meta']['review']        = 1;
	$option['listing-thumbnail-1']['meta']['review']   = 1;
	$option['listing-thumbnail-2']['meta']['review']   = 1;
	$option['listing-thumbnail-3']['meta']['review']   = 1;
	$option['listing-text-1']['meta']['review']        = 1;
	$option['listing-text-2']['meta']['review']        = 1;
	$option['listing-classic-1']['meta']['review']     = 1;
	$option['listing-classic-2']['meta']['review']     = 1;
	$option['listing-classic-3']['meta']['review']     = 1;
	$option['listing-tall-1']['meta']['review']        = 1;
	$option['listing-tall-2']['meta']['review']        = 1;

	update_option( publisher_get_theme_panel_id(), $option );

	return TRUE;
}

/**
 * Compatibility for versions before 1.5
 *
 * @return bool
 */
function publisher_version_1_5_compatibility() {

	$fields = array();
	include PUBLISHER_THEME_PATH . 'includes/options/panel-std.php';

	$option = get_option( publisher_get_theme_panel_id() );

	$keys = array(
		'post-page-settings'    => array(
			'format-icon' => 1,
			'term-count'  => 3,
			'tag'         => 1,
			'tag-count'   => 10,
		),
		'listing-modern-grid-1' => array(
			'term-badge-count' => 1,
		),
		'listing-modern-grid-2' => array(
			'term-badge-count' => 1,
		),
		'listing-modern-grid-3' => array(
			'term-badge-count' => 1,
		),
		'listing-modern-grid-4' => array(
			'term-badge-count' => 1,
		),
		'listing-modern-grid-5' => array(
			'term-badge-count' => 1,
		),
		'listing-modern-grid-6' => array(
			'term-badge-count' => 1,
		),
		'listing-mix-1-1'       => array(
			'big-term-badge-count' => 1,
		),
		'listing-mix-1-2'       => array(
			'big-term-badge-count'   => 1,
			'small-term-badge-count' => 1,
		),
		'listing-mix-1-3'       => array(
			'big-term-badge-count' => 1,
		),
		'listing-mix-1-4'       => array(
			'big-term-badge-count'   => 1,
			'small-term-badge-count' => 1,
		),
		'listing-mix-2-1'       => array(
			'big-term-badge-count' => 1,
		),
		'listing-mix-2-2'       => array(
			'big-term-badge-count' => 1,
		),
		'listing-mix-3-1'       => array(
			'big-term-badge-count' => 1,
		),
		'listing-mix-3-2'       => array(
			'big-term-badge-count'   => 1,
			'small-term-badge-count' => 1,
		),
		'listing-mix-3-3'       => array(
			'big-term-badge-count' => 1,
		),
		'listing-mix-3-4'       => array(
			'big-term-badge-count' => 1,
		),
		'listing-mix-4-1'       => array(
			'big-term-badge-count'   => 1,
			'small-term-badge-count' => 1,
		),
		'listing-mix-4-2'       => array(
			'big-term-badge-count'   => 1,
			'small-term-badge-count' => 1,
		),
		'listing-mix-4-3'       => array(
			'big-term-badge-count'   => 1,
			'small-term-badge-count' => 1,
		),
		'listing-mix-4-4'       => array(
			'big-term-badge-count'   => 1,
			'small-term-badge-count' => 1,
		),
		'listing-mix-4-5'       => array(
			'big-term-badge-count'   => 1,
			'small-term-badge-count' => 1,
		),
		'listing-mix-4-6'       => array(
			'big-term-badge-count'   => 1,
			'small-term-badge-count' => 1,
		),
		'listing-mix-4-7'       => array(
			'big-term-badge-count'   => 1,
			'small-term-badge-count' => 1,
		),
		'listing-mix-4-8'       => array(
			'big-term-badge-count'   => 1,
			'small-term-badge-count' => 1,
		),
		'listing-grid-1'        => array(
			'term-badge-count' => 1,
		),
		'listing-grid-2'        => array(
			'term-badge-count' => 1,
		),
		'listing-blog-1'        => array(
			'term-badge-count' => 1,
		),
		'listing-blog-2'        => array(
			'term-badge-count' => 1,
		),
		'listing-blog-3'        => array(
			'term-badge-count' => 1,
		),
		'listing-blog-4'        => array(
			'term-badge-count' => 1,
		),
		'listing-blog-5'        => array(
			'term-badge-count' => 1,
		),
		'listing-thumbnail-2'   => array(
			'term-badge-count' => 1,
		),
		'listing-text-1'        => array(
			'term-badge-count' => 1,
		),
		'listing-classic-1'     => array(
			'term-badge-count' => 1,
		),
		'listing-classic-2'     => array(
			'term-badge-count' => 1,
		),
		'listing-classic-3'     => array(
			'term-badge-count' => 1,
		),
		'listing-tall-1'        => array(
			'term-badge-count' => 1,
		),
		'listing-tall-2'        => array(
			'term-badge-count' => 1,
		),
		'blocks-related-posts'  => array(
			'term-badge-count' => 1,
		),
		'blocks-mega-menu'      => array(
			'term-badge-count' => 1,
		),
	);

	foreach ( $keys as $field_id => $elements ) {
		if ( ! isset( $option[ $field_id ] ) ) {
			$option[ $field_id ] = $fields[ $field_id ]['std'];
		} else {
			foreach ( (array) $elements as $el => $vl ) {
				$option[ $field_id ][ $el ] = $vl;
			}
		}
	}

	update_option( publisher_get_theme_panel_id(), $option );

	return TRUE;
}


/**
 * Compatibility for versions before 1.6.0
 *
 * @return bool
 */
function publisher_version_1_6_compatibility() {

	$fields = array();
	include PUBLISHER_THEME_PATH . 'includes/options/panel-std.php';

	$demo = publisher_get_style() . '-' . publisher_get_demo_id();

	$std_id = 'std-' . publisher_get_style();

	$option = get_option( publisher_get_theme_panel_id() );

	/**
	 * Merge all block options with std values
	 */
	$blocks = array(
		'listing-modern-grid-1',
		'listing-modern-grid-2',
		'listing-modern-grid-3',
		'listing-modern-grid-4',
		'listing-modern-grid-5',
		'listing-modern-grid-6',
		'listing-modern-grid-7',
		'listing-modern-grid-8',
		'listing-modern-grid-9',
		'listing-modern-grid-10',
		'listing-mix-1-1',
		'listing-mix-1-2',
		'listing-mix-1-3',
		'listing-mix-1-4',
		'listing-mix-2-1',
		'listing-mix-2-2',
		'listing-mix-3-1',
		'listing-mix-3-2',
		'listing-mix-3-3',
		'listing-mix-3-4',
		'listing-mix-4-1',
		'listing-mix-4-2',
		'listing-mix-4-3',
		'listing-mix-4-4',
		'listing-mix-4-5',
		'listing-mix-4-6',
		'listing-mix-4-7',
		'listing-mix-4-8',
		'listing-grid-1',
		'listing-grid-2',
		'listing-blog-1',
		'listing-blog-2',
		'listing-blog-3',
		'listing-blog-4',
		'listing-blog-5',
		'listing-thumbnail-1',
		'listing-thumbnail-2',
		'listing-thumbnail-3',
		'listing-text-1',
		'listing-text-2',
		'listing-classic-1',
		'listing-classic-2',
		'listing-classic-3',
		'listing-tall-1',
		'listing-tall-2',
		'blocks-related-posts',
		'blocks-mega-menu',
	);

	foreach ( $blocks as $id ) {
		if ( isset( $option[ $id ] ) ) {
			if ( isset( $fields[ $id ][ $std_id ] ) ) {
				$option[ $id ] = bf_array_replace_recursive( $fields[ $id ][ $std_id ], $option[ $id ] );
			} else {
				$option[ $id ] = bf_array_replace_recursive( $fields[ $id ]['std'], $option[ $id ] );
			}
		}
	}

	// Section heading typo
	if ( isset( $option['typo_section_heading'] ) ) {

		// clean mag
		if ( $demo == 'clean-magazine' && $option['typo_section_heading']['family'] == 'Roboto' ) {
			$option['typo_section_heading']['size']        = 20;
			$option['typo_section_heading']['line_height'] = 22;
			$option['typo_section_heading']['variant']     = '500';
			$option['typo_section_heading']['transform']   = 'capitalize';
		} // clean blog
		elseif ( $demo == 'clean-blog' && $option['typo_section_heading']['family'] == 'Noto Sans' && $option['typo_section_heading']['size'] == '13' && $option['typo_section_heading']['variant'] == 'regular' ) {
			$option['typo_section_heading']['size']        = 14;
			$option['typo_section_heading']['variant']     = '700';
			$option['typo_section_heading']['line_height'] = '30';
		} // clean video
		elseif ( $demo == 'clean-video' && $option['typo_section_heading']['family'] == 'Noto Sans' && $option['typo_section_heading']['size'] == '12' && $option['typo_section_heading']['variant'] == '700' ) {
			$option['typo_section_heading']['size']        = 16;
			$option['typo_section_heading']['line_height'] = '30';
		}

	} else {
		if ( isset( $fields['typo_section_heading'][ $std_id ] ) ) {
			$option['typo_section_heading'] = $fields['typo_section_heading'][ $std_id ];
		} else {
			$option['typo_section_heading'] = $fields['typo_section_heading']['std'];
		}
	}


	// Widget heading typo
	if ( isset( $option['typo_widget_title'] ) ) {

		// clean mag
		if ( $demo == 'clean-magazine' && $option['typo_widget_title']['family'] == 'Roboto' ) {
			$option['typo_widget_title']['size']        = 20;
			$option['typo_widget_title']['line_height'] = 22;
			$option['typo_widget_title']['variant']     = '500';
			$option['typo_widget_title']['transform']   = 'capitalize';
		} // clean blog
		elseif ( $option['typo_widget_title']['family'] == 'Noto Sans' && $option['typo_widget_title']['size'] == '13' && $option['typo_widget_title']['variant'] == 'regular' ) {
			$option['typo_widget_title']['size']        = 14;
			$option['typo_widget_title']['variant']     = '700';
			$option['typo_widget_title']['line_height'] = '30';
		} // clean video
		elseif ( $option['typo_widget_title']['family'] == 'Noto Sans' && $option['typo_widget_title']['size'] == '12' && $option['typo_widget_title']['variant'] == '700' ) {
			$option['typo_widget_title']['size']        = 16;
			$option['typo_widget_title']['line_height'] = '30';
		}

	} else {
		if ( isset( $fields['typo_widget_title'][ $std_id ] ) ) {
			$option['typo_widget_title'] = $fields['typo_widget_title'][ $std_id ];
		} else {
			$option['typo_widget_title'] = $fields['typo_widget_title']['std'];
		}
	}


	// Clean Magazine section heading colors
	if ( $demo == 'clean-magazine' ) {
		if ( $option['section_title_bg_color'] === '#444444' ) {
			$option['section_title_bg_color'] = 'rgba(0, 0, 0, 0.08)';
		}

		if ( $option['section_title_color'] === '#ffffff' ) {
			$option['section_title_color'] = '#444444';
		}

		if ( $option['widget_title_bg_color'] === '#0080ce' ) {
			$option['widget_title_bg_color'] = 'rgba(0, 0, 0, 0.08)';
		} elseif ( $option['widget_title_bg_color'] == $option['theme_color'] ) {
			$option['widget_title_bg_color'] = 'rgba(0, 0, 0, 0.08)';
			$option['widget_title_color']    = $option['theme_color'];
		}

		if ( $option['widget_title_color'] === '#ffffff' ) {
			$option['widget_title_color'] = '#444444';
		}

		if ( $option['typ_header_menu']['family'] == 'Roboto' && $option['typ_header_menu']['size'] == '15' ) {
			$option['typ_header_menu']['size']      = '16';
			$option['typ_header_menu']['transform'] = 'capitalize';
		}

	} elseif ( $demo == 'clean-blog' || $demo == 'clean-video' ) {

		if ( $option['section_title_color'] === '#ffffff' ) {
			$option['section_title_color'] = $option['section_title_bg_color'];
		}

		if ( $option['widget_title_color'] === '#ffffff' ) {
			$option['widget_title_color'] = $option['widget_title_bg_color'];
		}
	}


	// Resets new elements typo settings to relevant elements that is changed before
	// it's done because if user is selected new typo the new elements typo should be same as the user customization.
	$typo_keys = array(
		'typo_mg_7_title'  => 'typo_mg_1_title',
		'typo_mg_8_title'  => 'typo_mg_1_title',
		'typo_mg_9_title'  => 'typo_mg_2_title',
		'typo_mg_10_title' => 'typo_mg_2_title',
	);

	foreach ( $typo_keys as $field_id => $fallback_field ) {
		if ( isset( $option[ $fallback_field ] ) ) {
			$option[ $field_id ] = $option[ $fallback_field ];;
		} else {
			$option[ $field_id ] = $fields[ $field_id ]['std'];
		}
	}


	unset( $fields );
	update_option( publisher_get_theme_panel_id(), $option );

	return TRUE;
}


/**
 * Compatibility for versions before 1.7.0
 *
 * @return bool
 */
function publisher_version_1_7_compatibility() {

	$fields = array();
	include PUBLISHER_THEME_PATH . 'includes/options/panel-std.php';

	$theme_panel_id = publisher_get_theme_panel_id();

	// All current active langs
	$all_langs = bf_get_all_languages();

	// Default is English
	if ( empty( $all_langs ) ) {
		$all_langs = array(
			array(
				'id' => 'en',
			)
		);
	}


	//
	// Styles new structure migration (with support of multilingual)
	//
	{
		// current lang style or default none lang
		$raw_style = get_option( $theme_panel_id . '_current_style' );
		$raw_demo  = get_option( $theme_panel_id . '_current_demo' );

		if ( empty( $raw_demo ) ) {
			$raw_demo = 'magazine';
		} else {
			if ( $raw_style === 'pure' ) {
				if ( $raw_demo != 'magazine' ) {
					$raw_demo = 'magazine';
				}
			} elseif ( $raw_style === 'classic' ) {
				if ( $raw_demo != 'magazine' && $raw_demo != 'blog' ) {
					$raw_demo = 'magazine';
				}
			}
		}

		$full_style = $raw_style . '-' . $raw_demo;

		foreach ( $all_langs as $lang ) {

			if ( $lang['id'] == 'en' || $lang == 'all' ) {

				// update style and demo id for global lang (En)
				update_option( $theme_panel_id . '_current_style', $full_style );
				update_option( $theme_panel_id . '_current_demo', $full_style );
				continue;

			} else {
				$_lang = '_' . $lang['id'];
			}

			$_raw_style = get_option( $theme_panel_id . $_lang . '_current_style' );
			$_raw_demo  = get_option( $theme_panel_id . $_lang . '_current_demo' );

			if ( empty( $raw_demo ) ) {
				$_raw_demo = 'magazine';
			} else {

				if ( $_raw_style === 'pure' ) {
					if ( $_raw_demo != 'magazine' ) {
						$_raw_demo = 'magazine';
					}
				} elseif ( $_raw_style === 'classic' ) {
					if ( $_raw_demo != 'magazine' && $_raw_demo != 'blog' ) {
						$_raw_demo = 'magazine';
					}
				}
			}

			$_full_style = $_raw_style . '-' . $_raw_demo;

			$_check = array(
				'default-'                      => 'clean-magazine',
				'clean-clean-magazine'          => 'clean-magazine',
				'clean-magazine-magazine'       => 'clean-magazine',
				'clean-magazine-clean-magazine' => 'clean-magazine',
				'classic-classic-magazine'      => 'classic-magazine',
				'classic-magazine-magazine'     => 'classic-magazine',
				'pure-pure-magazine'            => 'pure-magazine',
				'pure-magazine-magazine'        => 'pure-magazine',
			);

			if ( isset( $_check[ $_full_style ] ) ) {
				$_full_style = $_check[ $_full_style ];
			}

			update_option( $theme_panel_id . $_lang . '_current_style', $_full_style );
			update_option( $theme_panel_id . $_lang . '_current_demo', $_full_style );
		}

	} // style migration


	//
	// Languages compatibility
	//
	{
		// Do compatibility for all languages
		foreach ( $all_langs as $lang ) {

			if ( $lang['id'] == 'en' || $lang == 'all' ) {
				$_lang = '';

				$style = $demo = get_option( $theme_panel_id . '_current_style' );

			} else {
				$_lang = '_' . $lang['id'];
				$style = $demo = get_option( $theme_panel_id . $_lang . '_current_style' );
			}

			$option = get_option( $theme_panel_id . $_lang );

			//
			// Theme options compatibility
			//
			{

				// update panel style field
				$option['style'] = $style;

				// avatar
				if ( isset( $option['post-page-settings'] ) ) {
					$option['post-page-settings']['meta']['author_avatar'] = 1;
				} else {
					$option['post-page-settings'] = $fields['post-page-settings']['std'];
				}

				// Text listing 3 and 4 typo
				if ( isset( $option['typo_text_listing_1_title'] ) ) {
					$_typo          = $option['typo_text_listing_1_title'];
					$_typo['align'] = 'inherit';

					$_check = array(
						'pure-magazine' => 'pure-magazine',
						'clean-tech'    => 'clean-tech',
					);

					if ( isset( $_check[ $style ] ) ) {
						$_typo['size'] -= 1;
						$_typo['line_height'] -= 2;
					}

					$option['typo_text_listing_3_title'] = $option['typo_text_listing_4_title'] = $_typo;
				}


				// Custom site width
				if ( isset( $option['site_box_width'] ) && strpos( $option['site_box_width'], 'px' ) ) {
					$option['layout-2-col'] = array(
						'width'   => str_replace( 'px', '', $option['site_box_width'] ),
						'content' => 67,
						'primary' => 33,
					);
				}

				// Columns gap fix
				if ( $style === 'clean-tech' ) {
					$option['layout_columns_space'] = '18';
				} elseif ( $style == 'clean-design' ) {
					$option['layout_columns_space'] = '16';
				}

				// Site Width size
				if ( $style === 'classic-blog' || $style === 'clean-blog' ) {
					$option['layout-2-col'] = array(
						'width'   => 1040,
						'content' => 67,
						'primary' => 33,
					);
				}

			} // Theme options compatibility


			// Update changed option
			update_option( $theme_panel_id . $_lang, $option );

		} // foreach

	}

	unset( $fields );
	unset( $all_langs );

	return TRUE;
}


/**
 * Compatibility for versions before 1.7.1
 *
 * @return bool
 */
function publisher_version_1_7_1_compatibility() {

	$fields = array();
	include PUBLISHER_THEME_PATH . 'includes/options/panel-std.php';

	$theme_panel_id = publisher_get_theme_panel_id();

	// All current active langs
	$all_langs = bf_get_all_languages();

	// Default is English
	if ( empty( $all_langs ) ) {
		$all_langs = array(
			array(
				'id' => 'en',
			)
		);
	}

	//
	// Languages compatibility
	//
	{
		// Do compatibility for all languages
		foreach ( $all_langs as $lang ) {

			if ( $lang['id'] == 'en' || $lang == 'all' ) {
				$_lang = '';
			} else {
				$_lang = '_' . $lang['id'];
			}

			$option = get_option( $theme_panel_id . $_lang );

			//
			// Theme options compatibility
			//
			{

				// share sites
				if ( isset( $option['social_share_sites'] ) ) {
					$option['social_share_sites']['line']  = FALSE;
					$option['social_share_sites']['bbm']   = FALSE;
					$option['social_share_sites']['viber'] = FALSE;
				} else {
					$option['social_share_sites'] = $fields['social_share_sites']['std'];
				}


			} // Theme options compatibility


			// Update changed option
			update_option( $theme_panel_id . $_lang, $option );

		} // foreach

	}

	unset( $fields );
	unset( $all_langs );

	return TRUE;
}


/**
 * Compatibility for versions before 1.7.5
 *
 * @return bool
 */
function publisher_version_1_7_5_compatibility() {

	$fields = array();
	include PUBLISHER_THEME_PATH . 'includes/options/panel-std.php';

	$theme_panel_id = publisher_get_theme_panel_id();

	// All current active langs
	$all_langs = bf_get_all_languages();

	// Default is English
	if ( empty( $all_langs ) ) {
		$all_langs = array(
			array(
				'id' => 'en',
			)
		);
	}

	//
	// Languages compatibility
	//
	{
		// Do compatibility for all languages
		foreach ( $all_langs as $lang ) {

			if ( $lang['id'] == 'en' || $lang == 'all' ) {
				$_lang = '';
			} else {
				$_lang = '_' . $lang['id'];
			}

			$option = get_option( $theme_panel_id . $_lang );

			//
			// Theme options compatibility
			//
			{

				// date type
				if ( isset( $option['post-page-settings'] ) ) {
					$option['post-page-settings']['meta']['date_type'] = 'one';
				} else {
					$option['post-page-settings'] = $fields['post-page-settings']['std'];
				}


			} // Theme options compatibility


			// Update changed option
			update_option( $theme_panel_id . $_lang, $option );

		} // foreach

	}

	unset( $fields );
	unset( $all_langs );

	return TRUE;
}


/**
 * Compatibility for versions before 1.8.0
 *
 * @return bool
 */
function publisher_version_1_8_0_compatibility() {

	$fields = array();
	include PUBLISHER_THEME_PATH . 'includes/options/panel-std.php';

	$theme_panel_id = publisher_get_theme_panel_id();

	// All current active langs
	$all_langs = bf_get_all_languages();

	// Default is English
	if ( empty( $all_langs ) ) {
		$all_langs = array(
			array(
				'id' => 'en',
			)
		);
	}

	//
	// Languages compatibility
	//
	{
		// Do compatibility for all languages
		foreach ( $all_langs as $lang ) {

			if ( $lang['id'] == 'en' || $lang == 'all' ) {
				$_lang = '';
			} else {
				$_lang = '_' . $lang['id'];
			}

			$option = get_option( $theme_panel_id . $_lang );

			//
			// Theme options compatibility
			//
			{

				// All fields that have to merged for new keys
				$keys = array(
					// Blocks fields
					'listing-modern-grid-1',
					'listing-modern-grid-2',
					'listing-modern-grid-3',
					'listing-modern-grid-4',
					'listing-modern-grid-5',
					'listing-modern-grid-6',
					'listing-modern-grid-7',
					'listing-modern-grid-8',
					'listing-modern-grid-9',
					'listing-modern-grid-10',
					'listing-mix-1-1',
					'listing-mix-1-2',
					'listing-mix-1-3',
					'listing-mix-1-4',
					'listing-mix-2-1',
					'listing-mix-2-2',
					'listing-mix-3-1',
					'listing-mix-3-2',
					'listing-mix-3-3',
					'listing-mix-3-4',
					'listing-mix-4-1',
					'listing-mix-4-2',
					'listing-mix-4-3',
					'listing-mix-4-4',
					'listing-mix-4-5',
					'listing-mix-4-6',
					'listing-mix-4-7',
					'listing-mix-4-8',
					'listing-grid-1',
					'listing-grid-2',
					'listing-blog-1',
					'listing-blog-2',
					'listing-blog-3',
					'listing-blog-4',
					'listing-blog-5',
					'listing-thumbnail-1',
					'listing-thumbnail-2',
					'listing-thumbnail-3',
					'listing-text-1',
					'listing-text-2',
					'listing-text-3',
					'listing-text-4',
					'listing-classic-1',
					'listing-classic-2',
					'listing-classic-3',
					'listing-tall-1',
					'listing-tall-2',
					'blocks-related-posts',
					'blocks-mega-menu',
					// post page settings
					'post-page-settings',
					// Typo
					'typo_text_listing_1_title',
					'typo_text_listing_2_title',
					'typo_text_listing_3_title',
				);

				// Save new changes into saved data
				foreach ( $keys as $field_id ) {
					if ( ! isset( $option[ $field_id ] ) ) {
						$option[ $field_id ] = $fields[ $field_id ]['std'];
					} else {
						$option[ $field_id ] = array_replace_recursive( $fields[ $field_id ]['std'], $option[ $field_id ] );
					}
				}


				// New single summary
				if ( ! isset( $option['typo_post_summary_single'] ) && isset( $option['typo_post_summary'] ) ) {

					$summary = $option['typo_post_summary'];

					unset( $summary['color'] );
					$summary['size']        = intval( $summary['size'] ) + 2;
					$summary['line_height'] = intval( $summary['line_height'] ) + 3;

					$option['typo_post_summary_single'] = $summary;
					unset( $summary );
				}

			} // Theme options compatibility


			// Update changed option
			update_option( $theme_panel_id . $_lang, $option );

		} // foreach

	}

	unset( $fields );
	unset( $all_langs );


	//
	// Convert Custom User Avatar URL to Attachment ID
	//

	$users = get_users( array(
		'meta_key'     => 'avatar',
		'meta_compare' => '!=',
		'meta_value'   => ' ',
		'number'       => 10,
		'fields'       => 'ID'
	) );

	foreach ( $users as $user_id ) {

		$avatar_url = get_user_meta( $user_id, 'avatar', TRUE );

		if ( filter_var( $avatar_url, FILTER_VALIDATE_URL ) ) {

			if ( $attachment_id = bf_get_attachment_id_by_url( $avatar_url, TRUE ) ) {

				update_user_meta( $user_id, 'avatar', $attachment_id, $avatar_url );
			}
		}
	}

	return TRUE;
}

function publisher_version_1_8_4_compatibility() {

	$fields = array();
	include PUBLISHER_THEME_PATH . 'includes/options/panel-std.php';

	$theme_panel_id = publisher_get_theme_panel_id();

	// All current active langs
	$all_langs = bf_get_all_languages();

	// Default is English
	if ( empty( $all_langs ) ) {
		$all_langs = array(
			array(
				'id' => 'en',
			)
		);
	}

	//
	// Languages compatibility
	//
	{
		// Do compatibility for all languages
		foreach ( $all_langs as $lang ) {

			if ( $lang['id'] == 'en' || $lang == 'all' ) {
				$_lang = '';
			} else {
				$_lang = '_' . $lang['id'];
			}

			$option = get_option( $theme_panel_id . $_lang );

			//
			// Theme options compatibility
			//
			{

				// All fields that have to merged for new keys
				$keys = array(
					// Blocks fields
					'listing-modern-grid-1',
					'listing-modern-grid-2',
					'listing-modern-grid-3',
					'listing-modern-grid-4',
					'listing-modern-grid-5',
					'listing-modern-grid-6',
					'listing-modern-grid-7',
					'listing-modern-grid-8',
					'listing-modern-grid-9',
					'listing-modern-grid-10',
					'listing-mix-1-1',
					'listing-mix-1-2',
					'listing-mix-1-3',
					'listing-mix-1-4',
					'listing-mix-2-1',
					'listing-mix-2-2',
					'listing-mix-3-1',
					'listing-mix-3-2',
					'listing-mix-3-3',
					'listing-mix-3-4',
					'listing-mix-4-1',
					'listing-mix-4-2',
					'listing-mix-4-3',
					'listing-mix-4-4',
					'listing-mix-4-5',
					'listing-mix-4-6',
					'listing-mix-4-7',
					'listing-mix-4-8',
					'listing-grid-1',
					'listing-grid-2',
					'listing-blog-1',
					'listing-blog-2',
					'listing-blog-3',
					'listing-blog-4',
					'listing-blog-5',
					'listing-thumbnail-1',
					'listing-thumbnail-2',
					'listing-thumbnail-3',
					'listing-text-1',
					'listing-text-2',
					'listing-text-3',
					'listing-text-4',
					'listing-classic-1',
					'listing-classic-2',
					'listing-classic-3',
					'listing-tall-1',
					'listing-tall-2',
					'blocks-related-posts',
					'blocks-mega-menu',
				);

				// Save new changes into saved data
				foreach ( $keys as $field_id ) {
					if ( ! isset( $option[ $field_id ] ) ) {
						$option[ $field_id ] = $fields[ $field_id ]['std'];
					} else {
						$option[ $field_id ] = array_replace_recursive( $fields[ $field_id ]['std'], $option[ $field_id ] );
					}
				}

			} // Theme options compatibility


			// Update changed option
			update_option( $theme_panel_id . $_lang, $option );

		} // foreach

	}

	unset( $fields );
	unset( $all_langs );
}
