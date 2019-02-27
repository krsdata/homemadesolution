<?php

/***** Fetch Theme Data *****/

$mh_magazine_lite_data = wp_get_theme('mh-magazine-lite');
$mh_magazine_lite_version = $mh_magazine_lite_data['Version'];
$mh_healthmag_data = wp_get_theme('mh-healthmag');
$mh_healthmag_version = $mh_healthmag_data['Version'];

/***** Load Google Fonts *****/

function mh_healthmag_fonts() {
	wp_dequeue_style('mh-google-fonts');
	wp_enqueue_style('mh-healthmag-fonts', 'https://fonts.googleapis.com/css?family=Josefin+Sans:400,700|Muli:400,400i,700,700i', array(), null);
}
add_action('wp_enqueue_scripts', 'mh_healthmag_fonts', 11);

/***** Load Stylesheets *****/

function mh_healthmag_styles() {
	global $mh_magazine_lite_version, $mh_healthmag_version;
    wp_enqueue_style('mh-magazine-lite', get_template_directory_uri() . '/style.css', array(), $mh_magazine_lite_version);
    wp_enqueue_style('mh-healthmag', get_stylesheet_uri(), array('mh-magazine-lite'), $mh_healthmag_version);
    if (is_rtl()) {
		wp_enqueue_style('mh-magazine-lite-rtl', get_template_directory_uri() . '/rtl.css', array(), $mh_magazine_lite_version);
	}
}
add_action('wp_enqueue_scripts', 'mh_healthmag_styles');

/***** Load Translations *****/

function mh_healthmag_theme_setup(){
	load_child_theme_textdomain('mh-healthmag', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'mh_healthmag_theme_setup');

/***** Change Defaults for Custom Colors *****/

function mh_healthmag_custom_colors() {
	remove_theme_support('custom-header');
	add_theme_support('custom-header', array('default-image' => '', 'default-text-color' => '4c2b2b', 'width' => 1080, 'height' => 250, 'flex-width' => true, 'flex-height' => true));
}
add_action('after_setup_theme', 'mh_healthmag_custom_colors');

/***** Display Posts on Archives as Grid - Override Pluggable Function from Parent Theme *****/

if (!function_exists('mh_magazine_lite_loop_layout')) {
	function mh_magazine_lite_loop_layout() {
		global $wp_query;
		$counter = 1;
		$max_posts = $wp_query->post_count;
		while (have_posts()) : the_post();
			if ($counter === 1) {
				echo '<div class="mh-row mh-posts-grid clearfix">' . "\n";
			}
			if ($counter >= 1) {
				echo '<div class="mh-col-1-2 mh-posts-grid-col clearfix">' . "\n";
					get_template_part('content', 'grid');
				echo '</div>' . "\n";
			}
			if ($counter % 2 === 0 && $counter != $max_posts) {
				echo '</div>' . "\n";
				echo '<div class="mh-row mh-posts-grid mh-posts-grid-more clearfix">' . "\n";
			}
			if ($counter >= 1 && $counter === $max_posts) {
				echo '</div>' . "\n";
			}
			$counter++;
		endwhile;
	}
}

?>