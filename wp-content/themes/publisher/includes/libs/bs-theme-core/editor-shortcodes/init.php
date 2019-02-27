<?php
/***
 *  BetterStudio Themes Core.
 *
 *  ______  _____   _____ _                           _____
 *  | ___ \/  ___| |_   _| |                         /  __ \
 *  | |_/ /\ `--.    | | | |__   ___ _ __ ___   ___  | /  \/ ___  _ __ ___
 *  | ___ \ `--. \   | | | '_ \ / _ \ '_ ` _ \ / _ \ | |    / _ \| '__/ _ \
 *  | |_/ //\__/ /   | | | | | |  __/ | | | | |  __/ | \__/\ (_) | | |  __/
 *  \____/ \____/    \_/ |_| |_|\___|_| |_| |_|\___|  \____/\___/|_|  \___|
 *
 *  Copyright © 2017 Better Studio
 *
 *
 *  Our portfolio is here: http://themeforest.net/user/Better-Studio/portfolio
 *
 *  \--> BetterStudio, 2017 <--/
 */


Publisher_Theme_Editor_Shortcodes::Run();

class Publisher_Theme_Editor_Shortcodes {


	/**
	 * Version of library
	 *
	 * @var string
	 */
	public $version = '1.0.1';


	/**
	 * Contains configuration's of theme shortcodes
	 *
	 * @var array
	 */
	public static $config = array();


	/**
	 * Contains alive instance of class
	 *
	 * @var  self
	 */
	protected static $instance;


	/**
	 * Publisher_Editor_Shortcodes_TinyMCE instance
	 *
	 * @var Publisher_Editor_Shortcodes_TinyMCE
	 */
	protected static $editor_instance;


	/**
	 * All registered shortcodes
	 *
	 * @var array
	 */
	private static $shortcodes = array();


	/**
	 * [ create and ] Returns life version
	 *
	 * @return \Publisher_Theme_Editor_Shortcodes
	 */
	public static function Run() {
		if ( ! self::$instance instanceof self ) {
			self::$instance = new self();
			self::$instance->init();
		}

		return self::$instance;
	}


	/**
	 * Handy function used to get custom value from config
	 *
	 * @param        $id
	 * @param string $default
	 *
	 * @return string
	 */
	public static function get_config( $id = NULL, $default = '' ) {

		if ( is_null( $id ) ) {
			return $default;
		}

		/**
		 * Calculates numbers of 2 column layout
		 */
		if ( $id === 'layout-2-col' ) {

			if ( ! isset( self::$config[ $id ] ) ) {
				return self::$config[ $id ] = array(
					'width'      => 1180,
					'content'    => 790.6,
					'primary'    => 389.4,
					'calculated' => TRUE,
				);
			}

			if ( isset( self::$config[ $id ]['calculated'] ) ) {
				return self::$config[ $id ];
			}

			self::$config[ $id ]['content'] = ( self::$config[ $id ]['content'] * 0.01 ) * self::$config[ $id ]['width'];
			self::$config[ $id ]['primary'] = ( self::$config[ $id ]['primary'] * 0.01 ) * self::$config[ $id ]['width'];

			self::$config[ $id ]['calculated'] = TRUE;

			return self::$config[ $id ];
		}


		/**
		 * Calculates numbers of 3 column layout
		 */
		if ( $id === 'layout-3-col' ) {

			if ( ! isset( self::$config[ $id ] ) ) {
				return self::$config[ $id ] = array(
					'width'      => 1300,
					'content'    => 754,
					'primary'    => 325,
					'secondary'  => 221,
					'calculated' => TRUE,
				);
			}

			if ( isset( self::$config[ $id ]['calculated'] ) ) {
				return self::$config[ $id ];
			}

			self::$config[ $id ]['content']   = ( self::$config[ $id ]['content'] * 0.01 ) * self::$config[ $id ]['width'];
			self::$config[ $id ]['primary']   = ( self::$config[ $id ]['primary'] * 0.01 ) * self::$config[ $id ]['width'];
			self::$config[ $id ]['secondary'] = ( self::$config[ $id ]['secondary'] * 0.01 ) * self::$config[ $id ]['width'];

			self::$config[ $id ]['calculated'] = TRUE;

			return self::$config[ $id ];
		}

		return isset( self::$config[ $id ] ) ? self::$config[ $id ] : $default;
	}


