<?php

add_filter( 'better-framework/panel/add', 'bgcs_panel_add', 10 );

if ( ! function_exists( 'bgcs_panel_add' ) ) {
	/**
	 * Callback: Ads panel
	 *
	 * Filter: better-framework/panel/options
	 *
	 * @param $panels
	 *
	 * @return array
	 */
	function bgcs_panel_add( $panels ) {

		$panels[ Better_GCS::$panel_id ] = array(
			'id' => Better_GCS::$panel_id,
		);

		return $panels;
	}
}


add_filter( 'better-framework/panel/' . Better_GCS::$panel_id . '/config', 'bgcs_panel_config', 10 );

if ( ! function_exists( 'bgcs_panel_config' ) ) {
	/**
	 * Callback: Init's BF options
	 *
	 * @param $panel
	 *
	 * @return array
	 */
	function bgcs_panel_config( $panel ) {

		include Better_GCS::dir_path( 'includes/options/panel-config.php' );

		return $panel;
	} // bgcs_panel_config
}


add_filter( 'better-framework/panel/' . Better_GCS::$panel_id . '/std', 'bgcs_panel_std', 10 );

if ( ! function_exists( 'bgcs_panel_std' ) ) {
	/**
	 * Callback: Init's BF options
	 *
	 * Filter: better-framework/panel/options
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	function bgcs_panel_std( $fields ) {

		$fields['google-custom-search-help'] = array(
			'std' => __( '<ol>
<li>Go to <a href="http://goo.gl/Pw8qFw" target="_blank">Google Custom Search Engine</a> Page</li>
<li>Click <strong>Create a custom search engine</strong> button</li>
<li>In next page fill <strong>Sites to search</strong> input with your site address and click <strong>CREATE</strong> button</li>
<li>In next page click <strong>Get code</strong> button and copy code in opened page</li>
<li>Paste code into following <strong>Embed Code/Search ID</strong> input.</li>
</ol>', 'better-studio' ),
		);
		$fields['engine_id']                 = array(
			'std' => ''
		);
		$fields['show_search_button']        = array(
			'std' => '1',
		);
		$fields['show_ads']                  = array(
			'std' => '0',
		);
		$fields['loading_text']              = array(
			'std' => __( 'Loading...', 'better-studio' )
		);

		return $fields;
	}
}


add_filter( 'better-framework/panel/' . Better_GCS::$panel_id . '/fields', 'bgcs_panel_fields', 10 );

if ( ! function_exists( 'bgcs_panel_fields' ) ) {
	/**
	 * Callback: Init's BF options
	 *
	 * Filter: better-framework/panel/options
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	function bgcs_panel_fields( $fields ) {

		$fields['google-custom-search-help'] = array(
			'name'          => __( 'How To Setup', 'better-studio' ),
			'id'            => 'google-custom-search-help',
			'type'          => 'info',
			'std'           => __( '<ol>
<li>Go to <a href="http://goo.gl/Pw8qFw" target="_blank">Google Custom Search Engine</a> Page</li>
<li>Click <strong>Create a custom search engine</strong> button</li>
<li>In next page fill <strong>Sites to search</strong> input with your site address and click <strong>CREATE</strong> button</li>
<li>In next page click <strong>Get code</strong> button and copy code in opened page</li>
<li>Paste code into following <strong>Embed Code/Search ID</strong> input.</li>
</ol>', 'better-studio' ),
			'state'         => 'open',
			'info-type'     => 'help',
			'section_class' => 'widefat',
		);
		$fields['engine_id']                 = array(
			'name' => __( 'Embed Code/Search ID', 'better-studio' ),
			'id'   => 'engine_id',
			'desc' => __( 'Paste the Custom Search embed code or Search engine unique ID here. <br><br>Note that any customized styles will be stripped out.', 'better-studio' ),
			'type' => 'textarea',
		);
		$fields['show_search_button']        = array(
			'name'      => __( 'Display Search Button', 'better-studio' ),
			'id'        => 'show_search_button',
			'type'      => 'switch',
			'on-label'  => __( 'Show', 'better-studio' ),
			'off-label' => __( 'Hide', 'better-studio' ),
		);
		$fields['show_ads']                  = array(
			'name'      => __( 'Show Ads in search page', 'better-studio' ),
			'id'        => 'show_ads',
			'type'      => 'switch',
			'on-label'  => __( 'Show', 'better-studio' ),
			'off-label' => __( 'Hide', 'better-studio' ),
		);
		$fields['loading_text']              = array(
			'name' => __( 'Loading Text', 'better-studio' ),
			'id'   => 'loading_text',
			'type' => 'text',
		);

		return $fields;
	}
}
