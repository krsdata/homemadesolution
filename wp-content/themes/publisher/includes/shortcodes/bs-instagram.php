<?php
/**
 * bs-instagram.php
 *---------------------------
 * [bs-instagram] shortcode & widget
 *
 */

/**
 * Publisher Instagram Shortcode
 */
class Publisher_Instagram_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-instagram';

		$_options = array(
			'defaults'       => array(
				'title'           => publisher_translation_get( 'widget_instagram' ),
				'show_title'      => 1,
				'icon'            => '',
				'user_id'         => '',
				'photo_count'     => '',
				'style'           => '3-1',
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

		publisher_set_prop( 'shortcode-bs-instagram-atts', $atts );

		publisher_get_view( 'shortcodes', 'bs-instagram' );

		publisher_clear_props();

		return ob_get_clean();

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map( array(
			"name"           => __( 'Instagram Photos', 'publisher' ),
			"base"           => $this->id,
			"weight"         => 10,
			"wrapper_height" => 'full',

			"category" => __( 'Publisher', 'publisher' ),
			"params"   => array(
				array(
					"type"        => 'textfield',
					"admin_label" => TRUE,
					"heading"     => __( 'Instagram Username', 'publisher' ),
					"param_name"  => 'user_id',
					"value"       => $this->defaults['user_id'],
					'group'       => __( 'Instagram', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Number of Shots', 'publisher' ),
					"param_name"  => 'photo_count',
					"value"       => $this->defaults['photo_count'],
					'group'       => __( 'Instagram', 'publisher' ),
				),
				array(
					'type'        => 'bf_select',
					'heading'     => __( 'Columns', 'publisher' ),
					'param_name'  => 'style',
					"admin_label" => FALSE,
					"value"       => $this->defaults['style'],
					"options"     => array(
						'2'      => __( '2 Column', 'publisher' ),
						'2-1'    => __( '2 Column - First Big + Small thumbnails [Small sidebar]', 'publisher' ),
						'3'      => __( '3 Column', 'publisher' ),
						'3-1'    => __( '3 Column - First Big + Small thumbnails', 'publisher' ),
						'slider' => __( 'Slider', 'publisher' ),
					),
					'group'       => __( 'Instagram', 'publisher' ),
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
					'heading'     => __( 'Custom Heading Icon (Optional)', 'publisher' ),
					'param_name'  => 'icon',
					'admin_label' => FALSE,
					'value'       => $this->defaults['icon'],
					'description' => __( 'Select custom icon for listing.', 'publisher' ),
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

} // Publisher_Instagram_Shortcode


if ( ! function_exists( 'publisher_shortcode_instagram_get_data' ) ) {
	/**
	 * Wrapper ro getting Instagram data with cache mechanism
	 *
	 * @param $atts
	 *
	 * @return array|bool|mixed|void
	 */
	function publisher_shortcode_instagram_get_data( $atts ) {

		// version number will be added to replace cache in each theme update
		// to prevent bugs from changing data from last version
		$theme_version = str_replace(
			array(
				'.',
				' '
			),
			'-',
			Better_Framework()->theme()->get( 'Version' )
		);

		// count will be added to prevent deference counts problem in widgets for same username
		$data_store = 'bs-insta-' . $atts['photo_count'] . '-' . $theme_version . '-' . $atts['user_id'];
		$back_store = 'bs-insta-bk-' . $atts['photo_count'] . '-' . $theme_version . '-' . $atts['user_id'];
		$cache_time = HOUR_IN_SECONDS * 6;

		if ( ( $images_list = get_transient( $data_store ) ) === FALSE ) {

			$images_list = publisher_shortcode_instagram_fetch_data( $atts );

			if ( is_wp_error( $images_list ) && is_user_logged_in() ) {
				return $images_list;
			} elseif ( ! is_wp_error( $images_list ) ) {

				// Save a transient to expire in $cache_time and a permanent backup option ( fallback )
				set_transient( $data_store, $images_list, $cache_time );
				update_option( $back_store, $images_list, 'no' );

			} // Fall to permanent backup store
			else {
				$images_list = get_option( $back_store );
			}
		}

		return $images_list;
	} // publisher_shortcode_instagram_get_data
} // if


if ( ! function_exists( 'publisher_shortcode_instagram_fetch_data' ) ) {
	/**
	 * Retrieve Instagram fresh data
	 * covered as function to support shortcode $atts
	 *
	 * output[]
	 *      [
	 *          'description',
	 *          'link'',
	 *          'time',
	 *          'comments',
	 *          'comments',
	 *          'likes',
	 *          'type',
	 *          'images'[]
	 *              [
	 *                  'thumbnail',
	 *                  'small',
	 *                  'large',
	 *                  'original',
	 *              ],
	 *      ]
	 *
	 * @param $atts
	 *
	 * @return array|bool
	 */
	function publisher_shortcode_instagram_fetch_data( $atts ) {

		if ( ! class_exists( 'Publisher_Instagram_Client_v1' ) ) {
			require_once bf_get_theme_dir( 'includes/libs/bs-theme-api/class-publisher-instagram-api.php' );
		}

		// Get images
		try {
			$client = new Publisher_Instagram_Scraper_Client_v1();

			// scrape user images
			$images_list = $client->scrape_user( $atts['user_id'], $atts['photo_count'] );
		} catch( Exception $e ) {
			return array();
		}

		return $images_list;

	} // publisher_shortcode_instagram_fetch_data
} // if


/**
 * Publisher Instagram Widget
 */
class Publisher_Instagram_Widget extends BF_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'bs-instagram',
			__( 'Publisher - Instagram', 'publisher' ),
			array(
				'description' => __( 'Display latest photos from Instagram.', 'publisher' )
			)
		);
	} // __construct


	/**
	 * Adds backend fields
	 */
	function load_fields() {

		$this->fields = array(
			array(
				'name'    => __( 'Title:', 'publisher' ),
				'attr_id' => 'title',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Instagram Username:', 'publisher' ),
				'attr_id' => 'user_id',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Number of Photos:', 'publisher' ),
				'attr_id' => 'photo_count',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Columns', 'publisher' ),
				'attr_id' => 'style',
				'type'    => 'select',
				'options' => array(
					'2'      => __( '2 Column', 'publisher' ),
					'2-1'    => __( '2 Column - First Big + Small thumbnails [Small sidebar]', 'publisher' ),
					'3'      => __( '3 Column', 'publisher' ),
					'3-1'    => __( '3 Column - First Big + Small thumbnails', 'publisher' ),
					'slider' => __( 'Slider', 'publisher' ),
				),
			),
		);
	}
} // Publisher_Instagram_Widget
