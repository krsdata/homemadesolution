<?php

/**
 * Generate all front end codes for better weather
 *
 * IMPORTANT NOTE: Do not create directly instance from this class! just use BW_Generator_Factory factory for getting
 * instance
 */
class BW_Frontend {


	/**
	 * Stores all widgets
	 * @var array
	 */
	var $widgets = array();


	function init() {
	}


	/**
	 * Used for generating HTML attribute string
	 *
	 * @param string $id
	 * @param string $val
	 *
	 * @return string
	 */
	private function html_attr( $id = '', $val = '' ) {

		if ( is_array( $val ) ) {

			$temp_attr = '';

			foreach ( $val as $_attr_id => $_attr_value ) {
				$temp_attr .= ' ' . $_attr_value;
			}

			return $id . '="' . $temp_attr . '"';

		} else {
			return $id . '="' . $val . '"';
		}

	}


	/**
	 * Generates full attr
	 *
	 * @param $attr
	 *
	 * @return string
	 */
	private function html_attr_full( $attr ) {

		$final_attr = '';

		foreach ( $attr as $attr_id => $attr_value ) {
			$final_attr .= ' ' . $this->html_attr( $attr_id, $attr_value );
		}

		return $final_attr;
	}


	/**
	 * Generate widget
	 *
	 * @param      $options
	 * @param bool $echo
	 *
	 * @return mixed|void
	 */
	function generate( $options, $echo = TRUE ) {

		ob_start();

		$id                   = $this->get_unique_id();
		$this->widgets[ $id ] = $options;

		$attr       = array();
		$attr['id'] = $id;

		/*
		 * today[]
		 *      time
		 *      summary
		 *      icon
		 *      temperature
		 *      temperature_max
		 *      temperature_min
		 *      sunrise_time
		 *      sunset_time
		 *
		 *
		 * next_days[]
		 *      []
		 *          time
		 *          day_name
		 *          icon
		 *
		 * location[]
		 *      country
		 *      city
		 *      latitude
		 *      longitude
		 */

		$data = $this->get_forecast_data( $options );


		if ( $data['status'] != 'succeed' ) {

			?>
			<div class="better-weather">
				<div class="bw-error">
					<p class="bw-error-sign">&#x26a0;</p>
					<p class="bw-error-title"><?php echo $data['title']; ?></p>
					<p class="bw-error-text"><?php echo $data['msg']; ?></p>
				</div>
			</div>
			<?php

			if ( $echo ) {
				echo ob_get_clean();

				return;
			} else {
				return ob_get_clean();
			}

		}


		// Location name
		if ( ! $options['showLocation'] ) {
			$location_name = FALSE;
		} elseif ( $options['locationName'] ) {
			$location_name = $options['locationName'];
		} else {
			if ( ! empty( $data['data']['location']['city'] ) ) {
				$location_name = $data['data']['location']['city'];
			} elseif ( ! empty( $data['data']['location']['country'] ) ) {
				$location_name = $data['data']['location']['country'];
			} else {
				$location_name = FALSE; // hide it
			}

		}

		// Date
		if ( ! $options['showDate'] ) {
			$date = FALSE;
		} else {
			$date = $data['data']['today']['time_r'];
		}

		// Animated Icon
		$animated_icon = isset( $options['animatedIcons'] ) ? $options['animatedIcons'] : TRUE;
		if ( $animated_icon ) {
			$attr['class'][] = 'animated-icons';
		} else {
			$attr['class'][] = 'static-icons';
		}


		$options['mode'] = 'block';
		$attr['class'][] = 'better-weather';

		if ( $options['style'] == 'normal' ) {
			$attr['class'][] = 'style-normal';
		} else {
			$attr['class'][] = 'style-modern';
		}

		if ( ! isset( $options['naturalBackground'] ) ) {
			$attr['class'][] = 'with-natural-background';
		} elseif ( $options['naturalBackground'] ) {
			$attr['class'][] = 'with-natural-background';
		} else {
			$attr['style'][] = 'background-color:' . $options['bgColor'] . ';';
		}

		if ( $options['nextDays'] ) {
			$attr['class'][] = 'have-next-days';
		}

		// Show unit
		if ( $options['showUnit'] ) {
			$attr['class'][] = 'unit-showed';
		}

		// todo sunrise time!
		$attr['class'][] = 'state-' . $data['data']['today']['icon'];

		// Icon color & font color
		$attr['style'][]         = 'color:' . $options['fontColor'] . ';';
		$attr['data-font-color'] = $options['fontColor'];

		?>
		<div <?php echo $this->html_attr_full( $attr ); ?>>
			<div class="bw_currently">
				<div class="bw_date-loc">
					<?php if ( $location_name ) { ?>
						<span class="bw_location"><?php echo $location_name; ?></span>
					<?php } ?>

					<?php if ( $location_name && $date ) { ?>
						<span class="bw_separator">-</span>
					<?php } ?>

					<?php if ( $date ) { ?>
						<span class="bw_date"><?php echo $date; ?></span>
					<?php } ?>
				</div>

				<?php if ( $options['mode'] != 'inline' ) { ?>
					<div class="bw_degree-up-down">
						<span
							class="bw_up-degree"><?php echo $this->get_pretty_temperature( $data['data']['today']['temperature_max'], $options['unit'], $options['showUnit'] ); ?></span>
						<span
							class="bw_down-degree"><?php echo $this->get_pretty_temperature( $data['data']['today']['temperature_min'], $options['unit'], $options['showUnit'] ); ?></span>
					</div>

					<div class="bw_summary">
						<?php if ( $options['style'] == 'normal' ) { ?>
							<span
								class="bw_icon-container"><?php echo $this->get_icon_tag( $animated_icon, $id . '-summary-icon', $data['data']['today']['icon'], 85, 85 ); ?></span>
						<?php } else { ?>
							<span
								class="bw_icon-container"><?php echo $this->get_icon_tag( $animated_icon, $id . '-summary-icon', $data['data']['today']['icon'], 75, 75 ); ?></span>
						<?php } ?>
						<p><?php echo $data['data']['today']['summary']; ?></p>
					</div>

					<div class="bw_degree">
						<p><?php echo $this->get_pretty_temperature( $data['data']['today']['temperature'], $options['unit'], $options['showUnit'] ); ?></p>
					</div>

				<?php } else { ?>

					<span
						class="bw_icon-container"><?php echo $this->get_icon_tag( $animated_icon, $id . '-summary-icon', $data['data']['today']['icon'] ); ?></span>
					<span
						class="bw_temperature"><p><?php echo $this->get_pretty_temperature( $data['data']['today']['temperature'], $options['unit'], $options['showUnit'] ); ?></p></span>
					<span class="bw_summary"><p><?php echo $data['data']['today']['summary']; ?></p></span>

				<?php } ?>

			</div>

			<?php if ( $options['nextDays'] ) { ?>
				<div class="bw_days">
					<ul class="bw_days-list">
						<li class="bw_day-item bw_day-1">
							<p class="bw_day-title"><?php echo $data['data']['next_days'][1]['day_name']; ?></p>
							<span
								class="bw_icon-container"><?php echo $this->get_icon_tag( FALSE, $id . '-day1-icon', $data['data']['next_days'][1]['icon'], 17, 17 ); ?></span>
						</li>
						<li class="bw_day-item bw_day-2">
							<p class="bw_day-title"><?php echo $data['data']['next_days'][2]['day_name']; ?></p>
							<span
								class="bw_icon-container"><?php echo $this->get_icon_tag( FALSE, $id . '-day2-icon', $data['data']['next_days'][2]['icon'], 17, 17 ); ?></span>
						</li>
						<li class="bw_day-item bw_day-3">
							<p class="bw_day-title"><?php echo $data['data']['next_days'][3]['day_name']; ?></p>
							<span
								class="bw_icon-container"><?php echo $this->get_icon_tag( FALSE, $id . '-day3-icon', $data['data']['next_days'][3]['icon'], 17, 17 ); ?></span>
						</li>
						<li class="bw_day-item bw_day-4">
							<p class="bw_day-title"><?php echo $data['data']['next_days'][4]['day_name']; ?></p>
							<span
								class="bw_icon-container"><?php echo $this->get_icon_tag( FALSE, $id . '-day4-icon', $data['data']['next_days'][4]['icon'], 17, 17 ); ?></span>
						</li>
					</ul>
				</div>
				<?php

			}
			?>
			<div class="bw-loader">
				<div class="bw-loader-icon"></div>
			</div>
		</div>
		<?php

		if ( $echo ) {
			echo ob_get_clean();
		} else {
			return ob_get_clean();
		}
	}


