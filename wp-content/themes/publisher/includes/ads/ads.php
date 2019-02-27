<?php

if ( ! function_exists( 'publisher_is_ad_plugin_active' ) ) {
	/**
	 * Detect the BetterAds manager v1.4 is active or not
	 *
	 * @return bool
	 */
	function publisher_is_ad_plugin_active() {
		return class_exists( 'Better_Ads_Manager' ) && function_exists( 'better_ads_inject_ad_field_to_fields' );
	}
}


if ( ! function_exists( 'publisher_get_ad_location_data' ) ) {
	/**
	 * Return data of Ad location by its ID prefix
	 *
	 * @param string $ad_location_prefix
	 *
	 * @return array
	 */
	function publisher_get_ad_location_data( $ad_location_prefix = '' ) {

		if ( ! publisher_is_ad_plugin_active() ) {
			return array(
				'type'            => '',
				'banner'          => '',
				'campaign'        => '',
				'count'           => '',
				'columns'         => '',
				'orderby'         => '',
				'order'           => '',
				'align'           => '',
				'active_location' => '',
			);
		}

		return better_ads_get_ad_location_data( $ad_location_prefix );
	}
}


if ( ! function_exists( 'publisher_show_ad_location' ) ) {
	/**
	 * Return data of Ad location by its ID prefix
	 *
	 * @param string $ad_location_prefix
	 * @param array  $args
	 *
	 * @return array
	 */
	function publisher_show_ad_location( $ad_location_prefix = '', $args = array() ) {

		if ( ! publisher_is_ad_plugin_active() ) {
			return;
		}

		// get data if not passed
		if ( empty( $args['ad-data'] ) ) {
			$ad = publisher_get_ad_location_data( $ad_location_prefix );
		} else {
			$ad = $args['ad-data'];
		}

		// Ads advanced classes for banner type
		if ( $ad['active_location'] && $ad['type'] == 'banner' ) {

			$ad_data = Better_Ads_Manager()->get_banner_data( $ad['banner'] );

			if ( empty( $args['container-class'] ) ) {
				$args['container-class'] = 'adloc-is-banner';
			} else {
				$args['container-class'] .= ' adloc-is-banner';
			}

			if ( $ad_data['show_desktop'] ) {
				$args['container-class'] .= ' adloc-show-desktop';
			}

			if ( ! empty( $ad_data['show_tablet_portrait'] ) ) {
				$args['container-class'] .= ' adloc-show-tablet-portrait';
			}

			if ( ! empty( $ad_data['show_tablet_landscape'] ) ) {
				$args['container-class'] .= ' adloc-show-tablet-landscape';
			}

			if ( $ad_data['show_phone'] ) {
				$args['container-class'] .= ' adloc-show-phone';
			}
		}

		if ( $ad['active_location'] ) {

			if ( empty( $args['container-class'] ) ) {
				$args['container-class'] = '';
			}

			if ( ! empty( $args['before'] ) ) {
				echo $args['before'];
			}

			better_ads_show_ad_location( $ad_location_prefix, $ad, array(
				'container-class' => $args['container-class']
			) );

			if ( ! empty( $args['after'] ) ) {
				echo $args['after'];
			}
		}
	}
}


// Only when BetterAds v1.4 installed
if ( ! publisher_is_ad_plugin_active() ) {
	return;
}


add_filter( 'better-framework/panel/better_ads_manager/fields', 'publisher_better_ads_options_top', 10 );

if ( ! function_exists( 'publisher_better_ads_options_top' ) ) {
	/**
	 * Publisher ads
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	function publisher_better_ads_options_top( $fields ) {

		/**
		 *
		 * Header Ads
		 *
		 */
		$fields[] = array(
			'name' => __( 'Header Ads', 'publisher' ),
			'id'   => 'header_ads',
			'type' => 'tab',
			'icon' => 'bsai-header',
		);

		$fields[] = array(
			'name'   => __( 'Header Style 2 & 3', 'publisher' ),
			'type'   => 'heading',
			'layout' => 'style-2',
		);

		better_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'       => TRUE,
				'group_title' => __( 'Aside Logo Ad', 'publisher' ),
				'group_state' => 'close',
				'id_prefix'   => 'header_aside_logo',
			)
		);


		$fields[] = array(
			'name'   => __( 'Header Style 1, 4 & 7', 'publisher' ),
			'type'   => 'heading',
			'layout' => 'style-2',
		);

		better_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'       => TRUE,
				'group_title' => __( 'Header Left Ad', 'publisher' ),
				'group_state' => 'close',
				'id_prefix'   => 'header_aside_logo_left',
			)
		);

		better_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'       => TRUE,
				'group_title' => __( 'Header Right Ad', 'publisher' ),
				'group_state' => 'close',
				'id_prefix'   => 'header_aside_logo_right',
			)
		);


		$fields[] = array(
			'name'   => __( 'General Header', 'publisher' ),
			'type'   => 'heading',
			'layout' => 'style-2',
		);


		better_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'       => TRUE,
				'group_title' => __( 'After Header', 'publisher' ),
				'group_state' => 'close',
				'id_prefix'   => 'header_after',
			)
		);

		return $fields;
	}
}


