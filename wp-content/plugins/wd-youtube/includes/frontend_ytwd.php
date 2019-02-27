<?php

class Frontend_ytwd extends Frontend_base_ytwd{

    private $api_data;
    private $youtube_id;
    private $row;
    private $iframe_video_url;
    private $embed_data = array();
    private $main_video_channel_data = array();
    private $main_video_data = array();
    private $items_data = array();
    private $total_results = 0;
    private $errors = array();
    private $f_p = false;

    public function __construct($params){
        parent::__construct($params);
		$this->f_p = isset($_GET["f_p"]) ? true : false;		
        $this->api_data = new YouTube_API_Data();
        $this->init_frontend_data();
    }

    public function display(){
        if($this->row &&  empty($this->errors) == true){
			if($this->row->published == 1){
				$params = $this->params;
				$shortcode_id = $params["id"];
				$youtube_id = $this->youtube_id;
				$row = $this->row;
				if(ytwd_get_option("api_key") == ""){
					if($row->enable_gallery == 1 || $row->video_additional_info != "" || $row->channel_additional_info != "" || $row->enable_youtube_link == 1){
						echo '<h2>'.__("API key is required.", "ytwd").'</h2>';
						return false;
					}
				}
				$iframe_video_url = $this->iframe_video_url;

				$embed_data = $this->embed_data ;
				$main_video_data = $this->main_video_data;
				$items_data = $this->items_data;
				$total_results = $this->total_results;
				$theme = $this->get_theme();
				$main_video_channel_data = $this->main_video_channel_data ;
				
				require(YTWD_DIR . '/views/view_youtube_frontend.php');				
			}
			else{
				echo '<h2>'.__("Not Published.", "ytwd").'</h2>';				
			}
        }
        else{

			echo '<h2>'.__("Data Not Found.", "ytwd").'</h2>';
			if(empty($this->errors) == false){
				foreach($this->errors as $error){
					echo '<div>'.$error.'</div>';
				}
			}				
			
        }

    }
    public function fb_markup(){
        $embed_data = $this->embed_data;

        $row = $this->row;
        $meta_tags = '<meta property="og:type" content="video" />' . "\n";
        $meta_tags .= '<meta property="og:title" content="'.$embed_data["items"][0]["snippet"]["title"].'" />' . "\n";
        $meta_tags .= '<meta property="og:video" content="'.$this->iframe_video_url.'" />' . "\n";
        $meta_tags .= '<meta property="og:image" content="'.$embed_data["items"][0]["snippet"]["thumbnails"]["high"]["url"].'" />' . "\n";
        $meta_tags .= '<meta property="og:video:width" content="400" />' . "\n";
        $meta_tags .= '<meta property="og:video:height" content="400" />' . "\n";
        $meta_tags .= '<meta property="og:description" content="'.$embed_data["items"][0]["snippet"]["description"].'" />' . "\n";
        $meta_tags .= '<meta property="og:site_name" content="'.get_bloginfo('name').'" />' . "\n";
        $meta_tags .= '<meta property="og:site_url" content="'.site_url().'" />' . "\n";

        echo $meta_tags;

    }

