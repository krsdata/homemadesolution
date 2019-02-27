<?php
/***
 *  BetterStudio Themes Core.
 *
 *  ______  _____   _____ _                           _____
 *  | ___ \/  ___| |_   _| |                         /  __ \
 *  | |_/ /\ `--.    | | | |__   ___ _ __ ___   ___  | /  \/ ___  _ __ ___
 *  | ___ \ `--. \   | | | '_ \ / _ \ '_ ` _ \ / _ \ | |    / _ \| '__/ _ \
 *  | |_/ //\__/ /   | | | | | |  __/ | | | | |  __/ | \__/\ (_) | | |  __/
 *  \____/ \____/    \_/ |_| |_|\___|_| |_| |_|\___|  \____/\___/|_|  \___|
 *
 *  Copyright © 2017 Better Studio
 *
 *
 *  Our portfolio is here: http://themeforest.net/user/Better-Studio/portfolio
 *
 *  \--> BetterStudio, 2017 <--/
 */


/**
 * Class Publisher_Theme_Listing_Widget
 */
class Publisher_Theme_Listing_Widget extends BF_Widget {

	/**
	 * Register widget.
	 *
	 * @param string $shortcode_id
	 * @param string $title
	 * @param array  $desc
	 * @param bool   $widget_id
	 */
	function __construct( $shortcode_id = '', $title = '', $desc = array(), $widget_id = FALSE ) {
		parent::__construct( $shortcode_id, $title, $desc, $widget_id );
	}


