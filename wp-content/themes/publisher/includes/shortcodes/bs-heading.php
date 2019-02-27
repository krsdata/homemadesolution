<?php
/**
 * bs-heading.php
 *---------------------------
 * [bs-heading] shortcode
 *
 */

/**
 * Publisher Heading shortcode
 */
class Publisher_Heading_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-heading';

		$_options = array(
			'defaults'       => array(
				'title'           => publisher_translation_get( 'heading' ),
				'title_link'      => '',
				'show_title'      => 1,
				'icon'            => '',
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

		if ( ! empty( $content ) ) {
			$atts['content'] = $content;
		}

		publisher_set_prop( 'shortcode-bs-heading-atts', $atts );

		$output = publisher_get_view( 'shortcodes', 'bs-heading', '', FALSE );

		publisher_clear_props();

		return $output;

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map(
			array(
				"name"           => __( 'Heading', 'publisher' ),
				"base"           => $this->id,
				"weight"         => 10,
				"wrapper_height" => 'full',
				"category"       => __( 'Publisher', 'publisher' ),
				"params"         => array(
					array(
						"type"        => 'textfield',
						"admin_label" => TRUE,
						"heading"     => __( 'Title', 'publisher' ),
						"param_name"  => 'title',
						"value"       => $this->defaults['title'],
					),
					array(
						"type"        => 'bf_icon_select',
						"heading"     => __( 'Title Icon', 'publisher' ),
						"param_name"  => 'icon',
						"admin_label" => FALSE,
						"value"       => $this->defaults['icon'],
						"description" => __( 'Select custom icon for listing.', 'publisher' ),
					),
					array(
						"type"        => 'textfield',
						"heading"     => __( 'Title Link', 'publisher' ),
						"param_name"  => 'title_link',
						"admin_label" => FALSE,
						"value"       => $this->defaults['title_link'],
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
			)
		);
	}
}
