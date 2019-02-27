<?php
/**
 * bs-mix-listing.php
 *---------------------------
 * [bs-mix-listing-{1,2,3,4}] shortcode
 *
 */


/**
 * Publisher mix Listing 1-1
 */
class Publisher_Mix_Listing_1_1_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-1-1';

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
				'count'       => 5,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style' => 'listing-mix-1-1',

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
		publisher_get_view( 'loop', 'listing-mix-1-1' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Mix 1', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => $this->vc_map_listing_all()
			)
		);
	} // register_vc_add_on

} // Publisher_Mix_Listing_1_1_Shortcode


/**
 * Publisher Mix Listing 1-2
 */
class Publisher_Mix_Listing_1_2_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-1-2';

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
				'count'       => 5,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style' => 'listing-mix-1-2',

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
		publisher_get_view( 'loop', 'listing-mix-1-2' );
	}

	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Mix 2', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => $this->vc_map_listing_all()
			)
		);
	} // register_vc_add_on

} // Publisher_Mix_Listing_1_2_Shortcode


/**
 * Publisher Mix Listing 1-3
 */
class Publisher_Mix_Listing_1_3_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-1-3';

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
				'count'       => 6,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style' => 'listing-mix-1-3',

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
		publisher_get_view( 'loop', 'listing-mix-1-3' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Mix 3', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => $this->vc_map_listing_all()
			)
		);
	} // register_vc_add_on

} // Publisher_Mix_Listing_1_3_Shortcode


/**
 * Publisher Mix Listing 1-4
 */
class Publisher_Mix_Listing_1_4_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-1-4';

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

				'style' => 'listing-mix-1-4',

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
		publisher_get_view( 'loop', 'listing-mix-1-4' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Mix 4', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => $this->vc_map_listing_all()
			)
		);
	} // register_vc_add_on

} // Publisher_Mix_Listing_1_4_Shortcode


/**
 * Publisher Mix Listing 2-1
 */
class Publisher_Mix_Listing_2_1_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-2-1';

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
				'count'       => 8,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style' => 'listing-mix-2-1',

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
		publisher_get_view( 'loop', 'listing-mix-2-1' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map(
			array(
				"name"           => __( 'Mix 5', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => $this->vc_map_listing_all()
			)
		);
	} // register_vc_add_on

} // Publisher_Mix_Listing_2_1_Shortcode


/**
 * Publisher Mix Listing 2-2
 */
class Publisher_Mix_Listing_2_2_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-2-2';

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
				'count'       => 10,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style' => 'listing-mix-2-2',

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
		publisher_get_view( 'loop', 'listing-mix-2-2' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map(
			array(
				"name"           => __( 'Mix 6', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => $this->vc_map_listing_all()
			)
		);
	} // register_vc_add_on

} // Publisher_Mix_Listing_2_1_Shortcode


/**
 * Publisher Mix Listing 3-1
 */
class Publisher_Mix_Listing_3_1_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-3-1';

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

				'style' => 'listing-mix-3-1',

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
		publisher_get_view( 'loop', 'listing-mix-3-1' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map(
			array(
				"name"           => __( 'Mix 7', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => $this->vc_map_listing_all(),
			)
		);
	} // register_vc_add_on

} // Publisher_Mix_Listing_3_1_Shortcode


/**
 * Publisher Mix Listing 7 Widget
 */
class Publisher_Mix_Listing_3_1_Widget extends Publisher_Theme_Listing_Widget {

