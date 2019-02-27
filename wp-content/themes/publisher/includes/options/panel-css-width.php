<?php


if ( ! function_exists( 'publisher_cb_css_generator_layout_2_col' ) ) {
	/**
	 * Handy function used to generate value for fields
	 *
	 * @param string $value
	 * @param string $unite
	 * @param string $append
	 *
	 * @return string
	 */
	function _themename_width_changer_to_px( $value = '', $unite = 'px', $append = '' ) {

		if ( $value === '' ) {
			$value = 0;
		}

		if ( $value !== 0 ) {
			$value = $value . $unite;
		}

		if ( ! empty( $append ) ) {
			return $value . $append;
		} else {
			return $value;
		}
	}
}


if ( ! function_exists( 'publisher_cb_css_generator_layout_2_col' ) ) {
	/**
	 * Custom CSS generator for 2 column layout
	 *
	 * @param array  $block
	 * @param string $value
	 */
	function publisher_cb_css_generator_layout_2_col( &$block = array(), &$value = '' ) {

		$block = array();

		//
		// Site width
		//
		$block[1] = array(
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1  => '.page-layout-1-col .container',
					2  => '.page-layout-1-col .content-wrap',
					3  => 'body.boxed.page-layout-1-col .site-header .main-menu-wrapper',
					4  => 'body.boxed.page-layout-1-col .site-header.header-style-5 .content-wrap > .bs-pinning-wrapper > .bs-pinning-block',
					5  => 'body.boxed.page-layout-1-col .site-header.header-style-6 .content-wrap > .bs-pinning-wrapper > .bs-pinning-block',
					6  => 'body.boxed.page-layout-1-col .site-header.header-style-8 .content-wrap > .bs-pinning-wrapper > .bs-pinning-block',
					7  => 'body.page-layout-1-col.boxed .main-wrap',
					8  => '.page-layout-2-col-right .container',
					9  => '.page-layout-2-col-right .content-wrap',
					10 => 'body.page-layout-2-col-right.boxed .main-wrap',
					11 => '.page-layout-2-col-left .container',
					12 => '.page-layout-2-col-left .content-wrap',
					13 => 'body.page-layout-2-col-left.boxed .main-wrap',
				),
			'prop'            =>
				array(
					'max-width' => _themename_width_changer_to_px( $value['width'] ),
				),
		);

		//
		// Content column width
		//
		$block[2] = array(
			'before'          => '@media (min-width: 768px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-2-col .content-column',
				),
			'prop'            =>
				array(
					'width' => _themename_width_changer_to_px( $value['content'], '%' ),
				),
		);

		//
		// Sidebar column width
		//
		$block[3] = array(
			'before'          => '@media (min-width: 768px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-2-col .sidebar-column',
				),
			'prop'            =>
				array(
					'width' => _themename_width_changer_to_px( $value['primary'], '%' ),
				),
		);


		//
		// Push content column to right
		//
		$block[4] = array(
			'before'          => '@media (min-width: 768px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-2-col.layout-2-col-2 .content-column',
				),
			'prop'            =>
				array(
					'left' => _themename_width_changer_to_px( $value['primary'], '%' ),
				),
		);
		$block[5] = array(
			'before'          => '@media (min-width: 768px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.rtl .layout-2-col.layout-2-col-2 .content-column',
				),
			'prop'            =>
				array(
					'left'  => 'inherit',
					'right' => _themename_width_changer_to_px( $value['primary'], '%' ),
				),
		);


		//
		// Pull sidebar column to left
		//
		$block[6] = array(
			'before'          => '@media (min-width: 768px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-2-col.layout-2-col-2 .sidebar-column',
				),
			'prop'            =>
				array(
					'right' => _themename_width_changer_to_px( $value['content'], '%' ),
				),
		);
		$block[7] = array(
			'before'          => '@media (min-width: 768px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.rtl .layout-2-col.layout-2-col-2 .sidebar-column',
				),
			'prop'            =>
				array(
					'right' => 'inherit',
					'left'  => _themename_width_changer_to_px( $value['content'], '%' ),
				),
		);

		$value = '';

	} // publisher_cb_css_generator_layout_2_col
}


