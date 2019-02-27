<?php

/**
 * Plugin Name: YouTube WD
 * Plugin URI: https://web-dorado.com/products/wordpress-youtube-plugin.html
 * Description: Easily integrate YouTube with your WordPress site and showcase your channel content in elegant and mobile-friendly layout.
 * Version: 1.0.19
 * Author: WebDorado
 * Author URI: https://web-dorado.com/wordpress-plugins-bundle.html
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
	
define('YTWD_DIR', WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__)));
define('YTWD_NAME', plugin_basename(dirname(__FILE__)));
define('YTWD_URL', plugins_url(plugin_basename(dirname(__FILE__))));
define('YTWD_MAIN_FILE', plugin_basename(__FILE__));


if ( is_admin() ) {
	require_once( 'ytwd_admin_class.php' );
    register_activation_hook(__FILE__, array('YTWDAdmin', 'ytwd_activate'));   
	add_action( 'plugins_loaded', array('YTWDAdmin', 'ytwd_get_instance'));
     
}

require_once( 'ytwd_class.php' );
add_action( 'plugins_loaded', array('YTWD', 'ytwd_get_instance'));

require_once( YTWD_DIR. '/includes/widgets.php' );

function ytwd($shortcode_id, $item_id){
    YTWD::ytwd_get_instance();
    $params = array();
    $params ['item'] = $item_id;
    $params ['id'] = $shortcode_id; 
    YTWD::$params = $params;    
    YTWD::ytwd_frontend();
}

function ytwd_bp_script_style() {
    wp_enqueue_script('wd_bck_install', YTWD_URL . '/js/wd_bp_install.js', array('jquery'));
    wp_enqueue_style('wd_bck_install', YTWD_URL . '/css/wd_bp_install.css');
}
add_action('admin_enqueue_scripts', 'ytwd_bp_script_style');

/**
 * Show notice to install backup plugin
 */
function ytwd_bp_install_notice() {

    if ( get_option('wds_bk_notice_status') !== FALSE ) {
        update_option('wds_bk_notice_status', '1', 'no');
    }

    if ( !isset($_GET['page']) || strpos(esc_html($_GET['page']), '_ytwd') === FALSE ) {
        return '';
    }
    $prefix = "ytwd";
    $meta_value = get_option('wd_bk_notice_status');
    if ($meta_value === '' || $meta_value === false) {
        ob_start();
        ?>
        <div class="notice notice-info" id="wd_bp_notice_cont">
            <p>
                <img id="wd_bp_logo_notice" src="<?php echo YTWD_URL . '/assets/logo.png'; ?>">
                <?php _e("Youtube WD advises:  Install brand new FREE", $prefix) ?>
                <a href="https://wordpress.org/plugins/backup-wd/" title="<?php _e("More details", $prefix) ?>"
                   target="_blank"><?php _e("Backup WD", $prefix) ?></a>
                <?php _e("plugin to keep your data and website safe.", $prefix) ?>
                <a class="button button-primary"
                   href="<?php echo esc_url(wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=backup-wd'), 'install-plugin_backup-wd')); ?>">
                    <span onclick="wd_bp_notice_install()"><?php _e("Install", $prefix); ?></span>
                </a>
            </p>
            <button type="button" class="wd_bp_notice_dissmiss notice-dismiss"><span class="screen-reader-text"></span>
            </button>
        </div>
        <script>wd_bp_url = '<?php echo add_query_arg(array('action' => 'wd_bp_dismiss',), admin_url('admin-ajax.php')); ?>'</script>
        <?php
        echo ob_get_clean();
    }
}

if (!is_dir(plugin_dir_path(__DIR__) . 'backup-wd')) {
    add_action('admin_notices', 'ytwd_bp_install_notice');
}

/**
 * Add usermeta to db
 *
 * empty: notice,
 * 1    : never show again
 */
function ytwd_bp_install_notice_status() {
    update_option('wd_bk_notice_status', '1', 'no');
}
add_action('wp_ajax_wd_bp_dismiss', 'ytwd_bp_install_notice_status');

if( !class_exists("DoradoWeb") ){
    require_once(YTWD_DIR . '/wd/start.php');
}

