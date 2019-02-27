<?php
/***
 *  BetterFramework is BetterStudio framework for themes and plugins.
 *
 *  ______      _   _             ______                                           _
 *  | ___ \    | | | |            |  ___|                                         | |
 *  | |_/ / ___| |_| |_ ___ _ __  | |_ _ __ __ _ _ __ ___   _____      _____  _ __| | __
 *  | ___ \/ _ \ __| __/ _ \ '__| |  _| '__/ _` | '_ ` _ \ / _ \ \ /\ / / _ \| '__| |/ /
 *  | |_/ /  __/ |_| ||  __/ |    | | | | | (_| | | | | | |  __/\ V  V / (_) | |  |   <
 *  \____/ \___|\__|\__\___|_|    \_| |_|  \__,_|_| |_| |_|\___| \_/\_/ \___/|_|  |_|\_\
 *
 *  Copyright © 2017 Better Studio
 *
 *
 *  Our portfolio is here: http://themeforest.net/user/Better-Studio/portfolio
 *
 *  \--> BetterStudio, 2017 <--/
 */


if ( ! function_exists( 'bf_enqueue_modal' ) ) {
	/**
	 * Enqueue BetterFramework modals safely
	 *
	 * @param $modal_key
	 */
	function bf_enqueue_modal( $modal_key = '' ) {

		Better_Framework::assets_manager()->add_modal( $modal_key );

	}
}

if ( ! function_exists( 'bf_enqueue_style' ) ) {
	/**
	 * @see   wp_enqueue_style for more documentation.
	 *
	 * @param string           $handle
	 * @param string           $src
	 * @param array            $deps
	 * @param string           $file_path
	 * @param string|bool|null $ver
	 */
	function bf_enqueue_style( $handle, $src = '', $deps = array(), $file_path = '', $ver = FALSE ) {

		if ( is_admin() ) {
			wp_enqueue_style( $handle, $src, $deps, $ver );

			return;
		}

		if ( $src ) {
			bf_styles()->add( $handle, $src, $deps, $ver, 'all' );
		}

		if ( $file_path ) {
			bf_styles()->files_path[ $handle ] = $file_path;
		}

		bf_styles()->enqueue( $handle );
	}
}

if ( ! function_exists( 'bf_enqueue_wp_script_deps' ) ) {

	function bf_enqueue_wp_script_deps( $handle ) {

		if ( ! isset( bf_scripts()->registered[ $handle ] ) ) {
			return;
		}

		$deps = &bf_scripts()->registered[ $handle ]->deps;
		foreach ( $deps as $index => $dep ) {

			if ( ! isset( bf_scripts()->registered[ $dep ] ) ) {

				if ( ! isset( wp_scripts()->registered[ $dep ] ) ) {
					continue;
				}

				unset( $deps[ $index ] );

				if ( wp_scripts()->registered[ $dep ]->args === 1 ) {
					wp_scripts()->registered[ $dep ]->args = NULL;
				}

				if ( ! wp_script_is( $dep ) ) {
					wp_enqueue_script( $dep );
				}

			} else {

				bf_enqueue_wp_script_deps( $dep );
			}
		}
	}
}

if ( ! function_exists( 'bf_enqueue_script' ) ) {
	/**
	 * Enqueue BetterFramework scripts safely
	 *
	 * @see   wp_enqueue_script for more documentation.
	 *
	 * @param string           $handle
	 * @param string           $src
	 * @param array            $deps
	 * @param string           $file_path
	 * @param string|bool|null $ver
	 */
	function bf_enqueue_script( $handle, $src = '', $deps = array(), $file_path = '', $ver = FALSE ) {

		if ( is_admin() ) {
			wp_enqueue_script( $handle, $src, $deps, $ver );

			return;
		}

		if ( $src ) {
			bf_scripts()->add( $handle, $src, $deps, $ver, '1' );
		}
		if ( $file_path ) {
			bf_scripts()->files_path[ $handle ] = $file_path;
		}

		bf_enqueue_wp_script_deps( $handle );

		bf_scripts()->enqueue( $handle );
	}
}