add_filter( 'better-framework/panel/better_ads_manager/fields', 'publisher_better_ads_options_bottom', 50 );

if ( ! function_exists( 'publisher_better_ads_options_bottom' ) ) {
	/**
	 * Publisher ads
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	function publisher_better_ads_options_bottom( $fields ) {

		$fields[] = array(
			'name'   => __( 'Publisher Post Ads', 'publisher' ),
			'type'   => 'heading',
			'layout' => 'style-2',
		);

		better_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'        => TRUE,
				'group_title'  => __( 'Above Post (Top of post before everything)', 'publisher' ),
				'group_state'  => 'close',
				'id_prefix'    => 'post_box_above',
				'start_fields' => array(
					'post_box_above_note' => array(
						'name'      => __( 'Please Note', 'publisher' ),
						'id'        => 'post_box_above_note',
						'type'      => 'info',
						'std'       => __( 'This will be shown in top of post (before title and featured image).', 'publisher' ) .
						               __( '<br><br><strong style="color: red;">Important 1:</strong> Please note this can make a conflict with "After Header" ad location in this post templates: 2, 3, 4, 5, 6, 7, 12 and 13', 'publisher' ) .
						               __( '<br><br><strong style="color: red;">Important 2:</strong> This ad will be shown after header in responsive design (small screen size) and all post template will have conflict with "After Header" ad location.', 'publisher' ),
						'state'     => 'open',
						'info-type' => 'warning',
						'ad-id'     => 'post_box_above',
					)
				),
			)
		);


		better_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'        => TRUE,
				'group_title'  => __( 'Between Featured Image & Post Title', 'publisher' ),
				'group_state'  => 'close',
				'id_prefix'    => 'post_between_featured_title',
				'start_fields' => array(
					'post_between_featured_logo_note' => array(
						'name'      => __( 'Please Note', 'publisher' ),
						'id'        => 'post_before_author_box_note',
						'type'      => 'info',
						'std'       => __( 'This will be shown only in post templates 1, 10, 12 and 13 and will not be shown in other post templates.', 'publisher' ),
						'state'     => 'open',
						'info-type' => 'warning',
						'ad-id'     => 'post_before_author_box',
					)
				),
			)
		);


		better_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'        => TRUE,
				'group_title'  => __( 'After Tags, Before Author Box', 'publisher' ),
				'group_state'  => 'close',
				'id_prefix'    => 'post_before_author_box',
				'start_fields' => array(
					'post_before_author_box_note' => array(
						'name'      => __( 'Please Note', 'publisher' ),
						'id'        => 'post_before_author_box_note',
						'type'      => 'info',
						'std'       => __( 'This will be shown before Author box and right after the Tags and if your post haven\'t tag then this will be the same as "<strong>Below Post Content</strong>".', 'publisher' ),
						'state'     => 'open',
						'info-type' => 'warning',
						'ad-id'     => 'post_before_author_box',
					)
				),
			)
		);


		better_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'       => TRUE,
				'group_title' => __( 'Ajax Related Posts - Between Posts', 'publisher' ),
				'group_state' => 'close',
				'id_prefix'   => 'post_ajax_related',
			)
		);


		/**
		 *
		 * Header Ads
		 *
		 */
		$fields[] = array(
			'name' => __( 'Footer Ads', 'publisher' ),
			'id'   => 'footer_ads',
			'type' => 'tab',
			'icon' => 'bsai-footer',
		);

		better_ads_inject_ad_field_to_fields(
			$fields,
			array(
				'group'       => TRUE,
				'group_title' => __( 'Before Footer Ad', 'publisher' ),
				'group_state' => 'close',
				'id_prefix'   => 'footer_before',
			)
		);

		return $fields;
	}
}

add_filter( 'better-framework/panel/better_ads_manager/std', 'publisher_better_ads_std', 33 );


/**
 * Ads STD
 *
 * @param $fields
 *
 * @return array
 */
