<?php

$css_id = $this->get_css_id();

/**
 * =>Color & Style
 */
$theme_color_css = include PUBLISHER_THEME_PATH . 'includes/options/panel-css-theme_color.php';

$theme_color_css['c_border_top_color'] = array(
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

$theme_color_css['bg'] = array(
	'selector' => '.section-heading.multi-tab:after',
	'prop'     =>
		array(
			'background-color' => '%%value%%',
		),
);

$theme_color_css['color']['selector'][]      = '.section-heading.multi-tab .main-link:hover .h-text';
$theme_color_css['color_impo']['selector'][] = '.section-heading .other-link:hover .h-text';
$theme_color_css['color_impo']['selector'][] = '.section-heading.multi-tab .active .h-text';
$theme_color_css['color_impo']['selector'][] = '.bs-pretty-tabs-container:hover .bs-pretty-tabs-more.other-link .h-text';
$theme_color_css['color_impo']['selector'][] = '.section-heading .bs-pretty-tabs-more.other-link:hover .h-text.h-text';
$fields['theme_color'][ $css_id ]            = $theme_color_css;
unset( $theme_color_css );

$fields['site_bg_color'][ $css_id ] = array(
	array(
		'selector' => array(
			'body',
			'body.boxed',
			'.page-layout-2-col-right .post-tp-7-header .post-header-title',
		),
		'prop'     => array(
			'background-color' => '%%value%%'
		),
	)
);


/**
 * -> Header Colors
 */
$fields['header_menu_st3_bbottom_color'][ $css_id ] = array(
	array(
		'selector' => array(
			'.site-header.header-style-3.boxed .main-menu-container',
			'.site-header.full-width.header-style-3 .main-menu-wrapper',
		),
		'prop'     => array(
			'border-bottom-color' => '%%value%% !important'
		)
	),
	array(
		'selector' => array(
			'.site-header.header-style-3',
		),
		'prop'     => array(
			'border-bottom' => '1px solid %%value%% !important'
		)
	),
);
$fields['header_menu_st4_bbottom_color'][ $css_id ] = array(
	array(
		'selector' => array(
			'.site-header.header-style-4.boxed .main-menu-container',
			'.site-header.full-width.header-style-4 .main-menu-wrapper',
		),
		'prop'     => array(
			'border-bottom-color' => '%%value%% !important'
		)
	),
	array(
		'selector' => array(
			'.site-header.header-style-4',
		),
		'prop'     => array(
			'border-bottom' => '1px solid %%value%% !important'
		)
	),
);
$fields['header_menu_st7_bbottom_color'][ $css_id ] = array(
	array(
		'selector' => array(
			'.site-header.header-style-7.boxed .main-menu-container',
			' .site-header.full-width.header-style-7 .main-menu-wrapper',
		),
		'prop'     => array(
			'border-bottom-color' => '%%value%% !important'
		)
	),
	array(
		'selector' => array(
			'.site-header.header-style-7',
		),
		'prop'     => array(
			'border-bottom' => '1px solid %%value%% !important'
		)
	),
);
$fields['header_top_border_color'][ $css_id ]       = array(
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
			'border-top' => '4px solid %%value%%'
		)
	),
);

