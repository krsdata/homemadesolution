<?php

/**
 * Generate Reviews Preview Codes
 */
class Better_Reviews_Generator {


	function __construct() {

		add_filter( 'the_content', array( $this, 'bf_main_content' ) );

		add_filter( 'post_class', array( $this, 'bf_post_class' ) );

	}


	/**
	 * Callback: Ads review class for post classes
	 * Filter: post_class
	 *
	 * @param $classes
	 *
	 * @return string
	 */
	public function bf_post_class( $classes ) {

		if ( ! $this->is_review_enabled() ) {
			return $classes;
		}

		$classes[] = 'review-post';

		if ( is_single( get_the_ID() ) && Better_Reviews::get_meta( '_bs_review_pos' ) && Better_Reviews::get_meta( '_bs_review_pos' ) != 'none' ) {
			$classes[] = 'review-post-' . Better_Reviews::get_meta( '_bs_review_pos' );
		}

		return $classes;
	}


	/**
	 * Filter Callback: Main Content off page and posts
	 *
	 * @param $content
	 *
	 * @return string
	 */
	public function bf_main_content( $content ) {

		if ( ! $this->is_review_enabled() ) {
			return $content;
		}

		$atts = $this->prepare_atts( array() );

		if ( $atts['position'] && $atts['position'] != 'none' ) {

			if ( $atts['position'] === 'top' ) {
				$atts['class'] = 'review-top';
				$content       = $this->generate_block( $atts, TRUE ) . $content;
			} elseif ( $atts['position'] === 'bottom' ) {
				$atts['class'] = 'review-bottom';
				$content       = $content . $this->generate_block( $atts, TRUE );
			} elseif ( $atts['position'] === 'top-bottom' ) {
				$atts['class']  = 'review-top';
				$reviews_top    = $this->generate_block( $atts, TRUE );
				$atts['class']  = 'review-bottom';
				$reviews_bottom = $this->generate_block( $atts, TRUE );
				$content        = $reviews_top . $content . $reviews_bottom;
			}

			if ( function_exists( 'is_better_amp' ) && is_better_amp() ) {

				static $amp_style_preinted;

				if ( ! $amp_style_preinted ) {
					ob_start();
					include bf_append_suffix( Better_Reviews::dir_path( 'css/better-reviews' ), '.css' );

					if ( is_rtl() ) {
						include bf_append_suffix( Better_Reviews::dir_path( 'css/better-reviews-rtl' ), '.css' );
					}

					better_amp_add_inline_style( better_amp_css_sanitizer( ob_get_clean() ), 'better-reviews' );
				}
			}

		}

		return $content;
	}


	/**
	 * Used for preparing review atts
	 *
	 * @param $atts
	 *
	 * @return array
	 */
	public function prepare_atts( $atts = array() ) {

		if ( ! isset( $atts['type'] ) ) {
			$atts['type'] = Better_Reviews::get_meta( '_bs_review_rating_type' );
		}

		if ( ! isset( $atts['heading'] ) ) {
			$atts['heading'] = Better_Reviews::get_meta( '_bs_review_heading' );
		}

		if ( ! isset( $atts['verdict'] ) ) {
			$atts['verdict'] = Better_Reviews::get_meta( '_bs_review_verdict' );
		}

		if ( ! isset( $atts['summary'] ) ) {
			$atts['summary'] = Better_Reviews::get_meta( '_bs_review_verdict_summary' );
		}

		if ( ! isset( $atts['criteria'] ) ) {
			$atts['criteria'] = Better_Reviews::get_meta( '_bs_review_criteria' );
		}

		if ( ! isset( $atts['position'] ) ) {
			$atts['position'] = Better_Reviews::get_meta( '_bs_review_pos' );
		}

		if ( ! isset( $atts['extra_desc'] ) ) {
			$atts['extra_desc'] = Better_Reviews::get_meta( '_bs_review_extra_desc' );
		}

		return $atts;
	}


	/**
	 * Used for preparing review atts
	 *
	 * @param $atts
	 *
	 * @return array
	 */
	public function prepare_rate_atts( $atts = array() ) {

		if ( ! isset( $atts['type'] ) ) {
			$atts['type'] = Better_Reviews::get_meta( '_bs_review_rating_type' );
		}

		if ( ! isset( $atts['criteria'] ) ) {
			$atts['criteria'] = Better_Reviews::get_meta( '_bs_review_criteria' );
		}

		return $atts;
	}


	/**
	 * Used for checking state of review
	 *
	 * @return string
	 */
	public function is_review_enabled() {
		return Better_Reviews::get_meta( '_bs_review_enabled' );
	}


