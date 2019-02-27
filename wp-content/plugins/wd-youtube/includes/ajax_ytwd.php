<?php

class Ajax_ytwd {

    public static function get_embed_ajax_data(){
        $id = (int)((isset($_POST['embed'])) ?  esc_html(stripslashes($_POST["embed"])) : "");
        $from_db = (isset($_POST['from_db'])) ? esc_html(stripslashes($_POST["from_db"])) : "";
        
        $response = array();
        $is_valid = false;
        
        if($from_db == 1 && $id){
            $row = YTWD_DB::get_row_by_id($id, "ytwd_youtube");            
            $params = self::get_params_from_db($id);
            $embed_type = $row->embed_type;
            $embed_id = $embed_type == 0 ? ytwd_get_youtube_embed_id($row->video_url) : ($embed_type == 1 ? ytwd_get_youtube_embed_id($row->playlist_url) : 0);
            $youtube_id = $row->youtube_id;
            $channel_identifer = $row->channel_identifer;
            $is_valid = true;
           
        }
        else if($from_db == 0){
            $params = self::get_params_from_post();
            $_video_url = (isset($_POST['video_url'])) ? trim(esc_html(stripslashes($_POST['video_url']))) : '';          
            $_playlist_url = (isset($_POST['playlist_url'])) ? trim(esc_html(stripslashes($_POST['playlist_url']))) : '';          
            $embed_type = (isset($_POST['embed_type'])) ? esc_html(stripslashes($_POST['embed_type'])) : '';
            
            $embed_id = $embed_type == 0 ? ytwd_get_youtube_embed_id($_video_url) : ($embed_type == 1 ? ytwd_get_youtube_embed_id($_playlist_url) : 0);
            $youtube_id = (isset($_POST['youtube_id'])) ? esc_html(stripslashes($_POST['youtube_id'])) : ''; 
            $channel_identifer = (isset($_POST['channel_identifer'])) ? esc_html(stripslashes($_POST['channel_identifer'])) : ''; 
            $is_valid = true;
        }        
        $_youtube_id = $embed_type == 0 || $embed_type == 1 ? $embed_id : $youtube_id;   
        if($is_valid == true){
			$protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
            $video_url = $protocol."://www.youtube.com/embed/";
            if($embed_type == 0){
                $video_url = $protocol."://www.youtube.com/embed/".$embed_id;
            }                
            else if($embed_type == 1){
                $params['listType'] = 'playlist';
                $params['list'] = $embed_id;                
            }
            else{
                
                if($channel_identifer == 0){
                    $params['listType'] =  'user_uploads';     
                }
                else{
                    $video_url .= "videoseries";
                    $youtube_id = "UU".substr($youtube_id,2);
                }
                $params['list'] = $youtube_id; 
            }
                
            $video_url =  add_query_arg($params, $video_url);

            $response["video_url"] = $video_url;
            if(ytwd_get_option("api_key")){
                $api_data = new YouTube_API_Data(); 
                $video_api_data =  $api_data->get_api_data_by_type($embed_type, $channel_identifer, $_youtube_id);               
                if($video_api_data["pageInfo"]["totalResults"] == 0){
                    $response["video_url"] = 'admin.php?page=ytwd_video_not_found';
                }
            }
        }
        else{
            $response["video_url"] = 'admin.php?page=ytwd_video_not_found';
        }

        echo json_encode($response);
        die();
  
    }
    

    
    public static function get_video_data(){
        $youtube_id = (isset($_POST['resource_id'])) ? esc_html(stripslashes($_POST['resource_id'])) : '';
        $id = (isset($_POST['id'])) ? esc_html(stripslashes($_POST['id'])) : '';
        $shortcode_id = (isset($_POST['shortcode_id'])) ? esc_html(stripslashes($_POST['shortcode_id'])) : '';
        if($youtube_id){
            global $wpdb;
            $api_data = new YouTube_API_Data();
            $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
            $iframe_video_youtube_url = $protocol."://www.youtube.com/watch?v=".$youtube_id;
            $embed_data = $api_data->get_api_data_by_type(0, 0, $youtube_id, true, false );
			$page_token = isset($_POST["nextPageToken"]) ? $_POST["nextPageToken"] : false;
			$max_results = isset($_POST["commentsCount"]) ? $_POST["commentsCount"] : 50;
            $comments = $api_data->get_video_comments($youtube_id, $page_token, $max_results);     
            $main_video_data = array( $iframe_video_youtube_url, $embed_data, $comments);
            $row = YTWD_DB::get_row_by_id($id, 'ytwd_youtube'); 
           
			require(YTWD_DIR . '/includes/admin/themes_ytwd.php');
			$theme = Themes_ytwd::theme_object();  
			if($row->embed_type != 2){
				$main_video_channel_data = $api_data->get_api_data_by_type(2, 1, $main_video_data[1]["items"][0]["snippet"]["channelId"]);
			}
			else{
				$main_video_channel_data = $embed_data;
			}			
         
            echo '<div class="ajax_data">';
            require(YTWD_DIR."/views/view_main_video_frontend.php");
            echo '</div>';
        }
        die();
    }
	public static function admin_filter(){
		$query = isset($_POST["query"]) && $_POST["query"] != "" ? $_POST["query"] : "";
		$type = isset($_POST["type"]) && $_POST["type"] != "" ? $_POST["type"] : "video";
		$response = array();
		if($query){
			$api_data = new YouTube_API_Data();	
			$result = $api_data->search_api_data($query, $type);
		}
		$id = $type == "video" ?  "videoId" : ($type == "playlist" ? "playlistId" : "channelId");

		if(isset($result["items"]) && count($result["items"]) > 0){
			foreach($result["items"] as $item){
				$published = $item["snippet"]["publishedAt"];
			    $published = substr($published, 0 , strpos($published,"T"));
				$response[] = array(
					"id" =>	$item["id"][$id],
					"title" =>	$item["snippet"]["title"],
					"description" =>	$item["snippet"]["description"],
					"thumbnail" =>	$item["snippet"]["thumbnails"]["default"]["url"],
					"published" =>	date("Y, F d", strtotime($published))
				);	
			}
		}
		
		echo json_encode($response);
		die();
		
			
	}	


