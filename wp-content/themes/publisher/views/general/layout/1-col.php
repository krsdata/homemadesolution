<?php
/**
 * Single column layout template file.
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

$container_class = 'container layout-1-col layout-no-sidebar';


if ( ( 'page' == get_option( 'show_on_front' ) ) && is_front_page() && bf_get_query_var_paged( 1 ) > 1 ) {
	$content_type = 'front paginated';
} elseif ( is_singular() ) {
	$content_type = 'singular';
} // Other pages template
else {
	$content_type = 'archive';
}


if ( publisher_get_header_style() !== 'disable' ) {

	// Shows breadcrumb
	if ( publisher_show_breadcrumb() ) {
		Better_Framework()->breadcrumb()->generate( array(
			'before'       => '<div class="container bf-breadcrumb-container">',
			'after'        => '</div>',
			'custom_class' => 'bc-top-style'
		) );
		$container_class .= ' layout-bc-before';
	}

	// After header Ad
	publisher_show_ad_location( 'header_after', array(
			'container-class' => 'adloc-after-header',
			'before'          => '<div class="container adcontainer">',
			'after'           => '</div>',
		)
	);
}

?>
<div class="content-wrap">
	<main <?php publisher_attr( 'content' ); ?>>

		<div class="<?php echo $container_class; ?>">
			<div class="main-section">
				<div class="content-column">
					<?php

					if ( $content_type === 'singular' ) {
						// Prints post and other post type templates
						// Location: "views/general/{posttype}/content.php"
						publisher_get_content_template();
					} else {


						if ( $content_type !== 'front paginated' ) {
							// Prints the title of archive pages
							// Location: "views/general/archive/page.php"
							publisher_get_view( 'archive', 'title' );
						} else {
							// Setup query for paginated posts on static homepage
							publisher_setup_paged_frontpage_query();
						}

						if ( publisher_have_posts() ) {

							// You can use this for adding codes before the main loop
							do_action( 'publisher/archive/before-loop' );

							// Prints posts base of listing that was selected in panels.
							// Location: "views/general/loop/listing-*.php"
							publisher_get_view( 'loop', publisher_get_page_listing() );

							// You can use this to add some code after the main query.
							// the pagination will be printed from this action.
							do_action( 'publisher/archive/after-loop' );


						} else {

							// Prints no result message
							// Location: "views/general/loop/_none-result.php"
							publisher_get_view( 'loop', '_none-result' );

						}

						// Clear all props
						publisher_clear_props();
					}

					?>
				</div><!-- .content-column -->
			</div><!-- .main-section -->
		</div><!-- .layout-1-col -->

	</main><!-- main -->
</div><!-- .content-wrap -->
