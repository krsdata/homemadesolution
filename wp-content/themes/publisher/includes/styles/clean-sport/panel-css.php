<?php

$css_id = $this->get_css_id();

/**
 * =>Color & Style
 */
$theme_color = include PUBLISHER_THEME_PATH . 'includes/options/panel-css-theme_color.php';

$theme_color['bg_color']['selector'][]     = '.entry-terms.source .terms-label, .entry-terms.via .terms-label, .entry-terms.post-tags .terms-label';
$theme_color['border_color']['selector'][] = '.entry-terms.source .terms-label, .entry-terms.via .terms-label, .entry-terms.post-tags .terms-label';
$theme_color['bg_color']['selector'][56]   = '.bs-slider-2-item .content-container a.read-more';
$theme_color['bg_color']['selector'][57]   = '.bs-slider-3-item .content-container a.read-more';

$fields['theme_color'][ $css_id ] = $theme_color;

unset( $theme_color );

/**
 * -> Topbar Colors
 */
$fields['topbar_bg_color'][ $css_id ] = array(
	array(
		'selector' => array(
			'.site-header.full-width .topbar',
		),
		'prop'     => array(
			'background-color' => '%%value%%'
		)
	),
	array(
		'selector' => array(
			'.site-header.boxed .topbar .topbar-inner',
		),
		'prop'     => array(
			'background-color' => '%%value%%; padding-left:15px; padding-right:15px'
		)
	),
	array(
		'selector' => array(
			'.header-style-5 .bs-pinning-block.pinned .header-inner',
			'.header-style-6 .bs-pinning-block.pinned .header-inner',
			'.header-style-8 .bs-pinning-block.pinned .header-inner',
		),
		'prop'     => array(
			'border-top' => '2px solid %%value%%'
		)
	),
);


/**
 * -> Section Heading
 */

$fields['widget_title_bg_color'][ $css_id ] = array(
	array(
		'selector' =>
			array(
				0 => '.widget .widget-heading > .h-text',
			),
		'prop'     =>
			array(
				'background-color' => '%%value%%',
			),
	),
);

$fields['widget_title_color'][ $css_id ] = array(
	0 =>
		array(
			'selector' =>
				array(
					0 => '.widget .widget-heading > .h-text',
				),
			'prop'     =>
				array(
					'color' => '%%value%% !important',
				),
		),
);

$fields['section_title_bg_color'][ $css_id ] = array(
	array(
		'selector' => array(
			'.section-heading.multi-tab .main-link.active .h-text',
			'.section-heading.multi-tab .active > .h-text',
			'.section-heading.multi-tab:after',
			'.section-heading:after',
			'.section-heading .h-text',
			'.section-heading .other-link:hover .h-text',
			'.section-heading.multi-tab .main-link:hover .h-text',
		),
		'prop'     => array(
			'background-color' => '%%value%%'
		)
	),
	array(
		'selector' => array(
			'.bs-pretty-tabs-container:hover .bs-pretty-tabs-more.other-link .h-text',
			'.section-heading .bs-pretty-tabs-more.other-link:hover .h-text.h-text',
		),
		'prop'     => array(
			'color' => '%%value%% !important'
		)
	),
);
