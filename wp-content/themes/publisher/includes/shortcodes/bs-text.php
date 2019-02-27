<?php
/**
 * bs-text.php
 *---------------------------
 * [bs-text] shortcode
 *
 */

/**
 * Publisher Text shortcode
 */
class Publisher_Text_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-text';

		$_options = array(
			'defaults'       => array(
				'title'           => __( 'Text with title', 'publisher' ),
				'title_link'      => '',
				'show_title'      => 1,
				'icon'            => '',
				'content'         => '',
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

		publisher_set_prop( 'shortcode-bs-text-atts', $atts );

		$output = publisher_get_view( 'shortcodes', 'bs-text', '', FALSE );

		publisher_clear_props();

		return $output;

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map(
			array(
				"name"           => __( 'Text with title', 'publisher' ),
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
						"description" => __( 'Select custom icon for widget.', 'publisher' ),
					),
					array(
						"type"        => 'textfield',
						"heading"     => __( 'Title Link', 'publisher' ),
						"param_name"  => 'title_link',
						"admin_label" => FALSE,
						"value"       => $this->defaults['title_link'],
					),
					array(
						"type"        => "textarea_html",
						"heading"     => __( 'Text', 'publisher' ),
						"param_name"  => 'content',
						"admin_label" => FALSE,
						"value"       => $this->defaults['content'],
						"description" => __( 'Enter Text, HTML or shortcode here.', 'publisher' ),
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
	}
}