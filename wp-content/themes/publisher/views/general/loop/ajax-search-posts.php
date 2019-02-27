<?php
/**
 * Ajax search posts
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

if ( publisher_have_posts() ) {

	publisher_get_view( 'loop', 'listing-thumbnail-1' );

	if ( publisher_get_prop( 'show-more-link', TRUE ) ) {

		?>
		<a href="<?php echo esc_attr( get_search_link( $_REQUEST['s'] ) ) ?>" class="clean-button ajax-search-button">
			<?php publisher_translation_echo( 'more_posts' );
			?>
		</a>
		<?php

	}

} else {

	?>
	<div class="align-vertical-center search-404">
		<?php
		publisher_translation_echo( 'search_not_found' );
		?>
	</div>
	<?php

}

