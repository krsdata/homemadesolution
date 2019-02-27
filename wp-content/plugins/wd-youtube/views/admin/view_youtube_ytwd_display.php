<div class="ytwd">
    <form method="post" action="" id="adminForm">
    <?php wp_nonce_field('nonce_ytwd', 'nonce_ytwd'); ?>
        <!-- header -->
        <h2>
            <img src="<?php echo YTWD_URL . '/assets/icon-yt.png';?>" width="50" style="vertical-align: middle;">
            <span><?php _e("YouTube","ytwd");?></span>
            <a class="wd-btn wd-btn-primary wd-btn-icon wd-btn-addnew" href="admin.php?page=youtube_ytwd&task=edit"><?php _e("Add new","ytwd");?></a>
        </h2>
        <!-- filters and actions -->
        <div class="wd_filters_actions wd-row wd-clear">
            <!-- filters-->
            <div class="wd-left">
                <?php echo ytwd_search(__('Title',"ytwd"), $search_value, 'adminForm'); ?>
            </div>
            <!-- actions-->
            <div class="wd-right">
                <div class="wd-table ytwd_btns">
                    <div class="wd-cell wd-cell-valign-middle">
                        <button class="wd-btn wd-btn-primary wd-btn-icon wd-btn-publish" onclick="ytwdFormInputSet('task', 'publish');ytwdFormInputSet('publish_unpublish', '1')"><?php _e("Publish","ytwd");?></button>
                    </div>
                    <div class="wd-cell wd-cell-valign-middle">
                        <button class="wd-btn wd-btn-primary wd-btn-icon wd-btn-unpublish" onclick="ytwdFormInputSet('task', 'publish');ytwdFormInputSet('publish_unpublish', '0')"><?php _e("Unpublish","ytwd");?></button>
                    </div>
                    <div class="wd-cell wd-cell-valign-middle">
                        <button class="wd-btn wd-btn-primary wd-btn-icon wd-btn-dublicate" onclick="ytwdFormInputSet('task', 'duplicate');"><?php _e("Duplicate","ytwd");?></button>
                    </div>
                    <div class="wd-cell wd-cell-valign-middle">
                        <button class="wd-btn wd-btn-primary wd-btn-icon wd-btn-delete" onclick="if (confirm('<?php _e("Do you want to delete selected items?","ytwd"); ?>')) { ytwdFormInputSet('task', 'remove');} else { return false;}"><?php _e("Delete","ytwd");?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- pagination-->
        <div class="wd-right wd-clear">
            <?php ytwd_html_page_nav($page_nav['total'], $pager++, $page_nav['limit'], 'adminForm', $per_page);?>
        </div>
        <!-- rows-->
        <table class="wp-list-table widefat fixed pages ytwd_list_table">
            <thead>
                <tr class="ytwd_alternate">
                    <th scope="col" id="cb" class="manage-column column-cb check-column" style="">
                        <label class="screen-reader-text" for="cb-select-all-1"><?php _e("Select All","ytwd"); ?></label>
                        <input id="cb-select-all-1" type="checkbox">
                    </th>
                    <th class="col <?php if ($order_by == 'id') {echo $order_class;} ?>" width="8%">
                        <a onclick="ytwdFormInputSet('order_by', 'id');
                                    ytwdFormInputSet('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'id') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                                    document.getElementById('adminForm').submit();return false;" href="">
                          <span>ID</span><span class="sorting-indicator"></span>
                        </a>
                    </th>

                    <th class="col <?php if ($order_by == 'title') {echo $order_class;} ?>">
                        <a onclick="ytwdFormInputSet('order_by', 'title');
                                    ytwdFormInputSet('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'title') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                                    document.getElementById('adminForm').submit();return false;" href="">
                          <span><?php _e("Title","ytwd"); ?></span><span class="sorting-indicator"></span>
                        </a>
                    </th>
                    <th class="col">
                      <span><?php _e("Shortcode","ytwd"); ?></span><span class="sorting-indicator"></span>
                    </th>
                    <th class="col">
                        <span><?php _e("PHP Function","ytwd"); ?></span><span class="sorting-indicator"></span>
                    </th>
                    <th class="col <?php if ($order_by == 'published') {echo $order_class;} ?>" width="10%">
                        <a onclick="ytwdFormInputSet('order_by', 'published');
                                    ytwdFormInputSet('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'published') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                                    document.getElementById('adminForm').submit();return false;" href="">
                          <span><?php _e("Published","ytwd"); ?></span><span class="sorting-indicator"></span>
                        </a>
                    </th>
                </tr>
            </thead>

            <tbody>
            <?php
                if(empty($rows ) == false){
                    $iterator = 0;
                    foreach($rows as $row){
                        $alternate = $iterator%2 != 0 ? "class='ytwd_alternate'" : "";
                        $published_image = (($row->published) ? 'publish-blue' : 'unpublish-blue');
                        $published = (($row->published) ? 0 : 1);
                ?>
                        <tr id="tr_<?php echo $iterator; ?>" <?php echo $alternate; ?>>
                            <th scope="row" class="check-column">
                                <input type="checkbox" name="ids[]" value="<?php echo $row->id; ?>">
                            </th>
                            <td class="id column-id">
                                <?php echo $row->id;?>
                            </td>
                            <td class="title column-title">
                                <a href="admin.php?page=youtube_ytwd&task=edit&id=<?php echo $row->id;?>">
                                    <?php echo $row->title;?>
                                </a>
                            </td>
                            <td class="shortcode column-shortcode">
                                <input type="text" style="border: 1px solid #eee; padding: 1px 4px;background: rgba(208, 203, 203, 0.1);width: 240px;" value="<?php echo '[YouTube_WD id='.$row->shortcode_id.' item='.$row->id.']';?>" readonly onclick="jQuery(this).focus();jQuery(this).select();">
                            </td>
                            <td class="php_function column-php_function">
                                <input type="text" style="border: 1px solid #eee; padding: 1px 4px;background: rgba(208, 203, 203, 0.1);" value="&#60;?php ytwd( <?php echo $row->shortcode_id; ?>, <?php echo $row->id; ?>); ?&#62;" readonly onclick="jQuery(this).focus();jQuery(this).select();">
                            </td>

                            <td class="table_big_col" align="center">
                                <a onclick="ytwdFormInputSet('task', 'publish');ytwdFormInputSet('publish_unpublish', '<?php echo $published ; ?>');ytwdFormInputSet('current_id', '<?php echo $row->id; ?>');document.getElementById('adminForm').submit();return false;" href="">
                                    <img src="<?php echo YTWD_URL . '/assets/css/' . $published_image . '.png'; ?>"></img>
                                </a>
                            </td>

                        </tr>
                <?php
                        $iterator++;
                        }
                    }
                ?>
            </tbody>
        </table>

        <input id="page" name="page" type="hidden" value="<?php echo $page;?>" />
        <input id="task" name="task" type="hidden" value="" />
        <input id="asc_or_desc" name="asc_or_desc" type="hidden" value="asc" />
        <input id="order_by" name="order_by" type="hidden" value="<?php echo $order_by; ?>" />
        <input id="current_id" name="current_id" type="hidden" value="" />
        <input id="publish_unpublish" name="publish_unpublish" type="hidden" value="" />
    </form>
</div>
