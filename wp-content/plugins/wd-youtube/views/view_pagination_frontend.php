
<div class="ytwd_pagination_wrapper<?php echo $shortcode_id; ?>">
    <?php if($row->gallery_display_type == 0){
    ?>
        <ul class="ytwd_pagination ytwd_pagination<?php echo $shortcode_id; ?>">
            <li class="ytwd_pagination_btn ytwd_pagination_btn<?php echo $shortcode_id; ?> ytwd_pagination_btn_prev<?php echo $shortcode_id; ?>"
            data-page="0" data-direction="-1" style="display:none;">
                <i class="fa <?php echo $theme->pagination_btns_style; ?>-left"></i>
                <span class="pag_text"><?php echo $row->prev_btn_text; ?></span>
            </li>
            <li>
                &nbsp;&nbsp;
                <span class="ytwd_current_page<?php echo $shortcode_id; ?>"> 1 </span>
                &nbsp;<?php _e("of", "ytwd"); ?>&nbsp;
                <span class="ytwd_num_pages<?php echo $shortcode_id; ?>"><?php echo $num_pages; ?></span>
                &nbsp;&nbsp;
            </li>
            <li class="ytwd_pagination_btn ytwd_pagination_btn<?php echo $shortcode_id; ?> ytwd_pagination_btn_next<?php echo $shortcode_id; ?>" data-page="1"  data-direction="+1" style="display:none;">
             <span class="pag_text"><?php echo $row->next_btn_text; ?></span>
             <i class="fa <?php echo $theme->pagination_btns_style; ?>-right"></i>
            </li>
        </ul>
    <?php
    }
    else if($row->gallery_display_type == 1){
    ?>
        <div class="ytwd_load_more_wrapper ytwd_load_more_wrapper<?php echo $shortcode_id; ?>">
            <div class="ytwd_load_more ytwd_load_more<?php echo $shortcode_id; ?>" data-limit="<?php echo 2*$row->gallery_items_count; ?>"><?php _e("Load More", "ytwd"); ?></div>
        </div>
    <?php
    }
    ?>
</div>

<style>
    .ytwd_pagination<?php echo $shortcode_id; ?> li{
        color: #<?php echo $theme->pagination_btns_color; ?>;
        font-size: <?php echo $theme->pagination_btns_font_size; ?>px;
    }
    .ytwd_pagination_wrapper<?php echo $shortcode_id; ?>{
        text-align: <?php echo $theme->pagination_alignment; ?>;
    }
    .ytwd_load_more<?php echo $shortcode_id; ?>{
        width: <?php echo $theme->load_more_btn_width; ?>px;
        height: <?php echo $theme->load_more_btn_height; ?>px;
        font-size: <?php echo $theme->load_more_btn_font_size; ?>px;
        color: #<?php echo $theme->load_more_btn_color; ?>;
        background: #<?php echo $theme->load_more_btn_bgcolor; ?>;
        border-style: <?php echo $theme->load_more_btn_border_style; ?>;
        border-radius: <?php echo $theme->load_more_btn_border_radius; ?>px;
        border-color: #<?php echo $theme->load_more_btn_border_color; ?>;
        border-width: <?php echo $theme->load_more_btn_border_width; ?>px;
        display: table-cell;
        vertical-align: middle;

    }
</style>