	/**
	 * Register widget.
	 */
	function __construct() {
		parent::__construct(
			'bs-mix-listing-3-1',
			__( 'Listing - Mix 7', 'publisher' ),
			array(
				'description' => __( 'Widget for Mix Listing 7', 'publisher' )
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
					'std'     => PUBLISHER_THEME_URI . 'images/shortcodes/bs-mix-listing-3-1-big.png',
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
 * Publisher Mix Listing 3-2
 */
class Publisher_Mix_Listing_3_2_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-3-2';

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
				'count'       => 5,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',
				'style'       => 'listing-mix-3-2',

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
	 * @param $atts
	 *
	 * @return array
	 */
	public function append_required_atts( $atts ) {

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
		publisher_get_view( 'loop', 'listing-mix-3-2' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map(
			array(
				"name"           => __( 'Mix 8', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => $this->vc_map_listing_all()
			)
		);
	} // register_vc_add_on

} // Publisher_Mix_Listing_3_2_Shortcode


/**
 * Publisher Mix Listing 8 Widget
 */
class Publisher_Mix_Listing_3_2_Widget extends Publisher_Theme_Listing_Widget {

	/**
	 * Register widget.
	 */
	function __construct() {
		parent::__construct(
			'bs-mix-listing-3-2',
			__( 'Listing - Mix 8', 'publisher' ),
			array(
				'description' => __( 'Widget for Mix Listing 8', 'publisher' )
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
					'std'     => PUBLISHER_THEME_URI . 'images/shortcodes/bs-mix-listing-3-2-big.png',
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
 * Publisher Mix Listing 3-3
 */
class Publisher_Mix_Listing_3_3_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-3-3';

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
				'count'       => 5,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style' => 'listing-mix-3-3',

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
		publisher_get_view( 'loop', 'listing-mix-3-3' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Mix 9', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => $this->vc_map_listing_all()
			)
		);
	} // register_vc_add_on

} // Publisher_Mix_Listing_3_3_Shortcode


/**
 * Publisher Mix Listing 9 Widget
 */
class Publisher_Mix_Listing_3_3_Widget extends Publisher_Theme_Listing_Widget {

	/**
	 * Register widget.
	 */
	function __construct() {
		parent::__construct(
			'bs-mix-listing-3-3',
			__( 'Listing - Mix 9', 'publisher' ),
			array(
				'description' => __( 'Widget for Mix Listing 9', 'publisher' )
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
					'std'     => PUBLISHER_THEME_URI . 'images/shortcodes/bs-mix-listing-3-3-big.png',
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
 * Publisher Mix Listing 3-4
 */
class Publisher_Mix_Listing_3_4_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-3-4';

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

				'style' => 'listing-mix-3-4',

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
	 * @param $atts
	 *
	 * @return array
	 */
	public function append_required_atts( $atts ) {

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
		publisher_get_view( 'loop', 'listing-mix-3-4' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Mix 10', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => $this->vc_map_listing_all()
			)
		);
	} // register_vc_add_on

} // Publisher_Mix_Listing_3_3_Shortcode


/**
 * Publisher Mix Listing 10 Widget
 */
class Publisher_Mix_Listing_3_4_Widget extends Publisher_Theme_Listing_Widget {

	/**
	 * Register widget.
	 */
	function __construct() {
		parent::__construct(
			'bs-mix-listing-3-4',
			__( 'Listing - Mix 10', 'publisher' ),
			array(
				'description' => __( 'Widget for Mix Listing 9', 'publisher' )
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
					'std'     => PUBLISHER_THEME_URI . 'images/shortcodes/bs-mix-listing-3-4-big.png',
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
 * Publisher Mix Listing 4-1
 */
class Publisher_Mix_Listing_4_1_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-4-1';

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
				'count'       => 5,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style'              => 'listing-mix-4-1',
				'show_excerpt_big'   => TRUE,
				'show_excerpt_small' => TRUE,

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

		$atts[] = 'show_excerpt_big';
		$atts[] = 'show_excerpt_small';
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

		publisher_set_prop( 'show-excerpt-big', $atts['show_excerpt_big'] );
		publisher_set_prop( 'show-excerpt-small', $atts['show_excerpt_small'] );
		publisher_get_view( 'loop', 'listing-mix-4-1' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Mix 11', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array_merge(
					array(
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Big Post Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt_big',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt_big'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'General', 'publisher' ),
						),
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Small Posts Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt_small',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt_small'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'General', 'publisher' ),
						),
					),
					$this->vc_map_listing_all()
				)
			)
		);
	} // register_vc_add_on

} // Publisher_Mix_Listing_4_1_Shortcode


/**
 * Publisher Mix Listing 4-2
 */
class Publisher_Mix_Listing_4_2_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-4-2';

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
				'count'       => 6,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style'              => 'listing-mix-4-2',
				'show_excerpt_big'   => TRUE,
				'show_excerpt_small' => TRUE,

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

		$atts[] = 'show_excerpt_big';
		$atts[] = 'show_excerpt_small';
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

		publisher_set_prop( 'show-excerpt-big', $atts['show_excerpt_big'] );
		publisher_set_prop( 'show-excerpt-small', $atts['show_excerpt_small'] );
		publisher_get_view( 'loop', 'listing-mix-4-2' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Mix 12', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array_merge(
					array(
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Big Post Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt_big',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt_big'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'General', 'publisher' ),
						),
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Small Posts Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt_small',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt_small'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'General', 'publisher' ),
						),
					),
					$this->vc_map_listing_all()
				),
			)
		);
	} // register_vc_add_on


	/**
	 * Excludes slider pagination
	 *
	 * @return array
	 */
	public static function pagination_styles() {
		$all_pagination_styles = parent::pagination_styles();
		unset( $all_pagination_styles['slider'] );

		return $all_pagination_styles;
	}

} // Publisher_Mix_Listing_4_2_Shortcode