	/**
	 * @return array
	 */
	public static function get_shortcodes() {
		return self::$shortcodes;
	}


	/**
	 * @param array $shortcodes
	 */
	public static function set_shortcodes( $shortcodes ) {
		self::$shortcodes = $shortcodes;
	}


	/**
	 * Get library url
	 *
	 * @param string $append optional.
	 *
	 * @return string
	 */
	public static function url( $append = '' ) {
		return trailingslashit( self::$config['url'] ) . ltrim( $append, '/' );
	}


	/**
	 * Get library path
	 *
	 * @param string $append optional.
	 *
	 * @return string
	 */
	public static function path( $append = '' ) {
		return trailingslashit( self::$config['path'] ) . ltrim( $append, '/' );
	}


	/**
	 * Register Hooks
	 */
	public function init() {
		add_action( 'better-framework/after_setup', array( $this, 'setup_shortcodes' ) );
	}


	/**
	 * Print dynamic editor css
	 */
	public function load_editor_css() {

		if ( isset( $_GET['publisher-theme-editor-shortcodes'] ) && intval( $_GET['publisher-theme-editor-shortcodes'] ) > 0 ) {

			@header( 'Content-Type: text/css; charset=UTF-8' );

			if ( ! empty( self::$config['editor-style'] ) ) {
				@include self::$config['editor-style'];
			} else {
				include self::path( '/assets/css/editor-style.php' );
			}

			// Injects dynamics generated CSS codes from PHP files outside of library
			if ( ! empty( self::$config['editor-dynamic-style'] ) ) {

				if ( is_array( self::$config['editor-dynamic-style'] ) ) {

					foreach ( self::$config['editor-dynamic-style'] as $_file ) {
						@include $_file;
					}

				} else {
					@include self::$config['editor-dynamic-style'];
				}
			}

			exit;
		}

	}


	/**
	 * Adds custom dynamic editor css
	 *
	 * @param  array $stylesheets list of stylesheets uri
	 *
	 * @return array
	 */
	public function prepare_editor_style_uri( $stylesheets ) {

		// Add dynamic css file
		$stylesheets[] = home_url( '?publisher-theme-editor-shortcodes=' . bf_get_admin_current_post_id() );

		// Enqueue font awesome library from better framework
		if ( function_exists( "Better_Framework" ) ) {
			$stylesheets[] = BF_URI . 'assets/css/font-awesome.min.css';
		}

		return $stylesheets;

	}


	/**
	 * Add custom editor script
	 */
	public function append_editor_script() {
		wp_enqueue_script( 'publisher-theme-editor-script', $this->url( 'assets/js/edit-post-script.js' ), '', $this->version );
	}


	/**
	 * Used for retrieving instance
	 *
	 * @param $fresh
	 *
	 * @return mixed
	 */
	public static function editor_instance( $fresh = FALSE ) {

		if ( self::$editor_instance != NULL && ! $fresh ) {
			return self::$editor_instance;
		}

		if ( ! class_exists( 'Publisher_Editor_Shortcodes_TinyMCE' ) ) {
			require_once self::path( 'includes/class-publisher-editor-shortcodes-tinymce.php' );
		}

		return self::$editor_instance = new Publisher_Editor_Shortcodes_TinyMCE();
	}


	/**
	 *
	 */
	public function setup_shortcodes() {

		/**
		 * Retrieves configurations
		 *
		 * @since 1.0.0
		 *
		 * @param string $args reset panel data
		 */
		self::$config = apply_filters( 'publisher-theme-core/editor-shortcodes/config', self::$config );

		self::$config['path'] = Publisher_Theme_Core()->get_dir_path( 'editor-shortcodes/' );
		self::$config['url']  = Publisher_Theme_Core()->get_dir_url( 'editor-shortcodes/' );

		// injects all our custom styles to TinyMCE
		add_filter( 'editor_stylesheets', array( $this, 'prepare_editor_style_uri' ), 100 );

		// Prints dynamic custom css if needed
		add_action( 'template_redirect', array( $this, 'load_editor_css' ), 1 );
		add_action( 'admin_init', array( $this, 'load_editor_css' ), 1 );

		$this->load_all_shortcodes();

		// registers shortcodes
		add_action( 'init', array( $this, 'register_all_shortcodes' ), 50 );

		global $pagenow;
		// Initiate custom shortcodes only in post edit editor
		if ( is_admin() && ( bf_is_doing_ajax() || in_array( $pagenow, array( 'post-new.php', 'post.php' ) ) ) ) {
			add_action( 'load-post.php', array( $this, 'append_editor_script' ) );
			add_action( 'load-post-new.php', array( $this, 'append_editor_script' ) );

			self::editor_instance();
		}
	}