	/**
	 * Generate widget
	 *
	 * @param      $options
	 * @param bool $echo
	 *
	 * @return mixed|void
	 */
	function generate_inline( $options, $echo = TRUE ) {


		ob_start();

		$id                   = $this->get_unique_id();
		$this->widgets[ $id ] = $options;

		$attr       = array();
		$attr['id'] = $id;


		/*
		 * today[]
		 *      time
		 *      summary
		 *      icon
		 *      temperature
		 *      temperature_max
		 *      temperature_min
		 *      sunrise_time
		 *      sunset_time
		 *
		 *
		 * next_days[]
		 *      []
		 *          time
		 *          day_name
		 *          icon
		 *
		 * location[]
		 *      country
		 *      city
		 *      latitude
		 *      longitude
		 */
		$data = $this->get_forecast_data( $options );


		if ( $data['status'] != 'succeed' ) {
			return;
		}

		// Animated Icon
		$animated_icon = isset( $options['animatedIcons'] ) ? $options['animatedIcons'] : TRUE;
		$width         = $height = '';
		if ( $animated_icon ) {

			$attr['class'][] = 'animated-icons';

			switch ( $options['inlineSize'] ) {
				case 'small':
					$width = $height = 18;
					break;
				case 'medium':
					$width = $height = 30;
					break;
				case 'large':
					$width = $height = 55;
					break;
			}

		} else {
			$attr['class'][] = 'static-icons';
		}

		// Create attr array
		$attr['class'][] = 'better-weather-inline';

		// Show unit
		if ( $options['showUnit'] ) {
			$attr['class'][] = 'unit-showed';
		}

		// size
		$attr['data-inline-size'] = $options['inlineSize'];
		$attr['class'][]          = 'bw_size-' . $options['inlineSize'];

		// todo sunrise time!
		//        $attr['class'][] = 'state-' . $data['data']['today']->icon;

		// Icon color & font color
		$attr['style'][]         = 'color:' . $options['fontColor'] . ';';
		$attr['data-font-color'] = $options['fontColor'];

		?>
		<span <?php echo $this->html_attr_full( $attr ); ?>>
		    <span
			    class="bw_icon-container"><?php echo $this->get_icon_tag( $animated_icon, $id . '-summary-icon', $data['data']['today']['icon'], $width, $height ); ?></span>
		    <span
			    class="bw_temperature"><?php echo $this->get_pretty_temperature( $data['data']['today']['temperature'], $options['unit'], $options['showUnit'] ); ?></span>
		    <span class="bw_summary"><?php echo $data['data']['today']['summary']; ?></span>
		</span>
		<?php

		if ( $echo ) {
			echo ob_get_clean();
		} else {
			return ob_get_clean();
		}
	}


