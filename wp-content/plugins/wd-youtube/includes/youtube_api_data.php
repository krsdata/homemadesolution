<?php

class YouTube_API_Data {

    public function get_api_data_by_type($embed_type, $channel_identifer, $youtube_id, $statistics = false, $contentDetails = false,  $brandingSettings = false){
        $atts = array();
        if($embed_type == 0){
            $type = 'videos';
            $by_id = true;
        }
        else if($embed_type == 1){
            $type = 'playlists';
            $by_id = true;
        }
        else{
            $type = 'channels';
            $by_id = $channel_identifer == 0 ? false : true;
        }

        $url = 'https://www.googleapis.com/youtube/v3/'.$type;
        $atts["part"] = 'snippet';
        if($statistics == true){
            $atts["part"] .= ',statistics';
        }
        if($contentDetails == true){
            $atts["part"] .= ',contentDetails';
        }
        if($brandingSettings == true){
            $atts["part"] .= ',brandingSettings';
        }
        if($by_id == true){
            $atts["id"] = $youtube_id;
        }
        else{
            $atts["forUsername"] = $youtube_id;
        }
        $atts["key"] = ytwd_get_option("api_key");

        $api_url = add_query_arg($atts, $url);
        $data = $this->get_remote_data($api_url);

        return $data;

    }
    public function search_api_data($query, $type = "video"){
        $atts = array();
        $url = 'https://www.googleapis.com/youtube/v3/search';

        $atts["part"] = 'snippet';
        $atts["maxResults"] = 50;
        $atts["q"] = $query;
        $atts["type"] = $type;

        $atts["key"] = ytwd_get_option("api_key");

        $api_url = add_query_arg($atts, $url);
        $data = $this->get_remote_data($api_url);
        return $data;
    }

    public function get_channel_api_data($channel_identifer, $youtube_id, $page_token ){

        if($channel_identifer == 0){
            $channel_api_data = $this->get_api_data_by_type(2, $channel_identifer, $youtube_id);
            $channel_id = isset($channel_api_data["items"][0]["id"]) ? $channel_api_data["items"][0]["id"] : 0;
        }
        else{
            $channel_id = $youtube_id;
        }
		
		$channel_id = "UU".substr($channel_id,2);
		
        if($page_token != false && $page_token != 1){
            $atts["pageToken"] = urlencode($page_token);
        }
		$data = $this->get_playlist_api_data($channel_id, $page_token);

        return $data;
    }

    public function get_playlist_api_data($youtube_id, $page_token){
        $atts = array();
        $url = 'https://www.googleapis.com/youtube/v3/playlistItems';
        $atts["part"] = 'snippet,contentDetails';
        $atts["maxResults"] = 50;
        $atts["playlistId"] = $youtube_id;

        if($page_token != false && $page_token != 1){
            $atts["pageToken"] = urlencode($page_token);
        }
        $atts["key"] = ytwd_get_option("api_key");

        $api_url = add_query_arg($atts, $url);

        $data = $this->get_remote_data($api_url);

        return $data;
    }


   public function get_video_comments($youtube_id, $page_token = false, $max_results = 50){
        $url = 'https://www.googleapis.com/youtube/v3/commentThreads';
        $atts["part"] = 'id,snippet,replies';
        $atts["videoId"] = $youtube_id;
        $atts["maxResults"] = $max_results;
        $atts["key"] = ytwd_get_option("api_key");
        if($page_token != false){
            $atts["pageToken"] = urlencode($page_token);
        }
        $api_url = add_query_arg($atts, $url);
        $data = $this->get_remote_data($api_url);

        return $data;
   }

    private function get_remote_data($url){
        $response = wp_remote_get($url);
        if(!is_wp_error($response) || wp_remote_retrieve_response_code($response) === 200){
            $data = json_decode($response['body'], true);
        }
        else{
            $data = false;
        }

        return $data;
    }


}


?>
