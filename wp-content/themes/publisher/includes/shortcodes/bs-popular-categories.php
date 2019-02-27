<?php
/**
 * bs-popular-categories.php
 *---------------------------
 * [bs-popular-categories] shortcode & widget
 *
 */

/**
 * Publisher Popular Categories Shortcode
 */
class Publisher_Popular_Categories_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-popular-categories';

		$_options = array(
			'defaults'       => array(
				'title'           => publisher_translation_get( 'widget_popular_categories' ),
				'show_title'      => 1,
				'icon'            => '',
				'count'           => 6,
				'exclude'         => '',
				'bs-show-desktop' => TRUE,
				'bs-show-tablet'  => TRUE,
				'bs-show-phone'   => TRUE,
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

		parent::__construct( $id, $_options );
	}


	/**
	 * Filter custom css codes for shortcode widget!
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	function register_custom_css( $fields ) {
		return $fields;
	}


	/**
	 * Handle displaying of shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function display( array $atts, $content = '' ) {

		ob_start();

		publisher_set_prop( 'shortcode-bs-popular-categories-atts', $atts );

		publisher_get_view( 'shortcodes', 'bs-popular-categories' );

		publisher_clear_props();

		return ob_get_clean();

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map( array(
			"name"           => __( 'Popular Categories', 'publisher' ),
			"base"           => $this->id,
			"weight"         => 10,
			"wrapper_height" => 'full',

			"category" => __( 'Publisher', 'publisher' ),
			"params"   => array(
				array(
					"type"        => 'textfield',
					"admin_label" => TRUE,
					"heading"     => __( 'Title', 'publisher' ),
					"param_name"  => 'title',
					"value"       => $this->defaults['title'],
					'group'       => __( 'General', 'publisher' ),
				),
				array(
					"type"        => 'bf_switchery',
					"admin_label" => FALSE,
					"heading"     => __( 'Show Title?', 'publisher' ),
					"param_name"  => 'show_title',
					"value"       => $this->defaults['show_title'],
					'group'       => __( 'General', 'publisher' ),
				),
				array(
					'type'        => 'bf_icon_select',
					'heading'     => __( 'Title Icon (Optional)', 'publisher' ),
					'param_name'  => 'icon',
					'admin_label' => FALSE,
					'value'       => $this->defaults['icon'],
					'description' => __( 'Select custom icon for widget.', 'publisher' ),
					'group'       => __( 'General', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Categories Limit', 'publisher' ),
					"param_name"  => 'count',
					"value"       => $this->defaults['count'],
					'group'       => __( 'General', 'publisher' ),
				),
				array(
					"type"        => 'bf_select',
					"admin_label" => FALSE,
					"heading"     => __( 'Excluded Categories', 'publisher' ),
					"input-desc"  => __( 'Hold Command in Mac or CTRL in Windows to select multiple categories.', 'publisher' ),
					"param_name"  => 'exclude',
					"multiple"    => TRUE,
					"value"       => $this->defaults['exclude'],
					"options"     => array(
						'' => __( '-- No Exclude --', 'publisher' ),
						array(
							'label'   => __( 'Categories', 'publisher' ),
							'options' => array(
								'category_walker' => 'category_walker'
							),
						),
					),
					'group'       => __( 'General', 'publisher' ),
				),
				array(
					"type"          => 'bf_switchery',
					"heading"       => __( 'Show on Desktop', 'publisher' ),
					"param_name"    => 'bs-show-desktop',
					"admin_label"   => FALSE,
					"value"         => $this->defaults['bs-show-desktop'],
					'section_class' => 'style-floated-left bordered bf-css-edit-switch',
					'group'         => __( 'Design options', 'publisher' ),
				),
				array(
					"type"          => 'bf_switchery',
					"heading"       => __( 'Show on Tablet Portrait', 'publisher' ),
					"param_name"    => 'bs-show-tablet',
					"admin_label"   => FALSE,
					"value"         => $this->defaults['bs-show-tablet'],
					'section_class' => 'style-floated-left bordered bf-css-edit-switch',
					'group'         => __( 'Design options', 'publisher' ),
				),
				array(
					"type"          => 'bf_switchery',
					"heading"       => __( 'Show on Phone', 'publisher' ),
					"param_name"    => 'bs-show-phone',
					"admin_label"   => FALSE,
					"value"         => $this->defaults['bs-show-phone'],
					'section_class' => 'style-floated-left bordered bf-css-edit-switch',
					'group'         => __( 'Design options', 'publisher' ),
				),

				array(
					'type'       => 'css_editor',
					'heading'    => __( 'CSS box', 'publisher' ),
					'param_name' => 'css',
					'group'      => __( 'Design options', 'publisher' ),
				),
				array(
					'type'          => 'textfield',
					'heading'       => __( 'Custom CSS Class', 'publisher' ),
					'param_name'    => 'custom-css-class',
					'admin_label'   => FALSE,
					'value'         => '',
					'section_class' => 'bf-section-two-column',
					'group'         => __( 'Design options', 'publisher' ),
				),
				array(
					'type'          => 'textfield',
					'heading'       => __( 'Custom ID', 'publisher' ),
					'param_name'    => 'custom-id',
					'admin_label'   => FALSE,
					'value'         => '',
					'section_class' => 'bf-section-two-column',
					'group'         => __( 'Design options', 'publisher' ),
				),
			)
		) );

	} // register_vc_add_on
}


/**
 * Publisher Popular Categories Widget
 */
class Publisher_Popular_Categories_Widget extends BF_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'bs-popular-categories',
			__( 'Publisher - Popular Categories', 'publisher' ),
			array(
				'description' => __( 'Show popular categories by post count.', 'publisher' )
			)
		);
	} // __construct


	/**
	 * Adds backend fields
	 */
	function load_fields() {

		// Back end form fields
		$this->fields = array(
			array(
				'name'    => __( 'Title', 'publisher' ),
				'attr_id' => 'title',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Categories Limit', 'publisher' ),
				'attr_id' => 'count',
				'type'    => 'text',
			),
			array(
				"type"       => 'select',
				"name"       => __( 'Excluded Categories', 'publisher' ),
				"input-desc" => __( 'Hold Command in Mac or CTRL in Windows to select multiple categories.', 'publisher' ),
				"attr_id"    => 'exclude',
				"multiple"   => TRUE,
				"options"    => array(
					'' => __( '-- No Exclude --', 'publisher' ),
					array(
						'label'   => __( 'Categories', 'publisher' ),
						'options' => array(
							'category_walker' => 'category_walker'
						),
					),
				),
			)
		);

	}
}
