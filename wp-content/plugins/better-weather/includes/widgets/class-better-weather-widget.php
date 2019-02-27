<?php

/**
 * Recent Tab Widget
 */
class Better_Weather_Widget extends BF_Widget {

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
				'name'          => __( 'Custom Location Name:', 'better-studio' ),
				'attr_id'       => 'locationName',
				'type'          => 'text',
				'section_class' => 'widefat',
			),

			array(
				'name'    => __( 'Show Location Name?', 'better-studio' ),
				'attr_id' => 'showLocation',
				'type'    => 'checkbox',
			),

			array(
				'name'    => __( 'Show Date?', 'better-studio' ),
				'attr_id' => 'showDate',
				'type'    => 'checkbox',
			),

			array(
				'name'          => __( 'Widget Style', 'better-studio' ),
				'attr_id'       => 'widgetStyle',
				'type'          => 'select',
				'section_class' => 'widefat',
				"options"       => array(
					'modern' => __( 'Modern Style', 'better-studio' ),
					'normal' => __( 'Normal Style', 'better-studio' ),
				),
			),

			array(
				'name'    => __( 'Show Next 4 Days Forecast!?', 'better-studio' ),
				'attr_id' => 'nextDays',
				'type'    => 'checkbox',
			),

			array(
				'name'          => __( 'Background Style', 'better-studio' ),
				'attr_id'       => 'bgType',
				'type'          => 'select',
				'section_class' => 'widefat',
				"options"       => array(
					'natural' => __( 'Natural Photo', 'better-studio' ),
					'static'  => __( 'Static Color', 'better-studio' ),
				),
			),

			array(
				'name'    => __( 'Background Color', 'better-studio' ),
				'attr_id' => 'bgColor',
				'type'    => 'color',
			),

			array(
				'name'          => __( 'Icons Style', 'better-studio' ),
				'attr_id'       => 'iconsType',
				'type'          => 'select',
				'section_class' => 'widefat',
				"options"       => array(
					'animated' => __( 'Animated Icon', 'better-studio' ),
					'static'   => __( 'Static Icon', 'better-studio' ),
				),
			),

			array(
				'name'    => __( 'Font Color', 'better-studio' ),
				'attr_id' => 'fontColor',
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
				'attr_id' => 'showUnit',
				'type'    => 'checkbox',
			),

			array(
				'name'    => __( 'Show Visitors Location Status!?', 'better-studio' ),
				'attr_id' => 'visitorLocation',
				'type'    => 'checkbox',
				'desc'    => '<span style="display: block;color: #FF5353;">' . __( 'Before using this you should read <a target="_blank" href="http://better-studio.net/plugins/better-weather/wp/#requests-note">this note</a>', 'better-studio' ) . '</span>',
			),


		);

		parent::__construct(
			'BetterWeather',
			__( 'Better Weather', 'better-studio' ),
			array( 'description' => __( 'Boxed Weather Widget', 'better-studio' ) ),
			'better_weather_widget'
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

		$instance['style'] = $instance['widgetStyle'];

		if ( $instance['bgType'] == 'static' ) {
			$instance['naturalBackground'] = FALSE;
		}

		if ( $instance['iconsType'] == 'static' ) {
			$instance['animatedIcons'] = FALSE;
		}

		BW_Generator_Factory::generator()->generate( $instance );

		echo $args['after_widget'];
	}


}