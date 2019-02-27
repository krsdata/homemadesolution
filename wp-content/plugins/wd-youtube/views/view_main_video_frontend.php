<?php 
$video_data = $main_video_data[1];
$iframe_video_youtube_url = $main_video_data[0];
$comments = $main_video_data[2];
$comment_next_page_token = isset($comments["nextPageToken"]) ? $comments["nextPageToken"] : false;
$likes = isset($video_data["items"]) ? $video_data["items"][0]["statistics"]["likeCount"] : 0;
$dislikes = isset($video_data["items"]) ? $video_data["items"][0]["statistics"]["dislikeCount"] : 0;
if($likes == 0 && $dislikes == 0){
    $likes_percentage = $dislikes_percentage = 0;
}
else{
    $likes_percentage = ($likes / ($likes + $dislikes)) * 100; 
    $dislikes_percentage = ($dislikes / ($likes + $dislikes)) * 100;
} 


?>   
<div class="ytwd_main_video_info ytwd_main_video_info<?php echo $shortcode_id; ?>">
	<img src="<?php echo YTWD_URL.'/assets/loader.png'; ?>"  width="20px" class="main_video_loder main_video_loder<?php echo $shortcode_id; ?> ytwd_loader">
    <?php if(in_array("title", explode("," ,$row->video_additional_info))){ ?>
        <div class="ytwd_video_title ytwd_video_title<?php echo $shortcode_id; ?>">
			<?php if($row->enable_youtube_link == 1){ ?>
				<a href="<?php echo $iframe_video_youtube_url; ?>" target="_blank"><?php echo $video_data["items"][0]["snippet"]["title"]; ?></a>
			<?php } 
				else{ 
					echo $video_data["items"][0]["snippet"]["title"];
				}	
			?>		
        </div>
    <?php
    }
    if($row->enable_share_btns == 1){
    ?> 
        <div class="ytwd_share_btns ytwd_share_btns<?php echo $shortcode_id; ?>">
            <a id="ytwd_facebook_share" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($iframe_video_youtube_url);?>" target="_blank" title="<?php echo __('Share on Facebook', 'ytwd'); ?>">
                <i title="<?php echo __('Share on Facebook', 'ytwd'); ?>" class="ytwd_share fa fa-facebook"></i>
            </a> 
         
            <a id="ytwd_twitter_share" href="https://twitter.com/home?status=<?php echo urlencode($iframe_video_youtube_url);?>" target="_blank" title="<?php echo __('Share on Twitter', 'ytwd'); ?>">
                <i title="<?php echo __('Share on Twitter', 'ytwd'); ?>" class="ytwd_share fa fa-twitter"></i>
            </a>
            <a id="ytwd_google_share" href="https://plus.google.com/share?url=<?php echo urlencode($iframe_video_youtube_url);?>" target="_blank" title=" <?php echo __('Share on Google+', 'ytwd'); ?>">
                <i title="<?php echo __('Share on Google+', 'ytwd'); ?>" class="ytwd_share fa fa-google-plus"></i>
            </a>
            <a id="ytwd_linkedin_share" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($iframe_video_youtube_url);?>" target="_blank" title=" <?php echo __('Share on Linkedin', 'ytwd'); ?>">
                <i title="<?php echo __('Share on Linkedin', 'ytwd'); ?>" class="ytwd_share fa fa-linkedin"></i>
            </a>
          
            <a id="ytwd_pinterest_share" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($iframe_video_youtube_url);?>" target="_blank" title="<?php echo __('Share on Pinterest', 'ytwd'); ?>">
                <i title="<?php echo __('Share on Pinterest', 'ytwd'); ?>" class="ytwd_share fa fa-pinterest"></i>
            </a>
            <a id="ytwd_tumblr_share" href="https://www.tumblr.com/share/link?url=<?php echo urlencode($iframe_video_youtube_url);?>" target="_blank" title="<?php echo __('Share on Tumblr', 'ytwd'); ?>">
                <i title="<?php echo __('Share on Tumblr', 'ytwd'); ?>" class="ytwd_share fa fa-tumblr"></i>
            </a> 
        </div>    
    <?php
    }
    ?>               
    <div class="ytwd_video_statistics ytwd_video_statistics<?php echo $shortcode_id; ?>">
    
		<div class="ytwd_main_video_channel_data ytwd_main_video_channel_data<?php echo $shortcode_id; ?>">
			<div class="ytwd_main_video_channel_title_subscripe">
				<?php
				if(in_array("subscribe_btn", explode("," ,$row->video_additional_info))){ ?>
					<div class="ytwd_main_video_subscripe_wrapper">
						<div class="g-ytsubscribe" data-channelId="<?php echo $video_data["items"][0]["snippet"]["channelId"]; ?>" data-layout="default" data-count="default" data-theme="default"></div>    
					</div>
				<?php
				}
				?> 
			</div>
		</div>
 
        <div class="ytwd_main_video_statistics">    
            <?php if(in_array("views_count", explode("," ,$row->video_additional_info))){ ?>
                <div class="ytwd_video_view_counts ytwd_video_view_counts<?php echo $shortcode_id; ?>">
                    <span><?php echo number_format($video_data["items"][0]["statistics"]["viewCount"], 0 ,".",",")." ".__("views", "ytwd"); ?></span> 
                </div>
            <?php
            }
            ?>
            <div class="ytwd_likes_dislikes<?php echo $shortcode_id; ?>">
                <?php                  
                    if(in_array("likes", explode("," ,$row->video_additional_info)) && isset($video_data["items"][0]["statistics"]["likeCount"])){ ?>
                        <i class="fa fa-thumbs-up" title="<?php _e("Likes Count", "ytwd"); ?>"></i>
                        <?php echo number_format($video_data["items"][0]["statistics"]["likeCount"], 0 ,".",",");
                        echo "&nbsp;&nbsp;&nbsp;";
                    }
                    if(in_array("dislikes", explode("," ,$row->video_additional_info)) && isset($video_data["items"][0]["statistics"]["dislikeCount"])){ ?>
                        <i class="fa fa-thumbs-down" title="<?php _e("Dislikes Count", "ytwd"); ?>"></i>
                        <?php echo number_format($video_data["items"][0]["statistics"]["dislikeCount"], 0 ,".",",");
                    }                    
                ?>
            </div>   
        </div>   
    </div>
    <?php  
        if(isset($video_data["items"])){
            $published_at = substr($video_data["items"][0]["snippet"]["publishedAt"], 0 , strpos($video_data["items"][0]["snippet"]["publishedAt"],"T"));
            $published_at = date("Y, F d", strtotime($published_at));
        }
        else{
            $published_at = "";
        }
    ?>
    <?php 
	if(in_array("desc", explode("," ,$row->video_additional_info)) || in_array("published_at", explode("," ,$row->video_additional_info)) || in_array("comments", explode("," ,$row->video_additional_info))){ 
		if((isset($_POST["action"]) && $_POST["action"] != "get_video_data") || !isset($_POST["action"])){
		?>
			<div class="ytwd_show_more_divaider">
				<div class="ytwd_short_more_info ytwd_short_more_info<?php echo $shortcode_id; ?>" <?php echo (!isset($_POST["action"]) || (isset($_POST["action"]) && $_POST["action"] != "get_video_data")) && $row->show_video_info_by_default == 1 ? 'style="display:none;"' : ""; ?>>
					<?php if(in_array("published_at", explode("," ,$row->video_additional_info))){ ?>
						<div class="ytwd_video_published_at<?php echo $shortcode_id; ?>">
							<?php echo __("Published at", "ytwd")." ".$published_at; ?> 
						</div>
					<?php
					}
					if(in_array("desc", explode("," ,$row->video_additional_info))){ ?>
						<div class="ytwd_video_description<?php echo $shortcode_id; ?> ytwd_video_description" >
							<?php echo nl2br(substr($video_data["items"][0]["snippet"]["description"], 0, 100)); ?> 
						</div>
					<?php
					}
					?>		
				</div>			
				<div class="ytwd_load_toggle ytwd_load_toggle<?php echo $shortcode_id; ?>"><?php echo $row->show_video_info_by_default == 0 ?  __("Show More", "ytwd") : __("Show Less", "ytwd"); ?></div>
			</div>	
		<?php
		}
    }
    ?>
    <div class="ytwd_more_info ytwd_more_info<?php echo $shortcode_id; ?>" <?php echo (!isset($_POST["action"]) || (isset($_POST["action"]) && $_POST["action"] != "get_video_data")) && $row->show_video_info_by_default == 0 ? 'style="display:none;"' : ""; ?>>            
        <?php if(in_array("published_at", explode("," ,$row->video_additional_info))){ ?>
            <div class="ytwd_video_published_at<?php echo $shortcode_id; ?>">
                <?php echo __("Published at", "ytwd")." ".$published_at; ?> 
            </div>
        <?php
        }
        if(in_array("desc", explode("," ,$row->video_additional_info))){ ?>
            <div class="ytwd_video_description<?php echo $shortcode_id; ?> ytwd_video_description" >
                <?php echo nl2br($video_data["items"][0]["snippet"]["description"]); ?> 
            </div>
        <?php
        }
		?>
    </div>