/**
 * Publisher Mix Listing 4-3
 */
class Publisher_Mix_Listing_4_3_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-4-3';

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
				'count'       => 5,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style'              => 'listing-mix-4-3',
				'show_excerpt_big'   => TRUE,
				'show_excerpt_small' => TRUE,

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

		$atts[] = 'show_excerpt_big';
		$atts[] = 'show_excerpt_small';
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

		publisher_set_prop( 'show-excerpt-big', $atts['show_excerpt_big'] );
		publisher_set_prop( 'show-excerpt-small', $atts['show_excerpt_small'] );
		publisher_get_view( 'loop', 'listing-mix-4-3' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Mix 13', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array_merge(
					array(
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Big Post Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt_big',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt_big'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'General', 'publisher' ),
						),
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Small Posts Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt_small',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt_small'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'General', 'publisher' ),
						),
					),
					$this->vc_map_listing_all()
				),
			)
		);
	} // register_vc_add_on

} // Publisher_Mix_Listing_4_3_Shortcode


/**
 * Publisher Mix Listing 4-4
 */
class Publisher_Mix_Listing_4_4_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-4-4';

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
				'count'       => 6,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style'              => 'listing-mix-4-4',
				'show_excerpt_big'   => TRUE,
				'show_excerpt_small' => TRUE,

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

		$atts[] = 'show_excerpt_big';
		$atts[] = 'show_excerpt_small';
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

		publisher_set_prop( 'show-excerpt-big', $atts['show_excerpt_big'] );
		publisher_set_prop( 'show-excerpt-small', $atts['show_excerpt_small'] );
		publisher_get_view( 'loop', 'listing-mix-4-4' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Mix 14', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array_merge(
					array(
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Big Post Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt_big',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt_big'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'General', 'publisher' ),
						),
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Small Posts Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt_small',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt_small'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'General', 'publisher' ),
						),
					),
					$this->vc_map_listing_all()
				),
			)
		);
	} // register_vc_add_on


	/**
	 * Excludes slider pagination
	 *
	 * @return array
	 */
	public static function pagination_styles() {
		$all_pagination_styles = parent::pagination_styles();
		unset( $all_pagination_styles['slider'] );

		return $all_pagination_styles;
	}

} // Publisher_Mix_Listing_4_4_Shortcode


/**
 * Publisher Theme Mix Listing 4-5
 */
class Publisher_Mix_Listing_4_5_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-4-5';

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
				'count'       => 5,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style'              => 'listing-mix-4-5',
				'show_excerpt_big'   => TRUE,
				'show_excerpt_small' => TRUE,

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

		$atts[] = 'show_excerpt_big';
		$atts[] = 'show_excerpt_small';
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

		publisher_set_prop( 'show-excerpt-big', $atts['show_excerpt_big'] );
		publisher_set_prop( 'show-excerpt-small', $atts['show_excerpt_small'] );
		publisher_get_view( 'loop', 'listing-mix-4-5' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Mix 15', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array_merge(
					array(
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Big Post Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt_big',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt_big'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'General', 'publisher' ),
						),
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Small Posts Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt_small',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt_small'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'General', 'publisher' ),
						),
					),
					$this->vc_map_listing_all()
				),
			)
		);
	} // register_vc_add_on

} // Publisher_Mix_Listing_4_5_Shortcode


