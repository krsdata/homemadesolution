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


/**
 * plugin installer/ updater handler
 *
 * Class BF_Product_Plugin_Factory
 */
class BF_Product_Plugin_Installer extends BF_Product_Pages_Base {

	/**
	 *  WP_Upgrade class instance
	 *
	 * @var Language_Pack_Upgrader|Plugin_Upgrader
	 */
	private $_handler;

	/**
	 * store data while installing plugin. at last save data into an option
	 *
	 * @var array
	 */
	private $process_data;

	/**
	 * installing plugin data, option key
	 *
	 * @var string
	 */
	private $data_option_name;

	/**
	 * store list of plugin file array {
	 *  plugin_directory => plugin_directory/plugin_file.php
	 * }
	 *
	 * @var array
	 */
	static $plugins_file;

	/**
	 * store list of plugins need update array {
	 *  plugin_directory => plugin_directory/plugin_file.php
	 * }
	 * @var array
	 */
	static $plugins_update;

	/**
	 * temporary data option name pattern
	 *
	 * %s replace with plugin name
	 *
	 * @var string
	 */
	private $option_name_pattern = 'bs_plugin_%s';

	/**
	 * BF_Product_Plugin_Factory constructor.
	 *
	 */
	public function __construct() {

		if ( ! class_exists( 'Plugin_Upgrader' ) ) {

			require_once ABSPATH . '/wp-admin/includes/class-wp-upgrader.php';
		}

		$this->_handler = new Plugin_Upgrader( $this->get_skin() );

		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
		}

