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


function bf_is_product_page( $page_slug = '' ) {
	global $pagenow;

	if ( $pagenow === 'admin.php' && ! empty( $_GET['page'] ) ) {
		if ( $page_slug ) {
			return BF_Product_Pages::$menu_slug . '-' . $page_slug === $_GET['page'];
		}

		$length = strlen( BF_Product_Pages::$menu_slug );

		return substr( $_GET['page'], 0, $length ) === BF_Product_Pages::$menu_slug;
	}

	return FALSE;
}

function bf_product_notice_thumbnail( $notices ) {
	static $thumbnail;

	if ( bf_is_product_page() ) {

		if ( is_null( $thumbnail ) ) {
			$settings  = BF_Product_Pages::get_config();
			$thumbnail = isset( $settings['notice-icon'] ) ? $settings['notice-icon'] : FALSE;
		}

		if ( $thumbnail ) {
			foreach ( $notices as $index => $notice ) {
				if ( empty( $notice['thumbnail'] ) || ! filter_var( $notice['thumbnail'], FILTER_VALIDATE_URL ) ) {
					$notices[ $index ]['thumbnail'] = $thumbnail;
				}
			}
		}
	}

	return $notices;
}

add_filter( 'better-framework/admin-notices/show', 'bf_product_notice_thumbnail' );

function bf_product_enqueue_scripts() {

	bf_enqueue_style( 'fontawesome' );
	wp_enqueue_style( 'bs-product-pages-styles', BF_Product_Pages::get_asset_url( 'css/bs-product-pages.css' ), array(), BF_Product_Pages::Run()->get_version() );
}

add_action( 'admin_enqueue_scripts', 'bf_product_enqueue_scripts' );


/**
 * Generate Product Box
 *
 *
 * @param array $box_data    array {
 *
 * @type array  $classes     wrapper extra class
 * @type string $icon        icon   class {@see bf_get_icon_tag}
 * @type string $header      box header label
 * @type string $description box container text
 * @type array buttons array{
 *  array{
 * @type string $url         button url
 * @type string $target      button url
 * @type string $class       button classes
 * @type string $label       button label
 *  }
 * }
 *
 * }
 */
function bf_product_box( $box_data ) {

	$box_data = bf_merge_args( $box_data, array(
		'classes'     => array(),
		'has_loading' => FALSE
	) );

	//class bs-pages-box-wrapper is required
	$box_data['classes'][] = 'bs-pages-box-wrapper';
	$box_data['classes']   = array_unique( $box_data['classes'] );
	?>

	<div class="<?php echo implode( ' ', array_map( 'sanitize_html_class', $box_data['classes'] ) ) ?>">
		<?php if ( $box_data['has_loading'] ) : ?>
			<div class="bs-loading-overlay" stlye="display:none;">
				<div class="la-line-scale-pulse-out-rapid la-2x">
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
				</div>
			</div>
		<?php endif ?>
		<div class="bs-pages-box-container">
		<span class="bs-pages-box-header">
			<?php echo ! empty( $box_data['icon'] ) ? bf_get_icon_tag( $box_data['icon'] ) : ''; // escaped before in function ?>
			<?php echo $box_data['header']; // escaped before ?>
		</span>

			<div class="bs-pages-box-description">
				<?php echo $box_data['description']; // escaped before ?>
			</div>

			<?php if ( isset( $box_data['buttons'] ) && count( $box_data['buttons'] ) > 0 ) { ?>
				<div class="bs-pages-buttons">
					<?php foreach ( $box_data['buttons'] as $btn ) { ?>
						<a href="<?php echo ! empty( $btn['url'] ) ? esc_url( $btn['url'] ) : ''; ?>"
						   target="<?php echo ! empty( $btn['target'] ) ? esc_attr( $btn['target'] ) : '_self'; ?>"
						   class="<?php echo ! empty( $btn['class'] ) ? esc_attr( $btn['class'] ) : ''; ?>">
							<?php echo ! empty( $btn['label'] ) ? $btn['label'] : ''; ?>
						</a>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php
}

/**
 * register admin menu and sub menus
 */
function bf_product_register_menus() {
	$settings = BF_Product_Pages::get_config();

	if ( ! isset( $settings['pages'] ) || ! is_array( $settings['pages'] ) ) {
		return;
	}

	bf_enqueue_style( 'better-studio-admin-icon' );

	$parent_slug = FALSE;

	// todo: check capability of each page, for example check install_plugins capability for plugins page
	$default_capability = 'edit_theme_options';
	$instance           = BF_Product_Pages::Run();

	foreach ( $settings['pages'] as $id => $menu ) {

		// don't register menu for tab_link type
		if ( isset( $menu['type'] ) && $menu['type'] == 'tab_link' ) {
			continue;
		}

		if ( ! isset( $menu['menu_title'] ) ) {
			$menu['menu_title'] = $menu['name'];
		}

		// change position from config
		// parent item position should be 3
		if ( $parent_slug === FALSE ) {
			if ( ! empty( $settings['menu_position'] ) ) {
				$default_position = $settings['menu_position'];
			} else {
				$default_position = 3;
			}
		} else if ( empty( $menu['menu_position'] ) ) {
			$default_position = 50;
		} else {
			$default_position = $menu['menu_position'];
		}

		$_menu_slug = BF_Product_Pages::$menu_slug . "-$id";

		// Create menu item config
		$menu_config = array(
			'id'           => $_menu_slug,
			'parent'       => $parent_slug ? $parent_slug : FALSE,
			'slug'         => $_menu_slug,
			'name'         => $menu['name'],
			'menu_title'   => isset( $menu['menu_title'] ) ? $menu['menu_title'] : $menu['name'],
			'page_title'   => $menu['name'],
			'parent_title' => $settings['menu_title'],
			'icon'         => isset( $settings['menu_icon'] ) ? $settings['menu_icon'] : '\E000',
			'callback'     => array( $instance, 'menu_callback' ),
			'position'     => $default_position,
			'capability'   => isset( $menu['capability'] ) ? $menu['capability'] : $default_capability,
			'on_admin_bar' => is_admin(),
		);

		Better_Framework()->admin_menus()->add_menupage( apply_filters( 'better-framework/product-pages/register-menu/params', $menu_config ) );

		// cache parent slug for next menu items
		if ( $parent_slug === FALSE ) {
			$parent_slug = $_menu_slug;
		}
	}


	if ( ! defined( 'BF_PRODUCT_PAGES_MAIN_MENU' ) ) {
		define( 'BF_PRODUCT_PAGES_MAIN_MENU', $parent_slug );
	}
} // bf_product_register_menus

if ( is_user_logged_in() ) {
	add_action( 'better-framework/admin-menus/admin-menu/before', 'bf_product_register_menus' );
}
