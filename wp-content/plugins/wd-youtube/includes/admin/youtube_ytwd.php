<?php

class Youtube_ytwd extends Admin_base_ytwd{

    protected $item;
    protected $shortcode_id;


    /*display function list */
    public function display(){
        $rows = $this->get_data_rows();
        $page = $this->page;
        $id = isset($_REQUEST["id"]) ? esc_html(stripslashes($_REQUEST['id'])) : 0;

        $page_nav = $this->page_nav();
        $search_value = ((isset($_POST['search_value'])) ? esc_html(stripslashes($_POST['search_value'])) : '');
        $asc_or_desc = ((isset($_POST['asc_or_desc'])) ? esc_html(stripslashes($_POST['asc_or_desc'])) : 'asc');
        $order_by = (isset($_POST['order_by']) ? esc_html(stripslashes($_POST['order_by'])) : 'id');
        $order_class = 'manage-column column-title sorted ' . $asc_or_desc;

        $per_page = $this->per_page();
        $pager = 0;

        require_once(YTWD_DIR . '/views/admin/view_youtube_ytwd_display.php');
    }

    public function edit(){
        $row = $this->get_data_row();
        $page = $this->page;
        $task = $this->task;

        $active_tab = isset($_REQUEST["ytwd_tabs_active"]) ? esc_html(stripslashes($_REQUEST['ytwd_tabs_active'])) : 'settings-general';
        $settings_tabs = array("settings-general" => __("General","ytwd"), "settings-player" => __("Player","ytwd"), "settings-gallery" => __("Gallery","ytwd"));

        $video_api_data = false;
        if(ytwd_get_option("api_key")){
            $api_data = new YouTube_API_Data();
            $youtube_id = $row->embed_type == 0 || $row->embed_type == 1 ? $row->embed_id : $row->youtube_id;
            $video_api_data =  $api_data->get_api_data_by_type($row->embed_type, $row->channel_identifer, $youtube_id);
        }

        if($video_api_data && isset($video_api_data["pageInfo"]["totalResults"]) && $video_api_data["pageInfo"]["totalResults"] == 0){
           $video_url = 'admin.php?page=ytwd_video_not_found';
        }
        else{
           $video_url = self::get_video_url($row);
        }
        $aligment = array("0" => __("Left", "ytwd"), "1" => __("Center", "ytwd"), "2" => __("Right", "ytwd"));

        $gallery_order = array("relevance" => __("Relevance", "ytwd"), "published_at_dev" => __("Date", "ytwd"), "likes_dev" => __("Rating", "ytwd"),  "title" => __("Title", "ytwd"), "comments_dev" => __("Comments Count", "ytwd"), "views_dev" => __("View Count", "ytwd"));

        $gallery_view_type = array( "list" => __("List (paid)", "ytwd"), "carousel" => __("Carousel (paid)", "ytwd"), "table" => __("Table (paid)", "ytwd"), "blog_style" => __("Blog Style (paid)", "ytwd"));

        $thumbnails_sizes = array("default" => "Default (120X90)", "medium" => "Medium (320X180)", "high" => "High (480X360)", "standard" => "Standart (640X480)", "maxres" => "Maxres (1280X720)", "custom" =>  __("Custom", "ytwd"));

        $loading_effects = array("none"=> __("None", "ytwd"), "fade_in" => __("Fade In", "ytwd"));
		
        $loading_effects_pro = array( "move_up" => __("Move Up", "ytwd"), "scale_up" => __("Scale Up", "ytwd"), "fall_perspective" => __("Fall Perspective", "ytwd"), "fly" => __("Fly", "ytwd"), "flip" => __("Flip", "ytwd"), "helix" => __("Helix", "ytwd"), "popup" => __("Pop Up", "ytwd"));		

        $video_qualities = array("default" => "Default", "small" => "Small", "medium" => "Medium", "large" => "Large", "hd720" => "hd720", "hd1080" => "hd1080", "highres" => "Highres");

        $gallery_positions = array("0" => __("Bottom of the Player", "ytwd"), "1" => __("Above Player", "ytwd"));

        $gallery_info_pro = array("views_count" => __("Views Count","ytwd"), "likes" => __("Likes","ytwd"), "dislikes" => __("Dislikes","ytwd"),"comments_count" => __("Comments Count","ytwd"), "duration" => __("Duration","ytwd"));
		
        $gallery_info = array("published_at" => __("Published Date","ytwd"), "title" => __("Title","ytwd"), "desc" => __("Description","ytwd"));		

        $video_info = array("published_at" => __("Published Date","ytwd"), "title" => __("Title","ytwd"), "desc" => __("Description","ytwd"), "views_count" => __("Views Count","ytwd"), "likes" => __("Likes","ytwd"), "dislikes" => __("Dislikes","ytwd"),  "subscribe_btn" => __("Subscribe Button","ytwd"));
		
        $video_info_pro = array( "comments_count" => __("Comments Count","ytwd"), "likes_ratio" => __("Likes Ratio","ytwd"), "comments" => __("Comments","ytwd"), "channel_logo" => __("Channel Logo","ytwd"), "channel_title" => __("Channel Title","ytwd") );		

        $channel_info = array("title" => __("Title","ytwd"), "desc" => __("Description","ytwd"), "logo" => __("Logo","ytwd"), "banner" => __("Banner","ytwd"), "videos_count" => __("Videos Count","ytwd"), "views_count" => __("Views Count","ytwd"), "subscribers_count" => __("Subscribers Count","ytwd"), "subscribe_button" => __("Subscribe Button","ytwd"), "published_at" => __("Published","ytwd"));

        $themes = array();
        require_once(YTWD_DIR . '/views/admin/view_youtube_ytwd_edit.php');
    }

