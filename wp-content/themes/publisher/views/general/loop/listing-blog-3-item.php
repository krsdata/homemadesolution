<?php
/**
 * Blog listing item template
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

// Creates main term ID that used for custom category color style
$main_term = publisher_get_post_primary_cat();
if ( ! is_wp_error( $main_term ) && is_object( $main_term ) ) {
	$main_term_class = 'main-term-' . $main_term->term_id;
} else {
	$main_term_class = 'main-term-none';
}

$thumbnail_size = publisher_get_prop_thumbnail_size( 'publisher-sm' );
$thumbnail      = publisher_get_thumbnail( $thumbnail_size );
$subtitle       = publisher_prop_is( 'show-subtitle', 1 );

?>
	<article <?php publisher_attr( 'post', publisher_get_prop_class() . ' clearfix listing-item listing-item-blog  listing-item-blog-3 ' . $main_term_class ); ?>>
		<?php

		if ( $subtitle && publisher_prop_is( 'subtitle-location', 'before-title' ) ) {
			$subtitle = FALSE;
			publisher_the_subtitle( '<h4 class="post-subtitle">', '</h4>', publisher_get_prop( 'subtitle-limit', 0 ) );
		}

		?>
		<h2 class="title">
			<a href="<?php publisher_the_permalink(); ?>" class="post-url post-title">
				<?php publisher_echo_html_limit_words( publisher_get_the_title(), publisher_get_prop( 'title-limit', 140 ) ); ?>
			</a>
		</h2>
		<?php

		if ( $subtitle && publisher_prop_is( 'subtitle-location', 'before-meta' ) ) {
			$subtitle = FALSE;
			publisher_the_subtitle( '<h4 class="post-subtitle">', '</h4>', publisher_get_prop( 'subtitle-limit', 0 ) );
		}

		if ( publisher_get_prop( 'show-meta', TRUE ) ) {
			publisher_loop_meta();
		}

		if ( ! empty( $thumbnail['src'] ) ) { ?>
			<div class="featured clearfix">
			<?php

			if ( publisher_get_prop( 'show-term-badge', TRUE ) ) {
				publisher_cats_badge_code( publisher_get_prop( 'term-badge-count', 1 ), '', FALSE, TRUE, 'floated' );
			}

			?>
			<a <?php publisher_the_thumbnail_attr( $thumbnail_size ); ?>
				class="img-holder" href="<?php publisher_the_permalink(); ?>"></a>
			<?php

			if ( publisher_get_prop( 'show-format-icon' ) ) {
				publisher_format_icon();
			}

			publisher_edit_post_link();

			?>
			</div><?php
		}

		if ( $subtitle && publisher_prop_is( 'subtitle-location', 'before-excerpt' ) ) {
			publisher_the_subtitle( '<h4 class="post-subtitle">', '</h4>', publisher_get_prop( 'subtitle-limit', 0 ) );
		}

		if ( publisher_get_prop( 'show-excerpt', TRUE ) ) { ?>
			<div class="post-summary">
				<?php publisher_the_excerpt( publisher_get_prop( 'excerpt-limit', 530 ), NULL, TRUE, FALSE ); ?>
			</div>
			<?php
		}

		?>
	</article>
<?php

$subtitle        = NULL;
$main_term       = NULL;
$main_term_class = NULL;
$thumbnail       = NULL;
$thumbnail_size  = NULL;
