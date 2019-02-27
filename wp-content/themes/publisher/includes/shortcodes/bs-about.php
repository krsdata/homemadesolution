<?php
/**
 * publisher-about-shortcode.php
 *---------------------------
 * [bs-about] shortcode & widget
 *
 */

/**
 * Publisher About Shortcode
 */
class Publisher_About_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-about';

		$_options = array(
			'defaults'       => array(
				'title'           => publisher_translation_get( 'about_us' ),
				'show_title'      => 1,
				'icon'            => '',
				'content'         => '',
				'logo_text'       => '',
				'logo_img'        => '',
				'about_link_url'  => '',
				'about_link_text' => publisher_translation_get( 'widget_readmore' ),

				'link_facebook'   => '',
				'link_twitter'    => '',
				'link_google'     => '',
				'link_instagram'  => '',
				'link_email'      => '',
				'link_youtube'    => '',
				'link_dribbble'   => '',
				'link_vimeo'      => '',
				'link_github'     => '',
				'link_behance'    => '',
				'link_pinterest'  => '',
				'link_telegram'   => '',
				'link_vk'         => '',
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

		if ( ! empty( $content ) ) {
			$atts['content'] = $content;
		}

		ob_start();

		publisher_set_prop( 'shortcode-bs-about-atts', $atts );

		publisher_get_view( 'shortcodes', 'bs-about' );

		publisher_clear_props();

		return ob_get_clean();

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map( array(
			"name"           => __( 'About Us', 'publisher' ),
			"base"           => $this->id,
			"weight"         => 10,
			"wrapper_height" => 'full',

			"category" => __( 'Publisher', 'publisher' ),
			"params"   => array(
				array(
					"type"         => 'bf_media_image',
					"admin_label"  => FALSE,
					"heading"      => __( 'Logo', 'publisher' ),
					"param_name"   => 'logo_img',
					"value"        => $this->defaults['logo_img'],
					'upload_label' => __( 'Upload Logo', 'publisher' ),
					'remove_label' => __( 'Remove', 'publisher' ),
					'media_title'  => __( 'Remove', 'publisher' ),
					'media_button' => __( 'Select as Logo', 'publisher' ),
					'group'        => __( 'General', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Logo Text (alt)', 'publisher' ),
					"param_name"  => 'logo_text',
					"value"       => $this->defaults['logo_text'],
					'group'       => __( 'General', 'publisher' ),
				),
				array(
					"type"        => 'textarea',
					"admin_label" => FALSE,
					"heading"     => __( 'Description', 'publisher' ),
					"param_name"  => 'content',
					"value"       => $this->defaults['content'],
					'group'       => __( 'General', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => TRUE,
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
					'description' => __( 'Select custom icon for widget.', 'publisher' ),
					'group'       => __( 'Heading', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Read more text', 'publisher' ),
					"param_name"  => 'about_link_text',
					"value"       => $this->defaults['about_link_text'],
					'group'       => __( 'Read More', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => TRUE,
					"heading"     => __( 'Read more link', 'publisher' ),
					"param_name"  => 'about_link_url',
					"value"       => $this->defaults['about_link_url'],
					'group'       => __( 'Read More', 'publisher' ),
				),

				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Facebook Full URL', 'publisher' ),
					"param_name"  => 'link_facebook',
					"value"       => $this->defaults['link_facebook'],
					'group'       => __( 'Social Icons', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Twitter Full URL', 'publisher' ),
					"param_name"  => 'link_twitter',
					"value"       => $this->defaults['link_twitter'],
					'group'       => __( 'Social Icons', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Google+ Full URL', 'publisher' ),
					"param_name"  => 'link_google',
					"value"       => $this->defaults['link_google'],
					'group'       => __( 'Social Icons', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Instagram Full URL', 'publisher' ),
					"param_name"  => 'link_instagram',
					"value"       => $this->defaults['link_instagram'],
					'group'       => __( 'Social Icons', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Email', 'publisher' ),
					"param_name"  => 'link_email',
					"value"       => $this->defaults['link_email'],
					'group'       => __( 'Social Icons', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Youtube Full URL', 'publisher' ),
					"param_name"  => 'link_youtube',
					"value"       => $this->defaults['link_youtube'],
					'group'       => __( 'Social Icons', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Dribbble Full URL', 'publisher' ),
					"param_name"  => 'link_dribbble',
					"value"       => $this->defaults['link_dribbble'],
					'group'       => __( 'Social Icons', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Vimeo Full URL', 'publisher' ),
					"param_name"  => 'link_vimeo',
					"value"       => $this->defaults['link_vimeo'],
					'group'       => __( 'Social Icons', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Github Full URL', 'publisher' ),
					"param_name"  => 'link_github',
					"value"       => $this->defaults['link_github'],
					'group'       => __( 'Social Icons', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Behance Full URL', 'publisher' ),
					"param_name"  => 'link_behance',
					"value"       => $this->defaults['link_behance'],
					'group'       => __( 'Social Icons', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Pinterest Full URL', 'publisher' ),
					"param_name"  => 'link_pinterest',
					"value"       => $this->defaults['link_pinterest'],
					'group'       => __( 'Social Icons', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Telegram Full URL', 'publisher' ),
					"param_name"  => 'link_telegram',
					"value"       => $this->defaults['link_telegram'],
					'group'       => __( 'Social Icons', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'VK Full URL', 'publisher' ),
					"param_name"  => 'link_vk',
					"value"       => $this->defaults['link_vk'],
					'group'       => __( 'Social Icons', 'publisher' ),
				),

				// Design Options Tab
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
 * Publisher About Widget
 */
class Publisher_About_Widget extends BF_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'bs-about',
			__( 'Publisher - About Us', 'publisher' ),
			array(
				'description' => __( 'About us widget.', 'publisher' )
			)
		);
	} // __construct


	/**
	 * Loads fields
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
				'name'         => __( 'Logo Image', 'publisher' ),
				'attr_id'      => 'logo_img',
				'type'         => 'media_image',
				'upload_label' => __( 'Upload Logo', 'publisher' ),
				'remove_label' => __( 'Remove', 'publisher' ),
				'media_title'  => __( 'Remove', 'publisher' ),
				'media_button' => __( 'Select as Logo', 'publisher' ),
			),
			array(
				'name'    => __( 'Logo Text', 'publisher' ),
				'attr_id' => 'logo_text',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'About Us', 'publisher' ),
				'attr_id' => 'content',
				'type'    => 'textarea',
			),
			'link_group' => array(
				'name'  => __( 'About Link', 'publisher' ),
				'type'  => 'group',
				'id'    => 'link_group',
				'state' => 'close',
			),
			array(
				'name'    => __( 'About Link Text', 'publisher' ),
				'attr_id' => 'about_link_text',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'About Link URL', 'publisher' ),
				'attr_id' => 'about_link_url',
				'type'    => 'text',
			),

			'social_group' => array(
				'name'  => __( 'Social Icons', 'publisher' ),
				'type'  => 'group',
				'id'    => 'social_group',
				'state' => 'close',
			),
			array(
				'name'    => __( 'Facebook Full URL', 'publisher' ),
				'attr_id' => 'link_facebook',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Twitter Full URL', 'publisher' ),
				'attr_id' => 'link_twitter',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Google+ Full URL', 'publisher' ),
				'attr_id' => 'link_google',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Instagram Full URL', 'publisher' ),
				'attr_id' => 'link_instagram',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Enter Your E-Mail', 'publisher' ),
				'attr_id' => 'link_email',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Youtube Full URL', 'publisher' ),
				'attr_id' => 'link_youtube',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Dribbble Full URL', 'publisher' ),
				'attr_id' => 'link_dribbble',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Vimeo Full URL', 'publisher' ),
				'attr_id' => 'link_vimeo',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Github Full URL', 'publisher' ),
				'attr_id' => 'link_github',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Behance Full URL', 'publisher' ),
				'attr_id' => 'link_behance',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Pinterest Full URL', 'publisher' ),
				'attr_id' => 'link_pinterest',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Telegram Full URL', 'publisher' ),
				'attr_id' => 'link_telegram',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'VK Full URL', 'publisher' ),
				'attr_id' => 'link_vk',
				'type'    => 'text',
			),
		);
	} // load_fields
}


if ( ! function_exists( 'publisher_shortcode_about_get_icons' ) ) {
	/**
	 * Creates and returns about widget social network icons
	 *
	 * @param $atts
	 *
	 * @return array|bool
	 */
	function publisher_shortcode_about_get_icons( $atts ) {

		$output = '';

		if ( ! empty( $atts['link_facebook'] ) ) {
			$output .= '<li class="about-icon-item facebook"><a href="' . esc_url( $atts['link_facebook'] ) . '" target="_blank"><i class="fa fa-facebook"></i></a>';
		}

		if ( ! empty( $atts['link_twitter'] ) ) {
			$output .= '<li class="about-icon-item twitter"><a href="' . esc_url( $atts['link_twitter'] ) . '" target="_blank"><i class="fa fa-twitter"></i></a>';
		}

		if ( ! empty( $atts['link_google'] ) ) {
			$output .= '<li class="about-icon-item google-plus"><a href="' . esc_url( $atts['link_google'] ) . '" target="_blank"><i class="fa fa-google"></i></a>';
		}

		if ( ! empty( $atts['link_instagram'] ) ) {
			$output .= '<li class="about-icon-item instagram"><a href="' . esc_url( $atts['link_instagram'] ) . '" target="_blank"><i class="fa fa-instagram"></i></a>';
		}

		if ( ! empty( $atts['link_email'] ) ) {
			$output .= '<li class="about-icon-item email"><a href="' . esc_url( $atts['link_email'] ) . '" target="_blank"><i class="fa fa-envelope"></i></a>';
		}

		if ( ! empty( $atts['link_youtube'] ) ) {
			$output .= '<li class="about-icon-item youtube"><a href="' . esc_url( $atts['link_youtube'] ) . '" target="_blank"><i class="fa fa-youtube"></i></a>';
		}

		if ( ! empty( $atts['link_dribbble'] ) ) {
			$output .= '<li class="about-icon-item dribbble"><a href="' . esc_url( $atts['link_dribbble'] ) . '" target="_blank"><i class="fa fa-dribbble"></i></a>';
		}

		if ( ! empty( $atts['link_vimeo'] ) ) {
			$output .= '<li class="about-icon-item vimeo"><a href="' . esc_url( $atts['link_vimeo'] ) . '" target="_blank"><i class="fa fa-vimeo"></i></a>';
		}

		if ( ! empty( $atts['link_github'] ) ) {
			$output .= '<li class="about-icon-item github"><a href="' . esc_url( $atts['link_github'] ) . '" target="_blank"><i class="fa fa-github"></i></a>';
		}

		if ( ! empty( $atts['link_behance'] ) ) {
			$output .= '<li class="about-icon-item behance"><a href="' . esc_url( $atts['link_behance'] ) . '" target="_blank"><i class="fa fa-behance"></i></a>';
		}

		if ( ! empty( $atts['link_pinterest'] ) ) {
			$output .= '<li class="about-icon-item pinterest"><a href="' . esc_url( $atts['link_pinterest'] ) . '" target="_blank"><i class="fa fa-pinterest"></i></a>';
		}

		if ( ! empty( $atts['link_telegram'] ) ) {
			$output .= '<li class="about-icon-item telegram"><a href="' . esc_url( $atts['link_telegram'] ) . '" target="_blank"><i class="fa fa-send"></i></a>';
		}

		if ( ! empty( $atts['link_vk'] ) ) {
			$output .= '<li class="about-icon-item vk"><a href="' . esc_url( $atts['link_vk'] ) . '" target="_blank"><i class="fa fa-vk"></i></a>';
		}

		if ( ! empty( $output ) ) {
			return '<ul class="about-icons-list">' . $output . '</ul>';
		} else {
			return '';
		}
	}
} // publisher_shortcode_about_get_icons
