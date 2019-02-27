<?php

better_amp_enqueue_ad( 'dfp' );

if ( $banner_data['dfp_spot'] === 'custom' ) {
	return $banner_data['custom_dfp_code'];
} else {

	$ad_code = '<amp-ad width=' . $banner_data['dfp_spot_width'] . ' height=' . $banner_data['dfp_spot_height'] . '
    type="doubleclick"
    data-slot="' . $banner_data['dfp_spot_id'] . '">
</amp-ad>';

}

return $ad_code;
