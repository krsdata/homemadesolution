<?php

$css_id = $this->get_css_id();

/**
 * =>Color & Style
 */
$theme_color = include PUBLISHER_THEME_PATH . 'includes/options/panel-css-theme_color.php';

$theme_color['bg_color']['selector'][]   = '.listing-item.listing-item-tb-2 .term-badges.floated .term-badge a';
$theme_color['bg_color']['selector'][]   = '.entry-terms.entry-terms .terms-label';
$theme_color['bg_color']['selector'][56] = '.bs-slider-2-item .content-container a.read-more';
$theme_color['bg_color']['selector'][57] = '.bs-slider-3-item .content-container a.read-more';
$fields['theme_color'][ $css_id ]        = $theme_color;
unset( $theme_color ); // clean memory

$fields['site_bg_color'][ $css_id ] = array( // fix for post title border
	array(
		'selector' => array(
			'body.full-width .post-tp-7-header.wfi .post-header-title',
			'body',
			'body.boxed',
		),
		'prop'     => array(
			'background-color' => '%%value%%'
		),
	),
	array(
		'selector' => array(
			'.page-title .post-title',
		),
		'prop'     => array(
			'border-color' => '%%value%%'
		),
	),

);


/**
 * -> Widgets
 */
$fields['widget_title_bg_color'][ $css_id ] = array(
	array(
		'selector' => array(
			'.widget .widget-heading > .h-text',
		),
		'prop'     => array(
			'background-color' => '%%value%% !important'
		)
	),
);

/**
 * -> Section Headings
 */
$fields['section_title_bg_color'][ $css_id ] = array(
	array(
		'selector' => array(
			'.section-heading.multi-tab .main-link.active .h-text',
			'.section-heading.multi-tab .active > .h-text',
			'.section-heading .h-text',
			'.section-heading.multi-tab .main-link:hover .h-text',
		),
		'prop'     => array(
			'background-color' => '%%value%%'
		)
	),
	array(
		'selector' => array(
			'.section-heading .other-link:hover .h-text',
		),
		'prop'     => array(
			'background-color' => '%%value%% !important'
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

$fields['widget_bg_color'] = array(
	'css' =>
		array(
			0 =>
				array(
					'selector' =>
						array(
							0 => '.sidebar-column .widget',
							1 => '.widget .widget-heading > .h-text:after',
							2 => '.widget .section-heading .h-text:after',
							3 => '.widget .section-heading.multi-tab .bs-pretty-tabs-container',
							4 => '.widget .section-heading.multi-tab.bs-pretty-tabs .bs-pretty-tabs-more.other-link .h-text:before',
						),
					'prop'     =>
						array(
							'background' => '%%value%%',
						),
				),
		),
);

unset( $css_id );