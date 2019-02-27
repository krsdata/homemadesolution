<?php
/*
Plugin Name: BetterWeather
Plugin URI: http://codecanyon.net/item/better-weather-wordpress-version/7724257?ref=Better-Studio
Description:
Version: 3.2.2
Author: BetterWeather
Author URI: http://betterstudio.com
License: GPL2
Text Domain: better-studio
*/

// Fire up BetterWeather
new Better_Weather();

class Better_Weather {

	/**
	 * Contains BW version number that used for assets for preventing cache mechanism
	 *
	 * @var string
	 */
	private static $version = '3.2.2';


	/**
	 * Contains BW option panel id
	 *
	 * @var string
	 */
	public static $panel_id = 'better_weather_options';


	function __construct() {

		// make sure following code only one time run
		static $initialized;
		if ( $initialized ) {
			return;
		} else {
			$initialized = TRUE;
		}

		// Clear BF transients on plugin activation
		register_activation_hook( __FILE__, array( $this, 'plugin_activation' ) );

		// Register included BF to loader
		add_filter( 'better-framework/loader', array( $this, 'better_framework_loader' ) );

		// Enable needed sections
		add_filter( 'better-framework/sections', array( $this, 'better_framework_sections' ) );

		// Add option panel
		include 'includes/options/panel.php';

		// Active and new shortcodes
		add_filter( 'better-framework/shortcodes', array( $this, 'setup_shortcodes' ) );

		// Initialize BetterWeather
		add_action( 'better-framework/after_setup', array( $this, 'init' ) );

		// Callback for resetting data
		add_filter( 'better-framework/panel/reset/result', array( $this, 'callback_panel_reset_result' ), 10, 2 );

		// Callback for importing data
		add_filter( 'better-framework/panel/import/result', array( $this, 'callback_panel_import_result' ), 10, 3 );

		// Adding Visual Composer add-on
		add_action( 'plugins_loaded', array( $this, 'register_vc_support' ) );

		// Includes BF loader if not included before
		require_once 'includes/libs/better-framework/init.php';

		// Ads plugin textdomain
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

		add_filter( 'better-framework/oculus/logger/turn-off', array( $this, 'oculus_logger' ), 22, 3 );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}


	/**
	 * Scripts & Styles
	 */
	function enqueue_assets() {

		$dir_url  = self::dir_url();
		$dir_path = self::dir_path();

		bf_enqueue_script( 'element-query' );

		bf_enqueue_script(
			'skycons',
			bf_append_suffix( $dir_url . 'js/skycons', '.js' ),
			array( 'jquery' ),
			bf_append_suffix( $dir_path . 'js/skycons', '.js' ),
			Better_Weather::$version
		);

		bf_enqueue_script(
			'better-weather',
			bf_append_suffix( $dir_url . 'js/betterweather', '.js' ),
			array(
				'jquery',
				'skycons'
			),
			bf_append_suffix( $dir_path . 'js/betterweather', '.js' ),
			Better_Weather::$version
		);

		bf_enqueue_style(
			'better-weather',
			bf_append_suffix( $dir_url . 'css/bw-style', '.css' ),
			array(),
			bf_append_suffix( $dir_path . 'css/bw-style', '.css' ),
			Better_Weather::$version
		);
	}


	/**
	 * Load plugin textdomain.
	 *
	 * @since 2.0.1
	 */
	function load_textdomain() {
		// Register text domain
		load_plugin_textdomain( 'better-studio', FALSE, 'better-weather/languages' );
	}


	/**
	 * Returns BW current Version
	 *
	 * @return string
	 */
	static function get_version() {
		return self::$version;
	}


	/**
	 * Used for accessing plugin directory URL
	 *
	 * @param string $address
	 *
	 * @return string
	 */
	public static function dir_url( $address = '' ) {

		static $url;

		if ( is_null( $url ) ) {
			$url = plugin_dir_url( __FILE__ );
		}

		return $url . $address;
	}


