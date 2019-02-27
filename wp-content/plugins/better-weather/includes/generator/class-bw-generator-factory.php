<?php

/**
 * Handles generation off all generators
 *
 * Class BW_Generator_Factory
 */
class BW_Generator_Factory {

	/**
	 * instance of generator
	 *
	 * @var BW_Frontend
	 */
	private static $instance;

	/**
	 * used for getting instance of generator
	 *
	 * @return BW_Frontend
	 */
	public static function generator() {

		if ( ! isset( self::$instance ) || is_null( self::$instance ) ) {

			require_once Better_Weather::dir_path( 'includes/generator/class-bw-forecast-facade.php' );
			require_once Better_Weather::dir_path( 'includes/generator/class-bw-frontend.php' );

			self::$instance = new BW_Frontend();

			self::$instance->init();

		}

		return self::$instance;
	}

}