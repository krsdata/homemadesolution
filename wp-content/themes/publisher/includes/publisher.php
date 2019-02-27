<?php
/**
 * publisher.php
 *---------------------------
 * The Publisher class that handles main functionality of theme.
 *
 */

/**
 * Publisher Theme Class
 */
class Publisher {

	/**
	 * Inner array of objects live instances like generator
	 *
	 * @var array
	 */
	protected static $instances = array();

	/**
	 * Store post thumbnail ID
	 *
	 * @var int
	 * @since 1.8.0
	 */
	public static $featured_image_ID = 0;

	/**
	 *
	 */
	function __construct() {

		// Performs the Bf setup
		add_action( 'better-framework/after_setup', array( $this, 'theme_init' ) );

		// Clears BF caches
		add_action( 'after_switch_theme', array( $this, 'after_theme_switch' ) );
		add_action( 'switch_theme', array( $this, 'theme_switch' ) );

		add_action( 'wp_ajax_ajax-get-post', array( $this, 'handle_ajaxified_load_post' ) );
		add_action( 'wp_ajax_nopriv_ajax-get-post', array( $this, 'handle_ajaxified_load_post' ) );

		/**
		 * Fix for Better AMP Auto update
		 */
		if ( class_exists( 'Better_AMP' ) ) {
			$is_bundled_plugin = ! defined( 'BETTER_AMP_INC' ); // is old better amp plugin?

			if ( $is_bundled_plugin ) {
				add_filter( 'plugins_update_check_locales', array( $this, 'enable_wp2update_better_amp' ), 1 );
			}
		}

		// Setup continue reading
		add_action( 'template_redirect', 'Publisher::init_continue_reading' );

	} // __construct


	/**
	 * Callback: delete cache and temp data after theme disabled
	 * action  : switch_theme
	 */
	public function theme_switch() {
		$this->after_theme_switch();

		// Remove theme notices after publisher disabled
		if ( $notices = Better_Framework()->admin_notices()->get_notices() ) {
			delete_option( 'bs-require-plugin-install' );

			foreach ( $notices as $idx => $notice ) {
				if ( isset( $notice['product'] ) && $notice['product'] === 'theme:publisher' ) {
					unset( $notices[ $idx ] );
				}
			}
			Better_Framework()->admin_notices()->set_notices( $notices );
		}
	}

	/**
	 * clears last BF caches for avoiding conflict
	 */
	function after_theme_switch() {

		// Clears BF transients for preventing of happening any problem
		delete_transient( '__better_framework__widgets_css' );
		delete_transient( '__better_framework__panel_css' );
		delete_transient( '__better_framework__menu_css' );
		delete_transient( '__better_framework__terms_css' );
		delete_transient( '__better_framework__final_fe_css' );
		delete_transient( '__better_framework__final_fe_css_version' );
		delete_transient( '__better_framework__backend_css' );

		// Delete all pages css transients
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->postmeta WHERE meta_key LIKE %s", '_bf_post_css_%' ) );

	} // after_theme_switch


	public function handle_ajaxified_load_post() {
		global $withcomments;

		if ( empty( $_REQUEST['post_ID'] ) ) {
			return;
		}
		define( 'PUBLISHER_THEME_AJAXIFIED_LOAD_POST', TRUE );
		$post_id = intval( $_REQUEST['post_ID'] );

		$type = bf_get_post_meta( 'post_related_type', $post_id );
		if ( $type === 'default' || ! $type ) {
			$type = publisher_get_option( 'post_related_type' );
		}

		$query_args = array(); // Extra query args
		if ( $type === 'custom-keyword' ) { // Handle related posts custom query feature
			if ( $custom_query = bf_get_post_meta( 'post_related_keyword', $post_id ) ) {
				$query_args['s'] = $custom_query;
			}
		}

		$posts_count = bf_get_post_meta( 'ajaxified_related_count', $post_id );
		if ( $posts_count === 'default' || ! $posts_count ) {
			$posts_count = publisher_get_option( 'ajaxified_related_count' );
		}

		$posts_offset = bf_get_post_meta( 'ajaxified_related_offset', $post_id );
		if ( $posts_offset === 'default' || $posts_offset === '' ) {
			$posts_offset = publisher_get_option( 'ajaxified_related_offset' );
		}

		if ( $posts_offset ) {
			$query_args['offset'] = $posts_offset;
		}

		$related_args = publisher_get_related_posts_args( $posts_count, $type, $post_id, $query_args );
		$withcomments = TRUE; // enable display post comments

		if ( ! isset( $related_args['post__not_in'] ) ) {
			$related_args['post__not_in'] = array();
		}
		if ( ! empty( $_REQUEST['loaded_posts'] ) && is_array( $_REQUEST['loaded_posts'] ) ) {
			$related_args['post__not_in'] = array_merge(
				$related_args['post__not_in'],
				$_REQUEST['loaded_posts']
			);
			$related_args['post__not_in'] = array_unique( $related_args['post__not_in'] );
		}

		$related_args['post_status'] = 'publish';

		$query = new WP_Query( $related_args );

		publisher_set_query( $query );

		$loaded_posts = array();
		if ( publisher_have_posts() ) {
			$update_post_view = FALSE;
			if ( function_exists( 'Better_Post_Views' ) ) {
				$post_view_cb     = array( Better_Post_Views(), 'increment_views' );
				$update_post_view = is_callable( $post_view_cb );
			}

			$posts_info = array();

			ob_start();
			while( publisher_have_posts() ) {
				publisher_the_post();

				$current_post_ID = get_the_ID();
				$loaded_posts[]  = $current_post_ID;
				$posts_info[]    = array(
					'id'   => $current_post_ID,
					'link' => is_ssl() ? set_url_scheme( get_the_permalink(), 'https' ) : get_the_permalink(),
				);

				if ( $update_post_view ) {
					call_user_func( $post_view_cb, $current_post_ID );
				}

				publisher_get_view( 'post', 'content-ajax', 'default' );

				// Fix inner posts queries
				// the_content filters that uses publisher_set_query()
				publisher_set_query( $query );
			}
			$output = ob_get_clean();
		} else {
			$output = FALSE;
		}

		die( json_encode( array(
			'rawHTML'      => $output,
			'haveNext'     => intval( $query->found_posts ) > 1,
			'loaded_posts' => $loaded_posts,
			'posts_info'   => $posts_info,
		) ) );

	} // handle_ajaxified_load_post