	/**
	 * Front-end display of widget.
	 *
	 * @see BetterWidget::widget()
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		$this->load_defaults();
		$instance = $this->parse_args( $this->defaults, $instance );

		echo $args['before_widget'];  // escaped before inside WP

		if ( ! empty( $instance['bf-widget-title-icon'] ) ) {
			$instance['icon'] = $instance['bf-widget-title-icon'];
			unset( $instance['bf-widget-title-icon'] );
		}

		echo BF_Shortcodes_Manager::factory( $this->base_widget_id )->handle_widget( $instance ); // escaped before inside WP

		echo $args['after_widget']; // escaped before inside WP
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

		// custom
		$this->defaults['listing-settings'] = '';
	}


	/**
	 * Adds backend fields
	 */
	function load_fields() {

		// Back end form fields
		$this->fields = array_merge(
			array(
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
	 * Handy function used to add posts filters fields array to Widget fields
	 *
	 * @return array
	 */
	function fields_map_listing_filters() {
		return array(
			'post_filter_group' => array(
				'name'  => __( 'Posts Filter', 'publisher' ),
				'id'    => 'post_filter_group',
				'type'  => 'group',
				'state' => 'close',
			),
			array(
				'name'       => __( 'Categories', 'publisher' ),
				'attr_id'    => 'category',
				'type'       => 'term_select',
				'taxonomy'   => 'category',
				'input-desc' => __( 'If you need Custom Taxonomy you can find in bottom of this form.', 'publisher' ),
			),
			array(
				'name'        => __( 'Tags', 'publisher' ),
				'attr_id'     => 'tag',
				'type'        => 'ajax_select',
				'callback'    => 'BF_Ajax_Select_Callbacks::tags_callback',
				'get_name'    => 'BF_Ajax_Select_Callbacks::tag_name',
				'placeholder' => __( 'Search tag...', 'publisher' ),
				'desc'        => __( 'If the field is empty the limit post number will be the number from WordPress Settings -> Reading.', 'publisher' ),
			),
			array(
				'name'    => __( 'Number of Posts', 'publisher' ),
				'attr_id' => 'count',
				'type'    => 'text',
				'desc'    => __( 'Search and select tags. You can use combination of Category and Tags!', 'publisher' ),
			),
			array(
				'name'    => __( 'Post ID filter', 'publisher' ),
				'attr_id' => 'post_ids',
				'type'    => 'text',
				'desc'    => __( 'Filter multiple posts by ID. Enter here the post IDs separated by commas (ex: 10,27,233). To exclude posts from this block add them with \'-\' (ex: -7, -16)', 'publisher' ),
			),
			array(
				'name'    => __( 'Offset posts', 'publisher' ),
				'attr_id' => 'offset',
				'type'    => 'text',
				'desc'    => __( 'Start the count with an offset. If you have a block that shows 4 posts before this one, you can make this one start from the 5\'th post( by using offset 4)', 'publisher' ),
			),
			array(
				'name'    => __( 'Only Posts With Featured Image?', 'publisher' ),
				'attr_id' => 'featured_image',
				'type'    => 'switch',
				'desc'    => __( 'You can show only posts that have featured image with enabling this option.', 'publisher' ),
			),
			array(
				'name'    => __( 'Remove Sticky Posts?', 'publisher' ),
				'attr_id' => 'ignore_sticky_posts',
				'type'    => 'switch',
				'desc'    => __( 'You can remove sticky posts from result with enabling this option', 'publisher' ),
			),
			array(
				'name'    => __( 'Post Author filter', 'publisher' ),
				'attr_id' => 'author_ids',
				'type'    => 'text',
				'desc'    => __( 'Filter multiple authors by ID. Enter here the author IDs separated by commas (ex: 10,27,233). To exclude author from this block add them with \'-\' (ex: -7, -16)', 'publisher' ),
			),
			array(
				'name'    => __( 'Time Filter', 'publisher' ),
				'attr_id' => 'time_filter',
				'type'    => 'select',
				'options' => array(
					''          => __( 'No Filter', 'publisher' ),
					'today'     => __( 'Today Posts', 'publisher' ),
					'yesterday' => __( 'Today + Yesterday Posts', 'publisher' ),
					'week'      => __( 'This Week Posts', 'publisher' ),
					'month'     => __( 'This Month Posts', 'publisher' ),
					'year'      => __( 'This Year Posts', 'publisher' ),
				),
			),
			array(
				'name'    => __( 'Order', 'publisher' ),
				'attr_id' => 'order',
				'type'    => 'select',
				'options' => array(
					'DESC' => __( 'Latest First - Descending', 'publisher' ),
					'ASC'  => __( 'Oldest First - Ascending', 'publisher' ),
				),
			),
			array(
				'name'    => __( 'Order By', 'publisher' ),
				'attr_id' => 'order_by',
				'type'    => 'select',
				'options' => publisher_get_order_field_option(),
			),

			array(
				"type"    => 'heading',
				"name"    => __( 'Custom Post type and Taxonomy', 'publisher' ),
				"attr_id" => '_heading_1',
			),
			array(
				'name'    => __( 'Custom Post Type', 'publisher' ),
				'attr_id' => 'post_type',
				'type'    => 'text',
				'desc'    => __( 'Enter here post type ID\'s separated by commas ( ex: book,movie,product ).', 'publisher' ),
			),
			array(
				'name'    => __( 'Custom Taxonomy', 'publisher' ),
				'attr_id' => 'taxonomy',
				'type'    => 'text',
				'desc'    => __( 'Enter here custom taxonomies with "taxonomy:term_id" pattern also you can separate multiple with commas. ( ex: genre:200,genre:212,writer:120 )', 'publisher' ),
			),

			array(
				"type"    => 'heading',
				"name"    => __( 'Query Conditions', 'publisher' ),
				"attr_id" => '_heading_2',
			),
			array(
				"type"          => 'select',
				"name"          => __( 'Between Cats & Tags', 'publisher' ),
				"attr_id"       => 'cats-tags-condition',
				"admin_label"   => FALSE,
				'section_class' => 'bf-vc-third-col',
				'group'         => __( 'Posts Filter', 'publisher' ),

				'options' => array(
					'and' => __( 'And (Both Cats & Tags)', 'publisher' ),
					'or'  => __( 'OR (One or more cat/ tag)', 'publisher' ),
				),
			),
			array(
				"type"          => 'select',
				"name"          => __( 'Between Cats', 'publisher' ),
				"attr_id"       => 'cats-condition',
				"admin_label"   => FALSE,
				'section_class' => 'bf-vc-third-col',
				'group'         => __( 'Posts Filter', 'publisher' ),
				'options'       => array(
					'and' => __( 'And (All Cats)', 'publisher' ),
					'in'  => __( 'OR (One or more cat)', 'publisher' ),
				),
			),
			array(
				"type"          => 'select',
				"name"          => __( 'Between Tags', 'publisher' ),
				"attr_id"       => 'tags-condition',
				"admin_label"   => FALSE,
				'section_class' => 'bf-vc-third-col',
				'group'         => __( 'Posts Filter', 'publisher' ),
				'options'       => array(
					'and' => __( 'And (All Tags)', 'publisher' ),
					'in'  => __( 'OR (One or more tag)', 'publisher' ),
				),

			),
		);
	} // fields_map_listing_filters


	/**
	 * Handy function used to add posts filters fields array to Widget fields
	 *
	 * @return array
	 */
	function fields_map_listing_tabs() {
		return array(
			'tabs_group' => array(
				'name'  => __( 'Multi Tabs', 'publisher' ),
				'type'  => 'group',
				'id'    => 'tabs_group',
				'state' => 'close',
			),
			array(
				'name'    => __( 'Tabs', 'publisher' ),
				'attr_id' => 'tabs',
				'type'    => 'select',
				'options' => array(
					''               => __( 'No Tab', 'publisher' ),
					'cat_filter'     => __( 'Categories as Tab', 'publisher' ),
					'sub_cat_filter' => __( 'Sub Categories as Tab', 'publisher' ),
					'tax_filter'     => __( 'Taxonomies as Tab', 'publisher' ),
				),
			),
			array(
				'name'               => __( 'Selected Categories as Tab', 'publisher' ),
				'attr_id'            => 'tabs_cat_filter',
				'type'               => 'select',
				'options'            => array(
					'category_walker' => 'category_walker'
				),
				'multiple'           => TRUE,
				'desc'               => __( 'Select multiple categories with holding "Control" button. this will create multi tab header.', 'publisher' ),
				'filter-field'       => 'tabs',
				'filter-field-value' => 'cat_filter',
			),
			array(
				'name'               => __( 'Taxonomies as tab', 'publisher' ),
				'type'               => 'text',
				'attr_id'            => 'tabs_tax_filter',
				'desc'               => __( 'Enter here custom taxonomies with "taxonomy:term_id" pattern also you can separate multiple with commas. ( ex: genre:200,genre:212,writer:120 )', 'publisher' ),
				'filter-field'       => 'tabs',
				'filter-field-value' => 'tax_filter',
			),
			array(
				'name'    => __( 'Tabs content type', 'publisher' ),
				'attr_id' => 'tabs_content_type',
				'type'    => 'select',
				'options' => array(
					'deferred'  => __( 'Deferred Content', 'publisher' ),
					'preloaded' => __( 'Preloaded Content', 'publisher' ),
				),
				'desc'    => __( '<strong>Recommended</strong>: Deferred. <br> Use deferred content type to make site loading faster, There is no need to load content\'s in tabs that maybe users didn\'t see them.', 'publisher' ),
			),
		);
	} // fields_map_listing_tabs


	/**
	 * Handy function used to add listing settings (design options)
	 *
	 * @return array
	 */
	function fields_map_listing_design() {

		return array(
			'designs_group' => array(
				'name'  => __( 'Listing Blocks Settings', 'publisher' ),
				'type'  => 'group',
				'id'    => 'designs_group',
				'state' => 'close',
			),
			array(
				'name'    => __( 'Override Listing Settings?', 'publisher' ),
				'attr_id' => 'override-listing-settings',
				'type'    => 'switch',
			),
			array(
				'name'            => '',
				'attr_id'         => 'listing-settings',
				'type'            => 'custom',
				'container_class' => 'advanced-block-settings',
				'input_callback'  => array(
					'callback' => 'publisher_cb_blocks_setting_field',
					'args'     => array(
						array(
							'field'             => $this->get_listing_option_id(),
							'use_group'         => FALSE,
							'print_images'      => FALSE,
							'widget_input_name' => $this->base_widget_id,
						)
					),
				),
				'show_on'         => array( array( 'override-listing-settings=1' ) ),
			),
		);
	} // fields_map_listing_design


	/**
	 *  Handy function used to add pagination fields array to Widget fields
	 *
	 * @return array
	 */
	function fields_map_listing_pagination() {

		$groups = $this->pagination_styles_group();

		$options = array( 'none' => __( 'No Pagination', 'publisher' ) );
		foreach ( self::pagination_styles() as $key => $data ) {
			$group = &$data['group'];

			if ( ! isset( $options[ $group ] ) ) {
				$options[ $group ] = array(
					'label'   => isset( $groups[ $group ] ) ? $groups[ $group ] : $group,
					'options' => array()
				);
			}

			$options[ $group ]['options'][ $key ] = $data['name'];
		}

		return array(
			'pagination_group' => array(
				'name'  => __( 'Pagination', 'publisher' ),
				'type'  => 'group',
				'id'    => 'pagination_group',
				'state' => 'close',
			),
			array(
				'name'    => __( 'Pagination Type', 'publisher' ),
				'type'    => 'select',
				'attr_id' => 'paginate',
				'options' => $options,
			),
			array(
				'type'               => 'switch',
				'name'               => __( 'Show pagination number label', 'publisher' ),
				'attr_id'            => 'pagination-show-label',
				'group'              => __( 'Pagination', 'publisher' ),
				'filter-field'       => 'paginate',
				'filter-field-value' => 'next_prev',
			),
			array(
				'type'               => 'text',
				'name'               => __( 'Number of slides', 'publisher' ),
				'attr_id'            => 'pagination-slides-count',
				'filter-field'       => 'paginate',
				'filter-field-value' => 'slider',
			),
			array(
				'type'               => 'text',
				'name'               => __( 'Animation Speed', 'publisher' ),
				'attr_id'            => 'slider-animation-speed',
				'filter-field'       => 'paginate',
				'filter-field-value' => 'slider',
			),
			array(
				'type'               => 'switch',
				'name'               => __( 'AutoPlay', 'publisher' ),
				'attr_id'            => 'slider-autoplay',
				'filter-field'       => 'paginate',
				'filter-field-value' => 'slider',
			),
			array(
				'type'               => 'text',
				'name'               => __( 'Slide duration', 'publisher' ),
				'attr_id'            => 'slider-speed',
				'filter-field'       => 'paginate',
				'filter-field-value' => 'slider',
			),
			array(
				'type'               => 'select',
				'name'               => __( 'Display Dot Navigation', 'publisher' ),
				'attr_id'            => 'slider-control-dots',
				'options'            => array(
					'off'     => __( 'Don\'t Show', 'publisher' ),
					'style-1' => __( 'Style 1', 'publisher' ),
					'style-2' => __( 'Style 2', 'publisher' ),
					'style-3' => __( 'Style 3', 'publisher' ),
					'style-4' => __( 'Style 4', 'publisher' ),
				),
				'filter-field'       => 'paginate',
				'filter-field-value' => 'slider',
			),
			array(
				'type'               => 'select',
				'name'               => __( 'Display Control Navigation', 'publisher' ),
				'attr_id'            => 'slider-control-next-prev',
				'options'            => array(
					'off'     => __( 'Don\'t Show', 'publisher' ),
					'style-1' => __( 'Style 1', 'publisher' ),
					'style-2' => __( 'Style 2', 'publisher' ),
					'style-3' => __( 'Style 3', 'publisher' ),
					'style-4' => __( 'Style 4', 'publisher' ),
				),
				'filter-field'       => 'paginate',
				'filter-field-value' => 'slider',
			),
		);
	} // fields_map_listing_pagination


	/**
	 * Pagination styles group
	 *
	 * @return array
	 */
	protected function pagination_styles_group() {
		return array(
			'ajax'   => 'Ajax',
			'slider' => 'Slider'
		);
	}


	/**
	 * Returns global valid pagination styles
	 *
	 * @return array
	 */
	public static function pagination_styles() {
		return Publisher_Theme_Listing_Pagin_Manager::pagination_styles();
	}


	/**
	 * Get listing settings option id
	 *
	 * @since 1.1.0
	 *
	 * @return bool|string
	 */
	public function get_listing_option_id() {

		if ( preg_match( '#^bs-(.*?)-listing-(.*?)$#i', $this->base_widget_id, $match ) ) {

			return 'listing-' . $match[1] . '-' . $match[2];

		} else if ( preg_match( '#^bs-slider-(.+)#', $this->base_widget_id, $match ) ) {

			return 'listing-bs-slider-' . $match[1];
		}
	}

} // Publisher_Theme_Listing_Widget
