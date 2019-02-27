<?php
/**
 * Custom Template For Better Google Custom Search Plugin
 *
 * Copy this to your site theme and make it more compatible with your site layout
 */

get_header();

echo '<div id="content" role="main">';

// this function adds search input and result tags
Better_GCS_Search_Box();

echo '</div>';

get_footer();