    private function init_frontend_data(){
        $row = $this->get_embed_data();
        $this->row = $row;
		$errors = array();
        if($row != false){
            $atts = array();
            $atts['autohide'] = $row->autohide;
            $atts['autoplay'] = $row->autoplay;
            $atts['color'] = $row->color;
            $atts['theme'] = $row->theme;
            $atts['controls'] = $row->controls;
            $atts['fs'] = $row->fs;
            $atts['loop'] = $row->loop;
            $atts['iv_load_policy'] = $row->iv_load_policy;
            $atts['cc_load_policy'] = $row->cc_load_policy;
            $atts['playsinline'] = $row->playsinline;
            $atts['wmode'] = $row->wmode;
            $atts['start'] = $row->start;
            $atts['end'] = $row->end;
            $atts['rel'] = 0;


            if($row->hl == 1){
                $atts['hl'] = get_locale();
            }
            $atts['enablejsapi'] = '1';
            $atts['version'] = '3';
			$protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
            $video_url = $protocol . "://www.youtube.com/embed/";
            $youtube_id = $row->embed_type == 0 || $row->embed_type == 1 ? $row->embed_id : $row->youtube_id;
            $this->youtube_id = $youtube_id;
            $api_data = $this->api_data;
            if($row->embed_type == 0){
                if($row->loop == 1){
                    $atts['playlist'] = $row->embed_id;
                }
                $iframe_video_url = add_query_arg($atts, $video_url.$row->embed_id);
                // get main video infotmation (title, description, published at, comments...)
                $main_video_data = $this->get_video_advanced_data($api_data, $row->embed_id, $row->comments_count);
                $embed_data =  $main_video_data[1];
            }
            else{
                $statistics = $row->embed_type == 1 ? false : true;
                $branding_settings = $row->embed_type == 1 ? false : true;
                $embed_data = $api_data->get_api_data_by_type($row->embed_type, $row->channel_identifer, $this->youtube_id, $statistics, true, $branding_settings);  
                
                if($row->enable_gallery == 1){
					$items_data = array();
                    if( isset($_POST["page"]) && get_transient("0ytwd_data_".$youtube_id) && $this->f_p == false && !get_transient("ytwd_data_f_p_".$youtube_id)){
						$k = 0;
						while(get_transient($k."ytwd_data_".$youtube_id)){
							$data = get_transient($k."ytwd_data_".$youtube_id);						
							$items_data = array_merge($items_data, json_decode($data, true));
							$k++;	
						}
                    }
                    else{
                        $nextPageToken = 1;
                        $all_data = array();
						if($this->f_p == true){
							set_transient("ytwd_data_f_p_".$youtube_id, 1);
                            $all_data[] = $this->get_gallery_data($api_data, $row->embed_type, $youtube_id, $row->channel_identifer,  $nextPageToken);							
						}
						else{
							delete_transient("ytwd_data_f_p_".$youtube_id);
							while($nextPageToken){
								$data = $this->get_gallery_data($api_data, $row->embed_type, $youtube_id, $row->channel_identifer,  $nextPageToken);
								$nextPageToken = isset($data["nextPageToken"]) ? $data["nextPageToken"] : false;
								$all_data[] = $data;
							}							
						}						

                        
                        foreach($all_data as $data){
                            if($data && isset($data["items"])){
                                $items = $data["items"];
                                for($i=0; $i<count($items); $i++){
                                    $item = $items[$i];
                                    $item_data = array();
                                    $kind = $item["snippet"]["resourceId"]["kind"] ;

                                    // get only videos from channel or playlist, and check for deleted videos
                                    if($kind != "youtube#video" || (ytwd_get_option("show_deleted_videos") == 0 && !isset($item["snippet"]["thumbnails"]["default"]["url"])) || $item["snippet"]["description"] == "This video is private."){
                                        continue;
                                    }
                                    //get video data
                                    $resource_id = $item["snippet"]["resourceId"]["videoId"];
                                    $item_data["resource_id"] = $resource_id;
                                    if($row->loop == 1){
                                        $atts['playlist'] = $resource_id;
                                    }
                                    $item_data["video_url"] =  add_query_arg($atts, $video_url.$resource_id);

                                    $published_at = substr($item["snippet"]["publishedAt"], 0 , strpos($item["snippet"]["publishedAt"],"T"));
                                    $item_data["published_at_dev"] = strtotime($published_at);
                                    $item_data["published_at"] = date("Y, F d", strtotime($published_at));

                                    $item_data["title"] = $item["snippet"]["title"];

                                    $item_data["description"] = $item["snippet"]["description"];
									
									$thumb_size =  key(array_slice( $item["snippet"]["thumbnails"], -1, 1, TRUE )) ;
									
									$item_data["thumb_url"] = (isset($item["snippet"]["thumbnails"][$thumb_size]["url"]) ? $item["snippet"]["thumbnails"][$thumb_size]["url"] : YTWD_URL.'/assets/no-image.png');
									
                                    $items_data[] = $item_data;
                                }
                            }
                        }
                        // cache data
						$options_count = ceil(count($items_data)/500);
						for($i=0; $i<$options_count; $i++){
							$items_data_ = array_slice($items_data, $i*500, 500);
							set_transient($i."ytwd_data_".$youtube_id, json_encode($items_data_), 3600);
						}						

                    }

                    $iframe_video_url = isset($items_data[0]["video_url"]) ? $items_data[0]["video_url"] : "";

                    $main_iframe_video_id = isset($_POST["resource_id"]) ? esc_html(stripslashes($_POST["resource_id"])) : (isset($items_data[0]["resource_id"]) ? $items_data[0]["resource_id"] : null); 
					
                    $total_results = count($items_data);
											
					$page = isset($_POST["page"]) ?  esc_html(stripslashes($_POST["page"])) : 0;
                    
					$start = $page*$row->gallery_items_count;
					$items_count = isset($_POST["items_count"]) ? esc_html(stripslashes($_POST["items_count"])) : $row->gallery_items_count;

					$items_data = array_slice($items_data, $start, $items_count);
                   
                    $this->items_data = $items_data;
                    $this->total_results = $total_results;

                }
                else{
                    if($row->embed_type == 1){
                        $atts['listType'] =  'playlist';
                    }
                    else{
                        if($row->channel_identifer == 0){
                            $atts['listType'] =  'user_uploads';
                        }
                        else{
                            $video_url .= "videoseries";
                            $youtube_id = "UU".substr($youtube_id,2);
                        }
                    }

                    $atts['list'] = $youtube_id;
                    $main_iframe_video_id = null;
                    $iframe_video_url = add_query_arg($atts, $video_url);
                }

                // get main video infotmation (title, description, published at, comments...)
                $main_video_data = $this->get_video_advanced_data($api_data, $main_iframe_video_id, $row->comments_count);
            }
			
			if(($embed_data == false || (isset($embed_data["pageInfo"]["totalResults"]) && $embed_data["pageInfo"]["totalResults"] == 0)) && ytwd_get_option("api_key") != ""){
				$errors[] = __("Embed not found. Wrong youtube id or video doesn't exist.","ytwd");
			}
			else if(isset($embed_data["error"]["message"]) && ytwd_get_option("api_key") != ""){
				$errors[] = $embed_data["error"]["message"];
			}
			else{
				if($row->embed_type != 2 && isset($main_video_data[1]["items"][0]["snippet"]["channelId"])){
					$main_video_channel_data = $api_data->get_api_data_by_type(2, 1, $main_video_data[1]["items"][0]["snippet"]["channelId"]);
				}
				else{
					$main_video_channel_data = $embed_data;
				}
				$this->main_video_channel_data = $main_video_channel_data;
			}
			
            $this->iframe_video_url = $iframe_video_url;
            $this->embed_data = $embed_data;
            $this->main_video_data = $main_video_data;
			

        }
        else{
            $errors[] = __("Database data not found.","ytwd");
        }
		$this->errors = $errors;
		return true;
    }
    private function get_video_advanced_data($api_data, $youtube_id, $max_results){
        if($youtube_id == null){
            return false;
        }
		$protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
        $iframe_video_youtube_url = $protocol . "://www.youtube.com/watch?v=".$youtube_id;
        $video_data = $api_data->get_api_data_by_type(0, 0, $youtube_id, true, false );
        
        $comments = $api_data->get_video_comments($youtube_id, false, $max_results);
        $data = array( $iframe_video_youtube_url, $video_data, $comments);
        return $data;
    }