global $ytwd_options;
$ytwd_options = array (
    "prefix" => "ytwd",
    "wd_plugin_id" => 175,
    "plugin_title" => "YouTube WD", 
    "plugin_wordpress_slug" => "wd-youtube", 
    "plugin_dir" => YTWD_DIR,
    "plugin_main_file" => __FILE__,  
    "description" => __('Easily integrate YouTube with your WordPress site and showcase your channel content in elegant and mobile-friendly layout.', 'ytwd'), 
   // from web-dorado.com
   "plugin_features" => array(
        0 => array(
            "title" => __("Easy set up", "ytwd"),
            "description" => __("Set-up YouTube WD plugin with just a few simple steps, activate the API Key and easily embed YouTube Channels, playlists and videos to your WordPress websites.", "ytwd"),
        ),
        1 => array(
            "title" => __("Customizable", "ytwd"),
            "description" => __("The plugin is highly customizable. Change the height and width of the videos, player alignment, progress bar color, adjust video quality, start and end times and much more.", "ytwd"),
        ),
        2 => array(
            "title" => __("Video Gallery", "ytwd"),
            "description" => __("Create impressive video galleries with YouTube WD plugin. Define gallery position and choose from 5 awesome view types available. Make your video galleries eve cooler with gallery loading effects like Fade In, Scale Up, Flip, Pop up and others.", "ytwd"),
        ),
        3 => array(
            "title" => __("Video and Channel Info", "ytwd"),
            "description" => __("The plugin allows you to choose what channel and video info you want to display. Show main video info like titles, descriptions, comments, likes and dislikes or don’t show anything at all.", "ytwd"),
        ), 
        4 => array(
            "title" => __("Share Buttons", "ytwd"),
            "description" => __("Make YouTube videos you share on your WordPress website social media friendly. Enable share buttons and let your website users share the videos in the most popular social networking sites with just a click.", "ytwd"),
        )                     
   ),
   // user guide from web-dorado.com
   "user_guide" => array(
        0 => array(
            "main_title" => __("Installation ", "ytwd"),
            "url" => "https://web-dorado.com/wordpress-youtube-wd/installation.html",
            "titles" => array(
                array(
                    "title" => __("Configuring API key", "ytwd"),
                    "url" => "https://web-dorado.com/wordpress-youtube-wd/configuring-api.html"
                ) 
            )
        ),
        1 => array(
            "main_title" => __("Embedding YouTube Video, Playlist and channel", "ytwd"),
            "url" => "https://web-dorado.com/wordpress-youtube-wd/embedding.html",
            "titles" => array(
                array(
                    "title" => __("General Options", "ytwd"),
                    "url" => "https://web-dorado.com/wordpress-youtube-wd/embedding/general-options.html",
                ),
                array(
                    "title" => __("Player Options", "ytwd"),
                    "url" => "https://web-dorado.com/wordpress-youtube-wd/embedding/player-options.html",
                ), 
                array(
                    "title" => __("Gallery Options", "ytwd"),
                    "url" => "https://web-dorado.com/wordpress-youtube-wd/embedding/gallery-options.html",
                ),                       
            )
        ),
 
        2 => array(
            "main_title" => __("Settings", "ytwd"),
            "url" => "https://web-dorado.com/wordpress-youtube-wd/settings.html",
            "titles" => array()
        ), 
        3 => array(
            "main_title" => __("Themes", "ytwd"),
            "url" => "https://web-dorado.com/wordpress-youtube-wd/themes.html",                
            "titles" => array()
        ),

        4 => array(
            "main_title" => __("Publishing", "ytwd"),
            "url" => "https://web-dorado.com/wordpress-youtube-wd/publishing.html",                
            "titles" => array()
        ),  
        5 => array(
            "main_title" => __("Reports", "ytwd"),
            "url" => "https://web-dorado.com/wordpress-youtube-wd/reports.html",                
            "titles" => array()
        ),                                   
   ), 
   "overview_welcome_image" => null,
   "video_youtube_id" => null,  // e.g. https://www.youtube.com/watch?v=acaexefeP7o youtube id is the acaexefeP7o
   "plugin_wd_url" => "https://web-dorado.com/products/wordpress-youtube-plugin.html", 
   "plugin_wd_demo_link" => "http://wpdemo.web-dorado.com/youtube-wd/?_ga=1.52904552.1148677990.1484574982", 
   "plugin_wd_addons_link" => null, 
   "after_subscribe" => "admin.php?page=overview_ytwd", // this can be plugin overview page or set up page
   "plugin_wizard_link" => null, 
   "plugin_menu_title" => "YouTube WD", 
   "plugin_menu_icon" => YTWD_URL . '/assets/icon-yt-20.png',
   "deactivate" => true, 
   "subscribe" => true,    
   "custom_post" => "youtube_ytwd",
   "menu_capability" => "manage_options",  
   "menu_position" => 9,        
);

dorado_web_init( $ytwd_options );
     



?>