	/**
	 * Initialize theme
	 */
	function theme_init() {

		// Init VC
		if ( function_exists( 'vc_set_as_theme' ) ) {
			vc_set_as_theme();
		}
		if ( function_exists( 'vc_disable_frontend' ) ) {
			vc_disable_frontend();
		}


		// Init bbPress Support
		self::bbPress();


		/*
		 * Enqueue assets (css, js)
		 */
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
		remove_action( 'wp_head', 'locale_stylesheet' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

		/*
		 * Featured images settings
		 */
		add_theme_support( 'post-thumbnails' ); // 150x150
		// rectangles
		add_image_size( 'publisher-tb1', 86, 64, array( 'center', 'center' ) );
		add_image_size( 'publisher-sm', 210, 136, array( 'center', 'center' ) );  // Main Post Image In Full Width
		add_image_size( 'publisher-mg2', 279, 220, array( 'center', 'center' ) );
		add_image_size( 'publisher-md', 357, 210, array( 'center', 'center' ) );  // Main Post Image In Full Width
		add_image_size( 'publisher-lg', 750, 430, array( 'center', 'center' ) );
		// full
		add_image_size( 'publisher-full', 1130, 580, array( 'center', 'center' ) );  // Main Post Image In Full Width
		// tall
		add_image_size( 'publisher-tall-sm', 180, 217, array( 'center', 'center' ) );
		add_image_size( 'publisher-tall-lg', 267, 322, array( 'center', 'center' ) );
		add_image_size( 'publisher-tall-big', 368, 445, array( 'center', 'center' ) );


		/*
		 * Ads theme image sizes to media uploader
		 */
		add_filter( 'image_size_names_choose', array( $this, 'add_image_size_names_choose' ) );


		/*
		 * Post formats ( All )
		 */
		add_theme_support( 'post-formats', array(
			'video',
			'gallery',
			'audio',
			'aside',
			'image',
			'quote',
			'status',
			'chat',
			'link'
		) );

		/*
		 * This feature enables post and comment RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Register menus
		 */
		register_nav_menu( 'main-menu', __( 'Main Navigation', 'publisher' ) );
		register_nav_menu( 'resp-menu', __( 'Responsive Navigation', 'publisher' ) );
		register_nav_menu( 'top-menu', __( 'Topbar Menu', 'publisher' ) );
		register_nav_menu( 'footer-menu', __( 'Footer Menu', 'publisher' ) );
		register_nav_menu( 'off-canvas-menu', __( 'Off-Canvas Navigation', 'publisher' ) );

		// Sets the content width in pixels, based on the theme's design and stylesheet.
		$GLOBALS['content_width'] = 1170;

		// Implements editor styling
		add_editor_style();

		// Add filters to generating custom menus
		add_filter( 'better-framework/menu/mega/end_lvl', array( $this, 'generate_better_menu' ) );

		// enqueue in header
		add_action( 'wp_head', array( $this, 'wp_head' ) );

		// favicon
		add_action( 'admin_head', array( $this, 'print_favicon' ) );
		add_action( 'wp_head', array( $this, 'print_favicon' ) );

		// enqueue in footer
		add_action( 'wp_footer', array( $this, 'wp_footer' ) );

		// add custom classes to body
		add_filter( 'body_class', array( $this, 'filter_body_class' ) );

		// Enqueue admin scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ), 120 );

		// Used for adding order by rand to WP_User_Query
		add_action( 'pre_user_query', array( $this, 'action_pre_user_query' ) );

		/*
		 * Register Sidebars
		 */
		register_sidebar( array(
			'name'          => __( 'Primary Sidebar', 'publisher' ),
			'id'            => 'primary-sidebar',
			'description'   => __( 'Widgets in this area will be shown in the default sidebar.', 'publisher' ),
			'before_title'  => '<h4 class="widget-heading"><span class="h-text">',
			'after_title'   => '</span></h4>',
			'before_widget' => '<div id="%1$s" class="primary-sidebar-widget widget %2$s">',
			'after_widget'  => '</div>'
		) );
		register_sidebar( array(
			'name'          => __( 'Secondary Sidebar', 'publisher' ),
			'id'            => 'secondary-sidebar',
			'description'   => __( 'Widgets in this area will be shown in the secondary small sidebar.', 'publisher' ),
			'before_title'  => '<h4 class="widget-heading"><span class="h-text">',
			'after_title'   => '</span></h4>',
			'before_widget' => '<div id="%1$s" class="secondary-sidebar-widget widget %2$s">',
			'after_widget'  => '</div>'
		) );

		// Footer Larger Sidebars
		register_sidebar( array(
			'name'          => __( 'Footer - Column 1', 'publisher' ),
			'id'            => 'footer-1',
			'description'   => __( 'Widgets in this area will be shown in the footer column 1.', 'publisher' ),
			'before_title'  => '<h5 class="widget-heading"><span class="h-text">',
			'after_title'   => '</span></h5>',
			'before_widget' => '<div id="%1$s" class="footer-widget footer-column-1 widget %2$s">',
			'after_widget'  => '</div>'
		) );
		register_sidebar( array(
			'name'          => __( 'Footer - Column 2', 'publisher' ),
			'id'            => 'footer-2',
			'description'   => __( 'Widgets in this area will be shown in the footer column 2.', 'publisher' ),
			'before_title'  => '<h5 class="widget-heading"><span class="h-text">',
			'after_title'   => '</span></h5>',
			'before_widget' => '<div id="%1$s" class="footer-widget footer-column-2 widget %2$s">',
			'after_widget'  => '</div>'
		) );
		register_sidebar( array(
			'name'          => __( 'Footer - Column 3', 'publisher' ),
			'id'            => 'footer-3',
			'description'   => __( 'Widgets in this area will be shown in the footer column 3.', 'publisher' ),
			'before_title'  => '<h5 class="widget-heading"><span class="h-text">',
			'after_title'   => '</span></h5>',
			'before_widget' => '<div id="%1$s" class="footer-widget footer-column-3 widget %2$s">',
			'after_widget'  => '</div>'
		) );
		register_sidebar( array(
			'name'          => __( 'Footer - Column 4', 'publisher' ),
			'id'            => 'footer-4',
			'description'   => __( 'Widgets in this area will be shown in the footer column 4.', 'publisher' ),
			'before_title'  => '<h5 class="widget-heading"><span class="h-text">',
			'after_title'   => '</span></h5>',
			'before_widget' => '<div id="%1$s" class="footer-widget footer-column-4 widget %2$s">',
			'after_widget'  => '</div>'
		) );

		// Filter WP_Query
		add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );


		// Compatibility with Better Post Views
		add_filter( 'better-post-views/views/ajax', array( $this, 'better_post_views_ajax' ) );

		// Control post advanced fields
		if ( publisher_get_option( 'advanced_post_fields_excerpt' ) == FALSE || publisher_get_option( 'advanced_post_fields_subtitle' ) == FALSE ) {
			add_filter( 'publisher-theme-core/post-fields/config', array(
				$this,
				'customize_post_advanced_fields'
			), 20 );
		}


		// Config BF JSON-LD
		add_filter( 'better-framework/json-ld/config', 'Publisher::config_json_ld' );

		// Config social meta tags generator
		add_filter( 'publisher-theme-core/social-meta-tags/config', 'Publisher::social_meta_tag' );

		// Permalink type for share
		add_filter( 'better-framework/share/permalink/type', 'Publisher::share_permalink_type' );

		// Setup inline related post feature
		if ( bf_is_doing_ajax( 'ajax-get-post' ) ) {
			Publisher::init_inline_related_posts();
		} else {
			add_action( 'template_redirect', 'Publisher::init_inline_related_posts' );
		}

		// Redirect to custom 404 page if is set
		if ( publisher_get_option( 'archive_404_custom' ) !== 'default' && publisher_get_option( 'archive_404_custom' ) != '' ) {
			add_filter( '404_template', 'Publisher::custom_404_template' );
		}

		// config for Facebook APP
		add_filter( 'better-framework/api/token/facebook', 'Publisher::facebook_app_config' );

		// config admin notices
		add_filter( 'better-framework/admin-notices/new', 'Publisher::customize_admin_notices' );

	} // theme_init


