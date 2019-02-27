<?php
/**
 * bs-boxes.php
 *---------------------------
 * [bs-boxes-{1,2,3,4}] shortcode
 */


/**
 * Publisher Box 1
 */
class Publisher_Box_1_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-box-1';

		$_options = array(
			'defaults'       => array(
				'title'           => '',
				'show_title'      => 0,
				'icon'            => '',
				'heading'         => '',
				'text'            => '',
				'link'            => '',
				'image'           => '',
				'bs-show-desktop' => TRUE,
				'bs-show-tablet'  => TRUE,
				'bs-show-phone'   => TRUE,
			),
			'have_widget'    => FALSE,
			'have_vc_add_on' => TRUE,
		);

		if ( isset( $options['shortcode_class'] ) ) {
			$_options['shortcode_class'] = $options['shortcode_class'];
		}

		parent::__construct( $id, $_options );

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

		publisher_set_prop( 'shortcode-bs-box-1-atts', $atts );

		publisher_get_view( 'shortcodes', 'bs-box-1' );

		publisher_clear_props();

		return ob_get_clean();

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Box 1', 'publisher' ),
				"base"           => $this->id,
				"icon"           => '',
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array(
					array(
						"type"        => 'textfield',
						"admin_label" => FALSE,
						"heading"     => __( 'Pre heading', 'publisher' ),
						'description' => __( 'Box pre heading', 'publisher' ),
						"param_name"  => 'text',
						"value"       => $this->defaults['text'],
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'textfield',
						"admin_label" => TRUE,
						"heading"     => __( 'Heading', 'publisher' ),
						'description' => __( 'Box heading', 'publisher' ),
						"param_name"  => 'heading',
						"value"       => $this->defaults['heading'],
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'textfield',
						"admin_label" => FALSE,
						"heading"     => __( 'Link', 'publisher' ),
						"param_name"  => 'link',
						"value"       => $this->defaults['link'],
						'description' => __( 'Link of box', 'publisher' ),
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'bf_media_image',
						"admin_label" => FALSE,
						"data-type"   => 'id',
						"heading"     => __( 'Box background image', 'publisher' ),
						"param_name"  => 'image',
						"value"       => $this->defaults['image'],
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'textfield',
						"admin_label" => FALSE,
						"heading"     => __( 'Title', 'publisher' ),
						"param_name"  => 'title',
						"value"       => $this->defaults['title'],
						'group'       => __( 'Custom Heading', 'publisher' ),
					),
					array(
						"type"        => 'bf_switchery',
						"admin_label" => FALSE,
						"heading"     => __( 'Show Title?', 'publisher' ),
						"param_name"  => 'show_title',
						"value"       => $this->defaults['show_title'],
						'group'       => __( 'Custom Heading', 'publisher' ),
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
					)
				)
			)
		);
	} // register_vc_add_on

} // Publisher_Box_1_Shortcode


/**
 * Publisher Box 2
 */
class Publisher_Box_2_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-box-2';

		$_options = array(
			'defaults'       => array(
				'title'           => '',
				'show_title'      => 0,
				'icon'            => '',
				'heading'         => '',
				'text'            => '',
				'link'            => '',
				'image'           => '',
				'bs-show-desktop' => TRUE,
				'bs-show-tablet'  => TRUE,
				'bs-show-phone'   => TRUE,
			),
			'have_widget'    => FALSE,
			'have_vc_add_on' => TRUE,
		);

		if ( isset( $options['shortcode_class'] ) ) {
			$_options['shortcode_class'] = $options['shortcode_class'];
		}

		parent::__construct( $id, $_options );

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

		publisher_set_prop( 'shortcode-bs-box-2-atts', $atts );

		publisher_get_view( 'shortcodes', 'bs-box-2' );

		publisher_clear_props();

		return ob_get_clean();

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Box 2', 'publisher' ),
				"base"           => $this->id,
				"icon"           => '',
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array(
					array(
						"type"        => 'textfield',
						"admin_label" => TRUE,
						"heading"     => __( 'Heading', 'publisher' ),
						'description' => __( 'Box heading', 'publisher' ),
						"param_name"  => 'heading',
						"value"       => $this->defaults['heading'],
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'textfield',
						"admin_label" => FALSE,
						"heading"     => __( 'Link', 'publisher' ),
						"param_name"  => 'link',
						"value"       => $this->defaults['link'],
						'description' => __( 'Link of box', 'publisher' ),
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'bf_media_image',
						"admin_label" => FALSE,
						"data-type"   => 'id',
						"heading"     => __( 'Box background image', 'publisher' ),
						"param_name"  => 'image',
						"value"       => $this->defaults['image'],
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'textfield',
						"admin_label" => FALSE,
						"heading"     => __( 'Title', 'publisher' ),
						"param_name"  => 'title',
						"value"       => $this->defaults['title'],
						'group'       => __( 'Custom Heading', 'publisher' ),
					),
					array(
						"type"        => 'bf_switchery',
						"admin_label" => FALSE,
						"heading"     => __( 'Show Title?', 'publisher' ),
						"param_name"  => 'show_title',
						"value"       => $this->defaults['show_title'],
						'group'       => __( 'Custom Heading', 'publisher' ),
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
					)
				)
			)
		);
	} // register_vc_add_on

} // Publisher_Box_2_Shortcode


