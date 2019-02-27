<?php
/**
 * The template to show social share shortcode/widget
 *
 * [bs-social-share] shortcode
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

$atts = publisher_get_prop( 'shortcode-bs-social-share-atts' );

if ( ! isset( $atts['class'] ) ) {
	$atts['class'] = '';
}

$show_title = TRUE;

if ( $atts['style'] == 'button-no-text' ) {
	$atts['style'] = 'button';
	$show_title    = FALSE;
} elseif ( $atts['style'] == 'outline-button-no-text' ) {
	$atts['style'] = 'outline-button';
	$show_title    = FALSE;
	$atts['class'] .= 'no-title-style';
}

$atts['class'] .= ' style-' . $atts['style'];

if ( $atts['colored'] ) {
	$atts['class'] .= ' colored';
}

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
	?>
		class="bs-shortcode bs-social-share <?php echo esc_attr( $atts['class'] ); ?>">
		<?php

		bf_shortcode_show_title( $atts ); // show title

		?>
		<ul class="bs-button-list social-list clearfix"><?php

			if ( ! is_array( $atts['sites'] ) ) {
				$atts['sites'] = explode( ',', $atts['sites'] );
				foreach ( $atts['sites'] as $site ) {
					echo publisher_shortcode_social_share_get_li( $site, $show_title ); // escaped before
				}
			} else {
				foreach ( $atts['sites'] as $site_key => $site ) {
					if ( $site ) {
						echo publisher_shortcode_social_share_get_li( $site_key, $show_title ); // escaped before
					}
				}
			}

			?>
		</ul><!-- .social-list -->
	</div><!-- .bs-social-share -->
<?php

unset( $atts );
unset( $show_title );
