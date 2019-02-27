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


call_user_func( 'add' . '_shortcode', 'tabs', 'publisher_sh_tabs' );
call_user_func( 'add' . '_' . 'shortcode', 'tab', 'publisher_sh_tab' );

$GLOBALS['publisher_sh_tabs_count'] = NULL;
$GLOBALS['publisher_sh_tabs']       = NULL;

if ( ! function_exists( 'publisher_sh_tabs' ) ) {
	/**
	 * Shortcode: Tabs
	 */
	function publisher_sh_tabs( $atts, $content = NULL ) {

		$panes  = $tabs = array();
		$output = '';

		global $publisher_sh_tabs_count, $publisher_sh_tabs;

		// parse nested shortcodes and collect data to temp
		do_shortcode( $content );

		if ( isset( $publisher_sh_tabs_count ) && is_array( $publisher_sh_tabs ) ) {

			$count = 0;

			foreach ( $publisher_sh_tabs as $tab ) {
				$count ++;

				$tab_class = ( $count == 1 ? ' class="active"' : '' );

				$tab_pane_class = ( $count == 1 ? ' class="active tab-pane"' : ' class="tab-pane"' );

				$tabs[]  = '<li' . $tab_class . '><a href="#tab-' . $tab['id'] . '" data-toggle="tab">' . $tab['title'] . '</a></li>';
				$panes[] = '<li id="tab-' . $tab['id'] . '"' . $tab_pane_class . '>' . $tab['content'] . '</li>';
			}

			$output =
				'<div class="bs-tab-shortcode">
                    <ul class="nav nav-tabs" role="tablist">' . implode( '', $tabs ) . '</ul>
                    <div class="tab-content">' . implode( "\n", $panes ) . '</div>
                </div>';
		}

		$publisher_sh_tabs_count = $publisher_sh_tabs = NULL;

		return $output;
	}
}


if ( ! function_exists( 'publisher_sh_tab' ) ) {
	/**
	 * Shortcode Helper: Part of Tabs
	 */
	function publisher_sh_tab( $atts, $content = NULL ) {

		global $publisher_sh_tabs_count, $publisher_sh_tabs;


		if ( is_null( $publisher_sh_tabs_count ) ) {
			$publisher_sh_tabs_count = 0;
		}

		extract( shortcode_atts( array( 'title' => 'Tab %d' ), $atts ), EXTR_SKIP );

		$publisher_sh_tabs[ $publisher_sh_tabs_count ] = array(
			'title'   => sprintf( $title, $publisher_sh_tabs_count ),
			'content' => do_shortcode( $content ),
			'id'      => mt_rand(),
		);

		$publisher_sh_tabs_count ++;
	}
}


call_user_func( 'add' . '_shortcode', 'accordions', 'publisher_accordions' );
call_user_func( 'add' . '_' . 'shortcode', 'accordion', 'publisher_accordion_pane' );

$GLOBALS['publisher_sh_accordion_panes'] = NULL;

if ( ! function_exists( 'publisher_accordions' ) ) {
	/**
	 * Shortcode: Accordion
	 */
	function publisher_accordions( $atts, $content = NULL ) {

		global $publisher_sh_accordion_panes;

		$publisher_sh_accordion_panes = array();

		// parse nested shortcodes and collect data
		do_shortcode( $content );

		$id = mt_rand();

		$output = '<div class="panel-group bs-accordion-shortcode" id="accordion-' . $id . '">';

		$count = 0;

		foreach ( $publisher_sh_accordion_panes as $pane ) {

			$count ++;

			$active = $pane['load'] == 'show' ? ' in' : '';

			$output .= '<div class="panel panel-default ' . ( $active == ' in' ? 'open' : '' ) . '">
                            <div class="panel-heading ' . ( $active == ' in' ? 'active' : '' ) . '">
                              <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion-' . $id . '" href="#accordion-' . $id . '-pane-' . $count . '">';
			$output .= ! empty( $pane['title'] ) ? $pane['title'] : __( 'Accordion', 'publisher' ) . ' ' . $count;
			$output .= '</a>
                              </h4>
                            </div>
                            <div id="accordion-' . $id . '-pane-' . $count . '" class="panel-collapse collapse ' . $active . '">
                              <div class="panel-body">';
			$output .= $pane['content'];
			$output .= '
                                </div>
                            </div>
                        </div>';

		}

		unset( $publisher_sh_accordion_panes );

		return $output . '</div>';
	}
}


if ( ! function_exists( 'publisher_accordion_pane' ) ) {
	/**
	 * Shortcode Helper: Accordion
	 */
	function publisher_accordion_pane( $atts, $content = NULL ) {

		global $publisher_sh_accordion_panes;

		extract( shortcode_atts( array( 'title' => '', 'load' => 'hide' ), $atts ), EXTR_SKIP );

		$publisher_sh_accordion_panes[] = array(
			'title'   => $title,
			'load'    => $load,
			'content' => do_shortcode( $content )
		);
	}
}
