<?php
/**
 * pingback and trackback comments template
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */
?>
<li <?php publisher_attr( 'comment' ); ?>>

	<article>
		<header class="comment-meta">
			<cite <?php publisher_attr( 'comment-author' ); ?>><?php comment_author_link(); ?></cite>
			<time <?php publisher_attr( 'comment-published' ); ?>><i
					class="fa  fa-calendar"></i> <?php echo sprintf( publisher_translation_get( 'readable_time_ago' ), human_time_diff( get_comment_time( 'U' ) ) ); ?>
			</time>
		</header><!-- .comment-meta -->

		<div <?php publisher_attr( 'comment-content' ); ?>>
			<?php comment_text(); ?>
		</div><!-- .comment-content -->

		<footer class="comment-footer">
			<?php edit_comment_link( ' <i class="fa fa-edit"></i> ' . publisher_translation_get( 'comments_edit' ) ); ?>
		</footer><!-- .comment-footer -->
	</article>

<?php /* No closing </li> is needed. */ ?>