</div>
<style>
	.ytwd_main_video_info<?php echo $shortcode_id; ?>{
		background: #<?php echo $theme->main_bgcolor; ?>;
		<?php if( $theme->main_padding){ ?>
			padding: <?php echo $theme->main_padding; ?>px;
		<?php } ?>
	}
    .ytwd_video_title<?php echo $shortcode_id; ?> , .ytwd_video_title<?php echo $shortcode_id; ?> a{
        color: #<?php echo $theme->main_title_color; ?> !important;
        font-size: <?php echo $theme->main_title_font_size; ?>px !important;
        margin: 15px 0px;        
    }
	.ytwd_video_title<?php echo $shortcode_id; ?> a:hover{
		color: #<?php echo $theme->main_title_color_hover; ?>!important;
	}
	
    .ytwd_share_btns<?php echo $shortcode_id; ?>{
        margin: 5px 0px;
     }
    .ytwd_share_btns<?php echo $shortcode_id; ?> a{
        color: #<?php echo $theme->main_share_btns_color; ?>!important;
        font-size: <?php echo $theme->main_share_btns_size; ?>px;
        text-decoration: none !important;
        border-bottom: none !important;
    } 
   .ytwd_share_btns<?php echo $shortcode_id; ?> a:hover{
        opacity: 0.7;
        text-decoration: none !important;
    }
    .ytwd_video_view_counts<?php echo $shortcode_id; ?>{
        color: #<?php echo $theme->main_views_color; ?>;
        font-size: <?php echo $theme->main_views_font_size; ?>px;
    }   
    .ytwd_likes_dislikes<?php echo $shortcode_id; ?>{
        color: #<?php echo $theme->main_likes_color; ?>;
        font-size: <?php echo $theme->main_likes_font_size; ?>px;
        clear: both;
    }
    .ytwd_video_published_at<?php echo $shortcode_id; ?>{
        color: #<?php echo $theme->main_published_at_color; ?>;
        font-size: <?php echo $theme->main_published_at_font_size; ?>px;
        margin-bottom: 10px;
    }
    .ytwd_video_description<?php echo $shortcode_id; ?>{
        color: #<?php echo $theme->main_desc_color; ?>;
        font-size: <?php echo $theme->main_desc_font_size; ?>px;
        margin: 15px 0px;
    } 

    .ytwd_main_video_channel_title<?php echo $shortcode_id; ?> a{
        color: #<?php echo $theme->main_channel_title_color; ?> !important;
        font-size: <?php echo $theme->main_channel_title_font_size; ?>px !important;
    }
	
</style>

