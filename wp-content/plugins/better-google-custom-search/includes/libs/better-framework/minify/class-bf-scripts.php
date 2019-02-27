<?php

/**
 * Merge and compress static js/css files.
 *
 * @since 2.9.0
 */
class BF_Scripts extends WP_Scripts {

	/**
	 * Static files path
	 *
	 * @var array
	 *
	 * @since 2.9.0
	 */
	public $files_path = array();


	/**
	 * Put contents into a file
	 *
	 * @param string $filename full path to file
	 * @param string $content
	 *
	 * @return bool true on success or false on failure
	 * @since 2.9.0
	 */
	public function write_file( $filename, $content ) {

		$dir = dirname( $filename );
		if ( ! is_dir( $dir ) ) {
			wp_mkdir_p( $dir );
		}

		return self::file_system()->put_contents(
			$filename,
			$content
		);
	}

	public function is_dir_writable( $dir_path ) {

		if ( ! is_dir( $dir_path ) ) {
			wp_mkdir_p( $dir_path );
		}

		return is_writeable( $dir_path );
	}


	/**
	 * Get file content
	 *
	 * @param string $handle handle name
	 *
	 * @since 2.9.0
	 * @return bool|string string on success or false on failure
	 */
	public function get_file_content( $handle ) {

		if ( ! empty( $this->files_path[ $handle ] ) && is_readable( $this->files_path[ $handle ] ) ) {

			$content = bf_get_local_file_content( $this->files_path[ $handle ] );
		} else {

			$remote = wp_remote_get( $this->registered[ $handle ]->src );

			if ( wp_remote_retrieve_response_code( $remote ) !== 200 ) {

				return FALSE;
			}

			$content = wp_remote_retrieve_body( $remote );
		}

		return $content;
	}


	/**
	 * Get WP FileSystem Object
	 *
	 * @since 2.9.0
	 * @return WP_Filesystem_Direct
	 */
	public static function file_system() {
		global $wp_filesystem;

		static $init = TRUE;

		if ( $init ) {

			if ( ! function_exists( 'WP_Filesystem' ) ) {
				require_once ABSPATH . '/wp-admin/includes/file.php';
			}

			WP_Filesystem( TRUE, WP_CONTENT_DIR, FALSE );

			$init = FALSE;
		}

		return $wp_filesystem;
	}


	/**
	 * Get unique file hash
	 *
	 * @param array $handles
	 *
	 * @since 2.9.0
	 * @return string
	 */
	public function file_hash( $handles ) {
		return md5( serialize( array_intersect_key( $this->registered, array_flip( $handles ) ) ) );
	}


	/**
	 * Combine and compress files content
	 *
	 * @param array  $handles
	 * @param string $new_filename
	 *
	 * @since 2.9.0
	 * @return bool true on success or false on failure
	 */
	public function do_minify( $handles, $new_filename ) {

		if ( is_admin() ) {
			return;
		}

		if ( ! $this->is_dir_writable( dirname( $new_filename ) ) ) {
			return FALSE;
		}

		$output = '';

		foreach ( $handles as $handle ) {

			$content = $this->get_file_content( $handle );

			if ( $content === FALSE ) {

				return FALSE;
			}

			$output .= $this->minify( $content ) . "\n\n";
		}


		return $this->write_file( $new_filename, $output );
	}

	//	BF_Minify


	public $handle = array();

	/**
	 * Initialize minify hooks
	 *
	 * @since 2.9.0
	 */
	public function init() {

		if ( is_admin() ) {

			add_action( 'admin_footer', 'BF_Scripts::print_main_script_tag', 1 );
		} else {

			add_action( 'wp_footer', 'BF_Scripts::print_main_script_tag' );
		}
	}


	/**
	 * Print scripts
	 */
	public function print_output() {

		$this->do_items( FALSE, 0 );

		$this->_print_scripts( $this->handle );

	}


	/**
	 * Processes a script dependency.
	 *
	 * @since  2.6.0
	 * @since  2.8.0 Added the `$group` parameter.
	 * @access public
	 *
	 * @see    WP_Dependencies::do_item()
	 *
	 * @param string   $handle The script's registered handle.
	 * @param bool|int $group  Optional. Group level: (int) level, (false) no groups. Default false.
	 *
	 * @return bool True on success, false on failure.
	 */
	public function do_item( $handle, $group = FALSE ) {

		$this->handle[] = $handle;
	}

	/**
	 * Print scripts
	 *
	 * @param array $handles
	 *
	 * @since 2.9.0
	 */
	public function _print_scripts( $handles ) {

		if ( ! $handles ) {
			return;
		}

		if ( count( $handles ) === 1 ) {

			$this->print_inline_script( $handles[0], 'before', FALSE );

			$this->print_extra_script( $handles[0] );

			self::print_script( $this->registered[ $handles[0] ]->src );

			$this->print_inline_script( $handles[0], 'after', FALSE );

			return;
		}

		$files_url = array();
		$after     = '';

		foreach ( $handles as $handle ) {

			echo $this->print_inline_script( $handle, 'before', FALSE );

			$this->print_extra_script( $handle );

			$files_url[] = $this->registered[ $handle ]->src;

			$after .= $this->print_inline_script( $handle, 'after', FALSE );
		}

		$file_dir  = trailingslashit( WP_CONTENT_DIR . '/' . BF_Minify::$cache_dir );
		$file_name = $this->file_hash( $handles ) . '.js';

		if ( is_readable( $file_dir . $file_name ) || $this->do_minify( $handles, $file_dir . $file_name ) ) {
			self::print_script( content_url( BF_Minify::$cache_dir . '/' . $file_name ) );
		} else {

			foreach ( $handles as $handle ) {
				self::print_script( $this->registered[ $handle ]->src );
			}
		}

		echo $after;
	}


	/**
	 * Print <script> tag
	 *
	 * @param string $url
	 *
	 * @since 2.9.0
	 */
	public static function print_script( $url ) {

		$atts = array(
			'type'  => 'text/javascript',
			'src'   => $url,
			'async' => 'async',
		);

		echo '<script ';

		foreach ( apply_filters( 'bs-booster/minify/script/atts', $atts ) as $key => $val ) {
			printf( '%s="%s"', esc_attr( $key ), esc_attr( $val ) );
		}

		echo '></script>';
	}

	public static function print_main_script_tag() {

		bf_scripts()->print_output();
	}


	/**
	 * Callback to compress files content
	 *
	 * @param string $content
	 *
	 * @since 2.9.0
	 * @return string|bool
	 */
	public function minify( $content ) {

		return $content;
	}
}
