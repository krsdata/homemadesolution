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


if ( ! class_exists( 'BF_Product_Multi_Step_Item' ) ) {
	require_once BF_PRODUCT_PAGES_PATH . 'init.php';
}

/**
 * Class BS_Product_Plugins
 */
class BF_Product_Plugin_Manager extends BF_Product_Multi_Step_Item {

	public $id = 'install-plugin';

	public $check_update_duration;

	/**
	 * BF_Product_Plugin_Manager constructor.
	 */
	public function __construct() {
		if ( ! class_exists( 'BS_Product_Plugin_Factor' ) ) {
			require_once BF_Product_Pages::get_path( 'install-plugin/class-bf-product-plugin-installer.php' );
		}

		$this->check_update_duration = MINUTE_IN_SECONDS * 15; //check plugin update every 15 minutes;
	}


	protected function before_render() {

		$this->update_plugins();
	}

	/**
	 * Check plugins for update
	 *
	 * @uses $wp_version Used to notify the WordPress version.
	 *
	 * @param bool $force Whether to force check plugins for update. Defaults to false.
	 *
	 * @return stdClass
	 */
	public function update_plugins( $force = FALSE ) {
		global $wp_version, $pagenow;
		include ABSPATH . WPINC . '/version.php';

		// Don't check update while updating another item!
		if (
			( isset( $_REQUEST['action'] ) && 'do-theme-upgrade' === $_REQUEST['action'] )
			||
			(
				isset( $_REQUEST['action'] ) &&
				in_array( $pagenow, array( 'admin-ajax.php', 'update.php' ) ) &&
				in_array( $_REQUEST['action'], array(
					'upgrade-theme',
					'update-selected-themes',
					'update-theme',
				) )
			)
		) {
			return FALSE;
		}

		$plugins_basename = BF_Product_Plugin_Installer::get_plugins_basename();
		$all_plugins_data = get_plugins();
		$remote_plugins   = array();
		$active_plugins   = array();

		$update_status                 = new stdClass();
		$update_status->last_checked   = time();
		$update_status->remote_plugins = array(); // wordpress repo plugins need update
		$update_status->translations   = array();
		$update_status->no_update      = array();
		$update_status->local_plugins  = array(); // list of local plugins need update

		if ( ! $force ) {
			$prev_status = get_option( 'bs-product-plugins-status' );

			if ( ! is_object( $prev_status ) ) {
				$prev_status               = new stdClass();
				$prev_status->last_checked = time();
				$skip_update               = FALSE;
			} else {
				$skip_update = $this->check_update_duration > ( time() - $prev_status->last_checked );
			}

			if ( $skip_update ) {

				return $prev_status;
			}
		}


		$bundled_plugins      = array();
		$bundled_plugins_data = array();
		if ( $plugins_data = $this->get_plugins_data() ) {
			foreach ( $plugins_data as $ID => $plugin_data ) {
				if ( empty( $plugin_data['slug'] ) ) {
					continue;
				}

				/**
				 * skip process if plugin was not installed!
				 */
				$slug = &$plugin_data['slug'];
				if ( ! isset( $plugins_basename[ $slug ] ) ) {
					continue;
				}
				$plugin_basename = &$plugins_basename[ $slug ];
				/**
				 * get plugin basename path EX: pluginDirectory/pluginFile.php
				 * @see plugin_basename
				 * @var string $plugin_basename
				 */
				if ( ! isset( $all_plugins_data[ $plugin_basename ] ) ) {
					continue;
				}
				// End plugin installation check block

				$active_plugins[] = $plugin_basename;
				$data             = &$all_plugins_data[ $plugin_basename ];
				$is_local_plugin  = ! empty( $plugin_data['local_path'] );

				if ( $is_local_plugin ) {
					//compare local plugin version with installed plugin
					if (
						isset( $data['Version'] ) && isset( $plugin_data['version'] )
						&& version_compare( $plugin_data['version'], $data['Version'], '>' )
					) {

						$update_status->local_plugins[ $plugin_basename ] = array(
							'id'          => $ID,
							'slug'        => $slug,
							'new_version' => $plugin_data['version']
						);
					}

				} else if ( isset( $plugin_data['type'] ) && $plugin_data['type'] === 'bundled' ) {
					// bundled plugin

					$bundled_plugins[ $slug ]      = $data['Version'];
					$bundled_plugins_data[ $slug ] = compact( 'plugin_basename', 'ID' );
				} else {
					//wordpress repository plugin
					$remote_plugins[ $plugin_basename ] = $data;
				}
			}
		}

		/**
		 * check wp repo plugins update
		 */

		// Three seconds, plus one extra second for every 10 plugins
		$timeout      = 3 + (int) ( count( $plugins_basename ) / 10 );
		$to_send      = array(
			'plugins' => $remote_plugins,
			'active'  => $active_plugins
		);
		$translations = wp_get_installed_translations( 'plugins' );
		$locales      = array( get_locale() );
		/**
		 * Filter the locales requested for plugin translations.
		 * @see wp_update_plugins
		 *
		 * @param array $locales Plugin locale. Default is current locale of the site.
		 */
		$locales = apply_filters( 'plugins_update_check_locales', $locales );


		$options = array(
			'timeout'    => $timeout,
			'body'       => array(
				'plugins'      => wp_json_encode( $to_send ),
				'translations' => wp_json_encode( $translations ),
				'locale'       => wp_json_encode( $locales ),
				'all'          => wp_json_encode( TRUE ),
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . esc_url( home_url( '/' ) )
		);
		$api_url = 'http://api.wordpress.org/plugins/update-check/1.1/';

		$raw_response = wp_remote_post( $api_url, $options );
		if ( ! is_wp_error( $raw_response ) && 200 == wp_remote_retrieve_response_code( $raw_response ) ) {

			$response = json_decode( wp_remote_retrieve_body( $raw_response ), TRUE );
			if ( is_array( $response ) ) {
				$update_status->remote_plugins = $response['plugins']; //list of plugins need update
				$update_status->translations   = $response['translations'];
				$update_status->no_update      = $response['no_update'];
			}
		}

		/**
		 * check bundled plugins update
		 */

		if ( $bundled_plugins ) {
			$check_update = $this->api_request( 'check-plugin-update', array( 'plugins_list' => $bundled_plugins ) );
			if ( ! is_wp_error( $check_update ) && ! empty( $check_update->success ) && ! empty( $check_update->plugins ) ) {
				foreach ( $check_update->plugins as $slug => $version ) {
					if ( $version !== 'latest' ) {
						$plugin_basename                                   = $bundled_plugins_data[ $slug ]['plugin_basename'];
						$update_status->remote_plugins[ $plugin_basename ] = array(
							'id'          => $bundled_plugins_data[ $slug ]['ID'],
							'slug'        => $slug,
							'new_version' => $version
						);
					}
				}
			}
		}

		update_option( 'bs-product-plugins-status', $update_status, 'no' );

		return $update_status;
	}

	/**
	 * get list of plugins
	 *
	 * @return array
	 * @see \BF_Product_Plugin_Factory::install_start $plugin_data param
	 */
	public function get_plugins_data() {

		return bf_get_plugins_config();
	}

	/**
	 * HTML output to display admin user
	 *
	 * @param $options
	 */
	public function render_content( $options ) {
		if ( $plugins_list = $this->get_plugins_data() ) :
			$product_active = bf_is_product_registered();
			BF_Product_Pages::Run();
			$product_type = BF_Product_Pages::get_product_info( 'product_type', 'product' );
			?>

			<div class="bs-product-pages-install-plugin">

				<?php foreach ( $plugins_list as $plugin_ID => $plugin_data ) :

					$classes = array( 'bs-pages-plugin-item' );

					$plugin_installed = BF_Product_Plugin_Installer::is_plugin_installed( $plugin_ID );
					$plugin_activated = $plugin_installed && BF_Product_Plugin_Installer::is_plugin_active( $plugin_ID );
					$update_available = $plugin_activated && ! BF_Product_Plugin_Installer::is_plugin_latest_version( $plugin_ID );

					if ( $update_available ) {
						$classes[] = 'plugin-update-available';
					}

					if ( $plugin_installed ) {
						$classes[] = 'plugin-installed';
					} else {
						$classes[] = 'plugin-not-installed';
					}

					if ( $plugin_activated ) {
						$classes[] = 'plugin-active';
					} else if ( $plugin_installed ) {
						$classes[] = 'plugin-inactive';
					}

					?>

					<div class="<?php echo implode( ' ', array_map( 'sanitize_html_class', $classes ) ) ?>">
						<div class="bs-pages-overlay "></div>

						<?php if ( ! empty( $plugin_data['required'] ) ) : ?>
							<div class="bs-pages-ribbon-wrapper bs-plugin-required">
								<div class="bs-pages-ribbon">
								</div>
								<div class="bs-pages-ribbon-label">
									<i class="fa fa-bolt"></i>
									<div class="txt"><?php esc_html_e( 'Required', 'better-studio' ); ?></div>
								</div>
							</div>

						<?php endif;
						if ( $update_available ): ?>

							<div class="bs-pages-ribbon-wrapper bs-plugin-update">
								<div class="bs-pages-ribbon">
								</div>
								<div class="bs-pages-ribbon-label">
									<i class="fa fa-refresh"></i>
								</div>
							</div>

						<?php endif ?>

						<figure>
							<img src="<?php echo esc_url( $plugin_data['thumbnail'] ) ?>"
							     alt="<?php echo esc_attr( $plugin_data['name'] ); ?>">
						</figure>

						<footer class="bs-pages-plugin-item-footer">

							<div class="bs-pages-progressbar">
								<div class="bs-pages-progress">
								</div>
							</div>
							<div class="bs-pages-plugin-item-footer-wrapper">
								<span class="bs-pages-plugin-name">
									<?php echo wp_kses( $plugin_data['name'], bf_trans_allowed_html() ); ?>
								</span>
								<div class="bs-pages-plugin-description">
									<?php echo wp_kses( $plugin_data['description'], bf_trans_allowed_html() ); ?>
								</div>
								<?php if ( $product_active ): ?>
									<div class="bs-pages-buttons"
									     data-plugin-slug="<?php echo esc_attr( $plugin_ID ); ?>">
								<span class="install-plugin">
									<a href="#"
									   class="bf-btn-primary bf-btn-primary"><?php esc_html_e( 'Install & Activate', 'better-studio' ) ?></a>
								</span>
								<span class="update-plugin">
									<a href="#"
									   class="bf-btn-primary bf-btn-primary"><?php esc_html_e( 'Update plugin', 'better-studio' ) ?></a>
								</span>
								<span class="active-plugin">
									<a href="#"
									   class="bbf-btn-primary bf-btn-primary"><?php esc_html_e( 'Activate', 'better-studio' ) ?></a>
								</span>
								<span class="deactivate-plugin">
									<a href="#"
									   class="bf-btn-secondary bs-pages-secondary-btn"><?php esc_html_e( 'Deactivate', 'better-studio' ) ?></a>
								</span>
									</div>
									<div class="clearfix"></div>
									<div class="messages">
										<div class="installing">
											<button type="button" disabled>
												<?php echo bf_get_icon_tag( 'fa-refresh', 'fa-spin' ); // escaped before in function ?>
												<?php esc_html_e( 'Installing...', 'better-studio' ); ?>
											</button>
										</div>
										<div class="uninstalling">
											<button type="button" disabled>
												<?php echo bf_get_icon_tag( 'fa-refresh', 'fa-spin' ); // escaped before in function ?>
												<?php esc_html_e( 'Uninstalling...', 'better-studio' ); ?>
											</button>
										</div>
										<div class="activating">
											<button type="button" disabled>
												<?php echo bf_get_icon_tag( 'fa-refresh', 'fa-spin' ); // escaped before in function ?>
												<?php esc_html_e( 'Activating...', 'better-studio' ) ?>
											</button>
										</div>
										<div class="rollback">
											<button type="button" disabled>
												<?php echo bf_get_icon_tag( 'fa-refresh', 'fa-spin' ); // escaped before in function ?>
												<?php esc_html_e( 'Rollback changes...', 'better-studio' ) ?>
											</button>
										</div>
										<div class="rollback-complete">
											<button type="button" disabled>
												<?php echo bf_get_icon_tag( 'fa-check' ); // escaped before in function ?>
												<?php esc_html_e( 'Installation canceled', 'better-studio' ) ?>
											</button>
										</div>
										<div class="updating">
											<button type="button" disabled>
												<?php echo bf_get_icon_tag( 'fa-refresh', 'fa-spin' ); // escaped before in function ?>
												<?php esc_html_e( 'Updating...', 'better-studio' ) ?>
											</button>
										</div>
										<div class="installed">
										<span class="deactivate-plugin">
											<a href="#" class="bf-btn-secondary bs-pages-secondary-btn">
												<?php esc_html_e( 'Deactivate', 'better-studio' ) ?>
											</a>
										</span>
										</div>
										<div class="uninstalled">
											<button type="button" disabled>
												<?php echo bf_get_icon_tag( 'fa-check' ); // escaped before in function ?>
												<?php esc_html_e( 'Uninstalled', 'better-studio' ) ?>
											</button>
										</div>
										<div class="updated-message">
											<button type="button" disabled>
												<?php echo bf_get_icon_tag( 'fa-check' ); // escaped before in function ?>
												<?php esc_html_e( 'Updated', 'better-studio' ) ?>
											</button>
										</div>
										<div class="activated">
											<button type="button" disabled>
												<?php echo bf_get_icon_tag( 'fa-check' ); // escaped before in function ?>
												<?php esc_html_e( 'Activated', 'better-studio' ) ?>
											</button>
										</div>
									</div>

								<?php else: ?>
									<span
										class="active-error"><?php echo wp_kses( sprintf( __( 'Please register your %s', 'better-studio' ), $product_type ), bf_trans_allowed_html() ); ?></span>
								<?php endif ?>
							</div>
						</footer>
					</div>
				<?php endforeach ?>

				<div class="clearfix"></div>
			</div>

			<?php
		else:

			$this->error( esc_html__( 'No plugin registered', 'better-studio' ) );
		endif;
	}


	/**
	 *  Calculate how many step needs to complete  install/update plugin
	 *
	 *  todo: first step of installation (download package) take a long time
	 *  and other steps pass fast, so the progressbar loading not work correctly!
	 *
	 * @param array  $plugin_data   plugin data array
	 * @param string $plugin_action plugin process action ( install|update|activate|deactivate )
	 * @param bool   $quick         quick mode is 2x faster than normal mode by reduce ajax requests.
	 *
	 * @return array {
	 *
	 * @type         $total         total steps count
	 *
	 * @type         $steps         list of steps Array {
	 *
	 * @type         $key           => step name
	 * @type         $value         => frequency (  how many steps need to complete this step! )
	 *
	 * }
	 *
	 * }
	 */
	public function calculate_process_steps( $plugin_data, $plugin_action = 'install', $quick = FALSE ) {

		//install or update package?
		$is_upgrade        = $plugin_action === 'update';
		$installation_type = $is_upgrade ? 'update' : 'install';
		$is_local          = ! empty( $plugin_data['local_path'] );

		if ( $plugin_action === 'install' || $is_upgrade ) {

			if ( $is_local ) {
				if ( $quick ) {

					$steps = array(
						$installation_type . '_unzip_package' => 1,
					);
				} else {

					$steps = array(
						'unzip_package'                 => 1,
						$installation_type . '_package' => 1
					);
				}
			} else {

				if ( $quick ) {

					$steps = array(
						'download_unzip_package'                    => 1,
						$installation_type . '_translation_package' => 1,
					);
				} else {

					$steps = array(
						'download_package'              => 1,
						'unzip_package'                 => 1,
						'update_translation'            => 1,
						$installation_type . '_package' => 1,
					);
				}
			}
		} else {

			$steps = array(
				'deactivate' => 1
			);
		}
		$steps['empty_request'] = 1;

		$total = array_sum( $steps );

		$reload = ! empty( $plugin_data['reload_after_install'] ) && in_array( $plugin_action, array(
				'install',
				'active'
			) );
		if ( ! $reload ) {
			$reload = $plugin_action === 'deactivate' && ! empty( $plugin_data['reload_after_uninstall'] );
		}

		return compact( 'total', 'steps', 'reload' );
	}


	/**
	 * ajax handler for demo install/deactivate/update plugin requests
	 *
	 * @param array $params
	 *
	 * @return bool true on success or false on failure.
	 */
	public function ajax_request( $params ) {

		$required_params = array(
			'bs_pages_action' => '',
			'plugin_slug'     => '',
		);

		if ( array_diff_key( $required_params, $params ) ) {
			return FALSE;
		}

		$slug         = &$params['plugin_slug'];// plugin directory name
		$plugins_list = $this->get_plugins_data();

		if ( ! isset( $plugins_list[ $slug ] ) ) {
			return FALSE;
		}

		$plugin_data           = $plugins_list[ $slug ];
		$plugin_data['action'] = $params['bs_pages_action'];

		$response = array();

		try {

			switch ( $params['bs_pages_action'] ) {

				case 'get_steps':

					//plugin will be install, update or deactivate
					$plugin_action = isset( $params['plugin_action'] ) ? $params['plugin_action'] : 'install';

					if ( $install_steps = $this->calculate_process_steps( $plugin_data, $plugin_action ) ) {

						$this->set_steps_data( $slug, $install_steps );

						$response = array(
							'steps'       => array_values( $install_steps['steps'] ),
							'types'       => array_keys( $install_steps['steps'] ),
							'steps_count' => count( $install_steps['steps'] ) - 1,
							'total'       => $install_steps['total'],
							'reload'      => $install_steps['reload'],
						);

					}

					break;


				case 'install':
				case 'update':

					if ( isset( $params['current_type'] ) && isset( $params['current_step'] ) ) {

						$type  = &$params['current_type'];
						$step  = intval( $params['current_step'] );
						$index = $step - 1;

						if ( ! class_exists( 'BF_Product_Plugin_Installer' ) ) {
							require_once BF_Product_Pages::get_path( 'install-plugin/class-bf-product-plugin-installer.php' );
						}

						$installer = new BF_Product_Plugin_Installer();

						$response = $installer->install_start( $plugin_data, $type, $index, $slug );
						$installer->install_stop();

						if ( $this->is_final_step( $slug, $type, $step ) ) {
							$installer->install_finished();
						}
					}
					break;

				case 'rollback':

					if ( ! class_exists( 'BF_Product_Plugin_Installer' ) ) {
						require_once BF_Product_Pages::get_path( 'install-plugin/class-bf-product-plugin-installer.php' );
					}

					$installer = new BF_Product_Plugin_Installer();
					$response  = $installer->rollback( $slug );
					break;

				case 'deactivate':
				case 'active':

					if ( ! class_exists( 'BF_Product_Plugin_Installer' ) ) {
						require_once BF_Product_Pages::get_path( 'install-plugin/class-bf-product-plugin-installer.php' );
					}

					$installer = new BF_Product_Plugin_Installer();
					$method    = $params['bs_pages_action'] . '_plugin';
					$callback  = array( $installer, $method );

					if ( is_callable( $callback ) ) {
						$response = call_user_func( $callback, $slug );
					}

					do_action( 'better-framework/product-pages/install-plugin/' . $params['bs_pages_action'] . '-finished', $slug );

					break;
			}
		} catch( Exception $e ) {
			$response = new WP_Error( $e->getCode(), $e->getMessage() );
		}

		if ( is_wp_error( $response ) ) {
			/**
			 * @var WP_Error $response
			 */
			$response = array(
				'is_error'      => TRUE,
				'error_message' => $response->get_error_message(),
				'error_code'    => $response->get_error_code(),
			);
		}

		return $response;
	}
}