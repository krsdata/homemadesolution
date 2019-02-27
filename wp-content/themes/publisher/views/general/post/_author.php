<?php
/**
 * Post author box in bottom of post contents template
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

$author_id = get_the_author_meta( 'ID' );

$author_archive_link = get_author_posts_url( $author_id );

?>
<section <?php publisher_attr( 'author', 'clearfix' ); ?>>
	<?php

	/**
	 * Filter the author bio avatar size.
	 *
	 * @since Publisher 1.0
	 *
	 * @param int $size The avatar height and width size in pixels.
	 */
	$avatar_size = apply_filters( 'publisher/post/author/avatar-size', 80 );

	?>
	<a href="<?php echo esc_url( $author_archive_link ); ?>"
	   title="<?php echo publisher_translation_esc_attr( 'browse_auth_articles' ); ?>">
		<span <?php publisher_attr( 'author-avatar' ); ?>><?php echo get_avatar( $author_id, $avatar_size ); /* escaped before */ ?></span>
	</a>

	<h5 class="author-title">
		<a <?php publisher_attr( 'post-meta-author-url' ) ?>><span <?php publisher_attr( 'author-name' ); ?>><?php echo get_the_author_meta( 'display_name' ); // escaped before in WP ?></span></a>
	</h5>

	<div class="author-links">
		<?php publisher_the_author_social_icons( $author_id ); ?>
	</div>

	<div <?php publisher_attr( 'author-bio' ); ?>>
		<?php echo wpautop( get_the_author_meta( 'description' ) ); // escaped before ?>
	</div>

</section>
