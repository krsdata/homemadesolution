<?php

if ( ! empty( $banner_data['caption'] ) ) {
	$title = $banner_data['caption'];
} else {
	$title = $banner_data['title'];
}

$_ad = '<a itemprop="url" class="bsac-link" href="' . $banner_data['url'] . '"' . ( $banner_data['target'] ? ' target="' . $banner_data['target'] . '"' : '' ) . ' ';

$_ad .= $banner_data['no_follow'] ? ' rel="nofollow" >' : '>';

$_ad .= '<img class="bsac-image" src="' . $banner_data['img'] . '" alt="' . $title . '" />';

$_ad .= '</a>';

if ( ! empty( $banner_data['caption'] ) && $args['show-caption'] ) {
	$_ad .= '<span class="bsac-caption">' . $banner_data['caption'] . '</span>';
}

return $_ad;
