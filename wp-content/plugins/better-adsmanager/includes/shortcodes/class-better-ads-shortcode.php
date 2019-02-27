<?php

class Better_Ads_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'better-ads';

		$this->widget_id = 'better ads';

		$this->name = __( 'Ad Box', 'better-studio' );

		$this->description = 'BetterAds ad box';

		$_options = array(
			'defaults'       => array(
				'title'           => '',
				'type'            => '',
				'banner'          => 'none',
				'campaign'        => 'none',
				'count'           => 2,
				'columns'         => 1,
				'align'           => 'center',
				'order'           => 'ASC',
				'orderby'         => 'rand',
				'float'           => 'none',
				'show-caption'    => TRUE,
				'bs-show-desktop' => TRUE,
				'bs-show-tablet'  => TRUE,
				'bs-show-phone'   => TRUE,
			),
			'have_widget'    => TRUE,
			'have_vc_add_on' => TRUE,
		);

		$_options = wp_parse_args( $_options, $options );

		parent::__construct( $id, $_options );

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

		$func = '';
		if ( is_singular() ) {
			$func = 'bf_get_post_meta';
		} elseif ( is_archive() ) {

			$queried_object = get_queried_object();

			if ( ! empty( $queried_object->taxonomy ) ) {
				$func = 'bf_get_term_meta';
			}
		}

		if ( ! empty( $func ) ) {
			if ( call_user_func( $func, 'bam_disable_all' ) || call_user_func( $func, 'bam_disable_widgets' ) ) {
				return '';
			}
		}

		ob_start();
		echo Better_Ads_Manager()->show_ads( $atts );

		return ob_get_clean();

	}


	/**
	 * Registers Visual Composer Add-on
	 */
	function register_vc_add_on() {

		vc_map( array(
			"name"           => $this->name,
			"base"           => $this->id,
			"description"    => $this->description,
			"weight"         => 10,
			"wrapper_height" => 'full',

			"category" => __( 'Content', 'better-studio' ),
			"params"   => array(
				array(
					"type"        => 'bf_select',
					"admin_label" => FALSE,
					"heading"     => __( 'Ad Type', 'better-studio' ),
					"param_name"  => 'type',
					"value"       => $this->defaults['type'],
					'options'     => array(
						''         => __( '-- Select Ad Type', 'better-studio' ),
						'campaign' => __( 'Campaign', 'better-studio' ),
						'banner'   => __( 'Banner', 'better-studio' ),
					),
					'group'       => __( 'General', 'better-studio' ),
				),

				//
				// Banner
				//
				array(
					"type"             => 'bf_select',
					"admin_label"      => FALSE,
					"heading"          => __( 'Banner', 'better-studio' ),
					"param_name"       => 'banner',
					"value"            => $this->defaults['banner'],
					'deferred-options' => array(
						'callback' => 'better_ads_get_banners_option',
						'args'     => array(
							- 1,
							TRUE
						),
					),
					'group'            => __( 'General', 'better-studio' ),
					'show_on'          => array(
						array( 'type=banner' ),
					)
				),
				//
				// Campaign
				//
				array(
					"type"             => 'bf_select',
					"admin_label"      => FALSE,
					"heading"          => __( 'Campaign', 'better-studio' ),
					"param_name"       => 'campaign',
					"value"            => $this->defaults['campaign'],
					'deferred-options' => array(
						'callback' => 'better_ads_get_campaigns_option',
						'args'     => array(
							- 1,
							TRUE
						),
					),
					'group'            => __( 'General', 'better-studio' ),
					'show_on'          => array(
						array( 'type=campaign' ),
					)
				),
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Max Amount of Allowed Banners', 'better-studio' ),
					"description" => __( 'Leave empty to show all banners.', 'better-studio' ),
					"param_name"  => 'count',
					"value"       => $this->defaults['count'],
					'group'       => __( 'General', 'better-studio' ),
					'show_on'     => array(
						array( 'type=campaign' ),
					)
				),
				array(
					"type"        => 'bf_select',
					"admin_label" => FALSE,
					"heading"     => __( 'Columns', 'better-studio' ),
					"param_name"  => 'columns',
					"value"       => $this->defaults['columns'],
					"options"     => array(
						1 => __( '1 Column', 'better-studio' ),
						2 => __( '2 Column', 'better-studio' ),
						3 => __( '3 Column', 'better-studio' ),
					),
					'group'       => __( 'General', 'better-studio' ),
					'show_on'     => array(
						array( 'type=campaign' ),
					)
				),
				array(
					"type"        => 'bf_select',
					"admin_label" => FALSE,
					"heading"     => __( 'Order By', 'better-studio' ),
					"param_name"  => 'orderby',
					"value"       => $this->defaults['orderby'],
					"options"     => array(
						'date'  => __( 'Date', 'better-studio' ),
						'title' => __( 'Title', 'better-studio' ),
						'rand'  => __( 'Rand', 'better-studio' ),
					),
					'group'       => __( 'General', 'better-studio' ),
					'show_on'     => array(
						array( 'type=campaign' ),
					)
				),
				array(
					"type"        => 'bf_select',
					"admin_label" => FALSE,
					"heading"     => __( 'Order', 'better-studio' ),
					"param_name"  => 'order',
					"value"       => $this->defaults['order'],
					"options"     => array(
						'ASC'  => __( 'Ascending', 'better-studio' ),
						'DESC' => __( 'Descending', 'better-studio' ),
					),
					'group'       => __( 'General', 'better-studio' ),
					'show_on'     => array(
						array( 'type=campaign' ),
					)
				),
				array(
					"type"        => 'bf_select',
					"admin_label" => FALSE,
					"heading"     => __( 'Align', 'better-studio' ),
					"param_name"  => 'align',
					"value"       => $this->defaults['align'],
					"options"     => array(
						'left'   => __( 'Left', 'better-studio' ),
						'center' => __( 'Center', 'better-studio' ),
						'right'  => __( 'Right', 'better-studio' ),
					),
					'group'       => __( 'General', 'better-studio' ),
					'show_on'     => array(
						array( 'type=campaign' ),
						array( 'type=banner' ),
					)
				),
				array(
					"type"        => 'bf_select',
					"admin_label" => FALSE,
					"heading"     => __( 'Show Captions', 'better-studio' ),
					"param_name"  => 'show-caption',
					"value"       => $this->defaults['show-caption'],
					"options"     => array(
						1 => __( 'Show caption\'s', 'better-studio' ),
						0 => __( 'Hide caption\'s', 'better-studio' ),
					),
					'group'       => __( 'General', 'better-studio' ),
					'show_on'     => array(
						array( 'type=campaign' ),
						array( 'type=banner' ),
					)
				),


				// Design Options Tab
				array(
					"type"        => 'textfield',
					"admin_label" => FALSE,
					"heading"     => __( 'Title', 'better-studio' ),
					"param_name"  => 'title',
					"value"       => $this->defaults['title'],
					'group'       => __( 'Design options', 'better-studio' ),
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
			)
		) );

	} // register_vc_add_on

}
