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

BetterFramework_Oculus_Notification::Run();

class BetterFramework_Oculus_Notification {

	/**
	 * Oculus Notifications Handler
	 * Initialize
	 */
	public static function Run() {
		global $bs_oculus_notification;

		if ( $bs_oculus_notification === FALSE ) {
			return;
		}

		if ( ! $bs_oculus_notification instanceof self ) {
			$bs_oculus_notification = new self();
			$bs_oculus_notification->init();
		}

		return $bs_oculus_notification;
	}

	/**
	 * Apply hooks
	 */
	public function init() {
		add_action( 'init', array( $this, 'append_fixed_notification_menu' ) );
		add_action( 'switch_theme', array( $this, 'theme_change_notification' ), 9, 3 );
		add_action( 'admin_head', array( $this, 'display_custom_notifications' ) );

		add_action( 'better-framework/oculus/check-update/done', array( $this, 'save_notifications' ) );
		add_filter( 'better-framework/oculus/check-update/data', array( $this, 'check_data' ) );
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public function check_data( $data ) {
		$data['watched-notifications'] = get_option( 'oculus-notifications-watched' );

		return $data;
	}

	/**
	 *  Callback: Register menu for 'fixed page' notification
	 *  action   : init
	 */
	public function append_fixed_notification_menu() {

		if ( ! function_exists( 'BF' ) ) {
			return;
		}
		$notifications = get_option( 'oculus-notifications' );
		if ( ! empty( $notifications['fixed_page'] ) ) {
			$default_id    = 'bs-product-pages-notification-';
			$default_menu  = array(
				'parent'       => 'bs-product-pages-welcome',
				'name'         => __( 'Notification', 'better-studio' ),
				'icon'         => '\\E034',
				'callback'     => array( $this, 'menu_callback' ),
				'capability'   => 'edit_theme_options',
				'position'     => '9.5',
				'on_admin_bar' => TRUE,
				'id'           => 'betterstudio-notification',
				'slug'         => 'betterstudio-notification',
			);
			$page_settings = &$notifications['fixed_page'];
			if ( ! empty( $page_settings->menu ) ) {
				$default_menu['id'] = $default_menu['slug'] = $default_id . $page_settings->id;

				$menu    = wp_parse_args( $page_settings->menu, $default_menu );
				$watched = get_option( 'oculus-notifications-watched', array() );

				/**
				 * Hide menu if watched previously.
				 */
				if ( ! empty( $page_settings->menu['notification_id'] ) ) {
					$nid = &$page_settings->menu['notification_id'];
					if ( ! empty( $watched[ $nid ] ) ) {
						if ( $GLOBALS['pagenow'] !== 'admin.php' || ! isset( $_GET['page'] ) || $_GET['page'] !== $menu['slug'] ) {
							$menu['parent'] = NULL;
						} // null parent make menu invisible
					}
				}

				Better_Framework()->admin_menus()->add_menupage( $menu );
			}
		}
	}

	/**
	 * Callback: report theme changes
	 * action  : switch_theme
	 *
	 * @param string   $new_name
	 * @param WP_Theme $new_theme
	 * @param WP_Theme $old_theme
	 */
	public function theme_change_notification( $new_name, $new_theme, $old_theme ) {
		$new_theme_headers = array(
			'Name'        => $new_theme->get( 'Name' ),
			'ThemeURI'    => $new_theme->get( 'ThemeURI' ),
			'Description' => $new_theme->get( 'Description' ),
			'Author'      => $new_theme->get( 'Author' ),
			'AuthorURI'   => $new_theme->get( 'AuthorURI' ),
			'Version'     => $new_theme->get( 'Version' ),
			'Template'    => $new_theme->get( 'Template' ),
		);

		$old_theme_headers = array(
			'Name'     => $old_theme->get( 'Name' ),
			'Version'  => $old_theme->get( 'Version' ),
			'Template' => $old_theme->get( 'Template' ),
		);

		BetterFramework_Oculus::request( 'product-disabled', array(
			'data'         => array(
				'new-theme-headers' => $new_theme_headers,
				'old-theme-headers' => $old_theme_headers,
			),
			'use_wp_error' => FALSE,
		) );
	}

	/**
	 * Display custom remote notifications to user
	 */
	public function display_custom_notifications() {
		if ( ! function_exists( 'bf_enqueue_style' ) ) {
			return;
		}

		$watched = get_option( 'oculus-notifications-watched', array() );
		$not     = get_option( 'oculus-notifications', array() );

		$need_update = FALSE;
		if ( ! $not ) {
			return;
		}

		if ( ! empty( $not['custom'] ) ) {

			bf_enqueue_script( 'bf-modal' );
			bf_enqueue_style( 'bf-modal' );

			foreach ( (array) $not['custom'] as $index => $custom ) {
				if ( empty( $custom->id ) || isset( $watched[ $custom->id ] ) ) {
					continue;
				}
				$this->mark_as_watched( $custom->id );
				$this->enqueue_dependencies( $custom );
				$this->print_html_css( $custom );

				$need_update = TRUE;
				unset( $not['custom'][ $index ] );
				break;
			}
		}

		if ( $need_update ) {
			update_option( 'oculus-notifications', $not, 'no' );
		}
	}

	/**
	 * Enqueue static file dependencies
	 *
	 * @param object $object
	 */
	protected function enqueue_dependencies( $object ) {
		if ( ! empty( $object->js_deps ) && is_array( $object->js_deps ) ) {
			foreach ( $object->js_deps as $args ) {
				$function = sizeof( $args ) === 1 ? 'bf_enqueue_script' : 'wp_enqueue_script';
				call_user_func_array( $function, $args );
			}
		}

		if ( ! empty( $object->css_deps ) && is_array( $object->css_deps ) ) {
			foreach ( $object->css_deps as $args ) {
				$function = sizeof( $args ) === 1 ? 'bf_enqueue_style' : 'wp_enqueue_style';
				call_user_func_array( $function, $args );
			}
		}
	}

	/**
	 * mark a notification as watched
	 *
	 * @param string|int $notification_id
	 */
	protected function mark_as_watched( $notification_id ) {
		$watched                     = get_option( 'oculus-notifications-watched', array() );
		$watched[ $notification_id ] = time();

		update_option( 'oculus-notifications-watched', $watched, 'no' );
	}

	/**
	 * Fixed page notification, menu callback
	 */
	public function menu_callback() {
		$notifications = get_option( 'oculus-notifications' );
		if ( ! empty( $notifications['fixed_page'] ) ) {
			$not = &$notifications['fixed_page'];
			if ( ! empty( $not->menu['notification_id'] ) ) {
				$this->mark_as_watched( $not->menu['notification_id'] );
			}

			$this->print_html_css( $not );
			echo $not->html;  // escaped before
			$this->mark_as_watched( $not->id );

		}
	}

	/**
	 * @param object $not_object notification object
	 */
	protected function print_html_css( $not_object ) {
		if ( isset( $not_object->css ) ) {
			echo '<style>', $not_object->css, '</style>'; // escaped before
		}
		if ( isset( $not_object->js ) ) {
			echo '<script>', $not_object->js, '</script>'; // escaped before
		}
	}

	/**
	 * @param object $response
	 */
	public function save_notifications( $response ) {
		if ( empty( $response->notifications ) ) {
			return;
		}
		$notifications = $response->notifications;
		$db            = get_option( 'oculus-notifications', array() );

		if ( isset( $notifications->fixed_page ) ) {
			$page_data = &$notifications->fixed_page;

			if ( isset( $page_data->html ) && isset( $page_data->id ) ) {
				if ( isset( $page_data->menu ) ) {
					$page_data->menu = (array) $page_data->menu;
				}
				$db['fixed_page'] = $page_data;
			}
		}
		if ( isset( $notifications->custom ) && is_array( $notifications->custom ) ) {
			if ( ! isset( $db['custom'] ) ) {
				$db['custom'] = array();
			}

			foreach ( $notifications->custom as $custom ) {
				if ( isset( $custom->id ) ) {
					$id                  = &$custom->id;
					$db['custom'][ $id ] = $custom;
				}
			}
		}

		update_option( 'oculus-notifications', $db, 'no' );
	}
}
