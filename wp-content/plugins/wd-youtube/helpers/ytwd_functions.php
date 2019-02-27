<?php
function ytwd_get_option($name)
{
    $settings = json_decode(get_option("ytwd_settings"), true);

    return (isset($settings[$name]) ? $settings[$name] : false);
}

function ytwd_get_youtube_embed_id($_url)
{
    $id = false;
    $url = parse_url($_url);
    if (isset($url['host'])) {
        if (strcasecmp($url['host'], 'youtu.be') === 0) {
            $id = substr($url['path'], 1);
        } else if (strcasecmp($url['host'], 'www.youtube.com') === 0) {
            if (isset($url['query'])) {
                parse_str($url['query'], $url['query']);
                if (isset($url['query']['v'])) {
                    $id = $url['query']['v'];
                } else if (isset($url['query']['list'])) {
                    $id = $url['query']['list'];
                }
            }
            if ($id == false) {
                $url['path'] = explode('/', substr($url['path'], 1));
                if (in_array($url['path'][0], array('e', 'embed', 'v'))) {
                    $id = $url['path'][1];
                }
            }
        }
    } else {
        $api_data = new YouTube_API_Data();
        $video_data = $api_data->search_api_data(urlencode($_url));
        if ($video_data) {
            $id = isset($video_data["items"][0]["id"]["videoId"]) ? $video_data["items"][0]["id"]["videoId"] : 0;
        }
    }

    return $id;
}

function ytwd_upgrade_pro($text = false)
{
    $page = isset($_GET["page"]) ? $_GET["page"] : "";
    $task = isset($_GET["task"]) ? $_GET["task"] : "";
    ?>
    <div class="ytwd_upgrade wd-clear">
        <div class="wd-left">
            <?php
            switch ($page) {
                case "youtube_ytwd":
                    if ($task == "edit") {
                        ?>
                        <div style="font-size: 14px; margin-top: 6px;">
                            <?php _e(" This section allows you to embed youtube videos, playlists, channels.", "ytwd"); ?>
                            <a style="color: #5CAEBD; text-decoration: none;border-bottom: 1px dotted;" target="_blank"
                               href="https://web-dorado.com/wordpress-youtube-wd/embedding.html"><?php _e("Read More in User Manual.", "ytwd"); ?></a>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div style="font-size: 14px;margin-top: 6px; ">
                            <?php _e(" This section allows you to manage youtube videos, playlists, channels.", "ytwd"); ?>
                            <a style="color: #5CAEBD; text-decoration: none;border-bottom: 1px dotted;" target="_blank"
                               href="https://web-dorado.com/wordpress-youtube-wd/embedding.html"><?php _e("Read More in User Manual.", "ytwd"); ?></a>
                        </div>
                        <?php
                    }
                    break;
                case "settings_ytwd":
                    ?>
                    <div style="font-size: 14px;margin-top: 6px;">
                        <?php _e(" This section allows you to change settings.", "ytwd"); ?>
                        <a style="color: #5CAEBD; text-decoration: none;border-bottom: 1px dotted;" target="_blank"
                           href="https://web-dorado.com/wordpress-youtube-wd/settings.html"><?php _e("Read More in User Manual.", "ytwd"); ?></a>
                    </div>
                    <?php
                    break;
            }
            ?>
        </div>
        <div class="wd-right">
            <div class="wd-table">
                <div class="wd-cell wd-cell-valign-middle">
                    <a href="https://wordpress.org/support/plugin/wd-youtube" target="_blank">
                        <img src="<?php echo YTWD_URL; ?>/assets/i_support.png">
                        Support Forum </a>
                </div>
                <div class="wd-cell wd-cell-valign-middle">
                    <a href="https://web-dorado.com/files/fromYoutube.php" target="_blank">
                        <?php _e("UPGRADE TO PAID VERSION", "gmwd"); ?>
                        <!--<div class="wd-table wd-upgrade-table">
                            <div class="wd-cell wd-cell-valign-middle">
                                <img src="<?php echo YTWD_URL; ?>/assets/web-dorado.png" width="42px">
                            </div>
                            <div class="wd-cell wd-cell-valign-middle">
                                <?php _e("UPGRADE TO PAID VERSION", "gmwd"); ?>
                            </div>
                        </div>-->
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php if ($text) {
    ?>
    <div class="wd-text-right wd-row" style="color: #15699F; font-size: 20px; margin-top:10px; padding:0px 15px;">
        <?php echo sprintf(__("This is FREE version, Customizing %s is available only in the PAID version.", "gmwd"), $text); ?>
    </div>
    <?php
}

}

