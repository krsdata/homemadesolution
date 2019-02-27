<?php

add_filter( 'better-framework/panel/add', 'better_disqus_comments_panel_add', 10 );

if ( ! function_exists( 'better_disqus_comments_panel_add' ) ) {
	/**
	 * Callback: Ads panel
	 *
	 * Filter: better-framework/panel/options
	 *
	 * @param $panels
	 *
	 * @return array
	 */
	function better_disqus_comments_panel_add( $panels ) {

		$panels['better_disqus_comments'] = array(
			'id' => 'better_disqus_comments',
		);

		return $panels;
	}
}


add_filter( 'better-framework/panel/better_disqus_comments/config', 'better_disqus_comments_panel_config', 10 );

if ( ! function_exists( 'better_disqus_comments_panel_config' ) ) {
	/**
	 * Callback: Init's BF options
	 *
	 * @param $panel
	 *
	 * @return array
	 */
	function better_disqus_comments_panel_config( $panel ) {

		include Better_Disqus_Comments::dir_path( 'includes/options/panel-config.php' );

		return $panel;
	} // better_disqus_comments_panel_config
}


add_filter( 'better-framework/panel/better_disqus_comments/std', 'better_disqus_comments_panel_std', 10 );

if ( ! function_exists( 'better_disqus_comments_panel_std' ) ) {
	/**
	 * Callback: Init's BF options
	 *
	 * Filter: better-framework/panel/options
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	function better_disqus_comments_panel_std( $fields ) {

		$field['shortname'] = array(
			'std' => '',
		);

		return $fields;
	}
}


add_filter( 'better-framework/panel/better_disqus_comments/fields', 'better_disqus_comments_panel_fields', 10 );

if ( ! function_exists( 'better_disqus_comments_panel_fields' ) ) {
	/**
	 * Callback: Init's BF options
	 *
	 * Filter: better-framework/panel/options
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	function better_disqus_comments_panel_fields( $fields ) {

		$fields['shortname'] = array(
			'name' => __( 'Site Shortname', 'better-studio' ),
			'id'   => 'shortname',
			'desc' => __( 'Enter the shortname for your website. This is generated in your Disqus account.', 'better-studio' ),
			'type' => 'text',
			'std'  => '',
		);

		return $fields;
	}
}
