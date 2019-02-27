<div class="ytwd_edit">  
    <form method="post" action="" id="adminForm" enctype="multipart/form-data">   
        <?php wp_nonce_field('nonce_ytwd', 'nonce_ytwd'); ?>  
        <div class="ytwd">
       
            <div class="wd-clear wd-row">
                <div class="wd-left"> 
                    <h2 style="margin: 0;">
                        <img src="<?php echo YTWD_URL . '/assets/settings.png';?>" width="30" style="vertical-align:middle;">
                        <span>
                            <?php _e("Settings","ytwd"); ?>
                        </span>

                    </h2>       
                </div>        
                <div class="wd-right">
                    <button class="wd-btn wd-btn-primary wd-btn-icon wd-btn-apply" onclick="ytwdFormSubmit('apply');" ><?php _e("Apply","ytwd");?></button>                             						
                </div>
            </div>        
            <table class="ytwd_edit_table"> 
                <tr>
                    <td><label for="api_key" title="<?php _e("Set api key.","ytwd");?>"><?php _e("API Key","ytwd");?>:</label></td>
                    <td>
                        <input type="text" name="api_key" id="api_key" value="<?php echo ytwd_get_option("api_key"); ?>" style="width:35em;">                
                    </td>
                </tr> 
				<!--<tr>
					<td colspan="2">
					   <a href="https://console.developers.google.com/apis/dashboard" target="_blank" style="color: #00A0D2;"><?php _e("Get Key","ytwd");?></a>.&nbsp;
						<?php _e("For getting API key read more in","ytwd");?>
						<a href="https://web-dorado.com/wordpress-youtube-wd/configuring-api.html" target="_blank" style="color: #00A0D2;"><?php _e("User Manual","ytwd");?></a>.
					</td>
				</tr> -->
                <tr>
                    <td colspan="2">
                       <a class="wd-btn wd-btn-primary thickbox thickbox-preview" name="<?php _e( 'Generate API Key - ( MUST be logged in to your Google account )', 'ytwd' ); ?>" href='https://console.developers.google.com/henhouse/?pb=["hh-1","youtube.googleapis.com",null,[],"https://developers.google.com",null,["youtube.googleapis.com","youtubeanalytics.googleapis.com","youtubereporting.googleapis.com"],null]&TB_iframe=true&width=600&height=400'>
                            <?php _e("Generate Key","gmwd");?>
                        </a>
                        or <a target="_blank" href='https://console.developers.google.com/flows/enableapi?apiid=maps_backend,geocoding_backend,directions_backend,distance_matrix_backend,elevation_backend,static_maps_backend,roads,street_view_image_backend,geolocation,places_backend&keyType=CLIENT_SIDE&reusekey=true'>click here</a>
                        <?php echo _e( ' to Get a Google Maps API KEY', 'gmwd' ) ?>
                    </td>
                </tr>                 				
                <tr>           
                    <td><label for="enable_cache" title="<?php _e("Turn on this setting to boost the speed of your YouTube video, playlist or channel.","ytwd");?>"><?php _e("Enable Caching","ytwd");?>:</label></td>
                    <td>
                        <input type="radio" class="ytwd_disabled_field" disabled readonly id="enable_cache1" name="enable_cache" <checked="checked" value="1" >
                        <label for="enable_cache1"><?php _e("Yes","ytwd"); ?></label>  
                        <input type="radio" class="ytwd_disabled_field" disabled readonly id="enable_cache0" name="enable_cache"  value="0" >
                        <label for="enable_cache0"><?php _e("No","ytwd"); ?></label> 
						<div class="ytwd_pro_option">
							<small><?php _e("Only in the Paid version.","ytwd"); ?></small>
						</div>						
                    </td>
                </tr>  

                <tr>
                    <td><label for="show_deleted_videos1" title="<?php _e("Enabling this setting will include the thumbnails of deleted videos in your YouTube gallery.","ytwd");?>"><?php _e("Show Deleted Video Thumbnails","ytwd");?>:</label></td>
                    <td>
                        <input type="radio" class="inputbox" id="show_deleted_videos1" name="show_deleted_videos" <?php echo ((ytwd_get_option("show_deleted_videos") == 1) ? 'checked="checked"' : ''); ?> value="1" >
                        <label for="show_deleted_videos1"><?php _e("Yes","ytwd"); ?></label>  
                        <input type="radio" class="inputbox" id="show_deleted_videos0" name="show_deleted_videos" <?php echo ((ytwd_get_option("show_deleted_videos") == 0) ? 'checked="checked"' : ''); ?> value="0" >
                        <label for="show_deleted_videos0"><?php _e("No","ytwd"); ?></label>                  
                    </td>
                </tr>                
                <tr>
                    <td><label for="video_seo_tags" title="<?php _e(" This option lets you enable meta keywords and descriptions for the videos. They are used for proper crawling and indexation by search engines.","ytwd");?>"><?php _e("Add Video SEO Tags","ytwd");?>:</label></td>
                    <td>
                        <input type="radio" class="inputbox" id="video_seo_tags1" name="video_seo_tags" <?php echo ((ytwd_get_option("video_seo_tags") == 1) ? 'checked="checked"' : ''); ?> value="1" >
                        <label for="video_seo_tags1"><?php _e("Yes","ytwd"); ?></label>  
                        <input type="radio" class="inputbox" id="video_seo_tags0" name="video_seo_tags" <?php echo ((ytwd_get_option("video_seo_tags") == 0) ? 'checked="checked"' : ''); ?> value="0" >
                        <label for="video_seo_tags0"><?php _e("No","ytwd"); ?></label>                  
                    </td>
                </tr> 
                <tr>
                    <td><label for="fb_markup" title="<?php _e("Add Open Graph markup to your YouTube entries. This recommended to enable for Facebook sharing, it will set the video thumbnail as the post image.","ytwd");?>"><?php _e("Facebook Open Graph Markup","ytwd");?>:</label></td>
                    <td>
                        <input type="radio" class="inputbox" id="fb_markup1" name="fb_markup" <?php echo ((ytwd_get_option("fb_markup") == 1) ? 'checked="checked"' : ''); ?> value="1" >
                        <label for="fb_markup1"><?php _e("Yes","ytwd"); ?></label>  
                        <input type="radio" class="inputbox" id="fb_markup0" name="fb_markup" <?php echo ((ytwd_get_option("fb_markup") == 0) ? 'checked="checked"' : ''); ?> value="0" >
                        <label for="fb_markup0"><?php _e("No","ytwd"); ?></label>                  
                    </td>
                </tr>
               
            </table>
        </div>
        <input id="page" name="page" type="hidden" value="<?php echo $page; ?>" />	
        <input id="task" name="task" type="hidden" value="<?php echo $task; ?>" />	
    </form>
</div>