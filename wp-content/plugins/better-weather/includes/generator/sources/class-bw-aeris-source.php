<?php


/**
 * Class BW_Aeris_Source
 */
class BW_Aeris_Source extends BW_Weather_Source {

	/**
	 * Source constructor
	 *
	 * @param string $app_id
	 * @param string $api_key
	 * @param string $lang
	 */
	public function __construct( $app_id = '', $api_key = '', $lang = '' ) {
		$this->source_id = 'aeris';
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

		// Check App ID and Key
		if ( $this->get_api_key() == '' ) {
			return array(
				'status' => 'error',
				'title'  => __( 'No API Key', 'better-studio' ),
				'msg'    => __( 'Obtain API Key from http://www.aerisweather.com/account/apps', 'better-studio' ),
				'data'   => 'no data'
			);
		} elseif ( $this->get_api_key() == '' ) {
			return array(
				'status' => 'error',
				'title'  => __( 'No API Key', 'better-studio' ),
				'msg'    => __( 'Obtain API Key from http://www.aerisweather.com/account/apps', 'better-studio' ),
				'data'   => 'no data'
			);
		}

		// Params of URL
		$url_parts = array(
			'p=' . $location,
			'client_secret=' . $this->get_api_key(),
			'client_id=' . $this->get_app_id(),
		);

		// final URL
		$url = 'http://api.aerisapi.com/forecasts?' . implode( '&', $url_parts );

		$r_resp = $this->get_remote_data( $url );

		$output = array();

		// Try to decode the json
		$r_body = @json_decode( wp_remote_retrieve_body( $r_resp ), TRUE );
		if ( $r_body === NULL and json_last_error() !== JSON_ERROR_NONE ) {
			return array(
				'status' => 'error',
				'title'  => __( 'Data Error', 'better-studio' ),
				'msg'    => __( 'Error decoding the json from aerisweather.com', 'better-studio' ),
				'data'   => $r_resp
			);
		}


		if ( $r_body['success'] != TRUE ) {
			return array(
				'status' => 'error',
				'title'  => __( 'Data Error', 'better-studio' ),
				'msg'    => $r_body['error']['description'],
				'data'   => $r_resp
			);
		}

		$day = $r_body['response'][0]['interval'] == 'day';

		$output = array();

		//
		// Location
		//
		$output['location']['longitude'] = $r_body['response'][0]['loc']['long'];
		$output['location']['latitude']  = $r_body['response'][0]['loc']['lat'];
		$_loc                            = explode( '/', current( $r_body['response'][0]['profile'] ) );
		$output['location']['country']   = $this->pretty_name( $_loc[0] );
		$output['location']['city']      = $this->pretty_name( $_loc[1] );


		//
		// Today data
		//
		$output['today']['time']            = $r_body['response'][0]['periods'][0]['timestamp'];
		$output['today']['time_r']          = $this->get_date_translation( $output['today']['time'] );
		$output['today']['summary']         = $r_body['response'][0]['periods'][0]['weatherPrimary'];
		$output['today']['icon']            = $this->get_standard_icon( $r_body['response'][0]['periods'][0]['weatherPrimaryCoded'], $day );
		$output['today']['temperature']     = $r_body['response'][0]['periods'][0]['avgTempC'];
		$output['today']['temperature_min'] = $r_body['response'][0]['periods'][0]['maxTempC'];
		$output['today']['temperature_max'] = $r_body['response'][0]['periods'][0]['minTempC'];
		$output['today']['sunrise_time']    = $r_body['response'][0]['periods'][0]['sunrise'];
		$output['today']['sunset_time']     = $r_body['response'][0]['periods'][0]['sunset'];


		//
		// Next Days
		//
		unset( $r_body['response'][0]['periods'][0] );
		$counter = 0;
		foreach ( $r_body['response'][0]['periods'] as $day ) {

			if ( $counter > 4 ) {
				break;
			} else {
				$counter ++;
			}

			$output['next_days'][ $counter ] = array(
				'time'            => $day['timestamp'],
				'time_r'          => $this->get_date_translation( $day['timestamp'] ),
				'day_name'        => $this->get_day_translation( $day['timestamp'] ),
				'summary'         => $day['weatherPrimary'],
				'icon'            => $this->get_standard_icon( $day['weatherPrimaryCoded'] ),
				'temperature'     => $day['avgTempC'],
				'temperature_min' => $day['maxTempC'],
				'temperature_max' => $day['minTempC'],
				'sunrise_time'    => $day['sunrise'],
				'sunset_time'     => $day['sunset'],
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
	 * http://www.aerisweather.com/support/docs/api/reference/weather-codes/
	 *
	 * @param $condition_code
	 *
	 * @return string
	 */
	function get_standard_icon( $condition_code, $day = TRUE ) {

		// get first condition code
		$condition_code = str_replace( '::', '', $condition_code );
		$condition_code = explode( ':', $condition_code );
		$condition_code = end( $condition_code );

		switch ( $condition_code ) {

			case 'FW': // Fair/Mostly sunny
			case 'CL': // Clear
				if ( $day ) {
					$_icon = 'clear-day';
				} else {
					$_icon = 'clear-night';
				}
				break;


			case 'UP': // Unknown precipitation
			case 'WM': // Wintry mix (snow, sleet, rain)
			case 'RS': // Rain/snow mix
			case 'RW': // Rain showers
			case 'R': // Rain
			case 'L': // Drizzle
			case 'FR': // Frost
			case 'ZY': // Freezing spray
			case 'ZR': // Freezing rain
			case 'ZL': // Freezing drizzle
				$_icon = 'rain';
				break;

			case 'A': // Hail
			case 'SI': // Snow/sleet mix
			case 'IP': // Ice pellets / Sleet
			case 'IF': // Ice fog
			case 'IC': // Ice crystals
			case 'BY': // Blowing spray
			case 'BS': // Blowing snow
			case 'SW': // Snow showers
			case 'S': // Snow
				$_icon = 'snow';
				break;


			case 'BR': // Mist
			case 'BN': // Blowing sand
			case 'BD': // Blowing dust
				$_icon = 'wind';
				break;


			case 'WP': // Waterspouts
			case 'T': // Thunderstorms
				$_icon = 'thunderstorm';
				break;


			case 'SC': // Partly cloudy
				if ( $day ) {
					$_icon = 'partly-cloudy-day';
				} else {
					$_icon = 'partly-cloudy-night';
				}
				break;


			case 'OV': // Cloudy/Overcast
			case 'BK': // Mostly Cloudy
				$_icon = 'cloudy';
				break;

			case 'VA': // Volcanic ash
			case 'H': // Haze
			case 'K': // Smoke
			case 'ZF': // Freezing fog
			case 'F': // Fog
				$_icon = 'fog';
				break;

			default:
				$_icon = '';

		}

		return $_icon;

	} // get_standard_icon

}