function publisher_better_ads_std( $fields ) {

	//  header_aside_logo
	$fields['header_aside_logo_type']     = array(
		'std' => '',
	);
	$fields['header_aside_logo_banner']   = array(
		'std' => 'none',
	);
	$fields['header_aside_logo_campaign'] = array(
		'std' => 'none',
	);
	$fields['header_aside_logo_count']    = array(
		'std' => 1,
	);
	$fields['header_aside_logo_columns']  = array(
		'std' => 1,
	);
	$fields['header_aside_logo_orderby']  = array(
		'std' => 'rand',
	);
	$fields['header_aside_logo_order']    = array(
		'std' => 'ASC',
	);
	$fields['header_aside_logo_align']    = array(
		'std' => 'right',
	);

	//  header_aside_logo_left
	$fields['header_aside_logo_left_type']     = array(
		'std' => '',
	);
	$fields['header_aside_logo_left_banner']   = array(
		'std' => 'none',
	);
	$fields['header_aside_logo_left_campaign'] = array(
		'std' => 'none',
	);
	$fields['header_aside_logo_left_count']    = array(
		'std' => 1,
	);
	$fields['header_aside_logo_left_columns']  = array(
		'std' => 1,
	);
	$fields['header_aside_logo_left_orderby']  = array(
		'std' => 'rand',
	);
	$fields['header_aside_logo_left_order']    = array(
		'std' => 'ASC',
	);
	$fields['header_aside_logo_left_align']    = array(
		'std' => 'left',
	);

	//  header_aside_logo_right
	$fields['header_aside_logo_right_type']     = array(
		'std' => '',
	);
	$fields['header_aside_logo_right_banner']   = array(
		'std' => 'none',
	);
	$fields['header_aside_logo_right_campaign'] = array(
		'std' => 'none',
	);
	$fields['header_aside_logo_right_count']    = array(
		'std' => 1,
	);
	$fields['header_aside_logo_right_columns']  = array(
		'std' => 1,
	);
	$fields['header_aside_logo_right_orderby']  = array(
		'std' => 'rand',
	);
	$fields['header_aside_logo_right_order']    = array(
		'std' => 'ASC',
	);
	$fields['header_aside_logo_right_align']    = array(
		'std' => 'right',
	);


	//  header_after
	$fields['header_after_type']     = array(
		'std' => '',
	);
	$fields['header_after_banner']   = array(
		'std' => 'none',
	);
	$fields['header_after_campaign'] = array(
		'std' => 'none',
	);
	$fields['header_after_count']    = array(
		'std' => 1,
	);
	$fields['header_after_columns']  = array(
		'std' => 1,
	);
	$fields['header_after_orderby']  = array(
		'std' => 'rand',
	);
	$fields['header_after_order']    = array(
		'std' => 'ASC',
	);
	$fields['header_after_align']    = array(
		'std' => 'center',
	);


	//  post_box_above
	$fields['post_box_above_type']     = array(
		'std' => '',
	);
	$fields['post_box_above_banner']   = array(
		'std' => 'none',
	);
	$fields['post_box_above_campaign'] = array(
		'std' => 'none',
	);
	$fields['post_box_above_count']    = array(
		'std' => 1,
	);
	$fields['post_box_above_columns']  = array(
		'std' => 1,
	);
	$fields['post_box_above_orderby']  = array(
		'std' => 'rand',
	);
	$fields['post_box_above_order']    = array(
		'std' => 'ASC',
	);
	$fields['post_box_above_align']    = array(
		'std' => 'center',
	);


	//  post_before_author_box
	$fields['post_before_author_box_type']     = array(
		'std' => '',
	);
	$fields['post_before_author_box_banner']   = array(
		'std' => 'none',
	);
	$fields['post_before_author_box_campaign'] = array(
		'std' => 'none',
	);
	$fields['post_before_author_box_count']    = array(
		'std' => 1,
	);
	$fields['post_before_author_box_columns']  = array(
		'std' => 1,
	);
	$fields['post_before_author_box_orderby']  = array(
		'std' => 'rand',
	);
	$fields['post_before_author_box_order']    = array(
		'std' => 'ASC',
	);
	$fields['post_before_author_box_align']    = array(
		'std' => 'center',
	);


	//  post_between_featured_title
	$fields['post_between_featured_title_type']     = array(
		'std' => '',
	);
	$fields['post_between_featured_title_banner']   = array(
		'std' => 'none',
	);
	$fields['post_between_featured_title_campaign'] = array(
		'std' => 'none',
	);
	$fields['post_between_featured_title_count']    = array(
		'std' => 1,
	);
	$fields['post_between_featured_title_columns']  = array(
		'std' => 1,
	);
	$fields['post_between_featured_title_orderby']  = array(
		'std' => 'rand',
	);
	$fields['post_between_featured_title_order']    = array(
		'std' => 'ASC',
	);
	$fields['post_between_featured_title_align']    = array(
		'std' => 'center',
	);


	//  post_ajax_related
	$fields['post_ajax_related_type']     = array(
		'std' => '',
	);
	$fields['post_ajax_related_banner']   = array(
		'std' => 'none',
	);
	$fields['post_ajax_related_campaign'] = array(
		'std' => 'none',
	);
	$fields['post_ajax_related_count']    = array(
		'std' => 1,
	);
	$fields['post_ajax_related_columns']  = array(
		'std' => 1,
	);
	$fields['post_ajax_related_orderby']  = array(
		'std' => 'rand',
	);
	$fields['post_ajax_related_order']    = array(
		'std' => 'ASC',
	);
	$fields['post_ajax_related_align']    = array(
		'std' => 'center',
	);


	//  footer_before
	$fields['footer_before_type']     = array(
		'std' => '',
	);
	$fields['footer_before_banner']   = array(
		'std' => 'none',
	);
	$fields['footer_before_campaign'] = array(
		'std' => 'none',
	);
	$fields['footer_before_count']    = array(
		'std' => 1,
	);
	$fields['footer_before_columns']  = array(
		'std' => 1,
	);
	$fields['footer_before_orderby']  = array(
		'std' => 'rand',
	);
	$fields['footer_before_order']    = array(
		'std' => 'ASC',
	);
	$fields['footer_before_align']    = array(
		'std' => 'center',
	);

	return $fields;
}
