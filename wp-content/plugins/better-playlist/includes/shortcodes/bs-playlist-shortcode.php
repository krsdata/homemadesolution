<?php

/**
 * Class BS_PlayList_Shortcode
 */
abstract class BS_PlayList_Shortcode extends BF_Shortcode {

	/**
	 * BroadCast Service Instance
	 *
	 * @return BS_PlayList_Service_Interface instance
	 */
	abstract protected function get_service();


	/**
	 * Default attributes that can be changed in class childs
	 *
	 * @var array
	 */
	protected $default_atts = array(
		'show_title'          => 0,
		'type'                => 'playlist',
		'videos_limit'        => 50,
		'playlist_title'      => FALSE,
		'show_playlist_title' => TRUE,
		'videos'              => '',
		'style'               => 'style-1',
		'by'                  => '',
	);


	/**
	 * Initialize shortcode
	 *
	 * @param string $id
	 * @param array  $options
	 */
	function __construct( $id, $options = array() ) {

		// default translated title
		if ( empty( $this->default_atts['title'] ) ) {
			$this->default_atts['title'] = Better_Playlist::_get( 'widget_playlist' );
		}

		$_options = array(
			'defaults'       => $this->default_atts,
			'have_widget'    => TRUE,
			'have_vc_add_on' => TRUE,
		);

		$_options = wp_parse_args( $_options, $options );

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

		$this->sanitize_atts( $atts );

		//set service object
		$atts['playlist_service'] = $this->get_service();

		if ( ! isset( $atts['class'] ) ) {
			$atts['class'] = '';
		}
		$atts['class'] .= $this->extra_classes( $atts );

		ob_start();

		bsp_set_prop( 'shortcode-bs-playlist-atts', $atts );

		include $this->get_template( $atts );

		bsp_clear_prop();

		return ob_get_clean();

	}


	/**
	 * Prepares custom classes for plylist container
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	protected function extra_classes( &$atts ) {

		$classes = array();

		$classes[] = $this->id;

		$classes[] = 'bsp-' . $atts['style'];

		if ( ! empty( $atts['playlist_service'] ) && is_object( $atts['playlist_service'] ) ) {
			$classes[] = str_replace( '_', '-', strtolower( get_class( ( $atts['playlist_service'] ) ) ) );
		}

		$classes = array_map( 'sanitize_html_class', $classes );

		return implode( ' ', $classes );
	}


	/**
	 * Sanitize attributes
	 *
	 * @param $atts
	 */
	protected function sanitize_atts( &$atts ) {

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		$labels = array(
			'type'           => __( 'Playlist Type', 'better-studio' ),
			'type=playlist'  => __( 'Youtube Playlist', 'better-studio' ),
			'type=custom'    => __( 'Custom Video Links', 'better-studio' ),
			'playlist_title' => __( 'Playlist Title', 'better-studio' ),
			'playlist_url'   => __( 'Playlist URL', 'better-studio' ),
			'videos_limit'   => __( 'Maximum Videos Count', 'better-studio' ),
			'videos'         => __( 'Playlist Videos List', 'better-studio' ),
			'by'             => __( 'By', 'better-studio' ),
		);

		$labels = wp_parse_args( $this->get_labels(), $labels );

		vc_map( array(
			"name"        => $this->name,
			"base"        => $this->id,
			"description" => $this->description,
			"weight"      => 1,

			"wrapper_height" => 'full',

			"category" => __( 'Publisher', 'better-studio' ),

			"params" => array(

				array(
					"type"        => 'bf_select',
					"heading"     => $labels['type'],
					"param_name"  => 'type',
					"admin_label" => FALSE,
					'value'       => $this->defaults['type'],
					"options"     => array(
						'playlist' => $labels['type=playlist'],
						'custom'   => $labels['type=custom'],
					),
					'group'       => __( 'Videos', 'better-studio' ),
					'always_show' => TRUE
				),
				array(
					"type"        => 'textfield',
					"admin_label" => TRUE,
					"heading"     => $labels['playlist_url'],
					"param_name"  => 'playlist_url',
					'group'       => __( 'Videos', 'better-studio' ),
					'show_on'     => array( 'type=playlist' )
				),
				array(
					"type"        => 'textarea_raw_html',
					"admin_label" => FALSE,
					"heading"     => $labels['videos'],
					"value"       => $this->defaults['videos'],
					"param_name"  => 'videos',
					'group'       => __( 'Videos', 'better-studio' ),
					'description' => __( 'Enter videos links each in one line.', 'better-studio' ),
					'show_on'     => array( 'type=custom' )
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => $labels['videos_limit'],
					"param_name"  => 'videos_limit',
					"value"       => $this->defaults['videos_limit'],
					'group'       => __( 'Videos', 'better-studio' ),
					'show_on'     => array( 'type=playlist' )
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => $labels['by'],
					"value"       => $this->defaults['by'],
					"param_name"  => 'by',
					'group'       => __( 'Videos', 'better-studio' ),
					'description' => __( 'Enter your name.', 'better-studio' ),
					'show_on'     => array( 'type=custom' )
				),
				array(
					"type"        => 'textfield',
					"admin_label" => TRUE,
					"heading"     => $labels['playlist_title'],
					"param_name"  => 'playlist_title',
					'group'       => __( 'Videos', 'better-studio' ),
				),
				array(
					"type"       => 'bf_switchery',
					"heading"    => __( 'Show Playlist Title?', 'better-studio' ),
					"param_name" => 'show_playlist_title',
					"value"      => $this->defaults['show_playlist_title'],
					'group'      => __( 'Videos', 'better-studio' ),
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Section Title', 'better-studio' ),
					"param_name"  => 'title',
					"value"       => $this->defaults['title'],
					'group'       => __( 'Heading', 'better-studio' ),
				),
				array(
					"type"       => 'bf_switchery',
					"heading"    => __( 'Show Title?', 'better-studio' ),
					"param_name" => 'show_title',
					"value"      => $this->defaults['show_title'],
					'group'      => __( 'Heading', 'better-studio' ),
				),
				array(
					'type'       => 'css_editor',
					'heading'    => __( 'CSS box', 'better-studio' ),
					'param_name' => 'css',
					'group'      => __( 'Design options', 'better-studio' ),
				),
			)
		) );
	}


	/**
	 * method for override labels array indexes
	 *
	 * @return array
	 */
	function get_labels() {
		return array();
	}


	/**
	 * Finds appropriate template file and return path
	 * This make option to change template in themes
	 *
	 * @return string
	 */
	function get_template( $atts ) {

		// Use theme specified template for shortcode
		if ( file_exists( get_template_directory() . '/better-playlist/bs-playlist-' . $atts['style'] . '.php' ) ) {
			return get_template_directory() . '/better-playlist/bs-playlist-' . $atts['style'] . '.php';
		}

		return Better_Playlist::dir_path() . 'views/bs-playlist-' . $atts['style'] . '.php';

	} // get_template

} // BS_PlayList_Shortcode