	/**
	 * Used for accessing plugin directory path
	 *
	 * @param string $address
	 *
	 * @return string
	 */
	public static function dir_path( $address = '' ) {

		static $path;

		if ( is_null( $path ) ) {
			$path = plugin_dir_path( __FILE__ );
		}

		return $path . $address;
	}


	/**
	 * Clears BF transients for avoiding of happening any problem
	 */
	function plugin_activation() {
		delete_transient( '__better_framework__widgets_css' );
		delete_transient( '__better_framework__panel_css' );
		delete_transient( '__better_framework__menu_css' );
		delete_transient( '__better_framework__terms_css' );
		delete_transient( '__better_framework__final_fe_css' );
		delete_transient( '__better_framework__final_fe_css_version' );
		delete_transient( '__better_framework__backend_css' );
	}


	/**
	 * Adds included BetterFramework to loader
	 *
	 * @param $frameworks
	 *
	 * @return array
	 */
	function better_framework_loader( $frameworks ) {

		$frameworks[] = array(
			'version' => '2.9.1.1',
			'path'    => self::dir_path( 'includes/libs/better-framework/' ),
			'uri'     => self::dir_url( 'includes/libs/better-framework/' ),
		);

		return $frameworks;
	}


	/**
	 * activate BF needed sections
	 *
	 * @param $sections
	 *
	 * @return mixed
	 */
	function better_framework_sections( $sections ) {

		$sections['vc-extender'] = TRUE;

		return $sections;

	}


	/**
	 *  Init the plugin
	 */
	function init() {
		require_once $this->dir_path( 'includes/generator/class-bw-generator-factory.php' );
		BW_Generator_Factory::generator();

		add_action( 'wp_ajax_nopriv_bw_ajax', array( $this, 'ajax_callback' ) );
		add_action( 'wp_ajax_bw_ajax', array( $this, 'ajax_callback' ) );
	}


	/**
	 * Used for retrieving options simply and safely for next versions
	 *
	 * @param $option_key
	 *
	 * @return mixed|null
	 */
	public static function get_option( $option_key ) {
		return bf_get_option( $option_key, self::$panel_id );
	}


	/**
	 * Setups Shortcodes
	 *
	 * @param $shortcodes
	 *
	 * @return array
	 */
	function setup_shortcodes( $shortcodes ) {

		require_once self::dir_path() . 'includes/shortcodes/class-better-weather-shortcode.php';
		require_once self::dir_path() . 'includes/widgets/class-better-weather-widget.php';
		$shortcodes['BetterWeather'] = array(
			'shortcode_class' => 'Better_Weather_Shortcode',
			'widget_class'    => 'Better_Weather_Widget',
		);

		require_once self::dir_path() . 'includes/shortcodes/class-better-weather-inline-shortcode.php';
		require_once self::dir_path() . 'includes/widgets/class-better-weather-inline-widget.php';
		$shortcodes['BetterWeather-inline'] = array(
			'shortcode_class' => 'Better_Weather_Inline_Shortcode',
			'widget_class'    => 'Better_Weather_Inline_Widget',
		);

		return $shortcodes;
	}


	/**
	 * Used for finding current user IP and Geo Location Data
	 *
	 * @return bool|string
	 */
	public static function get_user_geo_location() {

		// Get user info's by ip
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$user_ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$user_ip = $_SERVER['REMOTE_ADDR'];
		}

		$user_ip = '94.102.59.150';

		// return false in local hosts
		if ( $user_ip == '127.0.0.1' ) {
			return FALSE;
		}

		// move this to main host
		// todo move this to betterstudio.com
		$user_geo_location = wp_remote_get( "http://bw-api.betterstudio.com/get-geo.php?ip=" . $user_ip, array( 'timeout' => 10 ) );

		if ( is_wp_error( $user_geo_location ) || ! isset( $user_geo_location['body'] ) || $user_geo_location['body'] == FALSE ) {
			return FALSE;
		}