function ytwd_message($message, $type)
{
    echo '<div style="width:99%"><div class="' . $type . '"><p><strong>' . $message . '</strong></p></div></div>';
}

function ytwd_sorting_data($data, $order_by, $order_dir)
{

    for ($i = 0; $i < count($data); $i++) {
        for ($j = $i + 1; $j < count($data); $j++) {
            if (($order_dir == "asc" && $data[$j][$order_by] < $data[$i][$order_by]) || ($order_dir == "desc" && $data[$j][$order_by] > $data[$i][$order_by])) {
                $y = $data[$i];
                $data[$i] = $data[$j];
                $data[$j] = $y;
            }
        }

    }

    return $data;

}

function ytwd_print_message()
{
    $message_id = isset($_GET["message_id"]) ? $_GET["message_id"] : "";
    if (!ctype_digit($message_id) && $message_id) {
        echo '<div style="width:99%"><div class="error"><p><strong>' . sanitize_text_field($message_id) . '</strong></p></div></div>';

        return;
    }
    switch ($message_id) {
        // save apply
        case "1":
            echo '<div style="width:99%"><div class="updated"><p><strong>' . __("Item Succesfully Saved.", "ytwd") . '</strong></p></div></div>';
            break;
        // save as copy
        case "2":
            echo '<div style="width:99%"><div class="updated"><p><strong>' . __("Item Succesfully Duplicated.", "ytwd") . '</strong></p></div></div>';
            break;
        // dublicate
        case "3":
            echo '<div style="width:99%"><div class="updated"><p><strong>' . __("Item(s) Succesfully Duplicated.", "ytwd") . '</strong></p></div></div>';
            break;
        //remove
        case "4":
            echo '<div style="width:99%"><div class="updated"><p><strong>' . __("Item(s) Succesfully Removed.", "ytwd") . '</strong></p></div></div>';
            break;
        //publish
        case "5":
            echo '<div style="width:99%"><div class="updated"><p><strong>' . __("Item(s) Succesfully Published.", "ytwd") . '</strong></p></div></div>';
            break;
        //unpublish
        case "6":
            echo '<div style="width:99%"><div class="updated"><p><strong>' . __("Item(s) Succesfully Unublished.", "ytwd") . '</strong></p></div></div>';
            break;
        // one item
        case "7":
            echo '<div style="width:99%"><div class="error"><p><strong>' . __("You Must Select At Least One Item. ", "ytwd") . '</strong></p></div></div>';
            break;
        // import
        case "8":
            echo '<div style="width:99%"><div class="updated"><p><strong>' . __("Successfully Imported.", "ytwd") . '</strong></p></div></div>';
            break;
        // unexepted file
        case "9":
            echo '<div style="width:99%"><div class="error"><p><strong>' . __("Unexepted File.", "ytwd") . '</strong></p></div></div>';
            break;
        case "10":
            echo '<div style="width:99%"><div class="updated"><p><strong>' . __("Options Succesfully Saved.", "ytwd") . '</strong></p></div></div>';
            break;
        case "11":
            echo '<div style="width:99%"><div class="updated"><p><strong>' . __("The Item Is Successfully Set as Default.", "ytwd") . '</strong></p></div></div>';
            break;
    }
}

function ytwd_redirect($url)
{
    ?>
    <script>
        window.location = "<?php echo $url; ?>";
    </script>
    <?php
    exit;
}

