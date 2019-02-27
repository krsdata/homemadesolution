<?php

$css_id = $this->get_css_id();

/**
 * =>Color & Style
 */
$theme_color = include PUBLISHER_THEME_PATH . 'includes/options/panel-css-theme_color.php';

$theme_color['bg_color']['selector'][]     = '.entry-terms.source .terms-label, .entry-terms.via .terms-label, .entry-terms.post-tags .terms-label';
$theme_color['border_color']['selector'][] = '.entry-terms.source .terms-label, .entry-terms.via .terms-label, .entry-terms.post-tags .terms-label';
$theme_color['bg_color']['selector'][]     = '.entry-terms.entry-terms .terms-label';
$fields['theme_color'][ $css_id ]          = $theme_color;
unset( $theme_color );


/**
 * -> Topbar Colors
 */
$fields['topbar_bg_color'][ $css_id ] = array(
	array(
		'selector' => array(
			'.site-header .topbar',
		),
		'prop'     => array(
			'background-color' => '%%value%%'
		)
	),
);


/**
 * -> Widgets
 */
$fields['widget_bg_color'][ $css_id ] = array(
	array(
		'selector' => array(
			'.sidebar-column .widget',
		),
		'prop'     => array(
			'background' => '%%value%%;'
		)
	),
);

