<?php
/**
 * widget.php
 *---------------------------
 * Registers options for widgets
 *
 */


// Define general widget fields and values
add_filter( 'better-framework/widgets/options/general', 'publisher_widgets_general_fields', 100 );
add_filter( 'better-framework/widgets/options/general/bf-widget-title-bg-color/default', 'publisher_general_widget_title_bg_color_field_default', 100 );
add_filter( 'better-framework/widgets/options/general/bf-widget-title-color/default', 'publisher_general_widget_title_color_field_default', 100 );
add_filter( 'better-framework/widgets/options/general/bf-widget-bg-color/default', 'publisher_general_widget_bg_color_field_default', 100 );

// Define custom css for widgets
add_filter( 'better-framework/css/widgets', 'publisher_widgets_custom_css', 100 );

if ( ! function_exists( 'publisher_widgets_general_fields' ) ) {
	/**
	 * Filter widgets general fields
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	function publisher_widgets_general_fields( $fields ) {

		$fields[] = 'bf-widget-title-bg-color';
		$fields[] = 'bf-widget-title-color';
		$fields[] = 'bf-widget-bg-color';

		$fields[] = 'bf-widget-title-icon';
		$fields[] = 'bf-widget-title-link';

		$fields[] = 'bf-widget-show-desktop';
		$fields[] = 'bf-widget-show-tablet';
		$fields[] = 'bf-widget-show-mobile';

		$fields[] = 'bf-widget-custom-class';
		$fields[] = 'bf-widget-custom-id';

		$fields[] = 'bf-widget-listing-settings';

		return $fields;

	} // publisher_widgets_general_fields
}


if ( ! function_exists( 'publisher_general_widget_title_bg_color_field_default' ) ) {
	/**
	 * Default value for widget title heading color
	 *
	 * @param $value
	 *
	 * @return string
	 */
	function publisher_general_widget_title_bg_color_field_default( $value ) {
		return publisher_get_option( 'widget_title_bg_color' );
	}
}


if ( ! function_exists( 'publisher_general_widget_title_color_field_default' ) ) {
	/**
	 * Default value for widget title text color
	 *
	 * @param $value
	 *
	 * @return string
	 */
	function publisher_general_widget_title_color_field_default( $value ) {
		return '';
	}
}


if ( ! function_exists( 'publisher_general_widget_bg_color_field_default' ) ) {
	/**
	 * Default value for widget title heading color
	 *
	 * @param $value
	 *
	 * @return string
	 */
	function publisher_general_widget_bg_color_field_default( $value ) {
		return publisher_get_option( 'widget_bg_color' );
	}
}


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
			0       => array(
				'selector' => array(
					'%%widget-id%% .widget-heading > .h-text',
					'%%widget-id%% .section-heading > .h-text',
				),
				'prop'     => array(
					'color' => '%%value%%',
				),
			),
			array(
				'selector' => array(
					'%%widget-id%% .widget-heading:after',
					'%%widget-id%% .section-heading:after',
				),
				'prop'     => array(
					'background' => '%%value%%'
				),
			),
		);

		$fields['bf-widget-title-color'] = array(
			'field' => 'bf-widget-title-color',
			0       => array(
				'selector' => array(
					'%%widget-id%% .widget-heading > .h-text',
					'%%widget-id%% .section-heading .h-text',
				),
				'prop'     => array(
					'color' => '%%value%%'
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
					'background-color' => '%%value%%; padding: 20px;',
				),
			),
			array(
				'selector' => array(
					'%%widget-id%% .widget-heading > .h-text',
					'%%widget-id%% .section-heading .h-text',
					'%%widget-id%% .section-heading.multi-tab .bs-pretty-tabs-container',
					'%%widget-id%% .section-heading.multi-tab .bs-pretty-tabs-container .bs-pretty-tabs-elements',
				),
				'prop'     => array(
					'background-color' => '%%value%%',
				),
			),
			array(
				'selector' =>
					array(
						'%%widget-id%% .section-heading.multi-tab .bs-pretty-tabs .bs-pretty-tabs-more.other-link .h-text',
					),
				'prop'     =>
					array(
						'border-bottom-color' => '%%value%%',
					),
			),
		);


		return $fields;
	}
}
