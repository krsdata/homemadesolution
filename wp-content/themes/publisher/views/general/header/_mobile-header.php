<?php
/**
 * Responsive menu and header template
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

$site_name = get_bloginfo( 'name' );                              // Site name
$logo      = publisher_get_option( 'resp_logo_image' );           // Site logo
$logo2x    = publisher_get_option( 'resp_logo_image_retina' );    // Site 2X logo

// Default logos as fallback for resp logos
if ( $logo == '' ) {
	$logo   = publisher_get_option( 'logo_image' );        // Site logo
	$logo2x = publisher_get_option( 'logo_image_retina' ); // Site 2X logo

	// Custom logo for categories
	if ( is_category() && bf_get_term_meta( 'logo_image' ) != '' ) {
		$logo   = bf_get_term_meta( 'logo_image' );
		$logo2x = bf_get_term_meta( 'logo_image_retina' );
	}
}

// prepare retina logo tags
if ( $logo2x != '' ) {
	$logo2x = ' data-bsrjs="' . esc_url( $logo2x ) . '" ';
}

// Final menu code
$menu_code = '';

// Final theme menu location id
$menu_id = '';

// If specific menu was defined for responsive header
if ( has_nav_menu( 'resp-menu' ) ) {
	$menu_id = 'resp-menu';
} // If main menu is not defined but the top menu is, then get top menu as resp menu
elseif ( ! has_nav_menu( 'main-menu' ) && has_nav_menu( 'top-menu' ) ) {
	$menu_id = 'top-menu';
}

// Create final menu code
if ( $menu_id != '' ) {

	$menu_args = array(
		'theme_location' => $menu_id,
		'container'      => FALSE,
		'items_wrap'     => '%3$s',
		'fallback_cb'    => 'BF_Menu_Walker',
		'echo'           => FALSE,
	);

	$menu_code = '<ul id="resp-navigation" class="resp-menu menu clearfix">' . wp_nav_menu( $menu_args ) . '</ul>';
}

?>
<div class="responsive-header clearfix <?php publisher_echo_option( 'resp_scheme' ); ?> deferred-block-exclude">
	<div class="responsive-header-container clearfix">

		<div class="menu-container close">
			<span class="menu-handler">
				<span class="lines"></span>
			</span>

			<div class="menu-box clearfix"><?php echo $menu_code; // escaped before in top ?></div>
		</div><!-- .menu-container -->

		<div class="logo-container">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" <?php publisher_attr( 'site-url' ); ?>>
				<?php

				// Site logo
				if ( ! empty( $logo ) ) { ?>
					<img src="<?php echo esc_attr( $logo ); ?>"
					     alt="<?php echo esc_attr( $site_name ); ?>" <?php echo $logo2x; // escaped before ?> /><?php
				} // Site title as text logo
				else {
					echo $site_name; // escaped before in top
				}

				?>
			</a>
		</div><!-- .logo-container -->

		<div class="search-container close">
			<span class="search-handler">
				<i class="fa fa-search"></i>
			</span>

			<div class="search-box clearfix">
				<?php publisher_get_view( 'wp', 'searchform' ); ?>
			</div>
		</div><!-- .search-container -->

	</div><!-- .responsive-header-container -->
</div><!-- .responsive-header -->
