
<!--<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>	/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>-->


<?php if (get_bloginfo('version') >= '4.5') { ?>
<link media="all" type="text/css" href="<?php echo get_admin_url(); ?>load-styles.php?c=1&dir=ltr&load%5B%5D=dashicons,admin-bar,common,forms,admin-menu,dashboard,list-tables,edit,revisions,media,themes,about,nav-menus,widgets,site-icon,&load%5B%5D=l10n,buttons,wp-auth-check,media-views" rel="stylesheet">
<?php }
else{
?>
<link media="all" type="text/css" href="<?php echo get_admin_url(); ?>load-styles.php?c=1&amp;dir=ltr&amp;load=admin-bar,wp-admin,dashicons,buttons,wp-auth-check" rel="stylesheet">
<?php
}
if (get_bloginfo('version') < '3.9') { ?>
<link media="all" type="text/css" href="<?php echo get_admin_url(); ?>css/colors<?php echo ((get_bloginfo('version') < '3.8') ? '-fresh' : ''); ?>.min.css" id="colors-css" rel="stylesheet">
<?php } ?>
<link media="all" type="text/css" href="<?php echo YTWD_URL . '/css/admin_main.css'; ?>" rel="stylesheet">

<div class="" >

    <?php
        if (isset($_POST['tag_text'])) {
            echo '<script>top.tinyMCE.activeEditor.windowManager.close(window);</script>';
            die();
        }
    ?>
    <h2 style="width:98%; margin: 0px auto 15px;"><?php _e("YouTube WD","ytwd");?></h2>
    <form method="post" action="" id="adminForm">
        <?php wp_nonce_field('nonce_ytwd', 'nonce_ytwd'); ?>
        <table class="shortcode_table" style="width:98%; margin: 0 auto;">
            <tr>
                <td class="wd-cell-valign-top">
                    <table>
                        <tr>
                            <td style="width:50%"><label for="item"><?php _e("Select YouTube Embed","ytwd");?>:</label></td>
                            <td>
                                <select name="item" id="item" onchange="onSelectEmbedChange(this);" style="width:200px;">
                                    <option value="0"><?php _e("-Select-","ytwd");?></option>
                                    <?php
                                        foreach($embeds as $key => $value){
                                            echo '<option value="'.$key.'" >'.$value.'</option>';
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: right; padding-top: 8px;">
                                <input type="button" id="wd_insert" name="" value="Insert" class="wd-btn wd-btn-primary" style="background-color: #686668;color: #FFF;border: 1px solid #686668!important;" onClick="ytwdInsertShortcode();" />

                                <input type="button" id="" name="" value="Cancel" class="wd-btn wd-btn-secondary" onClick="top.tinyMCE.activeEditor.windowManager.close(window);" style="border: 1px solid #686668;" />
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="wd-cell-valign-top">
                    <div id="wd-palyer-container">
                        <div id="wd-player">
                            <iframe id="ytwd_player_iframe" width="440" height="290" src=""
                            frameborder="0" enablejsapi="1" allowfullscreen ></iframe>
                        </div>
                    </div>
                </td>
             </tr>

        </table>
        <input type="hidden" name="page" id="page" value="shortcode_ytwd">
        <input type="hidden" name="task" id="task" value="">
        <input type="hidden" name="id" id="id" value="">
        <input type="hidden" name="tag_text" id="tag_text" value="">
        <input type="hidden" name="insert" id="insert" value="">
    </form>
</div>
<script>
	jQuery("#id").val(<?php echo $max_short_code_id + 1;?>);	
    ytwdShortcodeEdit();

    function onSelectEmbedChange(obj){
        var id = jQuery(obj).val();
        ytwdInitShortcodeYouTube(id);
    }

    function ytwdInitShortcodeYouTube(id){
        var data = {};
        data.embed = id;
        data.from_db = 1;
        data.action = "get_embed_ajax_data";
        data.nonce_ytwd = "<?php echo wp_create_nonce('nonce_ytwd'); ?>";

        jQuery.post('<?php echo admin_url('admin-ajax.php');?>',  data, function (data){
            data = JSON.parse(data);
            if(typeof data.video_url != 'undefined'){
                jQuery("#ytwd_player_iframe").attr("src", data.video_url);
            }
        });
    }
    function ytwdShortcodeEdit(){

        var shortcodeParams = ytwdShortcodeParams();

        if( shortcodeParams != false ){

            for(param in shortcodeParams){
                if(jQuery("#" + param).is("input[type=checkbox]") || jQuery("#" + param).is("input[type=radio]") ){
                    jQuery("#" + param).removeAttr("checked");
                    jQuery("#" + param + "[value='" + shortcodeParams[param] + "']").attr("checked","checked");
                }
                else if(jQuery("#" + param).is("select")){
                    jQuery("#" + param + " option").removeAttr("selected");
                    jQuery("#" + param).find("[value='" + shortcodeParams[param] + "']").attr("selected","selected");
                }
                else {
                    jQuery("#" + param).val(shortcodeParams[param]);
                }
            }
            jQuery("#wd_insert").val("Update");
            jQuery("#insert").val(0);
            ytwdInitShortcodeYouTube(jQuery("#item :selected").val());
        }
        else{

            jQuery("#wd_insert").val("Insert");
            jQuery("#insert").val(1);
        }
    }

    function ytwdShortcodeParams(){
        var params = {};

        //var editorText = tinyMCE.activeEditor.selection.getContent();
        var editorText = top.tinyMCE.activeEditor.selection.getContent();

        var start = editorText.indexOf("[YouTube_WD");
        var end = editorText.indexOf("]", start);
        var shortcodes = [];

        <?php foreach($shortcodes as $shortcode){
        ?>
            shortcodes[<?php echo $shortcode->id;?>] = "<?php echo $shortcode->tag_text;?>";
        <?php
        }
        ?>

        if (start > -1 && end >-1 ) {

            currentIdStr = editorText.substring(start + 1, end);
            currentIdStr = currentIdStr.substring(currentIdStr.indexOf(" ") + 1);

            currentIdArray = currentIdStr.split(" ");

            var currentId =  currentIdArray[0].split("=");
            currentId = currentId[1];
			if(currentId){
				jQuery("#id").val(currentId);
			}
			else{
				jQuery("#id").val(<?php echo $max_short_code_id + 1;?>);	
			}

            paramsText = shortcodes[currentId];

            paramsArray = paramsText.split(" ");

            for(var j=0; j<paramsArray.length; j++){
                var param = paramsArray[j].split("=");
                params[param[0]] = param[1];
            }
            return params;
        }

        return false;
    }

    function ytwdInsertShortcode(){
        var plugin_url = '<?php echo YTWD_URL; ?>'
        var short_code = '[YouTube_WD ';

        var tagText = "id=" + jQuery("#id").val() + " item=" + jQuery("#item :selected").val();

        short_code = short_code + tagText + ']';

        short_code = short_code.replace(/\[YouTube_WD([^\]]*)\]/g, function(d, c) {
            return '<img src="' + plugin_url + '/assets/icon-yt-50.png" alt="YouTube_WD id=' + jQuery("#id").val() + ' item='+ jQuery("#item :selected").val() + '" title="YouTube_WD id=' + jQuery("#id").val() + ' item='+ jQuery("#item :selected").val() + '" class="ytwd_shortcode mceItem" >';
        });

        //window.parent.tinyMCE.DOM.encode(c)

        jQuery("#page").val("shortcode_ytwd");
        jQuery("#task").val("save");

        jQuery("#tag_text").val(tagText);
        jQuery("#adminForm").submit();

        //window.tinyMCE.execCommand('mceInsertContent', false, short_code);
        top.tinyMCE.execCommand('mceInsertContent', false, short_code);
        //tinyMCEPopup.editor.execCommand('mceRepaint');
    }




</script>
