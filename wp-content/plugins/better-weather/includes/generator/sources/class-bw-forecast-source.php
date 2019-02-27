<?php


/**
 * Source for Forecast.io
 */
class BW_Forecast_Source extends BW_Weather_Source {

	/**
	 * Source constructor
	 *
	 * @param string $app_id
	 * @param string $api_key
	 * @param string $lang
	 */
	public function __construct( $app_id = '', $api_key = '', $lang = '' ) {
		$this->source_id = 'forecast';
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
				'msg'    => __( 'Obtain API Key from https://developers.forecast.io/', 'better-studio' ),
				'data'   => 'no data'
			);
		}

		$url = 'https://api.forecast.io/forecast/' . $this->get_api_key() . '/' . $location . '?exclude=hourly,flags,alerts,minutely';

		// retrieving forecast content
		$r_resp = $this->get_remote_data( $url );

		// Connection Error
		if ( is_wp_error( $r_resp ) || ! isset( $r_resp['body'] ) || $r_resp['body'] == FALSE ) {
			return array(
				'status' => 'error',
				'title'  => __( 'Connection Error', 'better-studio' ),
				'msg'    => __( 'No any data received from Forecast.io!.', 'better-studio' ),
				'data'   => $r_resp
			);
		}

		// incorrect API Key
		if ( wp_remote_retrieve_response_code( $r_resp ) != 200 || preg_match( '~Forbidden~A', $r_resp['body'] ) > 0 ) {
			return array(
				'status' => 'error',
				'title'  => __( 'API key is incorrect', 'better-studio' ),
				'msg'    => __( 'Please obtain API Key from https://developers.forecast.io/', 'better-studio' ),
				'data'   => __( 'no data', 'better-studio' )
			);
		}

		$r_body = @json_decode( wp_remote_retrieve_body( $r_resp ), TRUE );
		if ( $r_body === NULL and json_last_error() !== JSON_ERROR_NONE ) {
			return array(
				'status' => 'error',
				'title'  => __( 'Data Error', 'better-studio' ),
				'msg'    => __( 'Error decoding the json from Forecast.io', 'better-studio' ),
				'data'   => $r_resp
			);
		}

		// Hack for getting today min/max temperature and sunset sunrise time!
		if ( date( 'Y M d', $r_body['daily']['data'][0]['time'] ) == date( 'Y M d', $r_body['currently']['time'] ) ) {
			$past_day_data = $r_body['daily']['data'][0];
		} else {
			$_past_day_data = $this->get_remote_data( 'https://api.forecast.io/forecast/' . $this->get_api_key() . '/' . $location . ',' . strtotime( "-1 day", time() ) . '?exclude=currently,hourly,flags,alerts,minutely' );
			$_past_day_body = @json_decode( wp_remote_retrieve_body( $_past_day_data ), TRUE );

			if ( $_past_day_body === NULL and json_last_error() !== JSON_ERROR_NONE ) {
				$past_day_data = $r_body['daily']['data'][0];
			} else {
				$past_day_data = $_past_day_body['daily']['data'][0];
			}
		}

		//
		// Create result standard data
		//
		$result = array();


		//
		// Location
		//
		$result['location']['latitude']  = $r_body['latitude'];
		$result['location']['longitude'] = $r_body['longitude'];
		$timezone                        = explode( '/', $r_body['timezone'] );
		if ( isset( $timezone[0] ) ) {
			$result['location']['country'] = $this->pretty_name( $timezone[0] );
		} else {
			$result['location']['country'] = '';
		}

		if ( isset( $timezone[1] ) ) {
			$result['location']['city'] = $this->pretty_name( $timezone[1] );
		} else {
			$result['location']['city'] = '';
		}

		//
		// Today
		//
		$result['today']['time']            = $r_body['currently']['time'];
		$result['today']['time_r']          = $this->get_date_translation( $result['today']['time'] );
		$result['today']['summary']         = $this->get_translation( $r_body['currently']['summary'] );
		$result['today']['icon']            = $r_body['currently']['icon'];
		$result['today']['temperature']     = $this->convert_fahrenheit_to_celsius( $r_body['currently']['temperature'] );
		$result['today']['temperature_min'] = $this->convert_fahrenheit_to_celsius( $past_day_data['temperatureMin'] );
		$result['today']['temperature_max'] = $this->convert_fahrenheit_to_celsius( $past_day_data['temperatureMax'] );
		$result['today']['sunrise_time']    = $past_day_data['sunriseTime'];
		$result['today']['sunset_time']     = $past_day_data['sunsetTime'];


		//
		// Next days
		//
		$counter = - 1;

		unset( $r_body['daily']['data'][0] );

		foreach ( $r_body['daily']['data'] as $day ) {

			if ( $counter == - 1 ) {
				$counter ++;
				continue;
			}

			if ( $counter > 4 ) {
				break;
			} else {
				$counter ++;
			}

			$result['next_days'][ $counter ] = array(
				'time'            => $day['time'],
				'time_r'          => $this->get_date_translation( $day['time'] ),
				'day_name'        => $this->get_day_translation( $day['time'] ),
				'summary'         => $this->get_translation( $day['summary'] ),
				'icon'            => $day['icon'],
				'temperature'     => '',
				'temperature_min' => $day['temperatureMin'],
				'temperature_max' => $day['temperatureMax'],
				'sunrise_time'    => $day['sunriseTime'],
				'sunset_time'     => $day['sunriseTime'],
			);
		}

		return array(
			'status' => 'succeed',
			'data'   => $result,
		);

	} // get_remote_data_forecast_io


	/**
	 * Used to get translation id of string in panel
	 *
	 * @param $text
	 *
	 * @return string
	 */
	public function get_trans_id( $text ) {

		$id = str_replace(
			array( ".", "/", "\\", ",", " ", "-" ),
			"_",
			trim( $text )
		);

		return strtolower( 'tr_forecast_' . $id );
	}

}