    // get video url
    public static function get_video_url($row){
        //get params
        $params = array();
        $params['autohide'] = $row->autohide;
        $params['autoplay'] = $row->autoplay;
        $params['color'] = $row->color;
        $params['theme'] = $row->theme;
        $params['controls'] = $row->controls;
        $params['fs'] = $row->fs;
        $params['loop'] = $row->loop;

        $params['iv_load_policy'] = $row->iv_load_policy;
        $params['cc_load_policy'] = $row->cc_load_policy;

        $params['playsinline'] = $row->playsinline;
        $params['wmode'] = $row->wmode;
        $params['start'] = $row->start;
        $params['end'] = $row->end;
        $params['rel'] = 0;
		
        if($row->loop == 1 && ($row->embed_type == 0 || $row->enable_gallery == 1)){
            $params['playlist'] = $row->embed_id;
        }

        if($row->hl == 1){
            $params['hl'] = get_locale();
        }
        $params['enablejsapi'] = '1';
        $params['version'] = '3';


        $video_url = "https://www.youtube.com/embed/";

        if($row->embed_type == 0){
            $video_url .= $row->embed_id;
        }
        else if($row->embed_type == 1){
            $params['listType'] = 'playlist';
            $params['list'] = $row->embed_id;
        }
        else{
            $youtube_id = $row->youtube_id;
            if($row->channel_identifer == 0){
                $params['listType'] =  'user_uploads';
            }
            else{
                $video_url .= "videoseries";
                $youtube_id = "UU".substr($youtube_id,2);
            }
            $params['list'] = $youtube_id;
        }

        $video_url = add_query_arg($params, $video_url);
        return $video_url;
    }

   // Actions
    public function save(){
        $this->store_data();
		if($this->shortcode_id){
            $this->store_shortcode();
        }
        ytwd_redirect("admin.php?page=youtube_ytwd&message_id=1");
    }
    public function apply(){

        $this->store_data();
		if($this->shortcode_id){
            $this->store_shortcode();
        }
        $active_tab = isset($_REQUEST["ytwd_tabs_active"]) ? esc_html(stripslashes($_REQUEST['ytwd_tabs_active'])) : 'settings-general';

        ytwd_redirect("admin.php?page=youtube_ytwd&task=edit&id=".$this->item."&message_id=1&ytwd_tabs_active=".$active_tab);
    }

   	public function save2copy(){
        $this->save();
    }

