<?php
/**
 * bs-text-listings.php
 *---------------------------
 * [bs-text-listing-{1,2,3,4}] short code & widget
 *
 */

/**
 * Publisher Text Listing 1 Shortcode
 */
class Publisher_Text_Listing_1_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-text-listing-1';

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
				'count'       => 3,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style'   => 'listing-text-1',
				'columns' => 1,

				'tabs'            => FALSE,
				'tabs_cat_filter' => '',
			),
			'have_widget'    => TRUE,
			'have_vc_add_on' => TRUE,
		);

		if ( isset( $options['shortcode_class'] ) ) {
			$_options['shortcode_class'] = $options['shortcode_class'];
		}

		if ( isset( $options['widget_class'] ) ) {
			$_options['widget_class'] = $options['widget_class'];
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
	 * @return array
	 */
	public function append_required_atts( $atts ) {

		$atts[] = 'columns';
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

		publisher_set_prop( 'listing-class', sprintf( 'columns-%d', $atts['columns'] ) );
		publisher_get_view( 'loop', 'listing-text-1' );

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map(
			array(
				"name"           => __( 'Text 1', 'publisher' ),
				"base"           => $this->id,
				"description"    => __( '1 to 4 Column', 'publisher' ),
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
								'3' => __( '3 Column', 'publisher' ),
								'4' => __( '4 Column', 'publisher' ),
							),
							'group'       => __( 'Style', 'publisher' ),
						),
					),
					$this->vc_map_listing_all()
				)
			)
		);
	} // register_vc_add_on

} // Publisher_Text_Listing_1_Shortcode


/**
 * Publisher Text Listing 1 Widget
 */
class Publisher_Text_Listing_1_Widget extends Publisher_Theme_Listing_Widget {

	/**
	 * Register widget.
	 */
	function __construct() {
		parent::__construct(
			'bs-text-listing-1',
			__( 'Listing - Text 1', 'publisher' ),
			array(
				'description' => __( 'Widget for Text Listing 1', 'publisher' )
			)
		);
	}


	/**
	 * Adds backend fields
	 */
	function load_fields() {

		// Back end form fields
		$this->fields = array_merge(
			array(
				array(
					'name'    => '',
					'attr_id' => '_help_img',
					'type'    => 'image_preview',
					'std'     => PUBLISHER_THEME_URI . 'images/shortcodes/bs-text-listing-1-big-widget.png',
				),
				array(
					'name'    => __( 'Widget Title', 'publisher' ),
					'attr_id' => 'title',
					'type'    => 'text',
				),
			),
			$this->fields_map_listing_filters(),
			$this->fields_map_listing_tabs(),
			$this->fields_map_listing_pagination(),
			$this->fields_map_listing_design()
		);
	}


	/**
	 * Loads widget -> shortcode default attrs
	 */
	public function load_defaults() {

		if ( $this->defaults_loaded ) {
			return;
		}

		$this->defaults_loaded = TRUE;
		$this->defaults        = BF_Shortcodes_Manager::factory( $this->base_widget_id )->defaults;

		$this->defaults['paginate']         = 'more_btn';
		$this->defaults['columns']          = 1;
		$this->defaults['listing-settings'] = publisher_get_option( $this->get_listing_option_id() );
	}
}


/**
 * Publisher Text Listing 2 Shortcode
 */
class Publisher_Text_Listing_2_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-text-listing-2';

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

				'style'   => 'listing-text-2',
				'columns' => 1,

				'tabs'            => FALSE,
				'tabs_cat_filter' => '',
			),
			'have_widget'    => TRUE,
			'have_vc_add_on' => TRUE,
		);

		if ( isset( $options['shortcode_class'] ) ) {
			$_options['shortcode_class'] = $options['shortcode_class'];
		}

		if ( isset( $options['widget_class'] ) ) {
			$_options['widget_class'] = $options['widget_class'];
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
	 * @return array
	 */
	public function append_required_atts( $atts ) {

		$atts[] = 'columns';
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

		if ( isset( $atts['columns'] ) ) {
			publisher_set_prop( 'listing-class', sprintf( 'columns-%d', $atts['columns'] ) );
		}
		publisher_get_view( 'loop', 'listing-text-2' );

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map(
			array(
				"name"           => __( 'Text 2', 'publisher' ),
				"base"           => $this->id,
				"description"    => __( '1 to 4 Column', 'publisher' ),
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
								'3' => __( '3 Column', 'publisher' ),
								'4' => __( '4 Column', 'publisher' ),
							),
							'group'       => __( 'Style', 'publisher' ),
						),
					),
					$this->vc_map_listing_all()
				)
			)
		);
	} // register_vc_add_on

} // Publisher_Text_Listing_2_Shortcode


