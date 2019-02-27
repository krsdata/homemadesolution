<?php

/**
 * Better Weather Inline Widget
 */
class Better_Weather_Inline_Widget extends BF_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {

		// Back end form fields
		$this->fields = array(

			array(
				'name'          => __( 'Title', 'better-studio' ),
				'attr_id'       => 'title',
				'type'          => 'text',
				'section_class' => 'widefat',
			),

			array(
				'name'          => __( 'Location', 'better-studio' ),
				'attr_id'       => 'location',
				'type'          => 'text',
				'section_class' => 'widefat',
				'desc'          => '<a target="_blank" href="http://better-studio.net/plugins/better-weather/wp/#how-to-find-location">' . __( 'How to find location value!?', 'better-studio' ) . '</a>',
			),

			array(
				'name'          => __( 'Widget Size', 'better-studio' ),
				'attr_id'       => 'inline_size',
				'type'          => 'select',
				'section_class' => 'widefat',
				"options"       => array(
					'large'  => __( 'Large Style', 'better-studio' ),
					'medium' => __( 'Medium Style', 'better-studio' ),
					'small'  => __( 'Small Style', 'better-studio' ),
				),
			),

			array(
				'name'          => __( 'Icons Style', 'better-studio' ),
				'attr_id'       => 'icons_type',
				'type'          => 'select',
				'section_class' => 'widefat',
				"options"       => array(
					'animated' => __( 'Animated Icon', 'better-studio' ),
					'static'   => __( 'Static Icon', 'better-studio' ),
				),
			),

			array(
				'name'    => __( 'Font Color', 'better-studio' ),
				'attr_id' => 'font_color',
				'type'    => 'color',
			),

			array(
				'name'          => __( 'Temperature Unit', 'better-studio' ),
				'attr_id'       => 'unit',
				'type'          => 'select',
				'section_class' => 'widefat',
				"options"       => array(
					'C' => __( 'Celsius', 'better-studio' ),
					'F' => __( 'Fahrenheit', 'better-studio' ),
				),
			),

			array(
				'name'    => __( 'Show Temperature Unit?', 'better-studio' ),
				'attr_id' => 'show_unit',
				'type'    => 'checkbox',
			),

			array(
				'name'    => __( 'Show Visitors Location Status!?', 'better-studio' ),
				'attr_id' => 'visitor_location',
				'type'    => 'checkbox',
				'desc'    => '<span style="display: block;color: #FF5353;">' . __( 'Before using this you should read <a target="_blank" href="http://better-studio.net/plugins/better-weather/wp/#requests-note">this note</a>', 'better-studio' ) . '</span>',
			),

		);

		parent::__construct(
			'BetterWeather-inline',
			__( 'Better Weather Inline', 'better-studio' ),
			array( 'description' => __( 'Inline Weather Widget', 'better-studio' ) )
		);
	}


	/**
	 * Front-end display of widget.
	 *
	 * @see BetterWidget::widget()
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		$instance = $this->parse_args( $this->defaults, $instance );


		echo $args['before_widget'];

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->base_widget_id );
		if ( ! empty( $title ) && $this->with_title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$options = array(
			"showLocation"    => TRUE,
			"locationName"    => '',
			"showDate"        => TRUE,
			"nextDays"        => FALSE,
			"location"        => isset( $instance['location'] ) ? $instance['location'] : '',
			"fontColor"       => isset( $instance['font_color'] ) ? $instance['font_color'] : '#606568',
			"visitorLocation" => isset( $instance['visitor_location'] ) ? $instance['visitor_location'] : FALSE,
			"inlineSize"      => isset( $instance['inline_size'] ) ? $instance['inline_size'] : 'medium',
			"unit"            => isset( $instance['unit'] ) ? $instance['unit'] : 'C',
			"iconsType"       => isset( $instance['icons_type'] ) ? $instance['icons_type'] : 'animated',
			"showUnit"        => isset( $instance['show_unit'] ) ? $instance['show_unit'] : 'off',
			"mode"            => 'inline',
		);

		if ( $options['iconsType'] == 'static' ) {
			$options['animatedIcons'] = FALSE;
		}

		BW_Generator_Factory::generator()->generate_inline( $options );

		echo $args['after_widget'];
	}


}