/**
 * Publisher Box 3
 */
class Publisher_Box_3_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-box-3';

		$_options = array(
			'defaults'       => array(
				'title'      => '',
				'show_title' => 0,
				'icon'       => '',

				'text_align'      => is_rtl() ? 'right' : 'left',
				'box_icon'        => '',
				'heading'         => '',
				'text'            => '',
				'link'            => '',
				'image'           => '',
				'bs-show-desktop' => TRUE,
				'bs-show-tablet'  => TRUE,
				'bs-show-phone'   => TRUE,
			),
			'have_widget'    => FALSE,
			'have_vc_add_on' => TRUE,
		);

		if ( isset( $options['shortcode_class'] ) ) {
			$_options['shortcode_class'] = $options['shortcode_class'];
		}

		parent::__construct( $id, $_options );
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

		publisher_set_prop( 'shortcode-bs-box-3-atts', $atts );

		publisher_get_view( 'shortcodes', 'bs-box-3' );

		publisher_clear_props();

		return ob_get_clean();

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Box 3', 'publisher' ),
				"base"           => $this->id,
				"icon"           => '',
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array(
					array(
						"type"        => 'bf_icon_select',
						"heading"     => __( 'Custom Box Icon (Optional)', 'publisher' ),
						"param_name"  => 'box_icon',
						"admin_label" => FALSE,
						"value"       => $this->defaults['box_icon'],
						"description" => __( 'Select custom icon for box.', 'publisher' ),
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'textfield',
						"admin_label" => TRUE,
						"heading"     => __( 'Heading', 'publisher' ),
						'description' => __( 'Box heading', 'publisher' ),
						"param_name"  => 'heading',
						"value"       => $this->defaults['heading'],
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'bf_select',
						"admin_label" => TRUE,
						"heading"     => __( 'Text align', 'publisher' ),
						"param_name"  => 'text_align',
						"options"     => array(
							'left'   => __( 'Left align', 'publisher' ),
							'center' => __( 'Center align', 'publisher' ),
							'right'  => __( 'Right align', 'publisher' ),
						),
						"value"       => $this->defaults['text_align'],
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'textarea',
						"admin_label" => FALSE,
						"heading"     => __( 'Description', 'publisher' ),
						"param_name"  => 'text',
						"value"       => $this->defaults['text'],
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'textfield',
						"admin_label" => FALSE,
						"heading"     => __( 'Link', 'publisher' ),
						"param_name"  => 'link',
						"value"       => $this->defaults['link'],
						'description' => __( 'Link of box', 'publisher' ),
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'bf_media_image',
						"admin_label" => FALSE,
						"data-type"   => 'id',
						"heading"     => __( 'Box background image', 'publisher' ),
						"param_name"  => 'image',
						"value"       => $this->defaults['image'],
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'textfield',
						"admin_label" => FALSE,
						"heading"     => __( 'Title', 'publisher' ),
						"param_name"  => 'title',
						"value"       => $this->defaults['title'],
						'group'       => __( 'Custom Heading', 'publisher' ),
					),
					array(
						"type"        => 'bf_switchery',
						"admin_label" => FALSE,
						"heading"     => __( 'Show Title?', 'publisher' ),
						"param_name"  => 'show_title',
						"value"       => $this->defaults['show_title'],
						'group'       => __( 'Custom Heading', 'publisher' ),
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
					)
				)
			)
		);
	} // register_vc_add_on

} // Publisher_Box_3_Shortcode