if ( ! function_exists( 'publisher_cb_css_generator_layout_3_col' ) ) {
	/**
	 * Custom CSS generator for 3 column layout
	 *
	 * @param array  $block
	 * @param string $value
	 */
	function publisher_cb_css_generator_layout_3_col( &$block = array(), &$value = '' ) {

		$block = array();

		$sm_content = $value['content'] + ceil( $value['secondary'] / 2 );
		$sm_primary = 100 - $sm_content;

		$xs_primary   = $value['primary'] + ceil( $value['content'] / 2 );
		$xs_secondary = 100 - $xs_primary;

		//
		// Site width
		//
		$block[1] = array(
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1  => '.page-layout-3-col-0 .container',
					2  => '.page-layout-3-col-0 .content-wrap',
					3  => 'body.page-layout-3-col-0.boxed .main-wrap',
					4  => '.page-layout-3-col-1 .container',
					5  => '.page-layout-3-col-1 .content-wrap',
					6  => 'body.page-layout-3-col-1.boxed .main-wrap',
					7  => '.page-layout-3-col-2 .container',
					8  => '.page-layout-3-col-2 .content-wrap',
					9  => 'body.page-layout-3-col-2.boxed .main-wrap',
					10 => '.page-layout-3-col-3 .container',
					11 => '.page-layout-3-col-3 .content-wrap',
					12 => 'body.page-layout-3-col-3.boxed .main-wrap',
					13 => '.page-layout-3-col-4 .container',
					14 => '.page-layout-3-col-4 .content-wrap',
					15 => 'body.page-layout-3-col-4.boxed .main-wrap',
					16 => '.page-layout-3-col-5 .container',
					17 => '.page-layout-3-col-5 .content-wrap',
					18 => 'body.page-layout-3-col-5.boxed .main-wrap',
					19 => '.page-layout-3-col-6 .container',
					20 => '.page-layout-3-col-6 .content-wrap',
					21 => 'body.page-layout-3-col-6.boxed .main-wrap',
					22 => 'body.boxed.page-layout-3-col .site-header.header-style-5 .content-wrap > .bs-pinning-wrapper > .bs-pinning-block',
					23 => 'body.boxed.page-layout-3-col .site-header.header-style-6 .content-wrap > .bs-pinning-wrapper > .bs-pinning-block',
					24 => 'body.boxed.page-layout-3-col .site-header.header-style-8 .content-wrap > .bs-pinning-wrapper > .bs-pinning-block',
				),
			'prop'            =>
				array(
					'max-width' => _themename_width_changer_to_px( $value['width'] ),
				),
		);


		//
		// Content > 1000px
		//
		$block[2] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col .content-column',
				),
			'prop'            =>
				array(
					'width' => _themename_width_changer_to_px( $value['content'], '%' ),
				),
		);


		//
		// Primary > 1000px
		//
		$block[3] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col .sidebar-column-primary',
				),
			'prop'            =>
				array(
					'width' => _themename_width_changer_to_px( $value['primary'], '%' ),
				),
		);


		//
		// Secondary > 1000px
		//
		$block[4] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col .sidebar-column-secondary',
				),
			'prop'            =>
				array(
					'width' => _themename_width_changer_to_px( $value['secondary'], '%' ),
				),
		);


		//
		// 768px < Layout-3-col-1 < 1000px
		// 768px < Layout-3-col-2 < 1000px
		//
		$block[5] = array(
			'before'          => '@media (max-width:1000px) and (min-width:768px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col .content-column',
				),
			'prop'            =>
				array(
					'width' => _themename_width_changer_to_px( $sm_content, '%' ),
				),
		);
		$block[6] = array(
			'before'          => '@media (max-width:1000px) and (min-width:768px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col .sidebar-column-primary',
				),
			'prop'            =>
				array(
					'width' => _themename_width_changer_to_px( $sm_primary, '%' ),
				),
		);

		//
		// 500px < Layout-3-col-1 < 768px
		//
		$block[7] = array(
			'before'          => '@media (max-width:768px) and (min-width:500px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col .sidebar-column-primary',
				),
			'prop'            =>
				array(
					'width' => _themename_width_changer_to_px( $xs_primary, '%' ),
				),
		);
		$block[8] = array(
			'before'          => '@media (max-width:768px) and (min-width:500px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col .sidebar-column-secondary',
				),
			'prop'            =>
				array(
					'width' => _themename_width_changer_to_px( $xs_secondary, '%' ),
				),
		);


		//
		// Layout-3-col-2 > 1000px
		//
		$block[9]  = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col-2 .sidebar-column-primary',
				),
			'prop'            =>
				array(
					'left' => _themename_width_changer_to_px( $value['secondary'], '%' ),
				),
		);
		$block[10] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.rtl .layout-3-col-2 .sidebar-column-primary',
				),
			'prop'            =>
				array(
					'left'  => 'inherit',
					'right' => _themename_width_changer_to_px( $value['secondary'], '%' ),
				),
		);
		$block[11] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col-2 .sidebar-column-secondary',
				),
			'prop'            =>
				array(
					'right' => _themename_width_changer_to_px( $value['primary'], '%' ),
				),
		);
		$block[12] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.rtl .layout-3-col-2 .sidebar-column-secondary',
				),
			'prop'            =>
				array(
					'right' => 'inherit',
					'left'  => _themename_width_changer_to_px( $value['primary'], '%' ),
				),
		);


		//
		// Layout-3-col-3 > 1000px
		//
		$block[13] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col-3 .content-column',
				),
			'prop'            =>
				array(
					'left' => _themename_width_changer_to_px( $value['primary'], '%' ),
				),
		);
		$block[14] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.rtl .layout-3-col-3 .content-column',
				),
			'prop'            =>
				array(
					'left'  => 'inherit',
					'right' => _themename_width_changer_to_px( $value['primary'], '%' ),
				),
		);
		$block[15] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col-3 .sidebar-column-primary',
				),
			'prop'            =>
				array(
					'right' => _themename_width_changer_to_px( $value['content'], '%' ),
				),
		);
		$block[16] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.rtl .layout-3-col-3 .sidebar-column-primary',
				),
			'prop'            =>
				array(
					'right' => 'inherit',
					'left'  => _themename_width_changer_to_px( $value['content'], '%' ),
				),
		);


		//
		// Layout-3-col-4 > 1000px
		//
		$block[17] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col-4 .content-column',
				),
			'prop'            =>
				array(
					'left' => _themename_width_changer_to_px( $value['secondary'], '%' ),
				),
		);
		$block[18] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.rtl .layout-3-col-4 .content-column',
				),
			'prop'            =>
				array(
					'left'  => 'inherit',
					'right' => _themename_width_changer_to_px( $value['secondary'], '%' ),
				),
		);
		$block[19] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col-4 .sidebar-column-primary',
				),
			'prop'            =>
				array(
					'left' => _themename_width_changer_to_px( $value['secondary'], '%' ),
				),
		);
		$block[20] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.rtl .layout-3-col-4 .sidebar-column-primary',
				),
			'prop'            =>
				array(
					'left'  => 'inherit',
					'right' => _themename_width_changer_to_px( $value['secondary'], '%' ),
				),
		);
		$block[21] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col-4 .sidebar-column-secondary',
				),
			'prop'            =>
				array(
					'right' => _themename_width_changer_to_px( $value['content'] + $value['primary'], '%' ),
				),
		);
		$block[22] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.rtl .layout-3-col-4 .sidebar-column-secondary',
				),
			'prop'            =>
				array(
					'right' => 'inherit',
					'left'  => _themename_width_changer_to_px( $value['content'] + $value['primary'], '%' ),
				),
		);


		//
		// Layout-3-col-5 > 1000px
		//
		$block[23] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col-5 .content-column',
				),
			'prop'            =>
				array(
					'left' => _themename_width_changer_to_px( $value['secondary'] + $value['primary'], '%' ),
				),
		);
		$block[24] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.rtl .layout-3-col-5 .content-column',
				),
			'prop'            =>
				array(
					'left'  => 'inherit',
					'right' => _themename_width_changer_to_px( $value['secondary'] + $value['primary'], '%' ),
				),
		);
		$block[25] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col-5 .sidebar-column-primary',
				),
			'prop'            =>
				array(
					'right' => _themename_width_changer_to_px( $value['content'], '%' ),
				),
		);
		$block[26] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.rtl .layout-3-col-5 .sidebar-column-primary',
				),
			'prop'            =>
				array(
					'right' => 'inherit',
					'left'  => _themename_width_changer_to_px( $value['content'], '%' ),
				),
		);
		$block[27] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col-5 .sidebar-column-secondary',
				),
			'prop'            =>
				array(
					'right' => _themename_width_changer_to_px( $value['content'], '%' ),
				),
		);
		$block[28] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.rtl .layout-3-col-5 .sidebar-column-secondary',
				),
			'prop'            =>
				array(
					'right' => 'inherit',
					'left'  => _themename_width_changer_to_px( $value['content'], '%' ),
				),
		);


		//
		// Layout-3-col-6 > 1000px
		//
		$block[29] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col-6 .content-column',
				),
			'prop'            =>
				array(
					'left' => _themename_width_changer_to_px( $value['secondary'] + $value['primary'], '%' ),
				),
		);
		$block[30] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.rtl .layout-3-col-6 .content-column',
				),
			'prop'            =>
				array(
					'left'  => 'inherit',
					'right' => _themename_width_changer_to_px( $value['secondary'] + $value['primary'], '%' ),
				),
		);
		$block[31] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col-6 .sidebar-column-primary',
				),
			'prop'            =>
				array(
					'right' => _themename_width_changer_to_px( $value['content'] - $value['secondary'], '%' ),
				),
		);
		$block[32] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.rtl .layout-3-col-6 .sidebar-column-primary',
				),
			'prop'            =>
				array(
					'right' => 'inherit',
					'left'  => _themename_width_changer_to_px( $value['content'] - $value['secondary'], '%' ),
				),
		);
		$block[33] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col-6 .sidebar-column-secondary',
				),
			'prop'            =>
				array(
					'right' => _themename_width_changer_to_px( $value['content'] + $value['primary'], '%' ),
				),
		);
		$block[34] = array(
			'before'          => '@media (min-width: 1000px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.rtl .layout-3-col-6 .sidebar-column-secondary',
				),
			'prop'            =>
				array(
					'right' => 'inherit',
					'left'  => _themename_width_changer_to_px( $value['content'] + $value['primary'], '%' ),
				),
		);


		//
		// 500px < Layout-3-col-3 < 768px
		// 500px < Layout-3-col-5 < 768px
		// 500px < Layout-3-col-6 < 768px
		//
		$block[35] = array(
			'before'          => '@media (max-width:1000px) and (min-width:768px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col-3 .content-column',
					2 => '.layout-3-col-5 .content-column',
					3 => '.layout-3-col-6 .content-column',
				),
			'prop'            =>
				array(
					'left' => _themename_width_changer_to_px( $sm_primary, '%' ),
				),
		);
		$block[36] = array(
			'before'          => '@media (max-width:1000px) and (min-width:768px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.rtl .layout-3-col-3 .content-column',
					2 => '.rtl .layout-3-col-5 .content-column',
					3 => '.rtl .layout-3-col-6 .content-column',
				),
			'prop'            =>
				array(
					'left'  => 'inherit',
					'right' => _themename_width_changer_to_px( $sm_primary, '%' ),
				),
		);
		$block[37] = array(
			'before'          => '@media (max-width:1000px) and (min-width:768px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-3-col-3 .sidebar-column-primary',
					2 => '.layout-3-col-5 .sidebar-column-primary',
					3 => '.layout-3-col-6 .sidebar-column-primary',
				),
			'prop'            =>
				array(
					'right' => _themename_width_changer_to_px( $sm_content, '%' ),
				),
		);
		$block[38] = array(
			'before'          => '@media (max-width:1000px) and (min-width:768px){',
			'after'           => '}',
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.rtl .layout-3-col-3 .sidebar-column-primary',
					2 => '.rtl .layout-3-col-5 .sidebar-column-primary',
					3 => '.rtl .layout-3-col-6 .sidebar-column-primary',
				),
			'prop'            =>
				array(
					'right' => 'inherit',
					'left'  => _themename_width_changer_to_px( $sm_content, '%' ),
				),

		);


		$value = '';
	} // publisher_cb_css_generator_layout_3_col
}


