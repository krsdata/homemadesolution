<?php

if ( $banner_data['dfp_spot'] === 'custom' ) {
	return $banner_data['custom_dfp_code'];
} else {

	$ad_code = '<!-- ' . $banner_data['dfp_spot_id'] . ' -->
<div id="' . $banner_data['dfp_spot_tag'] . '" style="width:' . $banner_data['dfp_spot_width'] . 'px; height:' . $banner_data['dfp_spot_height'] . 'px;">
<script>
googletag.cmd.push(function() { googletag.display("' . $banner_data['dfp_spot_tag'] . '"); });
</script>
</div>';

}

return $ad_code;
