<?php

/**
 * Publisher Products 1
 */
class Publisher_Products_1_Shortcode extends Publisher_Theme_Listing_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-products-1';

		$this->name = __( 'Products', 'publisher' );

		$this->description = '';

		$_options = array(
			'defaults'       => array(
				'title'           => publisher_translation_get( 'products' ),
				'hide_title'      => 0,
				'icon'            => '',
				//
				'post_ids'        => '',
				'category'        => '',
				'tag'             => '',
				'post_type'       => 'product',
				'offset'          => '',
				'count'           => 8,
				'order_by'        => 'date',
				'order'           => '',
				'time_filter'     => '',
				'columns'         => 4,
				'style'           => 'products',
				//
				'tabs_cat_filter' => '',
				'tabs'            => '',
			),
			'have_widget'    => FALSE,
			'have_vc_add_on' => TRUE,
		);

		add_filter( 'publisher-theme-core/pagination/filter-data/' . __CLASS__, array(
			$this,
			'append_required_atts'
		) );

		add_filter( 'publisher-theme-core/pagination-manager/query/args', array( $this, 'filter_query_args' ), 10, 3 );

		$_options = bf_merge_args( $_options, $options );

		parent::__construct( $id, $_options );

	}


	/**
	 * Adds this listing custom atts to bs_pagin
	 *
	 * @return array
	 */
	public function append_required_atts( $atts ) {
		return array_merge(
			$atts,
			array(
				'columns',
				'tax_query',
			)
		);
	}


	/**
	 * Display the inner content of listing
	 *
	 * @param string $atts         Attribute of shortcode or ajax action
	 * @param string $tab          Tab
	 * @param string $pagin_button Ajax action button
	 */
	function display_content( &$atts, $tab = '', $pagin_button = '' ) {

		publisher_set_prop( 'shortcode-bs-products-1-atts', $atts );

		publisher_get_view( 'woocommerce', 'shortcodes/bs-products-1' );
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => $this->name,
				"base"           => $this->id,
				"icon"           => $this->icon,
				"description"    => $this->description,
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
								'5' => __( '5 Column', 'publisher' ),
							),
							'group'       => __( 'General', 'publisher' ),
						),
					),
					$this->vc_map_listing_headings(),
					array(
						array(
							"type"        => 'bf_select',
							"admin_label" => TRUE,
							"heading"     => __( 'Categories', 'publisher' ),
							"param_name"  => 'category',
							"value"       => $this->defaults['category'],
							"options"     => array(
								'' => __( 'All Posts', 'publisher' ),
								array(
									'label'   => __( 'Categories', 'publisher' ),
									'options' => array(
										'category_walker' => array(
											'taxonomy' => 'product_cat'
										)
									),
								),
							),
							'group'       => __( 'Products Filter', 'publisher' ),
						),
						array(
							"type"        => 'textfield',
							"admin_label" => FALSE,
							"heading"     => __( 'Product ID filter', 'publisher' ),
							"param_name"  => 'post_ids',
							"value"       => $this->defaults['post_ids'],
							'description' => __( "Filter multiple products by ID. Enter here the product IDs separated by commas (ex: 10,27,233). To exclude products from this block add them with '-' (ex: -7, -16)", 'publisher' ),
							'group'       => __( 'Products Filter', 'publisher' ),
						),
						array(
							"type"        => 'textfield',
							"admin_label" => TRUE,
							"heading"     => __( 'Number of Products', 'publisher' ),
							"param_name"  => 'count',
							"value"       => $this->defaults['count'],
							"description" => __( 'If the field is empty the limit product number will be the number from WordPress Settings -> Reading.', 'publisher' ),
							'group'       => __( 'Products Filter', 'publisher' ),
						),
						array(
							"type"        => 'bf_select',
							"heading"     => __( 'Order By', 'publisher' ),
							"param_name"  => 'order_by',
							"admin_label" => FALSE,
							"value"       => $this->defaults['order_by'],
							"options"     => array(
								''           => __( 'Default order', 'publisher' ),
								'popularity' => __( 'Sort popularity', 'publisher' ),
								'rating'     => __( 'Sort by average rating', 'publisher' ),
								'date'       => __( 'Sort by newsness', 'publisher' ),
								'price'      => __( 'Sort by price: low to high', 'publisher' ),
								'price-desc' => __( 'Sort by price: high to low', 'publisher' ),
								'rand'       => __( 'Random', 'publisher' ),
							),
							'group'       => __( 'Products Filter', 'publisher' ),
						),
						array(
							'type'        => 'bf_select',
							'heading'     => __( 'Time Filter', 'publisher' ),
							'param_name'  => 'time_filter',
							"admin_label" => FALSE,
							"value"       => $this->defaults['time_filter'],
							"options"     => array(
								''          => __( 'No Filter', 'publisher' ),
								'today'     => __( 'Today Products', 'publisher' ),
								'yesterday' => __( 'Today + Yesterday Products', 'publisher' ),
								'week'      => __( 'This Week Products', 'publisher' ),
								'month'     => __( 'This Month Products', 'publisher' ),
								'year'      => __( 'This Year Products', 'publisher' ),
							),
							'group'       => __( 'Products Filter', 'publisher' ),
						),
						array(
							"type"        => 'textfield',
							"admin_label" => FALSE,
							"heading"     => __( 'Offset Products', 'publisher' ),
							"description" => __( 'Start the count with an offset. If you have a block that shows 4 posts before this one, you can make this one start from the 5\'th post (by using offset 4)', 'publisher' ),
							"param_name"  => 'offset',
							"value"       => $this->defaults['offset'],
							'group'       => __( 'Products Filter', 'publisher' ),
						),
					),
					$this->vc_map_listing_pagination(),
					$this->vc_map_design_options()
				)
			)
		);
	} // register_vc_add_on


	/**
	 * Callback: Filters query args for this shortcode
	 * Filter: publisher-theme-core/pagination-manager/query/args
	 *
	 * @param $wp_query_args
	 * @param $view
	 *
	 * @return mixed
	 */
	function filter_query_args( $wp_query_args, $view, $atts ) {

		if ( $view == 'Publisher_Products_1_Shortcode' ) {
			$wp_query_args = $this->isolate_query_args( $wp_query_args );

			return apply_filters( 'woocommerce_shortcode_products_query', $wp_query_args, $atts, 'products' );
		} else {
			return $wp_query_args;
		}

	}


	/**
	 * Handy function to set query args. Childs can override this
	 *
	 * @param $wp_query_args
	 *
	 * @return \WP_Query
	 */
	function set_post_query( $wp_query_args, $atts = array() ) {

		$wp_query_args = $this->isolate_query_args( $wp_query_args );

		return publisher_theme_pagin_manager()->set_post_query( apply_filters( 'woocommerce_shortcode_products_query', $wp_query_args, $atts, 'products' ) );

	}


	/**
	 * Handy function to isolate query args for WooCommerce
	 *
	 * @param $wp_query_args
	 *
	 * @return mixed
	 */
	function isolate_query_args( $wp_query_args ) {

		if ( isset( $wp_query_args['tax_query'] ) && ! empty( $wp_query_args['tax_query'][0] ) ) {
			$wp_query_args['tax_query'][0]['taxonomy'] = 'product_cat';
		}

		return $wp_query_args;
	}

} // Publisher_Products_1_Shortcode
