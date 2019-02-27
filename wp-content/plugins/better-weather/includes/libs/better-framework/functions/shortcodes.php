<?php
/***
 *  BetterFramework is BetterStudio framework for themes and plugins.
 *
 *  ______      _   _             ______                                           _
 *  | ___ \    | | | |            |  ___|                                         | |
 *  | |_/ / ___| |_| |_ ___ _ __  | |_ _ __ __ _ _ __ ___   _____      _____  _ __| | __
 *  | ___ \/ _ \ __| __/ _ \ '__| |  _| '__/ _` | '_ ` _ \ / _ \ \ /\ / / _ \| '__| |/ /
 *  | |_/ /  __/ |_| ||  __/ |    | | | | | (_| | | | | | |  __/\ V  V / (_) | |  |   <
 *  \____/ \___|\__|\__\___|_|    \_| |_|  \__,_|_| |_| |_|\___| \_/\_/ \___/|_|  |_|\_\
 *
 *  Copyright © 2017 Better Studio
 *
 *
 *  Our portfolio is here: http://themeforest.net/user/Better-Studio/portfolio
 *
 *  \--> BetterStudio, 2017 <--/
 */


if ( ! function_exists( 'bf_shortcode_show_title' ) ) {
	/**
	 * Used to show shortcodes heading in standard way!
	 * You can redefine this function or use 'better-framework/shortcodes/title' filter
	 * for changing values.
	 *
	 * @param array $atts
	 *
	 * @since 2.5.5
	 *
	 * @return string
	 */
	function bf_shortcode_show_title( $atts = array() ) {

		if ( isset( $atts['show_title'] ) && $atts['show_title'] == FALSE ) {
			return;
		}

		if ( isset( $atts['hide_title'] ) && $atts['hide_title'] == TRUE ) {
			return;
		}

		if ( empty( $atts['title'] ) || bf_get_current_sidebar() != '' ) {
			return;
		}

		$result = apply_filters( 'better-framework/shortcodes/title', $atts );

		if ( is_string( $result ) ) {
			echo $result; // escaped before
		}

	}
}


if ( ! function_exists( 'bf_shortcode_custom_css_prop' ) ) {
	/**
	 * @param        $css
	 * @param        $prop_name
	 * @param string $default
	 *
	 * @return string
	 *
	 * @since 2.5.2
	 */
	function bf_shortcode_custom_css_prop( $css, $prop_name, $default = '' ) {

		preg_match( '/' . $prop_name . ':([^!]*)/', $css, $css );

		if ( ! empty( $css[1] ) ) {
			return trim( $css[1] );
		}

		return $default;
	}
}


if ( ! function_exists( 'bf_shortcode_custom_css_class' ) ) {
	/**
	 * Custom function used to get custom css class name form VC/Shortcode css atribute
	 *
	 * @param        $param_value
	 * @param string $prefix
	 * @param string $css_key
	 *
	 * @return string
	 *
	 * @since 2.5.2
	 */
	function bf_shortcode_custom_css_class( $param_value, $prefix = '', $css_key = 'css' ) {

		$css_class = '';

		// prepare field
		if ( is_array( $param_value ) && ! empty( $param_value[ $css_key ] ) ) {
			$param_value = $param_value[ $css_key ];
		} else {
			return $css_class;
		}

		if ( is_string( $param_value ) ) {
			$css_class = preg_match( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $param_value ) ? $prefix . preg_replace( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', '$1', $param_value ) : '';
		}

		return $css_class;
	}
}


if ( ! function_exists( 'bf_vc_edit_form_classes' ) ) {
	/**
	 * Filter: vc_edit_form_class
	 * Description: add some class to visual composer edit form. used in admin-scripts.js setup_interactive_fields_for_vc() method
	 *
	 * @see setup_interactive_fields_for_vc method on `Better_Framework` JS Object
	 *
	 * @param array $classes
	 * @param array $atts
	 * @param array $params
	 *
	 * @return mixed
	 */
	function bf_vc_edit_form_classes( $classes, $atts, $params ) {

		$added_fields      = array();
		$interactive_added = FALSE;
		foreach ( $params as $param ) {
			if ( ! empty( $param['show_on'] ) ) {
				if ( ! $interactive_added ) {
					array_push( $classes, 'bf-interactive-fields', 'bf-has-filters' );
					$interactive_added = TRUE;
				}

				foreach ( (array) $param['show_on'] as $conditions ) {
					foreach ( (array) $conditions as $condition ) {
						$field_name = explode( '=', $condition, 2 );
						$field_name = $field_name[0];
						if ( ! in_array( $field_name, $added_fields ) ) {
							array_push( $classes, 'bf-filter-field-' . $field_name );
							$added_fields[] = $field_name;
						}
					}
				}
			}
		}

		return array_unique( $classes );
	}

	add_filter( 'vc_edit_form_class', 'bf_vc_edit_form_classes', 8, 3 );
}


if ( ! function_exists( 'bf_vc_layout_state' ) ) {
	/**
	 * Returns VC Columns state
	 *
	 * @return array
	 */
	function bf_vc_layout_state() {
		global $_bf_vc_column_atts, $_bf_vc_column_inner_atts;

		$_bf_vc_column_atts = array_filter( (array) $_bf_vc_column_atts );
		$_bf_vc_column_atts = bf_merge_args( $_bf_vc_column_atts, array(
			'width' => '1'
		) );

		$_bf_vc_column_inner_atts = array_filter( (array) $_bf_vc_column_inner_atts );
		$_bf_vc_column_inner_atts = bf_merge_args( $_bf_vc_column_inner_atts, array(
			'width' => '1'
		) );

		return array(
			'column' => $_bf_vc_column_atts,
			'row'    => $_bf_vc_column_inner_atts,
		);
	}
}


add_filter( 'vc_shortcode_set_template_vc_column', 'bf_vc_column_filter' );

if ( ! function_exists( 'bf_vc_column_filter' ) ) {
	/**
	 * Callback: Handy filter to calculate columns state
	 * Filter: vc_shortcode_set_template_vc_column
	 *
	 * @param $file
	 *
	 * @return string
	 */
	function bf_vc_column_filter( $file ) {
		global $_vc_column_template_file;

		$_vc_column_template_file = $file;

		return BF_PATH . 'vc-extend/vc_column.php';
	}
}


add_filter( 'vc_shortcode_set_template_vc_column_inner', 'bf_vc_column_inner_filter' );

if ( ! function_exists( 'bf_vc_column_inner_filter' ) ) {
	/**
	 * Callback: Handy filter to calculate columns state
	 * Filter: vc_shortcode_set_template_vc_column_inner
	 *
	 * @param $file
	 *
	 * @return string
	 */
	function bf_vc_column_inner_filter( $file ) {
		global $_vc_column_inner_template_file;

		$_vc_column_inner_template_file = $file;

		return BF_PATH . '/vc-extend/vc_column_inner.php';
	}
}
