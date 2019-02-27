<?php
/**
 * The template to show MailChimp newsletter shortcode/widget
 *
 * [bs-newsletter-mailchimp] shortcode
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

$atts = publisher_get_prop( 'shortcode-bs-newsletter-mailchimp-atts' );

if ( empty( $atts['css-class'] ) ) {
	$atts['css-class'] = '';
}

if ( ! empty( $atts['custom-css-class'] ) ) {
	$atts['css-class'] .= ' ' . sanitize_html_class( $atts['custom-css-class'] );
}

$custom_id = empty( $atts['custom-id'] ) ? '' : sanitize_html_class( $atts['custom-id'] );


if ( empty( $atts['mailchimp-url'] ) ) {

	if ( ! bf_get_current_sidebar() ) {
		$atts['mailchimp-code'] = rawurldecode( base64_decode( $atts['mailchimp-code'] ) );
	}

	preg_match( '/action="([^"]*?)"/i', $atts['mailchimp-code'], $matches );
	if ( isset( $matches[1] ) ) {
		$atts['mailchimp-url'] = $matches[1];
	} else {
		$atts['mailchimp-url'] = '';
	}
	unset( $matches );
}

?>
	<div <?php
	if ( $custom_id ) {
		echo 'id="', $custom_id, '"';
	}
	?> class="bs-shortcode bs-subscribe-newsletter bs-mailchimp-newsletter <?php echo $atts['css-class']; ?>">
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

		<form action="<?php echo $atts['mailchimp-url']; ?>" method="post" name="mc-embedded-subscribe-form"
		      class="validate"
		      target="_blank">
			<input name="EMAIL" type="email"
			       placeholder="<?php publisher_translation_echo_esc_attr( 'widget_enter_email' ); ?>"
			       class="newsletter-email">
			<button class="newsletter-subscribe" name="subscribe"
			        type="submit"><?php publisher_translation_echo( 'widget_subscribe' ); ?></button>
		</form>

		<?php if ( $atts['show-powered'] ) { ?>
			<p class="powered-by"><?php publisher_translation_echo( 'widget_newsletter_powered' ); ?> <img
					src="<?php echo PUBLISHER_THEME_URI . 'images/other/mailchimp.png'; ?>"
					data-bsrjs="<?php echo PUBLISHER_THEME_URI . 'images/other/mailchimp@2x.png'; ?>" alt="MailChimp"/>
			</p>
		<?php } ?>
	</div>
<?php

unset( $atts );
