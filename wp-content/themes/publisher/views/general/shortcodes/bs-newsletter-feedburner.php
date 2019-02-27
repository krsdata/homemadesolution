<?php
/**
 * The template to show FeedBurner newsletter shortcode/widget
 *
 * [bs-subscribe-newsletter] shortcode
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

$atts = publisher_get_prop( 'shortcode-bs-newsletter-feedburner-atts' );

if ( empty( $atts['css-class'] ) ) {
	$atts['css-class'] = '';
}

if ( ! empty( $atts['custom-css-class'] ) ) {
	$atts['css-class'] .= ' ' . sanitize_html_class( $atts['custom-css-class'] );
}

$custom_id = empty( $atts['custom-id'] ) ? '' : sanitize_html_class( $atts['custom-id'] );

?>
	<div <?php
	if ( $custom_id ) {
		echo 'id="', $custom_id, '"';
	}
	?> class="bs-shortcode bs-subscribe-newsletter bs-feedburner-newsletter <?php echo $atts['css-class']; ?>">
		<?php

		bf_shortcode_show_title( $atts ); // show title

		if ( ! empty( $atts['image'] ) ) { ?>
			<div class="subscribe-image">
				<img src="<?php echo $atts['image']; ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>">
			</div>
		<?php } ?>

		<div class="subscribe-message">
			<?php echo wpautop( $atts['msg'] ); ?>
		</div>

		<form method="post" action="//feedburner.google.com/fb/a/mailverify" class="bs-subscribe-feedburner clearfix"
		      target="_blank">
			<input type="hidden" value="<?php echo esc_attr( $atts['feedburner-id'] ); ?>" name="uri"/>
			<input type="hidden" name="loc" value="<?php echo get_locale(); ?>"/>
			<input type="text" id="feedburner-email" name="email" class="newsletter-email"
			       placeholder="<?php publisher_translation_echo_esc_attr( 'widget_enter_email' ); ?>"/>
			<button class="newsletter-subscribe" name="submit"
			        type="submit"><?php publisher_translation_echo( 'widget_subscribe' ); ?></button>

			<?php if ( $atts['show-powered'] ) { ?>
				<p class="powered-by"><?php publisher_translation_echo( 'widget_newsletter_powered' ); ?> <img
						src="<?php echo PUBLISHER_THEME_URI . 'images/other/feedburner.png'; ?>"
						data-bsrjs="<?php echo PUBLISHER_THEME_URI . 'images/other/feedburner@2x.png'; ?>"
						alt="MailChimp"/></p>
			<?php } ?>
		</form>

	</div>
<?php

unset( $atts );