    private function get_data_row(){
        global $wpdb;
        $id = isset($_REQUEST["id"]) ? esc_html(stripslashes($_REQUEST['id'])) : 0;
        $id = (int)$id ;
		$row = YTWD_DB::get_row_by_id($id);
        if($id == 0){
            $row->published = 1;
            $row->embed_id = '';
            $row->video_url = '';
            $row->gallery_items_count = 12;
            $row->width = 100;
            $row->width_unit = "%";
            $row->auto_height = 1;			
            $row->height = 400;
            $row->autohide = 1;
            $row->autoplay = 0;
            $row->controls = 1;
            $row->fs = 1;
            $row->showinfo = 1;
            $row->disablekb = 0;
            $row->iv_load_policy = 1;
            $row->modestbranding = 0;
            $row->wmode = 'opaque';
            $row->item_column_number = 4;
            $row->initial_volume = 50;
            $row->theme_id = 0;
            $row->prev_btn_text = 'Prev';
            $row->next_btn_text = 'Next';
            $row->gallery_order_dir = 'desc';
            $row->gallery_order = 'published_at_dev';
            $row->comments_count = 10;
            $row->desc_max_lenght = 100;
            $row->gallery_thumb_custom_size = 100;
            $row->comments_count = 15;
            $row->thumbnails_column_number = 3;
            $row->carousel_items_count = 3;
            $row->gallery_view_type = "thumbnails";
			$row->enable_gallery = 1;
			$row->player_aligment = 1;
            if(ytwd_get_option("api_key")){
                $row->video_additional_info = 'published_at,title,desc,views_count,likes,dislikes,subscribe_btn';
                $row->channel_additional_info = 'title,desc,logo,banner,videos_count,views_count,subscribers_count,subscribe_button';
                $row->gallery_additional_info = 'title';
            }
        }
        else{
            $row->embed_id = $row->embed_type == 0 || $row->embed_type == 1 ? ytwd_get_youtube_embed_id($row->video_url) : 0;
            //$row->video_url = "https://www.youtube.com/watch?v=".$row->embed_id;
        }
        return $row;
    }
    private function get_data_rows(){
		global $wpdb;
		$where = ((isset($_POST['search_value']) && (esc_html(stripslashes($_POST['search_value'])) != '')) ? 'WHERE title LIKE "%' . esc_html(stripslashes($_POST['search_value'])) . '%"'  : '');
		$asc_or_desc = ((isset($_POST['asc_or_desc'])) ? esc_html(stripslashes($_POST['asc_or_desc'])) : 'asc');
		$asc_or_desc = ($asc_or_desc != 'asc') ? 'desc' : 'asc';
		$order_by = ' ORDER BY ' . ((isset($_POST['order_by']) && esc_html(stripslashes($_POST['order_by'])) != '') ? esc_html(stripslashes($_POST['order_by'])) : 'id') . ' ' . $asc_or_desc;
		if (isset($_POST['page_number']) && $_POST['page_number']) {
		  $limit = ((int) $_POST['page_number'] - 1) * $this->per_page;
		}
		else {
		  $limit = 0;
		}
		// get rows
		$query = "SELECT id, title, published, shortcode_id  FROM " . $wpdb->prefix . "ytwd_youtube ". $where . $order_by . " LIMIT " . $limit . ",".$this->per_page ;

		$rows = $wpdb->get_results($query);

		return $rows;
    }
	private function page_nav() {
		global $wpdb;
		$where = ((isset($_POST['search_value']) && (esc_html(stripslashes($_POST['search_value'])) != '')) ? 'WHERE title LIKE "%' . esc_html(stripslashes($_POST['search_value'])) . '%"'  : '');
		$query = "SELECT COUNT(*) FROM " . $wpdb->prefix . "ytwd_youtube " . $where;
		$total = $wpdb->get_var($query);
		$page_nav['total'] = $total;
		if (isset($_POST['page_number']) && $_POST['page_number']) {
			$limit = ((int) $_POST['page_number'] - 1) * $this->per_page;
		}
		else {
			$limit = 0;
		}
		$page_nav['limit'] = (int) ($limit / $this->per_page + 1);
		return $page_nav;
	}

    private function store_data(){
		global $wpdb;

		$columns = YTWD_DB::get_columns("ytwd_youtube");
		$column_types = YTWD_DB::column_types("ytwd_youtube");

		$data = array();
		$format = array();
		foreach($columns as $column_name){
			$data[$column_name] = isset($_POST[$column_name]) ? trim(esc_html(stripslashes($_POST[$column_name]))) : "";
			$format[] = $column_types[$column_name];
		}

		if((isset($_POST["id"]) &&  $_POST["id"] == NULL) || $this->task == "save2copy"){
            $max_shortcode_id = $wpdb->get_var("SELECT MAX(id) FROM ". $wpdb->prefix . "ytwd_shortcodes");
			$data["published"] = 1;
			$data["shortcode_id"] = $max_shortcode_id + 1;
			$data["id"] = "";

			$wpdb->insert( $wpdb->prefix . "ytwd_youtube", $data, $format );
			//$wpdb->print_error(); exit;
			$id = $wpdb->get_var("SELECT MAX(id) FROM ". $wpdb->prefix . "ytwd_youtube");

            $this->shortcode_id = $max_shortcode_id + 1;
		}
		else{
			$data["published"] = esc_html($_POST["published"]);
            $id = isset($_POST["id"]) ? (int)$_POST["id"] : 0;
			$where = array("id"=>$id);
			$where_format = array('%d');
			$wpdb->update( $wpdb->prefix . "ytwd_youtube", $data, $where, $format, $where_format );

		}
		$this->item = $id;

    }
	private function store_shortcode(){
        global $wpdb;
        $data = array();
        $data["tag_text"] = 'id='.$this->shortcode_id.' item='.$this->item;
        $format = array('%s');
        $wpdb->insert( $wpdb->prefix . "ytwd_shortcodes", $data, $format );

    }



}


?>
