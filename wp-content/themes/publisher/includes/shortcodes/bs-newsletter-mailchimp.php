<?php

/**
 * bs-newsletter-mailchimp.php
 *---------------------------
 * [bs-newsletter-mailchimp] short code & widget
 *
 */
class Publisher_Newsletter_MailChimp_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-newsletter-mailchimp';

		$_options = array(
			'defaults'       => array(
				'title'           => publisher_translation_get( 'widget_newsletter' ),
				'show_title'      => 1,
				'icon'            => '',
				'mailchimp-code'  => '',
				'msg'             => publisher_translation_get( 'widget_newsletter_msg' ),
				'image'           => PUBLISHER_THEME_URI . 'images/other/email-illustration.png',
				'show-powered'    => TRUE,
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
	 * Handle displaying of shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function display( array $atts, $content = '' ) {

		ob_start();

		publisher_set_prop( 'shortcode-bs-newsletter-mailchimp-atts', $atts );

		publisher_get_view( 'shortcodes', 'bs-newsletter-mailchimp' );

		publisher_clear_props();

		return ob_get_clean();

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map( array(
			"name"           => __( 'Newsletter - MailChimp', 'publisher' ),
			"base"           => $this->id,
			"weight"         => 10,
			"wrapper_height" => 'full',
			"category"       => __( 'Publisher', 'publisher' ),
			"params"         => array(
				array(
					'heading'    => __( 'Instructions', 'publisher' ),
					'param_name' => 'help',
					'type'       => 'bf_info',
					'std'        => wp_kses(
						sprintf(
							__( '<p>To integrate MailChimp with your Publisher site, you will need MailChimp signup form code that you can find it with following steps:</p>
<ol>
    <li><a href="%s" target="_blank">Log in</a> to your MailChimp account.</li>
    <li>From your account Dashboard, click <strong>Lists</strong> in the navigation menu.</li>
    <li>Find the list you want to connect to your site, click on it.</li>
    <li>Find the "<strong>Sign up forms</strong>" from the list navigation, click on it.</li>
    <li>Click "<strong>Select</strong>" on the "<strong>Embedded</strong>" forms option.</li>
    <li>Find the "<strong>Copy/paste onto your site</strong>" section.</li>
    <li>Click anywhere in the box to select the code.</li>
    <li>Press "<strong>ctrl + C</strong>" on a PC or "<strong>command + C</strong>" on a Mac to copy the code.</li>
    <li>Paste it in following "<strong>MailChimp Form Code</strong>" field.</li>
</ol>
			                ', 'publisher' )
							,
							'https://goo.gl/MU6UWn'
						), bf_trans_allowed_html()
					),
					'state'      => 'open',
					'info-type'  => 'help',
					'group'      => __( 'Newsletter', 'publisher' ),
				),
				array(
					"type"        => 'textarea_raw_html',
					"admin_label" => FALSE,
					"heading"     => __( 'MailChimp Form Code', 'publisher' ),
					"param_name"  => 'mailchimp-code',
					"value"       => $this->defaults['mailchimp-code'],
					'group'       => __( 'Newsletter', 'publisher' ),
				),
				array(
					"type"        => 'textarea',
					"admin_label" => FALSE,
					"heading"     => __( 'MailChimp List URL', 'publisher' ),
					"param_name"  => 'mailchimp-url',
					"value"       => $this->defaults['mailchimp-code'],
					'group'       => __( 'Newsletter', 'publisher' ),
				),
				array(
					"type"         => 'bf_media_image',
					"admin_label"  => FALSE,
					"heading"      => __( 'Image', 'publisher' ),
					"param_name"   => 'image',
					"value"        => $this->defaults['image'],
					'upload_label' => __( 'Upload Image', 'publisher' ),
					'remove_label' => __( 'Remove', 'publisher' ),
					'media_title'  => __( 'Remove', 'publisher' ),
					'media_button' => __( 'Select as Image', 'publisher' ),
					'group'        => __( 'Newsletter', 'publisher' ),
				),
				array(
					"type"        => 'textarea',
					"admin_label" => FALSE,
					"heading"     => __( 'Message', 'publisher' ),
					"param_name"  => 'msg',
					"value"       => $this->defaults['msg'],
					'group'       => __( 'Newsletter', 'publisher' ),
				),
				array(
					"type"          => 'bf_switchery',
					"heading"       => __( 'Show Powered By?', 'publisher' ),
					"param_name"    => 'show-powered',
					"admin_label"   => FALSE,
					"value"         => $this->defaults['show-powered'],
					'section_class' => 'style-floated-left bordered bf-css-edit-switch',
					'group'         => __( 'Newsletter', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Title', 'publisher' ),
					"param_name"  => 'title',
					"value"       => $this->defaults['title'],
					'group'       => __( 'Heading', 'publisher' ),
				),
				array(
					"type"        => 'bf_switchery',
					"admin_label" => FALSE,
					"heading"     => __( 'Show Title?', 'publisher' ),
					"param_name"  => 'show_title',
					"value"       => $this->defaults['show_title'],
					'group'       => __( 'Heading', 'publisher' ),
				),
				array(
					'type'        => 'bf_icon_select',
					'heading'     => __( 'Title Icon (Optional)', 'publisher' ),
					'param_name'  => 'icon',
					'admin_label' => FALSE,
					'value'       => $this->defaults['icon'],
					'description' => __( 'Select custom icon for newsletter.', 'publisher' ),
					'group'       => __( 'Heading', 'publisher' ),
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


class Publisher_Newsletter_MailChimp_Widget extends BF_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'bs-newsletter-mailchimp',
			__( 'Publisher - Newsletter - MailChimp', 'publisher' ),
			array(
				'description' => __( 'MailChimp newsletter signup form widget.', 'publisher' )
			)
		);
	}


	/**
	 * Adds backend fields
	 */
	function load_fields() {

		$this->fields = array(
			array(
				'name'      => __( 'Instructions', 'publisher' ),
				'attr_id'   => 'help',
				'type'      => 'info',
				'std'       => wp_kses(
					sprintf(
						__( '<p>To integrate MailChimp with your Publisher site, you will need MailChimp signup form code that you can find it with following steps:</p>
<ol>
    <li><a href="%s" target="_blank">Log in</a> to your MailChimp account.</li>
    <li>From your account Dashboard, click <strong>Lists</strong> in the navigation menu.</li>
    <li>Find the list you want to connect to your site, click on it.</li>
    <li>Find the "<strong>Sign up forms</strong>" from the list navigation, click on it.</li>
    <li>Click "<strong>Select</strong>" on the "<strong>Embedded</strong>" forms option.</li>
    <li>Find the "<strong>Copy/paste onto your site</strong>" section.</li>
    <li>Click anywhere in the box to select the code.</li>
    <li>Press "<strong>ctrl + C</strong>" on a PC or "<strong>command + C</strong>" on a Mac to copy the code.</li>
    <li>Paste it in following "<strong>MailChimp Form Code</strong>" field.</li>
</ol>
			                ', 'publisher' )
						,
						'https://goo.gl/MU6UWn'
					), bf_trans_allowed_html()
				),
				'state'     => 'open',
				'info-type' => 'help',
			),
			array(
				'name'    => __( 'Title', 'publisher' ),
				'attr_id' => 'title',
				'type'    => 'text',
			),
			array(
				'name'            => __( 'MailChimp Form Code', 'publisher' ),
				'attr_id'         => 'mailchimp-code',
				'type'            => 'textarea',
				'container_class' => 'widget-mailchimp-code-field',
			),
			array(
				'name'            => __( 'MailChimp URL', 'publisher' ),
				'attr_id'         => 'mailchimp-url',
				'type'            => 'text',
				'container_class' => 'widget-mailchimp-url-field',
			),
			array(
				'name'         => __( 'Image', 'publisher' ),
				'attr_id'      => 'image',
				'type'         => 'media_image',
				'upload_label' => __( 'Upload Image', 'publisher' ),
				'remove_label' => __( 'Remove', 'publisher' ),
				'media_title'  => __( 'Remove', 'publisher' ),
				'media_button' => __( 'Select Image', 'publisher' ),
			),
			array(
				'name'    => __( 'Message', 'publisher' ),
				'attr_id' => 'msg',
				'type'    => 'textarea',
			),
			array(
				'name'    => __( 'Show Powered By?', 'publisher' ),
				'attr_id' => 'show-powered',
				'type'    => 'switch',
			),
		);
	}
}
