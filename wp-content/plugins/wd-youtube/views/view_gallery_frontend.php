<div class="ytwd_gallery_container ytwd_gallery_container<?php echo $shortcode_id; ?>">
    <div class="ytwd_loading_wrapper ytwd_loading_wrapper<?php echo $shortcode_id; ?>">
        <div class="ytwd_loading ytwd_loading<?php echo $shortcode_id; ?>">
			<img src="<?php echo YTWD_URL; ?>/assets/loader.png" class="ytwd_loader">
		</div>
    </div>
    <?php if(isset($_POST["action"]) && $_POST["action"] == "ytwd_gallery_pagination" ){ 
	 
		if($row->embed_type != 0){

			$num_pages = $row->gallery_items_count > 0 ? ceil(($total_results)/$row->gallery_items_count) : 0;
			if($num_pages>1 && $row->gallery_display_type == 0){
				require(YTWD_DIR.'/views/view_pagination_frontend.php');
			}
			?>
			<script>
				if(typeof ytwdItems == 'undefined'){
					var ytwdItems = [];
				}
				ytwdItems['<?php echo $shortcode_id; ?>'] = [];
				<?php foreach($items_data as $item){
				?>
					ytwdItems['<?php echo $shortcode_id; ?>'].push({"video_url":"<?php echo $item["video_url"]; ?>", "video_id": "<?php echo $item["resource_id"]; ?>"});
				<?php
				}
				?>
			</script>
		<?php
			 require(YTWD_DIR. "/views/view_thumbnails_frontend.php");
			 if($num_pages>1 ){
				require(YTWD_DIR.'/views/view_pagination_frontend.php');
			}
		}
	}
    ?>
</div>
