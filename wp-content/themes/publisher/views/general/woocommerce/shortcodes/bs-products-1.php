<?php
/**
 * Products shortcode
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

$atts = publisher_get_prop( 'shortcode-bs-products-1-atts' );

// Change global variables to be compatible with out of box
global $woocommerce_loop, $products;
$woocommerce_loop['columns'] = $columns = $atts['columns'];

$woocommerce_loop['name'] = $loop_name = 'products';
$products                 = publisher_get_query();

publisher_set_prop( 'woocommerce-columns', $woocommerce_loop['columns'] );

?>
	<div class="woocommerce columns-<?php echo esc_attr( $columns ); ?>">

		<?php
		if ( publisher_have_posts() ) {
			?>

			<?php do_action( "woocommerce_shortcode_before_{$loop_name}_loop" ); ?>

			<?php woocommerce_product_loop_start(); ?>

			<?php while( publisher_have_posts() ) : publisher_the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php do_action( "woocommerce_shortcode_after_{$loop_name}_loop" ); ?>

			<?php
		} else {
			do_action( "woocommerce_shortcode_{$loop_name}_loop_no_results" );
		}

		?>
	</div>
<?php

publisher_unset_prop( 'woocommerce-columns' );
