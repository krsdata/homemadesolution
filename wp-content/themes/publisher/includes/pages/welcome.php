<div class="bs-welcome-page-wrap">

	<div class="bs-welcome-header">
		<a href="http://themeforest.net/item/publisher/15801051?ref=Better-Studio" target="_blank"><img
				style=" box-shadow: 0 0 29px #e2e2e2;" class="bs-welcome-thumbnail"
				src="<?php echo bf_get_theme_uri( 'includes/pages/assets/images/thumbnail.jpg' ); ?>"></a>
		<h1><?php esc_html_e( 'Welcome to Publisher', 'publisher' ); ?>
			<div class="bs-welcome-version">V<?php echo Better_Framework()->theme()->get( 'Version' ); ?></div>
		</h1>
		<div class="welcome-text">
			<?php esc_html_e( 'Thank you for choosing the best theme we have ever build! we did a lot of pressure to release this great
			product and we will offer our 5 star support to this theme for fixing all the issues and adding more
			features.', 'publisher' ); ?>
		</div>
	</div>

	<?php
	$reg_info = bf_register_product_get_info();

	if ( ! isset( $reg_info['status'] ) || $reg_info['status'] !== 'success' ) :

		$desc = wp_kses( __( 'Your license of Publisher is not registered. Place your Envato purchase code to unlock automatic updates, access to support, and Plugins. <a href="#" id="register-help-modal">Learn more</a> about product validation or manage licenses directly in your BetterStudio account.', 'publisher' ), bf_trans_allowed_html() );

		?>
		<hr>
		<div class="bs-register-product bf-clearfix">
			<?php
			$page = isset( $_GET['page'] ) ? $_GET['page'] : '';
			bf_product_box( array(
				'icon'        => 'fa-unlock',
				'header'      => __( 'Register Publisher', 'publisher' ),
				'has_loading' => TRUE,
				'description' => '
		<div class="bs-product-desc">
		<div class="bs-icons-list">
            <i class="fa fa-lock register-product-icon" aria-hidden="true"></i>
			<i class="fa fa-key register-product-icon" aria-hidden="true"></i>
			<i class="fa fa-unlock register-product-icon" aria-hidden="true"></i>
        </div>
        <p>
        		' . $desc . '
		</p>
        </div>

        <form action="" id="bs-register-product-form">
        	' . wp_nonce_field( 'bs-register-product', 'bs-register-token', FALSE ) . '
        	<input type="hidden" name="page" value="' . esc_attr( $page ) . '" >
        	<input type="text" name="bs-purchase-code" id="bs-purchase-code" class="bs-purchase-code" placeholder="' . esc_attr__( 'Enter Code and Hit Enter', 'publisher' ) . '">
		</form>

		',
				'classes'     => array( 'bs-fullwidth-box' )
			) );
			?>
		</div>
	<?php endif ?>
	<hr>

	<div class="bs-welcome-intro-section bf-columns-2 bf-clearfix">
		<div class="bf-column">
			<h3><?php esc_html_e( 'Quick Start:', 'publisher' ); ?></h3>
			<p><?php echo wp_kses( sprintf( __( 'You can start using theme simply by installing Visual Composer plugin. Also there is more plugins for
				social counter, post views, ads manager ... that you can install them from our <a
					href="%s">plugin
					installer</a>.', 'publisher' ), admin_url( 'admin.php?page=bs-product-pages-install-plugin' ) ), bf_trans_allowed_html() ); ?></p>
			<p><?php echo wp_kses( sprintf( __( 'If you need setup your site like Publisher demos, you can use the <a
					href="%s">Demo Installer</a>
				that can do it for you with only <em>one click</em>.', 'publisher' ), admin_url( 'admin.php?page=bs-product-pages-install-demo' ) ), bf_trans_allowed_html() ); ?></p>
		</div>

		<div class="bf-column bf-text-right">
			<img style=" box-shadow: 0 0 29px #e2e2e2;"
			     src="<?php echo bf_get_theme_uri( 'includes/pages/assets/images/banner.jpg' ); ?>">
		</div>
	</div>

	<hr>

	<?php

	if ( $support_list = apply_filters( 'better-framework/product-pages/support/config', array() ) ) :

		?>
		<div class="bs-product-pages-box-container bf-clearfix">
			<?php

			$_check = array();

			if ( isset( $support_list['documentation'] ) ) {
				$_check[] = 'documentation';
			}

			if ( isset( $support_list['video-tutorials'] ) ) {
				$_check[] = 'video-tutorials';
			}

			if ( isset( $support_list['knowledge-base'] ) ) {
				$_check[] = 'knowledge-base';
			}

			foreach ( $_check as $support_data ) {

				$support_list[ $support_data ]['classes'][] = 'fix-height-1';

				bf_product_box( $support_list[ $support_data ] );
			}

			unset( $_check );

			?>
		</div>
		<?php

	endif;

	?>
</div>