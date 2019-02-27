<?php
/**
 * bs-google-plus.php
 *---------------------------
 * [bs-google-plus] short code & widget
 *
 */

/**
 * Publisher Google+ Shortcode
 */
class Publisher_Google_Plus_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-google-plus';

		$_options = array(
			'defaults'       => array(
				'title'           => publisher_translation_get( 'widget_google_plus' ),
				'show_title'      => TRUE,
				'icon'            => '',
				'type'            => 'profile', // or page, community
				'url'             => '',
				'width'           => '326',
				'scheme'          => 'light', // or dark
				'layout'          => 'portrait', // or Landscape
				'cover'           => 'show',
				'tagline'         => 'show',
				'lang'            => 'en-US',
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

		publisher_set_prop( 'shortcode-bs-google-plus-atts', $atts );

		publisher_get_view( 'shortcodes', 'bs-google-plus' );

		publisher_clear_props();

		return ob_get_clean();

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map( array(
			"name"           => __( 'Google+', 'publisher' ),
			"base"           => $this->id,
			"weight"         => 10,
			"wrapper_height" => 'full',

			"category" => __( 'Publisher', 'publisher' ),
			"params"   => array(
				array(
					"type"        => 'bf_select',
					"admin_label" => FALSE,
					"heading"     => __( 'Type', 'publisher' ),
					"param_name"  => 'type',
					"value"       => $this->defaults['type'],
					'options'     => array(
						'profile'   => __( 'Profile', 'publisher' ),
						'page'      => __( 'Page', 'publisher' ),
						'community' => __( 'Community', 'publisher' ),
					),
					'group'       => __( 'Google+', 'publisher' ),
				),
				array(
					"type"               => 'textfield',
					"admin_label"        => TRUE,
					"heading"            => __( 'Google+ Page URL', 'publisher' ),
					"param_name"         => 'url',
					"value"              => $this->defaults['url'],
					'group'              => __( 'Google+', 'publisher' ),
					'filter-field'       => 'type',
					'filter-field-value' => 'page',
				),
				array(
					"type"        => 'bf_select',
					"admin_label" => FALSE,
					"heading"     => __( 'Color Scheme', 'publisher' ),
					"param_name"  => 'scheme',
					"value"       => $this->defaults['scheme'],
					'options'     => array(
						'light' => __( 'Light', 'publisher' ),
						'dark'  => __( 'Dark', 'publisher' ),
					),
					'group'       => __( 'Style', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Width', 'publisher' ),
					"param_name"  => 'width',
					"value"       => $this->defaults['width'],
					'group'       => __( 'Style', 'publisher' ),
				),
				array(
					'type'        => 'bf_select',
					'heading'     => __( 'Layout', 'publisher' ),
					'param_name'  => 'layout',
					"admin_label" => FALSE,
					"value"       => $this->defaults['layout'],
					"options"     => array(
						'portrait'  => __( 'Portrait', 'publisher' ),
						'landscape' => __( 'Landscape', 'publisher' ),
					),
					'group'       => __( 'Style', 'publisher' ),
				),
				array(
					'type'        => 'bf_select',
					'heading'     => __( 'Cover', 'publisher' ),
					'param_name'  => 'cover',
					"admin_label" => FALSE,
					"value"       => $this->defaults['cover'],
					'options'     => array(
						'show' => __( 'Show', 'publisher' ),
						'hide' => __( 'Hide', 'publisher' ),
					),
					'group'       => __( 'Style', 'publisher' ),
				),
				array(
					'type'        => 'bf_select',
					'heading'     => __( 'Tagline', 'publisher' ),
					'param_name'  => 'tagline',
					"admin_label" => FALSE,
					"value"       => $this->defaults['tagline'],
					'options'     => array(
						'show' => __( 'Show', 'publisher' ),
						'hide' => __( 'Hide', 'publisher' ),
					),
					'group'       => __( 'Style', 'publisher' ),
				),
				array(
					'type'        => 'bf_select',
					'heading'     => __( 'Language', 'publisher' ),
					'param_name'  => 'lang',
					"admin_label" => FALSE,
					"value"       => $this->defaults['tagline'],
					'options'     => array(
						'af'     => __( 'Afrikaans', 'publisher' ),
						'am'     => __( 'Amharic', 'publisher' ),
						'ar'     => __( 'Arabic', 'publisher' ),
						'eu'     => __( 'Basque', 'publisher' ),
						'bn'     => __( 'Bengali', 'publisher' ),
						'bg'     => __( 'Bulgarian', 'publisher' ),
						'ca'     => __( 'Catalan', 'publisher' ),
						'zh-HK'  => __( 'Chinese (Hong Kong)', 'publisher' ),
						'zh-CN'  => __( 'Chinese (Simplified)', 'publisher' ),
						'zh-TW'  => __( 'Chinese (Traditional)', 'publisher' ),
						'hr'     => __( 'Croatian', 'publisher' ),
						'cs'     => __( 'Czech', 'publisher' ),
						'da'     => __( 'Danish', 'publisher' ),
						'nl'     => __( 'Dutch', 'publisher' ),
						'en-GB'  => __( 'English (UK)', 'publisher' ),
						'en-US'  => __( 'English (US)', 'publisher' ),
						'et'     => __( 'Estonian', 'publisher' ),
						'fil'    => __( 'Filipino', 'publisher' ),
						'fi'     => __( 'Finnish', 'publisher' ),
						'fr'     => __( 'French', 'publisher' ),
						'fr-CA'  => __( 'French (Canadian)', 'publisher' ),
						'gl'     => __( 'Galician', 'publisher' ),
						'de'     => __( 'German', 'publisher' ),
						'el'     => __( 'Greek', 'publisher' ),
						'gu'     => __( 'Gujarati', 'publisher' ),
						'iw'     => __( 'Hebrew', 'publisher' ),
						'hi'     => __( 'Hindi', 'publisher' ),
						'hu'     => __( 'Hungarian', 'publisher' ),
						'is'     => __( 'Icelandic', 'publisher' ),
						'id'     => __( 'Indonesian', 'publisher' ),
						'it'     => __( 'Italian', 'publisher' ),
						'ja'     => __( 'Japanese', 'publisher' ),
						'kn'     => __( 'Kannada', 'publisher' ),
						'ko'     => __( 'Korean', 'publisher' ),
						'lv'     => __( 'Latvian', 'publisher' ),
						'lt'     => __( 'Lithuanian', 'publisher' ),
						'ms'     => __( 'Malay', 'publisher' ),
						'ml'     => __( 'Malayalam', 'publisher' ),
						'mr'     => __( 'Marathi', 'publisher' ),
						'no'     => __( 'Norwegian', 'publisher' ),
						'fa'     => __( 'Persian', 'publisher' ),
						'pl'     => __( 'Polish', 'publisher' ),
						'pt-BR'  => __( 'Portuguese (Brazil)', 'publisher' ),
						'pt-PT'  => __( 'Portuguese (Portugal)', 'publisher' ),
						'ro'     => __( 'Romanian', 'publisher' ),
						'ru'     => __( 'Russian', 'publisher' ),
						'sr'     => __( 'Serbian', 'publisher' ),
						'sk'     => __( 'Slovak', 'publisher' ),
						'sl'     => __( 'Slovenian', 'publisher' ),
						'es'     => __( 'Spanish', 'publisher' ),
						'es-419' => __( 'Spanish (Latin America)', 'publisher' ),
						'sw'     => __( 'Swahili', 'publisher' ),
						'sv'     => __( 'Swedish', 'publisher' ),
						'ta'     => __( 'Tamil', 'publisher' ),
						'te'     => __( 'Telugu', 'publisher' ),
						'th'     => __( 'Thai', 'publisher' ),
						'tr'     => __( 'Turkish', 'publisher' ),
						'uk'     => __( 'Ukrainian', 'publisher' ),
						'ur'     => __( 'Urdu', 'publisher' ),
						'vi'     => __( 'Vietnamese', 'publisher' ),
						'zu'     => __( 'Zulu', 'publisher' ),
					),
					'group'       => __( 'Style', 'publisher' ),
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
					'description' => __( 'Select custom icon for widget.', 'publisher' ),
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

} // Publisher_Google_Plus_Shortcode


/**
 * Publisher Google+ Widget
 */
class Publisher_Google_Plus_Widget extends BF_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'bs-google-plus',
			__( 'Publisher - Google+ Badge Box', 'publisher' ),
			array(
				'description' => __( 'Adds a beautiful Google Plus badge widget.', 'publisher' )
			)
		);
	}


	/**
	 * Adds backend fields
	 */
	function load_fields() {

		// Back end form fields
		$this->fields = array(
			array(
				'name'    => __( 'Title:', 'publisher' ),
				'attr_id' => 'title',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Type:', 'publisher' ),
				'attr_id' => 'type',
				'type'    => 'select',
				'options' => array(
					'profile'   => __( 'Profile', 'publisher' ),
					'page'      => __( 'Page', 'publisher' ),
					'community' => __( 'Community', 'publisher' ),
				),
			),
			array(
				'name'    => __( 'Google+ Page URL:', 'publisher' ),
				'attr_id' => 'url',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Width:', 'publisher' ),
				'attr_id' => 'width',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Color Scheme:', 'publisher' ),
				'attr_id' => 'scheme',
				'type'    => 'select',
				'options' => array(
					'light' => __( 'Light', 'publisher' ),
					'dark'  => __( 'Dark', 'publisher' ),
				),
			),
			array(
				'name'    => __( 'Layout:', 'publisher' ),
				'attr_id' => 'layout',
				'type'    => 'select',
				'options' => array(
					'portrait'  => __( 'Portrait', 'publisher' ),
					'landscape' => __( 'Landscape', 'publisher' ),
				),
			),
			array(
				'name'    => __( 'Cover:', 'publisher' ),
				'attr_id' => 'cover',
				'type'    => 'select',
				'options' => array(
					'show' => __( 'Show', 'publisher' ),
					'hide' => __( 'Hide', 'publisher' ),
				),
			),
			array(
				'name'    => __( 'Tagline:', 'publisher' ),
				'attr_id' => 'tagline',
				'type'    => 'select',
				'options' => array(
					'show' => __( 'Show', 'publisher' ),
					'hide' => __( 'Hide', 'publisher' ),
				),
			),
			array(
				'name'    => __( 'Language:', 'publisher' ),
				'attr_id' => 'lang',
				'type'    => 'select',
				'options' => array(
					'af'     => __( 'Afrikaans', 'publisher' ),
					'am'     => __( 'Amharic', 'publisher' ),
					'ar'     => __( 'Arabic', 'publisher' ),
					'eu'     => __( 'Basque', 'publisher' ),
					'bn'     => __( 'Bengali', 'publisher' ),
					'bg'     => __( 'Bulgarian', 'publisher' ),
					'ca'     => __( 'Catalan', 'publisher' ),
					'zh-HK'  => __( 'Chinese (Hong Kong)', 'publisher' ),
					'zh-CN'  => __( 'Chinese (Simplified)', 'publisher' ),
					'zh-TW'  => __( 'Chinese (Traditional)', 'publisher' ),
					'hr'     => __( 'Croatian', 'publisher' ),
					'cs'     => __( 'Czech', 'publisher' ),
					'da'     => __( 'Danish', 'publisher' ),
					'nl'     => __( 'Dutch', 'publisher' ),
					'en-GB'  => __( 'English (UK)', 'publisher' ),
					'en-US'  => __( 'English (US)', 'publisher' ),
					'et'     => __( 'Estonian', 'publisher' ),
					'fil'    => __( 'Filipino', 'publisher' ),
					'fi'     => __( 'Finnish', 'publisher' ),
					'fr'     => __( 'French', 'publisher' ),
					'fr-CA'  => __( 'French (Canadian)', 'publisher' ),
					'gl'     => __( 'Galician', 'publisher' ),
					'de'     => __( 'German', 'publisher' ),
					'el'     => __( 'Greek', 'publisher' ),
					'gu'     => __( 'Gujarati', 'publisher' ),
					'iw'     => __( 'Hebrew', 'publisher' ),
					'hi'     => __( 'Hindi', 'publisher' ),
					'hu'     => __( 'Hungarian', 'publisher' ),
					'is'     => __( 'Icelandic', 'publisher' ),
					'id'     => __( 'Indonesian', 'publisher' ),
					'it'     => __( 'Italian', 'publisher' ),
					'ja'     => __( 'Japanese', 'publisher' ),
					'kn'     => __( 'Kannada', 'publisher' ),
					'ko'     => __( 'Korean', 'publisher' ),
					'lv'     => __( 'Latvian', 'publisher' ),
					'lt'     => __( 'Lithuanian', 'publisher' ),
					'ms'     => __( 'Malay', 'publisher' ),
					'ml'     => __( 'Malayalam', 'publisher' ),
					'mr'     => __( 'Marathi', 'publisher' ),
					'no'     => __( 'Norwegian', 'publisher' ),
					'fa'     => __( 'Persian', 'publisher' ),
					'pl'     => __( 'Polish', 'publisher' ),
					'pt-BR'  => __( 'Portuguese (Brazil)', 'publisher' ),
					'pt-PT'  => __( 'Portuguese (Portugal)', 'publisher' ),
					'ro'     => __( 'Romanian', 'publisher' ),
					'ru'     => __( 'Russian', 'publisher' ),
					'sr'     => __( 'Serbian', 'publisher' ),
					'sk'     => __( 'Slovak', 'publisher' ),
					'sl'     => __( 'Slovenian', 'publisher' ),
					'es'     => __( 'Spanish', 'publisher' ),
					'es-419' => __( 'Spanish (Latin America)', 'publisher' ),
					'sw'     => __( 'Swahili', 'publisher' ),
					'sv'     => __( 'Swedish', 'publisher' ),
					'ta'     => __( 'Tamil', 'publisher' ),
					'te'     => __( 'Telugu', 'publisher' ),
					'th'     => __( 'Thai', 'publisher' ),
					'tr'     => __( 'Turkish', 'publisher' ),
					'uk'     => __( 'Ukrainian', 'publisher' ),
					'ur'     => __( 'Urdu', 'publisher' ),
					'vi'     => __( 'Vietnamese', 'publisher' ),
					'zu'     => __( 'Zulu', 'publisher' ),
				),
			),
		);
	}
}