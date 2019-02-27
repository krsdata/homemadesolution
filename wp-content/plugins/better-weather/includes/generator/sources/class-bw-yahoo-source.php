<?php


/**
 * Class BW_Yahoo_Source
 */
class BW_Yahoo_Source extends BW_Weather_Source {

	/**
	 * Source constructor
	 *
	 * @param string $app_id
	 * @param string $api_key
	 * @param string $lang
	 */
	public function __construct( $app_id = '', $api_key = '', $lang = '' ) {
		$this->source_id = 'yahoo';
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
	 * @param        $location
	 * @param string $unit
	 *
	 * @return array
	 */
	function get_forecast( $location, $unit = 'c' ) {

		// Params of URL
		$url_parts = array(
			'u=c',
			'q=' . urlencode( 'select * from weather.forecast where woeid in (SELECT woeid FROM geo.places WHERE text="(' . $location . ')")' ),
			'format=json',
			//			'oauth_token=' . $this->get_app_id(),
			//			'oauth_token_secret=' . $this->get_api_key(),
		);

		// final URL
		$url = 'https://query.yahooapis.com/v1/public/yql?' . implode( '&', $url_parts );

		$r_resp = $this->get_remote_data( $url );

		// Connection Error
		if ( wp_remote_retrieve_response_code( $r_resp ) != 200 || is_wp_error( $r_resp ) || ! isset( $r_resp['body'] ) || $r_resp['body'] == FALSE ) {
			return array(
				'status' => 'error',
				'title'  => __( 'Connection Error', 'better-studio' ),
				'msg'    => __( 'No any data received from Yahoo Weather.', 'better-studio' ),
				'data'   => $r_resp
			);
		}

		// Try to decode the json
		$r_body = @json_decode( wp_remote_retrieve_body( $r_resp ), TRUE );
		if ( $r_body === NULL and json_last_error() !== JSON_ERROR_NONE ) {
			return array(
				'status' => 'error',
				'title'  => __( 'Data Error', 'better-studio' ),
				'msg'    => __( 'Error decoding the json from Yahoo Weather', 'better-studio' ),
				'data'   => $r_resp
			);
		}

		if ( empty( $r_body['query']['results'] ) || is_null( $r_body['query']['results'] ) ) {
			return array(
				'status' => 'error',
				'title'  => __( 'Incorrect Location', 'better-studio' ),
				'msg'    => __( 'Entered location ( lat and lang ) is incorrect', 'better-studio' ),
				'data'   => $r_body
			);
		}

		$output = array();

		$data = $r_body['query']['results']['channel'];

		//
		// Location
		//
		$output['location']['longitude'] = $data['item']['long'];
		$output['location']['latitude']  = $data['item']['lat'];
		$output['location']['country']   = $this->pretty_name( $data['location']['country'] );
		$output['location']['city']      = $this->pretty_name( $data['location']['city'] );


		//
		// Today data
		//
		$output['today']['time']            = strtotime( $data['item']['condition']['date'] );
		$output['today']['time_r']          = $this->get_date_translation( $output['today']['time'] );
		$output['today']['summary']         = $this->get_translation( $data['item']['condition']['text'] );
		$output['today']['icon']            = $this->get_standard_icon( $data['item']['condition']['code'] );
		$output['today']['temperature']     = $this->convert_fahrenheit_to_celsius( $data['item']['condition']['temp'] );
		$output['today']['temperature_min'] = $this->convert_fahrenheit_to_celsius( $data['item']['forecast'][0]['low'] );
		$output['today']['temperature_max'] = $this->convert_fahrenheit_to_celsius( $data['item']['forecast'][0]['high'] );
		$output['today']['sunrise_time']    = strtotime( $data['item']['forecast'][0]['date'] . ' ' . $data['astronomy']['sunrise'] );
		$output['today']['sunset_time']     = strtotime( $data['item']['forecast'][0]['date'] . ' ' . $data['astronomy']['sunset'] );


		//
		// Next Days
		//
		unset( $data['item']['forecast'][0] );
		$counter = 0;
		foreach ( $data['item']['forecast'] as $day ) {

			if ( $counter > 4 ) {
				break;
			} else {
				$counter ++;
			}

			$output['next_days'][ $counter ] = array(
				'time'            => strtotime( $day['date'] ),
				'time_r'          => $this->get_date_translation( strtotime( $day['date'] ) ),
				'day_name'        => $this->get_day_translation( strtotime( $day['date'] ) ),
				'summary'         => $this->get_translation( $day['text'] ),
				'icon'            => $this->get_standard_icon( $day['code'] ),
				'temperature'     => '',
				'temperature_min' => $day['low'],
				'temperature_max' => $day['high'],
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
	 * Creates standard icons from Aeris Weather condition code
	 *
	 * https://developer.yahoo.com/weather/documentation.html
	 *
	 * @param $condition_code
	 *
	 * @return string
	 */
	function get_standard_icon( $condition_code, $day = TRUE ) {

		switch ( $condition_code ) {

			case 33: // fair (night)
			case 31: // clear (night)
				$_icon = 'clear-night';
				break;

			case 34: // fair (day)
			case 32: // sunny
				$_icon = 'clear-day';
				break;

			case 36: // hot
				if ( $day ) {
					$_icon = 'clear-day';
				} else {
					$_icon = 'clear-night';
				}
				break;

			case 47: // isolated thundershowers
			case 6: // mixed rain and sleet
			case 5: // mixed rain and snow
			case 9: // drizzle
			case 40: // scattered showers
			case 12: // showers
			case 11: // showers
			case 10: // freezing rain
			case 8: // freezing drizzle
				$_icon = 'rain';
				break;

			case 7: // mixed snow and sleet
			case 13: // snow flurries
			case 14: // light snow showers
			case 15: // blowing snow
			case 16: // snow
			case 17: // hail
			case 18: // sleet
			case 35: // mixed rain and hail
			case 41: // heavy snow
			case 42: // scattered snow showers
			case 43: // heavy snow
			case 46: // snow showers
				$_icon = 'snow';
				break;

			case 45: // thundershowers
			case 39: // scattered thunderstorms
			case 38: // scattered thunderstorms
			case 37: // isolated thunderstorms
			case 4: // thunderstorms
			case 3: // severe thunderstorms
			case 2: // hurricane
			case 1: // tropical storm
			case 0: // tornado
			case 24: // windy
			case 23: // blustery
			case 19: // dust
				$_icon = 'wind';
				break;

			case 44: // partly cloudy
				if ( $day ) {
					$_icon = 'partly-cloudy-day';
				} else {
					$_icon = 'partly-cloudy-night';
				}
				break;

			case 29: // partly cloudy (night)
				$_icon = 'partly-cloudy-night';
				break;

			case 30: // partly cloudy (day)
				$_icon = 'partly-cloudy-day';
				break;

			case 28: // mostly cloudy (day)
			case 27: // mostly cloudy (night)
			case 25: // cold
			case 26: // cloudy
				$_icon = 'cloudy';
				break;

			case 22: // smoky
			case 21: // haze
			case 20: // foggy
				$_icon = 'fog';
				break;

			default:
				$_icon = '';

		}

		return $_icon;

	} // get_standard_icon

}