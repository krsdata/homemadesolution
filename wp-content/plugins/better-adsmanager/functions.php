<?php


/**
 * Used to get array of key->name of campaigns
 *
 * @param int  $count
 * @param bool $empty_label
 *
 * @return array
 */
function better_ads_get_campaigns_option( $count = 10, $empty_label = FALSE ) {

	$args = array(
		'posts_per_page' => $count,
	);

	if ( $empty_label ) {
		return array( 'none' => __( '-- Select Campaign --', 'better-studio' ) ) + Better_Ads_Manager::get_campaigns( $args );
	} else {
		return Better_Ads_Manager::get_campaigns( $args );
	}

}


/**
 * Used to get array of key->name of banners
 *
 * @param int    $count
 * @param bool   $empty_label
 * @param string $format
 *
 * @param string $label_type
 *
 * @return array
 */
function better_ads_get_banners_option( $count = 10, $empty_label = FALSE, $format = 'normal', $label_type = 'type' ) {

	$args = array(
		'posts_per_page' => $count,
		'label_type'     => $label_type,
	);

	if ( $format === 'normal' ) {
		$args['meta_query'] = array(
			'relation' => 'OR',
			array(
				'key'   => 'format',
				'value' => '',
			),
			array(
				'key'     => 'format',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'   => 'format',
				'value' => 'normal',
			),
		);
	} elseif ( $format === 'amp' ) {
		$args['meta_query'] = array(
			array(
				'key'   => 'format',
				'value' => 'amp',
			),
		);
	}

	if ( $empty_label ) {
		return array( 'none' => __( '-- Select Banner --', 'better-studio' ) ) + Better_Ads_Manager::get_banners( $args );
	} else {
		return Better_Ads_Manager::get_banners( $args );
	}

}


/**
 * Handy function to add Ad location fields to panel by it's prefix
 *
 * @param       $fields
 * @param array $args
 */
