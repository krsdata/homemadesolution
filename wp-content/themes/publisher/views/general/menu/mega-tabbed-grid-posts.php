<?php
/**
 * Grid posts mega menu template
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

$args = publisher_get_prop( 'mega-menu-args', array() );

$is_deferred_load = TRUE;

// Query Args
$query_args = array(
	'order'               => 'date',
	'posts_per_page'      => 3,
	'ignore_sticky_posts' => 1,
	'post_type'           => 'post',
);


// Mega category and tag composition
if ( isset( $args['current-item']->mega_menu_cat ) && $args['current-item']->mega_menu_cat != 'auto' ) {

	if ( bf_is_a_category( $args['current-item']->mega_menu_cat ) ) {
		$query_args['cat'] = $args['current-item']->mega_menu_cat;
	} elseif ( $args['current-item']->object == 'category' ) {
		$query_args['cat'] = $args['current-item']->object_id;
	}

} elseif ( $args['current-item']->object == 'category' ) {
	$query_args['cat'] = $args['current-item']->object_id;
}

// Prepare query
$wp_query = new WP_Query( $query_args );
publisher_set_query( $wp_query, 'cache_posts=1' );

$menu_id = mt_rand();

$sub_cats = get_categories(
	array(
		'parent' => $args['current-item']->object_id,
		'number' => 15
	)
);

// Sorts terms by name length
bf_sort_terms( $sub_cats );

$tabs = array();
foreach ( $sub_cats as $_sub_cat ) {
	$tabs[] = array(
		'name' => $_sub_cat->name,
		'link' => get_term_link( $_sub_cat, 'category' ),

		'term_id'  => $_sub_cat->term_id,
		'block_id' => mt_rand(),
	);
}

?>
	<div class="mega-menu tabbed-grid-posts">
		<div class="content-wrap clearfix">
			<ul class="tabs-section">
				<?php $angle = is_rtl() ? 'left' : 'right'; ?>
				<li class="active">
					<a href="<?php echo esc_url( $args['current-item']->url ); ?>"
					   data-target="#mtab-<?php echo esc_attr( $menu_id ); ?>-<?php echo esc_attr( $args['current-item']->object_id ); ?>"
					   data-toggle="tab" aria-expanded="true"
					   class="term-<?php echo esc_attr( $args['current-item']->object_id ); ?>">
						<i class="fa fa-angle-<?php echo $angle; ?>"></i> <?php publisher_translation_echo( 'menu_all' ); ?>
					</a>
				</li>
				<?php

				foreach ( $tabs as $tab ) {

					$id = mt_rand();
					?>
					<li>
						<a href="<?php echo esc_url( $tab['link'] ); ?>"
						   data-target="#mtab-<?php echo esc_attr( $menu_id ); ?>-<?php echo esc_attr( $tab['term_id'] ); ?>"
						   data-deferred-init="<?php echo esc_attr( $tab['block_id'] ); ?>"
						   data-toggle="tab" data-deferred-event="mouseenter"
						   class="term-<?php echo esc_attr( $tab['term_id'] ); ?>">
							<i class="fa fa-angle-<?php echo $angle; ?>"></i> <?php echo $tab['name']; // escaped before ?>
						</a>
					</li>
					<?php

				}

				?>
			</ul>
			<div class="tab-content">
				<div class="tab-pane bs-tab-anim bs-tab-animated active"
				     id="mtab-<?php echo esc_attr( $menu_id ); ?>-<?php echo esc_attr( $args['current-item']->object_id ); ?>">
					<?php

					$atts = array(
						'paginate'        => 'next_prev',
						'have_pagination' => TRUE,
						'show_label'      => TRUE,

						'order_by' => 'date',
						'count'    => 3,
						'category' => $args['current-item']->object_id,
					);

					publisher_set_prop( 'listing-main-term', $args['current-item']->object_id );

					publisher_theme_pagin_manager()->wrapper_start( $atts );

					publisher_get_view( 'menu', 'mega-tabbed-grid-posts-content' );

					publisher_theme_pagin_manager()->wrapper_end();

					publisher_theme_pagin_manager()->display_pagination( $atts, $wp_query, 'Publisher::bs_pagin_ajax_tabbed_mega_grid_posts', 'wp_query' );

					?>
				</div>
				<?php

				$view = 'Publisher::bs_pagin_ajax_tabbed_mega_grid_posts';

				$type = 'wp_query';

				foreach ( $tabs as $tab ) {
					?>
					<div class="tab-pane bs-tab-anim<?php echo $is_deferred_load ? ' bs-deferred-container' : '' ?>"
					     id="mtab-<?php echo esc_attr( $menu_id ); ?>-<?php echo esc_attr( $tab['term_id'] ); ?>">
						<?php

						// Prepare query nad atts
						$atts['category'] = $query_args['cat'] = $tab['term_id'];
						publisher_set_prop( 'listing-main-term', $tab['term_id'] );

						if ( $is_deferred_load ) {

							publisher_theme_pagin_manager()->wrapper_start( $atts );
							publisher_theme_pagin_manager()->display_deferred_html( $atts, $view, $type, $tab['block_id'] );
							publisher_theme_pagin_manager()->wrapper_end();

						} else {

							$wp_query = new WP_Query( $query_args );
							publisher_set_query( $wp_query, 'cache_posts=1' );
							publisher_theme_pagin_manager()->wrapper_start( $atts );
							publisher_get_view( 'menu', 'mega-tabbed-grid-posts-content' );
							publisher_theme_pagin_manager()->wrapper_end();
							publisher_theme_pagin_manager()->display_pagination( $atts, $wp_query, $view, $type );

						}

						?>
					</div>
					<?php
				}

				?>
			</div>
		</div>
	</div>
<?php

publisher_clear_props();
//TOOD: @vc_frontend
publisher_clear_query();
