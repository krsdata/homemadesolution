<?php
/**
 * bs-dribbble.php
 *---------------------------
 * [bs-dribbble] shortcode & widget
 *
 */


/**
 * Publisher Dribbble Shortcode
 */
class Publisher_Dribbble_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-dribbble';

		$_options = array(
			'defaults'       => array(
				'title'           => publisher_translation_get( 'widget_dribbble_shots' ),
				'show_title'      => 1,
				'icon'            => '',
				'user_id'         => '',
				'access_token'    => '',
				'photo_count'     => 6,
				'style'           => 3,
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

		publisher_set_prop( 'shortcode-bs-dribbble-atts', $atts );

		publisher_get_view( 'shortcodes', 'bs-dribbble' );

		publisher_clear_props();

		return ob_get_clean();

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map( array(
			"name"           => __( 'Dribbble Shots', 'publisher' ),
			"base"           => $this->id,
			"weight"         => 10,
			"wrapper_height" => 'full',

			"category" => __( 'Publisher', 'publisher' ),
			"params"   => array(
				array(
					"type"        => 'textfield',
					"admin_label" => TRUE,
					"heading"     => __( 'Dribbble ID', 'publisher' ),
					"param_name"  => 'user_id',
					"value"       => $this->defaults['user_id'],
					'group'       => __( 'Dribbble', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Access Token', 'publisher' ),
					"param_name"  => 'access_token',
					"value"       => $this->defaults['access_token'],
					'group'       => __( 'Dribbble', 'publisher' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Number of Shots', 'publisher' ),
					"param_name"  => 'photo_count',
					"value"       => $this->defaults['photo_count'],
					'group'       => __( 'Dribbble', 'publisher' ),
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
					'group'       => __( 'Dribbble', 'publisher' ),
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

	}
}


if ( ! function_exists( 'publisher_shortcode_dribbble_get_data' ) ) {

	/**
	 * Wrapper ro getting Dribbble data with cache mechanism
	 *
	 * @param $atts
	 *
	 * @return array|bool|mixed|void
	 */
	function publisher_shortcode_dribbble_get_data( $atts ) {

		$data_store = 'bs-drb-' . $atts['user_id'];
		$back_store = 'bs-drb-bk-' . $atts['user_id'];

		if ( ( $data = get_transient( $data_store ) ) === FALSE ) {

			$data = publisher_shortcode_dribbble_fetch_data( $atts );

			if ( $data ) {

				$cache_time = HOUR_IN_SECONDS * 6;

				// save a transient to expire in $cache_time and a permanent backup option ( fallback )
				set_transient( $data_store, $data, $cache_time );
				update_option( $back_store, $data, 'no' );

			} // fallback to permanent backup store
			else {
				$data = get_option( $back_store );
			}
		}

		return $data;
	}
}


if ( ! function_exists( 'publisher_shortcode_dribbble_fetch_data' ) ) {
	/**
	 * Retrieve Dribbble fresh data
	 *
	 * @param $atts
	 *
	 * @return array|bool
	 */
	function publisher_shortcode_dribbble_fetch_data( $atts ) {

		if ( ! class_exists( 'Publisher_Dribbble_Client_v1' ) ) {
			require_once bf_get_theme_dir( 'includes/libs/bs-theme-api/class-publisher-dribbble-api.php' );
		}

		$client = new Publisher_Dribbble_Client_v1( $atts['access_token'] );

		try {
			$shots = $client->getUserShots( $atts['user_id'] );
		} catch( Exception $e ) {
			$shots = array();
		}

		return $shots;
	}
}


/**
 * Publisher Dribbble Widget
 */
class Publisher_Dribbble_Widget extends BF_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'bs-dribbble',
			__( 'Publisher - Dribbble', 'publisher' ),
			array(
				'description' => __( 'Display latest shots from Dribbble.', 'publisher' )
			)
		);
	}


	/**
	 * Loads fields
	 */
	function load_fields() {

		// Back end form fields
		$this->fields = array(
			array(
				'name'      => __( 'Instructions', 'publisher' ),
				'attr_id'   => 'help',
				'type'      => 'info',
				'std'       => wp_kses( sprintf( __( '<p>You need to get the access token from your Dribbble account.</p>
                <ol>
                    <li>Go to <a href="%s" target="_blank">Applications</a> page.</li>
                    <li>Click on <strong>Register a new application</strong> button.</li>
                    <li>Fill all fields in next page and click on "<strong>Register application</strong>" button.</li>
                    <li>Copy "<strong>Client Access Token</strong>" in next page and paste in following Access Token field.</li>
                </ol>
                ', 'publisher' ), 'https://goo.gl/Xtidw3' ), bf_trans_allowed_html() ),
				'state'     => 'open',
				'info-type' => 'help',
			),
			array(
				'name'    => __( 'Title', 'publisher' ),
				'attr_id' => 'title',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Dribbble ID', 'publisher' ),
				'attr_id' => 'user_id',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Access Token', 'publisher' ),
				'attr_id' => 'access_token',
				'type'    => 'text',
			),
			array(
				'name'    => __( 'Number of Shots', 'publisher' ),
				'attr_id' => 'photo_count',
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
		);

	}
}