function better_ads_inject_ad_field_to_fields( &$fields, $args = array() ) {

	if ( is_string( $args ) ) {
		$args = array(
			'id_prefix' => $args,
		);
	}

	$args = bf_merge_args( $args, array(
		'id_prefix'        => '',
		'group'            => TRUE,
		'group_state'      => 'open',
		'group_title'      => __( 'Ad', 'better-ads' ),
		'group_auto_close' => TRUE,
		'group_desc'       => '',
		'start_fields'     => '',
		'format'           => 'normal',
	) );

	if ( empty( $args['id_prefix'] ) ) {
		return;
	}

	if ( $args['group'] ) {
		$fields[ $args['id_prefix'] . '-group' ] = array(
			'id'              => $args['id_prefix'] . '-group',
			'name'            => $args['group_title'],
			'type'            => 'group',
			'state'           => $args['group_state'],
			'desc'            => $args['group_desc'],
			'container-class' => 'better-ads-ad-group-field',
		);
	}

	if ( ! empty( $args['start_fields'] ) ) {
		foreach ( (array) $args['start_fields'] as $field_id => $field_val ) {
			$fields[ $field_id ] = $field_val;
		}
	}

	$fields[ $args['id_prefix'] . '_type' ]     = array(
		'name'          => __( 'Ad Type', 'better-studio' ),
		'id'            => $args['id_prefix'] . '_type',
		'desc'          => __( 'Choose campaign or banner.', 'better-studio' ),
		'type'          => 'select',
		'std'           => '',
		'options'       => array(
			''         => __( '-- Select Ad type --', 'better-studio' ),
			'campaign' => __( 'Campaign', 'better-studio' ),
			'banner'   => __( 'Banner', 'better-studio' ),
		),
		'ad-id'         => $args['id_prefix'],
		'section_class' => 'better-ads-ad-field',
	);
	$fields[ $args['id_prefix'] . '_banner' ]   = array(
		'name'             => __( 'Banner', 'better-studio' ),
		'id'               => $args['id_prefix'] . '_banner',
		'desc'             => __( 'Choose banner.', 'better-studio' ),
		'type'             => 'select',
		'std'              => 'none',
		'deferred-options' => array(
			'callback' => 'better_ads_get_banners_option',
			'args'     => array(
				- 1,
				TRUE,
				$args['format']
			),
		),
		'show_on'          => array(
			array(
				$args['id_prefix'] . '_type=banner'
			),
		),
		'_show_on_parent'  => $args['id_prefix'] . '_type',
		'ad-id'            => $args['id_prefix'],
		'section_class'    => 'better-ads-ad-field',
	);
	$fields[ $args['id_prefix'] . '_campaign' ] = array(
		'name'             => __( 'Campaign', 'better-studio' ),
		'id'               => $args['id_prefix'] . '_campaign',
		'desc'             => __( 'Choose campaign.', 'better-studio' ),
		'type'             => 'select',
		'std'              => 'none',
		'deferred-options' => array(
			'callback' => 'better_ads_get_campaigns_option',
			'args'     => array(
				- 1,
				TRUE
			),
		),
		'show_on'          => array(
			array(
				$args['id_prefix'] . '_type=campaign'
			),
		),
		'_show_on_parent'  => $args['id_prefix'] . '_type',
		'ad-id'            => $args['id_prefix'],
		'section_class'    => 'better-ads-ad-field',
	);
	$fields[ $args['id_prefix'] . '_count' ]    = array(
		'name'            => __( 'Max Amount of Allowed Banners', 'better-studio' ),
		'id'              => $args['id_prefix'] . '_count',
		'desc'            => __( 'How many banners are allowed?.', 'better-studio' ),
		'input-desc'      => __( 'Leave empty to show all banners.', 'better-studio' ),
		'type'            => 'text',
		'std'             => 1,
		'show_on'         => array(
			array(
				$args['id_prefix'] . '_type=campaign'
			),
		),
		'_show_on_parent' => $args['id_prefix'] . '_type',
		'ad-id'           => $args['id_prefix'],
		'section_class'   => 'better-ads-ad-field',
	);
	$fields[ $args['id_prefix'] . '_columns' ]  = array(
		'name'            => __( 'Columns', 'better-studio' ),
		'id'              => $args['id_prefix'] . '_columns',
		'desc'            => __( 'Show ads in multiple columns.', 'better-studio' ),
		'type'            => 'select',
		"options"         => array(
			1 => __( '1 Column', 'better-studio' ),
			2 => __( '2 Column', 'better-studio' ),
			3 => __( '3 Column', 'better-studio' ),
		),
		'std'             => 1,
		'show_on'         => array(
			array(
				$args['id_prefix'] . '_type=campaign'
			),
		),
		'_show_on_parent' => $args['id_prefix'] . '_type',
		'ad-id'           => $args['id_prefix'],
		'section_class'   => 'better-ads-ad-field',
	);
	$fields[ $args['id_prefix'] . '_orderby' ]  = array(
		'name'            => __( 'Order By', 'better-studio' ),
		'id'              => $args['id_prefix'] . '_orderby',
		'type'            => 'select',
		"options"         => array(
			'date'  => __( 'Date', 'better-studio' ),
			'title' => __( 'Title', 'better-studio' ),
			'rand'  => __( 'Rand', 'better-studio' ),
		),
		'std'             => 'rand',
		'show_on'         => array(
			array(
				$args['id_prefix'] . '_type=campaign'
			),
		),
		'_show_on_parent' => $args['id_prefix'] . '_type',
		'ad-id'           => $args['id_prefix'],
		'section_class'   => 'better-ads-ad-field',
	);
	$fields[ $args['id_prefix'] . '_order' ]    = array(
		'name'            => __( 'Order', 'better-studio' ),
		'id'              => $args['id_prefix'] . '_order',
		'type'            => 'select',
		"options"         => array(
			'ASC'  => __( 'Ascending', 'better-studio' ),
			'DESC' => __( 'Descending', 'better-studio' ),
		),
		'std'             => 'ASC',
		'show_on'         => array(
			array(
				$args['id_prefix'] . '_type=campaign'
			),
		),
		'_show_on_parent' => $args['id_prefix'] . '_type',
		'ad-id'           => $args['id_prefix'],
		'section_class'   => 'better-ads-ad-field',
	);
	$fields[ $args['id_prefix'] . '_align' ]    = array(
		'name'            => __( 'Align', 'better-studio' ),
		'desc'            => __( 'Choose align of ad.', 'better-studio' ),
		'id'              => $args['id_prefix'] . '_align',
		'type'            => 'select',
		"options"         => array(
			'left'   => __( 'Left', 'better-studio' ),
			'center' => __( 'Center', 'better-studio' ),
			'right'  => __( 'Right', 'better-studio' ),
		),
		'std'             => 'center',
		'show_on'         => array(
			array(
				$args['id_prefix'] . '_type=banner',
			),
			array(
				$args['id_prefix'] . '_type=campaign',
			),
		),
		'_show_on_parent' => $args['id_prefix'] . '_type',
		'ad-id'           => $args['id_prefix'],
		'section_class'   => 'better-ads-ad-field',
	);

	if ( ! empty( $args['end_fields'] ) ) {
		foreach ( (array) $args['end_fields'] as $field_id => $field_val ) {
			$fields[ $field_id ] = $field_val;
		}
	}

	if ( $args['group'] && $args['group_auto_close'] ) {
		$fields[] = array(
			'type' => 'group_close',
		);
	}
}


/**
 * Handy function to add Ad location reperator ad field to panel by it's prefix
 *
 * @param       $fields
 * @param array $args
 */
