<?php
class YTWDVideo_Not_Found {

	public function __construct() {
		add_action ( 'admin_menu', array (
				$this,
				'admin_menu' 
		) );
		add_action ( 'admin_init', array (
				$this,
				'ytwd_video_not_found' 
		), 1 );
	}

	public function admin_menu() {
		add_dashboard_page ( '', '', 'manage_options', 'ytwd_video_not_found', '' );
	}
	
	public function ytwd_video_not_found() {
        $version = get_option("ytwd_version");
		$this->ytwd_includes();

		wp_register_script ( 'jquery', FALSE, array ('jquery-core','jquery-migrate'), '1.10.2' );
		wp_enqueue_script ( 'jquery' );

        wp_enqueue_style('ytwd_admin_main-css',  YTWD_URL . '/css/admin_main.css');

		ob_start ();
		$this->ytwd_video_not_found_header();
		$this->ytwd_video_not_found_content ();
		$this->ytwd_video_not_found_footer ();
		exit ();
	}


	private function ytwd_video_not_found_header() {
    ?>
        <!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
            <head>
                <meta name="viewport" content="width=device-width" />
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title><?php _e( 'Not Found', 'ytwd' ); ?></title>

                <link media="all" type="text/css" href="<?php echo get_admin_url(); ?>load-styles.php?c=1&amp;dir=ltr&amp;load=admin-bar,wp-admin,dashicons,buttons,wp-auth-check" rel="stylesheet">
                <?php if (get_bloginfo('version') < '3.9') { ?>
                <link media="all" type="text/css" href="<?php echo get_admin_url(); ?>css/colors<?php echo ((get_bloginfo('version') < '3.8') ? '-fresh' : ''); ?>.min.css" id="colors-css" rel="stylesheet">
                <?php } ?>
                <?php wp_print_scripts( 'jquery' ); ?>                 
                <?php do_action( 'admin_print_styles' ); ?>
                <?php do_action( 'admin_head' ); ?>
     
            </head>
            <body style="background:#fff;">
		<?php
	}
	private function ytwd_video_not_found_content() {
    ?>
        <div class="ytwd_not_found_wrapper">
            <div class="ytwd_not_found">
                <img src="<?php echo YTWD_URL; ?>/assets/youtube-404.png">
                <p><?php _e("Video Not Found", "ytwd"); ?></p>
            </div>
        </div>
    <?php
	}
        
	private function ytwd_video_not_found_footer() {
    ?>    
            </body>
        </html>
    <?php
	}
    
    private function ytwd_includes(){
	
    }
   
}
    
   
new YTWDVideo_Not_Found();

?>
 
