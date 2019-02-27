<?php /* Template for displaying content on archives */ ?>
<article <?php post_class('mh-posts-grid-item clearfix'); ?>>
	<figure class="mh-posts-grid-thumb">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php
			if (has_post_thumbnail()) {
				the_post_thumbnail('mh-magazine-lite-medium');
			} else {
				echo '<img class="mh-image-placeholder" src="' . get_template_directory_uri() . '/images/placeholder-medium.png' . '" alt="' . esc_html__('No Picture', 'mh-healthmag') . '" />';
			} ?>
		</a>
	</figure>
	<h3 class="entry-title mh-posts-grid-title">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
			<?php the_title(); ?>
		</a>
	</h3>
	<div class="mh-meta mh-posts-grid-meta">
		<?php mh_magazine_lite_loop_meta(); ?>
	</div>
	<div class="mh-posts-grid-excerpt clearfix">
		<?php the_excerpt(); ?>
	</div>
</article>