	/**
	 * Loads all active shortcodes
	 *
	 * TODO Add popup box
	 * TODO Add icons
	 */
	public function load_all_shortcodes() {

		self::set_shortcodes( apply_filters( 'publisher-theme-core/editor-shortcodes/shortcodes-array',
				array(
					'pullquote' => array(
						'type'      => 'button',
						'label'     => __( 'Pull Quote', 'publisher' ),
						'callback'  => 'pull_quote',
						'formatter' => 'blockquote'
					),
					'pullquote' => array(
						'type'  => 'menu',
						'label' => __( 'Pull Quote', 'publisher' ),
						'items' => array(

							'pullquote-left'  => array(
								'type'      => 'button',
								'label'     => ! is_rtl() ? __( 'Pull Quote - Left', 'publisher' ) : __( 'Pull Quote - Right', 'publisher' ),
								'formatter' => 'BS_pullquote_Left'
							),
							'pullquote-right' => array(
								'register'  => FALSE,
								'type'      => 'button',
								'label'     => ! is_rtl() ? __( 'Pull Quote - Right', 'publisher' ) : __( 'Pull Quote - Left', 'publisher' ),
								'formatter' => 'BS_pullquote_Right'
							),
						)
					),

					'text-padding' => array(
						'type'  => 'menu',
						'label' => __( 'Text Paddings', 'publisher' ),
						'items' => array(

							'text-padding-right-1' => array(
								'type'              => 'button',
								'label'             => __( 'Text ⇠', 'publisher' ),
								'onclick_raw_js'    => '
								toggleClass("bs-padding-0-1",textPaddingPattern);
							',
								'active_conditions' => array(
									'classes' => 'bs-padding-0-1'
								)
							),

							'text-padding-left-1'  => array(
								'type'              => 'button',
								'label'             => __( '⇢ Text', 'publisher' ),
								'onclick_raw_js'    => '
								toggleClass("bs-padding-1-0",textPaddingPattern);
							',
								'active_conditions' => array(
									'classes' => 'bs-padding-1-0'
								)
							),
							'text-padding-1'       => array(
								'type'           => 'button',
								'label'          => __( '⇢ Text ⇠', 'publisher' ),
								'onclick_raw_js' => '
							toggleClass("bs-padding-1-1",textPaddingPattern);
							',

								'active_conditions' => array(
									'classes' => 'bs-padding-1-1'
								)
							),
							'text-padding-right-2' => array(
								'type'              => 'button',
								'label'             => __( '⇢ Text ⇠⇠', 'publisher' ),
								'onclick_raw_js'    => '
								toggleClass("bs-padding-1-2",textPaddingPattern);
							',
								'active_conditions' => array(
									'classes' => 'bs-padding-1-2'
								)
							),

							'text-padding-left-2' => array(
								'type'              => 'button',
								'label'             => __( '⇢⇢ Text ⇠', 'publisher' ),
								'onclick_raw_js'    => '
							toggleClass("bs-padding-2-1",textPaddingPattern);
							',
								'active_conditions' => array(
									'classes' => 'bs-padding-2-1'
								)
							),
							'text-padding-2'      => array(
								'type'              => 'button',
								'label'             => __( '⇢⇢ Text ⇠⇠', 'publisher' ),
								'onclick_raw_js'    => '
							toggleClass("bs-padding-2-2",textPaddingPattern);
							',
								'active_conditions' => array(
									'classes' => 'bs-padding-2-2'
								)
							),
							'text-padding-3'      => array(
								'type'              => 'button',
								'label'             => __( '⇢⇢⇢ Text ⇠⇠⇠', 'publisher' ),
								'onclick_raw_js'    => '
							toggleClass("bs-padding-3-3",textPaddingPattern);
							',
								'active_conditions' => array(
									'classes' => 'bs-padding-3-3'
								)
							),
						)
					),

					'dropcap' => array(
						'type'  => 'menu',
						'label' => __( 'Dropcap', 'publisher' ),
						'items' => array(

							'dropcap'                => array(
								'type'              => 'button',
								'label'             => __( 'Dropcap - Simple', 'publisher' ),
								'formatter'         => 'BS_Dropcap_Simple',
								'active_conditions' => array(
									'classes' => 'dropcap dropcap-simple'
								)
							),
							'dropcap-square'         => array(
								'register'          => FALSE,
								'type'              => 'button',
								'label'             => __( 'Dropcap - Square', 'publisher' ),
								'formatter'         => 'BS_Dropcap_Square',
								'active_conditions' => array(
									'classes' => 'dropcap dropcap-square'
								)
							),
							'dropcap-square-outline' => array(
								'register'          => FALSE,
								'type'              => 'button',
								'label'             => __( 'Dropcap - Square Outline', 'publisher' ),
								'formatter'         => 'BS_Dropcap_Square_Outline',
								'active_conditions' => array(
									'classes' => 'dropcap dropcap-square-outline'
								)
							),
							'dropcap-circle'         => array(
								'register'          => FALSE,
								'type'              => 'button',
								'label'             => __( 'Dropcap - Circle', 'publisher' ),
								'formatter'         => 'BS_Dropcap_circle',
								'active_conditions' => array(
									'classes' => 'dropcap dropcap-circle'
								)
							),
							'dropcap-circle-outline' => array(
								'register'          => FALSE,
								'type'              => 'button',
								'label'             => __( 'Dropcap - Circle Outline', 'publisher' ),
								'formatter'         => 'BS_Dropcap_Circle_Outline',
								'active_conditions' => array(
									'classes' => 'dropcap dropcap-circle-outline'
								)
							),
						)
					),

					'intro' => array(
						'type'  => 'menu',
						'label' => __( 'Intro', 'publisher' ),
						'items' => array(

							'bs-intro'             => array(
								'type'              => 'button',
								'label'             => __( 'Intro', 'publisher' ),
								'onclick_raw_js'    => '
								toggleClass("bs-intro",introClassPattern);
							',
								'active_conditions' => array(
									'classes' => 'bs-intro'
								)
							),
							'bs-intro-highlighted' => array(
								'type'              => 'button',
								'label'             => __( 'Highlighted Intro', 'publisher' ),
								'onclick_raw_js'    => '
								toggleClass("bs-intro-highlighted",introClassPattern);
							',
								'active_conditions' => array(
									'classes' => 'bs-intro-highlighted'
								)
							),
						)
					),

					'highlight' => array(
						'type'  => 'menu',
						'label' => __( 'Highlighted Text', 'publisher' ),
						'items' => array(

							'highlight' => array(
								'type'      => 'button',
								'label'     => __( 'Highlight Yellow', 'publisher' ),
								'formatter' => 'BS_Highlight',
							),

							'highlight-red' => array(
								'register'  => FALSE,
								'type'      => 'button',
								'label'     => __( 'Highlight Red', 'publisher' ),
								'formatter' => 'BS_Highlight_Red',
							),

						)
					),

					'columns' => array(
						'type'  => 'menu',
						'label' => __( 'Columns', 'publisher' ),
						'items' => array(
							'columns' => array(
								'type'     => 'button',
								'label'    => __( '2 Column', 'publisher' ),
								'callback' => 'columns',
								'command'  => 'BS_Column_2',
							),
							'column'  => array( 'callback' => 'column' ),

							'columns-3' => array(
								'type'     => 'button',
								'register' => FALSE,
								'label'    => __( '3 Column', 'publisher' ),
								'command'  => 'BS_Column_3',
							),

							'columns-4' => array(
								'type'     => 'button',
								'register' => FALSE,
								'label'    => __( '4 Column', 'publisher' ),
								'command'  => 'BS_Column_4',
							),

						)
					), // /Columns

					'button' => array(
						'type'  => 'menu',
						'label' => __( 'Buttons', 'publisher' ),
						'items' => array(

							'button' => array(
								'type'           => 'button',
								'label'          => __( 'Button - Large', 'publisher' ),
								'callback'       => 'button',
								'onclick_raw_js' => '
								newButton("lg");
							'
							),

							'button-medium' => array(
								'register'       => FALSE,
								'type'           => 'button',
								'label'          => __( 'Button - Medium', 'publisher' ),
								'callback'       => 'button',
								'onclick_raw_js' => '
								newButton("md");
							'
							),

							'button-small' => array(
								'register'       => FALSE,
								'type'           => 'button',
								'label'          => __( 'Button - Small', 'publisher' ),
								'callback'       => 'button',
								'onclick_raw_js' => '
								newButton("sm");
							'
							),
						)
					),

					'list-drop' => array(
						'type'  => 'menu',
						'label' => __( 'Custom List', 'publisher' ),
						'items' => array(
							'list' => array(
								'type'              => 'button',
								'label'             => __( 'Check List', 'publisher' ),
								'callback'          => 'list_shortcode',
								'active_conditions' => array(
									'classes' => 'bs-shortcode-list list-style-check',
									'parent'  => 'ul'
								),
								'command'           => 'BS_CheckList'
							),
							'li'   => array( 'callback' => 'list_item' ),

							'list-star'     => array(
								'type'              => 'button',
								'register'          => FALSE,
								'label'             => __( 'Star List', 'publisher' ),
								'active_conditions' => array(
									'classes' => 'bs-shortcode-list list-style-star',
									'parent'  => 'ul'
								),
								'command'           => 'BS_StarList'
							),
							'list-edit'     => array(
								'type'              => 'button',
								'register'          => FALSE,
								'label'             => __( 'Edit List', 'publisher' ),
								'active_conditions' => array(
									'classes' => 'bs-shortcode-list list-style-edit',
									'parent'  => 'ul',
								),
								'command'           => 'BS_EditList'
							),
							'list-folder'   => array(
								'type'              => 'button',
								'register'          => FALSE,
								'label'             => __( 'Folder List', 'publisher' ),
								'active_conditions' => array(
									'classes' => 'bs-shortcode-list list-style-folder',
									'parent'  => 'ul'
								),
								'command'           => 'BS_FolderList'
							),
							'list-file'     => array(
								'type'              => 'button',
								'register'          => FALSE,
								'label'             => __( 'File List', 'publisher' ),
								'active_conditions' => array(
									'classes' => 'bs-shortcode-list list-style-file',
									'parent'  => 'ul'
								),
								'command'           => 'BS_FileList'
							),
							'list-heart'    => array(
								'type'              => 'button',
								'register'          => FALSE,
								'label'             => __( 'Heart List', 'publisher' ),
								'active_conditions' => array(
									'classes' => 'bs-shortcode-list list-style-heart',
									'parent'  => 'ul'
								),
								'command'           => 'BS_HeartList'
							),
							'list-asterisk' => array(
								'type'              => 'button',
								'register'          => FALSE,
								'label'             => __( 'Asterisk List', 'publisher' ),
								'active_conditions' => array(
									'classes' => 'bs-shortcode-list list-style-asterisk',
									'parent'  => 'ul'
								),
								'command'           => 'BS_AsteriskList'
							),
						)
					), // /Custom List

					'divider-drop' => array(
						'type'  => 'menu',
						'label' => __( 'Dividers', 'publisher' ),
						'items' => array(
							'divider'        => array(
								'type'     => 'button',
								'label'    => __( 'Divider - Full', 'publisher' ),
								'callback' => 'divider',
								'content'  => '<hr class="bs-divider full large">'
							),
							'divider-small'  => array(
								'type'     => 'button',
								'register' => FALSE,
								'label'    => __( 'Divider - Small', 'publisher' ),
								'callback' => 'divider',
								'content'  => '<hr class="bs-divider full small">'
							),
							'divider-tiny'   => array(
								'type'     => 'button',
								'register' => FALSE,
								'label'    => __( 'Divider - Tiny', 'publisher' ),
								'callback' => 'divider',
								'content'  => '<hr class="bs-divider full tiny">'
							),
							'divider-double' => array(
								'type'     => 'button',
								'register' => FALSE,
								'label'    => __( 'Divider - Dashed Line', 'publisher' ),
								'callback' => 'divider',
								'content'  => '<hr class="bs-divider large dashed-line">'
							),

						)
					), // /Dividers

					'alert-drop' => array(
						'type'  => 'menu',
						'label' => __( 'Alerts', 'publisher' ),
						'items' => array(
							'alert'         => array(
								'type'              => 'button',
								'label'             => __( 'Alert - Simple', 'publisher' ),
								'formatter'         => 'BS_Alert_Simple',
								'active_conditions' => array(
									'classes' => 'bs-shortcode-alert alert-simple'
								)
							),
							'alert-success' => array(
								'type'              => 'button',
								'label'             => __( 'Alert - Success', 'publisher' ),
								'register'          => FALSE,
								'formatter'         => 'BS_Alert_Success',
								'active_conditions' => array(
									'classes' => 'bs-shortcode-alert alert-success'
								)
							),
							'alert-info'    => array(
								'type'              => 'button',
								'label'             => __( 'Alert - Info', 'publisher' ),
								'register'          => FALSE,
								'formatter'         => 'BS_Alert_Info',
								'active_conditions' => array(
									'classes' => 'bs-shortcode-alert alert-info'
								)
							),
							'alert-warning' => array(
								'type'              => 'button',
								'label'             => __( 'Alert - Warning', 'publisher' ),
								'register'          => FALSE,
								'formatter'         => 'BS_Alert_Warning',
								'active_conditions' => array(
									'classes' => 'bs-shortcode-alert alert-warning'
								)
							),
							'alert-danger'  => array(
								'type'              => 'button',
								'label'             => __( 'Alert - Danger', 'publisher' ),
								'register'          => FALSE,
								'formatter'         => 'BS_Alert_Danger',
								'active_conditions' => array(
									'classes' => 'bs-shortcode-alert alert-danger'
								)
							),
						)
					), // /Alerts

					'tabs' => array(
						'register' => FALSE,
						'type'     => 'button',
						'label'    => __( 'Tabs', 'publisher' ),
						'callback' => 'tabs',
						'content'  => '[tabs]<br />\
                                        [tab title="' . __( 'Tab 1', 'publisher' ) . '"]' . __( 'Tab 1 content...', 'publisher' ) . '[/tab]<br />\
                                        [tab title="' . __( 'Tab 2', 'publisher' ) . '"]' . __( 'Tab 2 content...', 'publisher' ) . '[/tab]<br />\
                                    [/tabs]<br />\ '
					),
					'tab'  => array(
						'register' => FALSE,
						'callback' => 'tab'
					),

					'accordions' => array(
						'type'     => 'button',
						'label'    => __( 'Accordions', 'publisher' ),
						'callback' => 'accordions',
						'register' => FALSE,
						'content'  => '[accordions ]<br>[accordion title="Accordion 1 Title" load="show"]Accordion 1 content...[/accordion]<br>[accordion title="Accordion 2 Title" load="hide"]Accordion 2 content...[/accordion]<br>[/accordions]'
					),
					'accordion'  => array(
						'register' => FALSE,
						'callback' => 'accordion_pane'
					),
				)
			)
		);

	}


