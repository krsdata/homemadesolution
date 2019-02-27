<?php
/**
 * Template of each item in modern listing 10
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

$subtitle = publisher_prop_is( 'show-subtitle', 1 );

?>
	<article <?php publisher_attr( 'post', publisher_get_prop_class() . ' listing-item listing-mg-item listing-mg-10-item listing-mg-type-1 ' . $main_term_class ) ?>>
		<div class="item-content">
			<a <?php publisher_the_thumbnail_attr( publisher_get_prop_thumbnail_size( 'publisher-md' ) ) ?>
				class="img-cont" href="<?php publisher_the_permalink(); ?>"></a>
			<?php

			if ( publisher_get_prop( 'show-term-badge', TRUE ) ) {
				publisher_cats_badge_code( publisher_get_prop( 'term-badge-count', 1 ), '', FALSE, TRUE, 'floated' );
			}

			if ( publisher_get_prop( 'show-format-icon', TRUE ) ) {
				publisher_format_icon();
			}

			?>
			<div class="content-container">
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

				if ( $subtitle && publisher_prop_is( 'subtitle-location', 'after-meta' ) ) {
					publisher_the_subtitle( '<h4 class="post-subtitle">', '</h4>', publisher_get_prop( 'subtitle-limit', 0 ) );
				}

				?>
			</div>
		</div>
	</article>
<?php

$subtitle        = NULL;
$main_term_class = NULL;
$main_term_class = NULL;
