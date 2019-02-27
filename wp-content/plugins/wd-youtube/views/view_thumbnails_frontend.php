
<div class="ytwd_gallery ytwd_gallery<?php echo $shortcode_id; ?>">

    <div class="ytwd_thumbnails ytwd_items<?php echo $shortcode_id; ?>" id="ytwd_thumbnails<?php echo $shortcode_id; ?>">
        <?php
            for($i=0; $i<count($items_data); $i++){
                $item = $items_data[$i];
         ?>
                <div class="ytwd_gallery_item ytwd_gallery_item<?php echo $shortcode_id; ?>" <?php if(ytwd_get_option("video_seo_tags") == 1) { ?> itemprop="video" itemscope itemtype="http://schema.org/VideoObject" <?php } ?> >
					<div class="ytwd_gallery_item_inner ytwd_gallery_item_inner<?php echo $shortcode_id; ?>">
						<div class="ytwd_gallery_item_0<?php echo $shortcode_id; ?>" >
							<div class="ytwd_item" data-url="<?php echo $item["video_url"]; ?>" data-current="<?php echo $i; ?>" data-resource-id="<?php echo $item["resource_id"]; ?>">
								<a href="<?php echo $row->gallery_video_display_mode == 3 ? 'https://www.youtube.com/watch?v='.$item["resource_id"] : '#'; ?>" onclick="<?php echo $row->gallery_video_display_mode != 3 ? 'return false;' : ''; ?>" <?php echo $row->gallery_video_display_mode == 3 ? 'target="_blank"' : ''; ?>>
									<div class="ytwd_items_img ytwd_items_img<?php echo $shortcode_id; ?>" style="background-image:url(<?php echo $item["thumb_url"]; ?>)" <?php echo ytwd_get_option("video_seo_tags") == 1 ? 'itemprop="thumbnailUrl"'  : ""; ?>></div>
									<img src="<?php echo YTWD_URL; ?>/assets/play.png" class="ytwd_play">
									<?php if(in_array("duration", explode("," ,$row->gallery_additional_info))) { ?>
										<div class="ytwd_duration"><?php echo $item["duration"]; ?></div>
									<?php
									}
									?>
								</a>
							</div>
						</div>							
						<div class="ytwd_gallery_item_p_1">
							<?php if(ytwd_get_option("video_seo_tags") == 1){ ?>
								<meta itemprop="name" content="<?php echo $item["title"]; ?>" />
								<meta itemprop="description" content="<?php echo $item["description"]; ?>" />
								<meta itemprop="thumbnailUrl" content="<?php echo $item["thumb_url"]; ?>" />
								<meta itemprop="embedURL" content="<?php echo $item["video_url"]; ?>" />
								<meta itemprop="uploadDate" content="<?php echo $item["published_at"]; ?>" />
								<meta itemprop="height" content="<?php echo $row->height; ?>" />
								<meta itemprop="width" content="<?php echo $row->width; ?>" />
							<?php
							}

							if(in_array("title", explode("," ,$row->gallery_additional_info)) && $item["title"]) { ?>
								<div class="ytwd_item_title ytwd_item_title<?php echo $shortcode_id; ?>"
								<?php echo ytwd_get_option("video_seo_tags") == 1 ? 'itemprop="name"' : ""; ?> >
									<?php echo $item["title"]; ?>
								</div>
							<?php
							}
							if(in_array("published_at", explode("," ,$row->gallery_additional_info)) && $item["published_at"]) { ?>
								<div class="ytwd_item_pub_at ytwd_item_pub_at<?php echo $shortcode_id; ?>"
								<?php echo ytwd_get_option("video_seo_tags") == 1 ? 'itemprop="uploadDate"'  : ""; ?>>
									<?php echo $item["published_at"]; ?>
								</div>
							<?php
							}						
							if(in_array("desc", explode("," ,$row->gallery_additional_info))) {
							?>
								<div class="ytwd_item_desc ytwd_item_desc<?php echo $shortcode_id; ?>" <?php echo ytwd_get_option("video_seo_tags") == 1 ? 'itemprop="description"'  : ""; ?>>
									<?php	echo ($row->desc_max_lenght && strlen($item["description"])> $row->desc_max_lenght) ? substr($item["description"] , 0, $row->desc_max_lenght).'...' : $item["description"]; ?>
								</div>
							<?php
							}
							?>
						</div>
					</div>

                </div>
        <?php
        }
        ?>
    </div>