function better_ads_inject_ad_repeater_field_to_fields( &$fields, $args = array() ) {

	if ( is_string( $args ) ) {
		$args = array(
			'id_prefix' => $args,
		);
	}

	$args = bf_merge_args( $args, array(
		'id_prefix'              => '',
		'group'                  => TRUE,
		'group_state'            => 'close',
		'group_title'            => __( 'Ad', 'better-studio' ),
		'group_auto_close'       => TRUE,
		'group_desc'             => '',
		'field_title'            => '',
		'field_desc'             => '',
		'field_add_label'        => '<i class="fa fa-plus"></i> ' . __( 'New Ad', 'better-studio' ),
		'field_delete_label'     => __( 'Delete Ad', 'better-studio' ),
		'field_item_title'       => __( 'Ad', 'better-studio' ),
		'field_item_smart_title' => TRUE,
		'start_fields'           => '',
		'format'                 => 'normal',
	) );

	if ( empty( $args['id_prefix'] ) ) {
		return;
	}

	if ( $args['group'] ) {
		$fields[] = array(
			'name'  => $args['group_title'],
			'type'  => 'group',
			'state' => $args['group_state'],
			'desc'  => $args['group_desc'],
		);
	}

	if ( ! empty( $args['start_fields'] ) ) {
		foreach ( (array) $args['start_fields'] as $field_id => $field_val ) {
			$fields[ $field_id ] = $field_val;
		}
	}

	$repeater_items = array();

	if ( ! empty( $args['field_start_fields'] ) ) {
		foreach ( (array) $args['field_start_fields'] as $field_id => $field_val ) {
			$repeater_items[ $field_id ] = $field_val;
		}
	}

	$repeater_items['type']     = array(
		'name'          => __( 'Ad Type', 'better-studio' ),
		'id'            => 'type',
		'desc'          => __( 'Choose campaign or banner.', 'better-studio' ),
		'type'          => 'select',
		'options'       => array(
			''         => __( '-- Select Ad Type --', 'better-studio' ),
			'campaign' => __( 'Campaign', 'better-studio' ),
			'banner'   => __( 'Banner', 'better-studio' ),
		),
		'repeater_item' => TRUE,
		'ad-id'         => $args['id_prefix'],
	);
	$repeater_items['campaign'] = array(
		'name'             => __( 'Campaign', 'better-studio' ),
		'id'               => 'campaign',
		'desc'             => __( 'Choose campaign.', 'better-studio' ),
		'type'             => 'select',
		'deferred-options' => array(
			'callback' => 'better_ads_get_campaigns_option',
			'args'     => array(
				- 1,
				TRUE,
				$args['format']
			),
		),
		'show_on'          => array(
			array(
				'type=campaign'
			),
		),
		'repeater_item'    => TRUE,
		'ad-id'            => $args['id_prefix'],
	);
	$repeater_items['banner']   = array(
		'name'             => __( 'Banner', 'better-studio' ),
		'id'               => 'banner',
		'desc'             => __( 'Choose banner.', 'better-studio' ),
		'type'             => 'select',
		'deferred-options' => array(
			'callback' => 'better_ads_get_banners_option',
			'args'     => array(
				- 1,
				TRUE,
				$args['format']
			),
		),
		'show_on'          => array(
			array(
				'type=banner'
			),
		),
		'repeater_item'    => TRUE,
		'ad-id'            => $args['id_prefix'],
	);
	$repeater_items['count']    = array(
		'name'          => __( 'Max Amount of Allowed Banners', 'better-studio' ),
		'id'            => 'count',
		'desc'          => __( 'How many banners are allowed?.', 'better-studio' ),
		'input-desc'    => __( 'Leave empty to show all banners.', 'better-studio' ),
		'type'          => 'text',
		'show_on'       => array(
			array(
				'type=campaign'
			),
		),
		'repeater_item' => TRUE,
		'ad-id'         => $args['id_prefix'],
	);
	$repeater_items['columns']  = array(
		'name'          => __( 'Columns', 'better-studio' ),
		'id'            => 'columns',
		'desc'          => __( 'Show ads in multiple columns.', 'better-studio' ),
		'type'          => 'select',
		"options"       => array(
			1 => __( '1 Column', 'better-studio' ),
			2 => __( '2 Column', 'better-studio' ),
			3 => __( '3 Column', 'better-studio' ),
		),
		'show_on'       => array(
			array(
				'type=campaign'
			),
		),
		'repeater_item' => TRUE,
		'ad-id'         => $args['id_prefix'],
	);
	$repeater_items['orderby']  = array(
		'name'          => __( 'Order By', 'better-studio' ),
		'id'            => 'orderby',
		'type'          => 'select',
		"options"       => array(
			'date'  => __( 'Date', 'better-studio' ),
			'title' => __( 'Title', 'better-studio' ),
			'rand'  => __( 'Rand', 'better-studio' ),
		),
		'show_on'       => array(
			array(
				'type=campaign'
			),
		),
		'repeater_item' => TRUE,
		'ad-id'         => $args['id_prefix'],
	);
	$repeater_items['order']    = array(
		'name'          => __( 'Order', 'better-studio' ),
		'id'            => 'order',
		'type'          => 'select',
		"options"       => array(
			'ASC'  => __( 'Ascending', 'better-studio' ),
			'DESC' => __( 'Descending', 'better-studio' ),
		),
		'show_on'       => array(
			array(
				'type=campaign'
			),
		),
		'repeater_item' => TRUE,
		'ad-id'         => $args['id_prefix'],
	);
	$repeater_items['align']    = array(
		'name'          => __( 'Align', 'better-studio' ),
		'id'            => 'align',
		'desc'          => __( 'Choose align of ad.', 'better-studio' ),
		'type'          => 'select',
		'options'       => array(
			'left'   => __( 'Left Align', 'better-studio' ),
			'center' => __( 'Center Align', 'better-studio' ),
			'right'  => __( 'Right Align', 'better-studio' ),
		),
		'show_on'       => array(
			array(
				'type=banner',
			),
			array(
				'type=campaign',
			),
		),
		'repeater_item' => TRUE,
		'ad-id'         => $args['id_prefix'],
	);


	if ( ! empty( $args['field_end_fields'] ) ) {
		foreach ( (array) $args['field_end_fields'] as $field_id => $field_val ) {
			$repeater_items[ $field_id ] = $field_val;
		}
	}

	$fields[ $args['id_prefix'] ] = array(
		'name'          => $args['field_title'],
		'desc'          => $args['field_desc'],
		'id'            => $args['id_prefix'],
		'type'          => 'repeater',
		'save-std'      => TRUE,
		'default'       => array(
			array(
				'type'      => '',
				'campaign'  => 'none',
				'banner'    => 'none',
				'paragraph' => 3,
				'count'     => 3,
				'columns'   => 3,
				'orderby'   => 'rand',
				'order'     => 'ASC',
				'align'     => 'center',
				'post_type' => '',
			),
		),
		'add_label'     => $args['field_add_label'],
		'delete_label'  => $args['field_delete_label'],
		'item_title'    => $args['field_item_title'],
		'section_class' => 'full-with-both' . ( $args['field_item_smart_title'] ? ' better-ads-repeater-ad-field' : '' ),
		'options'       => $repeater_items,
		'ad-id'         => $args['id_prefix'],
	);

	if ( ! empty( $args['end_fields'] ) ) {
		foreach ( (array) $args['end_fields'] as $field_id => $field_val ) {
			$fields[ $field_id ] = $field_val;
		}
	}

	if ( $args['group'] && $args['group_auto_close'] ) {
		$fields[] = array(
			'type' => 'group_close',
		);
	}

}


