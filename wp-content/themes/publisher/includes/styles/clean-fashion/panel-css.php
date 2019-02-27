<?php

$css_id = $this->get_css_id();

/**
 * =>Color & Style
 */
$theme_color = include PUBLISHER_THEME_PATH . 'includes/options/panel-css-theme_color.php';

$theme_color['c_border_top_color']       = array(
	'selector' => array(
		'.header-style-1.full-width .bs-pinning-block.pinned.main-menu-wrapper',
		'.header-style-1.boxed .bs-pinning-block.pinned .main-menu-container',
		'.header-style-2.full-width .bs-pinning-block.pinned.main-menu-wrapper',
		'.header-style-2.boxed .bs-pinning-block.pinned .main-menu-container',
		'.header-style-3.full-width .bs-pinning-block.pinned.main-menu-wrapper',
		'.header-style-3.boxed .bs-pinning-block.pinned .main-menu-container',
		'.header-style-4.full-width .bs-pinning-block.pinned.main-menu-wrapper',
		'.header-style-4.boxed .bs-pinning-block.pinned .main-menu-container',
		'.header-style-5.full-width .bspw-header-style-5 .bs-pinning-block.pinned',
		'.header-style-5.boxed .bspw-header-style-5 .bs-pinning-block.pinned .header-inner',
		'.header-style-6.full-width .bspw-header-style-6 .bs-pinning-block.pinned',
		'.header-style-6.boxed .bspw-header-style-6 .bs-pinning-block.pinned .header-inner',
		'.header-style-7.full-width .bs-pinning-block.pinned.main-menu-wrapper',
		'.header-style-7.boxed .bs-pinning-block.pinned .main-menu-container',
		'.header-style-8.full-width .bspw-header-style-8 .bs-pinning-block.pinned',
		'.header-style-8.boxed .bspw-header-style-8 .bs-pinning-block.pinned .header-inner',
	),
	'prop'     => array(
		'border-top' => '3px solid %%value%%'
	)
);
$theme_color['color']['selector'][]      = '.section-heading.multi-tab .main-link:hover .h-text';
$theme_color['color_impo']['selector'][] = '.section-heading .other-link:hover .h-text';
$theme_color['color_impo']['selector'][] = '.section-heading.multi-tab .active .h-text';
$theme_color['color_impo']['selector'][] = '.bs-pretty-tabs-container:hover .bs-pretty-tabs-more.other-link .h-text';
$theme_color['color_impo']['selector'][] = '.section-heading .bs-pretty-tabs-more.other-link:hover .h-text.h-text';
$theme_color['bg_color']['selector'][]   = '.section-heading:after';
$fields['theme_color'][ $css_id ]        = $theme_color;
unset( $theme_color );


/**
 * -> Header Colors
 */
$fields['header_top_border_color'][ $css_id ] = array(
	array(
		'selector' => array(
			'body.active-top-line .main-wrap'
		),
		'prop'     => array(
			'border-color' => '%%value%%'
		)
	),
	array(
		'selector' => array(
			'.header-style-1.full-width .bs-pinning-block.pinned.main-menu-wrapper',
			'.header-style-1.boxed .bs-pinning-block.pinned .main-menu-container',
			'.header-style-2.full-width .bs-pinning-block.pinned.main-menu-wrapper',
			'.header-style-2.boxed .bs-pinning-block.pinned .main-menu-container',
			'.header-style-3.full-width .bs-pinning-block.pinned.main-menu-wrapper',
			'.header-style-3.boxed .bs-pinning-block.pinned .main-menu-container',
			'.header-style-4.full-width .bs-pinning-block.pinned.main-menu-wrapper',
			'.header-style-4.boxed .bs-pinning-block.pinned .main-menu-container',
			'.header-style-5.full-width .bspw-header-style-5 .bs-pinning-block.pinned',
			'.header-style-5.boxed .bspw-header-style-5 .bs-pinning-block.pinned .header-inner',
			'.header-style-6.full-width .bspw-header-style-6 .bs-pinning-block.pinned',
			'.header-style-6.boxed .bspw-header-style-6 .bs-pinning-block.pinned .header-inner',
			'.header-style-7.full-width .bs-pinning-block.pinned.main-menu-wrapper',
			'.header-style-7.boxed .bs-pinning-block.pinned .main-menu-container',
			'.header-style-8.full-width .bspw-header-style-8 .bs-pinning-block.pinned',
			'.header-style-8.boxed .bspw-header-style-8 .bs-pinning-block.pinned .header-inner',
		),
		'prop'     => array(
			'border-top' => '3px solid %%value%%'
		)
	),
);


/**
 * -> Widgets
 */
$fields['widget_title_bg_color'][ $css_id ] = array(
	array(
		'selector' => array(
			'.widget .widget-heading:after',
		),
		'prop'     => array(
			'background-color' => '%%value%%'
		)
	),
);


$fields['section_title_bg_color'][ $css_id ] = array(
	array(
		'selector' => array(
			'.section-heading:after',
		),
		'prop'     => array(
			'background-color' => '%%value%%'
		)
	),
	array(
		'selector' => array(
			'.section-heading .h-text',
		),
		'prop'     => array(
			'color' => '%%value%%'
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

unset( $css_id );