		WP_Filesystem( TRUE, WP_CONTENT_DIR, FALSE );
	}


	/**
	 * get list of plugins and cache
	 *
	 * @see $plugins_file
	 *
	 * @return array array of plugins on success.
	 */
	public static function get_plugins_basename() {

		if ( ! is_array( self::$plugins_file ) ) {

			self::$plugins_file = array();

			if ( function_exists( 'get_plugins' ) ) { // fix for when there is no any active plugin!
				foreach ( get_plugins() as $file => $info ) {
					self::$plugins_file[ dirname( $file ) ] = $file;
				}
			}
		}

		return self::$plugins_file;
	}

	public function get_product_plugins() {

	}


	/**
	 * check a plugin in already installed
	 *
	 * @param string $plugin_directory plugin directory name
	 *
	 * @return bool return true if plugin installed
	 */

	public static function is_plugin_installed( $plugin_directory ) {

		self::get_plugins_basename();

		return ! empty( self::$plugins_file[ $plugin_directory ] );
	}

	/**
	 * check a plugin in already activated
	 *
	 * @param string $plugin_directory plugin directory name
	 *
	 * @return bool return true if plugin was activated.
	 */
	public static function is_plugin_active( $plugin_directory ) {

		self::get_plugins_basename();

		return isset( self::$plugins_file[ $plugin_directory ] ) &&
		       is_plugin_active( self::$plugins_file[ $plugin_directory ] );
	}


	/**
	 * get list of plugins need update and cache
	 *
	 * @see \BF_Product_Plugin_Manager::update_plugins
	 */
	private static function get_updates() {

		if ( ! is_array( self::$plugins_update ) ) {

			self::$plugins_update = array();
			$updates              = get_option( 'bs-product-plugins-status' );

			if ( is_object( $updates ) ) {

				// append remote plugins data
				if ( ! empty( $updates->remote_plugins ) && is_array( $updates->remote_plugins ) ) {

					foreach ( $updates->remote_plugins as $file => $info ) {

						$slug = empty( $info['slug'] ) ? dirname( $file ) : $info['slug'];

						self::$plugins_update[ $slug ] = $file;
					}
				}

				//append local plugins data
				if ( ! empty( $updates->local_plugins ) && is_array( $updates->local_plugins ) ) {

					foreach ( $updates->local_plugins as $file => $info ) {

						$slug = empty( $info['slug'] ) ? dirname( $file ) : $info['slug'];

						self::$plugins_update[ $slug ] = $file;
					}
				}
			}
		}
	}


	/**
	 * TODO: check update for local plugins
	 *
	 * check is plugin in latest version
	 *
	 * @param string $plugin_directory plugin directory name
	 *
	 * @return bool false if update available
	 */
	public static function is_plugin_latest_version( $plugin_directory ) {

		self::get_updates();

		return empty( self::$plugins_update[ $plugin_directory ] );
	}


	/**
	 * Active a plugin
	 *
	 * @param string $plugin_directory plugin folder name
	 *
	 * @return bool true on success.
	 */
	public function active_plugin( $plugin_directory ) {

		if ( ! function_exists( 'activate_plugin' ) ) {

			require_once ABSPATH . '/wp-admin/includes/plugin.php';
		}

		$plugin_directory = trim( $plugin_directory, '/' . DIRECTORY_SEPARATOR );

		if ( $plugin_data = get_plugins( '/' . $plugin_directory ) ) {

			$plugin_file = trailingslashit( $plugin_directory ) . key( $plugin_data );
			$activated   = activate_plugin( $plugin_file, FALSE, FALSE );
			$this->throw_if_is_wp_error( $activated, $plugin_file );

			return TRUE;
		}

		return FALSE;
	}


	/**
	 * deactivate a plugin
	 *
	 * @param string $plugin_directory plugin directory name
	 *
	 * @return bool true on success.
	 */
	public function deactivate_plugin( $plugin_directory ) {

		if ( ! function_exists( 'activate_plugin' ) ) {

			require_once ABSPATH . '/wp-admin/includes/plugin.php';
		}

		$plugin_directory = trim( $plugin_directory, '/' . DIRECTORY_SEPARATOR );

		if ( $plugin_data = get_plugins( '/' . $plugin_directory ) ) {

			deactivate_plugins( trailingslashit( $plugin_directory ) . key( $plugin_data ), FALSE, FALSE );

			/**
			 * Deactivate plugin in multisite if plugin was network activated
			 */
			if ( is_multisite() ) {
				deactivate_plugins( trailingslashit( $plugin_directory ) . key( $plugin_data ), FALSE, TRUE );
			}

			return TRUE;
		}

		return FALSE;
	}

	/**
	 * get custom skin class
	 *
	 * @return BF_Plugin_Upgrader_Skin
	 */

	private function get_skin() {
		if ( ! class_exists( 'BF_Plugin_Upgrader_Skin' ) ) {

			require_once BF_Product_Pages::get_path( 'install-plugin/class-bf-plugin-upgrader-skin.php' );
		}

		$skin = new BF_Plugin_Upgrader_Skin();

		return $skin;
	}


	/**
	 * update languages pack if needed.
	 *
	 * @return bool always return true
	 */
	protected function update_language_pack() {


		//		if ( ! class_exists( 'Language_Pack_Upgrader' ) ) {
		//
		//			require_once ABSPATH . '/wp-admin/includes/class-wp-upgrader.php';
		//		}
		//
		//		Language_Pack_Upgrader::async_upgrade();

		return TRUE;
	}


	/**
	 * Get full path of download directory
	 *
	 * @return string full path to download folder
	 * @throws BF_Exception
	 */
	protected function get_download_target_dir() {
		$upload_dir = _wp_upload_dir();
		$upload_dir = $upload_dir['basedir'] . '/plugins/';
		wp_mkdir_p( $upload_dir );

		if ( ! is_dir( $upload_dir ) ) {
			throw new BF_Exception( sprintf( 'Unable to create directory %s', $upload_dir ), 'error-create-directory' );
		}

		return $upload_dir;
	}

	/**
	 * Download file form remote source
	 *
	 * @param string $url remote url to download plugin file
	 * @param string $plugin_slug
	 *
	 * @return string|WP_Error downloaded file path on success or Exception|WP_Error on failure.
	 * @throws    BF_Exception
	 */
	public function download_package( $url, $plugin_slug ) {
		$target_dir = $this->get_download_target_dir();
		$new_path   = $target_dir . $plugin_slug . '.zip';

		//reject_unsafe_urls
		add_filter( 'http_request_args', 'bf_remove_reject_unsafe_urls', 99 );
		$path = $this->_handler->download_package( $url );
		remove_filter( 'http_request_args', 'bf_remove_reject_unsafe_urls', 99 );

		$this->throw_if_is_wp_error( $path, $url, $plugin_slug );

		if ( @ rename( $path, $new_path ) ) {
			return $new_path;
		}

		throw new BF_Exception( sprintf( 'Unable to move plugin package to %s', $new_path ), 'error-copy-plugin' );
	}

	/**
	 * Unpack a compressed package file.
	 *
	 * @param string $path           compressed file path
	 * @param bool   $delete_package Optional. Whether to delete the package file after attempting to unpack it.
	 *
	 * @return bool|string The path to the unpacked contents on success or false on failure.
	 * @throws BF_Exception
	 */
	protected function unpack_package( $path, $delete_package = FALSE ) {

		$working_dir = $this->_handler->unpack_package( $path, $delete_package );

		$this->throw_if_is_wp_error( $working_dir, $working_dir, $path );

		return $working_dir;
	}


	/**
	 * install a plugin
	 *
	 * @param string $package The full local path or URI of the package.
	 *
	 * @return bool|string  plugin destination path on success or false on failure.
	 * @throws BF_Exception
	 */
	protected function install( $package ) {

		$installed = $this->_handler->install_package( array(
			'source'                      => $package,
			'destination'                 => WP_PLUGIN_DIR,
			'clear_destination'           => FALSE,
			'abort_if_destination_exists' => TRUE,
			'clear_working'               => TRUE,
			'hook_extra'                  => array(
				'type'   => 'plugin',
				'action' => 'install'
			)
		) );

		$this->throw_if_is_wp_error( $installed, $package, $installed );

		return isset( $installed['destination'] ) ? $installed['destination'] : FALSE;
	}


	/**
	 * update a plugin
	 *
	 * @param string $package         The full local path or URI of the package.
	 * @param string $plugin_basename plugin basename path @see plugin_basename()
	 *
	 * @return bool|string  plugin destination path on success or false on failure.
	 */
	protected function update( $package, $plugin_basename = '' ) {

		$updated = $this->_handler->install_package( array(
			'source'                      => $package,
			'destination'                 => WP_PLUGIN_DIR,
			'clear_destination'           => TRUE,
			'abort_if_destination_exists' => TRUE,
			'clear_working'               => TRUE,
			'hook_extra'                  => array_filter(
				array(
					'plugin' => $plugin_basename
				)
			)
		) );

		$this->throw_if_is_wp_error( $updated, $package, $updated );

		return isset( $updated['destination'] ) ? $updated['destination'] : FALSE;
	}


	/**
	 *
	 * @see plugins_api()
	 *
	 * @param  string      $action
	 * @param array|object $args
	 *
	 * @return mixed|void
	 */
	protected function plugins_api( $action, $args = array() ) {

		if ( is_array( $args ) ) {
			$args = (object) $args;
		}

		if ( ! isset( $args->per_page ) ) {
			$args->per_page = 24;
		}

		if ( ! isset( $args->locale ) ) {
			$args->locale = get_locale();
		}

		/**
		 * Filter the WordPress.org Plugin Install API arguments.
		 *
		 * Important: An object MUST be returned to this filter.
		 *
		 * @since 2.7.0
		 *
		 * @param object $args   Plugin API arguments.
		 * @param string $action The type of information being requested from the Plugin Install API.
		 */
		$args = apply_filters( 'plugins_api_args', $args, $action );

		/**
		 * Filter the response for the current WordPress.org Plugin Install API request.
		 *
		 * Passing a non-false value will effectively short-circuit the WordPress.org API request.
		 *
		 * If `$action` is 'query_plugins' or 'plugin_information', an object MUST be passed.
		 * If `$action` is 'hot_tags` or 'hot_categories', an array should be passed.
		 *
		 * @since 2.7.0
		 *
		 * @param false|object|array $result The result object or array. Default false.
		 * @param string             $action The type of information being requested from the Plugin Install API.
		 * @param object             $args   Plugin API arguments.
		 */
		$res = apply_filters( 'plugins_api', FALSE, $action, $args );

		if ( FALSE === $res ) {
			$url = $http_url = 'http://api.wordpress.org/plugins/info/1.0/';
			if ( $ssl = wp_http_supports( array( 'ssl' ) ) ) {
				$url = set_url_scheme( $url, 'https' );
			}

			$http_args = array(
				'timeout' => 15,
				'body'    => array(
					'action'  => $action,
					'request' => serialize( $args )
				)
			);
			$request   = wp_remote_post( $url, $http_args );

			if ( $ssl && is_wp_error( $request ) ) {
				$request = wp_remote_post( $http_url, $http_args );
			}

			if ( is_wp_error( $request ) ) {
				$res = new WP_Error( 'plugins_api_failed', wp_kses( __( 'An unexpected error occurred. Something may be wrong with WordPress.org or this server&#8217;s configuration. If you continue to have problems, please try the <a href="https://wordpress.org/support/">support forums</a>.', 'better-studio' ), bf_trans_allowed_html() ), $request->get_error_message() );
			} else {
				$res = maybe_unserialize( wp_remote_retrieve_body( $request ) );
				if ( ! is_object( $res ) && ! is_array( $res ) ) {
					$res = new WP_Error( 'plugins_api_failed', wp_kses( __( 'An unexpected error occurred. Something may be wrong with WordPress.org or this server&#8217;s configuration. If you continue to have problems, please try the <a href="https://wordpress.org/support/">support forums</a>.', 'better-studio' ), bf_trans_allowed_html() ), wp_remote_retrieve_body( $request ) );
				}
			}
		} elseif ( ! is_wp_error( $res ) ) {
			$res->external = TRUE;
		}

		/**
		 * Filter the Plugin Install API response results.
		 *
		 * @since 2.7.0
		 *
		 * @param object|WP_Error $res    Response object or WP_Error.
		 * @param string          $action The type of information being requested from the Plugin Install API.
		 * @param object          $args   Plugin API arguments.
		 */
		return apply_filters( 'plugins_api_result', $res, $action, $args );
	}


	/**
	 * @param $plugin_directory plugin directory name
	 *
	 * @return bool|string|WP_Error plugin download URI on success or false|WP_Error on failure.
	 */
	protected function get_global_plugin_download_link( $plugin_directory ) {

		$api = $this->plugins_api( 'plugin_information', array(
			'slug'   => $plugin_directory,
			'fields' => array(
				'short_description' => FALSE,
				'sections'          => FALSE,
				'requires'          => FALSE,
				'rating'            => FALSE,
				'ratings'           => FALSE,
				'downloaded'        => FALSE,
				'last_updated'      => FALSE,
				'added'             => FALSE,
				'tags'              => FALSE,
				'compatibility'     => FALSE,
				'homepage'          => FALSE,
				'donate_link'       => FALSE,
			),
		) );

		if ( is_wp_error( $api ) ) {
			return $api;
		}
		if ( isset( $api->download_link ) ) {
			return $api->download_link;
		}

		return FALSE;
	}


	/**
	 * Fetch bundled plugin download link
	 *
	 * @param string $plugin_slug
	 * @param string $action
	 *
	 * @return bool|string|WP_Error url string on success bool|WP_Error otherwise
	 */
	public function get_bundled_plugin_download_link( $plugin_slug, $action = '' ) {
		$plugin_data = $this->api_request( 'download-plugin', compact( 'plugin_slug', 'action' ) );

		if ( is_wp_error( $plugin_data ) ) {
			return $plugin_data;
		}

		if ( ! empty( $plugin_data->success ) && ! empty( $plugin_data->download_link ) ) {
			return $plugin_data->download_link;
		}

		return FALSE;
	}

	/**
	 * Fetch download link for any type of plugin [bundled or global]
	 *
	 * @param string $plugin_data
	 *
	 * @return bool|string|WP_Error download url string on success
	 * @throws BF_Exception
	 */
	protected function get_plugin_download_link( $plugin_data ) {

		if ( ! isset( $plugin_data['type'] ) || $plugin_data['type'] != 'bundled' ) {

			$download_link = $this->get_global_plugin_download_link( $plugin_data['slug'] );
			$this->throw_if_is_wp_error( $download_link, $plugin_data['slug'], $download_link );

			return $download_link;
		}

		$action        = isset( $plugin_data['action'] ) ? $plugin_data['action'] : ''; // install or update
		$download_link = $this->get_bundled_plugin_download_link( $plugin_data['slug'], $action );
		$this->throw_if_is_wp_error( $download_link, $download_link, $plugin_data );

		return $download_link;
	}

	/**
	 * @param array  $plugin_data plugin data array{
	 *
	 * @type string  $local_path  path to local plugin package file if exists
	 * @type string  $action      plugin action. install | update
	 * @type string  $type        plugin type. bundled | global
	 * @type string  $thumbnail   plugin thumbnail image url
	 * @type bool    $required    is plugin required?
	 * @type string  $description plugin description
	 * @type string  $slug        plugin directory
	 * @type string  $version     plugin version
	 * @type string  $name        plugin name
	 * }
	 *
	 * @see bs-product-pages/install-plugin/config hook
	 *
	 * @param string $plugin_action
	 * @param int    $step_index  step number start from zero
	 * @param string $plugin_slug
	 *
	 * @return bool true on success or false on failure.
	 */
	public function install_start( $plugin_data, $plugin_action, $step_index, $plugin_slug ) {

		//check null to compatible with recursive calling
		if ( is_null( $this->process_data ) ) {
			$this->data_option_name          = sprintf( $this->option_name_pattern, $plugin_slug );
			$this->process_data              = get_option( $this->data_option_name, array() );
			$this->process_data['slug']      = $plugin_slug;
			$this->process_data['is_remote'] = empty( $plugin_data['local_path'] );
		}

		try {

			$result = FALSE;
			/**
			 * $plugin_action values generated by @see BF_Product_Plugin_Manager::calculate_process_steps
			 */
			$plugin_action = strtolower( str_replace( '-', '_', $plugin_action ) );

			switch ( $plugin_action ) {

				case 'download_package':

					if ( $plugin_zip_uri = $this->get_plugin_download_link( $plugin_data ) ) {

						if ( $file_path = $this->download_package( $plugin_zip_uri, $plugin_slug ) ) {

							$this->process_data['downloaded_package_path'] = $file_path;

							$result = TRUE;
						}

					}


					break;

				case 'unzip_package':

					$package_path = '';

					if ( $this->process_data['is_remote'] ) {

						if ( ! empty( $this->process_data['downloaded_package_path'] ) ) {

							$package_path = $this->process_data['downloaded_package_path'];
						}

					} else {

						$package_path = $plugin_data['local_path'];
					}

					//package_path saved in previous step
					if ( $package_path && file_exists( $package_path ) ) {

						if ( $path = $this->unpack_package( $package_path ) ) {

							$this->process_data['unpacked_path'] = $path;
							$result                              = TRUE;
						}
					}

					break;

				case 'install_package':

					if ( ! empty( $this->process_data['unpacked_path'] ) && file_exists( $this->process_data['unpacked_path'] ) ) {

						if ( $destination = $this->install( $this->process_data['unpacked_path'] ) ) {

							$this->active_plugin( basename( $destination ) );

							$result = TRUE;
						}
					}
					break;

				case 'update_package':

					if ( ! empty( $this->process_data['unpacked_path'] ) && file_exists( $this->process_data['unpacked_path'] ) ) {

						$plugin_basename = FALSE;

						if ( ! empty( $plugin_data['slug'] ) ) {

							$p_dir = &$plugin_data['slug'];

							if ( isset( self::$plugins_file[ $p_dir ] ) ) {
								$plugin_basename = self::$plugins_file[ $p_dir ];
							}
						}

						if ( $this->update( $this->process_data['unpacked_path'], $plugin_basename ) ) {

							$result = TRUE;
						}
					}
					break;

				case 'update_translation':

					// todo remove output in this
					$this->update_language_pack();

					$result = TRUE;

					break;

				case 'install_unzip_package':

					//quick mode, unzip & install at once request

					if ( $this->install_start( $plugin_data, 'unzip_package', $step_index, $plugin_slug ) ) {

						$result = $this->install_start( $plugin_data, 'install_package', $step_index, $plugin_slug );
					}

					break;

				case 'update_unzip_package':

					//quick mode, unzip & update at once request

					if ( $this->install_start( $plugin_data, 'unzip_package', $step_index, $plugin_slug ) ) {

						$result = $this->install_start( $plugin_data, 'update_package', $step_index, $plugin_slug );
					}

					break;

				case 'download_unzip_package':

					//quick mode, download & install at once request

					if ( $this->install_start( $plugin_data, 'download_package', $step_index, $plugin_slug ) ) {
						$result = $this->install_start( $plugin_data, 'unzip_package', $step_index, $plugin_slug );
					}

					break;

				case 'install_translation_package':

					//quick mode, install package & update translation at once request

					$result = $this->install_start( $plugin_data, 'install_package', $step_index, $plugin_slug );
					$this->install_start( $plugin_data, 'update_translation', $step_index, $plugin_slug );

					break;

				case 'update_translation_package':

					//quick mode, update package & update translation at once request

					$result = $this->install_start( $plugin_data, 'update_package', $step_index, $plugin_slug );
					$this->install_start( $plugin_data, 'update_translation', $step_index, $plugin_slug );

					break;

				case 'empty_request':
					// nothing happen!
					$result = TRUE;
					break;
			}
		} catch( BF_Exception $e ) {

			return new WP_Error( $e->getCode(), $e->getMessage() );
		}

		return $result;
	}


	/**
	 * save installation information in  database
	 * this function fire after @see install_start()
	 *
	 */
	public function install_stop() {

		update_option( $this->data_option_name, $this->process_data, 'no' );
	}

	public function install_finished() {

		//delete temporary option data
		delete_option( $this->data_option_name );

		//delete downloaded package file
		if ( ! empty( $this->process_data['downloaded_package_path'] ) ) {

			@unlink( $this->process_data['downloaded_package_path'] );
		}

		/**
		 * update update cache status for to prevent display update message after updated plugin!
		 *
		 * @see \BF_Product_Plugin_Manager::update_plugins
		 */
		if ( isset( $this->process_data['slug'] ) ) {

			$prev_status = get_option( 'bs-product-plugins-status' );
			if ( is_object( $prev_status ) ) {
				$slug = &$this->process_data['slug'];

				if ( $this->process_data['is_remote'] ) {
					$plugins_list = &$prev_status->remote_plugins;

				} else {
					$plugins_list = &$prev_status->local_plugins;
				}

				$need_update = FALSE;
				if ( $plugins_list && is_array( $plugins_list ) ) {

					foreach ( $plugins_list as $plugin_basename => $new_plugin_data ) {

						//remove plugin from update list
						if ( $slug === $new_plugin_data['slug'] ) {

							//check version again to make sure plugin was updated successfully
							if ( isset( $new_plugin_data['new_version'] ) ) {

								$plugin_file = trailingslashit( WP_PLUGIN_DIR ) . $plugin_basename;
								$plugin_data = get_plugin_data( $plugin_file );

								if ( isset( $plugin_data['Version'] ) &&
								     $plugin_data['Version'] === $new_plugin_data['new_version']
								) {
									unset( $plugins_list[ $plugin_basename ] );
									$need_update = TRUE;
								}
							}

							break;
						}
					}
				}

				if ( $need_update ) {
					update_option( 'bs-product-plugins-status', $prev_status, 'no' );
				}
			}
		}

		do_action( 'better-framework/product-pages/install-plugin/install-finished', $this->process_data );
	}

	/**
	 * delete temporary data generated while installing plugin
	 *
	 * @param string $plugin_slug
	 *
	 * @return boll always true
	 */
	public function rollback( $plugin_slug ) {

		global $wp_filesystem;

		$data_option_name = sprintf( $this->option_name_pattern, $plugin_slug );
		$process_data     = get_option( $data_option_name, array() );


		//delete downloaded package file
		if ( ! empty( $process_data['downloaded_package_path'] ) ) {

			@unlink( $process_data['downloaded_package_path'] );
		}

		//delete extracted files & folders
		if ( ! empty( $process_data['unpacked_path'] ) ) {

			/**
			 * @var WP_Filesystem_Direct $wp_filesystem
			 */
			$wp_filesystem->rmdir( $process_data['unpacked_path'], TRUE );
		}

		//delete temporary option data
		delete_option( $data_option_name );

		return TRUE;
	}

	function __destruct() {
		if ( ! headers_sent() ) {
			// prevent redirect page
			if ( function_exists( 'header_remove' ) ) {
				header_remove( 'Location' );
			}
			status_header( 200 );
		}
	}
}