/**
 * Shows ad location code by its panel prefix or data
 *
 * @param string $panel_ad_prefix
 * @param null   $ad_data
 * @param array  $args
 */
function better_ads_show_ad_location( $panel_ad_prefix = '', $ad_data = NULL, $args = array() ) {

	if ( empty( $panel_ad_prefix ) ) {
		return;
	}

	if ( is_null( $ad_data ) || ! is_array( $ad_data ) ) {
		$ad_data = better_ads_get_ad_location_data( $panel_ad_prefix );
	}

	if ( ! empty( $args['container-class'] ) ) {
		if ( ! empty( $ad_data['container-class'] ) ) {
			$ad_data['container-class'] .= ' ' . $args['container-class'] . ' location-' . $panel_ad_prefix;
		} else {
			$ad_data['container-class'] = $args['container-class'] . ' location-' . $panel_ad_prefix;
		}
	} else {
		$ad_data['container-class'] = 'location-' . $panel_ad_prefix;
	}

	echo Better_Ads_Manager()->show_ads( $ad_data );
}


/**
 * Returns full list of Ad location data from it's prefix inside panel
 *
 * @param string $panel_ad_prefix
 * @param bool   $multiple
 *
 * @return array
 */
function better_ads_get_ad_location_data( $panel_ad_prefix = '', $multiple = FALSE ) {

	$func = '';
	if ( is_singular() ) {
		$func = 'bf_get_post_meta';
	} elseif ( is_archive() ) {

		$queried_object = get_queried_object();

		if ( ! empty( $queried_object->taxonomy ) ) {
			$func = 'bf_get_term_meta';
		}
	}


	if ( ! empty( $func ) ) {
		if ( call_user_func( $func, 'bam_disable_all' ) || call_user_func( $func, 'bam_disable_locations' ) ) {
			return array(
				'type'            => '',
				'banner'          => '',
				'campaign'        => '',
				'count'           => '',
				'columns'         => '',
				'orderby'         => '',
				'order'           => '',
				'align'           => '',
				'post_type'       => '',
				'active_location' => FALSE,
			);
		}
	}

	return better_ads_get_ad_data( $panel_ad_prefix, $multiple );
}


