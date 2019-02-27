<?php


if ( ! function_exists( 'better_reviews_is_review_active' ) ) {
	/**
	 * Handy function to check state of review
	 *
	 * @since 1.3.0
	 */
	function better_reviews_is_review_active() {
		return Better_Reviews::get_meta( '_bs_review_enabled' );
	}
}


if ( ! function_exists( 'better_reviews_get_total_rate' ) ) {
	/**
	 * Handy function to get total rate of review
	 *
	 * @sine 1.3.0
	 */
	function better_reviews_get_total_rate() {
		return Better_Reviews()->generator()->calculate_overall_rate();
	}
}


if ( ! function_exists( 'better_reviews_get_review_type' ) ) {
	/**
	 * Handy function to get total rate of review
	 *
	 * @since 1.3.0
	 */
	function better_reviews_get_review_type() {
		return Better_Reviews::get_meta( '_bs_review_rating_type' );
	}
}
