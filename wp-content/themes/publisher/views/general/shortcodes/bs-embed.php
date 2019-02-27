<?php
/**
 * The template to show embed shortcode/widget
 *
 * [bs-embed] shortcode
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

$atts = publisher_get_prop( 'shortcode-bs-embed-atts' );

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
		class="bs-shortcode bs-embed clearfix <?php echo esc_attr( $atts['css-class'] ); ?>">
		<?php

		bf_shortcode_show_title( $atts ); // show title

		$embeds_list = explode( "\n", $atts['url'] );

		foreach ( $embeds_list as $embed ) {

			$embed = trim( $embed );

			if ( empty( $embed ) ) {
				continue;
			}

			?>
			<div class="bs-embed-item bs-lazy-iframe-wrapper">
				<?php

				$embed  = bf_auto_embed_content( $embed );
				$output = do_shortcode( $embed['content'] );

				if ( publisher_is_lazy_loading() ) {

					$output = str_replace(
						array( ' src=\'', ' src="' ),
						array( ' data-src=\'', ' data-src="' ),
						$output
					);
				}

				echo $output; // escaped before
				?>
			</div>
			<?php

		}

		?>
	</div><!-- .bs-embed -->
<?php

unset( $atts );
unset( $embeds_list );
