<?php
/**
 * The template to show text shortcode/widget
 *
 * [bs-text] shortcode
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

$atts = publisher_get_prop( 'shortcode-bs-text-atts' );

if ( empty( $atts['css-class'] ) ) {
	$atts['css-class'] = '';
}
if ( ! empty( $atts['custom-css-class'] ) ) {
	$atts['css-class'] .= ' ' . sanitize_html_class( $atts['custom-css-class'] );
}

$custom_id = empty( $atts['custom-id'] ) ? '' : sanitize_html_class( $atts['custom-id'] );

?>
	<div
		<?php
		if ( $custom_id ) {
			echo 'id="', $custom_id, '"';
		}
		?>
		class="bs-shortcode bs-text <?php echo esc_attr( $atts['css-class'] ); ?>">
		<?php

		bf_shortcode_show_title( $atts ); // show title

		?>
		<div class="bs-text-content">
			<?php echo wpautop( do_shortcode( $atts['content'] ) ); // escaped before ?>
		</div>
	</div><!-- .bs-text -->
<?php

unset( $atts );
