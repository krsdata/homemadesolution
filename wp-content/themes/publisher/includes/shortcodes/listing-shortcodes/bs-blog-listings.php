<?php
/**
 * bs-blog-listings.php
 *---------------------------
 * [bs-blog-listing-1] shortcode
 *
 */

/**
 * Publisher Blog Listing 1
 */
class Publisher_Blog_Listing_1_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-blog-listing-1';

		$_options = array(
			'defaults'       => array(
				'title'      => '',
				'hide_title' => 0,
				'icon'       => '',

				'category'    => '',
				'tag'         => '',
				'post_ids'    => '',
				'post_type'   => '',
				'offset'      => '',
				'count'       => 4,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style'        => 'listing-blog-1',
				'columns'      => 1,
				'show_excerpt' => 1,

				'tabs'            => FALSE,
				'tabs_cat_filter' => '',
			),
			'have_widget'    => FALSE,
			'have_vc_add_on' => TRUE,
		);

		if ( isset( $options['shortcode_class'] ) ) {
			$_options['shortcode_class'] = $options['shortcode_class'];
		}

		add_filter( 'publisher-theme-core/pagination/filter-data/' . __CLASS__, array(
			$this,
			'append_required_atts'
		) );

		parent::__construct( $id, $_options );

	}


	/**
	 * Adds this listing custom atts to bs_pagin
	 *
	 * @param $atts
	 *
	 * @return array
	 */
	public function append_required_atts( $atts ) {

		$atts[] = 'columns';
		$atts[] = 'show_excerpt';
		$atts[] = 'override-listing-settings';
		$atts[] = 'listing-settings';

		return $atts;
	}


	/**
	 * Display the inner content of listing
	 *
	 * @param string $atts         Attribute of shortcode or ajax action
	 * @param string $tab          Tab
	 * @param string $pagin_button Ajax action button
	 */
	function display_content( &$atts, $tab = '', $pagin_button = '' ) {

		$_check = array(
			'more_btn'          => '',
			'infinity'          => '',
			'more_btn_infinity' => '',
		);

		if ( isset( $_check[ $pagin_button ] ) ) {
			publisher_set_prop( 'show-listing-wrapper', FALSE );
			$atts['bs-pagin-add-to']   = '.listing';
			$atts['bs-pagin-add-type'] = 'append';
		}

		unset( $_check ); // clear memory

		publisher_set_prop( 'listing-columns', $atts['columns'] );
		publisher_set_prop( 'show-excerpt', $atts['show_excerpt'] );
		publisher_get_view( 'loop', 'listing-blog-1' );

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Blog 1', 'publisher' ),
				"base"           => $this->id,
				"description"    => __( '1 and 2 Column', 'publisher' ),
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array_merge(
					array(
						array(
							'type'        => 'bf_select',
							'heading'     => __( 'Columns', 'publisher' ),
							'param_name'  => 'columns',
							"admin_label" => TRUE,
							"value"       => $this->defaults['columns'],
							"options"     => array(
								'1' => __( '1 Column', 'publisher' ),
								'2' => __( '2 Column', 'publisher' ),
							),
							'group'       => __( 'General', 'publisher' ),
						),
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Post Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt'],
							'section_class' => 'style-floated-left bordered',
							"description"   => __( 'You can hide post excerpt with turning off this field.', 'publisher' ),
							'group'         => __( 'General', 'publisher' ),
						),
					),
					$this->vc_map_listing_all()
				)
			)
		);
	} // register_vc_add_on

} // Publisher_Blog_Listing_1_Shortcode


/**
 * Publisher Blog Listing 2
 */
