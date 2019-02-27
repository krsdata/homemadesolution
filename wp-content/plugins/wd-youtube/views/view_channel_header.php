<style>
	.ytwd_channel_data<?php echo $shortcode_id; ?>{
		background:#<?php echo $theme->channel_bgcolor; ?>;
	}
    .ytwd_channel_title<?php echo $shortcode_id; ?> , .ytwd_channel_title<?php echo $shortcode_id; ?> a {
        color: #<?php echo $theme->channel_header_title_color; ?>!important;
        font-size: <?php echo $theme->channel_header_title_font_size; ?>px!important;
        margin-bottom: 5px;
    }
    .ytwd_channel_desc<?php echo $shortcode_id; ?>{
        color: #<?php echo $theme->channel_header_desc_color; ?>;
        font-size: <?php echo $theme->channel_header_desc_font_size; ?>px;
		padding: 4px 10px 4px 6px;
    }
    .ytwd_channel_statistics<?php echo $shortcode_id; ?> span{
        color: #<?php echo $theme->channel_header_statistics_color; ?>;
        font-size: <?php echo $theme->channel_header_statistics_font_size; ?>px;
    }
    .ytwd_channel_banner<?php echo $shortcode_id; ?>{
		<?php if(in_array("banner", explode(",", $row->channel_additional_info)) && $row->embed_type == 2 ){ ?>		
		background-image: url(<?php echo $embed_data["items"][0]["brandingSettings"]["image"]["bannerTabletHdImageUrl"];?>);
		<?php 
		}
		if(in_array("banner", explode(",", $row->channel_additional_info)) || in_array("logo", explode(",", $row->channel_additional_info))) { ?>
			margin: 10px 0px; 
			height: 145px;			
		<?php } ?>		
	} 
	.ytwd_videos_count<?php echo $shortcode_id; ?>{
		color: #<?php echo $theme->playlist_header_videos_count_color; ?>;
		font-size: <?php echo $theme->playlist_header_videos_count_font_size; ?>px;
		text-align: center;
		margin-top: 5px;		
	}
	.ytwd_playlist_published_at<?php echo $shortcode_id; ?>{
		color: #<?php echo $theme->playlist_header_pub_color; ?>;
		font-size: <?php echo $theme->playlist_header_pub_font_size; ?>px;
	}	
	.ytwd_playlist_data<?php echo $shortcode_id; ?>{
		background: #<?php echo $theme->playlist_header_bgcolor; ?>;
		padding: <?php echo $theme->playlist_header_padding_top; ?>px <?php echo $theme->playlist_header_padding_right; ?>px <?php echo $theme->playlist_header_padding_bottom; ?>px <?php echo $theme->playlist_header_padding_left; ?>px;
	}
	.ytwd_playlist_data<?php echo $shortcode_id; ?> .ytwd_channel_info_cell:last-child{
		width: 120px;
	}
</style>

