<?php
/**
 * comments.php
 *
 * The template for displaying comments.
 *
 * Content of each comment will be output with the type of comment.
 * You can view and/or edit the comment file in "views/general/comments"
 *
 * @author    BetterStudio
 * @package   Publisher
 * @version   1.8.4
 */

/* If a post password is required, return. */
if ( post_password_required() ) {
	return;
}

// Comment Form Location
$form_location = publisher_get_option( 'post_comments_form_position' );

$note_before = publisher_translation_get( 'comment_notes_before' );
if ( ! empty( $note_before ) ) {
	$note_before = '<div class="note-before">' . wpautop( $note_before ) . '</div>';
}

$note_after = publisher_translation_get( 'comment_notes_after' );
if ( ! empty( $note_after ) ) {
	$note_after = '<div class="note-after">' . wpautop( $note_after ) . '</div>';
}

// Comment Form Arguments
$form_args = array(
	'title_reply'          => '<h4 class="section-heading" ><span class="h-text">' . publisher_translation_get( 'comments_leave_reply' ) . '</span></h4>',
	'title_reply_to'       => '<h4 class="section-heading" ><span class="h-text">' . publisher_translation_get( 'comments_reply_to' ) . '</span></h4>',
	'comment_notes_before' => $note_before,
	'comment_notes_after'  => $note_after,

	'logged_in_as' => '<p class="logged-in-as">' . sprintf(
			publisher_translation_get( 'comments_logged_as' ) . ' <a href="%1$s">%2$s</a>. <a href="%3$s" title="' . publisher_translation_esc_attr( 'comments_logout_this' ) . '"> ' . publisher_translation_get( 'comments_logout' ) . '</a>',
			admin_url( 'profile.php' ),
			$user_identity,
			wp_logout_url( get_permalink() )
		) . '</p>',

	'comment_field'     => '<p class="comment-wrap"><textarea name="comment" class="comment" id="comment" cols="45" rows="10" aria-required="true" placeholder="' . publisher_translation_esc_attr( 'comments_your_comment' ) . '"></textarea></p>',
	'id_submit'         => 'comment-submit',
	'class_submit'      => 'comment-submit',
	'label_submit'      => publisher_translation_esc_attr( 'comments_post_comment' ),
	'cancel_reply_link' => publisher_translation_esc_attr( 'comments_cancel_reply' ),
	'fields'            => array(
		'author' => '<p class="author-wrap"><input name="author" class="author" id="author" type="text" value="" size="45" aria-required="true" placeholder="' . publisher_translation_esc_attr( 'comments_your_name' ) . '" /></p>',
		'email'  => '<p class="email-wrap"><input name="email" class="email" id="email" type="text" value="" size="45" aria-required="true" placeholder="' . publisher_translation_esc_attr( 'comments_your_email' ) . '" /></p>',
	),
);

// Removes url field from form
if ( publisher_get_option( 'post_comments_form_remove_url' ) == 'no' ) {
	$form_args['fields']['url'] = '<p class="url-wrap"><input name="url" class="url" id="url" type="text" value="" size="45" placeholder="' . publisher_translation_esc_attr( 'comments_your_website' ) . '" /></p>';
}

?>
<section id="comments-template-<?php the_ID() ?>" class="comments-template">
	<?php
	// Shows comment form
	if ( $form_location == 'top' || $form_location == 'both' ) {

		comment_form( $form_args );
	}

	if ( have_comments() ) : // Check if there are any comments. 
		?>

		<div id="comments" class="comments-wrap">

			<?php if ( ! publisher_get_global( 'multiple-comments', FALSE ) ) {

				// Comments Number
				$num_comments = get_comments_number();

				// Prepare comment text
				if ( $num_comments == 0 ) {
					$comments_text = publisher_translation_get( 'no_comment_title' );
				} elseif ( $num_comments > 1 ) {
					$comments_text = str_replace( '%s', number_format_i18n( $num_comments ), publisher_translation_get( 'comments_count_title' ) );
				} else {
					$comments_text = publisher_translation_get( 'comments_1_comment' );
				}

				?>
				<h4 class="section-heading"><span class="h-text"><?php echo esc_html( $comments_text ); ?></span></h4>
			<?php } ?>

			<ol class="comment-list">
				<?php wp_list_comments( publisher_list_comments_args() ); ?>
			</ol><!-- .comment-list -->

			<?php

			publisher_get_view( 'comments', '_nav' );

			?>

		</div><!-- .comments-wrap-->

	<?php endif; // End check for comments. ?>

	<?php publisher_get_view( 'comments', '_messages' ); ?>

	<?php
	// Shows comment form
	if ( $form_location == 'bottom' || $form_location == 'both' ) {
		comment_form( $form_args );
	}
	?>
</section>