/**
 * Publisher Text Listing 2 Widget
 */
class Publisher_Text_Listing_2_Widget extends Publisher_Theme_Listing_Widget {

	/**
	 * Register widget.
	 */
	function __construct() {
		parent::__construct(
			'bs-text-listing-2',
			__( 'Listing - Text 2', 'publisher' ),
			array(
				'description' => __( 'Widget for Text Listing 2', 'publisher' )
			)
		);
	}


	/**
	 * Adds backend fields
	 */
	function load_fields() {

		// Back end form fields
		$this->fields = array_merge(
			array(
				array(
					'name'    => '',
					'attr_id' => '_help_img',
					'type'    => 'image_preview',
					'std'     => PUBLISHER_THEME_URI . 'images/shortcodes/bs-text-listing-2-big-widget.png',
				),
				array(
					'name'    => __( 'Widget Title', 'publisher' ),
					'attr_id' => 'title',
					'type'    => 'text',
				),
			),
			$this->fields_map_listing_filters(),
			$this->fields_map_listing_tabs(),
			$this->fields_map_listing_pagination(),
			$this->fields_map_listing_design()
		);
	}


	/**
	 * Loads widget -> shortcode default attrs
	 */
	public function load_defaults() {

		if ( $this->defaults_loaded ) {
			return;
		}

		$this->defaults_loaded = TRUE;
		$this->defaults        = BF_Shortcodes_Manager::factory( $this->base_widget_id )->defaults;

		$this->defaults['paginate']              = 'next_prev';
		$this->defaults['pagination-show-label'] = 1;
		$this->defaults['columns']               = 1;
		$this->defaults['listing-settings']      = publisher_get_option( $this->get_listing_option_id() );
	}
}


/**
 * Publisher Text Listing 3 Shortcode
 */
class Publisher_Text_Listing_3_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-text-listing-3';

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

				'style'        => 'listing-text-3',
				'columns'      => 1,
				'show_excerpt' => 0,

				'tabs'            => FALSE,
				'tabs_cat_filter' => '',
			),
			'have_widget'    => TRUE,
			'have_vc_add_on' => TRUE,
		);

		if ( isset( $options['shortcode_class'] ) ) {
			$_options['shortcode_class'] = $options['shortcode_class'];
		}

		if ( isset( $options['widget_class'] ) ) {
			$_options['widget_class'] = $options['widget_class'];
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

		if ( isset( $atts['columns'] ) ) {
			publisher_set_prop( 'listing-class', sprintf( 'columns-%d', $atts['columns'] ) );
		}

		publisher_set_prop( 'show-excerpt', $atts['show_excerpt'] );

		publisher_get_view( 'loop', 'listing-text-3' );

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map(
			array(
				"name"           => __( 'Text 3', 'publisher' ),
				"base"           => $this->id,
				"description"    => __( '1 to 4 Column', 'publisher' ),
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
								'3' => __( '3 Column', 'publisher' ),
								'4' => __( '4 Column', 'publisher' ),
							),
							'group'       => __( 'Style', 'publisher' ),
						),
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'Style', 'publisher' ),
						),
					),
					$this->vc_map_listing_all()
				)
			)
		);
	} // register_vc_add_on

} // Publisher_Text_Listing_3_Shortcode


/**
 * Publisher Text Listing 3 Widget
 */
class Publisher_Text_Listing_3_Widget extends Publisher_Theme_Listing_Widget {

	/**
	 * Register widget.
	 */
	function __construct() {
		parent::__construct(
			'bs-text-listing-3',
			__( 'Listing - Text 3', 'publisher' ),
			array(
				'description' => __( 'Widget for Text Listing 3', 'publisher' )
			)
		);
	}


