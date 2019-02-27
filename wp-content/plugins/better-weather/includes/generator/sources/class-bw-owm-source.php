<?php


/**
 * Class BW_OWM_Source
 */
class BW_OWM_Source extends BW_Weather_Source {

	/**
	 * Source constructor
	 *
	 * @param string $app_id
	 * @param string $api_key
	 * @param string $lang
	 */
	public function __construct( $app_id = '', $api_key = '', $lang = '' ) {
		$this->source_id = 'owm';
		parent::__construct( $app_id, $api_key, $lang );
	}


	/**
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
	 *          summary
	 *          icon
	 *          temperature
	 *          temperature_min
	 *          temperature_max
	 *          sunrise_time
	 *          sunset_time
	 *
	 * location[]
	 *      country
	 *      city
	 *      latitude
	 *      longitude
	 *
	 *
	 * @param        $location
	 * @param string $unit
	 *
	 * @return array
	 */
	function get_forecast( $location, $unit = 'c' ) {

		// Check API Key
		if ( $this->get_api_key() == '' ) {
			return array(
				'status' => 'error',
				'title'  => __( 'No API Key', 'better-studio' ),
				'msg'    => __( 'Obtain API Key from http://openweathermap.org/appid', 'better-studio' ),
				'data'   => 'no data'
			);
		}

		$location = explode( ',', $location );

		// Creates temperature unit
		switch ( $unit ) {

			case 'C':
			case 'c':
				$unit = 'metric';
				break;

			case 'F':
			case 'f':
				$unit = 'imperial';
				break;


			default:
				$unit = 'metric';
				break;
		}

		// Params of URL
		$url_parts = array(
			'lat=' . urlencode( $location[0] ),
			'lon=' . urlencode( $location[1] ),
			'lang=' . $this->get_lang(),
			'cnt=' . 60,
			'units=' . $unit,
			'appid=' . $this->get_api_key(),
		);

		// final URL
		$url = 'http://api.openweathermap.org/data/2.5/forecast?' . implode( '&', $url_parts );

		$r_resp = $this->get_remote_data( $url );

		if ( wp_remote_retrieve_response_code( $r_resp ) != 200 ) {
			return array(
				'status' => 'error',
				'title'  => __( 'API key is incorrect', 'better-studio' ),
				'msg'    => __( 'Please obtain API Key from https://developers.forecast.io/', 'better-studio' ),
				'data'   => __( 'no data', 'better-studio' )
			);
		}

		if ( is_wp_error( $r_resp ) ) {
			if ( is_wp_error( $r_resp ) || ! isset( $r_resp['body'] ) || $r_resp['body'] == FALSE ) {
				return array(
					'status' => 'error',
					'title'  => __( 'Connection Error', 'better-studio' ),
					'msg'    => __( 'Error getting remote data for today forecast. Please check your server configuration', 'better-studio' ),
					'data'   => $r_resp
				);
			}
		}


		// Try to decode the json
		$r_body = @json_decode( wp_remote_retrieve_body( $r_resp ), TRUE );
		if ( $r_body === NULL and json_last_error() !== JSON_ERROR_NONE ) {
			return array(
				'status' => 'error',
				'title'  => __( 'Data Error', 'better-studio' ),
				'msg'    => __( 'Error decoding the json from OpenWeatherMap', 'better-studio' ),
				'data'   => $r_resp
			);
		}


		// Validate location
		if ( $r_body['cod'] != 200 ) {
			return array(
				'status' => 'error',
				'title'  => __( 'Incorrect Location', 'better-studio' ),
				'msg'    => __( 'Entered location ( lat and lang ) is incorrect', 'better-studio' ),
				'data'   => $r_body
			);
		}

		$output = array();

		//
		// Location
		//
		$output['location']['longitude'] = $r_body['city']['coord']['lon'];
		$output['location']['latitude']  = $r_body['city']['coord']['lat'];
		$output['location']['country']   = $this->pretty_name( $r_body['city']['country'] );
		$output['location']['city']      = $this->pretty_name( $r_body['city']['name'] );


		//
		// Today data
		//
		$day                                = current( $r_body['list'][0]['sys'] ) == 'n' ? FALSE : TRUE;
		$output['today']['time']            = $r_body['list'][0]['dt'];
		$output['today']['time_r']          = $this->get_date_translation( $output['today']['time'] );
		$output['today']['summary']         = $this->get_translation( $r_body['list'][0]['weather'][0]['description'] );
		$output['today']['icon']            = $this->get_standard_icon( $r_body['list'][0]['weather'][0]['id'], $day );
		$output['today']['temperature']     = $r_body['list'][0]['main']['temp'];
		$output['today']['temperature_min'] = $r_body['list'][0]['main']['temp_min'];
		$output['today']['temperature_max'] = $r_body['list'][0]['main']['temp_max'];
		$output['today']['sunrise_time']    = '';
		$output['today']['sunset_time']     = '';

		//
		// Next Days
		//
		$date_flag = date( 'D', $output['today']['time'] );
		$counter   = 0;
		foreach ( $r_body['list'] as $day_id => $day ) {

			if ( $date_flag == date( 'D', $day['dt'] ) ) {
				continue;
			} else {
				$date_flag = date( 'D', $day['dt'] );
			}

			if ( $counter > 4 ) {
				break;
			} else {
				$counter ++;
			}

			$output['next_days'][ $counter ] = array(
				'time'            => $day['dt'],
				'time_r'          => $this->get_date_translation( $day['dt'] ),
				'day_name'        => $this->get_day_translation( $day['dt'] ),
				'summary'         => $this->get_translation( $day['weather'][0]['description'] ),
				'icon'            => $this->get_standard_icon( $day['weather'][0]['id'] ),
				'temperature'     => $day['main']['temp'],
				'temperature_min' => $day['main']['temp_min'],
				'temperature_max' => $day['main']['temp_max'],
				'sunrise_time'    => '',
				'sunset_time'     => '',
			);
		}

		return array(
			'status' => 'succeed',
			'data'   => $output,
		);

	} // get_remote_data_forecast_io