	/**
	 * Generates big block
	 *
	 * @param      $atts
	 *
	 * @param bool $prepared_atts
	 *
	 * @return string
	 */
	public function generate_block( $atts, $prepared_atts = FALSE ) {

		// Review is not enable
		if ( ! $this->is_review_enabled() ) {
			return '';
		}

		if ( ! $prepared_atts ) {
			$atts = $this->prepare_atts( $atts );
		}

		$overall_rate = $this->calculate_overall_rate( $atts );

		if ( ! isset( $atts['class'] ) ) {
			$atts['class'] = '';
		}

		ob_start();

		?>
	<section class=" betterstudio-review type-<?php echo $atts['type'], ' ', $atts['class']; ?>">
		<div class="verdict clearfix">
			<div class="overall">
                <span class="rate"><?php

	                if ( $atts['type'] == 'points' ) {
		                echo round( $overall_rate / 10, 1 );
	                } else {
		                echo $overall_rate;
	                }


	                if ( $atts['type'] != 'points' ) {
		                echo '<span class="percentage">%</span>';
	                }

	                ?></span>
				<?php

				echo $this->get_rating( $overall_rate, $atts['type'] );

				?>
				<span class="verdict-title"><?php echo $atts['verdict']; ?></span>
			</div>
			<?php ?>
			<div
				class="the-content verdict-summary"><?php
				if ( ! empty( $atts['heading'] ) ) {
					echo '<h4 class="page-heading uppercase"><span class="h-title">' . $atts['heading'] . '</span></h4>';
				}

				echo wpautop( do_shortcode( $atts['summary'] ) ); ?>
			</div>
		</div>
		<ul class="criteria-list"><?php

			foreach ( $atts['criteria'] as $criteria ) {

				?>
				<li class="clearfix">
					<div class="criterion">
					<span
						class="title"><?php echo ! empty( $criteria['label'] ) ? $criteria['label'] : __( 'Criteria', 'better-studio' ); ?></span>
						<?php if ( $atts['type'] != 'stars' ) { ?>
							<span
								class="rate"><?php echo $atts['type'] != 'points' ? round( $criteria['rate'] * 10 ) . '%' : $criteria['rate']; ?></span>
						<?php } ?>
					</div>
					<?php
					if ( $atts['type'] != 'points' ) {
						echo $this->get_rating( $criteria['rate'] * 10, $atts['type'] );
					} else {
						echo $this->get_rating( $criteria['rate'] * 10, $atts['type'] );
					}
					?>
				</li>
				<?php
			}

			?>
		</ul>
		<?php if ( ! empty( $atts['extra_desc'] ) ) { ?>
			<div class="review-description"><?php echo wpautop( do_shortcode( $atts['extra_desc'] ) ); ?></div>
		<?php } ?>
		</section><?php

		$output = ob_get_clean();
		$output = str_replace( "\n", '', $output ); // remove \n because using it inside other shortcodes like VC will create some bugs!

		return $output;
	}


	/**
	 * Calculates overall rate
	 *
	 * @param $atts
	 *
	 * @return float
	 */
	public function calculate_overall_rate( $atts = NULL ) {

		if ( is_null( $atts ) ) {
			$atts = $this->prepare_atts( array() );
		}

		$total = 0;

		foreach ( (array) $atts['criteria'] as $criteria ) {
			$total += floatval( $criteria['rate'] ) * 10;
		}

		if ( $total == 0 ) {
			return 0;
		}

		if ( $atts['type'] === 'points' ) {
			return round( $total / count( $atts['criteria'] ), 1 );
		} else {
			return round( $total / count( $atts['criteria'] ) );
		}

	}


	/**
	 * Used for retiring generated bars
	 *
	 * @param        $rate
	 * @param string $type
	 * @param bool   $show_rate
	 *
	 * @return string
	 */
	public function get_rating( $rate, $type = 'stars', $show_rate = FALSE ) {

		if ( $show_rate ) {
			if ( $type == 'points' ) {
				$show_rate = '<span class="rate-number">' . round( $rate / 10, 1 ) . '</span>';
			} else {
				$show_rate = '<span class="rate-number">' . esc_html( $rate ) . '%</span>';
			}
		} else {
			$show_rate = '';
		}

		if ( $type == 'points' || $type == 'percentage' ) {
			$type = 'bar';
		}

		return '<div class="rating rating-' . esc_attr( $type ) . '"><span style="width: ' . esc_attr( $rate ) . '%;"></span>' . $show_rate . '</div>';
	}

}
