<?php
/**
 * Simple recent posts widget
 *
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */
?>
<ul class="listing listing-widget listing-widget-simple">
	<?php while( publisher_have_posts() ): publisher_the_post(); ?>
		<li class="listing-item clearfix">
			<article <?php publisher_attr( 'post' ); ?>>
				<h4 class="title">
					<a href="<?php publisher_the_permalink(); ?>" class="post-url post-title">
						<?php publisher_echo_html_limit_words( publisher_get_the_title(), publisher_get_prop( 'title-limit', - 1 ) ); ?>
					</a>
				</h4>
			</article>
		</li>
	<?php endwhile; ?>
</ul>
