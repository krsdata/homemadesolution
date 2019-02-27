<?php
/**
 * Off-canvas panel
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

$class_name = sanitize_html_class( publisher_get_option( 'off_canvas_position' ) );
if ( is_rtl() ) {
	$class_name = $class_name === 'right' ? 'left' : 'right';
}

?>
<div class="off-canvas-overlay"></div>
<div class="off-canvas-container <?php echo $class_name; ?>"
     style="display: none;">
	<div class="off-canvas-inner">
		<?php

		if ( publisher_get_option( 'off_canvas_branding' ) ) {

			$menu_title = publisher_get_option( 'off_canvas_title' );
			$menu_logo  = publisher_get_option( 'off_canvas_logo' );

			?>
			<div class="off-canvas-header">
				<?php

				if ( $menu_logo ) {
					?>
					<div class="logo">

						<a href="<?php bloginfo( 'url' ) ?>">
							<img class="bs-lazy"
								<?php

								if ( publisher_is_lazy_loading() ) { ?>
									data-src="<?php echo esc_attr( $menu_logo ) ?>" <?php
								} else {
									?>
									src="<?php echo esc_attr( $menu_logo ) ?>" <?php
								}

								?> alt="<?php echo $menu_title ? $menu_title : get_bloginfo( 'name' ); ?>"<?php

							?>>
						</a>
					</div>
					<?php
					$menu_logo = NULL;
				}

				if ( $menu_title ) {
					?>
					<div class="site-name"><?php echo $menu_title; // escaped before ?></div>
					<?php

					$menu_title = NULL;
				}

				if ( ! $menu_description = publisher_get_option( 'off_canvas_desc' ) ) {
					$menu_description = get_bloginfo( 'description' );
				}

				?>
				<div class="site-description"><?php echo $menu_description // escaped before ?></div>
			</div>
			<?php

		} // show header


		if ( publisher_get_option( 'off_canvas_search' ) ) {

			?>
			<div class="off-canvas-search">
				<form role="search" method="get" action="<?php echo home_url(); ?>">
					<input type="text" name="s" value="<?php the_search_query() ?>"
					       placeholder="<?php publisher_translation_echo( 'search_dot' ) // escaped before
					       ?>">
					<i class="fa fa-search"></i>
				</form>
			</div>
			<?php

		}


		if ( has_nav_menu( 'off-canvas-menu' ) ) {
			?>
			<nav class="off-canvas-menu">
				<ul class="menu bsm-pure clearfix">
					<?php

					wp_nav_menu(
						array(
							'container'       => FALSE,
							'theme_location'  => 'off-canvas-menu',
							'bf_mega_menu'    => FALSE,
							'bf_default_anim' => 'slide-' . ( is_rtl() ? 'left' : 'right' ) . '-in',
							'items_wrap'      => '%3$s',
						)
					);

					?>
				</ul>
			</nav>
			<?php

		} else {
			?>
			<div class="off-canvas-menu">
				<div class="off-canvas-menu-fallback"></div>
			</div>
			<?php
		}


		if ( publisher_get_option( 'off_canvas_footer' ) || publisher_get_option( 'off_canvas_footer_icons' ) ) {

			?>
			<div class="off_canvas_footer">
				<div class="off_canvas_footer-info entry-content">
					<?php

					echo wpautop( publisher_get_option( 'off_canvas_footer' ) ); // escaped before

					if ( publisher_get_option( 'off_canvas_footer_icons' ) && class_exists( 'Better_Social_Counter_Shortcode' ) ) {

						// Social icons
						$icons = publisher_get_option( 'off_canvas_socials' );

						// make string for shortcode
						if ( is_array( $icons ) ) {
							$_icons = array();

							foreach ( (array) $icons as $icon_key => $icon ) {
								if ( $icon ) {
									$_icons[ $icon_key ] = $icon_key;
								}
							}

							$icons = implode( ',', $_icons );
						}

						echo do_shortcode( "[better-social-counter show_title='0' style='button' order='{$icons}']" ); // escaped before

					}

					?>
				</div>
			</div>
			<?php

		}

		?>
	</div>
</div>
