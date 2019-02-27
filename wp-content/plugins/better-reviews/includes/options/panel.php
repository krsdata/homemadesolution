<?php

add_filter( 'better-framework/panel/add', 'better_reviews_panel_add', 10 );

if ( ! function_exists( 'better_reviews_panel_add' ) ) {
	/**
	 * Callback: Ads panel
	 *
	 * Filter: better-framework/panel/options
	 *
	 * @param $panels
	 *
	 * @return array
	 */
	function better_reviews_panel_add( $panels ) {

		$panels[ Better_Reviews::$panel_id ] = array(
			'id' => Better_Reviews::$panel_id,
		);

		return $panels;
	}
}


add_filter( 'better-framework/panel/' . Better_Reviews::$panel_id . '/config', 'better_reviews_panel_config', 10 );

if ( ! function_exists( 'better_reviews_panel_config' ) ) {
	/**
	 * Callback: Init's BF options
	 *
	 * @param $panel
	 *
	 * @return array
	 */
	function better_reviews_panel_config( $panel ) {

		include Better_Reviews::dir_path( 'includes/options/panel-config.php' );

		return $panel;
	} // better_reviews_panel_config
}


add_filter( 'better-framework/panel/' . Better_Reviews::$panel_id . '/std', 'better_reviews_panel_std', 10 );

if ( ! function_exists( 'better_reviews_panel_std' ) ) {
	/**
	 * Callback: Init's BF options
	 *
	 * Filter: better-framework/panel/options
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	function better_reviews_panel_std( $fields ) {

		$fields['add_rich_snippet'] = array(
			'std' => TRUE,
		);

		return $fields;
	}
}


add_filter( 'better-framework/panel/' . Better_Reviews::$panel_id . '/fields', 'better_reviews_panel_fields', 10 );

if ( ! function_exists( 'better_reviews_panel_fields' ) ) {
	/**
	 * Callback: Init's BF options
	 *
	 * Filter: better-framework/panel/options
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	function better_reviews_panel_fields( $fields ) {

		$fields['add_rich_snippet'] = array(
			'name'      => __( 'Enable Schema SEO Rich Snippet Review Microdata', 'better-studio' ),
			'id'        => 'add_rich_snippet',
			'desc'      => __( 'Use for adding Microformats to get Rich Snippets showing for your site and increase the CTR from Google.', 'better-studio' ),
			'type'      => 'switch',
			'on-label'  => __( 'Enable', 'better-studio' ),
			'off-label' => __( 'Disable', 'better-studio' ),
		);

		return $fields;
	}
}
