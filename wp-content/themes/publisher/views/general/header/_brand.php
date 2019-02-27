<?php
/**
 * Prints branding information's of site
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

$site_name = publisher_get_option( 'logo_text' );
if ( empty( $site_name ) ) {
	$site_name = get_bloginfo( 'name' );
}                   // Site name
$site_name = do_shortcode( $site_name );

$logo   = publisher_get_option( 'logo_image' );        // Site logo
$logo2x = publisher_get_option( 'logo_image_retina' ); // Site 2X logo

// Custom logo for categories
if ( is_category() && bf_get_term_meta( 'logo_image' ) != '' ) {
	$logo   = bf_get_term_meta( 'logo_image' );
	$logo2x = bf_get_term_meta( 'logo_image_retina' );
} // Custom logo for categories
elseif ( is_singular( 'page' ) && bf_get_post_meta( 'logo_image' ) != '' ) {
	$logo   = bf_get_post_meta( 'logo_image' );
	$logo2x = bf_get_post_meta( 'logo_image_retina' );
}


// Make it retina friendly
if ( $logo2x != '' ) {
	$logo2x = ' data-bsrjs="' . esc_url( $logo2x ) . '" ';
}


$tag = 'h1';

if ( is_singular() && ! ( is_home() || is_front_page() ) ) {
	$tag = 'h2';
} elseif ( is_category() || is_tag() ) {
	$tag = 'h2';
}

?>
<div id="site-branding" class="site-branding">
	<<?php echo $tag, ' '; ?> id="site-title" class="logo <?php echo empty( $logo ) ? 'text-logo' : 'img-logo'; ?>">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" <?php publisher_attr( 'site-url' ); ?>>
		<?php

		// Site logo
		if ( ! empty( $logo ) ) { ?>
			<img id="site-logo" src="<?php echo esc_url( $logo ); ?>"
			     alt="<?php echo esc_attr( $site_name ); ?>" <?php echo $logo2x; // escaped before ?> />
			<?php
		} // Site title as text logo
		else {
			echo $site_name; // escaped before in WP
		}

		?>
	</a>
</<?php echo $tag; ?>>
</div><!-- .site-branding -->
