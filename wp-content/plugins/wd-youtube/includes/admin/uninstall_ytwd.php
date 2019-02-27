<?php

class Uninstall_ytwd extends Admin_base_ytwd{
	public function __construct(){

		parent::__construct();
		global  $ytwd_options;
        if(!class_exists("DoradoWebConfig")){
            include_once (YTWD_DIR . "/wd/config.php"); 	
        }
        $config = new DoradoWebConfig();

        $config->set_options( $ytwd_options );
		
		$deactivate_reasons = new DoradoWebDeactivate($config);
		//$deactivate_reasons->add_deactivation_feedback_dialog_box();	
		$deactivate_reasons->submit_and_deactivate(); 
	}

    public function display(){
        global $wpdb;
        $prefix = $wpdb->prefix;
        $page = $this->page; 
       
        require_once(YTWD_DIR . '/views/admin/view_uninstall_ytwd.php');
    }
    
	public function uninstall(){
		global $wpdb;
	
		// delete tables
		
		$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "ytwd_youtube");
		$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "ytwd_shortcodes");
		$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "ytwd_analytics");

        // delete options
        delete_option('ytwd_settings');
        delete_option('ytwd_version');
        delete_option('ytwd_pro');
        delete_transient('_transient_ytwd_update_check');
        delete_transient('_transient_timeout_ytwd_update_check');
        delete_option('ytwd_subscribe_done');
		delete_transient('_transient_timeout_ytwd_remote_data');
        delete_transient('_transient_ytwd_remote_data');
        delete_option('ytwd_admin_notice');

        $this->complete_uninstalation();

	}    

	private function complete_uninstalation(){
		global $wpdb;
		$prefix = $wpdb->prefix;
		$deactivate_url = wp_nonce_url('plugins.php?action=deactivate&amp;plugin='.YTWD_NAME.'/'.YTWD_NAME.'.php', 'deactivate-plugin_'.YTWD_NAME.'/'.YTWD_NAME.'.php');
		?>
		<div id="message" class="updated fade">
			<p><?php _e("The following Database Tables successfully deleted:","ytwd"); ?></p>
			<p><?php echo $prefix; ?>ytwd_youtube</p>
			<p><?php echo $prefix; ?>ytwd_shortcodes</p>
		</div>
		<div class="wrap">
		  <h2><?php _e("Uninstall YouTube WD","ytwd"); ?></h2>
		  <p><strong><a href="#" class="ytwd_deactivate_link" data-uninstall="1"><?php _e("Click Here","ytwd"); ?></a><?php _e(" To Finish the Uninstallation and YouTube WD will be Deactivated Automatically.","ytwd"); ?></strong></p>

		</div>
		<?php		
		
	}    


}


?>