</div>
<style>
	.ytwd_gallery_container<?php echo $shortcode_id; ?>{
		background: #<?php echo $theme->thumbnails_bgcolor; ?>;  		
	}
    .ytwd_gallery<?php echo $shortcode_id; ?>{
       /* max-width: <?php echo $row->thumbnails_column_number * (($theme->thumbnails_shape == 0 ? $thumb_width : $thumb_height) + 2 * (2 + $theme->thumbnails_border_width + 5) + $row->thumbnails_column_number*30); ?>px;*/	
	}

    .ytwd_gallery<?php echo $shortcode_id; ?> .ytwd_gallery_item<?php echo $shortcode_id; ?>{
        min-width: <?php echo  $thumb_width  ; ?>px;
		width: <?php echo $row->thumbnails_column_number ? 100/$row->thumbnails_column_number : 100 ;?>%;
        display: block;
        opacity: 1;
		float: left;		

    }
	.ytwd_gallery<?php echo $shortcode_id; ?> .ytwd_gallery_item<?php echo $shortcode_id; ?> .ytwd_gallery_item_inner<?php echo $shortcode_id; ?>{
		<?php if ($theme->thumbnails_box_shadow) {
			echo 'box-shadow: '.$theme->thumbnails_box_shadow.';';
		}
		?>
		background: #<?php echo $theme->thumbnails_video_info_bgcolor; ?>;
	}	
	.ytwd_gallery_item<?php echo $shortcode_id; ?> .ytwd_gallery_item_p_1{
		padding: <?php echo $theme->thumbnails_padding_top; ?>px <?php echo $theme->thumbnails_padding_right; ?>px 0px <?php echo $theme->thumbnails_padding_left; ?>px;
				
	}
	.ytwd_gallery_item<?php echo $shortcode_id; ?> .ytwd_gallery_item_p_2{
		padding: 0px <?php echo $theme->thumbnails_padding_right; ?>px <?php echo $theme->thumbnails_padding_bottom; ?>px <?php echo $theme->thumbnails_padding_left; ?>px;		
	}
	
    .ytwd_gallery<?php echo $shortcode_id; ?> .ytwd_gallery_item<?php echo $shortcode_id; ?> .ytwd_items_img<?php echo $shortcode_id; ?>{
        width: 100%;
		<?php if($theme->thumbnails_border_style != "none" || $theme->thumbnails_hover_border_style != "none" )	{?>
			border-width: <?php echo $theme->thumbnails_border_style != "none" ? $theme->thumbnails_border_width : $theme->thumbnails_hover_border_width; ?>px;
			border-style: <?php echo $theme->thumbnails_border_style != "none" ? $theme->thumbnails_border_style : $theme->thumbnails_hover_border_style; ?>;
			border-color: <?php echo $theme->thumbnails_border_style != "none" ? "#".$theme->thumbnails_border_color : "transparent"; ?>;
		<?php } ?>
       
        border-radius: <?php echo  $theme->thumbnails_border_radius; ?>px;
        <?php echo ($theme->thumbnails_transition) ? 'transition: all 0.3s ease 0s;-webkit-transition: all 0.3s ease 0s;' : ''; ?>
    }

    .ytwd_gallery<?php echo $shortcode_id; ?> .ytwd_gallery_item<?php echo $shortcode_id; ?> .ytwd_gallery_item_0<?php echo $shortcode_id; ?>:hover .ytwd_items_img<?php echo $shortcode_id; ?>{
        -ms-transform: <?php echo $theme->thumbnails_hover_effect; ?>(<?php echo $theme->thumbnails_hover_effect_val; ?>);
        -webkit-transform: <?php echo $theme->thumbnails_hover_effect; ?>(<?php echo $theme->thumbnails_hover_effect_val; ?>);
        transform: <?php echo $theme->thumbnails_hover_effect; ?>(<?php echo $theme->thumbnails_hover_effect_val; ?>);
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        -moz-backface-visibility: hidden;
        -ms-backface-visibility: hidden;
        z-index: 102;
        position: relative;
		<?php if($theme->thumbnails_hover_border_style != "none")	{?>
			border-width: <?php echo $theme->thumbnails_hover_border_width; ?>px;
			border-color: #<?php echo $theme->thumbnails_hover_border_color; ?>;
			border-style: <?php echo $theme->thumbnails_hover_border_style; ?>;
		<?php } ?>
        opacity: <?php echo $theme->thumbnails_hover_opacity; ?>;
    }
    .ytwd_gallery<?php echo $shortcode_id; ?> .ytwd_gallery_item<?php echo $shortcode_id; ?> .ytwd_item_title<?php echo $shortcode_id; ?>,  .ytwd_gallery<?php echo $shortcode_id; ?> .ytwd_gallery_item<?php echo $shortcode_id; ?> .ytwd_item_desc<?php echo $shortcode_id; ?>, .ytwd_gallery<?php echo $shortcode_id; ?> .ytwd_gallery_item<?php echo $shortcode_id; ?> .ytwd_item_pub_at<?php echo $shortcode_id; ?>{
        text-align: <?php echo $theme->thumbnails_text_align;?>;
    }
    .ytwd_gallery<?php echo $shortcode_id; ?> .ytwd_gallery_item<?php echo $shortcode_id; ?> .ytwd_item_title<?php echo $shortcode_id; ?>{
        font-size: <?php echo $theme->thumbnails_title_font_size; ?>px;
        color: #<?php echo $theme->thumbnails_title_font_color; ?>;
		<?php if($row->single_line_title == 1){?>
		    white-space: nowrap; 
			text-overflow: ellipsis; 
			overflow: hidden;
		<?php } ?>

    }
    .ytwd_gallery<?php echo $shortcode_id; ?> .ytwd_gallery_item<?php echo $shortcode_id; ?> .ytwd_item_pub_at<?php echo $shortcode_id; ?>{
        font-size: <?php echo $theme->thumbnails_published_at_font_size; ?>px;
        color: #<?php echo $theme->thumbnails_published_at_font_color; ?>;
		margin-bottom: 5px;
    }
    .ytwd_gallery<?php echo $shortcode_id; ?> .ytwd_gallery_item<?php echo $shortcode_id; ?> .ytwd_item_desc<?php echo $shortcode_id; ?>{
        font-size: <?php echo $theme->thumbnails_desc_font_size; ?>px;
        color: #<?php echo $theme->thumbnails_desc_font_color; ?>;
		word-break: break-all;	
    }


</style>