	/**
	 * Used for retrieving bbPress class of Publisher
	 *
	 * @return Publisher_bbPress|false
	 */
	public static function bbPress() {

		if ( ! class_exists( 'bbpress' ) ) {
			return FALSE;
		}

		if ( isset( self::$instances['bbpress'] ) ) {
			return self::$instances['bbpress'];
		}

		include_once bf_get_theme_dir( 'includes/bbpress/class-publisher-bbpress.php' );

		$generator = apply_filters( 'publisher/bbpress', 'Publisher_bbPress' );

		// if filtered class not exists or not child of Publisher_bbPress class
		if ( ! class_exists( $generator ) || ! is_subclass_of( $generator, 'Publisher_bbPress' ) ) {
			$generator = 'Publisher_bbPress';
		}

		self::$instances['bbpress'] = new $generator;

		return self::$instances['bbpress'];

	}


	/**
	 * Enqueue css and js files
	 *
	 * Action Callback: wp_enqueue_scripts
	 *
	 */
	function register_assets() {

		$theme_version = Better_Framework()->theme()->get( 'Version' );

		bf_enqueue_script( 'element-query' );

		// All Publisher js dependencies
		bf_enqueue_script(
			'theme-libs',
			bf_append_suffix( PUBLISHER_THEME_URI . 'js/theme-libs', '.js' ),
			array( 'jquery' ),
			bf_append_suffix( PUBLISHER_THEME_PATH . 'js/theme-libs', '.js' ),
			$theme_version
		);

		// PrettyPhoto
		if ( publisher_get_option( 'light_box_images' ) !== 'disable' ) {
			bf_enqueue_script( 'pretty-photo' );
			bf_enqueue_style( 'pretty-photo' );
		}

		// Theme libraries
		bf_enqueue_script(
			'publisher',
			bf_append_suffix( PUBLISHER_THEME_URI . 'js/theme', '.js' ),
			array( 'jquery', 'theme-libs' ),
			bf_append_suffix( PUBLISHER_THEME_PATH . 'js/theme', '.js' ),
			$theme_version
		);

		bf_localize_script(
			'publisher',
			'publisher_theme_global_loc',
			apply_filters( 'publisher-theme/localized-items', array(
				'ajax_url'     => admin_url( 'admin-ajax.php' ),
				'loading'      => '<div class="bs-loading"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
				'translations' => array(
					'tabs_all'        => publisher_translation_get( 'pretty_tabs_all' ),
					'tabs_more'       => publisher_translation_get( 'pretty_tabs_more' ),
					'lightbox_expand' => publisher_translation_get( 'lightbox_expand' ),
					'lightbox_close'  => publisher_translation_get( 'lightbox_close' ),
				),
				'lightbox'     => array(
					'not_classes' => '',
				),
				'main_menu'    => array(
					'more_menu' => publisher_get_option( 'advanced_collect_more_menu' ) ? 'enable' : 'disable',
				),

			) )
		);


		/**
		 * @see handle_ajaxified_search
		 */
		bf_localize_script(
			'publisher',
			'publisher_theme_ajax_search_loc',
			array(
				'ajax_url'      => admin_url( 'admin-ajax.php' ),
				'previewMarkup' => Publisher_Search::get_ajax_search_template(),
				'full_width'    => Publisher_Search::is_menu_full_width() ? '1' : '0',
			)
		);


		// Enqueue "BetterStudio Icons" from framework
		bf_enqueue_style( 'bs-icons' );

		// Theme libraries
		bf_enqueue_style(
			'theme-libs',
			bf_append_suffix( PUBLISHER_THEME_URI . 'css/theme-libs', '.css' ),
			array(),
			bf_append_suffix( PUBLISHER_THEME_PATH . 'css/theme-libs', '.css' ),
			$theme_version
		);

		// Fontawesome
		bf_enqueue_style( 'fontawesome' );

		// If a child theme is active, add the parent theme's style.
		// this is good for performance and cache.
		if ( is_child_theme() ) {

			bf_enqueue_style(
				'publisher',
				bf_append_suffix( PUBLISHER_THEME_URI . 'style', '.css' ),
				array(),
				bf_append_suffix( PUBLISHER_THEME_PATH . 'style', '.css' ),
				$theme_version
			);

			// adds child theme version to the end of url of child theme style file
			// child have not min version
			wp_enqueue_style(
				'publisher-child',
				bf_get_child_theme_uri( 'style.css' ),
				array(),
				Better_Framework()->theme( FALSE, TRUE, FALSE )->get( 'Version' )
			);

		} // Core style
		else {
			bf_enqueue_style(
				'publisher',
				bf_append_suffix( PUBLISHER_THEME_URI . 'style', '.css' ),
				array(),
				bf_append_suffix( PUBLISHER_THEME_PATH . 'style', '.css' ),
				$theme_version
			);
		}

		if ( is_rtl() ) {
			bf_enqueue_style(
				'publisher-rtl',
				bf_append_suffix( PUBLISHER_THEME_URI . 'rtl', '.css' ),
				array( 'publisher' ),
				bf_append_suffix( PUBLISHER_THEME_PATH . 'rtl', '.css' ),
				$theme_version
			);
		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		/** HTML5 Styles for IE from BF */
		wp_enqueue_script( 'bf-html5shiv', bf_get_uri( 'assets/js/html5shiv.min.js' ), array( 'publisher' ), Better_Framework()->version );
		wp_script_add_data( 'bf-html5shiv', 'conditional', 'lt IE 9' );
		wp_enqueue_script( 'bf-respond', bf_get_uri( 'assets/js/respond.min.js' ), array( 'publisher' ), Better_Framework()->version );
		wp_script_add_data( 'bf-respond', 'conditional', 'lt IE 9' );

	} // register_assets


	/**
	 *  Enqueue anything in header
	 */
	function wp_head() {

		// Add custom css and advanced css codes
		$this->add_custom_css();

		// Header HTML Code
		publisher_echo_option( '_custom_header_code' );

	} // wp_head


	/**
	 *  Prints favicon
	 */
	function print_favicon() {

		// Site favicon with fallback for old WP versions
		//if ( ! function_exists( 'has_site_icon' ) ) {
		$favicon_16_16 = publisher_get_option( 'favicon_16_16' );
		if ( $favicon_16_16 ) {
			?>
			<link rel="shortcut icon" href="<?php echo esc_url( $favicon_16_16 ); ?>"><?php
		}

		$favicon_57_57 = publisher_get_option( 'favicon_57_57' );
		if ( $favicon_57_57 ) {
			?>
			<link rel="apple-touch-icon" href="<?php echo esc_url( $favicon_57_57 ); ?>"><?php
		}

		$favicon_114_114 = publisher_get_option( 'favicon_114_114' );
		if ( $favicon_114_114 ) {
			?>
			<link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url( $favicon_114_114 ); ?>"><?php
		}

		$favicon_72_72 = publisher_get_option( 'favicon_72_72' );
		if ( $favicon_72_72 ) {
			?>
			<link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url( $favicon_72_72 ); ?>"><?php
		}

		$favicon_144_144 = publisher_get_option( 'favicon_144_144' );
		if ( $favicon_144_144 ) {
			?>
			<link rel="apple-touch-icon" sizes="144x144" href="<?php echo esc_url( $favicon_144_144 ); ?>"><?php
		}
		//}

	} // print_favicon


	/**
	 * Used for adding theme custom css and advanced css codes into pages
	 */
	function add_custom_css() {

		/**
		 *
		 * Processes and adds custom css codes that are coming from all panels
		 *
		 */
		bf_process_panel_custom_css_code_fields( array(
			'function' => 'publisher_get_option'
		) );


		// Print reviews section css fix when BetterReview is not active but
		// custom is using one of other active plugins.
		if ( ! function_exists( 'better_reviews_is_review_active' ) && function_exists( 'wp_review_get_post_review_type' ) ) {
			bf_add_css( bf_get_local_file_content( bf_append_suffix( PUBLISHER_THEME_PATH . 'css/reviews-fix', '.css' ) ), TRUE );
		}


	} // add_panel_custom_css


	/**
	 * Callback: Enqueue anything in footer
	 *
	 * Action: wp_footer
	 */
	function wp_footer() {

		// Footer HTML Code
		publisher_echo_option( '_custom_footer_code' );

	} // wp_footer


	/**
	 *  Enqueue admin scripts
	 */
	function admin_enqueue() {

		$version = Better_Framework::theme()->get( 'Version' );

		// Enqueue "BetterStudio Icons" from framework
		bf_enqueue_style( 'bs-icons' );

		wp_enqueue_style( 'jquery-ui-core' );
		wp_enqueue_style( 'jquery-ui-draggable' );

		wp_enqueue_style( 'publisher-admin', bf_get_theme_uri( bf_append_suffix( 'css/admin-style', '.css' ) ), array(), $version );
		wp_enqueue_script( 'publisher-admin', bf_get_theme_uri( bf_append_suffix( 'js/theme-admin', '.js' ) ), array(
			'jquery-ui-resizable',
			'jquery'
		), $version );

		// Admin custom css code
		bf_add_admin_css( publisher_get_option( '_admin_css_code' ) );

	} // admin_enqueue


	/**
	 * Callback: Customize body classes
	 *
	 * Filter: body_class
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	function filter_body_class( $classes ) {

		// Activates light box
		if ( publisher_get_option( 'light_box_images' ) !== 'disable' ) {
			$classes[] = 'active-light-box';
		}

		// Body top border
		if ( publisher_get_option( 'header_top_border' ) ) {
			$classes[] = 'active-top-line';
		}

		// Body top border
		if ( ! is_rtl() ) {
			$classes[] = 'ltr';
		}

		// Page layout
		$classes[] = 'page-layout-' . publisher_get_page_layout();

		// Page boxed layout
		$classes[] = publisher_get_page_boxed_layout();

		// Activates sticky sidebar
		if ( publisher_get_option( 'sticky_sidebar' ) == 'enable' ) {
			$classes[] = 'active-sticky-sidebar';
		}

		// Activate Sticky Menu
		if ( publisher_get_option( 'menu_sticky' ) != 'no-sticky' ) {
			$classes[] = 'main-menu-sticky' . ( publisher_get_option( 'menu_sticky' ) == 'smart' ? '-smart' : '' );
		}

		// Activate Ajax Search
		if ( publisher_get_option( 'menu_show_search_box' ) == 'show' && publisher_get_option( 'menu_search_type' ) == 'ajax' ) {
			$classes[] = 'active-ajax-search';
		}

		// Infinity load related posts for single posts
		if ( publisher_is_valid_cpt( 'post' ) && publisher_get_related_post_type() == 'infinity-related-post' ) {
			$classes[] = 'infinity-related-post';
		}

		/**
		 * Processes custom classes that are coming from panels
		 */
		bf_process_panel_custom_css_class_fields( $classes, array(
			'function' => 'publisher_get_option'
		) );

		return $classes;

	} // filter_body_class


