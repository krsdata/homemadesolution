<?php

/**
 * Class Publisher_Style_Option
 */
abstract class Publisher_Theme_Style {

	/**
	 * Current style id
	 *
	 * @var string
	 */
	public $style_id = '';


	/**
	 * Current demo id
	 *
	 * @var string
	 */
	public $demo_id = '';


	/**
	 * style initializer.
	 */
	public function __construct() {

		/*
		 * Enqueue assets (css, js)
		 */
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 100 );

		$this->include_functions();

	}


	/**
	 * Used to add custom functions for style or demo
	 *
	 * @return mixed
	 */
	abstract function include_functions();


	/**
	 * Enqueues style assets
	 *
	 * @return mixed
	 */
	abstract function register_assets();


	/**
	 * Returns std id of current style
	 *
	 * @return string
	 */
	function get_std_id() {
		return 'std-' . $this->style_id;
	}


	/**
	 * Returns css id of current style
	 *
	 * @return string
	 */
	function get_css_id() {
		return 'css-' . $this->style_id;
	}


	/**
	 * Returns list of all styles exclude current style
	 *
	 * @return string
	 */
	function get_styles_exc_current() {

		$styles_exc_current = array_flip( Publisher_Theme_Styles_Manager::get_styles() );
		unset( $styles_exc_current[ $this->style_id ] );

		return array_keys( $styles_exc_current );
	}

} // Publisher_Theme_Style