	/**
	 * Register shortcode from nested array
	 *
	 * @param $shortcode_key
	 * @param $shortcode
	 */
	public function register_shortcode( $shortcode_key, $shortcode ) {

		// Menu
		if ( isset( $shortcode['type'] ) && $shortcode['type'] == 'menu' ) {

			foreach ( (array) $shortcode['items'] as $_shortcode_key => $_shortcode_value ) {

				$this->register_shortcode( $_shortcode_key, $_shortcode_value );

			}

			return;

		}

		// Do not register shortcode
		if ( isset( $shortcode['register'] ) && $shortcode['register'] == FALSE ) {
			return;
		}

		// External callback
		if ( isset( $shortcode['external-callback'] ) && $shortcode['external-callback'] ) {
			call_user_func( 'add' . '_' . 'shortcode', $shortcode_key, $shortcode['external-callback'] );
		} elseif ( isset( $shortcode['callback'] ) ) {
			call_user_func( 'add' . '_' . 'shortcode', $shortcode_key, array( $this, $shortcode['callback'] ) );
		}

	}


	/**
	 * Registers all active shortcodes
	 */
	public function register_all_shortcodes() {

		foreach ( (array) self::get_shortcodes() as $shortcode_key => $shortcode ) {

			$this->register_shortcode( $shortcode_key, $shortcode );

		}
	}


