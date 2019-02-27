<?php
function ytwd_create_tables(){
    global $wpdb;

    $ytwd_youtube = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "ytwd_youtube` (
        `id`                              INT(17) 	   NOT NULL AUTO_INCREMENT,
        `title`                           VARCHAR(255) NOT NULL,
        `embed_type`                      TINYINT(1)   NOT NULL,
        `video_url`                       VARCHAR(255) NOT NULL,
        `playlist_url`                    VARCHAR(255) NOT NULL,
        `channel_identifer`               TINYINT(1)   NOT NULL,
        `youtube_id`                      VARCHAR(255) NOT NULL,
        `width`                           VARCHAR(255) NOT NULL,
        `width_unit`                      VARCHAR(7)   NOT NULL,
        `auto_height`                     TINYINT(1)   NOT NULL,		
        `height`                          VARCHAR(255) NOT NULL,
        `player_aligment`                 TINYINT(1)   NOT NULL, 
        `autohide`                        TINYINT(1)   NOT NULL,
        `autoplay`                        TINYINT(1)   NOT NULL,
        `color`                           VARCHAR(255) NOT NULL,
        `theme`                           VARCHAR(255) NOT NULL,
        `controls`                        TINYINT(1)   NOT NULL,
        `fs`                              TINYINT(1)   NOT NULL,
        `loop`                            TINYINT(1)   NOT NULL,
        `rel`                             TINYINT(1)   NOT NULL,
        `showinfo`                        TINYINT(1)   NOT NULL,
        `disablekb`                       TINYINT(1)   NOT NULL,
        `iv_load_policy`                  TINYINT(1)   NOT NULL,
        `modestbranding`                  TINYINT(1)   NOT NULL,
        `hl`                              TINYINT(1)   NOT NULL,
        `cc_load_policy`                  TINYINT(1)   NOT NULL,
        `playsinline`                     TINYINT(1)   NOT NULL,
        `origin`                          TINYINT(1)   NOT NULL,
        `wmode`                           VARCHAR(255) NOT NULL,
        `start`                           VARCHAR(255) NOT NULL,
        `end`                             VARCHAR(255) NOT NULL,
        `initial_volume`                  VARCHAR(255) NOT NULL,

        `enable_gallery`                  TINYINT(1)   NOT NULL,
        `gallery_items_count`             INT(17)      NOT NULL,
        `gallery_display_type`            TINYINT(1)   NOT NULL,
        `prev_btn_text`                   VARCHAR(255) NOT NULL,
        `next_btn_text`                   VARCHAR(255) NOT NULL,
        `gallery_order`                   VARCHAR(255) NOT NULL,
        `gallery_order_dir`               VARCHAR(255) NOT NULL,
        `enable_search`                   TINYINT(1)   NOT NULL,
        `gallery_view_type`               VARCHAR(255) NOT NULL,
        `gallery_position`                TINYINT(1)   NOT NULL,
        `thumbnails_column_number`        INT(17)      NOT NULL,
        `carousel_items_count`       	  INT(17)      NOT NULL,
        `gallery_video_display_mode`      TINYINT(1)   NOT NULL,
        `gallery_additional_info`         VARCHAR(255) NOT NULL,
        `desc_max_lenght`                 VARCHAR(27)  NOT NULL,
        `single_line_title`               TINYINT(1)   NOT NULL,
        `gallery_thumb_custom_size`       VARCHAR(255) NOT NULL,
        `loading_effects`                 VARCHAR(255) NOT NULL,
        `video_quality`                   VARCHAR(255) NOT NULL,
        `video_additional_info`           VARCHAR(255) NOT NULL,
        `enable_share_btns`               TINYINT(1)   NOT NULL,
        `enable_youtube_link`             TINYINT(1)   NOT NULL,
        `enable_youtube_link_channel`     TINYINT(1)   NOT NULL,
        `enable_youtube_link_playlist`    TINYINT(1)   NOT NULL,
        `show_video_info_by_default`      TINYINT(1)   NOT NULL,
        `channel_additional_info`         VARCHAR(255) NOT NULL,
        `comments_count`                  INT(15)      NOT NULL,

        `theme_id`                        INT(17) 	   NOT NULL,
        `shortcode_id`                    INT(17) 	   NOT NULL,
        `published`      				  TINYINT(1)   NOT NULL,

        PRIMARY KEY (`id`)
        ) DEFAULT CHARSET=utf8;";
    $wpdb->query($ytwd_youtube);


    $ytwd_shortcodes = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "ytwd_shortcodes` (
        `id`            INT(17) 	 NOT NULL AUTO_INCREMENT,
        `tag_text`      LONGTEXT     NOT NULL,

        PRIMARY KEY (`id`)
        ) DEFAULT CHARSET=utf8;";
    $wpdb->query($ytwd_shortcodes);



    $settings = get_option("ytwd_settings");
    if(!$settings){
        $data = array();
        $data["api_key"] = '';
        $data["video_seo_tags"] = 0;
        $data["show_deleted_videos"] = 0;
        $json_data = json_encode($data);
        add_option("ytwd_settings", $json_data, '', 'no');
    }

}

function ytwd_insert_tables(){
	global $wpdb;
	if(!get_option("ytwd_version")){
		$query = "INSERT INTO `" . $wpdb->prefix . "ytwd_youtube` (`id`, `title`, `embed_type`, `video_url`, `playlist_url`, `channel_identifer`, `youtube_id`, `width`, `width_unit`, `height`, `player_aligment`, `autohide`, `autoplay`, `color`, `theme`, `controls`, `fs`, `loop`, `rel`, `showinfo`, `disablekb`, `iv_load_policy`, `modestbranding`, `hl`, `cc_load_policy`, `playsinline`, `origin`, `wmode`, `start`, `end`, `initial_volume`, `enable_gallery`, `gallery_items_count`, `gallery_display_type`, `prev_btn_text`, `next_btn_text`, `gallery_order`, `gallery_order_dir`, `enable_search`, `gallery_view_type`, `gallery_position`, `thumbnails_column_number`, `carousel_items_count`, `gallery_video_display_mode`, `gallery_additional_info`, `desc_max_lenght`, `single_line_title`, `gallery_thumb_custom_size`, `loading_effects`, `video_quality`, `video_additional_info`, `enable_share_btns`, `enable_youtube_link`, `enable_youtube_link_channel`, `enable_youtube_link_playlist`, `show_video_info_by_default`, `channel_additional_info`, `comments_count`, `theme_id`, `shortcode_id`, `published`, `auto_height`) VALUES
		('', 'How to Get API Key for YouTube WD Plugin', 0, 'https://www.youtube.com/watch?v=RQxtFfapyO0', '', 0, '', '100', '%', '400', 1, 1, 0, 'red', '', 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 'opaque', '0', '0', '50', 0, 12, 0, 'Prev', 'Next', '', '', 0, 'thumbnails', 0, 3, 0, 0, 'title', '', 0, '100', 'none', 'default', '', 0, 0, 0, 0, 0, '', 0, 0, 1, 1, 1)";
		$wpdb->query($query);
		$wpdb->query("INSERT INTO `" . $wpdb->prefix . "ytwd_shortcodes` VALUES('', 'id=1 item=1')");
	}

}
?>
