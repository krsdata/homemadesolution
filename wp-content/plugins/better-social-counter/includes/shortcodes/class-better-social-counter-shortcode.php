<?php

/**
 * Better Social Counter Shortcode
 */
class Better_Social_Counter_Shortcode extends BF_Shortcode {

	private $valid_styles = array(
		'clean',
		'box',
		'button',
		'big-button',
		'modern',
		'name',
		'style-6',
		'style-7',
		'style-8',
		'style-9',
		'style-10',
		'style-11',
	);

	function __construct( $id, $options ) {

		$id              = 'better-social-counter';
		$this->widget_id = 'better-social-counter';

		$options = array_merge( array(
			'defaults'       => array(
				'title'           => __( 'Stay With Us', 'better-studio' ),
				'show_title'      => 1,
				'style'           => 'modern',
				'colored'         => 1,
				'columns'         => 4,
				'order'           => array(),
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
	 * Internal function for make decide result have a link or not
	 *
	 * @param $id
	 *
	 * @return bool
	 */
	private function decide_link( $id ) {

		switch ( $id ) {

			case 'members':
			case 'comments':
			case 'posts':
				return FALSE;

		}

		return TRUE;

	}

	/**
	 * Used for generating li for social list
	 *
	 * @param string $id
	 * @param string $style
	 *
	 * @return string
	 */
	function get_full_li( $id = '', $style = '' ) {

		if ( empty( $id ) ) {
			return '';
		}

		$data = Better_Social_Counter_Data_Manager::get_full_data( $id );

		if ( ! $data ) {
			return '';
		}

		$output = '<li class="social-item ' . $id . '">';

		if ( $this->decide_link( $id ) ) {
			$output .= '<a href="' . $data['link'] . '" class="item-link" target="_blank">';
		}

		switch ( $style ) {

			case 'style-11':
			case 'style-10':
			case 'style-9':
			case 'style-8':
			case 'style-7':
				$output .= '<i class="item-icon bsfi-' . $id . '"></i>';
				$output .= '<span class="item-count">' . $data['count'] . '</span>';
				$output .= '<span class="item-title">' . $data['title'] . '</span>';
				$output .= '<span class="item-join">' . $data['button'] . '</span>';
				break;

			default:
				$output .= '<i class="item-icon bsfi-' . $id . '"></i>';
				$output .= '<span class="item-count">' . $data['count'] . '</span>';
				$output .= '<span class="item-title">' . $data['title'] . '</span>';

		}


		if ( $this->decide_link( $id ) ) {
			$output .= '</a>';
		}

		$output .= '</li>';

		return $output;
	}


	/**
	 * Used for generating li for social list in "Big Button" style
	 *
	 * @param string $id
	 *
	 * @return string
	 */
	function get_big_button_li( $id = '' ) {

		if ( empty( $id ) ) {
			return '';
		}

		$data = Better_Social_Counter_Data_Manager::get_short_data( $id );

		if ( ! $data ) {
			return '';
		}

		$output = '<li class="social-item ' . $id . '">';

		if ( $this->decide_link( $id ) ) {
			$output .= '<a href="' . $data['link'] . '" class="item-link" target="_blank">';
		}

		$output .= '<i class="item-icon bsfi-' . $id . '"></i><span class="item-name">' . $data['name'] . '</span>';

		$output .= '<span class="item-title-join">' . $data['title_join'] . '</span>';

		if ( $this->decide_link( $id ) ) {
			$output .= '</a>';
		}

		$output .= '</li>';

		return $output;
	}


	/**
	 * Used for generating li for social list
	 *
	 * @param string $id
	 *
	 * @return string
	 */
	function get_short_li( $id = '' ) {

		if ( empty( $id ) ) {
			return '';
		}

		$data = Better_Social_Counter_Data_Manager::get_short_data( $id );

		if ( ! $data ) {
			return '';
		}

		$output = '<li class="social-item ' . $id . '">';

		if ( $this->decide_link( $id ) ) {
			$output .= '<a href="' . $data['link'] . '" target="_blank">';
		}

		$output .= '<i class="item-icon bsfi-' . $id . '"></i><span class="item-title">' . $data['title'] . '</span>';

		if ( $this->decide_link( $id ) ) {
			$output .= '</a>';
		}

		return $output . '</li>';
	}


	/**
	 * Used for generating li for social list
	 *
	 * @param string $id
	 *
	 * @return string
	 */
	function get_name_li( $id = '' ) {

		if ( empty( $id ) ) {
			return '';
		}

		$data = Better_Social_Counter_Data_Manager::get_short_data( $id );

		if ( ! $data ) {
			return '';
		}

		$output = '<li class="social-item ' . $id . '">';

		if ( $this->decide_link( $id ) ) {
			$output .= '<a href="' . $data['link'] . '" target="_blank">';
		}

		$output .= '<i class="item-icon bsfi-' . $id . '"></i><span class="item-name">' . $data['name'] . '</span>';

		if ( $this->decide_link( $id ) ) {
			$output .= '</a>';
		}

		return $output . '</li>';

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

		if ( BF_Widgets_Manager::is_special_sidebar() ) {
			$atts['style'] = 'button';
		}

		if ( ! in_array( $atts['style'], $this->valid_styles ) ) {
			$atts['style'] = 'clean';
		}

		if ( empty( $atts['css-class'] ) ) {
			$atts['css-class'] = '';
		}

		$atts['css-class'] .= ' better-studio-shortcode bsc-clearfix better-social-counter style-' . $atts['style'];

		if ( $atts['colored'] == 1 ) {
			$atts['css-class'] .= ' colored';
		}

		$atts['css-class'] .= ' in-' . $atts['columns'] . '-col';

		if ( ! empty( $atts['custom-css-class'] ) ) {
			$atts['css-class'] .= ' ' . sanitize_html_class( $atts['custom-css-class'] );
		}

		$custom_id = empty( $atts['custom-id'] ) ? '' : sanitize_html_class( $atts['custom-id'] );

		?>
		<div <?php
		if ( $custom_id ) {
			echo 'id="', $custom_id, '"';
		}
		?> class=" <?php echo esc_attr( $atts['css-class'] ); ?>">
			<?php

			bf_shortcode_show_title( $atts ); // show title

			?>
			<ul class="social-list bsc-clearfix"><?php

				if ( ! is_array( $atts['order'] ) ) {

					// Convert to array
					$atts['order'] = explode( ',', $atts['order'] );

					switch ( $atts['style'] ) {

						// Big Button Style
						case 'big-button':
							foreach ( $atts['order'] as $site ) {
								echo $this->get_big_button_li( $site );
							}
							break;

						// Button Style
						case 'button':
							foreach ( $atts['order'] as $site ) {
								echo $this->get_short_li( $site );
							}
							break;

						// Name Style
						case 'name':
							foreach ( $atts['order'] as $site_key => $site ) {
								echo $this->get_name_li( $site );
							}
							break;

						// Other Full Styles
						default:
							foreach ( $atts['order'] as $site ) {
								echo $this->get_full_li( $site, $atts['style'] );
							}

					}
				} else {
					switch ( $atts['style'] ) {

						// Big Button Style
						case 'big-button':
							foreach ( $atts['order'] as $site_key => $site ) {
								echo $this->get_big_button_li( $site_key );
							}
							break;

						// Button Style
						case 'button':
							foreach ( $atts['order'] as $site_key => $site ) {
								echo $this->get_short_li( $site_key );
							}
							break;

						// Name Style
						case 'name':
							foreach ( $atts['order'] as $site_key => $site ) {
								echo $this->get_name_li( $site_key );
							}
							break;

						// Other Full Styles
						default:
							foreach ( $atts['order'] as $site_key => $site ) {
								echo $this->get_full_li( $site_key, $atts['style'] );
							}

					}
				}

				?>
			</ul>
		</div>
		<?php
		return ob_get_clean();
	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map( array(
			"name"           => __( 'Better Social Counter', 'better-studio' ),
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
					'heading'       => __( 'Style', 'better-studio' ),
					'type'          => 'bf_image_radio',
					"admin_label"   => TRUE,
					"param_name"    => 'style',
					"value"         => $this->defaults['style'],
					'section_class' => 'style-floated-left',
					'options'       => array(
						'modern'     => array(
							'label' => __( 'Style 1', 'better-studio' ),
							'img'   => BETTER_SOCIAL_COUNTER_DIR_URL . 'img/vc-social-counter-modern.jpg'
						),
						'clean'      => array(
							'label' => __( 'Style 2', 'better-studio' ),
							'img'   => BETTER_SOCIAL_COUNTER_DIR_URL . 'img/vc-social-counter-clean.jpg'
						),
						'box'        => array(
							'label' => __( 'Style 3', 'better-studio' ),
							'img'   => BETTER_SOCIAL_COUNTER_DIR_URL . 'img/vc-social-counter-box.jpg'
						),
						'button'     => array(
							'label' => __( 'Style 4', 'better-studio' ),
							'img'   => BETTER_SOCIAL_COUNTER_DIR_URL . 'img/vc-social-counter-button.jpg'
						),
						'big-button' => array(
							'label' => __( 'Style 5', 'better-studio' ),
							'img'   => BETTER_SOCIAL_COUNTER_DIR_URL . 'img/vc-social-counter-big-button.jpg'
						),
						'style-6'    => array(
							'label' => __( 'Style 6', 'better-studio' ),
							'img'   => BETTER_SOCIAL_COUNTER_DIR_URL . 'img/vc-social-counter-style-6.jpg'
						),
						'style-7'    => array(
							'label' => __( 'Style 7', 'better-studio' ),
							'img'   => BETTER_SOCIAL_COUNTER_DIR_URL . 'img/vc-social-counter-style-7.png'
						),
						'style-8'    => array(
							'label' => __( 'Style 8', 'better-studio' ),
							'img'   => BETTER_SOCIAL_COUNTER_DIR_URL . 'img/vc-social-counter-style-8.png'
						),
						'style-9'    => array(
							'label' => __( 'Style 9', 'better-studio' ),
							'img'   => BETTER_SOCIAL_COUNTER_DIR_URL . 'img/vc-social-counter-style-9.png'
						),
						'style-10'   => array(
							'label' => __( 'Style 10', 'better-studio' ),
							'img'   => BETTER_SOCIAL_COUNTER_DIR_URL . 'img/vc-social-counter-style-10.png'
						),
						'style-11'   => array(
							'label' => __( 'Style 11', 'better-studio' ),
							'img'   => BETTER_SOCIAL_COUNTER_DIR_URL . 'img/vc-social-counter-style-11.png'
						),
					),
				),
				array(
					"type"       => 'bf_switchery',
					"heading"    => __( 'Show in colored  style?', 'better-studio' ),
					"param_name" => 'colored',
					"value"      => $this->defaults['colored'],
				),
				array(
					"type"        => 'bf_select',
					"admin_label" => TRUE,
					"heading"     => __( 'Number of Columns', 'better-studio' ),
					"param_name"  => 'columns',
					"value"       => $this->defaults['columns'],
					"options"     => array(
						'1'  => __( '1 Column', 'better-studio' ),
						'2'  => __( '2 Column', 'better-studio' ),
						'3'  => __( '3 Column', 'better-studio' ),
						'4'  => __( '4 Column', 'better-studio' ),
						'5'  => __( '5 Column', 'better-studio' ),
						'6'  => __( '6 Column', 'better-studio' ),
						'7'  => __( '7 Column', 'better-studio' ),
						'8'  => __( '8 Column', 'better-studio' ),
						'9'  => __( '9 Column', 'better-studio' ),
						'10' => __( '10 Column', 'better-studio' ),
					),
				),
				array(
					"type"          => 'bf_sorter_checkbox',
					"admin_label"   => TRUE,
					"heading"       => __( 'Active and Sort Sites', 'better-studio' ),
					"param_name"    => 'order',
					"value"         => '',
					"options"       => Better_Social_Counter_Data_Manager::self()->get_widget_options_list(),
					'section_class' => 'better-social-counter-sorter',
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
