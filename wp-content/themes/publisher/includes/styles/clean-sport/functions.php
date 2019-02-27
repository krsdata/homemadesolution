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
					'%%widget-id%% .widget-heading .h-text',
					'%%widget-id%% .section-heading .h-text',
				),
				'prop'     => array(
					'background-color' => '%%value%% !important'
				),
			),
		);

		$fields['bf-widget-title-color'] = array(
			'field' => 'bf-widget-title-color',
			array(
				'selector' => array(
					'%%widget-id%% .widget-heading .h-text',
					'%%widget-id%% .section-heading .h-text',
				),
				'prop'     => array(
					'color' => '%%value%% !important'
				),
			),
		);

		$fields['bf-widget-bg-color'] = array(
			'field' => 'bf-widget-bg-color',
			array(
				'selector' => array(
					'%%widget-id%%',
				),
				'prop'     => array(
					'background' => '%%value%%; padding: 20px;',
				),
			),
			array(
				'selector' => array(
					'%%widget-id%% .section-heading.multi-tab .bs-pretty-tabs-container',
				),
				'prop'     => array(
					'background' => '%%value%%',
				),
			),
		);

		return $fields;
	} // publisher_widgets_custom_css
}
