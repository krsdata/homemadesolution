<?php


/**
 * Facade for selecting and getting data from multiple weather sources
 */
class BW_Forecast_Facade {

	/**
	 * instance of weather source
	 *
	 * @var BW_Weather_Source
	 */
	var $source;


	/**
	 * Raw ID of weather source
	 *
	 * @var string
	 */
	var $source_id = '';


	/**
	 * create correct instance of weather source
	 */
	public function __construct() {

		switch ( $this->source_id = Better_Weather::get_api_source() ) {

			// http://forecast.io/
			case 'forecasts_io':

				require_once Better_Weather::dir_path( 'includes/generator/sources/class-bw-weather-source.php' );
				require_once Better_Weather::dir_path( 'includes/generator/sources/class-bw-forecast-source.php' );

				$this->source = new BW_Forecast_Source(
					'',
					Better_Weather::get_option( 'api_key' ),
					''
				);

				break;

			// http://openweathermap.org/
			case 'owm':

				require_once Better_Weather::dir_path( 'includes/generator/sources/class-bw-weather-source.php' );
				require_once Better_Weather::dir_path( 'includes/generator/sources/class-bw-owm-source.php' );

				$this->source = new BW_OWM_Source(
					'',
					Better_Weather::get_option( 'owm_api_key' ),
					''
				);

				break;

			// http://www.aerisweather.com/
			case 'aerisweather':

				require_once Better_Weather::dir_path( 'includes/generator/sources/class-bw-weather-source.php' );
				require_once Better_Weather::dir_path( 'includes/generator/sources/class-bw-aeris-source.php' );

				$this->source = new BW_Aeris_Source(
					Better_Weather::get_option( 'aerisweather_app_id' ),
					Better_Weather::get_option( 'aerisweather_api_key' ),
					''
				);

				break;
			// https://developer.yahoo.com/weather/
			case 'yahoo':

				require_once Better_Weather::dir_path( 'includes/generator/sources/class-bw-weather-source.php' );
				require_once Better_Weather::dir_path( 'includes/generator/sources/class-bw-yahoo-source.php' );

				$this->source = new BW_Yahoo_Source(
					'',
					'',
					''
				);

				break;

		}


	} // __construct


	/**
	 * Retrieves forecast from source
	 *
	 * @param        $location
	 * @param string $unit
	 *
	 * @return array
	 */
	public function get_forecast( $location, $unit = 'c' ) {
		return $this->source->get_forecast( $location, $unit );
	}

}