	/**
	 * Shortcode: Columns
	 */
	public function columns( $atts, $content = NULL ) {

		extract( shortcode_atts( array( 'class' => '' ), $atts ) );

		$classes = array( 'row', 'bs-row-shortcode' );

		if ( $class ) {
			$classes = array_merge( $classes, explode( ' ', $class ) );
		}

		$output = '<div class="' . implode( ' ', $classes ) . '">';

		$this->temp['columns'] = array();

		// parse nested shortcodes and collect data
		do_shortcode( $content );

		foreach ( $this->temp['columns'] as $column ) {
			$output .= $column;
		}

		unset( $this->temp['columns'] );

		return $output . '</div>';
	}


	/**
	 * Shortcode Helper: Column
	 */
	public function column( $atts, $content = NULL ) {
		extract(
			shortcode_atts( array(
				'size'       => '1/1',
				'class'      => '',
				'text_align' => ''
			),
				$atts
			),
			EXTR_SKIP
		);

		$classes = array( 'column' );

		if ( $class ) {
			$classes = array_merge( $classes, explode( ' ', $class ) );
		}

		if ( stristr( $size, '/' ) ) {

			$size = str_replace(
				array(
					'1/1',
					'1/2',
					'1/3',
					'1/4',
				),
				array(
					'col-lg-12',
					'col-lg-6',
					'col-lg-4',
					'col-lg-3',
				),
				$size
			);

		} else {
			$size = 'col-lg-6';
		}

		// Add size to column classes
		array_push( $classes, $size );

		// Add style such as text-align
		$style = '';
		if ( in_array( $text_align, array( 'left', 'center', 'right' ) ) ) {
			array_push( $classes, esc_attr( strip_tags( $text_align ) ) );
		}

		$this->temp['columns'][] = $column = '<div class="' . implode( ' ', $classes ) . '"' . $style . '>' . do_shortcode( $content ) . '</div>';

		return $column;
	}


