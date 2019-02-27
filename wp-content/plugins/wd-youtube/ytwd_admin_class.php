<?php

class YTWDAdmin{

    protected static $instance = null;
    private static $version = '1.0.19';
    private static $page;
    

	private function __construct() {
        self::$page = isset($_GET["page"]) ? $_GET["page"] : 'settings_ytwd';	
        // Includes
		add_action('init', array($this, 'ytwd_includes'));
		
        // Add menu
        add_action('admin_menu', array($this,'ytwd_options_panel'), 9);  
        //Screen options   
        add_filter('set-screen-option', array($this, 'ytwd_set_option_youtube'), 10, 3); 
        add_filter('set-screen-option', array($this, 'ytwd_set_option_themes'), 10, 3); 

        // Add admin styles and scripts
		add_action('admin_enqueue_scripts', array($this, 'ytwd_styles'));
		add_action('admin_enqueue_scripts', array($this, 'ytwd_scripts'));
        
        // Add shortcode
        add_action('admin_head', array($this,'ytwd_admin_ajax'));
        add_action('wp_ajax_shortcode_ytwd', array('YTWDAdmin', 'ytwd_ajax'));
  
        add_filter('mce_buttons', array($this, 'ytwd_add_button'), 0);
        add_filter('mce_external_plugins', array($this, 'ytwd_register'));        
        

        //ajax
        add_action('wp_ajax_get_embed_ajax_data', array('YTWDAdmin', 'ytwd_ajax'));
        add_action('wp_ajax_admin_filter', array('YTWDAdmin', 'ytwd_ajax'));

        add_action('wpmu_new_blog', array("YTWDAdmin", 'new_blog_added'), 10, 6);

        // add meta fields
        add_filter("plugin_row_meta", array($this, 'meta_links'), 10, 2);
	}

    public function meta_links($meta_fields, $file)
    {
        if (YTWD_MAIN_FILE == $file) {
            $plugin_url = "https://wordpress.org/support/plugin/wd-youtube";
            $prefix = 'ytwd';
            $meta_fields[] = "<a href='" . $plugin_url . "' target='_blank'>" . __('Support Forum', $prefix) . "</a>";
            $meta_fields[] = "<a href='" . $plugin_url . "/reviews#new-post' target='_blank' title='" . __('Rate', $prefix) . "'>
            <i class='wdi-rate-stars'>"
                . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
                . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
                . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
                . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
                . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
                . "</i></a>";

            $stars_color = "#ffb900";

            echo "<style>"
                . ".wdi-rate-stars{display:inline-block;color:" . $stars_color . ";position:relative;top:3px;}"
                . ".wdi-rate-stars svg{fill:" . $stars_color . ";}"
                . ".wdi-rate-stars svg:hover{fill:" . $stars_color . "}"
                . ".wdi-rate-stars svg:hover ~ svg{fill:none;}"
                . "</style>";
        }

        return $meta_fields;
    }

    public static function new_blog_added($blog_id) {
        if (is_plugin_active_for_network('wd-youtube/wd-youtube.php')) {
            switch_to_blog($blog_id);
            self::activate();
            restore_current_blog();
        }
    }

