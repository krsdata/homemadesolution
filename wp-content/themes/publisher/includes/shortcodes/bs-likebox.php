<?php
/**
 * bs-likebox.php
 *---------------------------
 * [bs-likebox] short code & widget
 *
 */

/**
 * Publisher Likebox Shortcode
 */
class Publisher_Likebox_Shortcode extends BF_Shortcode {

	/**
	 * Flag used to determine print Facebook SDK in footer
	 *
	 * @var bool
	 */
	public static $print_footer_sdk = FALSE;


	/**
	 * Flag used to determine print Facebook SDK in footer
	 *
	 * @var bool
	 */
	public static $locale = 'en_US';


	function __construct( $id, $options ) {

		$id = 'bs-likebox';

		$_options = array(
			'defaults'       => array(
				'title'           => '',
				'show_title'      => 0,
				'icon'            => '',
				'url'             => '',
				'show_faces'      => 1,
				'show_posts'      => 0,
				'locale'          => 'en_US',
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

		// Hooked to print Facebook JS SDK
		add_action( 'wp_footer', array( $this, 'wp_footer' ) );

	}


	/**
	 * Callback: used to print Facebook SDK in footer
	 *
	 * Action filter: wp_footer
	 */
	public static function wp_footer() {

		// print footer if needed
		if ( ! self::$print_footer_sdk ) {
			return;
		}


		$locales = publisher_likebox_locales();

		// validate locale
		if ( empty( self::$locale ) || ! isset( $locales[ self::$locale ] ) ) {
			self::$locale = 'en_US';
		}

		?>

		<div id="fb-root"></div>
		<?php

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

		self::$print_footer_sdk = TRUE;

		if ( ! empty( $atts['locale'] ) ) {
			self::$locale = $atts['locale'];
		}

		ob_start();

		publisher_set_prop( 'shortcode-bs-likebox-atts', $atts );

		publisher_get_view( 'shortcodes', 'bs-likebox' );

		publisher_clear_props();

		return ob_get_clean();

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map( array(
			"name"           => __( 'FB Likebox', 'publisher' ),
			"base"           => $this->id,
			"weight"         => 10,
			"wrapper_height" => 'full',

			"category" => __( 'Publisher', 'publisher' ),
			"params"   => array(
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Facebook Page Link', 'publisher' ),
					"param_name"  => 'url',
					"value"       => $this->defaults['url'],
					'group'       => __( 'Facebook', 'publisher' ),
				),
				array(
					"type"        => 'bf_switch',
					"admin_label" => FALSE,
					"heading"     => __( 'Show Posts', 'publisher' ),
					"param_name"  => 'show_posts',
					"value"       => $this->defaults['show_posts'],
					'on-label'    => __( 'Show', 'publisher' ),
					'off-label'   => __( 'Hide', 'publisher' ),
					'group'       => __( 'Facebook', 'publisher' ),
				),
				array(
					"type"        => 'bf_switch',
					"admin_label" => FALSE,
					"heading"     => __( 'Show Faces', 'publisher' ),
					"param_name"  => 'show_faces',
					"value"       => $this->defaults['show_posts'],
					'on-label'    => __( 'Show', 'publisher' ),
					'off-label'   => __( 'Hide', 'publisher' ),
					'group'       => __( 'Facebook', 'publisher' ),
				),
				array(
					"type"             => 'bf_select',
					"heading"          => __( 'Language', 'publisher' ),
					"param_name"       => 'locale',
					"admin_label"      => FALSE,
					"value"            => $this->defaults['locale'],
					'deferred-options' => 'publisher_likebox_locales',
					'group'            => __( 'Facebook', 'publisher' ),
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
					'description' => __( 'Select custom icon for share widget.', 'publisher' ),
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


if ( ! function_exists( 'publisher_likebox_locales' ) ) {
	/**
	 * List of all localizations for Likebox
	 *
	 * @return array
	 */
	function publisher_likebox_locales() {
		return array(
			'en_US' => '-- English (US) -- ',
			'af_ZA' => 'Afrikaans',
			'ak_GH' => 'Akan',
			'am_ET' => 'Amharic',
			'ar_AR' => 'Arabic',
			'as_IN' => 'Assamese',
			'ay_BO' => 'Aymara',
			'az_AZ' => 'Azerbaijani',
			'be_BY' => 'Belarusian',
			'bg_BG' => 'Bulgarian',
			'bn_IN' => 'Bengali',
			'br_FR' => 'Breton',
			'bs_BA' => 'Bosnian',
			'ca_ES' => 'Catalan',
			'cb_IQ' => 'Sorani Kurdish',
			'ck_US' => 'Cherokee',
			'co_FR' => 'Corsican',
			'cs_CZ' => 'Czech',
			'cx_PH' => 'Cebuano',
			'cy_GB' => 'Welsh',
			'da_DK' => 'Danish',
			'de_DE' => 'German',
			'el_GR' => 'Greek',
			'en_GB' => 'English (UK)',
			'en_IN' => 'English (India)',
			'en_PI' => 'English (Pirate)',
			'en_UD' => 'English (Upside Down)',
			'eo_EO' => 'Esperanto',
			'es_CO' => 'Spanish (Colombia)',
			'es_ES' => 'Spanish (Spain)',
			'es_LA' => 'Spanish',
			'et_EE' => 'Estonian',
			'eu_ES' => 'Basque',
			'fa_IR' => 'Persian',
			'fb_LT' => 'Leet Speak',
			'ff_NG' => 'Fulah',
			'fi_FI' => 'Finnish',
			'fo_FO' => 'Faroese',
			'fr_CA' => 'French (Canada)',
			'fr_FR' => 'French (France)',
			'fy_NL' => 'Frisian',
			'ga_IE' => 'Irish',
			'gl_ES' => 'Galician',
			'gn_PY' => 'Guarani',
			'gu_IN' => 'Gujarati',
			'gx_GR' => 'Classical Greek',
			'ha_NG' => 'Hausa',
			'he_IL' => 'Hebrew',
			'hi_IN' => 'Hindi',
			'hr_HR' => 'Croatian',
			'hu_HU' => 'Hungarian',
			'hy_AM' => 'Armenian',
			'id_ID' => 'Indonesian',
			'ig_NG' => 'Igbo',
			'is_IS' => 'Icelandic',
			'it_IT' => 'Italian',
			'ja_JP' => 'Japanese',
			'ja_KS' => 'Japanese (Kansai)',
			'jv_ID' => 'Javanese',
			'ka_GE' => 'Georgian',
			'kk_KZ' => 'Kazakh',
			'km_KH' => 'Khmer',
			'kn_IN' => 'Kannada',
			'ko_KR' => 'Korean',
			'ku_TR' => 'Kurdish (Kurmanji)',
			'la_VA' => 'Latin',
			'lg_UG' => 'Ganda',
			'li_NL' => 'Limburgish',
			'ln_CD' => 'Lingala',
			'lo_LA' => 'Lao',
			'lt_LT' => 'Lithuanian',
			'lv_LV' => 'Latvian',
			'mg_MG' => 'Malagasy',
			'mk_MK' => 'Macedonian',
			'ml_IN' => 'Malayalam',
			'mn_MN' => 'Mongolian',
			'mr_IN' => 'Marathi',
			'ms_MY' => 'Malay',
			'mt_MT' => 'Maltese',
			'my_MM' => 'Burmese',
			'nb_NO' => 'Norwegian (bokmal)',
			'nd_ZW' => 'Ndebele',
			'ne_NP' => 'Nepali',
			'nl_BE' => 'Dutch (België)',
			'nl_NL' => 'Dutch',
			'nn_NO' => 'Norwegian (nynorsk)',
			'ny_MW' => 'Chewa',
			'or_IN' => 'Oriya',
			'pa_IN' => 'Punjabi',
			'pl_PL' => 'Polish',
			'ps_AF' => 'Pashto',
			'pt_BR' => 'Portuguese (Brazil)',
			'pt_PT' => 'Portuguese (Portugal)',
			'qu_PE' => 'Quechua',
			'rm_CH' => 'Romansh',
			'ro_RO' => 'Romanian',
			'ru_RU' => 'Russian',
			'rw_RW' => 'Kinyarwanda',
			'sa_IN' => 'Sanskrit',
			'sc_IT' => 'Sardinian',
			'se_NO' => 'Northern Sámi',
			'si_LK' => 'Sinhala',
			'sk_SK' => 'Slovak',
			'sl_SI' => 'Slovenian',
			'sn_ZW' => 'Shona',
			'so_SO' => 'Somali',
			'sq_AL' => 'Albanian',
			'sr_RS' => 'Serbian',
			'sv_SE' => 'Swedish',
			'sw_KE' => 'Swahili',
			'sy_SY' => 'Syriac',
			'sz_PL' => 'Silesian',
			'ta_IN' => 'Tamil',
			'te_IN' => 'Telugu',
			'tg_TJ' => 'Tajik',
			'th_TH' => 'Thai',
			'tk_TM' => 'Turkmen',
			'tl_PH' => 'Filipino',
			'tl_ST' => 'Klingon',
			'tr_TR' => 'Turkish',
			'tt_RU' => 'Tatar',
			'tz_MA' => 'Tamazight',
			'uk_UA' => 'Ukrainian',
			'ur_PK' => 'Urdu',
			'uz_UZ' => 'Uzbek',
			'vi_VN' => 'Vietnamese',
			'wo_SN' => 'Wolof',
			'xh_ZA' => 'Xhosa',
			'yi_DE' => 'Yiddish',
			'yo_NG' => 'Yoruba',
			'zh_CN' => 'Simplified Chinese (China)',
			'zh_HK' => 'Traditional Chinese (Hong Kong)',
			'zh_TW' => 'Traditional Chinese (Taiwan)',
			'zu_ZA' => 'Zulu',
			'zz_TR' => 'Zazaki',
		);
	}
}


/**
 * Publisher Likebox Widget
 */
class Publisher_Likebox_Widget extends BF_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'bs-likebox',
			__( 'Publisher - Like Box', 'publisher' ),
			array(
				'description' => __( 'Display a Facebook Like Box', 'publisher' )
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
				'name'    => __( 'Title (Optional)', 'publisher' ),
				'attr_id' => 'title',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Facebook Page Link', 'publisher' ),
				'attr_id' => 'url',
				'desc'    => __( 'EG. http://www.facebook.com/envato', 'publisher' ),
				'type'    => 'text',
			),
			array(
				'name'      => __( 'Show Posts', 'publisher' ),
				'attr_id'   => 'show_posts',
				'id'        => 'show_posts',
				'type'      => 'switch',
				'on-label'  => __( 'Show', 'publisher' ),
				'off-label' => __( 'Hide', 'publisher' ),
			),
			array(
				'name'      => __( 'Show Faces', 'publisher' ),
				'attr_id'   => 'show_faces',
				'id'        => 'show_faces',
				'type'      => 'switch',
				'on-label'  => __( 'Show', 'publisher' ),
				'off-label' => __( 'Hide', 'publisher' ),
			),
			array(
				'name'             => __( 'Language', 'publisher' ),
				'attr_id'          => 'locale',
				'id'               => 'locale',
				'type'             => 'select',
				'deferred-options' => 'publisher_likebox_locales',
			),
		);
	}
}
