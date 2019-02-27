<div class="ytwd_iframe_container<?php echo $shortcode_id; ?>" <?php if(ytwd_get_option("video_seo_tags") == 1) { ?> itemprop="video" itemscope itemtype="http://schema.org/VideoObject" <?php } ?>>
    <?php if(ytwd_get_option("video_seo_tags") == 1){ ?>
        <meta itemprop="name" content="<?php echo $embed_data["items"][0]["snippet"]["title"]; ?>" />
        <meta itemprop="description" content="<?php echo $embed_data["items"][0]["snippet"]["description"]; ?>" />
        <meta itemprop="thumbnailUrl" content="<?php echo $embed_data["items"][0]["snippet"]["thumbnails"]["default"]["url"]; ?>" />
        <meta itemprop="embedURL" content="<?php echo $iframe_video_url; ?>" />
        <meta itemprop="uploadDate" content="<?php echo $embed_data["items"][0]["snippet"]["publishedAt"]; ?>" />
        <meta itemprop="height" content="<?php echo $row->height; ?>" />
        <meta itemprop="width" content="<?php echo $row->width; ?>" />
    <?php
    }

    ?>
    <div class="ytwd_iframe_wrapper">
        <div class="ytwd_iframe_black_wrapper_0 ytwd_iframe_black_wrapper_0<?php echo $shortcode_id; ?>">
			<div class="ytwd_iframe_black_wrapper ytwd_iframe_black_wrapper<?php echo $shortcode_id; ?>">
				<?php if($row->enable_gallery == 0 && ($row->embed_type == 1 ||  $row->embed_type == 2)){ ?>
					<iframe width="100%" src="<?php echo $iframe_video_url; ?>" frameborder="0" enablejsapi="1" allowfullscreen id="ytwd_main_iframe<?php echo $shortcode_id; ?>" class="ytwd_main_iframe" data-id="<?php echo $shortcode_id; ?>"  ></iframe>				
				<?php 
				}
				else { ?>
				<div  data-src="<?php echo $iframe_video_url; ?>" frameborder="0" enablejsapi="1" allowfullscreen id="ytwd_main_iframe<?php echo $shortcode_id; ?>" class="ytwd_main_iframe" data-id="<?php echo $shortcode_id; ?>" data-title="<?php echo $row->embed_type !=0 ? $items_data[0]["title"] : ""; ?>" data-youtube-title="<?php echo isset($embed_data["items"][0]["snippet"]["title"]) ? $embed_data["items"][0]["snippet"]["title"] : ""; ?>" data-video-id="<?php echo ytwd_get_youtube_embed_id($iframe_video_url); ?>"></div>
				<?php } ?>			
			</div>
        </div>
    </div>
    <?php
    if($main_video_data != false){
        require(YTWD_DIR."/views/view_main_video_frontend.php");
    }
    ?>
</div>
<style>
    .ytwd_iframe_black_wrapper_0<?php echo $shortcode_id; ?>{
        width: <?php echo $row->gallery_video_display_mode == 1 ? "800px" : $row->width.$row->width_unit; ?>;
        <?php
            if($row->player_aligment == 1){
                echo "margin: 0 auto;";
            }
            else if($row->player_aligment == 2){
                echo "float: right;";    
            }
        ?>
		position: relative;
			
    }
    .ytwd_iframe_black_wrapper<?php echo $shortcode_id; ?>{
		height: <?php echo $row->height; ?>px;	
		<?php if ($row->auto_height == 1 && $row->height == 0) echo 'padding-bottom: 55.25%'; ?>;			
    }	
	
	#ytwd_main_iframe<?php echo $shortcode_id; ?> {
		position: absolute !important;
		top: 0;
		left: 0;
		height: 100%;
	}	
	
</style>