if ( ! function_exists( 'bf_register_script' ) ) {

	function bf_register_script( $handle, $src = '', $deps = array(), $file_path = '', $ver = FALSE ) {

		if ( is_admin() ) {
			wp_register_script( $handle, $src, $deps, $ver );

			return;
		}

		if ( $file_path ) {
			bf_scripts()->files_path[ $handle ] = $file_path;
		}

		bf_scripts()->add( $handle, $src, $deps, $ver, '1' );
	}
}

if ( ! function_exists( 'bf_deregister_script' ) ) {

	function bf_deregister_script( $handle ) {

		bf_scripts()->remove( $handle );
	}
}
if ( ! function_exists( 'bf_add_style_file' ) ) {

	/**
	 * Append inline css content into a file
	 *
	 * @param string   $id unique name
	 * @param callable $content_cb
	 *
	 * @since 2.9.0
	 */
	function bf_add_style_file( $id, $content_cb ) {

		bf_styles()->add_css_file( $id, $content_cb );
	}
}

if ( ! function_exists( 'bf_register_style' ) ) {

	function bf_register_style( $handle, $src = '', $deps = array(), $file_path = '', $ver = FALSE ) {

		if ( is_admin() ) {
			wp_register_style( $handle, $src, $deps, $ver );

			return;
		}

		if ( $file_path ) {
			bf_styles()->files_path[ $handle ] = $file_path;
		}

		bf_styles()->add( $handle, $src, $deps, $ver, '1' );
	}
}

if ( ! function_exists( 'bf_deregister_style' ) ) {

	function bf_deregister_style( $handle ) {

		bf_styles()->remove( $handle );
	}
}


if ( ! function_exists( 'bf_add_jquery_js' ) ) {
	/**
	 * Used for adding inline js to front end
	 *
	 * @param string $code
	 * @param bool   $to_top
	 * @param bool   $force
	 */
	function bf_add_jquery_js( $code = '', $to_top = FALSE, $force = FALSE ) {

		Better_Framework::assets_manager()->add_jquery_js( $code, $to_top, $force );

	}
}


if ( ! function_exists( 'bf_add_js' ) ) {
	/**
	 * Used for adding inline js to front end
	 *
	 * @param string $code
	 * @param bool   $to_top
	 * @param bool   $force
	 */
	function bf_add_js( $code = '', $to_top = FALSE, $force = FALSE ) {

		Better_Framework::assets_manager()->add_js( $code, $to_top, $force );

	}
}


if ( ! function_exists( 'bf_add_css' ) ) {
	/**
	 * Used for adding inline css to front end
	 *
	 * @param string $code
	 * @param bool   $to_top
	 * @param bool   $force
	 */
	function bf_add_css( $code = '', $to_top = FALSE, $force = FALSE ) {

		Better_Framework::assets_manager()->add_css( $code, $to_top, $force );

	}
}


if ( ! function_exists( 'bf_add_admin_js' ) ) {
	/**
	 * Used for adding inline js to back end
	 *
	 * @param string $code
	 * @param bool   $to_top
	 * @param bool   $force
	 */
	function bf_add_admin_js( $code = '', $to_top = FALSE, $force = FALSE ) {

		Better_Framework::assets_manager()->add_admin_js( $code, $to_top, $force );

	}
}


if ( ! function_exists( 'bf_add_admin_css' ) ) {
	/**
	 * Used for adding inline css to back end
	 *
	 * @param string $code
	 * @param bool   $to_top
	 * @param bool   $force
	 */
	function bf_add_admin_css( $code = '', $to_top = FALSE, $force = FALSE ) {

		Better_Framework::assets_manager()->add_admin_css( $code, $to_top, $force );

	}
}


if ( ! function_exists( 'bf_append_suffix' ) ) {
	/**
	 * Used for adding .min quickly
	 *
	 * @param string $before
	 * @param string $after
	 *
	 * @return string
	 */
	function bf_append_suffix( $before = '', $after = '' ) {

		static $suffix;

		if ( is_null( $suffix ) ) {
			$suffix = bf_is( 'dev' ) ? '' : '.min';
		}

		return $before . $suffix . $after;
	}
}