if ( ! function_exists( 'publisher_cb_css_generator_columns_space' ) ) {
	/**
	 * Custom CSS generator space between columns
	 *
	 * @param array  $block
	 * @param string $value
	 */
	function publisher_cb_css_generator_columns_space( &$block = array(), &$value = '' ) {

		$block = array();
		$style = publisher_get_style();

		$space               = intval( $value );
		$columns_padding     = $space / 2;
		$columns_padding_neg = - 1 * $columns_padding;

		$space_1_6 = $space - ( $space / 6 );
		$space_2_6 = $space - ( ( $space / 6 ) * 2 );
		$space_3_6 = $space - ( ( $space / 6 ) * 3 );

		$block[1] = array(
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12',
					2 => '.vc_row .vc_column_container>.vc_column-inner',
				),
			'prop'            =>
				array(
					'padding-left'  => _themename_width_changer_to_px( $columns_padding ),
					'padding-right' => _themename_width_changer_to_px( $columns_padding ),
				),
		);

		$block[2] = array(
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.vc_row.wpb_row',
					2 => '.row',
				),
			'prop'            =>
				array(
					'margin-left'  => _themename_width_changer_to_px( $columns_padding_neg ),
					'margin-right' => _themename_width_changer_to_px( $columns_padding_neg ),
				),
		);

		$block[3] = array(
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1  => '.widget',
					2  => '.entry-content .better-studio-shortcode',
					3  => '.better-studio-shortcode',
					4  => '.bs-shortcode',
					5  => '.bs-listing',
					6  => '.bsac',
					7  => '.content-column > div:last-child',
					8  => '.slider-style-18-container',
					9  => '.slider-style-16-container',
					10 => '.slider-style-8-container',
					11 => '.slider-style-2-container',
					12 => '.slider-style-4-container',
					13 => '.bsp-wrapper',
					14 => '.single-container',
					15 => '.content-column > div:last-child',
					16 => '.vc_row .vc_column-inner .wpb_content_element',
					17 => '.wc-account-content-wrap',
					18 => '.order-customer-detail',
					19 => '.order-detail-wrap',
				),
			'prop'            =>
				array(
					'margin-bottom' => _themename_width_changer_to_px( $space ),
				),
		);

		$block[4] = array(
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.archive-title',
				),
			'prop'            =>
				array(
					'margin-bottom' => _themename_width_changer_to_px( $space_2_6 ),
				),
		);

		$block[5] = array(
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-1-col',
					2 => '.layout-2-col',
					3 => '.layout-3-col',
				),
			'prop'            =>
				array(
					'margin-top' => _themename_width_changer_to_px( $space_1_6 ),
				),
		);

		$block[14] = array(
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-1-col.layout-bc-before',
					2 => '.layout-2-col.layout-bc-before',
					3 => '.layout-3-col.layout-bc-before',
				),
			'prop'            =>
				array(
					'margin-top' => _themename_width_changer_to_px( $space_3_6 ),
				),
		);

		$block[6] = array(
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.entry-content>.vc_row.vc_row-fluid.vc_row-has-fill:first-child',
					2 => '.bs-listing.bs-listing-products .bs-slider-controls, .bs-listing.bs-listing-products .bs-pagination',
				),
			'prop'            =>
				array(
					'margin-top' => _themename_width_changer_to_px( - 1 * $space_1_6, 'px', '!important' ),
				),
		);

		$block[7] = array(
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1  => '.vc_col-has-fill>.vc_column-inner',
					2  => '.vc_row-has-fill+.vc_row-full-width+.vc_row>.wrapper-sticky>.vc_column_container>.vc_column-inner',
					3  => '.vc_row-has-fill+.vc_row-full-width+.vc_row>.vc_column_container>.vc_column-inner',
					4  => '.vc_row-has-fill+.vc_row>.vc_column_container>.vc_column-inner',
					5  => '.vc_row-has-fill+.vc_row>.wrapper-sticky>.vc_column_container>.vc_column-inner',
					6  => '.vc_row-has-fill+.vc_row>.vc_column_container>.vc_column-inner',
					7  => '.vc_row-has-fill+.vc_vc_row>.vc_row>.vc_vc_column>.vc_column_container>.vc_column-inner',
					8  => '.vc_row-has-fill+.vc_vc_row_inner>.vc_row>.vc_vc_column_inner>.vc_column_container>.vc_column-inner',
					9  => '.vc_row-has-fill>.vc_column_container>.vc_column-inner',
					10 => '.vc_row-has-fill>.vc_row>.vc_vc_column>.vc_column_container>.vc_column-inner',
					11 => '.vc_row-has-fill>.vc_vc_column_inner>.vc_column_container>.vc_column-inner',
				),
			'prop'            =>
				array(
					'padding-top' => _themename_width_changer_to_px( $space_1_6, 'px', '!important' ),
				),
		);

		$block[8] = array(
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.vc_row-has-fill .wpb_wrapper > .bsp-wrapper:last-child',
					2 => '.vc_col-has-fill .wpb_wrapper > .bsp-wrapper:last-child',
					3 => '.vc_row-has-fill .wpb_wrapper > .bs-listing:last-child',
					4 => '.vc_col-has-fill .wpb_wrapper > .bs-listing:last-child',
					5 => '.main-section',
					6 => '#bbpress-forums #bbp-search-form',
				),
			'prop'            =>
				array(
					'margin-bottom' => _themename_width_changer_to_px( $space_1_6 ),
				),
		);

		$block[9] = array(
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.layout-1-col .single-page-builder-content',
					2 => '.layout-3-col-0 .single-page-builder-content',
				),
			'prop'            =>
				array(
					'margin-bottom' => _themename_width_changer_to_px( - 1 * $space_1_6 ),
				),
		);

		$_check = array(
			'clean-tech'   => $space,
			'clean-design' => $space,
		);

		if ( isset( $_check[ $style ] ) ) {
			$block[16] = array(
				'skip_validation' => TRUE,
				'selector'        =>
					array(
						1 => '.bs-listing-modern-grid-listing-3.bs-listing',
					),
				'prop'            =>
					array(
						'margin-bottom' => _themename_width_changer_to_px( $_check[ $style ], 'px', '!important' ),
					),
			);
		} else {
			$block[16] = array(
				'skip_validation' => TRUE,
				'selector'        =>
					array(
						1 => '.bs-listing-modern-grid-listing-3.bs-listing',
					),
				'prop'            =>
					array(
						'margin-bottom' => _themename_width_changer_to_px( $space_3_6, 'px', '!important' ),
					),
			);
		}


		$_check = array(
			'clean-design' => 0,
		);

		if ( isset( $_check[ $style ] ) ) {
			$block[10] = array(
				'skip_validation' => TRUE,
				'selector'        =>
					array(
						1 => '.vc_row-has-fill .wpb_wrapper>.bs-listing-modern-grid-listing-3.bs-listing:last-child',

					),
				'prop'            =>
					array(
						'margin-bottom' => _themename_width_changer_to_px( $_check[ $style ], 'px', '!important' ),
					),
			);
		} else {
			$block[10] = array(
				'skip_validation' => TRUE,
				'selector'        =>
					array(
						1 => '.vc_row-has-fill .wpb_wrapper>.bs-listing-modern-grid-listing-3.bs-listing:last-child',

					),
				'prop'            =>
					array(
						'margin-bottom' => _themename_width_changer_to_px( $space_1_6 > 20 ? $space_1_6 - 20 : $space_1_6, 'px', '!important' ),
					),
			);
		}


		$block[11] = array(
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1  => '.single-container > .post-author',
					2  => '.post-related',
					3  => '.post-related + .comments-template',
					4  => '.post-related+.single-container',
					5  => '.post-related+.ajax-post-content',
					6  => '.post-related',
					7  => '.comments-template',
					8  => '.comment-respond.comments-template',
					9  => '.bsac.adloc-post-before-author',
					10 => '.woocommerce-page div.product .woocommerce-tabs',
					11 => '.woocommerce-page div.product .related.products',
					12 => '.woocommerce .cart-collaterals .cart_totals',
					13 => '.woocommerce .cart-collaterals .cross-sells',
					14 => '.woocommerce-checkout-review-order-wrap',
					15 => '.woocommerce + .woocommerce',
					16 => '.woocommerce + .bs-shortcode',
					17 => '.up-sells.products',
				),
			'prop'            =>
				array(
					'margin-top' => _themename_width_changer_to_px( $space ),
				),
		);

		$block[12] = array(
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1 => '.better-gcs-wrapper',
				),
			'prop'            =>
				array(
					'margin-top' => _themename_width_changer_to_px( - 1 * $space ),
				),
		);

		$block[13] = array(
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1  => '.slider-style-21-container',
					2  => '.slider-style-20-container',
					3  => '.slider-style-19-container',
					4  => '.slider-style-17-container',
					5  => '.slider-style-15-container',
					6  => '.slider-style-13-container',
					7  => '.slider-style-11-container',
					8  => '.slider-style-9-container',
					9  => '.slider-style-7-container',
					10 => '.slider-style-4-container.slider-container-1col',
					11 => '.slider-style-3-container',
					12 => '.slider-style-5-container',
					13 => '.slider-style-2-container.slider-container-1col',
					14 => '.slider-style-1-container',
				),
			'prop'            =>
				array(
					'padding-top'    => _themename_width_changer_to_px( $space_1_6 ),
					'padding-bottom' => _themename_width_changer_to_px( $space ),
					'margin-bottom'  => _themename_width_changer_to_px( - 1 * $space_1_6 ),
				),
		);

		// 14 is reserved

		$block[15] = array(
			'skip_validation' => TRUE,
			'selector'        =>
				array(
					1  => '.slider-style-21-container.slider-bc-before',
					2  => '.slider-style-20-container.slider-bc-before',
					3  => '.slider-style-19-container.slider-bc-before',
					4  => '.slider-style-17-container.slider-bc-before',
					5  => '.slider-style-15-container.slider-bc-before',
					6  => '.slider-style-13-container.slider-bc-before',
					7  => '.slider-style-11-container.slider-bc-before',
					8  => '.slider-style-9-container.slider-bc-before',
					9  => '.slider-style-7-container.slider-bc-before',
					11 => '.slider-style-3-container.slider-bc-before',
					12 => '.slider-style-5-container.slider-bc-before',
					14 => '.slider-style-1-container.slider-bc-before',
				),
			'prop'            =>
				array(
					'padding-top'    => _themename_width_changer_to_px( $space_3_6 ),
					'padding-bottom' => _themename_width_changer_to_px( $space_3_6 ),
					'margin-bottom'  => _themename_width_changer_to_px( $space_3_6 ),
				),
		);

		// 16 is reserved

	} // publisher_cb_css_generator_columns_space
}


