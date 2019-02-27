<?php

add_filter( 'better-framework/product-pages/install-plugin/config', 'publisher_plugin_installer_config' );

/**
 * Ads exclusive and public plugins to plugin installer
 *
 * @param $plugins
 *
 * @return mixed
 */
function publisher_plugin_installer_config( $plugins ) {

	$plugins['js_composer']                 = array(
		'name'                   => __( 'Visual Composer', 'publisher' ),
		'slug'                   => 'js_composer',
		'required'               => TRUE,
		'description'            => __( '#1 page builder plugin for WordPress - take full control over your site.', 'publisher' ),
		'thumbnail'              => bf_get_theme_uri( 'includes/plugins/images/js_composer.png' ),
		'type'                   => 'bundled',
		'reload_after_install'   => TRUE,
		'reload_after_uninstall' => TRUE,
	);
	$plugins['better-amp']                  = array(
		'name'                   => __( 'Better AMP', 'publisher' ),
		'slug'                   => 'better-amp',
		'required'               => FALSE,
		'description'            => __( 'Enables your site to load 4x faster in mobiles!', 'publisher' ),
		'thumbnail'              => bf_get_theme_uri( 'includes/plugins/images/better-amp.png' ),
		'type'                   => 'global',
		'reload_after_install'   => TRUE,
		'reload_after_uninstall' => TRUE,
	);
	$plugins['better-social-counter']       = array(
		'name'                   => __( 'Better Social Counter', 'publisher' ),
		'slug'                   => 'better-social-counter',
		'required'               => FALSE,
		'description'            => __( 'Complete solution for showing social networks stats on site.', 'publisher' ),
		'thumbnail'              => bf_get_theme_uri( 'includes/plugins/images/better-social-counter.png' ),
		'type'                   => 'bundled',
		'reload_after_install'   => TRUE,
		'reload_after_uninstall' => TRUE,
	);
	$plugins['better-adsmanager']           = array(
		'name'                   => __( 'Better Ads Manager', 'publisher' ),
		'slug'                   => 'better-adsmanager',
		'required'               => FALSE,
		'description'            => __( 'Advanced ads manager with huge options + ads blockers fallback.', 'publisher' ),
		'thumbnail'              => bf_get_theme_uri( 'includes/plugins/images/better-adsmanager.png' ),
		'type'                   => 'bundled',
		'reload_after_install'   => TRUE,
		'reload_after_uninstall' => TRUE,
	);
	$plugins['better-weather']              = array(
		'name'                   => __( 'Better Weather', 'publisher' ),
		'slug'                   => 'better-weather',
		'required'               => FALSE,
		'description'            => __( 'The best way to show weather to the world.', 'publisher' ),
		'thumbnail'              => bf_get_theme_uri( 'includes/plugins/images/better-weather.png' ),
		'type'                   => 'bundled',
		'reload_after_install'   => TRUE,
		'reload_after_uninstall' => TRUE,
	);
	$plugins['better-post-views']           = array(
		'name'        => __( 'Better Post Views', 'publisher' ),
		'slug'        => 'better-post-views',
		'required'    => FALSE,
		'description' => __( 'Count post views per day and week and show 7 days popular posts.', 'publisher' ),
		'thumbnail'   => bf_get_theme_uri( 'includes/plugins/images/better-post-views.png' ),
		'type'        => 'bundled',
	);
	$plugins['better-reviews']              = array(
		'name'        => __( 'Better Reviews', 'publisher' ),
		'slug'        => 'better-reviews',
		'required'    => FALSE,
		'description' => __( 'Review products in 3 type with stylish design.', 'publisher' ),
		'thumbnail'   => bf_get_theme_uri( 'includes/plugins/images/better-reviews.png' ),
		'type'        => 'bundled',
	);
	$plugins['better-playlist']             = array(
		'name'        => __( 'Better Playlist', 'publisher' ),
		'slug'        => 'better-playlist',
		'required'    => FALSE,
		'description' => __( 'The best way to Youtube playlist\'s and Vimeo album\'s in WordPress', 'publisher' ),
		'thumbnail'   => bf_get_theme_uri( 'includes/plugins/images/better-playlist.png' ),
		'type'        => 'bundled',
	);
	$plugins['better-google-custom-search'] = array(
		'name'                   => __( 'Better Google Custom Search', 'publisher' ),
		'slug'                   => 'better-google-custom-search',
		'required'               => FALSE,
		'description'            => __( 'Replace the default WordPress search engine with search powered by Google.', 'publisher' ),
		'thumbnail'              => bf_get_theme_uri( 'includes/plugins/images/better-google-custom-search.png' ),
		'type'                   => 'bundled',
		'reload_after_install'   => TRUE,
		'reload_after_uninstall' => TRUE,
	);
	$plugins['better-disqus-comments']      = array(
		'name'                   => __( 'Better Disqus Comments', 'publisher' ),
		'slug'                   => 'better-disqus-comments',
		'required'               => FALSE,
		'description'            => __( 'Use DISQUS comments for theme with this plugin.', 'publisher' ),
		'thumbnail'              => bf_get_theme_uri( 'includes/plugins/images/better-disqus-comments.png' ),
		'type'                   => 'bundled',
		'reload_after_install'   => TRUE,
		'reload_after_uninstall' => TRUE,
	);
	$plugins['better-facebook-comments']    = array(
		'name'                   => __( 'Better Facebook Comments', 'publisher' ),
		'slug'                   => 'better-facebook-comments',
		'required'               => FALSE,
		'description'            => __( 'Use Facebook comments for theme with this plugin.', 'publisher' ),
		'thumbnail'              => bf_get_theme_uri( 'includes/plugins/images/better-facebook-comments.png' ),
		'type'                   => 'bundled',
		'reload_after_install'   => TRUE,
		'reload_after_uninstall' => TRUE,
	);
	$plugins['revslider']                   = array(
		'name'                   => __( 'Slider Revolution', 'publisher' ),
		'slug'                   => 'revslider',
		'required'               => FALSE,
		'description'            => __( '#1 WordPress slider plugin ever created and used!', 'publisher' ),
		'thumbnail'              => bf_get_theme_uri( 'includes/plugins/images/revslider.png' ),
		'type'                   => 'bundled',
		'reload_after_install'   => TRUE,
		'reload_after_uninstall' => TRUE,
	);
	$plugins['custom-sidebars']             = array(
		'name'                   => __( 'Custom sidebars', 'publisher' ),
		'slug'                   => 'custom-sidebars',
		'required'               => FALSE,
		'description'            => __( 'Create and customize sidebars for pages with easy user interface.', 'publisher' ),
		'thumbnail'              => bf_get_theme_uri( 'includes/plugins/images/custom-sidebars.png' ),
		'type'                   => 'global',
		'reload_after_install'   => TRUE,
		'reload_after_uninstall' => TRUE,
	);
	$plugins['wordpress-social-login']      = array(
		'name'                   => __( 'Social Login', 'publisher' ),
		'slug'                   => 'wordpress-social-login',
		'required'               => FALSE,
		'description'            => __( 'Allow your visitors to comment and login with social networks.', 'publisher' ),
		'thumbnail'              => bf_get_theme_uri( 'includes/plugins/images/wordpress-social-login.png' ),
		'type'                   => 'global',
		'reload_after_install'   => TRUE,
		'reload_after_uninstall' => TRUE,
	);
	$plugins['contact-form-7']              = array(
		'name'                   => __( 'Contact Form 7', 'publisher' ),
		'slug'                   => 'contact-form-7',
		'required'               => FALSE,
		'description'            => __( 'Just another contact form plugin. Simple but flexible.', 'publisher' ),
		'thumbnail'              => bf_get_theme_uri( 'includes/plugins/images/contact-form-7.png' ),
		'type'                   => 'global',
		'reload_after_install'   => TRUE,
		'reload_after_uninstall' => TRUE,
	);
	$plugins['woocommerce']                 = array(
		'name'                   => __( 'WooCommerce', 'publisher' ),
		'slug'                   => 'woocommerce',
		'required'               => FALSE,
		'description'            => __( 'Powerful and extendable eCommerce plugin that helps you sell anything.', 'publisher' ),
		'thumbnail'              => bf_get_theme_uri( 'includes/plugins/images/woocommerce.png' ),
		'type'                   => 'global',
		'reload_after_install'   => TRUE,
		'reload_after_uninstall' => TRUE,
	);
	$plugins['bbpress']                     = array(
		'name'                   => __( 'bbPress', 'publisher' ),
		'slug'                   => 'bbpress',
		'required'               => FALSE,
		'description'            => __( 'Create forums! Publisher is fully compatible with bbPress.', 'publisher' ),
		'thumbnail'              => bf_get_theme_uri( 'includes/plugins/images/bbpress.png' ),
		'type'                   => 'global',
		'reload_after_install'   => TRUE,
		'reload_after_uninstall' => TRUE,
	);

	return $plugins;
}