<div class="ytwd_channel_header_wrapper ytwd_channel_header_wrapper<?php echo $shortcode_id; ?>">
	
	<?php if($row->embed_type == 2){ ?>
		<div class="ytwd_channel_data<?php echo $shortcode_id; ?>">
			<div class="ytwd_channel_banner ytwd_channel_banner<?php echo $shortcode_id; ?>">
				<?php if(in_array("logo", explode(",", $row->channel_additional_info)) ){ ?>
					<a href="<?php echo 'https://www.youtube.com/channel/'.$embed_data["items"][0]["id"]; ?>" class="ytwd_channel_logo" target="_blank">
						<img src="<?php echo $embed_data["items"][0]["snippet"]["thumbnails"]["default"]["url"]; ?>" >
					</a>
				<?php
				}
				?>
			</div>
			<div class="ytwd_channel_statistics ytwd_channel_statistics<?php echo $shortcode_id; ?>">
				<?php if(in_array("videos_count", explode(",", $row->channel_additional_info)) ){ ?>
				<span>
					<i class="fa fa-youtube-play" title="<?php _e("Videos Count", "ytwd"); ?>"></i>
					<?php echo $embed_data["items"][0]["statistics"]["videoCount"] ? ytwd_number_shorten($embed_data["items"][0]["statistics"]["videoCount"]) : "0"; ?>
				</span>
				<?php
				}
				if(in_array("subscribers_count", explode(",", $row->channel_additional_info)) ){ ?>                    
				<span>
					<i class="fa fa-user" title="<?php _e("Subscribers", "ytwd"); ?>"></i>
					<?php echo $embed_data["items"][0]["statistics"]["subscriberCount"] ? ytwd_number_shorten($embed_data["items"][0]["statistics"]["subscriberCount"]) : "0"; ?>
				</span>
				 <?php
				}
				if(in_array("views_count", explode(",", $row->channel_additional_info)) ){ ?>                 
				<span>
					<i class="fa fa-eye" title="<?php _e("Views", "ytwd"); ?>"></i>
					<?php echo $embed_data["items"][0]["statistics"]["viewCount"] ? ytwd_number_shorten($embed_data["items"][0]["statistics"]["viewCount"]) : "0"; ?>
				</span> 
				<?php
				}
				?>
			</div>		
			<div class="ytwd_channel_info ytwd_channel_info_table">
				<div class="ytwd_channel_info_cell">
					<?php if(in_array("title", explode(",", $row->channel_additional_info)) ){ ?>
						<div class="ytwd_channel_title ytwd_channel_title<?php echo $shortcode_id; ?>">
							<?php if($row->enable_youtube_link_channel == 1){ ?>
								<a href="<?php echo 'https://www.youtube.com/channel/'.$embed_data["items"][0]["id"]; ?>" target="_blank"><?php echo $embed_data["items"][0]["snippet"]["title"]; ?></a>
							<?php } 
								else{ 
									echo $embed_data["items"][0]["snippet"]["title"];
								}	
							?>
							
						</div>
					<?php
					}
					?>               
				</div>
				
				<div class="ytwd_channel_info_cell">
					<div class="ytwd_channel_subscribe_btn">
					   <?php if(in_array("subscribe_button", explode(",", $row->channel_additional_info))){
							$type = $row->channel_identifer == 0 ? "channel" : "channelid";
							
						?>
							<div class="ytwd_subscripe_wrapper">
								<div class="g-ytsubscribe" data-<?php echo $type; ?>="<?php echo $row->youtube_id; ?>" data-layout="default" data-count="default" ></div>
							</div>
						<?php
						}
						?>                                    
					</div>
				</div> 
			</div>
			<?php  if(in_array("desc", explode(",", $row->channel_additional_info)) && $embed_data["items"][0]["snippet"]["description"]){ ?>
					<div class="ytwd_channel_desc ytwd_channel_desc<?php echo $shortcode_id; ?>">
						<?php echo $embed_data["items"][0]["snippet"]["description"]; ?>
					</div>
			<?php
			}
			?>
		</div>
	<?php	
	}

    else { 
		if($row->channel_additional_info){	
    ?>
        <div class="ytwd_channel_info ytwd_playlist_data<?php echo $shortcode_id; ?>">
            <div class="ytwd_channel_info_cell">
                <?php if(in_array("title", explode(",", $row->channel_additional_info)) ){ ?>
                    <div class="ytwd_channel_title ytwd_channel_title<?php echo $shortcode_id; ?>">
						<?php if($row->enable_youtube_link_playlist == 1){ ?>
							<a href="https://www.youtube.com/playlist?list=<?php echo $row->embed_id;?>" target="_blank"><?php echo $embed_data["items"][0]["snippet"]["title"]; ?></a>
						<?php } 
							else{ 
								echo $embed_data["items"][0]["snippet"]["title"];
							}	
						?>
						
                    </div>				
                <?php
                }	
				if(in_array("published_at", explode(",", $row->channel_additional_info)) ){ 
					$published_at = substr( $embed_data["items"][0]["snippet"]["publishedAt"], 0 , strpos( $embed_data["items"][0]["snippet"]["publishedAt"],"T"));
					$published_at = date("Y, F d", strtotime($published_at));
					?>
						<div class="ytwd_playlist_published_at<?php echo $shortcode_id; ?>">
							<?php echo __("Published", "ytwd"). " ". $published_at; ?>
						</div>
					<?php
				}				
					
                if(in_array("desc", explode(",", $row->channel_additional_info)) && $embed_data["items"][0]["snippet"]["description"]){ ?>
                    <div class="ytwd_channel_desc ytwd_channel_desc<?php echo $shortcode_id; ?>">
                        <?php echo $embed_data["items"][0]["snippet"]["description"]; ?>
                    </div>
                <?php
                }
                ?>				
				<div>
					<?php
					if(in_array("subscribe_button", explode(",", $row->channel_additional_info))){
						$type = $row->channel_identifer == 0 ? "user" : "channel";
					?>	
						<div class="g-ytsubscribe" data-channelid="<?php echo $embed_data["items"][0]["snippet"]["channelId"]; ?>" data-layout="full" data-count="default"></div>&nbsp;&nbsp;
					<?php
					} 					
					?>	
				</div>
                                
            </div>
            <div class="ytwd_channel_info_cell">
                <?php if(in_array("logo", explode(",", $row->channel_additional_info)) ){ ?>
                    <img src="<?php echo $embed_data["items"][0]["snippet"]["thumbnails"]["default"]["url"]; ?>">
                <?php
                }
				if(in_array("videos_count", explode(",", $row->channel_additional_info)) ){ ?>
					<div class="ytwd_videos_count<?php echo $shortcode_id; ?>">
						<?php echo $embed_data["items"][0]["contentDetails"]["itemCount"]." " . __("videos", "ytwd"); ?>
					</div>
				<?php
				}				
				?>				
            </div> 
        </div>     
    <?php
		}
    }
    ?>      
</div>



