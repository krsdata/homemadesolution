<?php
class YTWDPreview {

    private $item;

	public function __construct() {
		add_action ( 'admin_menu', array (
				$this,
				'admin_menu' 
		) );
		add_action ( 'admin_init', array (
				$this,
				'ytwd_preview' 
		), 1 );
        $this->item = isset($_REQUEST["item_id"]) ? $_REQUEST["item_id"] : 0;
	}

	public function admin_menu() {
		add_dashboard_page ( '', '', 'manage_options', 'ytwd_preview', '' );
	}
	
	public function ytwd_preview() {
        $version = get_option("ytwd_version");
		$this->ytwd_includes();

		wp_register_script ( 'jquery', FALSE, array ('jquery-core','jquery-migrate'), '1.10.2' );
		wp_enqueue_script ( 'jquery' );
        wp_register_script ('ytwd_linkify-js', YTWD_URL . '/js/linkify.js', array ('jquery'), '' );
        wp_enqueue_script('ytwd_linkify-js');         
        wp_register_script ('ytwd_frontend_main-js', YTWD_URL . '/js/frontend_main.js', array ('jquery'), '' );
        wp_enqueue_script('ytwd_frontend_main-js');
        wp_localize_script( 'ytwd_frontend_main-js', 'ytwdGlobal', array(
            "ajaxURL" => admin_url('admin-ajax.php'),
            "YTWD_URL" => YTWD_URL,
        ));

        wp_enqueue_style('ytwd_font_awsome-css',  YTWD_URL . '/css/font-awesome/font-awesome.css');
        wp_enqueue_style('ytwd_bootstrap-css',  YTWD_URL . '/css/bootstrap.css');

        wp_enqueue_style('ytwd_frontend_main-css',  YTWD_URL . '/css/frontend_main.css');      

       
		ob_start ();
		$this->ytwd_preview_header();
		$this->ytwd_preview_content ();
		$this->ytwd_preview_footer ();
		exit ();
	}


	private function ytwd_preview_header() {
    ?>
        <!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
            <head>
                <meta name="viewport" content="width=device-width" />
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title><?php _e( 'YouTube WD', 'ytwd' ); ?></title>

                <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
    
                <?php wp_print_scripts( 'jquery' ); ?>
                <?php wp_print_scripts( 'ytwd_linkify-js' ); ?>
                <?php wp_print_scripts( 'ytwd_frontend_main-js' ); ?>
                <?php wp_print_scripts( 'ytwd_owl-js' ); ?>                    
                <?php do_action( 'admin_print_styles' ); ?>
                <?php do_action( 'admin_head' ); ?>
     
            </head>
            <body style="background:#fff;">
		<?php
	}
	private function ytwd_preview_content() {
        YTWD::ytwd_get_instance();
        $params = array();
        $params ['item'] = $this->item;
        $params ['id'] = "preview";
         
        require_once(YTWD_DIR . '/includes/frontend_ytwd.php');   	
        $view = new Frontend_ytwd($params);
        $view->execute();
	}
        
	private function ytwd_preview_footer() {
    ?>    
            </body>
        </html>
    <?php
	}
    
    private function ytwd_includes(){
        require_once(YTWD_DIR . '/includes/frontend_base_ytwd.php');
        require_once(YTWD_DIR . '/includes/ajax_ytwd.php');
        require_once(YTWD_DIR . '/helpers/ytwd_functions.php');
        require_once(YTWD_DIR . '/helpers/ytwd_db.php');
        require_once(YTWD_DIR . '/includes/youtube_api_data.php');
			
    }
  
}
    
   
new YTWDPreview();

?>