<?php
/**
 * Text listing item template
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

$heading_tag = publisher_get_prop( 'item-heading-tag', 'h2' );
$subtitle    = publisher_prop_is( 'show-subtitle', 1 );

// Creates main term ID that used for custom category color style
$main_term = publisher_get_post_primary_cat();
if ( ! is_wp_error( $main_term ) && is_object( $main_term ) ) {
	$main_term_class = 'main-term-' . $main_term->term_id;
} else {
	$main_term_class = 'main-term-none';
}

?>
	<article <?php publisher_attr( 'post', publisher_get_prop_class() . ' listing-item listing-item-text listing-item-text-4 ' . $main_term_class ); ?>>
		<div class="item-inner">
			<?php

			if ( publisher_get_prop( 'show-term-badge', TRUE ) ) {
				publisher_cats_badge_code( publisher_get_prop( 'term-badge-count', 1 ), '', FALSE, TRUE, 'text-badges' );
			}

			if ( $subtitle && publisher_prop_is( 'subtitle-location', 'before-title' ) ) {
				$subtitle = FALSE;
				publisher_the_subtitle( '<h4 class="post-subtitle">', '</h4>', publisher_get_prop( 'subtitle-limit', 0 ) );
			}

			echo '<', $heading_tag, ' class="title">'; ?>
			<a href="<?php publisher_the_permalink(); ?>" class="post-title post-url">
				<?php publisher_echo_html_limit_words( publisher_get_the_title(), publisher_get_prop( 'title-limit', 70 ) ); ?>
			</a>
			<?php echo '</', $heading_tag, '>';

			if ( $subtitle && publisher_prop_is( 'subtitle-location', 'before-meta' ) ) {
				$subtitle = FALSE;
				publisher_the_subtitle( '<h4 class="post-subtitle">', '</h4>', publisher_get_prop( 'subtitle-limit', 0 ) );
			}

			if ( publisher_get_prop( 'show-meta', TRUE ) ) {
				publisher_loop_meta();
			}

			if ( $subtitle && publisher_prop_is( 'subtitle-location', 'before-excerpt' ) ) {
				$subtitle = FALSE;
				publisher_the_subtitle( '<h4 class="post-subtitle">', '</h4>', publisher_get_prop( 'subtitle-limit', 0 ) );
			}

			if ( publisher_get_prop( 'show-excerpt', FALSE ) ) { ?>
				<div class="post-summary">
					<?php publisher_the_excerpt( publisher_get_prop( 'excerpt-limit', 200 ), NULL, TRUE, FALSE ); ?>
				</div>
				<?php
			}

			?>
		</div>
	</article>
<?php

$main_term       = NULL;
$main_term_class = NULL;
