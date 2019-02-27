<?php
/**
 * bs-flickr.php
 *---------------------------
 * [bs-flickr] short code & widget
 *
 */

/**
 * Publisher Flickr Shortcode
 */
class Publisher_Flickr_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-flickr';

		$_options = array(
			'defaults'       => array(
				'title'           => publisher_translation_get( 'widget_flickr_photos' ),
				'show_title'      => 1,
				'icon'            => '',
				'user_id'         => '',
				'photo_count'     => 6,
				'style'           => 3,
				'tags'            => '',
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

		publisher_set_prop( 'shortcode-bs-flickr-atts', $atts );

		publisher_get_view( 'shortcodes', 'bs-flickr' );

		publisher_clear_props();

		return ob_get_clean();

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map( array(
			"name"           => __( 'Flickr Photos', 'publisher' ),
			"base"           => $this->id,
			"weight"         => 10,
			"wrapper_height" => 'full',

			"category" => __( 'Publisher', 'publisher' ),
			"params"   => array(
				array(
					"type"        => 'textfield',
					"admin_label" => TRUE,
					"heading"     => __( 'Flicker ID', 'publisher' ),
					"param_name"  => 'user_id',
					"value"       => $this->defaults['user_id'],
					'group'       => __( 'Flickr', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Number of Shots', 'publisher' ),
					"param_name"  => 'photo_count',
					"value"       => $this->defaults['photo_count'],
					'group'       => __( 'Flickr', 'publisher' ),
				),
				array(
					'type'        => 'bf_select',
					'heading'     => __( 'Columns', 'publisher' ),
					'param_name'  => 'style',
					"admin_label" => FALSE,
					"value"       => $this->defaults['style'],
					"options"     => array(
						2        => __( '2 Column', 'publisher' ),
						3        => __( '3 Column', 'publisher' ),
						'slider' => __( 'Slider', 'publisher' ),
					),
					'group'       => __( 'Flickr', 'publisher' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => __( 'Tags (comma separated, optional)', 'publisher' ),
					"admin_label" => FALSE,
					'param_name'  => 'tags',
					"value"       => $this->defaults['tags'],
					'group'       => __( 'Flickr', 'publisher' ),
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

} // Publisher_Flickr_Shortcode


if ( ! function_exists( 'publisher_shortcode_flickr_get_data' ) ) {
	/**
	 * Wrapper ro getting Flickr data with cache mechanism
	 *
	 * @param $atts
	 *
	 * @return array|bool|mixed|void
	 */
	function publisher_shortcode_flickr_get_data( $atts ) {

		$data_store = 'bs-fk-' . $atts['user_id'];
		$back_store = 'bs-fk-bk-' . $atts['user_id'];
		$cache_time = HOUR_IN_SECONDS * 6;

		if ( ( $images_list = get_transient( $data_store ) ) === FALSE ) {

			$images_list = publisher_shortcode_flickr_fetch_data( $atts );

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
	} // publisher_shortcode_flickr_get_data
} // if


if ( ! function_exists( 'publisher_shortcode_flickr_fetch_data' ) ) {
	/**
	 * Retrieve Flickr fresh data
	 *
	 * @param $atts
	 *
	 * @return array|bool
	 */
	function publisher_shortcode_flickr_fetch_data( $atts ) {

		$remote_response = wp_remote_get( 'http://api.flickr.com/services/feeds/photos_public.gne?format=json&id=' . urlencode( $atts['user_id'] ) . '&nojsoncallback=1&tags=' . urlencode( $atts['tags'] ) );

		if ( is_wp_error( $remote_response ) || 200 != wp_remote_retrieve_response_code( $remote_response ) ) {
			return new WP_Error( 'invalid_response', __( 'Flickr did not return a 200.', 'publisher' ) );
		}

		// Fix Flickr JSON escape bug
		$remote_body = wp_remote_retrieve_body( $remote_response );
		$remote_body = str_replace( "\\'", "'", $remote_body );

		$json = json_decode( $remote_body, TRUE );

		if ( ! is_array( $json ) ) {
			return new WP_Error( 'bad_array', __( 'Flickr has returned invalid data.', 'publisher' ) );
		}

		$images_list = $json['items'];

		// Replace medium with small square image
		foreach ( $images_list as $key => $item ) {
			$images_list[ $key ]['media']['xs'] = preg_replace( '/_m\.(jp?g|png|gif)$/', '_s.\\1', $item['media']['m'] );
			$images_list[ $key ]['media']['s']  = preg_replace( '/_m\.(jp?g|png|gif)$/', '_q_d.\\1', $item['media']['m'] );
		}

		return $images_list;
	} // publisher_shortcode_flickr_fetch_data
} // if


/**
 * Publisher Flickr Widget
 */
class Publisher_Flickr_Widget extends BF_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'bs-flickr',
			__( 'Publisher - Flickr', 'publisher' ),
			array(
				'description' => __( 'Display latest photos from Flickr.', 'publisher' )
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
				'name'      => __( 'Instructions', 'publisher' ),
				'attr_id'   => 'help',
				'type'      => 'info',
				'std'       => wp_kses( sprintf( __( '<p>You need to get the user id from your Flickr account.</p>
                <ol>
                    <li>Attain your user id using <a href="%s" target="_blank">this tool</a></li>
                    <li>Copy the user id</li>
                    <li>Paste it in the "Flickr ID" input box below</li>
                </ol>
                ', 'publisher' ), 'http://goo.gl/pHx7LV' ), bf_trans_allowed_html() ),
				'state'     => 'open',
				'info-type' => 'help',
			),
			array(
				'name'    => __( 'Title:', 'publisher' ),
				'attr_id' => 'title',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Flickr ID:', 'publisher' ),
				'attr_id' => 'user_id',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Columns', 'publisher' ),
				'attr_id' => 'style',
				'type'    => 'select',
				'options' => array(
					2        => __( '2 Column', 'publisher' ),
					3        => __( '3 Column', 'publisher' ),
					'slider' => __( 'Slider', 'publisher' ),
				),
			),
			array(
				'name'    => __( 'Number of Photos:', 'publisher' ),
				'attr_id' => 'photo_count',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Tags (comma separated, optional):', 'publisher' ),
				'attr_id' => 'tags',
				'type'    => 'text',
			),
		);

	}
}
