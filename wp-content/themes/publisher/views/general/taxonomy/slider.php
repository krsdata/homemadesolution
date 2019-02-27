<?php
/**
 * The man code to print sliders.
 *
 * @author     BetterStudio
 * @package    Publisher
 * @version    1.8.4
 */

// Get slider params
$slider_config = publisher_main_slider_config();

if ( ! $slider_config['show'] ) {
	return;
}

$class = array(
	'slider-container clearfix',
	'slider-type-' . $slider_config['type'],
	publisher_get_prop( 'taxonomy-slider-class', '' ),
);

switch ( $slider_config['type'] ) {

	case 'disable':
		return;
		break;

	case 'custom-blocks':
		$class[] = 'slider-' . $slider_config['style'] . '-container';
		$class[] = 'slider-overlay-' . $slider_config['overlay'];

		$term = get_queried_object();

		$query_args = array(
			'posts_per_page' => $slider_config['posts'],
			'tax_query'      => array(
				array(
					'taxonomy' => $term->taxonomy,
					'field'    => 'term_id',
					'terms'    => $term->term_id,
				)
			),
		);

		$query = new WP_Query( $query_args );

		publisher_set_query( $query );

		// not show if there is no post
		if ( ! publisher_have_posts() ) {
			return;
		}

		if ( ! empty( $slider_config['columns'] ) ) {
			publisher_set_prop( 'listing-class', 'slider-overlay-' . $slider_config['overlay'] . ' columns-' . $slider_config['columns'] );
		} else {
			publisher_set_prop( 'listing-class', 'slider-overlay-' . $slider_config['overlay'] );
		}
		break;

	case 'rev_slider':

		if ( ! function_exists( 'putRevSlider' ) ) {
			return;
		}

		break;
}


?>
<div class="<?php echo esc_attr( implode( ' ', $class ) ); ?>">
<?php

// In columns wrapper
if ( ! $slider_config['in-column'] ){
	?>
	<div class="content-wrap">
	<div class="container">
	<div class="row">
	<div class="col-sm-12">
	<?php
}


switch ( $slider_config['type'] ) {

	case 'custom-blocks':
		publisher_get_view( $slider_config['directory'], $slider_config['file'] );
		break;

	case 'rev_slider':
		putRevSlider( $slider_config['style'] );
		break;

}


// In columns wrapper
if ( ! $slider_config['in-column'] ){
	?>
	</div>
	</div>
	</div>
	</div>
	<?php
}

?>
	</div><?php

publisher_clear_props();
publisher_clear_query();