		$user_geo_location = json_decode( $user_geo_location['body'] );

		if ( $user_geo_location->statusCode != 'OK' ) {
			return FALSE;
		}

		return $user_geo_location->latitude . ',' . $user_geo_location->longitude;

	} // get_user_geo_location


	/**
	 * Register BetterWeather VisualComposer support
	 */
	function register_vc_support() {

		// Check if Visual Composer is installed
		if ( ! defined( 'WPB_VC_VERSION' ) ) {
			return;
		}

		// Visual composer widget
		vc_map(
			array(
				"name"              => __( "BetterWeather Widget", 'better-studio' ),
				"base"              => "BetterWeather",
				"class"             => "",
				"weight"            => 8,
				"controls"          => "full",
				'admin_enqueue_css' => self::dir_url( 'includes/assets/css/vc-style.css?v=' . self::$version ),
				"params"            => array(
					array(
						"type"        => "textfield",
						"heading"     => __( "Location", 'better-studio' ),
						"admin_label" => TRUE,
						"param_name"  => "location",
						"value"       => "35.6705,139.7409",
						"description" => __( "Enter location ( latitude,longitude ) for showing forecast.", 'better-studio' ) . '<br>' . '<a target="_blank" href="http://better-studio.net/plugins/better-weather/stand-alone/#how-to-find-location">' . __( "How to find location values!?", 'better-studio' ) . '</a>',
						'group'       => __( 'General', 'better-studio' ),
					),
					array(
						"type"        => "textfield",
						"heading"     => __( "Location Custom Name", 'better-studio' ),
						"param_name"  => "location_name",
						"admin_label" => TRUE,
						"value"       => "",
						'group'       => __( 'General', 'better-studio' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Show Location Name?', 'better-studio' ),
						'param_name'  => 'show_location',
						'value'       => array(
							__( 'Yes', 'better-studio' ) => 'on',
							__( 'No', 'better-studio' )  => 'off',
						),
						'group'       => __( 'Style', 'better-studio' ),
						"admin_label" => FALSE,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Show Date?', 'better-studio' ),
						'param_name'  => 'show_date',
						'value'       => array(
							__( 'Yes', 'better-studio' ) => 'on',
							__( 'No', 'better-studio' )  => 'off',
						),
						'group'       => __( 'Style', 'better-studio' ),
						"admin_label" => FALSE,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Widget Style', 'better-studio' ),
						'param_name'  => 'style',
						"admin_label" => TRUE,
						'value'       => array(
							__( 'Modern Style', 'better-studio' ) => 'modern',
							__( 'Normal Style', 'better-studio' ) => 'normal',
						),
						'group'       => __( 'Style', 'better-studio' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Show next 4 days forecast!?', 'better-studio' ),
						'param_name'  => 'next_days',
						'value'       => array(
							__( 'Yes', 'better-studio' ) => 'on',
							__( 'No', 'better-studio' )  => 'off',
						),
						'group'       => __( 'Style', 'better-studio' ),
						"admin_label" => FALSE,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Background Style', 'better-studio' ),
						'param_name'  => 'bg_type',
						'value'       => array(
							__( 'Natural Photo', 'better-studio' ) => 'natural',
							__( 'Static Color', 'better-studio' )  => 'static',
						),
						'group'       => __( 'Style', 'better-studio' ),
						"admin_label" => FALSE,
					),
					array(
						"type"        => "colorpicker",
						"class"       => "",
						"heading"     => __( "Background Color", 'better-studio' ),
						"param_name"  => "bg_color",
						"value"       => '#4f4f4f',
						'group'       => __( 'Style', 'better-studio' ),
						"admin_label" => FALSE,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Icons Style', 'better-studio' ),
						'param_name'  => 'icons_type',
						'value'       => array(
							__( 'Animated Icons', 'better-studio' ) => 'animated',
							__( 'Static Icons', 'better-studio' )   => 'static',
						),
						'group'       => __( 'Style', 'better-studio' ),
						"admin_label" => FALSE,
					),
					array(
						"type"        => "colorpicker",
						"class"       => "",
						"heading"     => __( "Font Color", 'better-studio' ),
						"param_name"  => "font_color",
						"value"       => '#fff',
						'group'       => __( 'Style', 'better-studio' ),
						"admin_label" => FALSE,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Temperature Unit', 'better-studio' ),
						'param_name'  => 'unit',
						'value'       => array(
							__( 'Celsius', 'better-studio' )    => 'C',
							__( 'Fahrenheit', 'better-studio' ) => 'F',
						),
						'group'       => __( 'Style', 'better-studio' ),
						"admin_label" => FALSE,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Show Temperature Unit In Widget!?', 'better-studio' ),
						'param_name'  => 'show_unit',
						'value'       => array(
							__( 'No', 'better-studio' )  => 'off',
							__( 'Yes', 'better-studio' ) => 'on',
						),
						'group'       => __( 'Style', 'better-studio' ),
						"admin_label" => FALSE,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Auto detect user location via IP!?', 'better-studio' ),
						'param_name'  => 'visitor_location',
						'value'       => array(
							__( 'No', 'better-studio' )  => 'off',
							__( 'Yes', 'better-studio' ) => 'on',
						),
						"description" => __( 'Before using this you must read <a target="_blank" href="http://better-studio.net/plugins/better-weather/wp/#requests-note">this note</a>.', 'better-studio' ),
						'group'       => __( 'Style', 'better-studio' ),
						"admin_label" => FALSE,
					),
				)
			)
		);

		// Visual composer inline
		vc_map(
			array(
				"name"              => __( "BetterWeather Inline", 'better-studio' ),
				"base"              => "BetterWeather-inline",
				"class"             => "",
				"controls"          => "full",
				"weight"            => 8,
				'admin_enqueue_css' => self::dir_url( 'includes/assets/css/vc-style.css?v=' . self::$version ),
				"params"            => array(
					array(
						"type"        => "textfield",
						"class"       => "",
						"heading"     => __( "Location:", 'better-studio' ),
						"param_name"  => "location",
						"value"       => "35.6705,139.7409",
						"description" => __( "Enter location ( latitude,longitude ) for showing forecast.", 'better-studio' ) . '<br>' . '<a target="_blank" href="http://better-studio.net/plugins/better-weather/stand-alone/#how-to-find-location">' . __( "How to find location values!?", 'better-studio' ) . '</a>',
						"admin_label" => TRUE,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Inline Size:', 'better-studio' ),
						'param_name'  => 'inline_size',
						'value'       => array(
							__( 'Large', 'better-studio' )  => 'large',
							__( 'medium', 'better-studio' ) => 'medium',
							__( 'small', 'better-studio' )  => 'small',
						),
						"admin_label" => TRUE,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Icons Style:', 'better-studio' ),
						'param_name'  => 'icons_type',
						'value'       => array(
							__( 'Animated Icons', 'better-studio' ) => 'animated',
							__( 'Static Icons', 'better-studio' )   => 'static',
						),
						"admin_label" => FALSE,
					),
					array(
						"type"        => "colorpicker",
						"class"       => "",
						"heading"     => __( "Font Color:", 'better-studio' ),
						"param_name"  => "font_color",
						"value"       => '#000000',
						"admin_label" => FALSE,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Temperature Unit', 'better-studio' ),
						'param_name'  => 'unit',
						'value'       => array(
							__( 'Celsius', 'better-studio' )    => 'C',
							__( 'Fahrenheit', 'better-studio' ) => 'F',
						),
						"admin_label" => FALSE,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Show Temperature Unit In Widget!?', 'better-studio' ),
						'param_name'  => 'show_unit',
						'value'       => array(
							__( 'No', 'better-studio' )  => 'off',
							__( 'Yes', 'better-studio' ) => 'on',
						),
						"admin_label" => FALSE,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => __( 'Auto detect user location via IP!?', 'better-studio' ),
						'param_name'  => 'visitor_location',
						'value'       => array(
							__( 'No', 'better-studio' )  => 'off',
							__( 'Yes', 'better-studio' ) => 'on',
						),
						"description" => __( "Please note Forecast.io free accounts API calls per day is just 1000 and with enabling autodetect location you must do some pay to Forecast.io for calls over 1000!", 'better-studio' ),
						"admin_label" => FALSE,
					),
				)
			)
		);
	}


	/**
	 * return api key that saved in option panel
	 * @return string|bool
	 */
	static function get_api_key() {

		switch ( self::get_api_source() ) {

			case 'forecasts_io':
				return self::get_option( 'api_key' );
				break;

			case 'owm':
				return self::get_option( 'owm_api_key' );
				break;

			case 'yahoo':
				return '';
				break;

		}

		return self::get_option( 'api_key' );
	}


	/**
	 * return api key that saved in option panel
	 * @return string|bool
	 */
	static function get_api_source() {

		switch ( self::get_option( 'forecasts_source' ) ) {

			// First source that was setup
			case '':
				if ( self::get_option( 'api_key' ) != '' ) {
					return 'forecasts_io';
				} elseif ( self::get_option( 'owm_api_key' ) != '' ) {
					return 'owm';
				} elseif ( self::get_option( 'aerisweather_app_id' ) != '' && self::get_option( 'aerisweather_api_key' ) != '' ) {
					return 'aerisweather';
				} else {
					return 'yahoo'; // default
				}

				break;


			// selected source
			default:
				return self::get_option( 'forecasts_source' );
				break;

		}

	} // get_API_Source


	/**
	 * Clears all cache inside data base
	 *
	 * Callback
	 *
	 * @return array
	 */
	public static function clear_cache_all() {

		// don't print any error or notice!
		ob_start();

		// Delete all pages css transients
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->options WHERE meta_key LIKE %s", 'bw_location_%' ) );

		ob_end_clean();

		return array(
			'status' => 'succeed',
			'msg'    => __( 'All Caches was cleaned.', 'better-studio' ),
		);
	}


	/**
	 * Filter callback: Used for changing current language on importing translation panel data
	 *
	 * @param $result
	 * @param $data
	 * @param $args
	 *
	 * @return array
	 */
	function callback_panel_import_result( $result, $data, $args ) {

		// check panel
		if ( $args['panel-id'] != self::$panel_id ) {
			return $result;
		}

		// change messages
		if ( $result['status'] == 'succeed' ) {
			$result['msg'] = __( 'BetterWeather options imported successfully.', 'better-studio' );
		} else {
			if ( $result['msg'] == __( 'Imported data is not for this panel.', 'better-studio' ) ) {
				$result['msg'] = __( 'Imported data is not for BetterWeather.', 'better-studio' );
			} else {
				$result['msg'] = __( 'An error occurred while importing options.', 'better-studio' );
			}
		}

		return $result;
	}


	/**
	 * Filter callback: Used for resetting current language on resetting panel
	 *
	 * @param $options
	 * @param $result
	 *
	 * @return array
	 */
	function callback_panel_reset_result( $result, $options ) {

		// check panel
		if ( $options['id'] != self::$panel_id ) {
			return $result;
		}

		// change messages
		if ( $result['status'] == 'succeed' ) {
			$result['msg'] = __( 'BetterWeather options reset to default.', 'better-studio' );
		} else {
			$result['msg'] = __( 'An error occurred while resetting options.', 'better-studio' );
		}

		return $result;
	}


	/**
	 * Callback: Enable oculus error logging system for plugin
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
	function oculus_logger( $bool, $product_dir, $type_dir ) {

		if ( $type_dir === 'plugins' && $product_dir === 'better-weather' ) {
			return FALSE;
		}

		return $bool;
	}
} // Better_Weather