class Publisher_Blog_Listing_2_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-blog-listing-2';

		$_options = array(
			'defaults'       => array(
				'title'      => '',
				'hide_title' => 0,
				'icon'       => '',

				'category'    => '',
				'tag'         => '',
				'post_ids'    => '',
				'post_type'   => '',
				'offset'      => '',
				'count'       => 4,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style'        => 'listing-blog-2',
				'columns'      => 1,
				'show_excerpt' => 1,

				'tabs'            => FALSE,
				'tabs_cat_filter' => '',
			),
			'have_widget'    => FALSE,
			'have_vc_add_on' => TRUE,
		);

		if ( isset( $options['shortcode_class'] ) ) {
			$_options['shortcode_class'] = $options['shortcode_class'];
		}

		add_filter( 'publisher-theme-core/pagination/filter-data/' . __CLASS__, array(
			$this,
			'append_required_atts'
		) );

		parent::__construct( $id, $_options );

	}


	/**
	 * Adds this listing custom atts to bs_pagin
	 *
	 * @param $atts
	 *
	 * @return array
	 */
	public function append_required_atts( $atts ) {

		$atts[] = 'columns';
		$atts[] = 'show_excerpt';
		$atts[] = 'override-listing-settings';
		$atts[] = 'listing-settings';

		return $atts;
	}


	/**
	 * Display the inner content of listing
	 *
	 * @param string $atts         Attribute of shortcode or ajax action
	 * @param string $tab          Tab
	 * @param string $pagin_button Ajax action button
	 */
	function display_content( &$atts, $tab = '', $pagin_button = '' ) {

		$_check = array(
			'more_btn'          => '',
			'infinity'          => '',
			'more_btn_infinity' => '',
		);

		if ( isset( $_check[ $pagin_button ] ) ) {
			publisher_set_prop( 'show-listing-wrapper', FALSE );
			$atts['bs-pagin-add-to']   = '.listing';
			$atts['bs-pagin-add-type'] = 'append';
		}

		unset( $_check );

		publisher_set_prop( 'listing-columns', $atts['columns'] );
		publisher_set_prop( 'show-excerpt', $atts['show_excerpt'] );
		publisher_get_view( 'loop', 'listing-blog-2' );

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Blog 2', 'publisher' ),
				"base"           => $this->id,
				"description"    => __( '1 and 2 Column', 'publisher' ),
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array_merge(
					array(
						array(
							'type'        => 'bf_select',
							'heading'     => __( 'Columns', 'publisher' ),
							'param_name'  => 'columns',
							"admin_label" => TRUE,
							"value"       => $this->defaults['columns'],
							"options"     => array(
								'1' => __( '1 Column', 'publisher' ),
								'2' => __( '2 Column', 'publisher' ),
							),
							'group'       => __( 'General', 'publisher' ),
						),
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Post Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt'],
							'section_class' => 'style-floated-left bordered',
							"description"   => __( 'You can hide post excerpt with turning off this field.', 'publisher' ),
							'group'         => __( 'General', 'publisher' ),
						),
					),
					$this->vc_map_listing_all()
				)
			)
		);
	} // register_vc_add_on

} // Publisher_Blog_Listing_2_Shortcode


/**
 * Publisher Blog Listing 3
 */
