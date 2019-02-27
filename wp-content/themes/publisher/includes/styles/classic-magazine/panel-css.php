<?php

$css_id = $this->get_css_id();

/**
 * =>Color & Style
 */
$theme_color = include PUBLISHER_THEME_PATH . 'includes/options/panel-css-theme_color.php';

$theme_color['color_impo']['selector'][] = '.section-heading.multi-tab .main-link:hover > .h-text.h-text'; // section heading
$theme_color['color_impo']['selector'][] = '.section-heading.multi-tab .active > .h-text.h-text'; // section heading
$theme_color['color_impo']['selector'][] = '.section-heading .active > .h-text'; // section heading
$theme_color['color_impo']['selector'][] = '.section-heading.multi-tab .main-link.active .h-text.h-text.h-text'; // section heading
$theme_color['color_impo']['selector'][] = '.section-heading .other-link:hover .h-text.h-text'; // section heading
$theme_color['color_impo']['selector'][] = '.bs-pretty-tabs-container:hover .bs-pretty-tabs-more.other-link .h-text.h-text';
$theme_color['color_impo']['selector'][] = '.section-heading .bs-pretty-tabs-more.other-link:hover .h-text.h-text';
unset( $theme_color['color']['selector'][51] ); // menu hover color

$fields['theme_color'][ $css_id ] = $theme_color;

unset( $theme_color );


/**
 * -> Widgets
 */
$fields['widget_title_bg_color'][ $css_id ] = array(
	array(
		'selector' => array(
			'.widget .widget-heading > .h-text',
		),
		'prop'     => array(
			'background-color' => '%%value%%'
		)
	),
);
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

$fields['widget_bg_color'] = array(
	'css' =>
		array(
			0 =>
				array(
					'selector' =>
						array(
							0 => '.sidebar-column .widget',
						),
					'prop'     =>
						array(
							'background' => '%%value%%; padding: 20px',
						),
				),
			1 => array(
				'selector' => array(
					0 => '.sidebar-column .widget .widget-heading > .h-text',
					1 => '.sidebar-column .widget .section-heading .h-text',
					2 => '.sidebar-column .widget .section-heading.multi-tab .bs-pretty-tabs-container',
				),
				'prop'     => array(
					'background-color' => '%%value%%',
				),
			),
		),
);


/**
 * -> Section Headings
 */

$fields['section_title_color'][ $css_id ] = array(
	0 =>
		array(
			'selector' =>
				array(
					1  => '.bs-pretty-tabs-container:hover .bs-pretty-tabs-more.other-link .h-text.h-text',
					3  => '.section-heading.multi-tab .main-link.active .h-text.h-text',
					4  => '.section-heading.multi-tab .active > .h-text.h-text',
					5  => '.section-heading .other-link:hover .h-text',
					6  => '.section-heading.multi-tab .main-link:hover > .h-text.h-text',
					7  => '.section-heading .bs-pretty-tabs-more.other-link:hover .h-text.h-text',
					8  => '.bs-pretty-tabs-container:hover .bs-pretty-tabs-more.other-link .h-text.h-text',
					9  => '.section-heading .other-link:hover .h-text.h-text',
					10 => '.section-heading.multi-tab .main-link.active .h-text.h-text.h-text',
				),
			'prop'     =>
				array(
					'color' => '%%value%% !important',
				),
		),
	1 =>
		array(
			'selector' =>
				array(
					0 => '.section-heading .h-text',
				),
			'prop'     =>
				array(
					'color' => '%%value%%',
				),
		),

);

$fields['section_title_bg_color'][ $css_id ] = array(
	array(
		'selector' => array(
			'.section-heading.multi-tab:after',
			'.section-heading:after',
		),
		'prop'     => array(
			'background-color' => '%%value%%'
		)
	),
	array(
		'selector' => array(
			'.bs-pretty-tabs-container .bs-pretty-tabs-elements',
		),
		'prop'     => array(
			'border-color' => '%%value%%'
		)
	),
);


//
//$section_title_bg_color_css = $fields['section_title_bg_color']['css'];
//unset( $section_title_bg_color_css[1]['selector'][4] ); // simple heading text color
//unset( $section_title_bg_color_css[1]['selector'][1] ); // other link hover
//unset( $section_title_bg_color_css[2]['selector'][3] ); // other link hover
//$section_title_bg_color_css[]                = array(
//	'selector' => array(
//		'.bs-pretty-tabs-container .bs-pretty-tabs-elements',
//	),
//	'prop'     => array(
//		'border-color' => '%%value%%'
//	)
//);
//$fields['section_title_bg_color'][ $css_id ] = $section_title_bg_color_css;

unset( $css_id );
unset( $section_title_bg_color_css );