	/**
	 * Creates standard icons from OWM weather condition code
	 *
	 * http://openweathermap.org/weather-conditions
	 *
	 * @param $condition_code
	 *
	 * @return string
	 */
	function get_standard_icon( $condition_code, $day = TRUE ) {

		switch ( TRUE ) {

			case $condition_code == 955: // fresh breeze
			case $condition_code == 954: // moderate breeze
			case $condition_code == 953: // gentle breeze
			case $condition_code == 952: // light breeze
			case $condition_code == 951: // calm
			case $condition_code == 904: // hot
			case $condition_code == 903: // cold
			case $condition_code == 800: // clear
				if ( $day ) {
					$_icon = 'clear-day';
				} else {
					$_icon = 'clear-night';
				}
				break;


			case $condition_code == 611: // hail
			case $condition_code >= 300 && $condition_code < 400: // Drizzle
			case $condition_code >= 500 && $condition_code < 600: // Rain
				$_icon = 'rain';
				break;


			case $condition_code == 906: // Sleet
			case $condition_code >= 600 && $condition_code < 700: // Snow
				$_icon = 'snow';
				break;


			case $condition_code == 902: // tornado
			case $condition_code == 901: // tornado
			case $condition_code == 900: // tornado
			case $condition_code == 962: // hurricane
			case $condition_code == 961: // violent storm
			case $condition_code == 960: // storm
			case $condition_code == 959: // severe gale
			case $condition_code == 958: // gale
			case $condition_code == 956: // strong breeze
			case $condition_code == 957: // high wind, near gale
			case $condition_code == 905: // windy
				$_icon = 'wind';
				break;


			case $condition_code >= 200 && $condition_code < 300: // Thunderstorm
				$_icon = 'thunderstorm';
				break;


			case $condition_code == 801: // few clouds
			case $condition_code == 802: // scattered clouds
				if ( $day ) {
					$_icon = 'partly-cloudy-day';
				} else {
					$_icon = 'partly-cloudy-night';
				}
				break;


			case $condition_code >= 700 && $condition_code < 800: // Atmosphere | Fog
				$_icon = 'fog';
				break;

			case $condition_code >= 800 && $condition_code < 810: // Clouds + fallback for new
				$_icon = 'cloudy';
				break;

			default:
				$_icon = '';

		}

		return $_icon;

	} // get_standard_icon

}