/**
 * Publisher Mix Listing 4-6
 */
class Publisher_Mix_Listing_4_6_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-4-6';

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
				'count'       => 6,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style'              => 'listing-mix-4-6',
				'show_excerpt_big'   => TRUE,
				'show_excerpt_small' => TRUE,

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

		$atts[] = 'show_excerpt_big';
		$atts[] = 'show_excerpt_small';
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

		publisher_set_prop( 'show-excerpt-big', $atts['show_excerpt_big'] );
		publisher_set_prop( 'show-excerpt-small', $atts['show_excerpt_small'] );
		publisher_get_view( 'loop', 'listing-mix-4-6' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Mix 16', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array_merge(
					array(
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Big Post Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt_big',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt_big'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'General', 'publisher' ),
						),
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Small Posts Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt_small',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt_small'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'General', 'publisher' ),
						),
					),
					$this->vc_map_listing_all()
				),
			)
		);
	} // register_vc_add_on

	/**
	 * Excludes slider pagination
	 *
	 * @return array
	 */
	public static function pagination_styles() {
		$all_pagination_styles = parent::pagination_styles();
		unset( $all_pagination_styles['slider'] );

		return $all_pagination_styles;
	}

} // Publisher_Mix_Listing_4_6_Shortcode


/**
 * Publisher Mix Listing 4-7
 */
class Publisher_Mix_Listing_4_7_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-4-7';

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
				'count'       => 5,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style'              => 'listing-mix-4-7',
				'show_excerpt_big'   => TRUE,
				'show_excerpt_small' => TRUE,

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

		$atts[] = 'show_excerpt_big';
		$atts[] = 'show_excerpt_small';
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

		publisher_set_prop( 'show-excerpt-big', $atts['show_excerpt_big'] );
		publisher_set_prop( 'show-excerpt-small', $atts['show_excerpt_small'] );
		publisher_get_view( 'loop', 'listing-mix-4-7' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Mix 17', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array_merge(
					array(
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Big Post Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt_big',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt_big'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'General', 'publisher' ),
						),
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Small Posts Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt_small',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt_small'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'General', 'publisher' ),
						),
					),
					$this->vc_map_listing_all()
				),
			)
		);
	} // register_vc_add_on

} // Publisher_Mix_Listing_4_7_Shortcode


/**
 * Publisher Mix Listing 4-8
 */
class Publisher_Mix_Listing_4_8_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-mix-listing-4-8';

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
				'count'       => 5,
				'order_by'    => 'date',
				'order'       => 'DESC',
				'time_filter' => '',

				'style'              => 'listing-mix-4-8',
				'show_excerpt_big'   => TRUE,
				'show_excerpt_small' => TRUE,

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

		$atts[] = 'show_excerpt_big';
		$atts[] = 'show_excerpt_small';
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

		publisher_set_prop( 'show-excerpt-big', $atts['show_excerpt_big'] );
		publisher_set_prop( 'show-excerpt-small', $atts['show_excerpt_small'] );
		publisher_get_view( 'loop', 'listing-mix-4-8' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Mix 18', 'publisher' ),
				"base"           => $this->id,
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array_merge(
					array(
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Big Post Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt_big',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt_big'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'General', 'publisher' ),
						),
						array(
							"type"          => 'bf_switchery',
							"heading"       => __( 'Show Small Posts Excerpt?', 'publisher' ),
							"param_name"    => 'show_excerpt_small',
							"admin_label"   => FALSE,
							"value"         => $this->defaults['show_excerpt_small'],
							'section_class' => 'style-floated-left bordered',
							'group'         => __( 'General', 'publisher' ),
						),
					),
					$this->vc_map_listing_all()
				),
			)
		);
	} // register_vc_add_on

} // Publisher_Mix_Listing_4_8_Shortcode
