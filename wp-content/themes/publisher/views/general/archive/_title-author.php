<?php
/**
 * Authors title template
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

$author = bf_get_author_archive_user();

/**
 * Filter the author bio avatar size.
 *
 * @since 'publisher- 1.0
 *
 * @param int $size The avatar height and width size in pixels.
 */
$avatar_size = apply_filters( 'publisher/author-archive/avatar-size', 100 );

?>
<section <?php publisher_attr( 'author', 'author-profile clearfix' ); ?>>

	<h3 class="section-heading">
		<span class="h-text"><?php publisher_translation_echo( 'author' ); ?></span>
	</h3>

	<div <?php publisher_attr( 'author-avatar' ); ?>>
		<?php echo isset( $author->ID ) ? get_avatar( $author->ID, $avatar_size ) : ''; // escaped before ?>
	</div>

	<h1 class="author-title">
		<a <?php publisher_attr( 'post-meta-author-url' ) ?>><span <?php publisher_attr( 'author-name' ); ?>><?php echo isset( $author->display_name ) ? esc_html( $author->display_name ) : ''; ?></span></a>
	</h1>

	<div class="author-links">
		<?php publisher_the_author_social_icons( $author ); ?>
	</div>

	<?php if ( isset( $author->ID ) && get_the_author_meta( 'description', $author->ID ) != '' ) { ?>
		<div <?php publisher_attr( 'author-bio' ); ?>>
			<?php echo wpautop( get_the_author_meta( 'description', $author->ID ) ); // escaped before ?>
		</div>
	<?php } ?>

</section>
