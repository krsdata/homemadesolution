<?php


/**
 * Base class for weather sopurces
 */
class BW_Weather_Source {

	/**
	 * Source ID used for internal actions
	 *
	 * @var string
	 */
	protected $source_id = '';

	/**
	 * App ID for source
	 *
	 * @var
	 */
	var $app_id;

	/**
	 * API key for weather source
	 *
	 * @var
	 */
	var $api_key;


	/**
	 * Current language for weather API
	 *
	 * @var string
	 */
	var $lang = '';


	/**
	 * Weather source constructor.
	 *
	 * @param string $app_id
	 * @param string $api_key
	 * @param string $lang
	 */
	public function __construct( $app_id = '', $api_key = '', $lang = '' ) {
		$this->app_id  = $app_id;
		$this->api_key = $api_key;
		$this->lang    = $lang;
	}


	/**
	 * Fethces and returns forecasts data
	 *
	 * @param        $location
	 * @param string $unit
	 *
	 * @return array
	 */
	public function get_forecast( $location, $unit = 'c' ) {
		return array();
	}


	/**
	 * Returns weather API App ID
	 *
	 * @return string
	 */
	public function get_app_id() {
		return $this->app_id;
	}


	/**
	 * Returns weather API key
	 *
	 * @return string
	 */
	public function get_api_key() {
		return $this->api_key;
	}


	/**
	 * Returns weather API language
	 *
	 * @return string
	 */
	public function get_lang() {
		return $this->lang;
	}


	/**
	 * Retrieves remote data
	 *
	 * @param       $url
	 * @param array $params
	 *
	 * @return array|\WP_Error
	 */
	public function get_remote_data( $url, $params = array() ) {
		return wp_remote_get( $url, $params );
	}


	/**
	 * Used to get text translation from its id
	 *
	 * @param $text
	 *
	 * @return string
	 */
	public function get_translation( $text, $trans_id = '' ) {

		if ( empty( $trans_id ) ) {
			$trans_id = $this->get_trans_id( $text );
		}

		$trans = Better_Weather::get_option( $trans_id );

		if ( is_null( $trans ) ) {
			// todo add some logging for this!
			return $text;
		} else {

			return $trans;
		}

	}


	/**
	 * Used to get readable date translation
	 *
	 * @param $time
	 *
	 * @return mixed
	 */
	public function get_date_translation( $time ) {

		$pattern = Better_Weather::get_option( 'tr_date' );

		$month  = date( "M", $time );
		$_month = date( "F", $time );

		return str_replace(
			array(
				'%%day%%',
				'%%month%%',
			),
			array(
				date( "d", $time ),
				$this->get_translation( $month, 'tr_month_' . strtolower( $_month ) ),
			),
			$pattern
		);

	}


	/**
	 * Used to get readable day name translation
	 *
	 * @param $time
	 *
	 * @return mixed
	 */
	public function get_day_translation( $time ) {

		$day = date( 'D', $time );

		return $this->get_translation( $day, 'tr_days_' . strtolower( $day ) );

	}


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

		return strtolower( 'tr_' . $this->source_id . '_' . $id );
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
	 * Prettifies name
	 *
	 * @param string $name
	 *
	 * @return mixed|string
	 */
	function pretty_name( $name = '' ) {
		$name = str_replace(
			array( ".", "/", "\\", ",", " " ),
			"",
			trim( $name )
		);
		$name = str_replace(
			array( "_", "-" ),
			" ",
			trim( $name )
		);

		return $name;
	}

} // BW_Weather_Source