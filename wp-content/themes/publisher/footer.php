<?php
/**
 * footer.php
 *
 * The template for displaying the footer.
 *
 * @author    BetterStudio
 * @package   Publisher
 * @version   1.8.4
 */

if ( publisher_get_footer_style() == 'show' ) {

	// Before Footer Ad
	publisher_show_ad_location( 'footer_before',
		array(
			'container-class' => 'adloc-before-footer',
			'before'          => '<div class="container adcontainer">',
			'after'           => '</div>',
		) );

	$date     = date( 'Y' );
	$name     = get_bloginfo( 'name' );
	$home_url = get_home_url();

	// Prepare copyright Text
	$copy_text_1 = str_replace(
		array(
			'%%year%%',
			'%%date%%',
			'%%title%%',
			'%%sitename%%',
			'%%siteurl%%',
		),
		array(
			$date,
			$date,
			$name,
			$name,
			$home_url
		),
		do_shortcode( publisher_get_option( 'footer_copy1' ) )
	);

	$copy_text_2 = str_replace(
		array(
			'%%year%%',
			'%%date%%',
			'%%title%%',
			'%%sitename%%',
			'%%siteurl%%',
		),
		array(
			$date,
			$date,
			$name,
			$name,
			$home_url
		),
		do_shortcode( publisher_get_option( 'footer_copy2' ) )
	);

	// Footer Instagram
	if ( publisher_get_option( 'footer_social_feed' ) != 'hide' && publisher_get_option( 'footer_instagram' ) != '' ) {
		// Location: "views/footer/_social-feed.php"
		publisher_get_view( 'footer', 'instagram-' . publisher_get_option( 'footer_social_feed' ) );
	}

	?>
	<footer id="site-footer" class="site-footer">
		<?php

		// Footer Socials
		if ( class_exists( 'Better_Social_Counter_Shortcode' ) && publisher_get_option( 'footer_social' ) == 'show' ) {
			// Location: "views/footer/_social-icons.php"
			publisher_get_view( 'footer', '_social-icons' );
		}

		// Footer Widgets
		// Location: "views/footer/widgets.php"
		publisher_get_view( 'footer', 'widgets' );

		?>
		<div class="copy-footer">
			<div class="content-wrap">
				<div class="container">
					<?php

					if ( has_nav_menu( 'footer-menu' ) ) {
						publisher_get_view( 'menu', 'footer' );
					}

					?>
					<div class="row">
						<div class="copy-1 col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<?php echo $copy_text_1; ?>
						</div>
						<div class="copy-2 col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<?php echo $copy_text_2; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer><!-- .footer -->
	<?php

}

?>
</div><!-- .main-wrap -->
<?php

if ( publisher_get_option( 'back_to_top' ) == 'show' ) { ?>
	<span class="back-top"><i class="fa fa-arrow-up"></i></span>
<?php } ?>

<?php wp_footer(); // WordPress hook for loading JavaScript, toolbar, and other things in the footer. ?>

</body>
</html>