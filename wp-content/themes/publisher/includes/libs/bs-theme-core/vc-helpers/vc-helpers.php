<?php
/***
 *  BetterStudio Themes Core.
 *
 *  ______  _____   _____ _                           _____
 *  | ___ \/  ___| |_   _| |                         /  __ \
 *  | |_/ /\ `--.    | | | |__   ___ _ __ ___   ___  | /  \/ ___  _ __ ___
 *  | ___ \ `--. \   | | | '_ \ / _ \ '_ ` _ \ / _ \ | |    / _ \| '__/ _ \
 *  | |_/ //\__/ /   | | | | | |  __/ | | | | |  __/ | \__/\ (_) | | |  __/
 *  \____/ \____/    \_/ |_| |_|\___|_| |_| |_|\___|  \____/\___/|_|  \___|
 *
 *  Copyright © 2017 Better Studio
 *
 *
 *  Our portfolio is here: http://themeforest.net/user/Better-Studio/portfolio
 *
 *  \--> BetterStudio, 2017 <--/
 */


if ( ! function_exists( 'publisher_is_pagebuilder_used' ) ) {
	/**
	 * Used to find current page uses VC for content or not!
	 *
	 * @return bool
	 */
	function publisher_is_pagebuilder_used( $post_id = NULL ) {

		if ( is_null( $post_id ) ) {
			global $post;
		} elseif ( intval( $post_id ) ) {
			$post = get_post( $post_id );
		} else {
			return FALSE;
		}

		if ( ! $post || is_null( $post ) || is_wp_error( $post ) ) {
			return FALSE;
		}

		$behaviour = 'default';

		if ( bf_get_post_meta( '_page_simple_in_pagebuilder' ) != 'default' ) {
			$behaviour = bf_get_post_meta( '_page_simple_in_pagebuilder' );
		}

		if ( $behaviour == 'default' ) {
			$behaviour = publisher_get_option( 'page_simple_in_pagebuilder' );
		}

		// if user selected show then no need to shortcode check
		if ( $behaviour == 'show' ) {
			return FALSE;
		}


		$used = FALSE;

		// Detect page builder is used or not
		if ( method_exists( 'WPBMap', 'getShortCodes' ) ) {

			$valid_shortcodes = array();

			$registered_shortcodes = array_keys( WPBMap::getShortCodes() );

			if ( is_array( $registered_shortcodes ) && ! empty( $registered_shortcodes ) ) {
				foreach ( $registered_shortcodes as $short_code_name ) {
					$valid_shortcodes[] = '[' . $short_code_name;
				}
			}

			if ( ! empty( $valid_shortcodes ) && publisher_strpos_array( $post->post_content, $valid_shortcodes ) === TRUE ) {
				$used = TRUE;
			}

		}

		return $used;
	}
} // publisher_is_pagebuilder_used


if ( ! function_exists( 'publisher_is_vc_frontend_editor' ) ) {
	/**
	 * Hard code to checking VC frontend editor because of their shit code! >.<
	 *
	 * @return bool
	 */
	function publisher_is_vc_frontend_editor() {
		return ! is_admin() && is_user_logged_in() &&
		       ! empty( $_GET['vc_editable'] ) && ! empty( $_GET['vc_post_id'] );
	}
}


add_filter( 'publisher-theme-core/vc-helper/widget-config', 'publisher_vc_wp_widgets_shortcode_atts' );

if ( ! function_exists( 'publisher_vc_wp_widgets_shortcode_atts' ) ) {
	/**
	 * Changes VC widgets config
	 *
	 * @return array
	 */
	function publisher_vc_wp_widgets_shortcode_atts( $atts ) {

		if ( ! empty( Publisher_Theme_Core::$config['vc-widgets-atts']['before_title'] ) ) {
			$atts['before_title'] = Publisher_Theme_Core::$config['vc-widgets-atts']['before_title'];
		}

		if ( ! empty( Publisher_Theme_Core::$config['vc-widgets-atts']['after_title'] ) ) {
			$atts['after_title'] = Publisher_Theme_Core::$config['vc-widgets-atts']['after_title'];
		}

		if ( ! empty( Publisher_Theme_Core::$config['vc-widgets-atts']['before_title'] ) ) {
			$atts['before_title'] = Publisher_Theme_Core::$config['vc-widgets-atts']['before_title'];
		}

		if ( ! empty( Publisher_Theme_Core::$config['vc-widgets-atts']['after_widget'] ) ) {
			$atts['after_widget'] = Publisher_Theme_Core::$config['vc-widgets-atts']['after_widget'];
		}

		return $atts;
	}
}
