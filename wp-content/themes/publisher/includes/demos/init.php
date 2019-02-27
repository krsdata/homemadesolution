<?php
/**
 * Demo Installer Configuration
 */

add_filter( 'better-framework/product-pages/install-demo/config', 'publisher_demos_config' );

if ( ! function_exists( 'publisher_demos_config' ) ) {
	/**
	 * Adds active demos to BS Product Pages with correct config to install
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	function publisher_demos_config( $data = array() ) {

		static $theme_version;

		if ( ! $theme_version ) {
			$theme = wp_get_theme();

			if ( $theme->get( 'Template' ) ) {
				$theme = wp_get_theme( $theme->get( 'Template' ) );
			}

			$theme_version = $theme->get( 'Version' );
		}

		$data['pure-magazine']            = array(
			'thumbnail'   => PUBLISHER_THEME_URI . 'includes/demos/pure-magazine/thumbnail.png?v=' . $theme_version,
			'name'        => __( 'Pure Magazine', 'publisher' ),
			'preview_url' => 'http://demo.betterstudio.com/publisher/',
			'options'     => TRUE,
		);
		$data['clean-tech']               = array(
			'thumbnail'   => PUBLISHER_THEME_URI . 'includes/demos/clean-tech/thumbnail.png?v=' . $theme_version,
			'name'        => __( 'Clean Tech', 'publisher' ),
			'preview_url' => 'http://demo.betterstudio.com/publisher/clean-tech/',
			'options'     => TRUE,
		);
		$data['classic-magazine']         = array(
			'thumbnail'   => PUBLISHER_THEME_URI . 'includes/demos/classic-magazine/thumbnail.png?v=' . $theme_version,
			'name'        => __( 'Classic Magazine', 'publisher' ),
			'preview_url' => 'http://demo.betterstudio.com/publisher/classic-mag/',
			'options'     => TRUE,
		);
		$data['clean-blog']               = array(
			'thumbnail'   => PUBLISHER_THEME_URI . 'includes/demos/clean-blog/thumbnail.png?v=' . $theme_version,
			'name'        => __( 'Clean Blog', 'publisher' ),
			'preview_url' => 'http://demo.betterstudio.com/publisher/clean-blog/',
			'options'     => TRUE,
			'badges'      => array(
				'‌Blog'
			),
		);
		$data['clean-fashion']            = array(
			'thumbnail'   => PUBLISHER_THEME_URI . 'includes/demos/clean-fashion/thumbnail.png?v=' . $theme_version,
			'name'        => __( 'Clean Fashion', 'publisher' ),
			'preview_url' => 'http://demo.betterstudio.com/publisher/clean-fashion/',
			'options'     => TRUE,
		);
		$data['clean-magazine']           = array(
			'thumbnail'   => PUBLISHER_THEME_URI . 'includes/demos/clean-magazine/thumbnail.png?v=' . $theme_version,
			'name'        => __( 'Clean Magazine', 'publisher' ),
			'preview_url' => 'http://demo.betterstudio.com/publisher/clean-mag/',
			'options'     => TRUE,
		);
		$data['clean-design']             = array(
			'thumbnail'   => PUBLISHER_THEME_URI . 'includes/demos/clean-design/thumbnail.png?v=' . $theme_version,
			'name'        => __( 'Clean Design', 'publisher' ),
			'preview_url' => 'http://demo.betterstudio.com/publisher/clean-design/',
			'options'     => TRUE,
		);
		$data['clean-sport']              = array(
			'thumbnail'   => PUBLISHER_THEME_URI . 'includes/demos/clean-sport/thumbnail.png?v=' . $theme_version,
			'name'        => __( 'Clean Sport', 'publisher' ),
			'preview_url' => 'http://demo.betterstudio.com/publisher/clean-sport/',
			'options'     => TRUE,
		);
		$data['classic-blog']             = array(
			'thumbnail'   => PUBLISHER_THEME_URI . 'includes/demos/classic-blog/thumbnail.png?v=' . $theme_version,
			'name'        => __( 'Classic Blog', 'publisher' ),
			'preview_url' => 'http://demo.betterstudio.com/publisher/classic-blog/',
			'options'     => TRUE,
			'badges'      => array(
				'‌Blog'
			),
		);
		$data['clean-video']              = array(
			'thumbnail'   => PUBLISHER_THEME_URI . 'includes/demos/clean-video/thumbnail.png?v=' . $theme_version,
			'name'        => __( 'Clean Video', 'publisher' ),
			'preview_url' => 'http://demo.betterstudio.com/publisher/clean-video',
			'options'     => TRUE,
		);
		$data['clean-tech-rtl-arabic']    = array(
			'thumbnail'   => PUBLISHER_THEME_URI . 'includes/demos/clean-tech-rtl-arabic/thumbnail.png?v=' . $theme_version,
			'name'        => __( 'RTL - Clean Tech', 'publisher' ),
			'preview_url' => 'http://demo.betterstudio.com/publisher/rtl/',
			'badges'      => array(
				'RTL',
				'Arabic'
			),
			'options'     => TRUE,
		);
		$data['pure-magazine-rtl-arabic'] = array(
			'thumbnail'   => PUBLISHER_THEME_URI . 'includes/demos/pure-magazine-rtl-arabic/thumbnail.png?v=' . $theme_version,
			'name'        => __( 'RTL - Pure Mag', 'publisher' ),
			'preview_url' => 'http://demo.betterstudio.com/publisher/rtl-clean-mag/',
			'badges'      => array(
				'RTL',
				'Arabic'
			),
			'options'     => TRUE,
		);

		return $data;
	} // publisher_demos_config
}


if ( ! function_exists( 'publisher_get_demo_id' ) ) {
	/**
	 *
	 * @return mixed
	 */
	function publisher_get_demo_id() {

		global $publisher_theme_core_globals_cache;

		// return from cache
		if ( isset( $publisher_theme_core_globals_cache['theme-demo'] ) ) {
			return $publisher_theme_core_globals_cache['theme-demo'];
		}

		$demo = get_option( publisher_get_theme_panel_id() . '_current_demo' );

		// cache it
		$publisher_theme_core_globals_cache['theme-demo'] = $demo;

		return $demo;

	} // publisher_get_demo_id
}