function ytwd_number_shorten($number, $precision = 1)
{
    $divisors = array(
        pow(1000, 0) => '', // 1000^0 == 1
        pow(1000, 1) => 'K', // Thousand
        pow(1000, 2) => 'M', // Million
        pow(1000, 3) => 'B', // Billion
        pow(1000, 4) => 'T', // Trillion
    );

    foreach ($divisors as $divisor => $shorthand) {
        if ($number < ($divisor * 1000)) {
            break;
        }
    }
    if ($shorthand == "") {
        return $number;
    }

    return number_format($number / $divisor, $precision) . $shorthand;
}

function ytwd_search($search_by, $search_value, $form_id)
{
    ?>
    <div class="alignleft actions">
        <script>
            function ytwd_search() {
                document.getElementById("page_number").value = "1";
                document.getElementById("search_or_not").value = "search";
                document.getElementById("<?php echo $form_id; ?>").submit();
            }

            function ytwd_reset() {
                if (document.getElementById("search_value")) {
                    document.getElementById("search_value").value = "";
                }
                if (document.getElementById("search_select_value")) {
                    document.getElementById("search_select_value").value = 0;
                }
                document.getElementById("<?php echo $form_id; ?>").submit();
            }

            function check_search_key(e, that) {
                var key_code = (e.keyCode ? e.keyCode : e.which);
                if (key_code == 13) { /*Enter keycode*/
                    spider_search();
                    return false;
                }
                return true;
            }
        </script>
        <div class="alignleft actions" style="">
            <label for="search_value" style="font-size:14px;  display:inline-block;"><?php echo $search_by; ?>:</label>
            <input type="text" id="search_value" name="search_value" onkeypress="return check_search_key(event, this);"
                   value="<?php echo esc_html($search_value); ?>" style="width: 287px;"/>
        </div>
        <div class="alignleft actions ">
            <input type="button" value="" onclick="ytwd_search()" class="wd-search-btn">
            <input type="button" value="" onclick="ytwd_reset()" class="wd-reset-btn">
        </div>
        <div class="wd-clear"></div>
    </div>
    <?php
}

