<?php

class Settings_ytwd extends Admin_base_ytwd{

    public function display(){      
        $page = $this->page;
        $task = $this->task;
        require_once(YTWD_DIR . '/views/admin/view_settings_ytwd.php');

    }    
    
	public function apply(){
        $settings = get_option("ytwd_settings");
        $data = array();
        $data["api_key"] =  isset($_REQUEST["api_key"]) ? esc_html(stripslashes($_REQUEST['api_key'])) : '';
        $data["enable_cache"] =  isset($_REQUEST["enable_cache"]) ? esc_html(stripslashes($_REQUEST['enable_cache'])) : 0;
        $data["cache_time"] =  isset($_REQUEST["cache_time"]) ? esc_html(stripslashes($_REQUEST['cache_time'])) : 0;
        $data["video_seo_tags"] =  isset($_REQUEST["video_seo_tags"]) ? esc_html(stripslashes($_REQUEST['video_seo_tags'])) : 0;
        $data["fb_markup"] =  isset($_REQUEST["fb_markup"]) ? esc_html(stripslashes($_REQUEST['fb_markup'])) : 0;        
        $data["show_deleted_videos"] =  isset($_REQUEST["show_deleted_videos"]) ? esc_html(stripslashes($_REQUEST['show_deleted_videos'])) : 0;  
        
        $json_data = json_encode($data);
        update_option("ytwd_settings", $json_data);

		ytwd_redirect("admin.php?page=settings_ytwd&message_id=10");

	}


}


?>