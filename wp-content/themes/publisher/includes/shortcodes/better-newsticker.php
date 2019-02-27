<?php

/**
 * BetterNewsTicker Shortcode
 */
class Better_Newsticker_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'better-newsticker';

		$options = array_merge( array(
			'defaults'       => array(
				'title'           => publisher_translation_get( 'newsticker_trending' ),
				'show_title'      => 0,
				'ticker_text'     => publisher_translation_get( 'newsticker_trending' ),
				'speed'           => 12,
				'count'           => 10,
				'cat'             => '',
				'tag'             => '',
				'class'           => '',
				'bg_color'        => '',
				'bs-show-desktop' => TRUE,
				'bs-show-tablet'  => TRUE,
				'bs-show-phone'   => TRUE,
			),
			'have_widget'    => FALSE,
			'have_vc_add_on' => TRUE,
		), $options );

		if ( isset( $options['shortcode_class'] ) ) {
			$_options['shortcode_class'] = $options['shortcode_class'];
		}

		parent::__construct( $id, $options );
	}


	/**
	 * Filter custom css codes for shortcode widget!
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	function register_custom_css( $fields ) {
		return $fields;
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map( array(
			"name"           => __( 'News Ticker', 'publisher' ),
			"base"           => $this->id,
			"weight"         => 10,
			"wrapper_height" => 'full',

			"category" => __( 'Publisher', 'publisher' ),
			"params"   => array(
				array(
					"type"        => 'textfield',
					"admin_label" => TRUE,
					"heading"     => __( 'News Ticker Text', 'publisher' ),
					"param_name"  => 'ticker_text',
					"value"       => $this->defaults['ticker_text'],
					'group'       => __( 'Newsticker', 'publisher' ),
				),
				array(
					"type"        => 'bf_slider',
					"admin_label" => TRUE,
					"heading"     => __( 'Speed', 'publisher' ),
					"param_name"  => 'speed',
					"value"       => $this->defaults['speed'],
					'dimension'   => 'second',
					'min'         => '3',
					'max'         => '60',
					'step'        => '1',
					'std'         => '15',
					'description' => __( 'Set the speed of the ticker cycling, in second.', 'publisher' ),
					'group'       => __( 'Newsticker', 'publisher' ),
				),
				array(
					"type"        => 'bf_select',
					"admin_label" => TRUE,
					"heading"     => __( 'Category', 'publisher' ),
					"param_name"  => 'cat',
					"value"       => $this->defaults['cat'],
					'options'     => array(
						'' => __( 'All Posts', 'publisher' ),
						array(
							'label'   => __( 'Categories', 'publisher' ),
							'options' => array(
								'category_walker' => 'category_walker'
							),
						),
					),
					'group'       => __( 'Newsticker', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => TRUE,
					"heading"     => __( 'Number of Posts', 'publisher' ),
					"param_name"  => 'count',
					"value"       => $this->defaults['count'],
					'group'       => __( 'Newsticker', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => TRUE,
					"heading"     => __( 'Title', 'publisher' ),
					"param_name"  => 'title',
					"value"       => $this->defaults['title'],
					'group'       => __( 'Heading', 'publisher' ),
				),
				array(
					"type"       => 'bf_switchery',
					"heading"    => __( 'Show Title?', 'publisher' ),
					"param_name" => 'show_title',
					"value"      => $this->defaults['show_title'],
					'group'      => __( 'Heading', 'publisher' ),
				),
				array(
					"type"          => 'bf_switchery',
					"heading"       => __( 'Show on Desktop', 'publisher' ),
					"param_name"    => 'bs-show-desktop',
					"admin_label"   => FALSE,
					"value"         => $this->defaults['bs-show-desktop'],
					'section_class' => 'style-floated-left bordered bf-css-edit-switch',
					'group'         => __( 'Design options', 'publisher' ),
				),
				array(
					"type"          => 'bf_switchery',
					"heading"       => __( 'Show on Tablet Portrait', 'publisher' ),
					"param_name"    => 'bs-show-tablet',
					"admin_label"   => FALSE,
					"value"         => $this->defaults['bs-show-tablet'],
					'section_class' => 'style-floated-left bordered bf-css-edit-switch',
					'group'         => __( 'Design options', 'publisher' ),
				),
				array(
					"type"          => 'bf_switchery',
					"heading"       => __( 'Show on Phone', 'publisher' ),
					"param_name"    => 'bs-show-phone',
					"admin_label"   => FALSE,
					"value"         => $this->defaults['bs-show-phone'],
					'section_class' => 'style-floated-left bordered bf-css-edit-switch',
					'group'         => __( 'Design options', 'publisher' ),
				),

				array(
					'type'       => 'css_editor',
					'heading'    => __( 'CSS box', 'publisher' ),
					'param_name' => 'css',
					'group'      => __( 'Design options', 'publisher' ),
				),
				array(
					'type'          => 'textfield',
					'heading'       => __( 'Custom CSS Class', 'publisher' ),
					'param_name'    => 'custom-css-class',
					'admin_label'   => FALSE,
					'value'         => '',
					'section_class' => 'bf-section-two-column',
					'group'         => __( 'Design options', 'publisher' ),
				),
				array(
					'type'          => 'textfield',
					'heading'       => __( 'Custom ID', 'publisher' ),
					'param_name'    => 'custom-id',
					'admin_label'   => FALSE,
					'value'         => '',
					'section_class' => 'bf-section-two-column',
					'group'         => __( 'Design options', 'publisher' ),
				),
			)
		) );

	}

	/**
	 * Handle displaying of shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function display( array $atts, $content = '' ) {
		ob_start();

		publisher_set_prop( 'shortcode-better-newsticker', $atts );

		publisher_get_view( 'shortcodes', 'better-newsticker' );

		publisher_clear_props();
		publisher_clear_query();

		return ob_get_clean();
	}
}
