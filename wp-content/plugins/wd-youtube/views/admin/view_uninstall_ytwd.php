<form method="post" action="" id="adminForm">
    <?php wp_nonce_field('nonce_ytwd', 'nonce_ytwd'); ?>
    <div class="ytwd">
    
        <h2>
            <img src="<?php echo YTWD_URL . '/assets/uninstall.png';?>" width="30" style="vertical-align:middle;">
            <span><?php _e("Uninstall YouTube WD","ytwd"); ?></span>
        </h2>
        <div class="goodbye-text">
            <?php
            $support_team = '<a href="https://web-dorado.com/support/contact-us.html?source=wd-google-maps" target="_blank">' . __('support team', 'bwg_back') . '</a>';
            $contact_us = '<a href="https://web-dorado.com/support/contact-us.html?source=wd-google-maps" target="_blank">' . __('Contact us', 'bwg_back') . '</a>';
            
            echo sprintf(__("Before uninstalling the plugin, please Contact our %s. We'll do our best to help you out with your issue. We value each and every user and value what's right for our users in everything we do.<br />
            However, if anyway you have made a decision to uninstall the plugin, please take a minute to %s and tell what you didn't like for our plugins further improvement and development. Thank you !!!", "ytwd"), $support_team, $contact_us); ?>
        </div>                
        <p>
          <?php _e("Deactivating YouTube WD plugin does not remove any data that may have been created. To completely remove this plugin, you can uninstall it here.","ytwd"); ?>
        </p>
        <p style="color: red;">
          <strong><?php _e("WARNING:","ytwd"); ?></strong>
          <?php _e("Once uninstalled, this can't be undone. You should use a Database Backup plugin of WordPress to back up all the data first.","ytwd"); ?>
        </p>
        <p style="color: red">
            <strong><?php _e("The following Database Tables will be deleted:","ytwd"); ?></strong>
        </p>
        <table class="widefat">
            <thead>
                <tr>
                    <th><?php _e("Database Tables","ytwd"); ?></th>
                </tr>
            </thead>
            <tr>
                <td valign="top">
                    <ol>
                      <li><?php echo $prefix; ?>ytwd_youtube</li>
                      <li><?php echo $prefix; ?>ytwd_themes</li>
                      <li><?php echo $prefix; ?>ytwd_shortcodes</li>
                    </ol>
                </td>
            </tr>                
        </table>
        <p style="text-align: center;">	<?php _e("Do you really want to uninstall YouTube WD?","ytwd"); ?></p>
        <p style="text-align: center;">
            <input type="checkbox" name="unistall_ytwd" id="check_yes" value="yes" />&nbsp;
            <label for="check_yes"><?php _e("Yes","ytwd"); ?></label>
        </p>
        <p style="text-align: center;">
        <input type="button" value="<?php _e("UNINSTALL","ytwd"); ?>" class="wd-btn wd-btn-primary" 
        onclick="if (check_yes.checked) { 
                                                                            if (confirm('You are About to Uninstall YouTube WD from WordPress.\nThis Action Is Not Reversible.')) {
                                                                                ytwdFormSubmit('uninstall');
                                                                            } else {
                                                                                return false;
                                                                            }
                                                                          }
                                                                          else {
                                                                            return false;
                                                                          }" />
        </p>				
    </div>	
    
    <input id="page" name="page" type="hidden" value="<?php echo $page;?>" />							
    <input id="task" name="task" type="hidden" value="" />
</form>

