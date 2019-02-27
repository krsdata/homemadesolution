<?php

if ( ! function_exists( 'publisher_widgets_custom_css' ) ) {
	/**
	 * Widgets Custom css parameters
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	function publisher_widgets_custom_css( $fields ) {

		$fields['bf-widget-title-bg-color'] = array(
			'field' => 'bf-widget-title-bg-color',
			array(
				'selector' => array(
					'%%widget-id%% .widget-heading',
					'%%widget-id%% .section-heading',
				),
				'prop'     => array(
					'background-color' => '%%value%% !important'
				),
			),
			array(
				'selector' => array(
					'%%widget-id%% .widget-heading:after',
					'%%widget-id%% .section-heading:after',
				),
				'prop'     => array(
					'border-top-color' => '%%value%% !important'
				),
			),
		);

		$fields['bf-widget-title-color'] = array(
			'field' => 'bf-widget-title-color',
			array(
				'selector' => array(
					'%%widget-id%% .widget-heading > .h-text',
					'%%widget-id%% .section-heading .h-text',
				),
				'prop'     => array(
					'color' => '%%value%% !important'
				),
			),
		);

		$fields[] = array(
			'field' => 'bf-widget-bg-color',
			array(
				'selector' => array(
					'%%widget-id%%',
				),
				'prop'     => array(
					'background' => '%%value%%; padding: 20px;',
				),
			),
		);

		return $fields;
	} // publisher_widgets_custom_css
}


if ( ! function_exists( 'publisher_fix_shortcode_vc_style' ) ) {
	/**
	 * Fixes shortcode style for generated style from VC
	 *
	 * @param $atts
	 */
	function publisher_fix_shortcode_vc_style( &$atts ) {

		publisher_general_fix_shortcode_vc_style( $atts ); // general fixes

		return; // It's for inner style!
	}
}// publisher_fix_shortcode_vc_style