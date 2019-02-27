<?php
/***
 *  BetterFramework is BetterStudio framework for themes and plugins.
 *
 *  ______      _   _             ______                                           _
 *  | ___ \    | | | |            |  ___|                                         | |
 *  | |_/ / ___| |_| |_ ___ _ __  | |_ _ __ __ _ _ __ ___   _____      _____  _ __| | __
 *  | ___ \/ _ \ __| __/ _ \ '__| |  _| '__/ _` | '_ ` _ \ / _ \ \ /\ / / _ \| '__| |/ /
 *  | |_/ /  __/ |_| ||  __/ |    | | | | | (_| | | | | | |  __/\ V  V / (_) | |  |   <
 *  \____/ \___|\__|\__\___|_|    \_| |_|  \__,_|_| |_| |_|\___| \_/\_/ \___/|_|  |_|\_\
 *
 *  Copyright © 2017 Better Studio
 *
 *
 *  Our portfolio is here: http://themeforest.net/user/Better-Studio/portfolio
 *
 *  \--> BetterStudio, 2017 <--/
 */


/**
 * Manage all shortcode element registration
 */
class BF_Shortcodes_Manager {


	/**
	 * Contain All shortcodes
	 *
	 * @var array
	 */
	public static $shortcodes = array();


	/**
	 * Instances of all BetterFramework active shortcode
	 *
	 * @var array
	 */
	private static $shortcode_instances = array();


	function __construct() {

		// Base class for all shortcodes
		if ( ! class_exists( 'BF_Shortcode' ) ) {
			include BF_PATH . 'shortcode/class-bf-shortcode.php';
		}

		// Filter active shortcodes
		self::load_shortcodes();

		// Initialize active shortcodes
		self::init_shortcodes();

		// Add widgets
		add_action( 'widgets_init', array( __CLASS__, 'load_widgets' ) );
	}


	/**
	 * Get active short codes from bf_active_shortcodes filter
	 */
	public static function load_shortcodes() {
		self::$shortcodes = apply_filters( 'better-framework/shortcodes', array() );
	}


	/**
	 * Initialize active shortcodes
	 */
	public static function init_shortcodes() {

		foreach ( self::$shortcodes as $key => $shortcode ) {

			self::factory( $key, $shortcode );

		}

	}


	/**
	 * Factory For All BF Active Shortcodes
	 *
	 * @param string $key
	 * @param array  $options
	 * @param bool   $instance
	 *
	 * @return \BF_Shortcode|null
	 */
	static function factory( $key = '', $options = array(), $instance = FALSE ) {

		if ( $key == '' ) {
			return NULL;
		}

		if ( $instance === FALSE ) {
			if ( is_admin() ) {
				if ( ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] === 'vc_edit_form' ) || ! bf_is_doing_ajax() ) {
					$instance = TRUE;
				}
			} elseif ( bf_get_current_sidebar() ) { // fix for inside sidebar call od factory method
				$instance = TRUE;
			}
		}

		//TODO: we cannot make more than one instance of each shortcode
		//we need it for creating instance with separate attribute
		if ( isset( self::$shortcode_instances[ $key ] ) ) {
			return self::$shortcode_instances[ $key ];
		} else {

			//
			// Short Code That Haves Specific Handler Out Side Of BF
			//
			if ( isset( self::$shortcodes[ $key ]['shortcode_class'] ) ) {

				// Create instance for shortcode class
				if ( $instance ) {

					$class = self::$shortcodes[ $key ]['shortcode_class'];

					self::$shortcode_instances[ $key ] = new $class( $key, self::$shortcodes[ $key ] );

					// register shortcode and be theme check plugin friend
					call_user_func(
						'add' . '_' . 'shortcode',
						self::$shortcode_instances[ $key ]->id,
						array(
							self::$shortcode_instances[ $key ],
							'handle_shortcode'
						)
					);

					return self::$shortcode_instances[ $key ];
				}

				// register shortcode and be theme check plugin friend
				call_user_func( 'add' . '_' . 'shortcode', $key, array( __CLASS__, 'handle_shortcodes' ) );

				return NULL;
			}

			//
			// Active Shortcodes In Inner BF
			//
			$class = bf_convert_string_to_class_name( $key, 'BF_', '_Shortcode' );

			if ( ! class_exists( $class ) ) {
				if ( file_exists( bf_get_dir( 'shortcode/shortcodes/class-bf-' . $key . '-shortcode.php' ) ) ) {
					include 'shortcode/shortcodes/class-bf-' . $key . '-shortcode.php';
				}
			}

			self::$shortcode_instances[ $key ] = new $class( $key, $options );

			return self::$shortcode_instances[ $key ];
		}
	}


	/**
	 * Handle shortcodes wrapper
	 *
	 * @param $atts
	 * @param $content
	 * @param $shortcode_id
	 *
	 * @return string
	 */
	public static function handle_shortcodes( $atts, $content, $shortcode_id ) {

		if ( isset( self::$shortcode_instances[ $shortcode_id ] ) ) {
			return self::$shortcode_instances[ $shortcode_id ]->handle_shortcode( $atts, $content );
		}

		// if this shortcode is not valid
		if ( empty( self::$shortcodes[ $shortcode_id ]['shortcode_class'] ) ) {
			return '';
		}

		$class = self::$shortcodes[ $shortcode_id ]['shortcode_class'];

		self::$shortcode_instances[ $shortcode_id ] = new $class( $shortcode_id, self::$shortcodes[ $shortcode_id ] );

		return self::$shortcode_instances[ $shortcode_id ]->handle_shortcode( $atts, $content );
	}


	/**
	 * Load widget for shortcode
	 */
	public static function load_widgets() {

		foreach ( self::$shortcodes as $key => $shortcode ) {
			if ( isset( $shortcode['widget_class'] ) && class_exists( $shortcode['widget_class'] ) && is_subclass_of( $shortcode['widget_class'], 'WP_Widget' ) ) {
				register_widget( $shortcode['widget_class'] );
			}
		}
	}

}