	/**
	 * Generate Custom Mega Menu HTML
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	public function generate_better_menu( $args ) {

		publisher_set_prop( 'mega-menu-args', $args );

		switch ( $args['current-item']->mega_menu ) {

			case 'link-3-column':
			case 'link-2-column':
			case 'link-4-column':
				$args['output'] = publisher_get_view( 'menu', 'mega-links-columns', 'general', FALSE );
				break;

			case 'link-list':
				$args['output'] = publisher_get_view( 'menu', 'mega-links-list', 'general', FALSE );
				break;

			case 'grid-posts':
				$args['output'] = publisher_get_view( 'menu', 'mega-grid-posts', 'general', FALSE );
				break;

			case 'tabbed-grid-posts':
				$args['output'] = publisher_get_view( 'menu', 'mega-tabbed-grid-posts', 'general', FALSE );
				break;
		}

		return $args;

	} // generate_better_menu


	/**
	 * Adds random order by feature to WP_User_Query
	 *
	 * Action: pre_user_query
	 *
	 * @param $class
	 *
	 * @return mixed
	 */
	public function action_pre_user_query( $class ) {

		if ( 'rand' == $class->query_vars['orderby'] ) {
			$class->query_orderby = str_replace( 'user_login', 'RAND()', $class->query_orderby );
		}

		return $class;

	} // action_pre_user_query


	/**
	 * Resets typography options to default
	 *
	 * Callback
	 *
	 * @return array
	 */
	public static function reset_typography_options() {

		$lang = bf_get_current_language_option_code();

		$theme_options = get_option( publisher_get_theme_panel_id() . $lang );

		$fields   = Better_Framework()->options()->load_panel_fields( publisher_get_theme_panel_id() );
		$defaults = Better_Framework()->options()->get_panel_std( publisher_get_theme_panel_id() );

		$all_styles = publisher_styles_config();

		$style = publisher_get_style();

		// if items haven't any option config
		if ( ! isset( $all_styles[ $style ] ) ) {
			$std_id = 'std';
		} else {
			$std_id = 'std-' . $style;
		}

		foreach ( (array) $fields as $field_id => $field ) {

			if ( ! isset( $field['reset-typo'] ) || ! $field['reset-typo'] ) {
				unset( $fields[ $field_id ] );
				continue;
			}

			if ( $std_id == 'std' ) {
				$theme_options[ $field['id'] ] = $defaults[ $field['id'] ][ $std_id ];
			} else {
				if ( isset( $defaults[ $field['id'] ][ $std_id ] ) ) {
					$theme_options[ $field['id'] ] = $defaults[ $field['id'] ][ $std_id ];
				} elseif ( isset( $defaults[ $field['id'] ]['std'] ) ) {
					$theme_options[ $field['id'] ] = $defaults[ $field['id'] ]['std'];
				}
			}

			unset( $defaults[ $field_id ] );
		}

		unset( $fields );
		unset( $defaults );

		// Updates option
		update_option( publisher_get_theme_panel_id() . $lang, $theme_options );

		// clear caches
		delete_transient( '__better_framework__panel_css' );
		delete_transient( '__better_framework__final_fe_css' );
		delete_transient( '__better_framework__final_fe_css_version' );

		Better_Framework()->admin_notices()->add_notice( array(
			'msg'         => __( 'Typography options was restored to default setting.', 'publisher' ),
			'notice-icon' => PUBLISHER_THEME_URI . 'images/admin/notice-logo.png',
			'product'     => 'theme:publisher'
		) );

		return array(
			'status'  => 'succeed',
			'msg'     => __( 'Typography options was restored to default setting.', 'publisher' ),
			'refresh' => TRUE
		);

	} // reset_typography_options