/**
 * Publisher Box 4
 */
class Publisher_Box_4_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-box-4';

		$_options = array(
			'defaults'       => array(
				'title'           => '',
				'show_title'      => 0,
				'icon'            => '',
				'text_align'      => is_rtl() ? 'right' : 'left',
				'box_icon'        => '',
				'heading'         => '',
				'text'            => '',
				'link'            => '',
				'image'           => '',
				'bs-show-desktop' => TRUE,
				'bs-show-tablet'  => TRUE,
				'bs-show-phone'   => TRUE,
			),
			'have_widget'    => FALSE,
			'have_vc_add_on' => TRUE,
		);

		if ( isset( $options['shortcode_class'] ) ) {
			$_options['shortcode_class'] = $options['shortcode_class'];
		}

		parent::__construct( $id, $_options );

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

		publisher_set_prop( 'shortcode-bs-box-4-atts', $atts );

		publisher_get_view( 'shortcodes', 'bs-box-4' );

		publisher_clear_props();

		return ob_get_clean();

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {
		vc_map(
			array(
				"name"           => __( 'Box 4', 'publisher' ),
				"base"           => $this->id,
				"icon"           => '',
				"description"    => '',
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array(
					array(
						"type"        => 'bf_icon_select',
						"heading"     => __( 'Custom Box Icon (Optional)', 'publisher' ),
						"param_name"  => 'box_icon',
						"admin_label" => FALSE,
						"value"       => $this->defaults['box_icon'],
						"description" => __( 'Select custom icon for box.', 'publisher' ),
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'textfield',
						"admin_label" => TRUE,
						"heading"     => __( 'Heading', 'publisher' ),
						'description' => __( 'Box heading', 'publisher' ),
						"param_name"  => 'heading',
						"value"       => $this->defaults['heading'],
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'bf_select',
						"admin_label" => TRUE,
						"heading"     => __( 'Text align', 'publisher' ),
						"param_name"  => 'text_align',
						"options"     => array(
							'left'   => __( 'Left align', 'publisher' ),
							'center' => __( 'Center align', 'publisher' ),
							'right'  => __( 'Right align', 'publisher' ),
						),
						"value"       => $this->defaults['text_align'],
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'textarea',
						"admin_label" => FALSE,
						"heading"     => __( 'Description', 'publisher' ),
						"param_name"  => 'text',
						"value"       => $this->defaults['text'],
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'textfield',
						"admin_label" => FALSE,
						"heading"     => __( 'Link', 'publisher' ),
						"param_name"  => 'link',
						"value"       => $this->defaults['link'],
						'description' => __( 'Link of box', 'publisher' ),
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'bf_media_image',
						"admin_label" => FALSE,
						"data-type"   => 'id',
						"heading"     => __( 'Box background image', 'publisher' ),
						"param_name"  => 'image',
						"value"       => $this->defaults['image'],
						'group'       => __( 'Box', 'publisher' ),
					),
					array(
						"type"        => 'textfield',
						"admin_label" => FALSE,
						"heading"     => __( 'Title', 'publisher' ),
						"param_name"  => 'title',
						"value"       => $this->defaults['title'],
						'group'       => __( 'Custom Heading', 'publisher' ),
					),
					array(
						"type"        => 'bf_switchery',
						"admin_label" => FALSE,
						"heading"     => __( 'Show Title?', 'publisher' ),
						"param_name"  => 'show_title',
						"value"       => $this->defaults['show_title'],
						'group'       => __( 'Custom Heading', 'publisher' ),
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
					)
				)
			)
		);
	} // register_vc_add_on

} // Publisher_Box_4_Shortcode
