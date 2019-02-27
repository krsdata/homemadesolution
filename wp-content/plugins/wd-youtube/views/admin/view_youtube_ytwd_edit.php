<?php

?>
<div class="ytwd_edit">

    <form method="post" action="" id="adminForm" enctype="multipart/form-data">
        <input id="page" name="page" type="hidden" value="<?php echo $page; ?>" />
        <input id="task" name="task" type="hidden" value="<?php echo $task; ?>" />
        <input id="id" name="id" type="hidden" value="<?php echo $row->id;?>" />
        <input id="shortcode_id" name="shortcode_id" type="hidden" value="<?php echo $row->shortcode_id;?>" />
        <input id="ytwd_tabs_active" name="ytwd_tabs_active" type="hidden" value="<?php echo $active_tab; ?>" />
        <?php wp_nonce_field('nonce_ytwd', 'nonce_ytwd'); ?>
        <div class="wd-main-youtube">
            <div class="wd-youtube-header">
                <!-- title row -->
                <div class="wd-clear wd-row">
                    <div class="title-wrapper ytwd_container_red_border" style="position:relative;">

                        <!-- btns row -->
                        <div class="wd-clear wd-row">
                            <div class="wd-left">
                                <h2 style="margin: 0;">
                                    <img src="<?php echo YTWD_URL . '/assets/icon-yt.png';?>" width="50" style="vertical-align:middle;">
                                    <span>
                                        <?php _e("Embed YouTube video, playlist, channel","ytwd"); ?>
                                    </span>

                                </h2>
                            </div>
                            <div class="wd-table ytwd_btns wd-right">
                                <div class="wd-cell wd-cell-valign-middle">
                                    <button class="wd-btn wd-btn-primary wd-btn-icon wd-btn-save" onclick="ytwdFormSubmit('save');return false;"><?php _e("Save","ytwd");?></button>
                                </div>
                                <div class="wd-cell wd-cell-valign-middle">
                                    <button class="wd-btn wd-btn-primary wd-btn-icon wd-btn-apply" onclick="ytwdFormSubmit('apply');return false;"><?php _e("Apply","ytwd");?></button>
                                </div>
                                <div class="wd-cell wd-cell-valign-middle">
                                    <button class="wd-btn wd-btn-primary wd-btn-icon wd-btn-save2copy" onclick="ytwdFormSubmit('save2copy');return false;"><?php _e("Save as Copy","ytwd");?></button>
                                </div>
                                <div class="wd-cell wd-cell-valign-middle">
                                    <button class="wd-btn wd-btn-primary wd-btn-icon wd-btn-cancel" onclick="ytwdFormSubmit('cancel');return false;"><?php _e("Cancel","ytwd");?></button>
                                </div>
                            </div>
                        </div>

                        <div class="helper_wrapper" style='display:none;'>
                            <div class="yt_helper wd-table yt_helper0" style='display:none;'>
                                <div class="wd-cell wd-cell-valign-middle">
                                    Search YouTube video by title below (example: Web Dorado Google Maps). Or, if you already have the URL for the video, you can paste it below ( example: <a href="https://www.youtube.com/watch?v=acaexefeP7o" target="_blank">https://www.youtube.com/watch?v=acaexefeP7o</a> ).
                                </div>
                            </div>
                            <div class="yt_helper wd-table yt_helper1" style='display:none;'>
                                <div class="wd-cell wd-cell-valign-middle">
                                    Search YouTube playlist by title below. Or, go to the page for the playlist that lists all of its videos ( example: <a href="https://www.youtube.com/playlist?list=PLnxWPiY5tLFVgUSTYoWRdy63XZ0pUJvIZ" target="_blank">https://www.youtube.com/playlist?list=PLnxWPiY5tLFVgUSTYoWRdy63XZ0pUJvIZ</a> ). Copy the URL in your browser and paste it in the textbox below.
                                </div>
                            </div>
                            <div class="yt_helper wd-table yt_helper2" style='display:none;'>
                                <div class="wd-cell wd-cell-valign-middle channel channel0" style='display:none;'>
									Search YouTube channel by title below. Or, 
                                    go to the page for the channel ( example: <a href="https://www.youtube.com/user/WebDorado88" target="_blank">https://www.youtube.com/user/WebDorado88</a> ). You'll notice that a channel URL contains the YouTube ID (WebDorado88). Copy the ID in your browser and paste it in the textbox below.
                                </div>
                                <div class="wd-cell wd-cell-valign-middle channel channel1" style='display:none;'>
                                    Go to the page for the channel ( example: <a href="https://www.youtube.com/channel/UC70QckdMkEtr9QHDhRn8-kw" target="_blank">https://www.youtube.com/channel/UC70QckdMkEtr9QHDhRn8-kw</a> ). You'll notice that a channel URL contains the Channel ID (UC70QckdMkEtr9QHDhRn8-kw). Copy the ID in your browser and paste it in the textbox below.
                                </div>								
                            </div>
                        </div>
                        <table class="ytwd_edit_table">
                            <tr>
                                <td>
                                    <label for="title"><?php _e("Title","ytwd"); ?>:</label>
                                    <span style="color:#FF0000;">*</span>
                                </td>
                                <td>
                                    <input type="text" name="title" class="wd-required" value="<?php echo $row->title;?>">
                                </td>
                            </tr>
                             <tr>
                                <td>
                                    <label for="embed_type"><?php _e("Select Type","ytwd"); ?>:</label>
                                </td>
                                <td class="embed_type_td">
                                    <select class="wd-form-el" name="embed_type" style="width: 180px;">
                                        <option value="0" <?php echo (($row->embed_type == 0) ? 'selected="selected"' : ''); ?>><?php _e("Single Video","ytwd"); ?></option>
                                        <option value="1" <?php echo (($row->embed_type == 1) ? 'selected="selected"' : ''); ?>><?php _e("Playlist","ytwd"); ?></option>
                                        <option value="2" <?php echo (($row->embed_type == 2) ? 'selected="selected"' : ''); ?>><?php _e("Channel","ytwd"); ?></option>
                                    </select>
                                </td>
                            </tr>							
                            <tr class="video_url_container" <?php echo $row->embed_type == 2 ? "style='display:none;'" : ""; ?>>
                                <td>
                                    <label for="title"><?php _e("URL or ","ytwd"); ?><br><?php _e("Search by Titile","ytwd"); ?>:</label>
                                    <span style="color:#FF0000;">*</span>
                                </td>
                                <td <?php echo $row->embed_type == 0 ? '' : 'style="display:none;"'; ?> class="video_url_td ">
                                    <input type="text" name="video_url" id="video_url" class="wd-form-el <?php echo $row->embed_type == 0 ? 'wd-required' : ''; ?>" value="<?php echo $row->video_url;?>" style="width:47em;" autocomplete="off">
									<span class="ytwd_help_icon">?</span>
									<div class="filtered_items filtered_items_0"></div>
                                </td>
                                <td <?php echo $row->embed_type == 1 ? '' : 'style="display:none;"'; ?> class="playlist_url_td ">
                                    <input type="text" name="playlist_url" id="playlist_url" class="wd-form-el <?php echo $row->embed_type == 1 ? 'wd-required' : ''; ?>" value="<?php echo $row->playlist_url;?>" style="width:47em;" autocomplete="off">
									<span class="ytwd_help_icon">?</span>
									<div class="filtered_items filtered_items_1"></div>
                                </td>
                            </tr>
                            <tr class="channel_container" <?php echo $row->embed_type == 2 ? "" : "style='display:none;'"; ?>>
                                <td>
                                    <label for="title"><?php _e("Search by Title","ytwd"); ?>:</label>
                                </td>
                                <td class="channel_filter_td">
                                    <input type="text" id="channel_filter" style="width:47em;" autocomplete="off" class="ytwd-need-key">
									<span class="ytwd_help_icon">?</span>
									<div class="filtered_items filtered_items_2"></div>
									<div class="ytwd_need_api_key"></div>
                                </td>
                            </tr>
							
                            <tr class="channel_container" <?php echo $row->embed_type == 2 ? "" : "style='display:none;'"; ?>>
                                <td>
                                    <label for="title"><?php _e("Channel ID","ytwd"); ?>:</label>
                                    <span style="color:#FF0000;">*</span>
                                </td>
                                <td>
                                    <div style="width:47em;">
                                        <label for="channel_identifer"><?php _e("Identify By","ytwd"); ?>:</label>
                                        <select name="channel_identifer" id="channel_identifer" class="wd-form-el">
                                            <option value="0" <?php echo $row->channel_identifer == 0 ? "selected" : ""; ?>><?php _e("Username","ytwd"); ?></option>
                                            <option value="1" <?php echo $row->channel_identifer == 1 ? "selected" : ""; ?>><?php _e("Channel ID","ytwd"); ?></option>
                                        </select>
                                        <!--<label for="youtube_id"><?php _e("YouTube ID","ytwd"); ?>:</label>-->

                                        <input type="text" name="youtube_id" class="wd-form-el <?php echo $row->embed_type == 2 ? 'wd-required' : ''; ?>" id="youtube_id" value="<?php echo $row->youtube_id;?>" style="    vertical-align: top;" >
                                    </div>
                                </td>
                            </tr>
						
                            <tr>
                                <td><?php _e("Published:","ytwd"); ?></td>
                                <td>
                                  <input type="radio" class="inputbox wd-form-field wd-form-el" id="published1" name="published" <?php echo (($row->published) ? 'checked="checked"' : ''); ?> value="1" >
                                  <label for="published1"><?php _e("Yes","ytwd"); ?></label>
                                  <input type="radio" class="inputbox wd-form-field wd-form-el" id="published0" name="published" <?php echo (($row->published) ? '' : 'checked="checked"'); ?> value="0"  >
                                  <label for="published0"><?php _e("No","ytwd"); ?></label>

                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>

            <div class="wd-clear wd-row" >
                <div class="wd-row wd-table" style="width:100%;">
                    <div class="wd-cell wd-cell-valign-top ">
                        <div class="wd-clear">
                            <div class="wd-row wd-table ytwd_tabs_container" style="width: 100%">
                                <div class="ytwd_container_red_border wd-settings-container ">
                                <div class="wd-tabs-wrapper">
                                    <ul class="ytwd_tabs wd-clear">
                                        <?php
                                        foreach($settings_tabs as $tab_key => $tab_title){
                                            $_active_tab = $active_tab == $tab_key  ? 'ytwd_tabs_active' : '';
                                        ?>
                                            <li <?php echo $row->embed_type == 0 && $tab_key == "settings-gallery" ? 'style="display:none;"' : ''; ?>>
                                                <a href="#<?php echo $tab_key; ?>" class="<?php echo $_active_tab; ?>"><?php echo $tab_title; ?></a>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <!-- player settings -->
                                <div id="settings-player" class="wd-cell wd-cell-valign-top ytwd_tabs_container_item" <?php echo $active_tab == "settings-player" ? '' : 'style="display:none;"'; ?>>
                                    <table class="ytwd_edit_table">
                                        <tr>
                                            <td><label for="width" title="<?php _e("Set the width of the player, you can use pixels or percents.", "ytwd"); ?>"><?php _e("Width","ytwd");?>:</label></td>
                                            <td>
                                                <input type="text" name="width" id="width" value="<?php echo $row->width;?>" class="wd-form-el" >
                                                <select name="width_unit" class="wd-form-el">
                                                    <option value="%" <?php echo $row->width_unit == "%" ? "selected" : ""; ?>>%</option>
                                                    <option value="px" <?php echo $row->width_unit == "px" ? "selected" : ""; ?>>px</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="auto_height" title="<?php _e("Enable auto height.", "ytwd"); ?>"><?php _e("Auto Height","ytwd");?>:</label></td>
                                            <td>
                                                <input type="checkbox" name="auto_height" id="auto_height" value="1" <?php echo $row->auto_height == 1 ? "checked" : "";?> class="wd-form-el"> 
                                            </td>
                                        </tr>											
                                        <tr class="ytwd_height_tr" <?php echo $row->auto_height == 0 ? '' : 'style="display:none;"'; ?>>
                                            <td><label for="height" title="<?php _e("Provide the height of YouTube player in pixels.", "ytwd"); ?>"><?php _e("Height","ytwd");?>:</label></td>
                                            <td>
                                                <input type="text" name="height" id="height" value="<?php echo $row->height;?>" class="wd-form-el"> px
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="player_aligment" title="<?php _e("Choose the alignment of your YouTube player, which can be set to Left, Center or Right.", "ytwd"); ?>"><?php _e("Player Alignment","ytwd");?>:</label></td>
                                            <td>
                                              <select name="player_aligment" id="player_aligment" class="wd-form-el">
                                                    <?php foreach($aligment  as $key => $value){
                                                        $selected = $key == $row->player_aligment ? "selected" : "";
                                                        echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><label for="autohide" title="<?php _e("Switch on this parameter to hide the control bar after the video starts playing. It will appear again if users mouse over the video. Note that this option only affects fullscreen playback only.", "ytwd"); ?>"><?php _e("Enable Autohide","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" class="wd-form-el" id="autohide1" name="autohide" <?php echo (($row->autohide) ? 'checked="checked"' : ''); ?> value="1" >
                                                <label for="autohide1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" class="wd-form-el" id="autohide0" name="autohide" <?php echo (($row->autohide) ? '' : 'checked="checked"'); ?> value="0" >
                                                <label for="autohide0"><?php _e("No","ytwd"); ?></label>
                                                <span style="display: inline-block;color: #c10505;vertical-align: middle;padding-left: 5px;"> (Deprecated)</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="autoplay" title="<?php _e("Switch this option on to start the main video automatically, when the player loads on your WordPress page or post.", "ytwd"); ?>"><?php _e("Enable Autoplay","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" class="wd-form-el" id="autoplay1" name="autoplay" <?php echo (($row->autoplay) ? 'checked="checked"' : ''); ?> value="1" >
                                                <label for="autoplay1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" class="wd-form-el" id="autoplay0" name="autoplay" <?php echo (($row->autoplay) ? '' : 'checked="checked"'); ?> value="0" >
                                                <label for="autoplay0"><?php _e("No","ytwd"); ?></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="color" title="<?php _e("You can specify the color of player’s progress bar with this setting. Valid values for this parameter are red and white.", "ytwd"); ?>"><?php _e("Progress Bar Color","ytwd");?>:</label></td>
                                            <td>
                                                 <select name="color" id="color" class="wd-form-el">
                                                    <option <?php echo $row->color == 'red' ? 'selected' : ''; ?> value="red" ><?php _e("Red","ytwd");?></option>
                                                    <option <?php echo $row->color == 'white' ? 'selected' : ''; ?> value="white"><?php _e("White","ytwd");?></option>
                                                 </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="controls" title="<?php _e("This setting lets you show or hide control buttons of YouTube player on your video. This includes the progress bar, play, volume, captions, settings and fullscreen buttons, as well as YouTube logo and the timer.", "ytwd"); ?>"><?php _e("Enable Controls","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" class="wd-form-el" id="controls1" name="controls" <?php echo (($row->controls) ? 'checked="checked"' : ''); ?> value="1" >
                                                <label for="controls1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" class="wd-form-el" id="controls0" name="controls" <?php echo (($row->controls) ? '' : 'checked="checked"'); ?> value="0" >
                                                <label for="controls0"><?php _e("No","ytwd"); ?></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="fs" title="<?php _e("Use this setting to enable or disable fullscreen button on your YouTube player.", "ytwd"); ?>"><?php _e("Allow Fullscreen","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" class="wd-form-el" id="fs1" name="fs" <?php echo (($row->fs) ? 'checked="checked"' : ''); ?> value="1" >
                                                <label for="fs1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" class="wd-form-el" id="fs0" name="fs" <?php echo (($row->fs) ? '' : 'checked="checked"'); ?> value="0" >
                                                <label for="fs0"><?php _e("No","ytwd"); ?></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="loop" title="<?php _e("With this option you can configure the video to play on repeat. It will start over after the video is done playing.", "ytwd"); ?>"><?php _e("Enable Looping","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" class="wd-form-el" id="loop1" name="loop" <?php echo (($row->loop) ? 'checked="checked"' : ''); ?> value="1" >
                                                <label for="loop1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" class="wd-form-el" id="loop0" name="loop" <?php echo (($row->loop) ? '' : 'checked="checked"'); ?> value="0" >
                                                <label for="loop0"><?php _e("No","ytwd"); ?></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="rel" title="<?php _e("Enabling this setting lets you show related videos after the playback of initial video is finished.", "ytwd"); ?>"><?php _e("Show Relative Videos","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" class="ytwd_disabled_field" disabled readonly id="rel1" name="rel" checked="checked value="1" >
                                                <label for="rel1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" class="ytwd_disabled_field" disabled readonly id="rel0" name="rel"  value="0" >
                                                <label for="rel0"><?php _e("No","ytwd"); ?></label>
												<div class="ytwd_pro_option">
													<small><?php _e("Only in the Paid version.","ytwd"); ?></small>
												</div>												
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="showinfo" title="<?php _e("When this parameter is disabled, the title and author of the main video, as well as share button will not be displayed on the player.", "ytwd"); ?>"><?php _e("Show Video Info","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" class="ytwd_disabled_field" disabled readonly id="showinfo1" name="showinfo" checked="checked" value="1" >
                                                <label for="showinfo1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" class="ytwd_disabled_field" disabled readonly id="showinfo0" name="showinfo"  value="0" >
                                                <label for="showinfo0"><?php _e("No","ytwd"); ?></label>
												<div class="ytwd_pro_option">
													<small><?php _e("Only in the Paid version.","ytwd"); ?></small>
												</div>													
                                            </td>
                                        </tr>
                                        <!--<tr>
                                            <td><label for="theme"><?php _e("Skin","ytwd");?>:</label></td>
                                            <td>
                                                 <select name="theme" id="theme" class="wd-form-el">
                                                    <option <?php echo $row->theme == 'dark' ? 'selected' : ''; ?> value="dark" ><?php _e("Dark","ytwd");?></option>
                                                    <option <?php echo $row->theme == 'light' ? 'selected' : ''; ?> value="light"><?php _e("Light","ytwd");?></option>
                                                 </select>
                                            </td>
                                        </tr>-->
                                        <tr>
                                            <td><label for="disablekb" title="<?php _e("Switch this option on in case you do not want the player to respond to keyboard controls, such as spacebar (play/pause), up/down arrows (volume control), etc.", "ytwd"); ?>"><?php _e("Disable Keyboard","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" class="ytwd_disabled_field" disabled readonly id="disablekb1" name="disablekb" checked="checked" value="1" >
                                                <label for="disablekb1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" class="ytwd_disabled_field" disabled readonly id="disablekb0" name="disablekb"  value="0" >
                                                <label for="disablekb0"><?php _e("No","ytwd"); ?></label>
												<div class="ytwd_pro_option">
													<small><?php _e("Only in the Paid version.","ytwd"); ?></small>
												</div>													
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="modestbranding" title="<?php _e("This setting lets you enable or disable YouTube logo among control buttons of the player.", "ytwd"); ?>"><?php _e("Show YouTube Icon","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" class="ytwd_disabled_field" disabled readonly id="modestbranding1" name="modestbranding" checked="checked" value="0" >
                                                <label for="modestbranding1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" class="ytwd_disabled_field" disabled readonlyid="modestbranding0" name="modestbranding" value="1" >
                                                <label for="modestbranding0"><?php _e("No","ytwd"); ?></label>
												<div class="ytwd_pro_option">
													<small><?php _e("Only in the Paid version.","ytwd"); ?></small>
												</div>													
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="iv_load_policy" title="<?php _e("You can switch annotations of the main video on or off with this setting.", "ytwd"); ?>"><?php _e("Show Annotations","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" class="wd-form-el" id="iv_load_policy1" name="iv_load_policy" <?php echo (($row->iv_load_policy == 1) ? 'checked="checked"' : ''); ?> value="1" >
                                                <label for="iv_load_policy1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" class="wd-form-el" id="iv_load_policy0" name="iv_load_policy" <?php echo (($row->iv_load_policy == 3) ? 'checked="checked"' : ''); ?> value="3" >
                                                <label for="iv_load_policy0"><?php _e("No","ytwd"); ?></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="hl" title="<?php _e("When this option is turned on, the player detects the language of your WordPress site and displays its controls in the same language. The site language can be changed from WordPress Settings > General page.", "ytwd"); ?>"><?php _e("Enable Localization","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" class="wd-form-el" id="hl1" name="hl" <?php echo (($row->hl) ? 'checked="checked"' : ''); ?> value="1" >
                                                <label for="hl1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" class="wd-form-el" id="hl0" name="hl" <?php echo (($row->hl) ? '' : 'checked="checked"'); ?> value="0" >
                                                <label for="hl0"><?php _e("No","ytwd"); ?></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="cc_load_policy1" title="<?php _e("If this parameter is enabled, the YouTube player published on your website will have closed captions displayed by default.", "ytwd"); ?>"><?php _e("Show Closed Captions","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" class="wd-form-el" id="cc_load_policy1" name="cc_load_policy" <?php echo (($row->cc_load_policy) ? 'checked="checked"' : ''); ?> value="1" >
                                                <label for="cc_load_policy1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" class="wd-form-el" id="cc_load_policy0" name="cc_load_policy" <?php echo (($row->cc_load_policy) ? '' : 'checked="checked"'); ?> value="0" >
                                                <label for="cc_load_policy0"><?php _e("No","ytwd"); ?></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="playsinline1" title="<?php _e("This setting lets you configure the videos will play without entering fullscreen mode on iOS devices.", "ytwd"); ?>"><?php _e("Enable iOS Playback","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" class="wd-form-el" id="playsinline1" name="playsinline" <?php echo (($row->playsinline) ? 'checked="checked"' : ''); ?> value="1" >
                                                <label for="playsinline1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" class="wd-form-el" id="playsinline0" name="playsinline" <?php echo (($row->playsinline) ? '' : 'checked="checked"'); ?> value="0" >
                                                <label for="playsinline0"><?php _e("No","ytwd"); ?></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="origin1" title="<?php _e("Enable this option to add extra security measure to your YouTube embed.", "ytwd"); ?>"><?php _e("Add Origin","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" class="ytwd_disabled_field" disabled readonly id="origin1" name="origin" checked="checked" value="1" >
                                                <label for="origin1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" class="ytwd_disabled_field" disabled readonly id="origin0" name="origin"  value="0" >
                                                <label for="origin0"><?php _e("No","ytwd"); ?></label>
												<div class="ytwd_pro_option">
													<small><?php _e("Only in the Paid version.","ytwd"); ?></small>
												</div>												
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="wmode1" title="<?php _e("Use Opaque for Wmode parameter to have higher performance on your YouTube embed. Mark Transparent to switch it off.", "ytwd"); ?>"><?php _e("Wmode","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" class="wd-form-el" id="wmode1" name="wmode" <?php echo (($row->wmode == "opaque") ? 'checked="checked"' : ''); ?> value="opaque" >
                                                <label for="wmode1"><?php _e("Opaque","ytwd"); ?></label>
                                                <input type="radio" class="wd-form-el" id="wmode0" name="wmode" <?php echo (($row->wmode == "transparent") ? 'checked="checked"' : ''); ?> value="transparent" >
                                                <label for="wmode0"><?php _e("Transparent","ytwd"); ?></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="initial_volume" title="<?php _e("Select the default volume of the player, which will be set to the video when it is first loaded. The user is able to control the volume afterwards.", "ytwd"); ?>"><?php _e("Initial Volume","ytwd");?>:</label></td>
                                            <td>
                                                <input type="text" name="initial_volume" id="initial_volume" value="<?php echo $row->initial_volume; ?>" data-slider="true" data-slider-highlight="true" data-slider-theme="volume" data-slider-values="<?php echo implode(",",range(0,100)); ?>" class="wd-form-el">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label for="video_quality" title="<?php _e("Choose the default quality for the main video. The user is able to change the quality of it during playback.", "ytwd"); ?>"><?php _e("Video Quality","ytwd");?>:</label></td>
                                            <td>
                                                 <select name="video_quality" id="video_quality" class="wd-form-el">
                                                    <?php foreach($video_qualities as $key => $value){
                                                        $selected = $key == $row->video_quality ? "selected" : "";
                                                        echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="start" title="<?php _e("Set the timestamp from the video and let users to start watching it from that particular moment. You can define hours, minutes and seconds.", "ytwd"); ?>"><?php _e("Start Video at","ytwd"); ?>:</label>
                                            </td>
                                            <td>
												<input type="text" class="start_hours ytwd_small_input" placeholder="HH" > : 
												<input type="text" class="start_minutes ytwd_small_input" placeholder="MM"> : 
												<input type="text" class="start_seconds ytwd_small_input" placeholder="SS">
												
                                                <input type="hidden" name="start" id="start" class="wd-form-el" value="<?php echo $row->start;?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="end" title="<?php _e("Define the timestamp from the video, when the video will end its playback. You can set hours, minutes and seconds.", "ytwd"); ?>"><?php _e("End Video at","ytwd"); ?>:</label>
                                            </td>
                                            <td>
												<input type="text" class="end_hours ytwd_small_input" placeholder="HH" > : 
												<input type="text" class="end_minutes ytwd_small_input" placeholder="MM"> : 
												<input type="text" class="end_seconds ytwd_small_input" placeholder="SS">
												
                                                <input type="hidden" name="end" id="end" class="wd-form-el" value="<?php echo $row->end;?>">											

                                              
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <!-- gallery settings -->
                                <div id="settings-gallery" class="wd-cell wd-cell-valign-top ytwd_tabs_container_item" <?php echo $active_tab == "settings-gallery" ? '' : 'style="display:none;"'; ?>>
                                   <?php
                                    if(!ytwd_get_option("api_key")){
                                        echo '<p style="font-size:18px;"><strong>'.__("Important. API key is required for YouTube channels and playlists galleries to work.","ytwd").'</strong></p>
                                        <p><a href="https://console.developers.google.com/apis/dashboard?project=vivid-plateau-136407" target="_blank" class="wd-btn wd-btn-primary" style="text-decoration:none;">'.__("GET API KEY FOR FREE","ytwd").'</a></p>
                                        <p>'.__("For getting API key read more in","ytwd").'
                                            <a href="https://web-dorado.com/wordpress-google-maps/installation-wizard-options-menu/configuring-api-key.html" target="_blank" style="color: #00A0D2;">'. __("User Manual","ytwd").'</a>.
                                        </p>
                                        <p>After creating the API key, please paste it here.</p>
                                        <form method="post">
                                            '.wp_nonce_field('nonce_ytwd', 'nonce_ytwd').'
                                            <p>'.__("API Key","ytwd").' <input type="text" name="ytwd_api_key_general"> <button class="wd-btn wd-btn-primary">'.__("Save","ytwd").'</button></p>
                                            <input type="hidden" name="task" value="save_api_key">
                                            <input type="hidden" name="page" value="'.$_GET["page"].'">
                                        </form>';
                                    }
                                     else{
                                    ?>
                                       <table class="ytwd_edit_table">
                                            <tr>
                                                <td><label for="enable_gallery1" title="<?php _e("Show gallery.", "ytwd"); ?>"><?php _e("Show Gallery","ytwd");?>:</label></td>
                                                <td>
                                                    <input type="radio" class="wd-form-el" id="enable_gallery1" name="enable_gallery" <?php echo (($row->enable_gallery) ? 'checked="checked"' : ''); ?> value="1" >
                                                    <label for="enable_gallery1"><?php _e("Yes","ytwd"); ?></label>
                                                    <input type="radio" class="wd-form-el" id="enable_gallery0" name="enable_gallery" <?php echo (($row->enable_gallery) ? '' : 'checked="checked"'); ?> value="0" >
                                                    <label for="enable_gallery0"><?php _e("No","ytwd"); ?></label>
                                                </td>
                                            </tr>
											<tbody class="ytwd_gallery_tbody">
                                            <tr>
                                                <td><label for="gallery_view_type" title="<?php _e("Choose the display type of your playlist/channel gallery. ", "ytwd"); ?>"><?php _e("Gallery View Type","ytwd");?>:</label></td>
                                                <td>
                                                    <select name="gallery_view_type" id="gallery_view_type" class="wd-form-el">
														<option value="thumbnails"><?php _e("Thumbnails", "ytwd"); ?></option>
                                                        <?php foreach($gallery_view_type as $key => $value){
                                                            echo '<option value="'.$key.'" '.$selected.' class="ytwd_disabled_field" disabled readonly>'.$value.'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="ytwd_thumbnails_column_number_tr" <?php echo $row->gallery_view_type == "thumbnails" ? "" : 'style="display:none;"'; ?>>
                                                <td><label for="thumbnails_column_number" title="<?php _e("Set the maximum number of columns, which will be used for displaying your YouTube gallery thumbnails in Thumbnails View. ", "ytwd"); ?>"><?php _e("Max. Number of Columns","ytwd");?>:</label></td>
                                                <td>
                                                     <input type="text" name="thumbnails_column_number" id="thumbnails_column_number" class="wd-form-el" value="<?php echo $row->thumbnails_column_number; ?>"> 
                                                </td>
                                            </tr>
											
                                            <tr class="ytwd_gallery_position_tr" <?php echo $row->gallery_view_type == 'blog_style' ? 'style="display:none;"' : ''; ?>>
                                                <td><label for="gallery_position" title="<?php _e("Select the position of your YouTube video gallery. It can be set to display above or below the main video of your YouTube channel or playlist.", "ytwd"); ?>"><?php _e("Gallery Position","ytwd");?>:</label></td>
                                                <td>
                                                    <select name="gallery_position" id="gallery_position" class="wd-form-el">
                                                        <?php foreach($gallery_positions as $key => $value){
                                                            $selected = $key == $row->gallery_position ? "selected" : "";
                                                            echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="ytwd_gallery_thumb_custom_size_tr" <?php echo  $row->gallery_view_type != 'blog_style' ? '' : 'style="display:none;"'; ?>>
                                                <td><label for="gallery_thumb_custom_size" title="<?php _e("Specify the custom width (in pixels) of your YouTube gallery thumbnails. Maximum recommended value of this option is 1280 pixels.", "ytwd"); ?>"><?php _e("Thumbnails Min Width","ytwd");?>:</label></td>
                                                <td>
                                                    <input type="text" name="gallery_thumb_custom_size" id="gallery_thumb_custom_size" class="wd-form-el" value="<?php echo $row->gallery_thumb_custom_size; ?>"> px
                                                    <div><small><?php _e("Maximum recommended value of this option is 1280 pixels","ytwd");?>.</small></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="gallery_items_count" title="<?php _e("Set the number of videos which will be displayed on one page of YouTube video gallery.", "ytwd"); ?>"><?php _e("Items Count Per Page","ytwd");?>:</label></td>
                                                <td>
                                                    <input type="number" class="wd-form-el" id="gallery_items_count" name="gallery_items_count" value="<?php echo $row->gallery_items_count; ?>" min="0" >                                             
											   </td>
                                            </tr>
                                            <tr>
                                                <td><label for="gallery_display_type" title="<?php _e("This setting indicates the pagination type your YouTube video gallery will use.", "ytwd"); ?>"><?php _e("Gallery View Type","ytwd");?>:</label></td>
                                                <td>
                                                    <input type="radio" class="wd-form-el" id="gallery_display_type0" name="gallery_display_type" <?php echo (($row->gallery_display_type == 0) ? 'checked="checked"' : ''); ?> value="0" >
                                                    <label for="gallery_display_type0"><?php _e("Pagination","ytwd"); ?></label><br>

                                                    <input type="radio" class="wd-form-el" id="gallery_display_type1" name="gallery_display_type" <?php echo (($row->gallery_display_type == 1) ? 'checked="checked"' : ''); ?> value="1" >
                                                    <label for="gallery_display_type1"><?php _e("Load More Button","ytwd"); ?></label><br>

                                                    <input type="radio" class="ytwd_disabled_field" disabled readonly id="gallery_display_type2" name="gallery_display_type"  value="2" >
                                                    <label for="gallery_display_type2"><?php _e("Infinite Scroll","ytwd"); ?></label>
													<div class="ytwd_pro_option">
														<small><?php _e("Only in the Paid version.","ytwd"); ?></small>
													</div> 
                                                </td>
                                            </tr>
                                            <tr class="ytwd_pagination_btn_text_tr" <?php echo $row->gallery_display_type == 0 ? '' : 'style="display:none;"';  ?> >
                                                <td><label for="prev_btn_text" title="<?php _e("You can provide the text for Previous button with this setting. In case you wish to only have arrows, leave the option value blank.", "ytwd"); ?>"><?php _e("Pagination Prev. Button Text","ytwd");?>:</label></td>
                                                <td>
                                                    <input type="text" class="wd-form-el" id="prev_btn_text" name="prev_btn_text" value="<?php echo $row->prev_btn_text;?>">
                                                </td>
                                            </tr>
                                            <tr class="ytwd_pagination_btn_text_tr" <?php echo $row->gallery_display_type == 0 ? '' : 'style="display:none;"';  ?>>
                                                <td><label for="next_btn_text" title="<?php _e("Similarly, this option sets the text for Next button with this setting. If you need to only have arrows for pagination, leave the option value blank.", "ytwd"); ?>"><?php _e("Pagination Next Button Text","ytwd");?>:</label></td>
                                                <td>
                                                    <input type="text" class="wd-form-el" id="next_btn_text" name="next_btn_text" value="<?php echo $row->next_btn_text;?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="gallery_order" title="<?php _e(" Choose the parameter based on which your YouTube videos will be ordered in your gallery.", "ytwd"); ?>"><?php _e("Order By","ytwd");?>:</label></td>
                                                <td>
                                                    <select name="gallery_order" id="gallery_order" class="ytwd_disabled_field" disabled readonly>
                                                        <?php foreach($gallery_order as $key => $value){
                                                            echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                                        }
                                                        ?>
                                                    </select>
													<div class="ytwd_pro_option">
														<small><?php _e("Only in the Paid version.","ytwd"); ?></small>
													</div> 													
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="gallery_order_dir" title="<?php _e("Specify the type of ordering based on Order By parameter.", "ytwd"); ?>"><?php _e("Order Direction","ytwd");?>:</label></td>
                                                <td>
                                                    <input type="radio" id="gallery_order_dir1" name="gallery_order_dir" checked="checked" value="asc" class="ytwd_disabled_field" disabled readonly >
                                                    <label for="gallery_order_dir1"><?php _e("Asc","ytwd"); ?></label>
                                                    <input type="radio" id="gallery_order_dir0" name="gallery_order_dir"  value="desc" class="ytwd_disabled_field" disabled readonly >
                                                    <label for="gallery_order_dir0"><?php _e("Desc","ytwd"); ?></label>
													<div class="ytwd_pro_option">
														<small><?php _e("Only in the Paid version.","ytwd"); ?></small>
													</div> 													
                                                </td>
                                            </tr>                                            
                                            <tr>
                                                <td><label for="enable_search1" title="<?php _e(" Enable this option to have a searchbox placed on your YouTube video gallery.", "ytwd"); ?>"><?php _e("Show Searchbox","ytwd");?>:</label></td>
                                                <td>
                                                    <input type="radio" id="enable_search1" name="enable_search" checked="checked" value="1"  class="ytwd_disabled_field" disabled readonly>
                                                    <label for="enable_search1"><?php _e("Yes","ytwd"); ?></label>
                                                    <input type="radio" id="enable_search0" name="enable_search"  value="0"  class="ytwd_disabled_field" disabled readonly >
                                                    <label for="enable_search0"><?php _e("No","ytwd"); ?></label>
													<div class="ytwd_pro_option">
														<small><?php _e("Only in the Paid version.","ytwd"); ?></small>
													</div> 													
                                                </td>
                                            </tr>
                                            <tr class="gallery_video_display_mode_tr" <?php echo $row->gallery_view_type == 'blog_style' ? 'style="display:none;"' : ''; ?>>
                                                <td><label for="gallery_video_display_mode" title="<?php _e("Select a display option for playing videos from your YouTube gallery.", "ytwd"); ?>"><?php _e("Gallery Video Display Mode","ytwd");?>:</label></td>
                                                <td>
                                                    <input type="radio" class="wd-form-el" id="gallery_video_display_mode0" name="gallery_video_display_mode" checked="checked" value="0" >
                                                    <label for="gallery_video_display_mode0"><?php _e("Iframe","ytwd"); ?></label><br>
													<div class="ytwd_pro_option">
														<small><?php _e("Only in the Paid version.","ytwd"); ?></small>
													</div>													
                                                    <input type="radio" class="ytwd_disabled_field" disabled readonly id="gallery_video_display_mode1" name="gallery_video_display_mode"  value="1" >
                                                    <label for="gallery_video_display_mode1"><?php _e("Popup","ytwd"); ?></label><br>
                                                    <input type="radio" class="ytwd_disabled_field" disabled readonly id="gallery_video_display_mode2" name="gallery_video_display_mode"  value="2" >
                                                    <label for="gallery_video_display_mode2"><?php _e("Inline","ytwd"); ?></label>  <br>
                                                    <input type="radio" class="ytwd_disabled_field" disabled readonly id="gallery_video_display_mode3" name="gallery_video_display_mode"  value="3" >
                                                    <label for="gallery_video_display_mode3"><?php _e("Youtube","ytwd"); ?></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="gallery_additional_info" title="<?php _e("This setting lets you enable or disable additional information from your  videos. It will be added under each video thumbnail.", "ytwd"); ?>"><?php _e("Show Additional Info","ytwd");?>:</label></td>
                                                <td>
                                                   <?php
                                                        $i = 0;
                                                        foreach($gallery_info as $key => $value){
                                                    ?>
                                                        <input type="checkbox" value="<?php echo $key;?>" class="gallery_additional_info wd-form-el" id="gallery_additional_info<?php echo $i; ?>" <?php echo in_array($key, explode(",", $row->gallery_additional_info)) ? "checked" : ""; ?>>
                                                        <label for="gallery_additional_info<?php echo $i; ?>"><?php echo $value; ?></label><br>
                                                    <?php
                                                        $i++;
                                                    }
                                                    ?>
													<div class="ytwd_pro_option">
														<small><?php _e("Only in the Paid version.","ytwd"); ?></small>
													</div>													
													<?php
                                                        foreach($gallery_info_pro as $key => $value){
                                                    ?>
                                                        <input type="checkbox" value="<?php echo $key;?>" class="ytwd_disabled_field" disabled readonly id="gallery_additional_info<?php echo $i; ?>" >
                                                        <label for="gallery_additional_info<?php echo $i; ?>"><?php echo $value; ?></label><br>
                                                    <?php
                                                        $i++;
                                                    }
                                                    ?>													
                                                    <input type="hidden" value="<?php echo $row->gallery_additional_info; ?>" name="gallery_additional_info" class="wd-form-el">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="single_line_title" title="<?php _e("This setting lets you enable or disable single line titles for gallery items.", "ytwd"); ?>"><?php _e("Single Line Title","ytwd");?>:</label></td>
                                                <td>
													<input type="radio" id="single_line_title1" name="single_line_title" <?php echo (($row->single_line_title) ? 'checked="checked"' : ''); ?> value="1" class="wd-form-el" >
													<label for="single_line_title1"><?php _e("Yes","ytwd"); ?></label>
													<input type="radio" id="single_line_title0" name="single_line_title" <?php echo (($row->single_line_title) ? '' : 'checked="checked"'); ?> value="0" class="wd-form-el">
													<label for="single_line_title0"><?php _e("No","ytwd"); ?></label>
													
                                                </td>
                                            </tr>											
                                            <tr>
                                                <td><label for="desc_max_lenght" title="<?php _e("This parameter indicates the maximum number of characters, which will be used for creating an excerpt from YouTube video description.", "ytwd"); ?>"><?php _e("Description Max Length","ytwd");?>:</label></td>
                                                <td>
                                                    <input type="text" class="ytwd_disabled_field" disabled readonly id="desc_max_lenght" name="desc_max_lenght" value="100" >
													<div class="ytwd_pro_option">
														<small><?php _e("Only in the Paid version.","ytwd"); ?></small>
													</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="loading_effects" title="<?php _e("Select one of the following effects to load gallery videos with. They will be triggered upon scrolling the page down.", "ytwd"); ?>"><?php _e("Gallery Loading Effects","ytwd");?>:</label></td>
                                                <td>
                                                     <select name="loading_effects" id="loading_effects" class="wd-form-el">
                                                        <?php foreach($loading_effects as $key => $value){
                                                            $selected = $key == $row->loading_effects ? "selected" : "";
                                                            echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                                        }
														
														foreach($loading_effects_pro as $key => $value){
                                                            echo '<option value="'.$key.'" class="ytwd_disabled_field" disabled readonly>'.$value.' (paid)</option>';
                                                        }														
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
											</tbody>
                                       </table>
                                    <?php
                                    }
                                    ?>
                                </div>

                                 <!-- general settings -->
                                <div id="settings-general" class="wd-cell wd-cell-valign-top ytwd_tabs_container_item" <?php echo $active_tab == "settings-general" ? '' : 'style="display:none;"'; ?>>
                                   <table class="ytwd_edit_table">
                                        <tr>
                                            <td><label for="theme_id" title="<?php _e("This setting lets you choose the theme from YouTube WD themes, which is going to be used on current YouTube entry. The default theme is pre-selected.", "ytwd"); ?>"><?php _e("Select Theme","ytwd");?>:</label></td>
                                            <td>
                                                <select name="theme_id" id="theme_id" class="ytwd_disabled_field" disabled readonly>
													<option>-Select-</option>
                                                </select>
												<div class="ytwd_pro_option">
													<small><?php _e("Only in the Paid version.","ytwd"); ?></small>
												</div>
												
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><label for="video_additional_info" title="<?php _e("With this option you can enable or disable the following attributes from the embedded YouTube video.", "ytwd"); ?>"><?php _e("Show Main Video Info","ytwd");?>:</label></td>
                                            <td>
                                                <?php
                                                    $i = 0;
                                                    foreach($video_info as $key => $value){
                                                        $additional_info_selected = ($key == "subscribe_btn") ? 'additional_info_selected' : '';
                                                ?>
                                                    <div class="<?php echo  $additional_info_selected; ?>">
                                                        <input type="checkbox" value="<?php echo $key;?>" class="video_additional_info wd-form-el ytwd-need-key" id="video_additional_info<?php echo $i; ?>" <?php echo in_array($key, explode(",", $row->video_additional_info)) ? "checked" : ""; ?>>
                                                        <label for="video_additional_info<?php echo $i; ?>"><?php echo $value; ?></label>
                                                    </div>
                                                <?php
                                                    $i++;
                                                }
                                                ?>
												<div class="ytwd_pro_option">
													<small><?php _e("Only in the Paid version.","ytwd"); ?></small>
												</div>	
                                                <?php
                                                    foreach($video_info_pro as $key => $value){
                                                ?>
                                                    <div class="<?php echo  $additional_info_selected; ?>">
                                                        <input type="checkbox" value="<?php echo $key;?>" class="ytwd_disabled_field" disabled readonly id="video_additional_info<?php echo $i; ?>" >
                                                        <label for="video_additional_info<?php echo $i; ?>" ><?php echo $value; ?></label>														
                                                    </div>
                                                <?php
                                                    $i++;
                                                }
                                                ?>											
                                                <input type="hidden" value="<?php echo $row->video_additional_info; ?>" name="video_additional_info" class="wd-form-el">
                                                <div class="ytwd_need_api_key"></div>
                                            </td>
										</tr>
										<tr>
											<td><label for="comments_count" title="<?php _e("Indicates the initial number of displayed comments under your YouTube WD entry.", "ytwd"); ?>"><?php _e("Comments Count Per Page","ytwd");?>:</label></td>
											<td>
												<input type="number" class="ytwd_disabled_field" disabled readonly id="comments_count" name="comments_count" value="10" min="0" max="50">
												<br><small><?php _e("Max count is 50.", "ytwd"); ?></small>
												 <div class="ytwd_need_api_key"></div>
												<div class="ytwd_pro_option">
													<small><?php _e("Only in the Paid version.","ytwd"); ?></small>
												</div>	
											</td>
										</tr>																		
										<tr>
                                            <td><label for="enable_share_btns1" title="<?php _e(" If activated, this setting will place a social sharing block under your YouTube entry.", "ytwd"); ?>"><?php _e("Enable Share Buttons","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" id="enable_share_btns1" name="enable_share_btns" <?php echo (($row->enable_share_btns) ? 'checked="checked"' : ''); ?> value="1" class="wd-form-el" >
                                                <label for="enable_share_btns1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" id="enable_share_btns0" name="enable_share_btns" <?php echo (($row->enable_share_btns) ? '' : 'checked="checked"'); ?> value="0" class="wd-form-el">
                                                <label for="enable_share_btns0"><?php _e("No","ytwd"); ?></label>
                                            </td>
                                        </tr>
                                        <tr class="show_video_info_by_default_tr" <?php echo $row->gallery_view_type == "blog_style" ? 'style="display:none;"' : ""; ?>>
                                            <td><label for="show_video_info_by_default" title="<?php _e("In case this option is enabled, the main description and published date of your YouTube video will appear along when you add it into a page or post.", "ytwd"); ?>"><?php _e("Show Main Video Info by default","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" id="show_video_info_by_default1" name="show_video_info_by_default" <?php echo (($row->show_video_info_by_default) ? 'checked="checked"' : ''); ?> value="1" class="wd-form-el ytwd-need-key" >
                                                <label for="show_video_info_by_default1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" id="show_video_info_by_default0" name="show_video_info_by_default" <?php echo (($row->show_video_info_by_default) ? '' : 'checked="checked"'); ?> value="0" class="wd-form-el ytwd-need-key">
                                                <label for="show_video_info_by_default0"><?php _e("No","ytwd"); ?></label>
												<div class="ytwd_need_api_key"></div>
                                            </td>
                                        </tr>										
                                        <tr class="enable_youtube_link_tr" <?php echo in_array("title", explode("," , $row->video_additional_info)) ? "" : 'style="display:none;"'; ?>>
                                            <td><label for="enable_youtube_link1" title="<?php _e("Enabling this setting lets you redirect users to the link of the YouTube page of your video upon clicking on its title.", "ytwd"); ?>"><?php _e("Show Main Video Title as Youtube Link","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" id="enable_youtube_link1" name="enable_youtube_link" <?php echo (($row->enable_youtube_link) ? 'checked="checked"' : ''); ?> value="1" class="wd-form-el ytwd-need-key">
                                                <label for="enable_youtube_link1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" id="enable_youtube_link0" name="enable_youtube_link" <?php echo (($row->enable_youtube_link) ? '' : 'checked="checked"'); ?> value="0" class="wd-form-el ytwd-need-key">
                                                <label for="enable_youtube_link0"><?php _e("No","ytwd"); ?></label>
                                                <div class="ytwd_need_api_key"></div>
                                            </td>
                                        </tr>

                                        <tr <?php echo ($row->embed_type == 0) ? 'style="display:none;"' : '';?> class="ytwd_channel_add_info">
                                            <td><label for="channel_additional_info" title="<?php _e("With this option you can enable or disable the following attributes from the embedded YouTube channel or playlist.", "ytwd"); ?>"><?php echo sprintf(__("Show %s Info","ytwd"), ($row->embed_type == 1 ? __("Playlist", "ytwd") : __("Channel", "ytwd") ) ); ?>:</label></td>
                                            <td>
                                                <?php
                                                    $i = 0;
                                                    foreach($channel_info as $key => $value){
                                                     $additional_info_selected_channel = ($key == "banner" || $key == "views_count" || $key == "subscribers_count" ) ? 'additional_info_selected_channel' : '';
                                                     
													 $additional_info_selected_playlist = ($key == "published_at"  ) ? 'additional_info_selected_playlist' : '';
													 $class = $additional_info_selected_channel ? $additional_info_selected_channel :$additional_info_selected_playlist;
                                                ?>
                                                    <div class="<?php echo $class ; ?>">
                                                        <input type="checkbox" value="<?php echo $key;?>" class="channel_additional_info wd-form-el ytwd-need-key" id="channel_additional_info<?php echo $i; ?>" <?php echo in_array($key, explode(",", $row->channel_additional_info)) ? "checked" : ""; ?>>
                                                        <label for="channel_additional_info<?php echo $i; ?>"><?php echo $value; ?></label>
                                                    </div>
                                                <?php
                                                    $i++;
                                                }
                                                ?>

                                                <input type="hidden" value="<?php echo $row->channel_additional_info; ?>" name="channel_additional_info" class="wd-form-el">
                                                <div class="ytwd_need_api_key"></div>
                                            </td>
                                        </tr>
                                        <tr class="enable_youtube_link_channel_tr" <?php echo in_array("title", explode("," , $row->channel_additional_info )) && $row->embed_type == 2 ? "" : 'style="display:none;"'; ?>>
                                            <td><label for="enable_youtube_link_channel1" title="<?php _e("Enabling this setting lets you redirect users to the link of the YouTube channel page upon clicking on its title.", "ytwd"); ?>"><?php _e("Show Channel Title as Youtube Link","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" id="enable_youtube_link_channel1" name="enable_youtube_link_channel" <?php echo (($row->enable_youtube_link_channel) ? 'checked="checked"' : ''); ?> value="1" class="wd-form-el ytwd-need-key">
                                                <label for="enable_youtube_link_channel1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" id="enable_youtube_link_channel0" name="enable_youtube_link_channel" <?php echo (($row->enable_youtube_link_channel) ? '' : 'checked="checked"'); ?> value="0" class="wd-form-el ytwd-need-key">
                                                <label for="enable_youtube_link_channel0"><?php _e("No","ytwd"); ?></label>
                                                <div class="ytwd_need_api_key"></div>
                                            </td>
                                        </tr>
                                        <tr class="enable_youtube_link_playlist_tr" <?php echo in_array("title", explode("," , $row->channel_additional_info )) && $row->embed_type == 1 ? "" : 'style="display:none;"'; ?>>
                                            <td><label for="enable_youtube_link_playlist1" title="<?php _e("Enabling this setting lets you redirect users to the link of the YouTube playlist page upon clicking on its title.", "ytwd"); ?>"><?php _e("Show Playlist Title as Youtube Link","ytwd");?>:</label></td>
                                            <td>
                                                <input type="radio" id="enable_youtube_link_playlist1" name="enable_youtube_link_playlist" <?php echo (($row->enable_youtube_link_playlist) ? 'checked="checked"' : ''); ?> value="1" class="wd-form-el ytwd-need-key">
                                                <label for="enable_youtube_link_playlist1"><?php _e("Yes","ytwd"); ?></label>
                                                <input type="radio" id="enable_youtube_link_playlist0" name="enable_youtube_link_playlist" <?php echo (($row->enable_youtube_link_playlist) ? '' : 'checked="checked"'); ?> value="0" class="wd-form-el ytwd-need-key">
                                                <label for="enable_youtube_link_playlist0"><?php _e("No","ytwd"); ?></label>
                                                <div class="ytwd_need_api_key"></div>
                                            </td>
                                        </tr>											
                                   </table>
                                </div>

                               </div>
                                <div class="wd-cell wd-cell-valign-top =" style="width: 64%;padding-left: 15px;">
                                    <div id="wd-youtube" class="wd_youtube ytwd_container_red_border wd-settings-container ">                                      
										<a class="refresh_preview wd-btn wd-btn-primary" href="#"><?php _e("Reload","ytwd");?></a>
										<span><strong><?php _e("Reload Preview to See Changes","ytwd");?></strong></span>   

                                        <?php
                                            $url = admin_url( 'index.php?page=ytwd_preview');
                                            $url = add_query_arg(array("item_id" => $row->id, "f_p" => 1), $url);
                                        ?>
                                        <div class="preview_container">
                                            <iframe src="<?php echo $row->id ? $url : ""; ?>" id="ytwd_preview_iframe" marginwidth="10"></iframe>
                                            <img src="<?php echo YTWD_URL."/assets/loader.png"; ?>" class="ytwd_loader">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </form>
<script>
    var initialVolume = "<?php echo $row->initial_volume; ?>";
    var ajaxURL = "<?php echo admin_url('admin-ajax.php');?>";
    var ytwdNonce = "<?php echo wp_create_nonce('nonce_ytwd'); ?>";
    var apiKey = "<?php echo ytwd_get_option('api_key');?>";
    var embedType = "<?php echo $row->embed_type; ?>";
    jQuery("[data-slider]").each(function () {
      var input = jQuery(this);
      jQuery("<span>").addClass("output").insertAfter(jQuery(this));
    }).bind("slider:ready slider:changed", function (event, data) {
      jQuery(this) .nextAll(".output:first").html(data.value.toFixed(1) + "%");
    });
    ytwdSlider(this.jQuery || this.Zepto, jQuery("#settings-player"));

</script>
</div>