    private static function get_params_from_db($id){

        $row = YTWD_DB::get_row_by_id($id, "ytwd_youtube");
         
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

        return $params;
    }
    private static function get_params_from_post(){
        $params = array();
        $params['autohide'] = (isset($_POST['autohide'])) ? esc_html(stripslashes($_POST['autohide'])) : '';
        $params['autoplay'] = (isset($_POST['autoplay'])) ? esc_html(stripslashes($_POST['autoplay'])) : '';
        $params['color'] = (isset($_POST['color'])) ? esc_html(stripslashes($_POST['color'])) : '';
        $params['theme'] = (isset($_POST['theme'])) ? esc_html(stripslashes($_POST['theme'])) : '';
        $params['controls'] = (isset($_POST['controls'])) ? esc_html(stripslashes($_POST['controls'])) : '';
        $params['fs'] = (isset($_POST['fs'])) ? esc_html(stripslashes($_POST['fs'])) : '';
        $params['loop'] = (isset($_POST['loop'])) ? esc_html(stripslashes($_POST['loop'])) : '';
        $params['iv_load_policy'] = (isset($_POST['iv_load_policy'])) ? esc_html(stripslashes($_POST['iv_load_policy'])) : '';
        $params['cc_load_policy'] = (isset($_POST['cc_load_policy'])) ? esc_html(stripslashes($_POST['cc_load_policy'])) : '';
        $params['playsinline'] = (isset($_POST['playsinline'])) ? esc_html(stripslashes($_POST['playsinline'])) : '';
        $params['wmode'] = (isset($_POST['wmode'])) ? esc_html(stripslashes($_POST['wmode'])) : '';
        $params['start'] = (isset($_POST['start'])) ? esc_html(stripslashes($_POST['start'])) : '';
        $params['end'] = (isset($_POST['end'])) ? esc_html(stripslashes($_POST['end'])) : '';
        $origin = (isset($_POST['origin'])) ? esc_html(stripslashes($_POST['origin'])) : '';
        $hl = (isset($_POST['hl'])) ? esc_html(stripslashes($_POST['hl'])) : '';
		$params['rel'] = 0;
        if($hl == 1){
            $params['hl'] = get_locale();
        }            
        $params['enablejsapi'] = '1';
        $params['version'] = '3';

        return $params;
    }    
 

}


?>