if ( ! function_exists( 'publisher_cb_css_generator_views_ranking' ) ) {
	/**
	 * Custom CSS generator for views ranking
	 *
	 * @param array  $block
	 * @param string $value
	 */
	function publisher_cb_css_generator_views_ranking( &$block = array(), &$value = '' ) {

		$block = array();

		foreach ( (array) $value as $rank ) {

			if ( empty( $rank['color'] ) ) {
				continue;
			}

			if ( empty( $rank['rate'] ) ) {
				$selector = array(
					'.post-meta .views.rank-default',
					'.single-post-share .post-share-btn.post-share-btn-views.rank-default',
				);
			} else {
				$selector = array(
					'.post-meta .views.rank-' . $rank['rate'],
					'.single-post-share .post-share-btn.post-share-btn-views.rank-' . $rank['rate'],
				);
			}

			$block[] = array(
				'skip_validation' => TRUE,
				'selector'        => $selector,
				'prop'            =>
					array(
						'color' => $rank['color'] . ' !important',
					),
			);

		}

	} // publisher_cb_css_generator_views_ranking
}


if ( ! function_exists( 'publisher_cb_css_generator_shares_ranking' ) ) {
	/**
	 * Custom CSS generator for shares ranking
	 *
	 * @param array  $block
	 * @param string $value
	 */
	function publisher_cb_css_generator_shares_ranking( &$block = array(), &$value = '' ) {

		$block = array();

		foreach ( (array) $value as $rank ) {

			if ( empty( $rank['color'] ) ) {
				continue;
			}

			if ( empty( $rank['rate'] ) ) {
				$selector = array(
					'.post-meta .share.rank-default',
					'.single-post-share .post-share-btn.rank-default',
				);
			} else {
				$selector = array(
					'.post-meta .share.rank-' . $rank['rate'],
					'.single-post-share .post-share-btn.rank-' . $rank['rate'],
				);
			}

			$block[] = array(
				'skip_validation' => TRUE,
				'selector'        => $selector,
				'prop'            =>
					array(
						'color' => $rank['color'] . ' !important',
					),
			);

		}

	} // publisher_cb_css_generator_shares_ranking
}

