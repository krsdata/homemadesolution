<?php

// include it manually earlier to get styles work!
include PUBLISHER_THEME_PATH . 'includes/libs/better-framework/functions/multilingual.php';

// Init style manager
include PUBLISHER_THEME_PATH . 'includes/styles/publisher-theme-style.php';
include PUBLISHER_THEME_PATH . 'includes/styles/publisher-theme-styles-manager.php';

if ( ! function_exists( 'publisher_styles_config' ) ) {
	/**
	 * List of all styles with configuration
	 *
	 * @return array
	 */
	function publisher_styles_config() {

		static $theme_version;

		if ( ! $theme_version ) {
			$theme = wp_get_theme();

			if ( $theme->get( 'Template' ) ) {
				$theme = wp_get_theme( $theme->get( 'Template' ) );
			}

			$theme_version = $theme->get( 'Version' );
		}


		/*
		 * attrs for styles:
		 * - img
		 * - label
		 * - views
		 * - options
		 * - functions
		 * - css
		 * - js
		 */

		return array(

			//
			// Pure Styles
			//
			'pure-magazine'    => array(
				'img'   => PUBLISHER_THEME_URI . 'includes/demos/pure-magazine/thumbnail.png?v=' . $theme_version,
				'label' => __( 'Pure Magazine', 'publisher' ),
				'views' => FALSE,
				'info'  => array(
					'cat'  => array(
						__( 'Magazine', 'publisher' ),
					),
					'type' => array(
						__( 'Pure', 'publisher' ),
					),
				)
			),

			//
			// Clean Styles
			//
			'clean-magazine'   => array(
				'img'   => PUBLISHER_THEME_URI . 'includes/demos/clean-magazine/thumbnail.png?v=' . $theme_version,
				'label' => __( 'Clean Magazine', 'publisher' ),
				'views' => FALSE,
				'info'  => array(
					'cat'  => array(
						__( 'Magazine', 'publisher' ),
					),
					'type' => array(
						__( 'Clean', 'publisher' ),
					),
				)
			),
			'clean-tech'       => array(
				'img'   => PUBLISHER_THEME_URI . 'includes/demos/clean-tech/thumbnail.png?v=' . $theme_version,
				'label' => __( 'Clean Tech', 'publisher' ),
				'views' => FALSE,
				'info'  => array(
					'cat'  => array(
						__( 'Magazine', 'publisher' ),
					),
					'type' => array(
						__( 'Clean', 'publisher' ),
					),
				)
			),
			'clean-video'      => array(
				'img'   => PUBLISHER_THEME_URI . 'includes/demos/clean-video/thumbnail.png?v=' . $theme_version,
				'label' => __( 'Clean Video', 'publisher' ),
				'views' => FALSE,
				'info'  => array(
					'cat'  => array(
						__( 'Magazine', 'publisher' ),
					),
					'type' => array(
						__( 'Clean', 'publisher' ),
					),
				)
			),
			'clean-blog'       => array(
				'img'   => PUBLISHER_THEME_URI . 'includes/demos/clean-blog/thumbnail.png?v=' . $theme_version,
				'label' => __( 'Clean Blog', 'publisher' ),
				'views' => FALSE,
				'info'  => array(
					'cat'  => array(
						__( 'Blog', 'publisher' ),
					),
					'type' => array(
						__( 'Clean', 'publisher' ),
					),
				)
			),
			'clean-design'     => array(
				'img'   => PUBLISHER_THEME_URI . 'includes/demos/clean-design/thumbnail.png?v=' . $theme_version,
				'label' => __( 'Clean Design', 'publisher' ),
				'views' => FALSE,
				'info'  => array(
					'cat'  => array(
						__( 'Magazine', 'publisher' ),
					),
					'type' => array(
						__( 'Clean', 'publisher' ),
					),
				)
			),
			'clean-fashion'    => array(
				'img'   => PUBLISHER_THEME_URI . 'includes/demos/clean-fashion/thumbnail.png?v=' . $theme_version,
				'label' => __( 'Clean Fashion', 'publisher' ),
				'views' => FALSE,
				'info'  => array(
					'cat'  => array(
						__( 'Magazine', 'publisher' ),
					),
					'type' => array(
						__( 'Clean', 'publisher' ),
					),
				)
			),
			'clean-sport'      => array(
				'img'   => PUBLISHER_THEME_URI . 'includes/demos/clean-sport/thumbnail.png?v=' . $theme_version,
				'label' => __( 'Clean Sport', 'publisher' ),
				'views' => FALSE,
				'info'  => array(
					'cat'  => array(
						__( 'Magazine', 'publisher' ),
					),
					'type' => array(
						__( 'Clean', 'publisher' ),
					),
				)
			),


			//
			// Classic Styles
			//
			'classic-magazine' => array(
				'img'   => PUBLISHER_THEME_URI . 'includes/demos/classic-magazine/thumbnail.png?v=' . $theme_version,
				'label' => __( 'Classic Magazine', 'publisher' ),
				'views' => FALSE,
				'info'  => array(
					'cat'  => array(
						__( 'Magazine', 'publisher' ),
					),
					'type' => array(
						__( 'Classic', 'publisher' ),
					),
				)
			),
			'classic-blog'     => array(
				'img'   => PUBLISHER_THEME_URI . 'includes/demos/classic-blog/thumbnail.png?v=' . $theme_version,
				'label' => __( 'Classic Blog', 'publisher' ),
				'views' => FALSE,
				'info'  => array(
					'cat'  => array(
						__( 'Blog', 'publisher' ),
					),
					'type' => array(
						__( 'Classic', 'publisher' ),
					),
				)
			),

		);
	} // publisher_styles_config
}


if ( ! function_exists( 'bf_get_panel_default_style' ) ) {
	/**
	 * Handy function to get panels default style field id
	 *
	 * @param string $panel_id
	 *
	 * @return string
	 */
	function bf_get_panel_default_style( $panel_id = '' ) {

		if ( $panel_id == publisher_get_theme_panel_id() ) {
			return publisher_get_style() === 'default' ? 'clean-magazine' : publisher_get_style();
		}

		return 'default';
	}
}


if ( ! function_exists( 'publisher_get_style' ) ) {
	/**
	 * Used to get current active style.
	 *
	 * Default style: general
	 *
	 * @return  string
	 */
	function publisher_get_style() {

		static $style;

		if ( $style ) {
			return $style;
		}

		$lang = bf_get_current_language_option_code();

		// current lang style or default none lang
		$style = get_option( publisher_get_theme_panel_id() . $lang . '_current_style' );

		// check
		if ( $style === FALSE && ! empty( $lang ) ) {
			$style = get_option( publisher_get_theme_panel_id() . '_current_style' );
		}

		if ( $style === FALSE || empty( $style ) ) {
			$style = 'clean-magazine';
		}

		return $style;
	}
}

// Init styles
if ( class_exists( 'Publisher_Theme_Styles_Manager' ) ) {
	new Publisher_Theme_Styles_Manager();
}
