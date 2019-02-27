<?php

/**
 * Better Weather Shortcode
 */
class Better_Weather_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'BetterWeather';

		$this->name = __( 'BetterWeather', 'better-studio' );

		$this->description = __( 'Modern listing with 2, 3 and 4 column option', 'better-studio' );

		$this->icon = ( '' . 'images/vc-' . $id . '.png' );

		$_options = array(
			'defaults' => array(

				'title' => '',

				'location'        => '',
				'locationName'    => '',
				'fontColor'       => '#fff',
				'bgColor'         => '#4f4f4f',
				'style'           => 'modern',
				'nextDays'        => 'on',
				'visitorLocation' => FALSE,
				'bgType'          => 'natural',
				'iconsType'       => 'animated',
				'unit'            => 'C',
				'showUnit'        => 'off',
				'showDate'        => 'on',
				'showLocation'    => 'on',
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
			"locationName"    => isset( $atts['location_name'] ) ? $atts['location_name'] : '',
			"fontColor"       => isset( $atts['font_color'] ) ? $atts['font_color'] : '#fff',
			"bgColor"         => isset( $atts['bg_color'] ) ? $atts['bg_color'] : '#4f4f4f',
			"style"           => isset( $atts['style'] ) ? $atts['style'] : 'modern',
			"nextDays"        => isset( $atts['next_days'] ) ? $atts['next_days'] : 'on',
			"visitorLocation" => isset( $atts['visitor_location'] ) ? $atts['visitor_location'] : FALSE,
			"showLocation"    => isset( $atts['show_location'] ) ? $atts['show_location'] : 'on',
			"showDate"        => isset( $atts['show_date'] ) ? $atts['show_date'] : 'on',
			"unit"            => isset( $atts['unit'] ) ? $atts['unit'] : 'C',
			"showUnit"        => isset( $atts['show_unit'] ) ? $atts['show_unit'] : 'off',
		);

		if ( ! isset( $atts['bg_type'] ) ) {
			$atts['bg_type'] = 'natural';
		}

		$options['showLocation']    = $options['showLocation'] == 'on' ? TRUE : FALSE;
		$options['nextDays']        = $options['nextDays'] == 'on' ? TRUE : FALSE;
		$options['visitorLocation'] = $options['visitorLocation'] == 'on' ? TRUE : FALSE;
		$options['showUnit']        = $options['showUnit'] == 'on' ? TRUE : FALSE;
		$options['showDate']        = $options['showDate'] == 'on' ? TRUE : FALSE;

		if ( $atts['bg_type'] == 'static' ) {
			$options['naturalBackground'] = FALSE;
		}

		if ( ! isset( $atts['icons_type'] ) ) {
			$atts['icons_type'] = 'animated';
		}

		if ( $atts['icons_type'] == 'static' ) {
			$options['animatedIcons'] = FALSE;
		} else {
			$options['animatedIcons'] = TRUE;
		}

		return BW_Generator_Factory::generator()->generate( $options, FALSE );

	}

}