	/**
	 * Resets advanced options to default
	 *
	 * Callback
	 *
	 * @return array
	 */
	public static function reset_advanced_settings() {

		$lang = bf_get_current_language_option_code();

		$theme_options = get_option( publisher_get_theme_panel_id() . $lang );

		$fields   = Better_Framework()->options()->load_panel_fields( publisher_get_theme_panel_id() );
		$defaults = Better_Framework()->options()->get_panel_std( publisher_get_theme_panel_id() );

		$all_styles = publisher_styles_config();

		$style = publisher_get_style();

		// if items haven't any option config
		if ( ! isset( $all_styles[ $style ] ) ) {
			$std_id = 'std';
		} else {
			$std_id = 'std-' . $style;
		}

		foreach ( (array) $fields as $field_id => $field ) {

			if ( ! isset( $field['reset-advanced'] ) || ! $field['reset-advanced'] ) {
				unset( $fields[ $field_id ] );
				continue;
			}

			if ( $std_id == 'std' ) {
				$theme_options[ $field['id'] ] = $defaults[ $field['id'] ][ $std_id ];
			} else {
				if ( isset( $defaults[ $field['id'] ][ $std_id ] ) ) {
					$theme_options[ $field['id'] ] = $defaults[ $field['id'] ][ $std_id ];
				} elseif ( isset( $defaults[ $field['id'] ]['std'] ) ) {
					$theme_options[ $field['id'] ] = $defaults[ $field['id'] ]['std'];
				}
			}

			unset( $defaults[ $field_id ] );
		}

		unset( $fields );
		unset( $defaults );

		// Updates option
		update_option( publisher_get_theme_panel_id() . $lang, $theme_options );

		// clear caches
		delete_transient( '__better_framework__panel_css' );
		delete_transient( '__better_framework__final_fe_css' );
		delete_transient( '__better_framework__final_fe_css_version' );

		Better_Framework()->admin_notices()->add_notice( array(
			'msg'         => __( 'Advanced options was restored to default setting.', 'publisher' ),
			'notice-icon' => PUBLISHER_THEME_URI . 'images/admin/notice-logo.png',
			'product'     => 'theme:publisher'
		) );

		return array(
			'status'  => 'succeed',
			'msg'     => __( 'Advanced options was restored to default setting.', 'publisher' ),
			'refresh' => TRUE
		);

	} // reset_typography_options


	/**
	 * Resets blocks settings to default
	 *
	 * Callback
	 *
	 * @return array
	 */
	public static function reset_blocks_options() {

		$lang = bf_get_current_language_option_code();

		$theme_options = get_option( publisher_get_theme_panel_id() . $lang );

		$fields   = Better_Framework()->options()->load_panel_fields( publisher_get_theme_panel_id() );
		$defaults = Better_Framework()->options()->get_panel_std( publisher_get_theme_panel_id() );

		$all_styles = publisher_styles_config();

		$style = publisher_get_style();

		// if items haven't any option config
		if ( ! isset( $all_styles[ $style ] ) ) {
			$std_id = 'std';
		} else {
			$std_id = 'std-' . $style;
		}

		foreach ( (array) $fields as $field ) {
			if ( ! isset( $field['reset-blocks'] ) || ! $field['reset-blocks'] ) {
				continue;
			}

			if ( $std_id == 'std' ) {
				$theme_options[ $field['id'] ] = $defaults[ $field['id'] ][ $std_id ];
			} else {
				if ( isset( $defaults[ $field['id'] ][ $std_id ] ) ) {
					$theme_options[ $field['id'] ] = $defaults[ $field['id'] ][ $std_id ];
				} elseif ( isset( $defaults[ $field['id'] ]['std'] ) ) {
					$theme_options[ $field['id'] ] = $defaults[ $field['id'] ]['std'];
				}
			}
		}

		unset( $fields );
		unset( $defaults );

		// Updates option
		update_option( publisher_get_theme_panel_id() . $lang, $theme_options );

		Better_Framework()->admin_notices()->add_notice( array(
			'msg'         => __( 'Blocks settings resets to default.', 'publisher' ),
			'notice-icon' => PUBLISHER_THEME_URI . 'images/admin/notice-logo.png',
			'product'     => 'theme:publisher'
		) );

		return array(
			'status'  => 'succeed',
			'msg'     => __( 'Blocks settings was restored to default setting.', 'publisher' ),
			'refresh' => TRUE
		);

	} // reset_blocks_options


	/**
	 * Resets color options to default
	 *
	 * Callback
	 *
	 * @return array
	 */
	public static function reset_color_options() {

		$lang = bf_get_current_language_option_code();

		$theme_options = get_option( publisher_get_theme_panel_id() . $lang );

		$fields   = Better_Framework()->options()->load_panel_fields( publisher_get_theme_panel_id() );
		$defaults = Better_Framework()->options()->get_panel_std( publisher_get_theme_panel_id() );

		$all_styles = publisher_styles_config();

		$style = publisher_get_style();

		// if items haven't any option config
		if ( ! isset( $all_styles[ $style ] ) ) {
			$std_id = 'std';
		} else {
			$std_id = 'std-' . $style;
		}

		foreach ( (array) $fields as $field_id => $field ) {
			if ( ! isset( $field['reset-color'] ) || ! $field['reset-color'] ) {
				continue;
			}

			if ( $std_id == 'std' ) {
				$theme_options[ $field['id'] ] = $defaults[ $field['id'] ][ $std_id ];
			} else {
				if ( isset( $defaults[ $field['id'] ][ $std_id ] ) ) {
					$theme_options[ $field['id'] ] = $defaults[ $field['id'] ][ $std_id ];
				} elseif ( isset( $defaults[ $field['id'] ]['std'] ) ) {
					$theme_options[ $field['id'] ] = $defaults[ $field['id'] ]['std'];
				}
			}
		}

		unset( $fields );
		unset( $defaults );

		// Updates option
		update_option( publisher_get_theme_panel_id() . $lang, $theme_options );

		// clear caches
		delete_transient( '__better_framework__panel_css' );
		delete_transient( '__better_framework__final_fe_css' );
		delete_transient( '__better_framework__final_fe_css_version' );

		Better_Framework()->admin_notices()->add_notice( array(
			'msg'         => __( 'All color options resets to default.', 'publisher' ),
			'notice-icon' => PUBLISHER_THEME_URI . 'images/admin/notice-logo.png',
			'product'     => 'theme:publisher'
		) );

		return array(
			'status'  => 'succeed',
			'msg'     => __( 'Color options resets to default.', 'publisher' ),
			'refresh' => TRUE
		);

	} // reset_color_options


