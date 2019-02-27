<?php

add_filter( 'better-framework/panel/add', 'better_weather_panel_add', 10 );

if ( ! function_exists( 'better_weather_panel_add' ) ) {
	/**
	 * Callback: Ads panel
	 *
	 * Filter: better-framework/panel/options
	 *
	 * @param $panels
	 *
	 * @return array
	 */
	function better_weather_panel_add( $panels ) {

		$panels[ Better_Weather::$panel_id ] = array(
			'id'  => Better_Weather::$panel_id,
			'css' => TRUE,
		);

		return $panels;
	}
}


add_filter( 'better-framework/panel/' . Better_Weather::$panel_id . '/config', 'better_weather_panel_config', 10 );

if ( ! function_exists( 'better_weather_panel_config' ) ) {
	/**
	 * Callback: Init's BF options
	 *
	 * @param $panel
	 *
	 * @return array
	 */
	function better_weather_panel_config( $panel ) {

		include Better_Weather::dir_path( 'includes/options/panel-config.php' );

		return $panel;
	}
}


add_filter( 'better-framework/panel/' . Better_Weather::$panel_id . '/std', 'better_weather_panel_std', 10 );

if ( ! function_exists( 'better_weather_panel_std' ) ) {
	/**
	 * Callback: Init's BF options
	 *
	 * Filter: better-framework/panel/options
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	function better_weather_panel_std( $fields ) {

		include Better_Weather::dir_path( 'includes/options/panel-std.php' );

		return $fields;
	}
}


add_filter( 'better-framework/panel/' . Better_Weather::$panel_id . '/fields', 'better_weather_panel_fields', 10 );

if ( ! function_exists( 'better_weather_panel_fields' ) ) {
	/**
	 * Callback: Init's BF options
	 *
	 * Filter: better-framework/panel/options
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	function better_weather_panel_fields( $fields ) {

		include Better_Weather::dir_path( 'includes/options/panel-fields.php' );

		return $fields;
	}
}


add_filter( 'better-framework/panel/' . Better_Weather::$panel_id . '/css', 'better_weather_panel_css', 10 );

if ( ! function_exists( 'better_weather_panel_css' ) ) {
	/**
	 * Callback: Init's BF options
	 *
	 * Filter: better-framework/panel/options
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	function better_weather_panel_css( $fields ) {

		include Better_Weather::dir_path( 'includes/options/panel-css.php' );

		return $fields;
	}
}