// Adds filter for all demos content
foreach ( publisher_demos_config() as $demo_id => $demo_config ) {
	add_filter( 'better-framework/product-pages/install-demo/' . $demo_id . '/content', 'publisher_init_demo_content', 10, 2 );
	add_filter( 'better-framework/product-pages/install-demo/' . $demo_id . '/setting', 'publisher_init_demo_setting', 10, 2 );
}

if ( ! function_exists( 'publisher_init_demo_content' ) ) {
	/**
	 * Pulls selected demo data from its directory and send it to BS Product Pages demo installer
	 *
	 * @param array  $content
	 * @param string $demo_id
	 *
	 * @return array
	 */
	function publisher_init_demo_content( $content = array(), $demo_id = '' ) {

		$demos_list = publisher_demos_config();

		$theme_dir = get_template_directory() . '/';

		// check if its valid, get value from its directory
		if ( ! empty( $demos_list[ $demo_id ] ) ) {

			include $theme_dir . 'includes/demos/' . $demo_id . '/content.php';

			$content = call_user_func( 'publisher_demo_raw_content' );

		}

		return $content;
	} // publisher_init_demo_content
}

if ( ! function_exists( 'publisher_init_demo_setting' ) ) {
	/**
	 * Pulls selected demo data from its directory and send it to BS Product Pages demo installer
	 *
	 * @param array  $content
	 * @param string $demo_id
	 *
	 * @return array
	 */
	function publisher_init_demo_setting( $content = array(), $demo_id = '' ) {

		$demos_list = publisher_demos_config();

		$theme_dir = get_template_directory() . '/';

		// check if its valid, get value from its directory
		if ( ! empty( $demos_list[ $demo_id ] ) ) {

			include $theme_dir . 'includes/demos/' . $demo_id . '/options.php';

			$content = call_user_func( 'publisher_demo_raw_options' );

		}

		return $content;
	} // publisher_init_demo_setting
}


if ( ! function_exists( 'publisher_get_demo_images_url' ) ) {
	/**
	 * Used to get demo images url
	 *
	 * @param string $style_id
	 * @param string $demo_id
	 *
	 * @return array
	 */
	function publisher_get_demo_images_url( $style_id = '', $demo_id = '' ) {

		$demo_image_url = 'http://demo-contents.betterstudio.com/themes/publisher/v1/' . $style_id . '/';

		if ( bf_is( 'demo-dev' ) ) {
			$demo_image_url = home_url( 'demo-images/v1/' . $style_id . '/' );
		}

		return $demo_image_url;
	} // publisher_get_demo_images_url
}
