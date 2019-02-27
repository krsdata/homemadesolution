<?php
/**
 * Mix listing 4-4 template
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

$_posts_count = publisher_get_prop( 'posts-count', 0 );

$block_settings = FALSE;
if ( ! publisher_get_prop( 'block-customized', FALSE ) ) {
	$block_settings = publisher_get_option( 'listing-mix-4-4' );

	if ( $block_settings_override = publisher_get_prop( 'block-settings-override' ) ) {
		$block_settings = array_merge( $block_settings, $block_settings_override );
	}
	$block_settings_override = NULL;

}

?>
	<div class="listing listing-mix-4-4 clearfix <?php publisher_echo_prop( 'listing-class' ); ?>">
		<?php

		publisher_set_prop( 'show-excerpt', TRUE );

		$_counter = 0;
		while( publisher_have_posts() ) {

			publisher_set_prop( 'posts-count', 1 );

			if ( publisher_have_posts() ) {

				if ( $block_settings ) {

					publisher_set_prop( 'title-limit', $block_settings['big-title-limit'] );
					publisher_set_prop( 'excerpt-limit', $block_settings['big-excerpt-limit'] );
					publisher_set_prop( 'show-subtitle', $block_settings['big-subtitle'] );

					if ( $block_settings['big-subtitle'] ) {
						publisher_set_prop( 'subtitle-limit', $block_settings['big-subtitle-limit'] );
						publisher_set_prop( 'subtitle-location', $block_settings['big-subtitle-location'] );
					}

					publisher_set_prop( 'show-term-badge', $block_settings['big-term-badge'] );
					publisher_set_prop( 'term-badge-count', $block_settings['big-term-badge-count'] );
					publisher_set_prop( 'term-badge-tax', $block_settings['big-term-badge-tax'] );
					publisher_set_prop( 'show-format-icon', $block_settings['big-format-icon'] );
					publisher_set_prop( 'show-meta', $block_settings['big-meta']['show'] );
					publisher_set_prop( 'show-read-more', $block_settings['big-read-more'] );

					if ( $block_settings['big-meta']['show'] ) {
						publisher_set_prop( 'hide-meta-author', ! $block_settings['big-meta']['author'] );
						publisher_set_prop( 'hide-meta-date', ! $block_settings['big-meta']['date'] );
						publisher_set_prop( 'meta-date-format', $block_settings['big-meta']['date-format'] );
						publisher_set_prop( 'hide-meta-view', ! $block_settings['big-meta']['view'] );
						publisher_set_prop( 'hide-meta-share', ! $block_settings['big-meta']['share'] );
						publisher_set_prop( 'hide-meta-comment', ! $block_settings['big-meta']['comment'] );
						publisher_set_prop( 'hide-meta-review', ! $block_settings['big-meta']['review'] );
					}

					publisher_set_prop( 'block-customized', TRUE );
				}

				$_counter ++;
				publisher_set_prop_thumbnail_size( 'publisher-lg' );
				publisher_set_prop( 'show-excerpt', publisher_get_prop( 'show-excerpt-big', TRUE ) );
				publisher_set_prop( 'listing-class', 'columns-1' );
				publisher_get_view( 'loop', 'listing-classic-2' );
			}

			publisher_unset_prop( 'posts-counter' );

			publisher_set_prop( 'posts-count', 2 );

			if ( publisher_have_posts() ) {

				if ( $block_settings ) {

					publisher_set_prop( 'title-limit', $block_settings['small-title-limit'] );
					publisher_set_prop( 'excerpt-limit', $block_settings['small-excerpt-limit'] );
					publisher_set_prop( 'show-subtitle', $block_settings['small-subtitle'] );

					if ( $block_settings['small-subtitle'] ) {
						publisher_set_prop( 'subtitle-limit', $block_settings['small-subtitle-limit'] );
						publisher_set_prop( 'subtitle-location', $block_settings['small-subtitle-location'] );
					}

					publisher_set_prop( 'show-term-badge', $block_settings['small-term-badge'] );
					publisher_set_prop( 'term-badge-count', $block_settings['small-term-badge-count'] );
					publisher_set_prop( 'term-badge-tax', $block_settings['small-term-badge-tax'] );
					publisher_set_prop( 'show-format-icon', $block_settings['small-format-icon'] );
					publisher_set_prop( 'show-meta', $block_settings['small-meta']['show'] );

					if ( $block_settings['small-meta']['show'] ) {
						publisher_set_prop( 'hide-meta-author', ! $block_settings['small-meta']['author'] );
						publisher_set_prop( 'hide-meta-date', ! $block_settings['small-meta']['date'] );
						publisher_set_prop( 'meta-date-format', $block_settings['small-meta']['date-format'] );
						publisher_set_prop( 'hide-meta-view', ! $block_settings['small-meta']['view'] );
						publisher_set_prop( 'hide-meta-share', ! $block_settings['small-meta']['share'] );
						publisher_set_prop( 'hide-meta-comment', ! $block_settings['small-meta']['comment'] );
						publisher_set_prop( 'hide-meta-review', ! $block_settings['small-meta']['review'] );
					}

					publisher_set_prop( 'block-customized', TRUE );
				}

				$_counter += 2;
				publisher_set_prop_thumbnail_size( 'publisher-md' );
				publisher_set_prop( 'show-excerpt', publisher_get_prop( 'show-excerpt-small', TRUE ) );
				publisher_set_prop( 'listing-class', 'columns-2' );
				publisher_get_view( 'loop', 'listing-grid-1' );
			}

			publisher_unset_prop( 'posts-counter' );

			if ( $_posts_count && $_counter >= $_posts_count ) {
				break;
			}
		}

		?>
	</div>
<?php

unset( $block_settings );
unset( $_posts_count );
unset( $_counter );
