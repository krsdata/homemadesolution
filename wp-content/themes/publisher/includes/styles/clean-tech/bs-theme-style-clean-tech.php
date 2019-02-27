<?php

/**
 * Publisher
 *      -> Clean Tech Style
 */
class Publisher_Theme_Style_Clean_Tech extends Publisher_Theme_Style {

	/**
	 * Style initializer
	 */
	public function __construct() {

		$this->style_id = 'clean-tech';

		add_filter( 'better-framework/panel/' . publisher_get_theme_panel_id() . '/std', array(
			$this,
			'panel_std'
		), 20 );

		add_filter( 'better-framework/panel/' . publisher_get_theme_panel_id() . '/css', array(
			$this,
			'panel_css'
		), 20 );

		add_filter( 'better-framework/taxonomy/metabox/better-category-options/css', array(
			$this,
			'customize_category_fields'
		), 100 );

		if ( Publisher_Theme_Styles_Manager::$current_style === $this->style_id ) {
			add_filter( 'publisher-theme-core/page-templates/config', array(
				$this,
				'page_templates_config'
			) );
		}

		parent::__construct();
	}


	/**
	 * Demo panel STD's
	 *
	 * @param $fields
	 *
	 * @return mixed
	 */
	function panel_std( $fields ) {
		include PUBLISHER_THEME_PATH . 'includes/styles/clean-tech/panel-std.php';

		return $fields;
	}


	/**
	 * Demo panel STD's
	 *
	 * @param $fields
	 *
	 * @return mixed
	 */
	function panel_css( $fields ) {
		include PUBLISHER_THEME_PATH . 'includes/styles/clean-tech/panel-css.php';

		return $fields;
	}


	/**
	 * Adds custom functions of style
	 */
	function include_functions() {
		if ( $this->style_id == Publisher_Theme_Styles_Manager::$current_style ) {
			include_once Publisher_Theme_Styles_Manager::get_path( 'clean-tech/functions.php' );
		}
	}


	/**
	 * Enqueue current style css file
	 */
	function register_assets() {

		bf_enqueue_style(
			'publisher-theme-clean-tech',
			bf_append_suffix( Publisher_Theme_Styles_Manager::get_uri( 'clean-tech/style' ), '.css' ),
			array( 'publisher' ),
			bf_append_suffix( Publisher_Theme_Styles_Manager::get_path( 'clean-tech/style' ), '.css' ),
			Better_Framework()->theme()->get( 'Version' )
		);
	}


	/**
	 * Modify each style or demo category fields
	 *
	 * @param $fields
	 *
	 * @return
	 */
	function customize_category_fields( $fields ) {

		$term_color = include PUBLISHER_THEME_PATH . 'includes/options/category-css-term_color.php';

		// fix section heading bg color
		$term_color['bg_color']['selector'][] = '.section-heading.main-term-%%id%%:after';

		$term_color['color']['selector'][] = '.section-heading.main-term-%%id%% .h-text.main-term-%%id%%';
		$term_color['color']['selector'][] = '.section-heading .h-text.main-term-%%id%%:hover';
		$term_color['color']['selector'][] = '.section-heading.multi-tab .main-link.main-term-%%id%%:hover .h-text';

		$fields['term_color'][ $this->get_css_id() ] = $term_color;
		unset( $term_color );

		return $fields;
	}


	/**
	 * Injects Page templates for current style
	 *
	 * @param $page_templates
	 *
	 * @return mixed
	 */
	function page_templates_config( $page_templates ) {

		publisher_set_global( 'style-page-template', $this->style_id );

		include PUBLISHER_THEME_PATH . 'includes/styles/' . $this->style_id . '/page-templates.php';

		publisher_unset_global( 'style-page-template' );

		return $page_templates;
	}

} // Publisher_Theme_Style_Clean_Tech