	/**
	 * Shortcode: List
	 */
	public function list_shortcode( $atts, $content = NULL ) {

		extract( shortcode_atts( array( 'style' => 'check', 'class' => '' ), $atts ), EXTR_SKIP );

		$this->temp['list_style'] = $style;

		// parse nested shortcodes and collect data
		$content = do_shortcode( $content );
		$content = preg_replace( '#^<\/p>|<div>|<\/div>|<p>$#', '', $content );
		$content = preg_replace( '#<\/li><br \/>#', '</li>', $content );
		// no list?
		if ( ! preg_match( '#<(ul|ol)[^<]*>#i', $content ) ) {

			$content = '<ul>' . $content . '</ul>'; // escaped before

		}

		$content = preg_replace( '#<ul><br \/>#', '<ul>', $content );

		return '<div class="bs-shortcode-list list-style-' . esc_attr( $style ) . $class . '">' . $content . '</div>';
	}


	/**
	 * Shortcode Helper: List item
	 */
	public function list_item( $atts, $content = NULL ) {

		$icon = '<i class="fa fa-' . $this->temp['list_style'] . '"></i>';

		return '<li>' . $icon . do_shortcode( $content ) . '</li>';

	}


	/**
	 * Shortcode: Button
	 */
	public function button( $atts, $content = NULL ) {

		$atts = bf_merge_args( $atts, array(
			'style'      => 'default',
			'link'       => '#link',
			'size'       => 'medium',
			'target'     => '',
			'background' => '',
			'color'      => '',
		) );

		$atts['size'] = str_replace(
			array(
				'large',
				'medium',
				'small',
			),
			array(
				'lg',
				'sm',
				'xs'
			),
			$atts['size']
		);

		$style = '';

		if ( ! empty( $atts['background'] ) ) {
			$style .= 'background:#' . ltrim( $atts['background'], '#' ) . ' !important;';
		}

		if ( ! empty( $atts['color'] ) ) {
			$style .= 'color:#' . ltrim( $atts['color'], '#' ) . ' !important;';
		}

		return '<a class="btn btn-' . $atts['style'] . ' btn-' . $atts['size'] . ' btn-shortcode" href="' . $atts['link'] . '" target="' . $atts['target'] . '" ' . ( $style ? 'style="' . $style . '"' : '' ) . '>' . do_shortcode( $content ) . '</a>';
	}

}