	/**
	 * Callback: Used for changing WP_Query, specifically for posts per page in archives
	 *
	 * @param   WP_Query $query WP_Query instance
	 */
	function pre_get_posts( $query ) {

		// This is only for front end and main query
		if ( ! is_admin() && $query->is_main_query() ) {

			// Homepage customize query
			if ( $query->is_home() ) {

				$paged = bf_get_query_var_paged();
				$limit = get_option( 'posts_per_page' );

				// Home posts count
				if ( publisher_get_option( 'home_posts_count' ) != '' ) {
					$limit = publisher_get_option( 'home_posts_count' );
					$query->set( 'posts_per_page', $limit );
					$query->set( 'paged', $paged );
				}

				// Home category filters
				if ( publisher_get_option( 'home_cat_include' ) != '' ) {
					$query->set( 'cat', publisher_get_option( 'home_cat_include' ) );
				}

				// Home exclude category filters
				if ( publisher_get_option( 'home_cat_exclude' ) != '' ) {
					$query->set( 'category__not_in', publisher_get_option( 'home_cat_exclude' ) );
				}

				// Home tag filters
				if ( publisher_get_option( 'home_tag_include' ) != '' ) {
					$query->set( 'tag__in', publisher_get_option( 'home_tag_include' ) );
				}

				// exclude first
				$slider_config = publisher_main_slider_config( array(
						'type' => 'home',
					)
				);
				if ( $slider_config['show'] && $slider_config['type'] == 'custom-blocks' && empty( $query->is_feed ) && publisher_get_option( 'home_top_posts_query' ) === 'default' ) {
					if ( $paged > 1 ) {
						$query->set( 'offset', intval( $slider_config['posts'] ) + ( ( $paged - 1 ) * $limit ) );
					} else {
						$query->set( 'offset', intval( $slider_config['posts'] ) );
					}
				}

			} // Posts per page for categories
			elseif ( $query->get_queried_object_id() > 0 && publisher_is_valid_tax( 'category', $query->get_queried_object() ) ) {

				/**
				 * @type $term WP_Term
				 */
				$term = $query->get_queried_object_id();

				$paged = get_query_var( 'paged' );
				$limit = get_option( 'posts_per_page' );

				// Custom count per category
				if ( bf_get_term_meta( 'term_posts_count', $term, '' ) != '' ) {
					$limit = bf_get_term_meta( 'term_posts_count', $term, '' );

				} // Custom count for all categories
				elseif ( publisher_get_option( 'cat_posts_count' ) != '' && intval( publisher_get_option( 'cat_posts_count' ) ) > 0 ) {
					$limit = publisher_get_option( 'cat_posts_count' );
				}

				$query->set( 'posts_per_page', $limit );

				// exclude first
				$slider_config = publisher_main_slider_config( array(
						'type'    => 'term',
						'term_id' => $term
					)
				);
				if ( $slider_config['show'] && $slider_config['type'] == 'custom-blocks' && empty( $query->is_feed ) ) {
					if ( $paged > 1 ) {
						$query->set( 'offset', intval( $slider_config['posts'] ) + ( ( $paged - 1 ) * $limit ) );
					} else {
						$query->set( 'offset', intval( $slider_config['posts'] ) );
					}
				}

			} // Posts per page for tags
			elseif ( $query->get_queried_object_id() > 0 && publisher_is_valid_tax( 'tag', $query->get_queried_object() ) ) {

				/**
				 * @type $term WP_Term
				 */
				$term = $query->get_queried_object();

				// Custom count per tag
				if ( bf_get_term_meta( 'term_posts_count', $term, '' ) != '' ) {

					$query->set( 'posts_per_page', bf_get_term_meta( 'term_posts_count', $term, '' ) );
					$query->set( 'paged', bf_get_query_var_paged() );

				} // Custom count for all tags
				elseif ( publisher_get_option( 'tag_posts_count' ) != '' && intval( publisher_get_option( 'tag_posts_count' ) ) > 0 ) {

					$query->set( 'posts_per_page', publisher_get_option( 'tag_posts_count' ) );
					$query->set( 'paged', bf_get_query_var_paged() );

				}

			} // Posts per page for authors
			elseif ( $query->is_author() ) {

				$current_user = $query->query_vars['author_name'];
				$current_user = get_user_by( 'slug', $current_user );

				// Custom count per author
				if ( bf_get_user_meta( 'author_posts_count', $current_user, '' ) != '' && intval( bf_get_user_meta( 'author_posts_count', $current_user, '' ) ) > 0 ) {

					$query->set( 'posts_per_page', bf_get_user_meta( 'author_posts_count', $current_user, '' ) );
					$query->set( 'paged', bf_get_query_var_paged() );

				} // Custom count for all tags
				elseif ( publisher_get_option( 'author_posts_count' ) != '' && intval( publisher_get_option( 'author_posts_count' ) ) > 0 ) {

					$query->set( 'posts_per_page', publisher_get_option( 'author_posts_count' ) );
					$query->set( 'paged', bf_get_query_var_paged() );

				}

			}

		}// if

	} // pre_get_posts


	/**
	 * Adds custom image sizes to WP media uploader
	 *
	 * @param $sizes
	 *
	 * @return array
	 */
	function add_image_size_names_choose( $sizes ) {

		$new_sizes = array(
			'publisher-sm' => __( 'Publisher - Small', 'publisher' ),
			'publisher-md' => __( 'Publisher - Middle', 'publisher' ),
			'publisher-lg' => __( 'Publisher - Large', 'publisher' ),
		);

		$sizes = array_merge( $sizes, $new_sizes );

		return $sizes;

	}


	//
	// BS-Pagination Ajax
	//


	/**
	 * Custom function used to return mega menu posts from bs_pagin ajax
	 */
	public static function bs_pagin_ajax_mega_grid_posts() {
		publisher_get_view( 'menu', 'mega-grid-posts-content' );
	}


	/**
	 * Custom function used to return tabbed mega menu posts from bs_pagin ajax
	 */
	public static function bs_pagin_ajax_tabbed_mega_grid_posts( $res, $wp_query, $view, $type, $atts ) {
		// only display pagination on defer loading [ paged=1 ]
		if ( isset( $atts['cat'] ) ) {
			publisher_set_prop( 'listing-main-term', $atts['cat'] );
		}
		$display_pagination      = ! ( isset( $atts['paged'] ) && $atts['paged'] > 1 );
		$atts['have_pagination'] = ! empty( $atts['paginate'] );

		if ( $display_pagination ) {
			publisher_theme_pagin_manager()->wrapper_start( $atts );
		}
		publisher_get_view( 'menu', 'mega-tabbed-grid-posts-content' );
		if ( $display_pagination ) {
			publisher_theme_pagin_manager()->wrapper_end();
		}

		if ( $display_pagination ) {
			publisher_theme_pagin_manager()->display_pagination( $atts, $wp_query, $view, $type );
		}
	}

	/**
	 * Display related posts
	 * @see path: views/general/post/_related.php
	 *
	 * @param array $atts
	 */
	protected static function _display_related_posts( $atts ) {
		publisher_theme_pagin_manager()->wrapper_start( $atts );

		$related_posts_query = publisher_get_query();
		$column              = $related_posts_query->post_count === 2 ? 2 : 3;

		$block_settings = publisher_get_option( 'blocks-related-posts' );
		publisher_set_prop( 'title-limit', $block_settings['title-limit'] );
		publisher_set_prop( 'show-subtitle', $block_settings['subtitle'] );

		if ( $block_settings['subtitle'] ) {
			publisher_set_prop( 'subtitle-limit', $block_settings['subtitle-limit'] );
			publisher_set_prop( 'subtitle-location', $block_settings['subtitle-location'] );
		}

		publisher_set_prop( 'show-term-badge', $block_settings['term-badge'] );
		publisher_set_prop( 'term-badge-count', $block_settings['term-badge-count'] );
		publisher_set_prop( 'term-badge-tax', $block_settings['term-badge-tax'] );
		publisher_set_prop( 'show-format-icon', $block_settings['format-icon'] );
		publisher_set_prop( 'show-excerpt', FALSE );
		publisher_set_prop( 'show-meta', FALSE );
		publisher_set_prop( 'listing-class', 'columns-' . $column );
		publisher_set_prop( 'block-customized', TRUE );
		publisher_set_prop_class( 'simple-grid' );
		publisher_get_view( 'loop', 'listing-grid-1' );

		publisher_theme_pagin_manager()->wrapper_end();
	}

