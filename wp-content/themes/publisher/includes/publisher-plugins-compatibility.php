<?php
/**
 * publisher-plugins-compatibility.php
 *---------------------------
 * Handles all tasks about making Publisher compatible with third party plugins.
 *
 */


/**
 * Publisher third party plugins compatibility
 *
 * @since 1.8.0
 */
class Publisher_Plugins_Compatibility {

	/**
	 *
	 * @since 1.8.0
	 */
	public static function init() {


		/**
		 * Plugin: APS Arena Products
		 *
		 * http://www.webstudio55.com/plugins/arena-products/
		 *
		 * Issue: Remove duplicate posts and brands page conflict because it seams this plugins create 2 query!
		 * First removes all items so the second have not first page query results.
		 *
		 * Solution: Disable duplicate posts temporarily in archive pages of this plugin
		 *
		 */
		add_action( 'aps_brand_archive_after_controls', 'Publisher_Plugins_Compatibility::aps_products_disable_duplicate_posts' );
		add_action( 'aps_brand_archive_after_results', 'Publisher_Plugins_Compatibility::aps_products_enable_duplicate_posts' );


	}


	/**
	 * Activates duplicate posts removal temporarily
	 */
	public static function disable_duplicate_posts() {
		publisher_set_global( 'disable-duplicate-posts', TRUE );
	}


	/**
	 * Deactivates duplicate posts removal temporarily
	 */
	public static function enable_duplicate_posts() {
		publisher_unset_global( 'disable-duplicate-posts' );
	}


} // Publisher_Plugins_Compatibility
