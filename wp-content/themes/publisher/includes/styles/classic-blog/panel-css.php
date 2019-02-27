<?php

$css_id = $this->get_css_id();

/**
 * =>Color & Style
 */
$theme_color = include PUBLISHER_THEME_PATH . 'includes/options/panel-css-theme_color.php';

$theme_color['color_impo']['selector'][] = '.section-heading .other-link.active .h-text.h-text';
$theme_color['color_impo']['selector'][] = '.section-heading.multi-tab .main-link.active .h-text';
$theme_color['color_impo']['selector'][] = '.section-heading.multi-tab .main-link:hover .h-text';
$theme_color['color_impo']['selector'][] = '.section-heading .other-link:hover .h-text';
$theme_color['color_impo']['selector'][] = '.bs-pretty-tabs-container:hover .bs-pretty-tabs-more.other-link .h-text';
$theme_color['color_impo']['selector'][] = '.section-heading .bs-pretty-tabs-more.other-link:hover .h-text.h-text';

$fields['theme_color'][ $css_id ] = $theme_color;

unset( $theme_color ); // clean memory

/**
 * -> Widgets
 */
$fields['widget_title_bg_color'][ $css_id ] = array(
	array(
		'selector' => array(
			'.widget .widget-heading',
		),
		'prop'     => array(
			'background-color' => '%%value%%'
		)
	),
	array(
		'selector' => array(
			'.widget .widget-heading:after',
		),
		'prop'     => array(
			'border-top-color' => '%%value%% !important'
		)
	),
);


/**
 * -> Section Headings
 */
$fields['section_title_bg_color'][ $css_id ] = array(
	array(
		'selector' => array(
			'.section-heading',
			'.bs-pretty-tabs-container .bs-pretty-tabs-elements',
		),
		'prop'     => array(
			'background-color' => '%%value%%'
		)
	),
	array(
		'selector' => array(
			'.section-heading:after',
		),
		'prop'     => array(
			'border-top-color' => '%%value%% !important'
		)
	),
);

$fields['section_title_color'][ $css_id ] = array(
	0 =>
		array(
			'selector' =>
				array(
					1 => '.bs-pretty-tabs-container:hover .bs-pretty-tabs-more.other-link .h-text.h-text',
					3 => '.section-heading.multi-tab .main-link.active .h-text.h-text',
					4 => '.section-heading.multi-tab .active > .h-text',
					5 => '.section-heading .other-link:hover .h-text',
					6 => '.section-heading.multi-tab .main-link:hover .h-text',
					7 => '.section-heading .h-text',
				),
			'prop'     =>
				array(
					'color' => '%%value%%',
				),
		),
);

unset( $css_id );