	/**
	 * Adds backend fields
	 */
	function load_fields() {

		// Back end form fields
		$this->fields = array_merge(
			array(
				array(
					'name'    => '',
					'attr_id' => '_help_img',
					'type'    => 'image_preview',
					'std'     => PUBLISHER_THEME_URI . 'images/shortcodes/bs-text-listing-3-big-widget.png',
				),
				array(
					'name'    => __( 'Widget Title', 'publisher' ),
					'attr_id' => 'title',
					'type'    => 'text',
				),
				array(
					'type'    => 'switch',
					'name'    => __( 'Show Excerpt?', 'publisher' ),
					'attr_id' => 'show_excerpt',
				),
			),
			$this->fields_map_listing_filters(),
			$this->fields_map_listing_tabs(),
			$this->fields_map_listing_pagination(),
			$this->fields_map_listing_design()
		);
	}


	/**
	 * Loads widget -> shortcode default attrs
	 */
	public function load_defaults() {

		if ( $this->defaults_loaded ) {
			return;
		}

		$this->defaults_loaded = TRUE;
		$this->defaults        = BF_Shortcodes_Manager::factory( $this->base_widget_id )->defaults;

		$this->defaults['paginate']              = 'next_prev';
		$this->defaults['pagination-show-label'] = 1;
		$this->defaults['columns']               = 1;
		$this->defaults['listing-settings']      = publisher_get_option( $this->get_listing_option_id() );
	}
}


/**
 * Publisher Text Listing 4 Shortcode
 */
class Publisher_Text_Listing_4_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-text-listing-4';

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

				'style'        => 'listing-text-4',
				'columns'      => 1,
				'show_excerpt' => 0,

				'tabs'            => FALSE,
				'tabs_cat_filter' => '',
			),
			'have_widget'    => TRUE,
			'have_vc_add_on' => TRUE,
		);

		if ( isset( $options['shortcode_class'] ) ) {
			$_options['shortcode_class'] = $options['shortcode_class'];
		}

		if ( isset( $options['widget_class'] ) ) {
			$_options['widget_class'] = $options['widget_class'];
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

		if ( isset( $atts['columns'] ) ) {
			publisher_set_prop( 'listing-class', sprintf( 'columns-%d', $atts['columns'] ) );
		}

		publisher_set_prop( 'show-excerpt', $atts['show_excerpt'] );

		publisher_get_view( 'loop', 'listing-text-4' );

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map(
			array(
				"name"           => __( 'Text 4', 'publisher' ),
				"base"           => $this->id,
				"description"    => __( '1 to 4 Column', 'publisher' ),
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
								'3' => __( '3 Column', 'publisher' ),
								'4' => __( '4 Column', 'publisher' ),
							),
							'group'       => __( 'Style', 'publisher' ),
						),
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'Style', 'publisher' ),
						),
					),
					$this->vc_map_listing_all()
				)
			)
		);
	} // register_vc_add_on

} // Publisher_Text_Listing_4_Shortcode


/**
 * Publisher Text Listing 4 Widget
 */
class Publisher_Text_Listing_4_Widget extends Publisher_Theme_Listing_Widget {

	/**
	 * Register widget.
	 */
	function __construct() {
		parent::__construct(
			'bs-text-listing-4',
			__( 'Listing - Text 4', 'publisher' ),
			array(
				'description' => __( 'Widget for Text Listing 4', 'publisher' )
			)
		);
	}


	/**
	 * Adds backend fields
	 */
	function load_fields() {

		// Back end form fields
		$this->fields = array_merge(
			array(
				array(
					'name'    => '',
					'attr_id' => '_help_img',
					'type'    => 'image_preview',
					'std'     => PUBLISHER_THEME_URI . 'images/shortcodes/bs-text-listing-4-big-widget.png',
				),
				array(
					'name'    => __( 'Widget Title', 'publisher' ),
					'attr_id' => 'title',
					'type'    => 'text',
				),
				array(
					'type'    => 'switch',
					'name'    => __( 'Show Excerpt?', 'publisher' ),
					'attr_id' => 'show_excerpt',
				),
			),
			$this->fields_map_listing_filters(),
			$this->fields_map_listing_tabs(),
			$this->fields_map_listing_pagination(),
			$this->fields_map_listing_design()
		);
	}


	/**
	 * Loads widget -> shortcode default attrs
	 */
	public function load_defaults() {

		if ( $this->defaults_loaded ) {
			return;
		}

		$this->defaults_loaded = TRUE;
		$this->defaults        = BF_Shortcodes_Manager::factory( $this->base_widget_id )->defaults;

		$this->defaults['paginate']              = 'next_prev';
		$this->defaults['pagination-show-label'] = 1;
		$this->defaults['columns']               = 1;
		$this->defaults['listing-settings']      = publisher_get_option( $this->get_listing_option_id() );
	}
}