/**
 * Returns full list of Ad location data from it's prefix inside panel
 *
 * @param string $panel_ad_prefix
 * @param bool   $multiple
 *
 * @return array
 */
function better_ads_get_ad_data( $panel_ad_prefix = '', $multiple = FALSE ) {

	$data_ids = array(
		'type'            => '',
		'banner'          => '',
		'campaign'        => '',
		'count'           => '',
		'columns'         => '',
		'orderby'         => '',
		'order'           => '',
		'align'           => '',
		'post_type'       => '',
		'active_location' => FALSE,
	);


	if ( empty( $panel_ad_prefix ) ) {
		return $multiple ? array( $data_ids ) : $data_ids;
	}


	$object_id   = 0;
	$object_type = '';
	$override_id = FALSE;
	$final_ads   = array();
	$data        = array();


	//
	// Find override ID for current page
	//
	if ( is_singular() && ! is_front_page() ) {
		if ( get_post_type() ) {
			$override_id = get_post_type();
			$object_id   = get_queried_object_id();
			$object_type = 'post';
		}
	} elseif ( is_post_type_archive() ) {

		$queried_object = get_queried_object();

		if ( ! empty( $queried_object->name ) ) {
			$override_id = $queried_object->name;
		}

	} elseif ( is_archive() ) {

		$queried_object = get_queried_object();

		if ( ! empty( $queried_object->taxonomy ) ) {
			$override_id = $queried_object->taxonomy;
			$object_id   = $queried_object->term_id;
			$object_type = 'taxonomy';
		}
	}


	/**
	 * TODO: Refactor, DRY!
	 */

	if ( $multiple ) {

		if ( $override_id && $object_type === 'post' &&
		     bf_get_post_meta( 'ovr_' . $override_id . '-' . $panel_ad_prefix . '-active', $object_id )
		) {

			$data = bf_get_post_meta( 'ovr_' . $override_id . '-' . $panel_ad_prefix, $object_id );

		} else if ( $override_id && $object_type === 'taxonomy' &&
		            bf_get_term_meta( 'ovr_' . $override_id . '-' . $panel_ad_prefix . '-active', $object_id )
		) {

			$data = bf_get_term_meta( 'ovr_' . $override_id . '-' . $panel_ad_prefix, $object_id );

		} else if ( $override_id && Better_Ads_Manager::get_option( 'ovr_' . $override_id . '-' . $panel_ad_prefix . '-active' ) ) {


			$data = Better_Ads_Manager::get_option( 'ovr_' . $override_id . '-' . $panel_ad_prefix );

		} else {
			$data = Better_Ads_Manager::get_option( $panel_ad_prefix );
		}

	} else {


		if ( $override_id && $object_type === 'post' &&
		     bf_get_post_meta( 'ovr_' . $override_id . '-' . $panel_ad_prefix . '-active', $object_id )
		) {

			foreach ( $data_ids as $id => $value ) {
				$data[0][ $id ] = bf_get_post_meta( 'ovr_' . $override_id . '-' . $panel_ad_prefix . '_' . $id, $object_id );
			}

		} else if ( $override_id && $object_type === 'taxonomy' &&
		            bf_get_term_meta( 'ovr_' . $override_id . '-' . $panel_ad_prefix . '-active', $object_id )
		) {

			foreach ( $data_ids as $id => $value ) {
				$data[0][ $id ] = bf_get_term_meta( 'ovr_' . $override_id . '-' . $panel_ad_prefix . '_' . $id, $object_id );
			}

		} else if ( $override_id && Better_Ads_Manager::get_option( 'ovr_' . $override_id . '-' . $panel_ad_prefix . '-active' ) ) {
			foreach ( $data_ids as $id => $value ) {
				$data[0][ $id ] = Better_Ads_Manager::get_option( 'ovr_' . $override_id . '-' . $panel_ad_prefix . '_' . $id );
			}

		} else {
			foreach ( $data_ids as $id => $value ) {
				$data[0][ $id ] = Better_Ads_Manager::get_option( $panel_ad_prefix . '_' . $id );
			}
		}
	}


	foreach ( $data as $ad_item ) {

		// Type not selected
		if ( empty( $ad_item['type'] ) || $ad_item['type'] === 'none' ) {
			continue;
		}

		// Banner not selected
		if ( $ad_item['type'] === 'banner' && ( empty( $ad_item['banner'] ) || $ad_item['banner'] === 'none' ) ) {
			continue;
		}

		// Campaign not selected
		if ( $ad_item['type'] === 'campaign' && ( empty( $ad_item['campaign'] ) || $ad_item['campaign'] == 'none' ) ) {
			continue;
		}

		// Post type is not valid
		if ( ! empty( $ad_item['post_type'] ) ) {
			foreach ( explode( ',', $ad_item['post_type'] ) as $post_type ) {
				if ( ! is_singular( $post_type ) ) {
					continue;
				}
			}
		}

		$ad_item['active_location'] = TRUE;

		if ( empty( $ad_item['align'] ) ) {
			$ad_item['align'] = 'center';
		}

		$final_ads[] = $ad_item;
	}


	// return default ID's
	if ( empty( $final_ads ) ) {
		return $multiple ? array( $data_ids ) : $data_ids;
	}

	if ( $multiple ) {
		return $final_ads;
	}

	return current( $final_ads );
}


