<?php

/**
 * Better Social Counter Shortcode
 */
class Better_Social_Banner_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id              = 'better-social-banner';
		$this->widget_id = 'better-social-banner';

		$options = array_merge( array(
			'defaults'       => array(
				'title'           => '',
				'show_title'      => 0,
				'site'            => '',
				'bs-show-desktop' => TRUE,
				'bs-show-tablet'  => TRUE,
				'bs-show-phone'   => TRUE,
			),
			'have_widget'    => TRUE,
			'have_vc_add_on' => TRUE,
		), $options );

		parent::__construct( $id, $options );

	}


	/**
	 * Filter custom css codes for shortcode widget!
	 *
	 * @param $fields
	 *
	 * @return array
	 */
	function register_custom_css( $fields ) {
		return $fields;
	}


	/**
	 * Handle displaying of shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function display( array $atts, $content = '' ) {

		ob_start();

		if ( empty( $atts['css-class'] ) ) {
			$atts['css-class'] = '';
		}

		$atts['css-class'] .= ' better-studio-shortcode better-social-banner bsc-clearfix';

		$custom_id = empty( $atts['custom-id'] ) ? '' : sanitize_html_class( $atts['custom-id'] );

		?>
		<div <?php
		if ( $custom_id ) {
			echo 'id="', $custom_id, '"';
		}
		?> class=" <?php echo esc_attr( $atts['css-class'] ); ?>">
			<?php

			bf_shortcode_show_title( $atts ); // show title

			$data = Better_Social_Counter_Data_Manager::get_full_data( $atts['site'] );

			// If data is valid
			if ( $data ) {

				?>
				<a href="<?php echo $data['link']; ?>" class="banner-item item-<?php echo $atts['site']; ?>">
					<i class="item-icon bsfi-<?php echo $atts['site']; ?>"
					   aria-label="<?php echo $atts['site']; ?>"></i>
					<span class="item-count"><?php echo $data['count']; ?></span>
					<span class="item-title"><?php echo $data['title']; ?></span>
					<span class="item-button"><?php echo $data['button']; ?></span>
				</a>
				<?php

			}

			?>
		</div>
		<?php

		return ob_get_clean();
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		$sites = Better_Social_Counter_Data_Manager::self()->get_select_options_for_banner( TRUE, TRUE );

		// Select first active site
		$active_site = '';
		if ( empty( $this->defaults['site'] ) ) {
			foreach ( $sites as $site_key => $site_value ) {
				if ( is_array( $site_value ) ) {
					continue;
				}
				$active_site = $site_key;
				break;
			}
		}

		vc_map( array(
			"name"           => __( 'Better Social Banner', 'better-studio' ),
			"base"           => $this->id,
			"weight"         => 1,
			"wrapper_height" => 'full',
			"category"       => __( 'Content', 'better-studio' ),
			"params"         => array(
				array(
					"type"        => 'textfield',
					"admin_label" => TRUE,
					"heading"     => __( 'Title', 'better-studio' ),
					"param_name"  => 'title',
					"value"       => $this->defaults['title'],
				),
				array(
					"type"       => 'bf_switchery',
					"heading"    => __( 'Show Title?', 'better-studio' ),
					"param_name" => 'show_title',
					"value"      => $this->defaults['show_title'],
				),
				array(
					'heading'     => __( 'Site', 'better-studio' ),
					'type'        => 'bf_select',
					"admin_label" => TRUE,
					"param_name"  => 'site',
					"value"       => empty( $this->defaults['site'] ) ? $active_site : $this->defaults['site'],
					'options'     => $sites,
				),
				array(
					"type"          => 'bf_switchery',
					"heading"       => __( 'Show on Desktop', 'better-studio' ),
					"param_name"    => 'bs-show-desktop',
					"admin_label"   => FALSE,
					"value"         => $this->defaults['bs-show-desktop'],
					'section_class' => 'style-floated-left bordered bf-css-edit-switch',
					'group'         => __( 'Design options', 'better-studio' ),
				),
				array(
					"type"          => 'bf_switchery',
					"heading"       => __( 'Show on Tablet Portrait', 'better-studio' ),
					"param_name"    => 'bs-show-tablet',
					"admin_label"   => FALSE,
					"value"         => $this->defaults['bs-show-tablet'],
					'section_class' => 'style-floated-left bordered bf-css-edit-switch',
					'group'         => __( 'Design options', 'better-studio' ),
				),
				array(
					"type"          => 'bf_switchery',
					"heading"       => __( 'Show on Phone', 'better-studio' ),
					"param_name"    => 'bs-show-phone',
					"admin_label"   => FALSE,
					"value"         => $this->defaults['bs-show-phone'],
					'section_class' => 'style-floated-left bordered bf-css-edit-switch',
					'group'         => __( 'Design options', 'better-studio' ),
				),
				array(
					'type'       => 'css_editor',
					'heading'    => __( 'CSS box', 'better-studio' ),
					'param_name' => 'css',
					'group'      => __( 'Design options', 'better-studio' ),
				),
				array(
					'type'          => 'textfield',
					'heading'       => __( 'Custom CSS Class', 'better-studio' ),
					'param_name'    => 'custom-css-class',
					'admin_label'   => FALSE,
					'value'         => '',
					'section_class' => 'bf-section-two-column',
					'group'         => __( 'Design options', 'better-studio' ),
				),
				array(
					'type'          => 'textfield',
					'heading'       => __( 'Custom ID', 'better-studio' ),
					'param_name'    => 'custom-id',
					'admin_label'   => FALSE,
					'value'         => '',
					'section_class' => 'bf-section-two-column',
					'group'         => __( 'Design options', 'better-studio' ),
				),
			)
		) );
	}
}