class Publisher_Blog_Listing_3_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-blog-listing-3';

		$_options = array(
			'defaults'       => array(
				'title'      => '',
				'hide_title' => 0,
				'icon'       => '',

				'category'    => '',
				'tag'         => '',
				'post_ids'    => '',
				'post_type'   => '',
				'offset'      => '',
				'count'       => 4,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style'        => 'listing-blog-3',
				'columns'      => 1,
				'show_excerpt' => 1,

				'tabs'            => FALSE,
				'tabs_cat_filter' => '',
			),
			'have_widget'    => FALSE,
			'have_vc_add_on' => TRUE,
		);

		if ( isset( $options['shortcode_class'] ) ) {
			$_options['shortcode_class'] = $options['shortcode_class'];
		}

		add_filter( 'publisher-theme-core/pagination/filter-data/' . __CLASS__, array(
			$this,
			'append_required_atts'
		) );

		parent::__construct( $id, $_options );

	}


	/**
	 * Adds this listing custom atts to bs_pagin
	 *
	 * @param $atts
	 *
	 * @return array
	 */
	public function append_required_atts( $atts ) {

		$atts[] = 'columns';
		$atts[] = 'show_excerpt';
		$atts[] = 'override-listing-settings';
		$atts[] = 'listing-settings';

		return $atts;
	}


	/**
	 * Display the inner content of listing
	 *
	 * @param string $atts         Attribute of shortcode or ajax action
	 * @param string $tab          Tab
	 * @param string $pagin_button Ajax action button
	 */
	function display_content( &$atts, $tab = '', $pagin_button = '' ) {

		$_check = array(
			'more_btn'          => '',
			'infinity'          => '',
			'more_btn_infinity' => '',
		);

		if ( isset( $_check[ $pagin_button ] ) ) {
			publisher_set_prop( 'show-listing-wrapper', FALSE );
			$atts['bs-pagin-add-to']   = '.listing';
			$atts['bs-pagin-add-type'] = 'append';
		}

		unset( $_check ); // clear memory

		publisher_set_prop( 'listing-columns', $atts['columns'] );
		publisher_set_prop( 'show-excerpt', $atts['show_excerpt'] );
		publisher_get_view( 'loop', 'listing-blog-3' );

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Blog 3', 'publisher' ),
				"base"           => $this->id,
				"description"    => __( '1 and 2 Column', 'publisher' ),
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array_merge(
					array(
						array(
							'type'        => 'bf_select',
							'heading'     => __( 'Columns', 'publisher' ),
							'param_name'  => 'columns',
							"admin_label" => TRUE,
							"value"       => $this->defaults['columns'],
							"options"     => array(
								'1' => __( '1 Column', 'publisher' ),
								'2' => __( '2 Column', 'publisher' ),
							),
							'group'       => __( 'General', 'publisher' ),
						),
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Post Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt'],
							'section_class' => 'style-floated-left bordered',
							"description"   => __( 'You can hide post excerpt with turning off this field.', 'publisher' ),
							'group'         => __( 'General', 'publisher' ),
						),
					),
					$this->vc_map_listing_all()
				)
			)
		);
	} // register_vc_add_on

} // Publisher_Blog_Listing_3_Shortcode


/**
 * Publisher Blog Listing 4
 */
class Publisher_Blog_Listing_4_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-blog-listing-4';

		$_options = array(
			'defaults'       => array(
				'title'      => '',
				'hide_title' => 0,
				'icon'       => '',

				'category'    => '',
				'tag'         => '',
				'post_ids'    => '',
				'post_type'   => '',
				'offset'      => '',
				'count'       => 4,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style'        => 'listing-blog-4',
				'columns'      => 1,
				'show_excerpt' => 1,

				'tabs'            => FALSE,
				'tabs_cat_filter' => '',
			),
			'have_widget'    => FALSE,
			'have_vc_add_on' => TRUE,
		);

		if ( isset( $options['shortcode_class'] ) ) {
			$_options['shortcode_class'] = $options['shortcode_class'];
		}

		add_filter( 'publisher-theme-core/pagination/filter-data/' . __CLASS__, array(
			$this,
			'append_required_atts'
		) );

		parent::__construct( $id, $_options );

	}


	/**
	 * Adds this listing custom atts to bs_pagin
	 *
	 * @param $atts
	 *
	 * @return array
	 */
	public function append_required_atts( $atts ) {

		$atts[] = 'columns';
		$atts[] = 'show_excerpt';
		$atts[] = 'override-listing-settings';
		$atts[] = 'listing-settings';

		return $atts;
	}


	/**
	 * Display the inner content of listing
	 *
	 * @param string $atts         Attribute of shortcode or ajax action
	 * @param string $tab          Tab
	 * @param string $pagin_button Ajax action button
	 */
	function display_content( &$atts, $tab = '', $pagin_button = '' ) {

		$_check = array(
			'more_btn'          => '',
			'infinity'          => '',
			'more_btn_infinity' => '',
		);

		if ( isset( $_check[ $pagin_button ] ) ) {
			publisher_set_prop( 'show-listing-wrapper', FALSE );
			$atts['bs-pagin-add-to']   = '.listing';
			$atts['bs-pagin-add-type'] = 'append';
		}

		unset( $_check );

		publisher_set_prop( 'listing-columns', $atts['columns'] );
		publisher_set_prop( 'show-excerpt', $atts['show_excerpt'] );
		publisher_get_view( 'loop', 'listing-blog-4' );

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Blog 4', 'publisher' ),
				"base"           => $this->id,
				"description"    => __( '1 and 2 Column', 'publisher' ),
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array_merge(
					array(
						array(
							'type'        => 'bf_select',
							'heading'     => __( 'Columns', 'publisher' ),
							'param_name'  => 'columns',
							"admin_label" => TRUE,
							"value"       => $this->defaults['columns'],
							"options"     => array(
								'1' => __( '1 Column', 'publisher' ),
								'2' => __( '2 Column', 'publisher' ),
							),
							'group'       => __( 'General', 'publisher' ),
						),
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Post Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt'],
							'section_class' => 'style-floated-left bordered',
							"description"   => __( 'You can hide post excerpt with turning off this field.', 'publisher' ),
							'group'         => __( 'General', 'publisher' ),
						),
					),
					$this->vc_map_listing_all()
				)
			)
		);
	} // register_vc_add_on

} // Publisher_Blog_Listing_4_Shortcode