/**
 * Handy function to fetching data from Google Adsense code.
 *
 * @param $code
 *
 * @return array
 */
function better_ads_extract_google_ad_code_data( $code ) {

	$data = array(
		'ad-client' => '',
		'ad-slot'   => '',
		'ad-format' => '',
		'style'     => '',
	);

	$code = strtolower( $code );

	/**
	 *
	 * data-ad-client
	 *
	 */
	preg_match( '/data-ad-client="(.*)"/', $code, $matches );

	if ( ! empty( $matches[1] ) ) {
		$data['ad-client'] = $matches[1];
	}


	/**
	 *
	 * data-ad-slot
	 *
	 */
	preg_match( '/data-ad-slot="(.*)"/', $code, $matches );

	if ( ! empty( $matches[1] ) ) {
		$data['ad-slot'] = $matches[1];
	}


	/**
	 *
	 * data-ad-format
	 *
	 */
	preg_match( '/data-ad-format="(.*)"/', $code, $matches );

	if ( ! empty( $matches[1] ) ) {
		$data['ad-format'] = $matches[1];
	}

	$_check = array(
		'vertical'   => '',
		'horizontal' => '',
		'rectangle'  => '',
		'auto'       => '',
	);
	if ( empty( $data['ad-format'] ) || ! isset( $_check[ $data['ad-format'] ] ) ) {
		$data['ad-format'] = 'auto';
	}


	/**
	 *
	 * style
	 *
	 */
	preg_match( '/style="(.*)"/', $code, $matches );

	if ( ! empty( $matches[1] ) ) {
		$data['style'] = $matches[1];
	}


	return $data;
}


if ( ! function_exists( 'bam_deferred_dfp_spot_options' ) ) {
	/**
	 * Callback for banner options. Extracts spots from list and shows them to user for easy to use.
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	function bam_deferred_dfp_spot_options( $args = array() ) {

		$options = array(
			''       => __( '-- Select Spot --', 'better-studio' ),
			'custom' => __( 'Custom Code', 'better-studio' ),
		);

		$dfp_code = Better_Ads_Manager::get_option( 'dfp_code' );

		if ( ! empty( $dfp_code ) ) {
			preg_match_all( '#defineSlot\((.*)\).addService#', $dfp_code, $dfp_spots );
		} else {
			$dfp_spots = array();
		}

		$group = array(
			'label'   => __( 'Auto detected DFP spots', 'better-studio' ),
			'options' => array()
		);

		if ( ! empty( $dfp_spots[1] ) ) {
			foreach ( $dfp_spots[1] as $_spot ) {
				$group['options'][ str_replace( ',', '--', $_spot ) ] = $_spot;
			}
		}

		if ( empty( $group['options'] ) ) {
			$group['options']['not-detected'] = array(
				'label'    => __( 'Please enter DFP code into Better Ads Manager panle', 'better-studio' ),
				'disabled' => TRUE,
			);
		}

		$options[] = $group;

		return $options;
	}
}


if ( ! function_exists( 'better_ads_get_override_sections_list' ) ) {
	/**
	 * Returns list of items that can be overrided
	 *
	 * @return array
	 */
	function better_ads_get_override_sections_list() {

		static $sections;

		if ( $sections ) {
			return $sections;
		}

		$sections = array(
			'taxonomy'  => array(
				'label' => 'Taxonomies',
				'items' => array(),
			),
			'post_type' => array(
				'label' => 'Post Types',
				'items' => array(),
			),
		);


		//
		// CPT's
		//
		{
			$post_types = array_diff_key(
				get_post_types(
					array(
						'public' => TRUE,
					)
				),
				array(
					'attachment' => 0,
				)
			);


			foreach ( $post_types as $cpt_id ) {

				$post_type = get_post_type_object( $cpt_id );

				$sections['post_type']['items'][ $cpt_id ] = array(
					'id'    => $cpt_id,
					'label' => $post_type->labels->singular_name
				);
			}

			ksort( $sections['post_type']['items'] );
		}


		//
		// Taxonomy
		//
		{
			$taxonomies = array_diff_key(
				get_taxonomies(
					array(
						'public' => TRUE,
					)
				),
				array(
					'nav_menu'               => 0,
					'link_category'          => 0,
					'post_format'            => 0,
					'product_shipping_class' => 0,
					'product_type'           => 0,
				)
			);

			foreach ( $taxonomies as $tax_id ) {
				$tax = get_taxonomy( $tax_id );

				$sections['taxonomy']['items'][ $tax_id ] = array(
					'id'    => $tax_id,
					'label' => $tax->labels->singular_name
				);
			}

			ksort( $sections['taxonomy']['items'] );
		}

		ksort( $sections );

		return $sections;

	} // better_ads_get_override_sections_list
}