    private function get_gallery_data($api_data, $embed_type, $youtube_id, $channel_identifer, $page_token  ){
        if($embed_type == 1){
            $data = $api_data->get_playlist_api_data($youtube_id, $page_token);
        }
        else{
            $data = $api_data->get_channel_api_data($channel_identifer, $youtube_id, $page_token);
       }
       return $data;
    }

    private function get_embed_data(){
        $row = false;
        $params = $this->params;
        $item_id = (isset($params["item"]) && $params["item"]) ? $params["item"] : ($this->f_p == true ? true : 0);

        if($item_id != 0){
            if($this->f_p == true && $item_id === true ){
                $row = new stdClass();
                $fields = YTWD_DB::get_columns('ytwd_youtube');
                foreach($fields as $field){
                    $row->$field = isset($_GET[$field]) ? esc_html(stripslashes($_GET[$field])) : null;
                }
            }
            else{
                $row = YTWD_DB::get_row_by_id($item_id, 'ytwd_youtube');
            }
            if($row){
				if($this->f_p == true){
					$row->published = 1;
					$row->autoplay = 0;					
				}				
                $row->video_url = $row->embed_type == 1 ? $row->playlist_url : $row->video_url;

                $row->width = (isset($params["width"]) && !($row->embed_type != 0 && $row->enable_gallery == 1 && $row->gallery_video_display_mode == 1 && $row->gallery_view_type != "blog_style")) ? esc_html(stripslashes($params["width"])) : $row->width;
				$row->width_unit = (isset($params["width"]) && !($row->embed_type != 0 && $row->enable_gallery == 1 && $row->gallery_video_display_mode == 1 && $row->gallery_view_type != "blog_style")) ? "px" : $row->width_unit;				
                $row->height = (isset($params["height"]) && !($row->embed_type != 0 && $row->enable_gallery == 1 && $row->gallery_video_display_mode == 1 && $row->gallery_view_type != "blog_style")) ? esc_html(stripslashes($params["height"])) : ($row->auto_height == 1 ? 0 :  $row->height );
				
                $row->embed_id = $row->embed_type == 0 || $row->embed_type == 1 ? ytwd_get_youtube_embed_id($row->video_url) : 0;
            }
            else{
                echo '<h2>'.__("Dtata Not Found.", "ytwd").'</h2>';
            }
        }
        else{
            echo '<h2>'.__("Invalid Embed Id.", "ytwd").'</h2>';
        }

        return $row;

    }