	/**
	 * Author related posts ajax deferred loading & pagination handler
	 * @see path: views/general/post/_related.php
	 *
	 * @param array    $res
	 * @param WP_Query $wp_query
	 * @param string   $view
	 * @param string   $type
	 * @param array    $atts
	 */
	public static function fetch_other_related_posts( $res, $wp_query, $view, $type, $atts ) {
		// only display pagination on defer loading [ paged=1 ]
		$display_pagination      = ! ( isset( $atts['paged'] ) && $atts['paged'] > 1 );
		$atts['have_pagination'] = ! empty( $atts['paginate'] );

		if ( $display_pagination ) {
			publisher_theme_pagin_manager()->wrapper_start( $atts );
		}
		self::_display_related_posts( $atts );
		if ( $display_pagination ) {
			publisher_theme_pagin_manager()->wrapper_end();
			publisher_theme_pagin_manager()->display_pagination( $atts, $wp_query, $view, $type );
		}
	}

	/**
	 * Related posts pagination ajax handler
	 * @see path: views/general/post/_related.php
	 *
	 * @param array    $res
	 * @param WP_Query $wp_query
	 * @param string   $view
	 * @param string   $type
	 * @param array    $atts
	 */
	public static function fetch_related_posts( $res, $wp_query, $view, $type, $atts ) {
		self::_display_related_posts( $atts );
	}

	/**
	 * Custom function used to return mega menu posts from bs_pagin ajax
	 */
	public static function bs_pagin_ajax_archive( &$response ) {

		// if request is not valid
		if ( empty( $_REQUEST['query']['query_vars'] ) ) {
			wp_send_json( array( 'error' => __( 'Invalid Request', 'publisher' ) ) );

			return;
		}

		$args = $_REQUEST['query']['query_vars'];

		// Show/hide excerpt
		if ( isset( $_REQUEST['query']['show_excerpt'] ) ) {
			publisher_set_prop( 'show-excerpt', $_REQUEST['query']['show_excerpt'] );
		}

		// update query for current page (paged)
		$args['paged'] = $paged = max( intval( $_REQUEST['current_page'] ), 1 );

		// fix offset of query
		if ( ! empty( $args['offset'] ) ) {
			$args['offset'] = ( max( $paged - 1, 1 ) * intval( $args['posts_per_page'] ) ) + ( $args['offset'] );
		}

		$args['post_status'] = 'publish';

		$wp_query = new WP_Query( $args );
		publisher_set_query( $wp_query );

		// total pages and next page with fix for offset
		if ( ! empty( $args['offset'] ) ) {
			// uses $_REQUEST because $args offset was changed for query fix
			$response['pages']     = bf_get_wp_query_total_pages( $wp_query, $_REQUEST['query']['query_vars']['offset'], $args['posts_per_page'] );
			$response['have_next'] = $response['pages'] > $paged;
			$response['have_prev'] = $paged > 1;
		} else {
			$response['pages']     = $wp_query->max_num_pages;
			$response['have_next'] = $wp_query->max_num_pages > $paged;
			$response['have_prev'] = $paged > 1;
		}

		$response['label'] = publisher_theme_pagin_manager()->get_pagination_label( $paged, $response['pages'] );

		// Add response to .listing for better UX
		if ( isset( $_REQUEST['pagin_type'] ) ) {

			$_check = array(
				'more_btn'          => '',
				'infinity'          => '',
				'more_btn_infinity' => '',
			);

			$listing = publisher_get_page_listing( $wp_query );

			if ( isset( $_check[ $_REQUEST['pagin_type'] ] ) ) {

				$_check = array(
					'listing-mix-4-1' => '',
					'listing-mix-4-2' => '',
					'listing-mix-4-3' => '',
					'listing-mix-4-4' => '',
					'listing-mix-4-5' => '',
					'listing-mix-4-6' => '',
					'listing-mix-4-7' => '',
					'listing-mix-4-8' => '',
				);

				if ( ! isset( $_check[ $listing ] ) ) {
					publisher_set_prop( 'show-listing-wrapper', FALSE );
					$response['add-to']   = '.listing';
					$response['add-type'] = 'append';
				}
			}

			unset( $_check ); // clear memory
		}

		// Prints posts base of listing that was selected in panels.
		// Location: "views/general/loop/listing-*.php"
		publisher_get_view( 'loop', publisher_get_page_listing( $wp_query ) );

	} // bs_pagin_ajax_archive


	/**
	 * Compatibility of Publisher with Better Post Views plugin in ajax callback.
	 *
	 * @param string $count
	 *
	 * @return string
	 */
	function better_post_views_ajax( $count = '' ) {

		$rank = publisher_get_ranking_icon( $count, 'views_ranking', 'fa-eye', TRUE );

		if ( isset( $rank['show'] ) && $rank['show'] ) {
			return $rank['icon'] . ' <b class="number">' . bf_human_number_format( $count ) . '</b>';
		} else {
			return '';
		}

	}


	/**
	 * Changes the default config of post advanced fields
	 *
	 * @param $config
	 *
	 * @return mixed
	 */
	function customize_post_advanced_fields( $config ) {

		$config['excerpt']  = publisher_get_option( 'advanced_post_fields_excerpt' );
		$config['subtitle'] = publisher_get_option( 'advanced_post_fields_subtitle' );

		return $config;
	}


	/**
	 * Trick for sending update for lower version number!
	 *
	 * @param $return
	 *
	 * @return mixed
	 */
	public function enable_wp2update_better_amp( $return ) {

		// filter the request params!
		add_filter( 'http_request_args', array( $this, 'make_better_amp_updatable' ), 9, 2 );

		return $return;
	}


	/**
	 * Sends update for v1.1 because we reverted the base version of new plugin is starting from v1.0
	 *
	 * @param $args
	 * @param $url
	 *
	 * @return mixed
	 */
	public function make_better_amp_updatable( $args, $url ) {

		if ( ! preg_match( '#^https?://api.wordpress.org/+plugins/+update-check#i', $url ) ) {
			return $args;
		}

		if ( empty( $args['body']['plugins'] ) ) {
			return $args;
		}

		$plugins = json_decode( $args['body']['plugins'], TRUE );

		if ( isset( $plugins['plugins']['better-amp/better-amp.php'] ) ) {
			$plugins['plugins']['better-amp/better-amp.php']['Version'] = '0.9';
		}

		$args['body']['plugins'] = json_encode( $plugins );

		return $args;
	}