/**
 * Publisher Blog Listing 5
 */
class Publisher_Blog_Listing_5_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-blog-listing-5';

		$_options = array(
			'defaults'       => array(
				'title'      => '',
				'hide_title' => 0,
				'icon'       => '',

				'category'    => '',
				'tag'         => '',
				'post_ids'    => '',
				'post_type'   => '',
				'offset'      => '',
				'count'       => 4,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style'        => 'listing-blog-1',
				'columns'      => 1,
				'show_excerpt' => 1,

				'tabs'            => FALSE,
				'tabs_cat_filter' => '',
			),
			'have_widget'    => FALSE,
			'have_vc_add_on' => TRUE,
		);

		if ( isset( $options['shortcode_class'] ) ) {
			$_options['shortcode_class'] = $options['shortcode_class'];
		}

		add_filter( 'publisher-theme-core/pagination/filter-data/' . __CLASS__, array(
			$this,
			'append_required_atts'
		) );

		parent::__construct( $id, $_options );

	}


	/**
	 * Adds this listing custom atts to bs_pagin
	 *
	 * @param $atts
	 *
	 * @return array
	 */
	public function append_required_atts( $atts ) {

		$atts[] = 'columns';
		$atts[] = 'show_excerpt';
		$atts[] = 'override-listing-settings';
		$atts[] = 'listing-settings';

		return $atts;
	}


	/**
	 * Display the inner content of listing
	 *
	 * @param string $atts         Attribute of shortcode or ajax action
	 * @param string $tab          Tab
	 * @param string $pagin_button Ajax action button
	 */
	function display_content( &$atts, $tab = '', $pagin_button = '' ) {

		$_check = array(
			'more_btn'          => '',
			'infinity'          => '',
			'more_btn_infinity' => '',
		);

		if ( isset( $_check[ $pagin_button ] ) ) {
			publisher_set_prop( 'show-listing-wrapper', FALSE );
			$atts['bs-pagin-add-to']   = '.listing';
			$atts['bs-pagin-add-type'] = 'append';
		}

		unset( $_check );

		publisher_set_prop( 'listing-columns', $atts['columns'] );
		publisher_set_prop( 'show-excerpt', isset( $atts['show_excerpt'] ) ? $atts['show_excerpt'] : NULL );
		publisher_get_view( 'loop', 'listing-blog-5' );

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Blog 5', 'publisher' ),
				"base"           => $this->id,
				"description"    => __( '1 and 2 Column', 'publisher' ),
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array_merge(
					array(
						array(
							'type'        => 'bf_select',
							'heading'     => __( 'Columns', 'publisher' ),
							'param_name'  => 'columns',
							"admin_label" => TRUE,
							"value"       => $this->defaults['columns'],
							"options"     => array(
								'1' => __( '1 Column', 'publisher' ),
								'2' => __( '2 Column', 'publisher' ),
							),
							'group'       => __( 'General', 'publisher' ),
						),
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Post Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt'],
							'section_class' => 'style-floated-left bordered',
							"description"   => __( 'You can hide post excerpt with turning off this field.', 'publisher' ),
							'group'         => __( 'General', 'publisher' ),
						),
					),
					$this->vc_map_listing_all()
				)
			)
		);
	} // register_vc_add_on

} // Publisher_Blog_Listing_5_Shortcode