if ( ! function_exists( 'better_ads_get_override_fields_list' ) ) {
	/**
	 * Creates fields list of a overriden section
	 *
	 * @param array $fields
	 *
	 * @return array
	 */
	function better_ads_get_override_fields_list( $fields = array() ) {

		$section_fields = array();

		//
		// Loads fields from filter
		//
		if ( empty( $fields ) ) {
			$fields = apply_filters( 'better-framework/panel/better_ads_manager/fields', array() );
		}

		// Converts tabs and groups to be nested fields
		foreach ( $fields as $field_id => $field ) {

			// from start to DFP or AMP ads
			if ( ! empty( $field['id'] ) && ( $field['id'] === 'dfp_settings' || $field['id'] === 'amp_ads' || $field['id'] === 'override_settings' ) ) {
				break;
			}

			if ( ! empty( $field['type'] ) ) {
				if ( $field['type'] === 'tab' ) {
					$field['type']  = 'group';
					$field['level'] = 2;
					$field['state'] = 'close';
					unset( $field['ajax-tab'] );
				} elseif ( $field['type'] === 'group' ) {
					$field['level'] = 4;
					$field['type']  = 'group';
					$field['state'] = 'close';
				} elseif ( $field['type'] === 'heading' ) {
					$field['type']  = 'group';
					$field['level'] = 3;
					$field['state'] = 'close';
				}
			}

			$field['ajax-tab-field'] = 'override_settings';

			$section_fields[ $field_id ] = $field;
		}

		return $section_fields;

	} // better_ads_get_override_fields_list
}


if ( ! function_exists( 'better_ads_inject_override_ad_section_fields' ) ) {
	/**
	 * Creates overridable fields for a section
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	function better_ads_inject_override_ad_section_fields( $args = array() ) {

		$args = bf_merge_args( $args, array(
			'id'                 => '',
			'name'               => '',
			'fields'             => array(),
			'ajax-section-field' => '',
		) );

		$action             = '';
		$condition_field_id = '';
		$override_fields    = array();
		$closed             = TRUE;
		$closed_top         = TRUE;

		foreach ( $args['fields'] as $field_k => $field ) {

			// create new ID
			if ( ! empty( $field['id'] ) ) {
				$id = 'ovr_' . $args['id'] . '-' . $field['id'];
			} else {
				$id = $field_k;
			}


			//
			// Add condition field for group fields
			//
			if ( $action == 'add condition' ) {

				if ( isset( $field['ad-id'] ) ) {
					$condition_field_id = 'ovr_' . $args['id'] . '-' . $field['ad-id'] . '-active';
				} else {
					$condition_field_id = $id . '-active';
				}

				$override_fields[ $condition_field_id ] = array(
					'name'           => __( 'Override this ad?', 'better-studio' ),
					'desc'           => sprintf( __( 'You can override this ad location for "%s" with enabling this option', 'better-studio' ), $args['name'] ),
					'id'             => $condition_field_id,
					'type'           => 'switch',
					'std'            => 0,
					'ajax-tab-field' => $args['ajax-section-field'],
				);

				$action = 'add filter';

			}


			//
			// Add filter for group fields (show_on)
			//
			if ( $action == 'add filter' && $field['type'] !== 'group' ) {

				//
				// Update old show_on value
				//
				if ( isset( $field['show_on'] ) ) {

					$new_show_on = array();

					if ( ! empty( $field['_show_on_parent'] ) ) {
						$type_id = $field['_show_on_parent'];
						$rep_id  = 'ovr_' . $args['id'] . '-' . $field['_show_on_parent'];
					} else {

						//
						// remove text after last _ to detect the parent field id for replacement
						// We suggest to add "_show_on_parent" to parent.
						//
						$type_id = explode( '_', $field['id'] );
						if ( count( $type_id ) > 1 ) {
							array_pop( $type_id );
						}

						$type_id = implode( '_', $type_id );
						$rep_id  = 'ovr_' . $args['id'] . '-' . $type_id;
					}


					// renames old ID's to new id
					foreach ( $field['show_on'] as $show_l1 ) {

						$_show_l1 = array();

						foreach ( $show_l1 as $show_l2 ) {
							$_show_l1[] = str_replace( $type_id, $rep_id, $show_l2 );
						}

						$new_show_on[] = $_show_l1;
					}


					// add new filter to show on
					foreach ( $new_show_on as $idx => $_ ) {
						$new_show_on[ $idx ][] = $condition_field_id . '=1';
					}
					$field['show_on'] = $new_show_on;

				} else {
					$field['show_on'] = array(
						array(
							$condition_field_id . '=1'
						)
					);
				}

			}


			if ( $field['type'] === 'group' && $field['level'] == 2 ) {
				$override_fields[ $id . '-close' ] = array(
					'type'           => 'group_close',
					'ajax-tab-field' => $args['ajax-section-field'],
					'level'          => 'all',
				);
			}


			if ( $field['type'] !== 'group_close' ) {
				$field['id']             = $id;
				$field['ajax-tab-field'] = $args['ajax-section-field'];
				$override_fields[ $id ]  = $field;
			}


			//
			// auto close for old group
			//
			if ( $field['type'] === 'group' && $field['level'] == 4 && ! $closed ) {
				$override_fields[ $id . '-close' ] = array(
					'type'           => 'group_close',
					'ajax-tab-field' => $args['ajax-section-field'],
				);
				$closed                            = TRUE;
			}


			//
			// group start -> condition field should be added
			//
			if ( $field['type'] === 'group' && $field['level'] == 4 ) {
				$action = 'add condition';
			}


			//
			// End of group -> clear
			//
			elseif ( $field['type'] === 'group_close' ) {
				$action             = '';
				$condition_field_id = '';
				$closed             = TRUE;
			}

		}

		return $override_fields;

	} // better_ads_inject_override_ad_section_fields
}


if ( ! function_exists( 'better_ads_section_override_fields_list' ) ) {
	/**
	 * Prepares fields to opened group in ajax action of panel
	 *
	 * @param $args
	 *
	 * @return array
	 */
	function better_ads_section_override_fields_list( $args ) {

		$section_fields_list = better_ads_get_override_fields_list();

		if ( empty( $args['ajax-section-field'] ) ) {
			$args['ajax-section-field'] = 'ajax-section-field';
		}

		$section_fields = better_ads_inject_override_ad_section_fields( array(
			'id'                 => $args['section'],
			'name'               => $args['section-name'],
			'fields'             => $section_fields_list,
			'ajax-section-field' => $args['ajax-section-field'],
		) );

		return $section_fields;
	}
}


