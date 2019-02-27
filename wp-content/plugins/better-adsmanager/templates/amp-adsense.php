<?php

$attrs = array(
	'type'           => 'adsense',
	'data-ad-client' => $ad_data['ad-client'],
	'data-ad-slot'   => $ad_data['ad-slot'],
);

if ( ! empty( $banner_data['size']['width'] ) && ! empty( $banner_data['size']['height'] ) ) {
	$attrs['width']  = $banner_data['size']['width'];
	$attrs['height'] = $banner_data['size']['height'];
} elseif ( empty( $banner_data['size']['width'] ) && ! empty( $banner_data['size']['height'] ) ) {
	$attrs['height'] = $banner_data['size']['height'];
	$attrs['layout'] = 'fixed-height';
} else {
	$attrs['width']  = '300';
	$attrs['height'] = '250';
}

better_amp_enqueue_ad( 'adsense' );

ob_start();

?>
<amp-ad <?php

foreach ( $attrs as $k => $v ) {
	echo $k, '=', $v, ' ';
}

?>></amp-ad><?php

return ob_get_clean();
