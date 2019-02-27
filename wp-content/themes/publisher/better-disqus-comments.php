<?php
/**
 * better-disqus-comments.php
 *
 * Custom template file for our "Better Disqus Comments" plugin.
 *
 * @author    BetterStudio
 * @package   Publisher
 * @version   1.8.4
 */

?>
<section id="comments-template-<?php the_ID() ?>" class="comments-template comment-respond">

	<?php if ( ! publisher_get_global( 'multiple-comments', FALSE ) ) { ?>
		<h4 class="section-heading"><span class="h-text"><?php publisher_translation_echo( 'comments' ); ?></span></h4>
	<?php } ?>

	<div id="comments" class="better-comments-area better-disqus-comments-area">

		<div id="disqus_thread"></div>

		<noscript><?php _e( 'Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a>', 'publisher' ); ?></noscript>

	</div>
</section>