if ( ! function_exists( 'better_ads_section_disable_fields_list' ) ) {
	/**
	 * Prepares fields to opened group in ajax action of panel
	 *
	 * @param array $fields
	 * @param array $args
	 *
	 * @return array
	 */
	function better_ads_section_disable_fields_list( $fields = array(), $args = array() ) {

		$args = bf_merge_args( $args, array(
			'type' => 'post',
		) );

		$fields['bam_disable_all'] = array(
			'name'      => __( 'Disable All Ads?', 'better-studio' ),
			'id'        => 'bam_disable_all',
			'type'      => 'switch',
			'on-label'  => __( 'Yes', 'better-studio' ),
			'off-label' => __( 'No', 'better-studio' ),
			'desc'      => __( 'Hides all ads.', 'better-studio' ),
		);

		$fields['bam_disable_locations'] = array(
			'name'      => __( 'Disable All Ad Locations?', 'better-studio' ),
			'id'        => 'bam_disable_locations',
			'type'      => 'switch',
			'on-label'  => __( 'Yes', 'better-studio' ),
			'off-label' => __( 'No', 'better-studio' ),
			'desc'      => __( 'Hides only ad locations.', 'better-studio' ),
			'show_on'   => array(
				array(
					'bam_disable_all=0',
				),
			),
		);

		$fields['bam_disable_widgets'] = array(
			'name'      => __( 'Disable All Widgets?', 'better-studio' ),
			'id'        => 'bam_disable_widgets',
			'type'      => 'switch',
			'on-label'  => __( 'Yes', 'better-studio' ),
			'off-label' => __( 'No', 'better-studio' ),
			'desc'      => __( 'Hides ad widgets.', 'better-studio' ),
			'show_on'   => array(
				array(
					'bam_disable_all=0',
				),
			),
		);

		if ( $args['type'] === 'post' ) {
			$fields['bam_disable_post_content'] = array(
				'name'      => __( 'Disable All Content Ads?', 'better-studio' ),
				'id'        => 'bam_disable_post_content',
				'type'      => 'switch',
				'on-label'  => __( 'Yes', 'better-studio' ),
				'off-label' => __( 'No', 'better-studio' ),
				'desc'      => __( 'Hides post content ads.', 'better-studio' ),
				'show_on'   => array(
					array(
						'bam_disable_all=0',
					),
				),
			);
		}

		return $fields;
	}
}