	/**
	 * Print more stories posts
	 *
	 * @param array $atts
	 *
	 * @since 1.8.0
	 */
	public static function list_posts( &$wp_query, &$view, &$type, &$atts ) {

		publisher_theme_pagin_manager()->wrapper_start( $atts );

		if ( publisher_have_posts() ) {

			{
				if ( ! isset( $atts['data']['columns'] ) ) {
					$atts['data']['columns'] = 1;
				}

				publisher_set_prop( 'listing-columns', $atts['data']['columns'] );
				publisher_set_prop( 'listing-class', 'columns-' . $atts['data']['columns'] );
			}

			if ( isset( $atts['data']['item-heading-tag'] ) ) {
				publisher_set_prop( 'item-heading-tag', $atts['data']['item-heading-tag'] );
			}

			publisher_get_view( 'loop', 'listing-' . $atts['data']['listing'] );

			publisher_clear_props();
		}

		publisher_theme_pagin_manager()->wrapper_end();
	}


	/**
	 * More stories pagination ajax handle
	 *
	 * @param array $atts
	 *
	 * @see   list_posts
	 * @since 1.8.0
	 */
	public static function listing_ajax_handler( &$response, &$wp_query, &$view, &$type, &$atts ) {
		self::list_posts( $wp_query, $view, $type, $atts );
	}


	/**
	 * Handle 'Continue Reading' button
	 *
	 * @since 1.8.0
	 */
	public static function init_continue_reading() {

		if ( ! publisher_get_option( 'post_continue_reading' ) ) {
			return;
		}

		if ( ! publisher_is_valid_cpt( 'post' ) || is_home() || is_front_page() ) {
			return;
		}

		// Automatic AMP
		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
			return;
		}

		// Better AMP
		if ( function_exists( 'is_better_amp' ) && is_better_amp() ) {
			return;
		}

		bf_content_inject( array(
			'priority' => 10, // low Priority [ in our standards ;)) ]
			'position' => 'top',
			'content'  => '<div class="continue-reading-content close">',
			'config'   => 'publisher',
		) );

		bf_content_inject( array(
			'priority' => 1000, // High Priority [ again in our standards ;)) ]
			'position' => 'bottom',
			'content'  => '</div><div class="continue-reading-container"><a href="#" class="continue-reading-btn btn">' .
			              publisher_translation_get( 'continue_reading_mobile' )
			              . '</a></div>',
			'config'   => 'publisher',
		) );
	}

	/**
	 * Setup inline related posts
	 *
	 * @since 1.8.0
	 */
	public static function init_inline_related_posts() {

		if ( is_feed() ) {
			return;
		}

		if ( ! bf_is_doing_ajax( 'ajax-get-post' ) ) {
			if ( ! publisher_is_valid_cpt( 'post' ) || is_home() || is_front_page() ) {
				return;
			}
		}

		// Better AMP
		if ( function_exists( 'is_better_amp' ) && is_better_amp() ) {
			return;
		}

		// Automatic AMP
		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
			return;
		}

		$post_id      = get_queried_object_id();
		$inline_posts = array();

		if ( bf_get_post_meta( 'inline_related_posts_override', $post_id ) ) {

			if ( bf_get_post_meta( 'inline_related_posts_status', $post_id ) === 'show' ) {

				$inline_posts = bf_get_post_meta( 'inline_related_posts', $post_id );
			}
		} else {

			if ( publisher_get_option( 'inline_related_posts_status' ) === 'show' ) {
				$inline_posts = publisher_get_option( 'inline_related_posts' );
			}
		}

		foreach ( $inline_posts as $inline ) {

			bf_content_inject( array(
				'position'   => $inline['position'] === 'custom' ? intval( $inline['paragraph'] ) : $inline['position'],
				'content_cb' => 'Publisher::inline_related_posts_callback',
				'args'       => $inline,
				'config'     => 'publisher',
			) );

			publisher_clear_props();

			if ( $block_elements = publisher_get_option( 'inline_related_posts_html_blocks' ) ) {
				bf_content_inject_config( 'publisher', array(
					'blocks_elements' => explode( ',', $block_elements ),
				) );
			}
		}
	} // init_inline_related_posts


	/**
	 * Display inline related posts
	 *
	 * @see   init_inline_related_posts
	 *
	 * @param array $inject bf_content_inject data
	 *
	 * @since 1.8.0
	 * @return string
	 */
	public static function inline_related_posts_callback( $inject ) {

		if ( empty( $inject['args'] ) ) {
			return '';
		}

		publisher_set_props( array(
			'inline-posts-heading'          => $inject['args']['heading'],
			//
			'inline-posts-keyword'          => isset( $inject['args']['keyword'] ) ? $inject['args']['keyword'] : '',
			'inline-posts-listing'          => $inject['args']['listing'],
			'inline-posts-align'            => $inject['args']['align'],
			'inline-posts-count'            => $inject['args']['count'],
			'inline-posts-type'             => $inject['args']['type'],
			'inline-posts-offset'           => $inject['args']['offset'],
			//
			'inline-posts-pagination'       => $inject['args']['pagination'],
			'inline-posts-pagination-label' => $inject['args']['pagination_label'],
		) );

		$output = publisher_get_view( 'post', '_related_inline', '', FALSE );

		publisher_clear_props();

		return $output;
	} // inline_related_posts_callback


	/**
	 * Configurations for BF JSON-LD
	 *
	 * @param $config
	 *
	 * @return array
	 */
	public static function config_json_ld( $config ) {

		$config['active'] = publisher_get_option( 'json_ld' );

		$config['logo'] = publisher_get_option( 'logo_image' );

		return $config;
	}


	/**
	 * Configurations for social meta tag generator
	 *
	 * @param $config
	 *
	 * @return array
	 */
	public static function social_meta_tag( $config ) {

		$config['active'] = publisher_get_option( 'social_meta_tag' );

		return $config;
	}


	/**
	 * Changes permalink type of share buttons
	 *
	 * @param $type
	 *
	 * @return mixed|null
	 */
	public static function share_permalink_type( $type ) {
		return publisher_get_option( 'social_share_permalink_type' );
	}


	/**
	 * Redirects 404 page to custom page
	 *
	 * @hooked 404_template
	 */
	public static function custom_404_template() {
		wp_redirect( get_permalink( publisher_get_option( 'archive_404_custom' ) ), 301 );
	}


	/**
	 * Prepares base config for Facebook
	 * This can be used in many sections.
	 *
	 * @param $config
	 *
	 * @return mixed
	 */
	public static function facebook_app_config( $config ) {

		if ( publisher_get_option( 'facebook_app_id' ) && publisher_get_option( 'facebook_app_secret' ) ) {
			$config['id']     = publisher_get_option( 'facebook_app_id' );
			$config['secret'] = publisher_get_option( 'facebook_app_secret' );
		}

		return $config;
	}


	/**
	 * Customizes admin notices
	 *
	 * @param $notice
	 *
	 * @return mixed
	 */
	public static function customize_admin_notices( $notice ) {

		$_check = array(
			'share-facebook-rate-limit' => '',
		);

		if ( ( isset( $notice['id'] ) && isset( $_check[ $notice['id'] ] ) ) || $notice['product'] == 'theme:publisher' ) {
			$notice['product']   = 'theme:publisher';
			$notice['thumbnail'] = PUBLISHER_THEME_URI . 'images/admin/notice-logo.png';
		}

		if ( isset( $notice['id'] ) && $notice['id'] === 'share-facebook-rate-limit' ) {
			$notice['msg'] = sprintf( __( 'Facebook API rate limitation was reached. You have to <a href="%s" >enter App ID & App Secret</a> in social share settings.', 'publisher' ), admin_url( 'admin.php?page=better-studio/publisher' ) );
		}

		return $notice;
	}

} // Publisher