    public static function ytwd_activate($networkwide) {
        if (function_exists('is_multisite') && is_multisite()) {
            // Check if it is a network activation - if so, run the activation function for each blog id.
            if ($networkwide) {
                global $wpdb;
                // Get all blog ids.
                $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
                foreach ($blogids as $blog_id) {
                    switch_to_blog($blog_id);
                    self::activate();
                    restore_current_blog();
                }
                return;
            }
        } else{
            self::activate();
        }
    }
    public static function activate() {
        delete_transient('ytwd_update_check');
        require_once(YTWD_DIR . '/sql/sql.php');
        ytwd_create_tables();
		ytwd_insert_tables();

        $version = get_option("ytwd_version");
       
        if(get_option("ytwd_pro")){
            update_option("ytwd_pro", "yes");
        }
        else{
            add_option("ytwd_pro", "yes", '', 'no');
        }
        if ($version && version_compare($version, self::$version, '<')) {
            require_once YTWD_DIR . "/update/ytwd_update.php";
            ytwd_update($version);
            update_option("ytwd_version", self::$version);           
        }
        else {
            add_option("ytwd_version", self::$version, '', 'no');          
        }
       
    }    
	
  
	// Return an instance of this class.	 
	public static function ytwd_get_instance() {
		if (null == self::$instance) {
			self::$instance = new self;
		}
		return self::$instance;
	} 
  // Admin menu
    public function ytwd_options_panel() {
        $parent_slug = null;
        if( get_option( "ytwd_subscribe_done" ) == 1 ){
            $parent_slug = "youtube_ytwd";
            $ytwd_page = add_menu_page( 'YouTube WD', 'YouTube WD', 'manage_options', 'youtube_ytwd'  , array( $this, 'ytwd' ), YTWD_URL . '/assets/icon-yt-20.png', 9 );
            add_action('load-' . $ytwd_page, array($this,'ytwd_youtube_per_page_option'));            
        }        
  

        $ytwd_page = add_submenu_page($parent_slug, __('YouTube WD','ytwd'), __('YouTube WD','ytwd'), 'manage_options', 'youtube_ytwd', array($this,'ytwd'));  
        add_action('load-' . $ytwd_page, array($this,'ytwd_youtube_per_page_option'));   

        $ytwd_settings_page = add_submenu_page($parent_slug, __('Settings','ytwd'), __('Settings','ytwd'), 'manage_options', 'settings_ytwd', array($this,'ytwd'));
        
        $ytwd_themes_page = add_submenu_page($parent_slug, __('Themes','ytwd'), __('Themes','ytwd'), 'manage_options', 'themes_ytwd', array($this,'ytwd')); 
        add_action('load-' . $ytwd_themes_page, array($this,'ytwd_theme_per_page_option'));

        $ytwd_analytics_page = add_submenu_page($parent_slug, __('Reports','ytwd'), __('Reports','ytwd'), 'manage_options', 'analytics_ytwd', array($this,'ytwd'));       
       
        
        $ytwd_uninstall_page = add_submenu_page($parent_slug, __('Uninstall','ytwd'), __('Uninstall','ytwd'), 'manage_options', 'uninstall_ytwd', array($this,'ytwd'));
          
    }

    // Admin main function
    public function ytwd() { 
        if( self::$page == "youtube_ytwd" || self::$page == "settings_ytwd" || self::$page == "analytics_ytwd" || self::$page == "themes_ytwd" || self::$page == "uninstall_ytwd" ){
            require_once(YTWD_DIR . '/includes/admin/'.self::$page.'.php');   	
            $view_class = ucfirst(strtolower(self::$page));
            $view = new $view_class();
            $view->execute();
        }
    }

   public static function ytwd_ajax(){
        check_ajax_referer('nonce_ytwd', 'nonce_ytwd');  
        $action = isset($_REQUEST["action"]) ? $_REQUEST["action"] : '';
        
        if($action){  
        
            if($action == "shortcode_ytwd"){
                require_once(YTWD_DIR . '/includes/admin/'.$action.'.php');   	
                $view_class = ucfirst(strtolower($action));
                $view = new $view_class();
                $view->execute();
            } 
            else{
                if(method_exists('Ajax_ytwd', $action)){
                    Ajax_ytwd::$action();
                }
            }
            die();
        }
        
    } 
    // Admin includes
    public function ytwd_includes(){
        require_once(YTWD_DIR . '/includes/admin/admin_base_ytwd.php');
        require_once(YTWD_DIR . '/includes/ajax_ytwd.php');
        require_once(YTWD_DIR . '/helpers/ytwd_functions.php');
        require_once(YTWD_DIR . '/helpers/ytwd_db.php');
        require_once(YTWD_DIR . '/includes/youtube_api_data.php'); 
        if (self::$page == 'ytwd_preview' ) {     
            require_once( YTWD_DIR. '/templates/preview.php' );       
        }
        if (self::$page == 'ytwd_video_not_found' ) {     
            require_once( YTWD_DIR. '/templates/not_found.php' );       
        }        
    }
    