	/**
	 * Used to get icon
	 *
	 * @param        $animated
	 * @param string $id
	 * @param string $icon
	 * @param string $width
	 * @param string $height
	 *
	 * @return string
	 */
	function get_icon_tag( $animated, $id = '', $icon = '', $width = '', $height = '' ) {

		if ( $animated ) {

			switch ( $icon ) {
				case 'thunderstorm':
					return $this->get_icon_tag( FALSE, $id, $icon, $width, $height );
					break;
			}

			if ( $width != '' ) {
				return '<canvas id="' . $id . '" class="bw_icon bw_svg-icon" style="height:' . $height . 'px; width:' . $width . 'px;" data-icon="' . $icon . '"></canvas>';
			} else {
				return '<canvas id="' . $id . '" class="bw_icon bw_svg-icon" data-icon="' . $icon . '"></canvas>';
			}

		} else {

			switch ( $icon ) {
				case 'clear-day':
					$_icon = 'wi-day-sunny';
					break;

				case 'clear-night':
					$_icon = 'wi-night-clear';
					break;

				case 'rain':
					$_icon = 'wi-rain';
					break;

				case 'snow':
					$_icon = 'wi-snow';
					break;

				case 'sleet':
					$_icon = 'wi-rain';
					break;

				case 'wind':
					$_icon = 'wi-strong-wind';
					break;

				case 'thunderstorm':
					$_icon = 'wi-lightning';
					break;

				case 'cloudy':
					$_icon = 'wi-cloudy';
					break;

				case 'partly-cloudy-day':
					$_icon = 'wi-day-cloudy';
					break;

				case 'partly-cloudy-night':
					$_icon = 'wi-night-cloudy';
					break;

				case 'fog':
					$_icon = 'wi-fog';
					break;
			}

			return '<span id="' . $id . '" class="bw_icon hw_static-icon bw_partly-cloudy-day" ><i class="' . $_icon . '"></i></span>';

		}

	} // get_icon_tag


