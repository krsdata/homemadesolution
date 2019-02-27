////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Variables                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
var wdPlayer;
var time = false;
////////////////////////////////////////////////////////////////////////////////////////
// Constructor & Destructor                                                           //
////////////////////////////////////////////////////////////////////////////////////////
jQuery(document).ready(function () {
	wdTabs('ytwd_tabs');
	toTimeFormat();

	if(jQuery("[name=enable_gallery]:checked").val() == 0){
		jQuery(".ytwd_gallery_tbody").hide();
	}
	else{
		jQuery(".ytwd_gallery_tbody").show();
	}
	
    if(typeof embedType != "undefined" && embedType == 2){
        jQuery(".additional_info_selected_channel").show();
        jQuery(".additional_info_selected_playlist").hide();
    }
    else{
        jQuery(".additional_info_selected_channel").hide();
        jQuery(".additional_info_selected_playlist").show();
    }

    jQuery("[name=embed_type]").change(function(){
        jQuery("#video_url, #playlist_url, #youtube_id").removeClass("wd-required");

        jQuery('.ytwd_tabs li:first-child a').click();
		jQuery(".helper_wrapper").hide();
		jQuery(".yt_helper").hide();
		jQuery(".yt_helper .channel").hide();

        if(jQuery(this).val() == 2) {
            jQuery(".channel_container").show();
            jQuery(".video_url_container").hide();
			jQuery(".additional_info_selected_channel").show();
			jQuery(".additional_info_selected_playlist").hide();
            jQuery("#youtube_id").addClass("wd-required");
			jQuery(".enable_youtube_link_playlist_tr").hide();
			jQuery(".enable_youtube_link_channel_tr").show();
        }
        else{
            jQuery(".channel_container").hide();
            jQuery(".video_url_container").show();
			jQuery(".additional_info_selected_channel").hide();
			jQuery(".additional_info_selected_playlist").show();

            if(jQuery(this).val() == 0){
                jQuery(".video_url_td").show();
                jQuery(".playlist_url_td").hide();
                jQuery("#video_url").addClass("wd-required");
				jQuery(".enable_youtube_link_playlist_tr").hide();
				jQuery(".enable_youtube_link_channel_tr").hide();
            }
            else{
                jQuery(".video_url_td").hide();
                jQuery(".playlist_url_td").show();
                jQuery("#playlist_url").addClass("wd-required");
				jQuery(".enable_youtube_link_playlist_tr").show();
				jQuery(".enable_youtube_link_channel_tr").hide();				
            }
        }

        if(jQuery(this).val() != 0){
            jQuery(".ytwd_tabs li:last-child").show();
            jQuery(".ytwd_channel_add_info").show();
        }
        else{
            jQuery(".ytwd_tabs li:last-child").hide();
            jQuery(".ytwd_channel_add_info").hide();
        }
		
		if(jQuery(this).val() == 1){
			jQuery("label[for=channel_additional_info]").html("Show Playlist Info:");
		}
		else{
			jQuery("label[for=channel_additional_info]").html("Show Channel Info:");
		}		
    });

    jQuery(".gallery_additional_info").change(function(){
        var galleryAddInfo = [];
        jQuery(".gallery_additional_info:checked").each(function(){
            galleryAddInfo.push(jQuery(this).val());
        });
        jQuery("[name=gallery_additional_info]").val(galleryAddInfo.join());
    });
    jQuery(".video_additional_info").change(function(){
        var videoAddInfo = [];
        jQuery(".video_additional_info:checked").each(function(){
            videoAddInfo.push(jQuery(this).val());
        });
        jQuery("[name=video_additional_info]").val(videoAddInfo.join());
    });
    jQuery(".channel_additional_info").change(function(){
        var channelAddInfo = [];
        jQuery(".channel_additional_info:checked").each(function(){
            channelAddInfo.push(jQuery(this).val());
        });
        jQuery("[name=channel_additional_info]").val(channelAddInfo.join());
    });
    // video url change
    jQuery(".refresh_preview").click(function(){
        getPreview();
        return false;
    });
    jQuery("#ytwd_preview_iframe").load(function(){
        jQuery(".preview_container img").css("z-index", "-1");
        jQuery(this).css("opacity", "1");
        jQuery(".preview_container").css("opacity", "1");
    });

    if(typeof apiKey != "undefined" && apiKey == ""){
        jQuery(".ytwd-need-key").each(function(){
            jQuery(this).attr("disabled", "disabled");
            jQuery(this).closest("tr").find("label").css("color", "#c7c5c5");
        });
        jQuery(".ytwd_need_api_key").html("Important. API key is required for this option to work.");

    }


	jQuery("#gallery_view_type").change(function(){
		if(jQuery(this).val() == 'blog_style'){
			jQuery(".ytwd_gallery_thumb_custom_size_tr").hide();
			jQuery(".gallery_video_display_mode_tr").hide();
			jQuery(".ytwd_gallery_position_tr").hide();
			jQuery(".show_video_info_by_default_tr").hide();
			jQuery(".ytwd_thumbnails_column_number_tr").hide();
		}
		else{
			if(jQuery(this).val() == 'thumbnails'){
				jQuery(".ytwd_thumbnails_column_number_tr").show();
			}			
			else{
				jQuery(".ytwd_thumbnails_column_number_tr").hide();
			}
			
			if(jQuery(this).val() == 'carousel'){
				jQuery(".ytwd_carousel_items_count_tr").show();
			}			
			else{
				jQuery(".ytwd_carousel_items_count_tr").hide();
			}			
			
			jQuery(".gallery_video_display_mode_tr").show();			
			jQuery(".ytwd_gallery_position_tr").show();			
			jQuery(".show_video_info_by_default_tr").show();
			jQuery(".ytwd_gallery_thumb_custom_size_tr").show();			
		}

	});
	jQuery("[name=gallery_display_type]").change(function(){
		if(jQuery(this).val() == 0){
			jQuery(".ytwd_pagination_btn_text_tr").show();
		}
		else{
			jQuery(".ytwd_pagination_btn_text_tr").hide();
		}
	});
	jQuery(".video_additional_info[value=title]").change(function(){
		if(jQuery(this).is(":checked") == true){
			jQuery(".enable_youtube_link_tr").show();
		}
		else{
			jQuery(".enable_youtube_link_tr").hide();
		}
	});
	jQuery(".channel_additional_info[value=title]").change(function(){
		if(jQuery(this).is(":checked") == false){
			jQuery(".enable_youtube_link_playlist_tr").hide();
			jQuery(".enable_youtube_link_channel_tr").hide();
		}
		else{
			if(jQuery("[name=embed_type] :selected").val() == 1){
				jQuery(".enable_youtube_link_playlist_tr").show();
			}
			else if(jQuery("[name=embed_type] :selected").val() == 2){
				jQuery(".enable_youtube_link_channel_tr").show();				
			}
		}
	});	
	jQuery("[name=enable_gallery]").change(function(){
		if(jQuery(this).val() == 0){
			jQuery(".ytwd_gallery_tbody").hide();
		}
		else{
			jQuery(".ytwd_gallery_tbody").show();
		}
	});		
	
	// main filter 
	jQuery("#channel_filter, #video_url, #playlist_url").keyup(function(){
		_this = jQuery(this);
		if(jQuery(this).val()){
			setTimeout(function(){
				
				if(!time){
					jQuery(".filtered_items").hide();
					jQuery(".filtered_items").html("");
					var types = ["video", "playlist", "channel"];
					var data = {};
					data.action = "admin_filter";
					data.nonce_ytwd = ytwdNonce;
					data.query = _this.val();
					data.type = types[Number(jQuery("[name=embed_type] :selected").val())];
					
					jQuery.post(ajaxURL, data, function (response){
						var response = JSON.parse(response);
						if(response){
							for(var i=0; i<response.length; i++){
								var row = response[i];
								var img = row["thumbnail"] != null ? '<img src="' + row["thumbnail"] + '" width="95px">' : '';
								var html = 
									'<div class="wd-table filter-itme" data-id="' + row["id"] + '" onclick="selectItem(this);">' + 
										'<div class="wd-cell wd-cell-valign-middle">' +
											img + 
										'</div>' + 
										'<div class="wd-cell wd-cell-valign-middle">' +
											'<h3>' + row["title"] + '</h3>' + 
											'<div> Published at ' + row["published"] + '</div>' + 
											'<div>' + row["description"] + '</div>' + 
										'</div>' + 						
									'</div>';
								jQuery(".filtered_items_" + jQuery("[name=embed_type] :selected").val()).append(html);
							}
							
							if(jQuery(".filtered_items_" + jQuery("[name=embed_type] :selected").val()).html()){
								jQuery(".filtered_items_" + jQuery("[name=embed_type] :selected").val()).show();
							}
							
						}
						time = false;
					});
				
				}
				time = true;					
			}, 600);
		}

	});
	jQuery("#channel_filter, #video_url, #playlist_url").change(function(){	
		if(!jQuery(this).val()){
			jQuery(".filtered_items").hide();
			jQuery(".filtered_items").html("");
		}
	});
	jQuery(":not(.channel_filter_td)").click(function(){
		jQuery(".filtered_items").hide();
		jQuery(".filtered_items").html("");		
	});	
	jQuery(".start_hours, .start_minutes, .start_seconds, .end_hours, .end_minutes, .end_seconds").change(function(){
		toSeconds();
	});
	
	jQuery(".ytwd_help_icon").click(function(){
		if(jQuery(".helper_wrapper").is(":visible")){
			jQuery(".helper_wrapper").hide();
			jQuery(".yt_helper").hide();
			jQuery(".yt_helper .channel").hide();
		}
		else{
			jQuery(".yt_helper" + jQuery("[name=embed_type] :selected").val() + " .channel" + jQuery("#channel_identifer :selected").val()).show();
			jQuery(".yt_helper" + jQuery("[name=embed_type] :selected").val()).show();				
			jQuery(".helper_wrapper").show();				
		}
	});
	jQuery("#channel_identifer").change(function(){
		jQuery(".helper_wrapper").hide();
		jQuery(".yt_helper").hide();
		jQuery(".yt_helper .channel").hide();		
	});

	jQuery("#auto_height").change(function(){
		if(jQuery(this).is(":checked") == true){
			jQuery(".ytwd_height_tr").hide();
		}
		else{
			jQuery(".ytwd_height_tr").show();
		}
		
	});	
});
////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////
function selectItem(obj){
	var id = jQuery(obj).attr("data-id");
	var type = jQuery("[name=embed_type] :selected").val();
	if(type == 0){
		jQuery("#video_url").val("https://www.youtube.com/watch?v=" + id);
	}
	else if(type == 1){
		jQuery("#playlist_url").val("https://www.youtube.com/playlist?list=" + id);
	}
	else{
		jQuery("#channel_identifer option").attr("selected", false);
		jQuery("#channel_identifer option[value=1]").attr("selected", "selected");
		jQuery("#youtube_id").val(id);
	}
	jQuery(".filtered_items").hide();
	jQuery(".filtered_items").html("");	
	
}
function getPreview(){
    jQuery("#ytwd_preview_iframe").css("opacity", "0.4");
    jQuery(".preview_container img").css("z-index", "1");
    //jQuery(".preview_container").css("background", "#000");
    var data = ytwdGetData();
    var data_str = [];
    for(var key in data){
        data_str.push(key + "=" + data[key]);
    }
    data_str = "&" + data_str.join("&");
    var previewURL = "index.php?page=ytwd_preview&f_p=1" + data_str;
    jQuery("#ytwd_preview_iframe").attr("src", previewURL);
}
function ytwdGetData(){
    var data = {};
    jQuery(".wd-form-el").each(function(){
        var name = jQuery(this).attr("name");
		if(jQuery(this).is("input[type=radio]") || jQuery(this).is("input[type=checkbox]")){
            data[name] = jQuery("[name=" + name + "]:checked").val();
		}
		else if(jQuery(this).is("select")){
			data[name] = jQuery("[name=" + name + "] :selected").val();
		}
		else {
			data[name] = jQuery(this).val();
		}
    });

    return data;
}
function onYouTubeIframeAPIReady(){
    wdPlayer = new YT.Player("wd-player-iframe", {
      events: {
        'onReady':  onPlayerReady
       /* 'onStateChange': onPlayerStateChange*/
      }
    });
}
function onPlayerReady(event){
   wdPlayer.setVolume(Number(initialVolume));
}

function toSeconds(){
	var startHours = Number(jQuery(".start_hours").val());
	var startMinutes = Number(jQuery(".start_minutes").val());
	var startSeconds = Number(jQuery(".start_seconds").val());
	var start = startSeconds + 60 * startMinutes + 3600 * startHours;
	
	var endHours = Number(jQuery(".end_hours").val());
	var endMinutes = Number(jQuery(".end_minutes").val());
	var endSeconds = Number(jQuery(".end_seconds").val());
	var end = endSeconds + 60 * endMinutes + 3600 * endHours;
	
	jQuery("#start").val(start);
	jQuery("#end").val(end);
}

function toTimeFormat(){
	var start =	Number(jQuery("#start").val());
	var end = Number(jQuery("#end").val());
	
	if(start){
		
		jQuery(".start_hours").val(parseInt(start/3600));
		jQuery(".start_minutes").val(parseInt((start%3600)/60));
		jQuery(".start_seconds").val((start%3600)%60);
	}
	if(end){
		jQuery(".end_hours").val(parseInt(end/3600));
		jQuery(".end_minutes").val(parseInt((end%3600)/60));
		jQuery(".end_seconds").val((end%3600)%60);
	}
	
	
}

function fillInputs(){
	toSeconds();
}
////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