    // Admin styles
    public function ytwd_styles() {
        wp_admin_css('thickbox');
		if( self::$page == "youtube_ytwd" || self::$page == "settings_ytwd"  || self::$page == "analytics_ytwd" || self::$page == "themes_ytwd" || self::$page == "uninstall_ytwd" ){
			wp_enqueue_style( 'ytwd_admin_main-css', YTWD_URL . '/css/admin_main.css', array(), self::$version);
            wp_enqueue_style('ytwd_bootstrap-css',  YTWD_URL . '/css/bootstrap.css', array(), self::$version);
            wp_enqueue_style('ytwd_simple_slider-css',  YTWD_URL . '/css/simple-slider.css', array(), self::$version);
            
       }
         if(self::$page== "uninstall_ytwd") {
            wp_enqueue_style('ytwd_deactivate-css',  YTWD_URL . '/wd/assets/css/deactivate_popup.css', array(), self::$version);
        }
      
    } 
    
    // Admin scripts
    public function ytwd_scripts() {
        global $wpdb, $wp_scripts;
        wp_enqueue_script('thickbox');
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui');
        wp_enqueue_script('jquery-ui-tooltip');
        wp_enqueue_media();

        if( self::$page == "youtube_ytwd" || self::$page == "settings_ytwd"  || self::$page == "analytics_ytwd" || self::$page == "themes_ytwd" || self::$page == "uninstall_ytwd" ){
            wp_enqueue_script( 'ytwd_admin_main-js', YTWD_URL . '/js/admin_main.js', array(), self::$version);
            wp_enqueue_script('ytwd_simple_slider-js', YTWD_URL . '/js/simple-slider.js', array(), true );

            wp_localize_script( 'ytwd_admin_main-js', 'ytwdGlobal', array(
                "page" => self::$page,
            ) );
            
            if(self::$page == "youtube_ytwd" ||  self::$page == "themes_ytwd" || self::$page == "analytics_ytwd"){
                wp_enqueue_script( 'ytwd_'.self::$page.'-js', YTWD_URL . '/js/'.self::$page.'.js', array(), self::$version);
            }            
            wp_enqueue_script( 'ytwd-js', 'https://www.youtube.com/iframe_api');            
         
        }
         if(self::$page == "uninstall_ytwd") {
           wp_enqueue_script('ytwd-deactivate-popup', YTWD_URL.'/wd/assets/js/deactivate_popup.js', array(), self::$version, true );
           $admin_data = wp_get_current_user();
           
            wp_localize_script( 'ytwd-deactivate-popup', 'ytwdWDDeactivateVars', array(
                "prefix" => "ytwd" ,
                "deactivate_class" =>  'ytwd_deactivate_link',
                "email" => $admin_data->data->user_email,
                "plugin_wd_url" => "https://web-dorado.com/products/wordpress-youtube-plugin.html",
            ));
        }

    }    
    
   
    public function ytwd_admin_ajax() {
      ?>
      <script>
        var ytwd_admin_ajax = '<?php echo add_query_arg(array('action' => 'shortcode_ytwd','nonce_ytwd' => wp_create_nonce('nonce_ytwd')), admin_url('admin-ajax.php')); ?>';
        var ytwd_plugin_url = '<?php echo YTWD_URL;?>';
      </script>
      <?php
    }
    // Add media button
    public function ytwd_add_button($buttons) {
      array_push($buttons, "ytwd_mce");
      return $buttons;
    }
    // Register button
    public function ytwd_register($plugin_array) {
        $url = YTWD_URL . '/js/ytwd_editor_button.js';
        $plugin_array["ytwd_mce"] = $url;
        return $plugin_array;
    }   
          
    
    public function ytwd_set_option_youtube($status, $option, $value) {
        if ( 'ytwd_youtube_per_page' == $option ) return $value;
        return $status;
    }
    public function ytwd_set_option_themes($status, $option, $value) {
        if ( 'ytwd_theme_per_page' == $option ) return $value;
        return $status;
    }   
    
    // Add pagination to youtube admin pages.
    public function ytwd_youtube_per_page_option(){
        $option = 'per_page';  
        $args_youtube = array(
            'label' => __('YouTube',"gmwd"),
            'default' => 20,
            'option' => 'ytwd_youtube_per_page'
        );
        add_screen_option( $option, $args_youtube ); 
    } 
    
    public function ytwd_theme_per_page_option(){
        $option = 'per_page';  
        $args_theme = array(
            'label' => __('Themes',"gmwd"),
            'default' => 20,
            'option' => 'ytwd_theme_per_page'
        );
        add_screen_option( $option, $args_theme ); 
    }



}


?>