	/**
	 * Converts temp to pretty value!
	 *
	 * @param        $temperature
	 * @param string $unit
	 * @param bool   $show_unit
	 *
	 * @return string
	 */
	function get_pretty_temperature( $temperature, $unit = 'C', $show_unit = FALSE ) {

		$unit = strtolower( $unit );

		if ( $unit == 'f' ) {
			return intval( $this->convert_celsius_to_fahrenheit( $temperature ) ) . '°' . ( $show_unit ? ' F' : '' );
		} else {
			return intval( $temperature ) . '°' . ( $show_unit ? ' C' : '' );
		}

	}


	/**
	 * Used to convert Fahrenheit to Celsius
	 *
	 * @param $temp
	 *
	 * @return int
	 */
	function convert_fahrenheit_to_celsius( $temp ) {
		return intval( ( $temp - 32 ) * 5 / 9 );
	}


	/**
	 * Used to convert Fahrenheit to Celsius
	 *
	 * @param $temp
	 *
	 * @return int
	 */
	function convert_celsius_to_fahrenheit( $temp ) {
		return $temp * 9 / 5 + 32;
	}


	/**
	 * Generate unique id widgets
	 *
	 * @return string
	 */
	function get_unique_id() {
		return 'bw-' . uniqid();
	}


	/**
	 * Retrieved data from Forecast.io or cache and return it
	 *
	 * @param $options
	 *
	 * @return array
	 */
	public function get_forecast_data( $options ) {

		// Check location
		if ( isset( $options["location"] ) && $options["location"] != "" ) {
			$location = $options["location"];
		} else {
			$location = "35.6705,139.7409";
		}

		// Visitor location
		if ( isset( $options["visitorLocation"] ) && $options["visitorLocation"] ) {
			$_l = Better_Weather::get_user_geo_location();

			if ( ! empty( $_l ) ) {
				$visitor_location = TRUE;
				$location         = $_l;
			}

		} else {
			$visitor_location = FALSE;
		}

		$api_source = Better_Weather::get_api_source();

		// If cache is older than 30min, get new data or error if triggered
		if ( ( $data = get_transient( 'bw_location_' . $api_source . '_' . str_replace( ',', '-', $location ) ) ) === FALSE || $visitor_location == TRUE ) {
			$options = new BW_Forecast_Facade();
			$data    = $options->get_forecast( $location );

			if ( $data['status'] == 'succeed' ) {
				set_transient(
					'bw_location_' . $api_source . '_' . str_replace( ',', '-', $location ),
					$data,
					MINUTE_IN_SECONDS * Better_Weather::get_option( 'cache_time' )
				);
			}
		}

		return $data;

	} // get_forecast_data

}
