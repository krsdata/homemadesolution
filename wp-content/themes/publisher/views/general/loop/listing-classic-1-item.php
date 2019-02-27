<?php
/**
 * Classic listing item template
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

$thumbnail_size = publisher_get_prop_thumbnail_size( 'publisher-lg' );
$thumbnail      = publisher_get_thumbnail( $thumbnail_size );
$subtitle       = publisher_prop_is( 'show-subtitle', 1 );

$class = ' listing-item listing-item-classic listing-item-classic-1';

// Creates main term ID that used for custom category color style
$main_term = publisher_get_post_primary_cat();
if ( ! is_wp_error( $main_term ) && is_object( $main_term ) ) {
	$class .= ' main-term-' . $main_term->term_id;
} else {
	$class .= ' main-term-none';
}

$columns = publisher_get_prop( 'listing-columns' );

?>
	<article <?php publisher_attr( 'post', publisher_get_prop_class() . $class ); ?>>
		<div class="listing-inner">
			<?php if ( ! empty( $thumbnail['src'] ) ) { ?>
				<div class="featured clearfix">
					<?php

					if ( publisher_get_prop( 'show-term-badge', TRUE ) ) {
						publisher_cats_badge_code( publisher_get_prop( 'term-badge-count', 1 ), '', FALSE, TRUE, 'floated' );
					}

					?>
					<a <?php publisher_the_thumbnail_attr( $thumbnail_size ); ?>
						class="img-holder" href="<?php publisher_the_permalink(); ?>"></a>
					<?php

					if ( publisher_get_prop( 'show-format-icon', TRUE ) ) {
						publisher_format_icon();
					}

					publisher_edit_post_link();

					?>
				</div>
			<?php }

			if ( $subtitle && publisher_prop_is( 'subtitle-location', 'before-title' ) ) {
				$subtitle = FALSE;
				publisher_the_subtitle( '<h4 class="post-subtitle">', '</h4>', publisher_get_prop( 'subtitle-limit', 0 ) );
			}

			?>
			<h2 class="title">
				<a href="<?php publisher_the_permalink(); ?>" class="post-url post-title">
					<?php publisher_echo_html_limit_words( publisher_get_the_title(), publisher_get_prop( 'title-limit', - 1 ) ); ?>
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

			if ( $subtitle && publisher_prop_is( 'subtitle-location', 'before-excerpt' ) ) {
				publisher_the_subtitle( '<h4 class="post-subtitle">', '</h4>', publisher_get_prop( 'subtitle-limit', 0 ) );
			}

			?>
			<?php if ( publisher_get_prop( 'show-excerpt', TRUE ) ) { ?>
				<div class="post-summary">
					<?php

					switch ( $columns ) {

						case 1:
							$excerpt_length = publisher_get_prop( 'excerpt-limit', 350 );
							break;

						case 2:
							$excerpt_length = publisher_get_prop( 'excerpt-limit-2col', 175 );
							break;

						case 3:
							$excerpt_length = publisher_get_prop( 'excerpt-limit-3col', 100 );
							break;

						default:
							$excerpt_length = publisher_get_prop( 'excerpt-limit', 350 );

					}

					publisher_the_excerpt( $excerpt_length, NULL, TRUE, FALSE );

					?>
				</div>
			<?php }

			if ( publisher_get_prop( 'show-read-more', TRUE ) ) {

				?>
				<a class="read-more"
				   href="<?php publisher_the_permalink(); ?>"><?php publisher_translation_echo( 'continue_reading' ); ?></a>
				<?php
			}

			?>
		</div>
	</article>
<?php

$subtitle        = NULL;
$thumbnail_size  = NULL;
$thumbnail       = NULL;
$main_term       = NULL;
$main_term_class = NULL;
$class           = NULL;
$excerpt_length  = NULL;