function ytwd_html_page_nav($count_items, $pager, $page_number, $form_id, $items_per_page = 20)
{
    $limit = $items_per_page;
    if ($count_items) {
        if ($count_items % $limit) {
            $items_county = ($count_items - $count_items % $limit) / $limit + 1;
        } else {
            $items_county = ($count_items - $count_items % $limit) / $limit;
        }
    } else {
        $items_county = 1;
    }
    if (!$pager) {
        ?>
        <script type="text/javascript">
            var items_county = <?php echo $items_county; ?>;

            function spider_page(x, y) {
                switch (y) {
                    case 1:
                        if (x >= items_county) {
                            document.getElementById('page_number').value = items_county;
                        }
                        else {
                            document.getElementById('page_number').value = x + 1;
                        }
                        break;
                    case 2:
                        document.getElementById('page_number').value = items_county;
                        break;
                    case -1:
                        if (x == 1) {
                            document.getElementById('page_number').value = 1;
                        }
                        else {
                            document.getElementById('page_number').value = x - 1;
                        }
                        break;
                    case -2:
                        document.getElementById('page_number').value = 1;
                        break;
                    default:
                        document.getElementById('page_number').value = 1;
                }
                document.getElementById('<?php echo $form_id; ?>').submit();
            }

            function check_enter_key(e, that) {
                var key_code = (e.keyCode ? e.keyCode : e.which);
                if (key_code == 13) { /*Enter keycode*/
                    if (jQuery(that).val() >= items_county) {
                        document.getElementById('page_number').value = items_county;
                    }
                    else {
                        document.getElementById('page_number').value = jQuery(that).val();
                    }
                    document.getElementById('<?php echo $form_id; ?>').submit();
                }
                return true;
            }
        </script>
    <?php } ?>
    <div class="tablenav-pages">
      <span class="displaying-num">
        <?php
        if ($count_items != 0) {
            echo $count_items; ?> item<?php echo(($count_items == 1) ? '' : 's');
        }
        ?>
      </span>
        <?php
        if ($count_items > $items_per_page) {
        $first_page = "first-page";
        $prev_page = "prev-page";
        $next_page = "next-page";
        $last_page = "last-page";
        if ($page_number == 1) {
            $first_page = "first-page disabled";
            $prev_page = "prev-page disabled";
            $next_page = "next-page";
            $last_page = "last-page";
        }
        if ($page_number >= $items_county) {
            $first_page = "first-page ";
            $prev_page = "prev-page";
            $next_page = "next-page disabled";
            $last_page = "last-page disabled";
        }
        ?>
        <span class="pagination-links">
        <a class="<?php echo $first_page; ?>" title="Go to the first page"
           href="javascript:spider_page(<?php echo $page_number; ?>,-2);">«</a>
        <a class="<?php echo $prev_page; ?>" title="Go to the previous page"
           href="javascript:spider_page(<?php echo $page_number; ?>,-1);">‹</a>
        <span class="paging-input">
          <span class="total-pages">
          <input class="current_page" id="current_page" name="current_page" value="<?php echo $page_number; ?>"
                 onkeypress="return check_enter_key(event, this)" title="Go to the page" type="text" size="1"/>
        </span> of
        <span class="total-pages">
            <?php echo $items_county; ?>
          </span>
        </span>
        <a class="<?php echo $next_page ?>" title="Go to the next page"
           href="javascript:spider_page(<?php echo $page_number; ?>,1);">›</a>
        <a class="<?php echo $last_page ?>" title="Go to the last page"
           href="javascript:spider_page(<?php echo $page_number; ?>,2);">»</a>
            <?php
            }
            ?>
      </span>
    </div>
    <?php if (!$pager) { ?>
    <input type="hidden" id="page_number" name="page_number"
           value="<?php echo((isset($_POST['page_number'])) ? (int)$_POST['page_number'] : 1); ?>"/>
    <input type="hidden" id="search_or_not" name="search_or_not"
           value="<?php echo((isset($_POST['search_or_not'])) ? esc_html($_POST['search_or_not']) : ''); ?>"/>
    <?php
}
}

function ytwd_api_key_notice()
{

    echo '<div style="width:99%">
                <div class="error">
                    <p style="font-size:18px;"><strong>' . __("Important. API key is required for YouTube channels and playlists to work.", "ytwd") . '</strong></p>
                    <p><a name="' . __('Generate API Key - ( MUST be logged in to your Google account )', 'ytwd') . '" href=\'https://console.developers.google.com/henhouse/?pb=["hh-1","youtube.googleapis.com",null,[],"https://developers.google.com",null,["youtube.googleapis.com","youtubeanalytics.googleapis.com","youtubereporting.googleapis.com"],null]&TB_iframe=true&width=600&height=400\'  class="wd-btn wd-btn-primary thickbox thickbox-preview" style="text-decoration:none;">' . __("GET API KEY FOR FREE", "ytwd") . '</a></p>
					<p>' . __("For getting API key read more in", "ytwd") . '
						<a href="https://web-dorado.com/wordpress-youtube-wd/configuring-api.html" target="_blank" style="color: #00A0D2;">' . __("User Manual", "ytwd") . '</a>.
					</p> 
                    <p>After creating the API key, please paste it here.</p>
                    <form method="post">
                        ' . wp_nonce_field('nonce_ytwd', 'nonce_ytwd') . '
                        <p>' . __("API Key", "ytwd") . ' <input type="text" name="ytwd_api_key_general"> <button class="wd-btn wd-btn-primary">' . __("Save", "ytwd") . '</button></p>
                        <input type="hidden" name="task" value="save_api_key">
                        <input type="hidden" name="page" value="' . $_GET["page"] . '">
                    </form>
                </div>
          </div>';
}

?>
