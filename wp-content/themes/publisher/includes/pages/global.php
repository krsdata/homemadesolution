<?php

add_filter( 'better-framework/product-pages/register-product/auth', 'publisher_bs_register_product_params' );
add_filter( 'better-framework/oculus/request/auth', 'publisher_bs_register_product_params' );
/**
 * @see \bf_register_product_get_info
 *
 * @return array
 */
function publisher_bs_register_product_params() {
	$item_id     = 15801051;
	$option_name = sprintf( '%s-register-info', $item_id );
	$data        = get_option( $option_name );
	$version     = Better_Framework()->theme( TRUE )->get( 'Version' );

	return array(
		'item_id'       => $item_id,
		'version'       => $version,
		'purchase_code' => isset( $data['purchase_code'] ) ? $data['purchase_code'] : '',
	);
}
