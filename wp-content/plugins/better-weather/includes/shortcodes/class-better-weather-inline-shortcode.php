<?php

/**
 * Better Weather Inline Shortcode
 */
class Better_Weather_Inline_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'BetterWeather-inline';

		$_options = array(
			'defaults' => array(
				'location'         => '',
				'visitor_location' => FALSE,
				'font_color'       => '#000000',
				'icons_type'       => 'animated',
				'inline_size'      => 'large',
				"unit"             => 'C',
				"show_unit"        => FALSE,
			),

			'have_widget'    => TRUE,
			'have_vc_add_on' => FALSE,
		);

		$_options = wp_parse_args( $_options, $options );

		parent::__construct( $id, $_options );

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

		$options = array(
			"location"        => isset( $atts['location'] ) ? $atts['location'] : '',
			"fontColor"       => isset( $atts['font_color'] ) ? $atts['font_color'] : '#fff',
			"visitorLocation" => isset( $atts['visitor_location'] ) ? $atts['visitor_location'] : FALSE,
			"inlineSize"      => isset( $atts['inline_size'] ) ? $atts['inline_size'] : 'medium',
			"unit"            => isset( $atts['unit'] ) ? $atts['unit'] : 'C',
			"iconsType"       => isset( $atts['icons_type'] ) ? $atts['icons_type'] : 'animated',
			"showUnit"        => isset( $atts['show_unit'] ) ? $atts['show_unit'] : 'off',
		);

		$options['visitorLocation'] = $options['visitorLocation'] == 'on' ? TRUE : FALSE;

		$options['showUnit'] = $options['showUnit'] == 'on' ? TRUE : FALSE;

		if ( $options['iconsType'] == 'static' ) {
			$options['animatedIcons'] = FALSE;
		}

		return BW_Generator_Factory::generator()->generate_inline( $options, FALSE );

	}

}