	private function get_theme(){
        $row = new stdClass();
        $row->title = "";
        $row->published = 1;
        $row->default = 0;
		$row->thumbnails_bgcolor = "fff";
		$row->thumbnails_border_width = 0;
		$row->thumbnails_padding_top = "0";
        $row->thumbnails_padding_right = "0";
        $row->thumbnails_padding_bottom = "0";
        $row->thumbnails_padding_left = "0";
		$row->thumbnails_border_style = "none";
		$row->thumbnails_border_color = "000";
		$row->thumbnails_border_radius = "0";
		$row->thumbnails_box_shadow = "";
		$row->thumbnails_hover_effect = "none";
		$row->thumbnails_hover_effect_val = "";
		$row->thumbnails_hover_border_width = 0;
		$row->thumbnails_hover_border_style = "none";
		$row->thumbnails_hover_border_color = "000";
		$row->thumbnails_hover_opacity = 0.8;
		$row->thumbnails_transition = 1;
		$row->thumbnails_video_info_bgcolor = "fff";
		$row->thumbnails_title_font_size = 15;
		$row->thumbnails_title_font_color = '363636';
		$row->thumbnails_published_at_font_size = 12;
		$row->thumbnails_published_at_font_color = '959595';
		$row->thumbnails_desc_font_size = 13;
		$row->thumbnails_desc_font_color = '363636';
		$row->thumbnails_stat_font_size = 13;
		$row->thumbnails_stat_font_color = '959595';
		$row->thumbnails_stat_align = "block";
		$row->thumbnails_text_align = 'left';
		$row->thumbnails_shape = 0;
		$row->thumbnails_horizontal_line = 0;
		$row->list_backgorund_color = 'fff';
        $row->list_padding_top = '0';
        $row->list_padding_right = '0';
        $row->list_padding_bottom = '0';
        $row->list_padding_left = '0';		
		$row->list_border_width = 0;
		$row->list_border_style = "none";
		$row->list_border_color = "000";
		$row->list_border_radius = "0";
		$row->list_box_shadow = "";
		$row->list_hover_effect = "none";
		$row->list_hover_effect_val = "";
		$row->list_hover_border_width = 0;
		$row->list_hover_border_style = "none";
		$row->list_hover_border_color = "000";
		$row->list_hover_opacity = 0.8;
		$row->list_transition = 1;
		$row->list_title_font_size = 18;
		$row->list_title_font_color = "000";
		$row->list_published_at_font_size = 16;
		$row->list_published_at_font_color = '959595';
		$row->list_desc_font_size = 14;
		$row->list_desc_font_color = '545454';
		$row->list_stat_font_size = 13;
		$row->list_stat_font_color = '959595';
		$row->list_thumbanil_position = 0;
		$row->list_shape = 0;
		$row->list_horizontal_line = 0;
		$row->carousel_border_width = 0;
        $row->carousel_padding_top = '0';
        $row->carousel_padding_right = '0';
        $row->carousel_padding_bottom = '0';
        $row->carousel_padding_left = '0';			
		$row->carousel_border_style = "none";
		$row->carousel_border_color = "000";
		$row->carousel_border_radius = "0";
		$row->carousel_box_shadow = "";
		$row->carousel_hover_border_width = 0;
		$row->carousel_hover_border_style = "none";
		$row->carousel_hover_border_color = "000";
		$row->carousel_hover_opacity = 0.8;
		$row->carousel_transition = 1;
		$row->carousel_btns_style = 'fa-chevron';
		$row->carousel_btns_size = 30;
		$row->carousel_btns_color = '363636';
		$row->carousel_video_info_bgcolor = 'fff';
		$row->carousel_title_font_size = 15;
		$row->carousel_title_font_color = '363636';
		$row->carousel_published_at_font_size = 12;
		$row->carousel_published_at_font_color = '959595';
		$row->carousel_desc_font_size = 13;
		$row->carousel_desc_font_color = '363636';
		$row->carousel_stat_font_color = '959595';
		$row->carousel_stat_font_size = '13';
		$row->carousel_stat_align = "block";
		$row->carousel_text_align = 'left';
		$row->carousel_shape = 0;
		$row->carousel_horizontal_line = 0;		
		$row->table_body_bgcolor = 'fff';
        $row->table_padding_top = '0';
        $row->table_padding_right = '0';
        $row->table_padding_bottom = '0';
        $row->table_padding_left = '0';		
		$row->table_body_color = '545454';
		$row->table_body_font_size = 14;
		$row->table_body_border_width = "0";
		$row->table_body_border_style = "none";
		$row->table_body_border_color = "fff";
		$row->table_box_shadow = '';
		$row->table_border_width = 0;
		$row->table_border_style = 'none';
		$row->table_border_color = '000';
		$row->table_border_radius = '0';
		$row->table_hover_border_width = 0;
		$row->table_hover_border_style = 'none';
		$row->table_hover_border_color = '000';
		$row->table_hover_opacity = 0.8;
		$row->table_transition = 1;
		$row->table_shape = 0;
		$row->table_stat_font_size = 13;
		$row->table_stat_font_color = '959595';
		$row->pagination_btns_color = '545454';
		$row->pagination_btns_font_size = 16;
		$row->pagination_btns_style = 'fa-angle-double';
		$row->pagination_alignment = 'center';
		$row->load_more_btn_width = '150';
		$row->load_more_btn_height = '40';
		$row->load_more_btn_color = '545454';
		$row->load_more_btn_bgcolor = 'fff';
		$row->load_more_btn_font_size = 16;
		$row->load_more_btn_border_style = 'solid';
		$row->load_more_btn_border_width = '1';
		$row->load_more_btn_border_color = '545454';
		$row->load_more_btn_border_radius = '0';
		$row->main_bgcolor = "fff";
		$row->main_padding = "0";
		$row->main_title_color = "080808";
		$row->main_title_color_hover = "959595";
		$row->main_title_font_size = "25";
		$row->main_channel_title_color = "545454";
		$row->main_channel_title_font_size = "13";
		$row->main_share_btns_color = "959595";
		$row->main_share_btns_size = "18";
		$row->main_views_color = "080808";
		$row->main_views_font_size = "20";
		$row->main_likes_color = "959595";
		$row->main_likes_font_size = "16";
		$row->main_published_at_color = "545454";
		$row->main_published_at_font_size = "16";
		$row->main_desc_color = "545454";
		$row->main_desc_font_size = "13";
		$row->main_comment_author_color = "545454";
		$row->main_comment_author_color_hover = "959595";
		$row->main_comment_author_font_size = "15";
		$row->main_comment_published_color = "959595";
		$row->main_comment_published_font_size = "11";
		$row->main_comment_text_color = "545454";
		$row->main_comment_text_font_size = "13";
		$row->main_captions_text_color = "333";
		$row->channel_bgcolor = "fff";
		$row->channel_header_title_color = "545454";
		$row->channel_header_title_font_size = "24";
		$row->channel_header_desc_color = "545454";
		$row->channel_header_desc_font_size = "13";
		$row->channel_header_statistics_font_size = "15";
		$row->channel_header_statistics_color = "959595";
        $row->playlist_header_bgcolor = "fff";
        $row->playlist_header_padding_top = "0";
        $row->playlist_header_padding_right = "0";
        $row->playlist_header_padding_bottom = "0";
        $row->playlist_header_padding_left = "0";
        $row->playlist_header_videos_count_color = "959595";
        $row->playlist_header_videos_count_font_size = "14";
        $row->playlist_header_pub_color = "959595";
        $row->playlist_header_pub_font_size = "14";
		$row->blog_style_bgcolor = "fff";
        $row->blog_style_padding_top = '0';
        $row->blog_style_padding_right = '0';
        $row->blog_style_padding_bottom = '0';
        $row->blog_style_padding_left = '0';		
		$row->blog_style_title_font_size = 22;
		$row->blog_style_title_font_color = "363636";
		$row->blog_style_published_at_font_size = 16;
		$row->blog_style_published_at_font_color = "363636";
		$row->blog_style_desc_font_size = 14;
		$row->blog_style_desc_font_color = "363636";
		$row->blog_style_stat_font_size = 19;
		$row->blog_style_stat_font_color = "959595";
		$row->blog_style_box_shadow = "";	

        return $row;

	}


}


?>
