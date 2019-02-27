<?php


/**
 * 5.1. => General Options
 */
$fields[] = array(
	'name' => __( 'API Key', 'better-studio' ),
	'id'   => 'bw_settings',
	'type' => 'tab',
	'icon' => 'bsai-key'
);


$fields['source-setup'] = array(
	'name'          => __( 'Select Weather Source', 'better-studio' ),
	'id'            => 'source-setup',
	'type'          => 'info',
	'std'           => 'Please select of of following sources and setup the API for fetching weather data from that source.',
	'state'         => 'open',
	'info-type'     => 'warning',
	'section_class' => 'widefat',
);


$fields['forecasts_source'] = array(
	'name'    => __( 'Forecasts Source', 'better-studio' ),
	'id'      => 'forecasts_source',
	'type'    => 'select',
	'options' => array(
		''             => __( 'Automatic - First source was setup', 'better-studio' ),
		'yahoo'        => __( 'Yahoo Weather', 'better-studio' ),
		'forecasts_io' => __( 'Forecasts.io', 'better-studio' ),
		'owm'          => __( 'Open Weather Map', 'better-studio' ),
		'aerisweather' => __( 'Aeris Weather', 'better-studio' ),
	)
);

//
// Forecast.io
//
$fields[]          = array(
	'name'  => __( 'Forecast.io API Key', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['api_key'] = array(
	'name' => __( 'API Key', 'better-studio' ),
	'id'   => 'api_key',
	'desc' => __( 'Enter your own API Key for Forecast.io', 'better-weather' ),
	'type' => 'text',
);
$fields[]          = array(
	'name'          => __( 'How to get your own API key!?', 'better-studio' ),
	'id'            => 'forecasts-io-help',
	'type'          => 'info',
	'std'           => '<p>' . __( 'For showing forecast you should get a free API key with a simple sign up to the site.', 'better-studio' ) .

	                   '</p><ol><li>' . __( 'Go to <a href="http://goo.gl/d1d6Ji" target="_blank">https://developer.forecast.io/register</a> and Sing up', 'better-studio' ) . '<br><br><img class="aligncenter" src="' . Better_Weather::dir_url() . 'img/help-singup-page.png"><br></li>
    <li>After you can see your API Key in bottom of page.<br><br><img class="aligncenter" src="' . Better_Weather::dir_url() . 'img/help-singup-page-api.png"><br></li>
    <li>Copy "API Key" and paste that in upper input box.</li>
  </ol>

',
	'state'         => 'open',
	'info-type'     => 'help',
	'section_class' => 'widefat',
);

//
// OWM
//
$fields[]              = array(
	'name'  => __( 'Open Weather Map API Key', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['owm_api_key'] = array(
	'name' => __( 'API Key', 'better-studio' ),
	'id'   => 'owm_api_key',
	'desc' => __( 'Enter your own API Key for Forecast.io', 'better-weather' ),
	'type' => 'text',
);
$fields[]              = array(
	'name'          => __( 'How to get your own API key!?', 'better-studio' ),
	'id'            => 'owm-help',
	'type'          => 'info',
	'std'           => '<p>' . __( 'For showing forecast you should get a free API key with a simple sign up to the site.', 'better-studio' ) .

	                   '</p><ol><li>' . __( 'Go to <a href="https://goo.gl/eFj0DF" target="_blank">https://home.openweathermap.org/users/sign_up</a> and Sing up', 'better-studio' ) . '</li>
    <li>In next page enter and name for company field and select "Weather widget for web" in purpose filed and hit the save button..<br><br><img class="aligncenter" src="' . Better_Weather::dir_url() . 'img/setup/owm-1.jpg"><br></li>
    <li>In next page go to the "API Keys" tab and copy Key.<br><br><img class="aligncenter" src="' . Better_Weather::dir_url() . 'img/setup/owm-2.jpg"><br></li>
    <li>Paste that in upper input box.</li>
  </ol>
',
	'state'         => 'open',
	'info-type'     => 'help',
	'section_class' => 'widefat',
);


//
// Aeris Weather API
//
$fields[]                       = array(
	'name'  => __( 'Aeris Weather API Key', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['aerisweather_app_id']  = array(
	'name' => __( 'App ID', 'better-studio' ),
	'id'   => 'aerisweather_app_id',
	'desc' => __( 'Enter your own API Key for Forecast.io', 'better-weather' ),
	'type' => 'text',
);
$fields['aerisweather_api_key'] = array(
	'name' => __( 'API Key', 'better-studio' ),
	'id'   => 'aerisweather_api_key',
	'desc' => __( 'Enter your own API Key for Forecast.io', 'better-weather' ),
	'type' => 'text',
);
$fields[]                       = array(
	'name'          => __( 'How to get your own API key!?', 'better-studio' ),
	'id'            => 'qeris-help',
	'type'          => 'info',
	'std'           => '<p>' . __( 'For showing forecast you should get a free API ID and App Key with a simple sign up to the site.', 'better-studio' ) .

	                   '</p><ol><li>' . __( 'Go to <a href="http://goo.gl/hNygjr" target="_blank">http://www.aerisweather.com/signup/</a> and Sing up as Free API Developer.', 'better-studio' ) . '</li>
    <li>In next page click on "<strong>Checkout</strong>" button.</li>
    <li>Fill form in opened page and hit the <strong>NEXR</strong> button.</li>
    <li>Click on <strong>Here</strong> button on next page<br><br><img class="aligncenter" src="' . Better_Weather::dir_url() . 'img/setup/aeris-1.jpg"><br></li>
    <li>Go to Apss tab on opened page and hit the <strong>NEW APPLICATION</strong> Button.<br><br><img class="aligncenter" src="' . Better_Weather::dir_url() . 'img/setup/aeris-2.jpg"><br></li>
    <li>Fill the opened form and hit the <strong>SAVE APP</strong> button.<br><br><img class="aligncenter" src="' . Better_Weather::dir_url() . 'img/setup/aeris-3.jpg"><br></li>
    <li>Refresh the page, Then copy the ID and paste it to upper APP ID field and copy secret and paste it to APP Key field. <strong>SAVE APP</strong> button.<br><br><img class="aligncenter" src="' . Better_Weather::dir_url() . 'img/setup/aeris-4.jpg"><br></li>
  </ol>
',
	'state'         => 'open',
	'info-type'     => 'help',
	'section_class' => 'widefat',
);


/**
 * => Style
 */
$fields[] = array(
	'name'  => __( 'Style', 'better-studio' ),
	'id'    => 'style',
	'type'  => 'tab',
	'icon'  => 'bsai-paint',
	'badge' => array(
		'text'  => __( 'New', 'better-studio' ),
		'color' => '#F47878'
	)
);

$fields[] = array(
	'name'          => __( 'How to customize forecasts style!?', 'better-studio' ),
	'id'            => 'style-help',
	'type'          => 'info',
	'std'           => '<p>' . __( 'You can customize background image and color of all forecasts and also each of them separately.', 'better-studio' ) .

	                   '</p><ul><li><strong>' . __( 'Change All of forecasts:', 'better-studio' ) . '</strong>
    ' . __( 'Use options inside following <strong>All Forecasts Style</strong> option group.', 'better-studio' ) . '</li>

    <li><strong>' . __( 'Customize Each Forecast Style:', 'better-studio' ) . '</strong>
    ' . __( 'Use options inside each forecast option group.', 'better-studio' ) . '</li>
  </ul>

',
	'state'         => 'open',
	'info-type'     => 'help',
	'section_class' => 'widefat',
);


/**
 * => Style -> Clear Day
 */
$fields[]                     = array(
	'name'  => __( 'All Forecasts Style', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['style_all_bg_img']   = array(
	'name'         => __( 'Background Image', 'better-studio' ),
	'id'           => 'style_all_bg_img',
	'type'         => 'background_image',
	'upload_label' => __( 'Upload Image', 'better-studio' ),
	'desc'         => __( 'Customize <strong>All Forecasts</strong> background image.', 'better-studio' ),
);
$fields['style_all_bg_color'] = array(
	'name' => __( 'Background Color', 'better-studio' ),
	'id'   => 'style_all_bg_color',
	'type' => 'color',
	'desc' => __( 'Customize <strong>All Forecasts</strong> background color.', 'better-studio' ),
);


/**
 * => Style -> Clear Day
 */
$fields[]                           = array(
	'name'  => __( 'Clear Day Style', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['style_clear_day_bg_img']   = array(
	'name'         => __( 'Background Image', 'better-studio' ),
	'id'           => 'style_clear_day_bg_img',
	'type'         => 'background_image',
	'upload_label' => __( 'Upload Image', 'better-studio' ),
	'desc'         => __( 'Customize <strong>Clear Day</strong> background image.', 'better-studio' ),
);
$fields['style_clear_day_bg_color'] = array(
	'name' => __( 'Background Color', 'better-studio' ),
	'id'   => 'style_clear_day_bg_color',
	'type' => 'color',
	'desc' => __( 'Customize <strong>Clear Day</strong> background color.', 'better-studio' ),
);


/**
 * => Style -> Clear Night
 */
$fields[]                             = array(
	'name'  => __( 'Clear Night Style', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['style_clear_night_bg_img']   = array(
	'name'         => __( 'Background Image', 'better-studio' ),
	'id'           => 'style_clear_night_bg_img',
	'type'         => 'background_image',
	'upload_label' => __( 'Upload Image', 'better-studio' ),
	'desc'         => __( 'Customize <strong>Clear Night</strong> background image.', 'better-studio' ),
);
$fields['style_clear_night_bg_color'] = array(
	'name' => __( 'Background Color', 'better-studio' ),
	'id'   => 'style_clear_night_bg_color',
	'type' => 'color',
	'desc' => __( 'Customize <strong>Clear Night</strong> background color.', 'better-studio' ),
);


/**
 * => Style -> Rain
 */
$fields[]                      = array(
	'name'  => __( 'Rain Style', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['style_rain_bg_img']   = array(
	'name'         => __( 'Background Image', 'better-studio' ),
	'id'           => 'style_rain_bg_img',
	'type'         => 'background_image',
	'upload_label' => __( 'Upload Image', 'better-studio' ),
	'desc'         => __( 'Customize <strong>Rain</strong> background image.', 'better-studio' ),
);
$fields['style_rain_bg_color'] = array(
	'name' => __( 'Background Color', 'better-studio' ),
	'id'   => 'style_rain_bg_color',
	'type' => 'color',
	'desc' => __( 'Customize <strong>Rain</strong> background color.', 'better-studio' ),
);


/**
 * => Style -> Snow
 */
$fields[]                      = array(
	'name'  => __( 'Snow Style', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['style_snow_bg_img']   = array(
	'name'         => __( 'Background Image', 'better-studio' ),
	'id'           => 'style_snow_bg_img',
	'type'         => 'background_image',
	'upload_label' => __( 'Upload Image', 'better-studio' ),
	'desc'         => __( 'Customize <strong>Snow</strong> background image.', 'better-studio' ),
);
$fields['style_snow_bg_color'] = array(
	'name' => __( 'Background Color', 'better-studio' ),
	'id'   => 'style_snow_bg_color',
	'type' => 'color',
	'desc' => __( 'Customize <strong>Snow</strong> background color.', 'better-studio' ),
);


/**
 * => Style -> Cloudy
 */
$fields[]                        = array(
	'name'  => __( 'Cloudy Style', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['style_cloudy_bg_img']   = array(
	'name'         => __( 'Background Image', 'better-studio' ),
	'id'           => 'style_cloudy_bg_img',
	'type'         => 'background_image',
	'upload_label' => __( 'Upload Image', 'better-studio' ),
	'desc'         => __( 'Customize <strong>Cloudy</strong> background image.', 'better-studio' ),
);
$fields['style_cloudy_bg_color'] = array(
	'name' => __( 'Background Color', 'better-studio' ),
	'id'   => 'style_cloudy_bg_color',
	'type' => 'color',
	'desc' => __( 'Customize <strong>Cloudy</strong> background color.', 'better-studio' ),
);


/**
 * => Style -> Partly Cloudy Day
 */
$fields[]                                   = array(
	'name'  => __( 'Partly Cloudy Day Style', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['style_partly_cloudy_day_bg_img']   = array(
	'name'         => __( 'Background Image', 'better-studio' ),
	'id'           => 'style_partly_cloudy_day_bg_img',
	'type'         => 'background_image',
	'upload_label' => __( 'Upload Image', 'better-studio' ),
	'desc'         => __( 'Customize <strong>Partly Cloudy Day</strong> background image.', 'better-studio' ),
);
$fields['style_partly_cloudy_day_bg_color'] = array(
	'name' => __( 'Background Color', 'better-studio' ),
	'id'   => 'style_partly_cloudy_day_bg_color',
	'type' => 'color',
	'desc' => __( 'Customize <strong>Partly Cloudy Day</strong> background color.', 'better-studio' ),
);


/**
 * => Style -> Partly Cloudy Night
 */
$fields[]                                     = array(
	'name'  => __( 'Partly Cloudy Night Style', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['style_partly_cloudy_night_bg_img']   = array(
	'name'         => __( 'Background Image', 'better-studio' ),
	'id'           => 'style_partly_cloudy_night_bg_img',
	'type'         => 'background_image',
	'upload_label' => __( 'Upload Image', 'better-studio' ),
	'desc'         => __( 'Customize <strong>Partly Cloudy Night</strong> background image.', 'better-studio' ),
);
$fields['style_partly_cloudy_night_bg_color'] = array(
	'name' => __( 'Background Color', 'better-studio' ),
	'id'   => 'style_partly_cloudy_night_bg_color',
	'type' => 'color',
	'desc' => __( 'Customize <strong>Partly Cloudy Night</strong> background color.', 'better-studio' ),
);


/**
 * => Style -> Sunrise
 */
$fields[]                         = array(
	'name'  => __( 'Sunrise Style', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['style_sunrise_bg_img']   = array(
	'name'         => __( 'Background Image', 'better-studio' ),
	'id'           => 'style_sunrise_bg_img',
	'type'         => 'background_image',
	'upload_label' => __( 'Upload Image', 'better-studio' ),
	'desc'         => __( 'Customize <strong>Sunrise</strong> background image.', 'better-studio' ),
);
$fields['style_sunrise_bg_color'] = array(
	'name' => __( 'Background Color', 'better-studio' ),
	'id'   => 'style_sunrise_bg_color',
	'type' => 'color',
	'desc' => __( 'Customize <strong>Sunrise</strong> background color.', 'better-studio' ),
);


/**
 * => Style -> Sunset
 */
$fields[]                        = array(
	'name'  => __( 'Sunset Style', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['style_sunset_bg_img']   = array(
	'name'         => __( 'Background Image', 'better-studio' ),
	'id'           => 'style_sunset_bg_img',
	'type'         => 'background_image',
	'upload_label' => __( 'Upload Image', 'better-studio' ),
	'desc'         => __( 'Customize <strong>Sunset</strong> background image.', 'better-studio' ),
);
$fields['style_sunset_bg_color'] = array(
	'name' => __( 'Background Color', 'better-studio' ),
	'id'   => 'style_sunset_bg_color',
	'type' => 'color',
	'desc' => __( 'Customize <strong>Sunset</strong> background color.', 'better-studio' ),
);

/**
 * => Style -> Sleet
 */
$fields[]                       = array(
	'name'  => __( 'Sleet Style', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['style_sleet_bg_img']   = array(
	'name'         => __( 'Background Image', 'better-studio' ),
	'id'           => 'style_sleet_bg_img',
	'type'         => 'background_image',
	'upload_label' => __( 'Upload Image', 'better-studio' ),
	'desc'         => __( 'Customize <strong>Sleet</strong> background image.', 'better-studio' ),
);
$fields['style_sleet_bg_color'] = array(
	'name' => __( 'Background Color', 'better-studio' ),
	'id'   => 'style_sleet_bg_color',
	'type' => 'color',
	'desc' => __( 'Customize <strong>Sleet</strong> background color.', 'better-studio' ),
);


/**
 * => Style -> Wind
 */
$fields[]                      = array(
	'name'  => __( 'Wind Style', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['style_wind_bg_img']   = array(
	'name'         => __( 'Background Image', 'better-studio' ),
	'id'           => 'style_wind_bg_img',
	'type'         => 'background_image',
	'upload_label' => __( 'Upload Image', 'better-studio' ),
	'desc'         => __( 'Customize <strong>Wind</strong> background image.', 'better-studio' ),
);
$fields['style_wind_bg_color'] = array(
	'name' => __( 'Background Color', 'better-studio' ),
	'id'   => 'style_wind_bg_color',
	'type' => 'color',
	'desc' => __( 'Customize <strong>Wind</strong> background color.', 'better-studio' ),
);


/**
 * => Style -> Fog
 */
$fields[]                     = array(
	'name'  => __( 'Fog Style', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['style_fog_bg_img']   = array(
	'name'         => __( 'Background Image', 'better-studio' ),
	'id'           => 'style_fog_bg_img',
	'type'         => 'background_image',
	'upload_label' => __( 'Upload Image', 'better-studio' ),
	'desc'         => __( 'Customize <strong>Fog</strong> background image.', 'better-studio' ),
);
$fields['style_fog_bg_color'] = array(
	'name' => __( 'Background Color', 'better-studio' ),
	'id'   => 'style_fog_bg_color',
	'type' => 'color',
	'desc' => __( 'Customize <strong>Fog</strong> background color.', 'better-studio' ),
);


/**
 * => Style -> Thunderstorm
 */
$fields[]                              = array(
	'name'  => __( 'Thunderstorm Style', 'better-studio' ),
	'type'  => 'group',
	'state' => 'close',
);
$fields['style_thunderstorm_bg_img']   = array(
	'name'         => __( 'Background Image', 'better-studio' ),
	'id'           => 'style_thunderstorm_bg_img',
	'type'         => 'background_image',
	'upload_label' => __( 'Upload Image', 'better-studio' ),
	'desc'         => __( 'Customize <strong>Thunderstorm</strong> background image.', 'better-studio' ),
);
$fields['style_thunderstorm_bg_color'] = array(
	'name' => __( 'Background Color', 'better-studio' ),
	'id'   => 'style_thunderstorm_bg_color',
	'type' => 'color',
	'desc' => __( 'Customize <strong>Thunderstorm</strong> background color.', 'better-studio' ),
);


$fields[] = array(
	'name'  => __( 'Translations', 'better-studio' ),
	'id'    => 'translation',
	'type'  => 'tab',
	'icon'  => 'bsai-translation',
	'badge' => array(
		'text'  => __( 'New', 'better-studio' ),
		'color' => '#62D393'
	)
);

// todo add reset translation button ;)


$fields[]                     = array(
	'name'  => __( 'Months Name Translations', 'better-studio' ),
	'id'    => 'tr_month',
	'type'  => 'group',
	'state' => 'close',
);
$fields['tr_date']            = array(
	'name'            => __( 'Date translation', 'better-studio' ),
	'id'              => 'tr_date',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
	'desc'            => __( 'You can use this keywords<br>
<strong>%%day%%</strong>: Day.<br>
<strong>%%month%%</strong>: Month.', 'better-studio' ),
);
$fields['tr_month_january']   = array(
	'name'            => __( 'January', 'better-studio' ),
	'id'              => 'tr_month_january',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_month_february']  = array(
	'name'            => __( 'February', 'better-studio' ),
	'id'              => 'tr_month_february',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_month_march']     = array(
	'name'            => __( 'March', 'better-studio' ),
	'id'              => 'tr_month_march',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_month_april']     = array(
	'name'            => __( 'April', 'better-studio' ),
	'id'              => 'tr_month_april',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_month_may']       = array(
	'name'            => __( 'May', 'better-studio' ),
	'id'              => 'tr_month_may',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_month_june']      = array(
	'name'            => __( 'June', 'better-studio' ),
	'id'              => 'tr_month_june',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_month_july']      = array(
	'name'            => __( 'July', 'better-studio' ),
	'id'              => 'tr_month_july',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_month_august']    = array(
	'name'            => __( 'August', 'better-studio' ),
	'id'              => 'tr_month_august',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_month_september'] = array(
	'name'            => __( 'September', 'better-studio' ),
	'id'              => 'tr_month_september',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_month_october']   = array(
	'name'            => __( 'October', 'better-studio' ),
	'id'              => 'tr_month_october',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_month_november']  = array(
	'name'            => __( 'November', 'better-studio' ),
	'id'              => 'tr_month_november',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_month_december']  = array(
	'name'            => __( 'December', 'better-studio' ),
	'id'              => 'tr_month_december',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);

$fields[]              = array(
	'name'  => __( 'Days Name Translations', 'better-studio' ),
	'id'    => 'tr_day',
	'type'  => 'group',
	'state' => 'close',
);
$fields['tr_days_sat'] = array(
	'name'            => __( 'Sat', 'better-studio' ),
	'id'              => 'tr_days_sat',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_days_sun'] = array(
	'name'            => __( 'Sun', 'better-studio' ),
	'id'              => 'tr_days_sun',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_days_mon'] = array(
	'name'            => __( 'Mon', 'better-studio' ),
	'id'              => 'tr_days_mon',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_days_tue'] = array(
	'name'            => __( 'Tue', 'better-studio' ),
	'id'              => 'tr_days_tue',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_days_wed'] = array(
	'name'            => __( 'Wed', 'better-studio' ),
	'id'              => 'tr_days_wed',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_days_thu'] = array(
	'name'            => __( 'Thu', 'better-studio' ),
	'id'              => 'tr_days_thu',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_days_fri'] = array(
	'name'            => __( 'Fri', 'better-studio' ),
	'id'              => 'tr_days_fri',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);


$fields[] = array( 'type' => 'group_close' ); // Close last group

$fields[] = array( 'type' => 'hr' );

//
// Yahoo Translation
//
$fields[]                                   = array(
	'name'  => __( 'Weather Yahoo Translations', 'better-studio' ),
	'id'    => 'tr_yahoo',
	'type'  => 'group',
	'state' => 'close',
);
$fields['tr_yahoo_tornado']                 = array(
	'name'            => __( 'Tornado', 'better-studio' ),
	'id'              => 'tr_yahoo_tornado',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_tropical_storm']          = array(
	'name'            => __( 'Tropical Storm', 'better-studio' ),
	'id'              => 'tr_yahoo_tropical_storm',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_hurricane']               = array(
	'name'            => __( 'Hurricane', 'better-studio' ),
	'id'              => 'tr_yahoo_hurricane',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_severe_thunderstorms']    = array(
	'name'            => __( 'Severe Thunderstorms', 'better-studio' ),
	'id'              => 'tr_yahoo_severe_thunderstorms',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_thunderstorms']           = array(
	'name'            => __( 'Thunderstorms', 'better-studio' ),
	'id'              => 'tr_yahoo_thunderstorms',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_mixed_rain_and_snow']     = array(
	'name'            => __( 'Mixed Rain And Snow', 'better-studio' ),
	'id'              => 'tr_yahoo_mixed_rain_and_snow',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_mixed_rain_and_snow']     = array(
	'name'            => __( 'Mixed Rain And Snow', 'better-studio' ),
	'id'              => 'tr_yahoo_mixed_rain_and_snow',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_mixed_rain_and_sleet']    = array(
	'name'            => __( 'Mixed Rain And Sleet', 'better-studio' ),
	'id'              => 'tr_yahoo_mixed_rain_and_sleet',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_mixed_snow_and_sleet']    = array(
	'name'            => __( 'Mixed Snow And Sleet', 'better-studio' ),
	'id'              => 'tr_yahoo_mixed_snow_and_sleet',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_freezing_drizzle']        = array(
	'name'            => __( 'Freezing Drizzle', 'better-studio' ),
	'id'              => 'tr_yahoo_freezing_drizzle',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_drizzle']                 = array(
	'name'            => __( 'Drizzle', 'better-studio' ),
	'id'              => 'tr_yahoo_drizzle',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_freezing_rain']           = array(
	'name'            => __( 'Freezing Rain', 'better-studio' ),
	'id'              => 'tr_yahoo_freezing_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_showers']                 = array(
	'name'            => __( 'Showers', 'better-studio' ),
	'id'              => 'tr_yahoo_showers',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_snow_flurries']           = array(
	'name'            => __( 'Snow Flurries', 'better-studio' ),
	'id'              => 'tr_yahoo_snow_flurries',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_light_snow_showers']      = array(
	'name'            => __( 'Light Snow Showers', 'better-studio' ),
	'id'              => 'tr_yahoo_light_snow_showers',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_blowing_snow']            = array(
	'name'            => __( 'Blowing Snow', 'better-studio' ),
	'id'              => 'tr_yahoo_blowing_snow',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_snow']                    = array(
	'name'            => __( 'Snow', 'better-studio' ),
	'id'              => 'tr_yahoo_snow',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_hail']                    = array(
	'name'            => __( 'Hail', 'better-studio' ),
	'id'              => 'tr_yahoo_hail',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_sleet']                   = array(
	'name'            => __( 'Sleet', 'better-studio' ),
	'id'              => 'tr_yahoo_sleet',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_dust']                    = array(
	'name'            => __( 'Dust', 'better-studio' ),
	'id'              => 'tr_yahoo_dust',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_haze']                    = array(
	'name'            => __( 'Haze', 'better-studio' ),
	'id'              => 'tr_yahoo_haze',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_smoky']                   = array(
	'name'            => __( 'Smoky', 'better-studio' ),
	'id'              => 'tr_yahoo_smoky',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_blustery']                = array(
	'name'            => __( 'Blustery', 'better-studio' ),
	'id'              => 'tr_yahoo_blustery',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_windy']                   = array(
	'name'            => __( 'Windy', 'better-studio' ),
	'id'              => 'tr_yahoo_windy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_cold']                    = array(
	'name'            => __( 'Cold', 'better-studio' ),
	'id'              => 'tr_yahoo_cold',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_cloudy']                  = array(
	'name'            => __( 'Cloudy', 'better-studio' ),
	'id'              => 'tr_yahoo_cloudy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_mostly_cloudy']           = array(
	'name'            => __( 'Mostly Cloudy', 'better-studio' ),
	'id'              => 'tr_yahoo_mostly_cloudy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_partly_cloudy']           = array(
	'name'            => __( 'Partly Cloudy', 'better-studio' ),
	'id'              => 'tr_yahoo_partly_cloudy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_clear']                   = array(
	'name'            => __( 'Clear', 'better-studio' ),
	'id'              => 'tr_yahoo_clear',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_sunny']                   = array(
	'name'            => __( 'Sunny', 'better-studio' ),
	'id'              => 'tr_yahoo_sunny',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_fair']                    = array(
	'name'            => __( 'Fair', 'better-studio' ),
	'id'              => 'tr_yahoo_fair',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_mixed_rain_and_hail']     = array(
	'name'            => __( 'Mixed Rain And Hail', 'better-studio' ),
	'id'              => 'tr_yahoo_mixed_rain_and_hail',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_hot']                     = array(
	'name'            => __( 'Hot', 'better-studio' ),
	'id'              => 'tr_yahoo_hot',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_isolated_thunderstorms']  = array(
	'name'            => __( 'Isolated Thunderstorms', 'better-studio' ),
	'id'              => 'tr_yahoo_isolated_thunderstorms',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_scattered_thunderstorms'] = array(
	'name'            => __( 'Scattered Thunderstorms', 'better-studio' ),
	'id'              => 'tr_yahoo_scattered_thunderstorms',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_scattered_showers']       = array(
	'name'            => __( 'Scattered Showers', 'better-studio' ),
	'id'              => 'tr_yahoo_scattered_showers',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_heavy_snow']              = array(
	'name'            => __( 'Heavy Snow', 'better-studio' ),
	'id'              => 'tr_yahoo_heavy_snow',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_scattered_snow_showers']  = array(
	'name'            => __( 'Scattered Snow Showers', 'better-studio' ),
	'id'              => 'tr_yahoo_scattered_snow_showers',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_thundershowers']          = array(
	'name'            => __( 'Thundershowers', 'better-studio' ),
	'id'              => 'tr_yahoo_thundershowers',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_snow_showers']            = array(
	'name'            => __( 'Snow Showers', 'better-studio' ),
	'id'              => 'tr_yahoo_snow_showers',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_yahoo_isolated_thundershowers'] = array(
	'name'            => __( 'Isolated Thundershowers', 'better-studio' ),
	'id'              => 'tr_yahoo_isolated_thundershowers',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);


//
// OWM Translation
//
$fields[]                                         = array(
	'name'  => __( 'Open Weather Map Translation', 'better-studio' ),
	'id'    => 'tr_owm',
	'type'  => 'group',
	'state' => 'close',
);
$fields['tr_owm_thunderstorm_with_light_rain']    = array(
	'name'            => __( 'Thunderstorm With Light Rain', 'better-studio' ),
	'id'              => 'tr_owm_thunderstorm_with_light_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_thunderstorm_with_rain']          = array(
	'name'            => __( 'Thunderstorm With Rain', 'better-studio' ),
	'id'              => 'tr_owm_thunderstorm_with_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_thunderstorm_with_heavy_rain']    = array(
	'name'            => __( 'Thunderstorm With Heavy Rain', 'better-studio' ),
	'id'              => 'tr_owm_thunderstorm_with_heavy_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_light_thunderstorm']              = array(
	'name'            => __( 'Light Thunderstorm', 'better-studio' ),
	'id'              => 'tr_owm_light_thunderstorm',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_thunderstorm']                    = array(
	'name'            => __( 'Thunderstorm', 'better-studio' ),
	'id'              => 'tr_owm_thunderstorm',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_heavy_thunderstorm']              = array(
	'name'            => __( 'Heavy Thunderstorm', 'better-studio' ),
	'id'              => 'tr_owm_heavy_thunderstorm',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_ragged_thunderstorm']             = array(
	'name'            => __( 'Ragged Thunderstorm', 'better-studio' ),
	'id'              => 'tr_owm_ragged_thunderstorm',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_thunderstorm_with_light_drizzle'] = array(
	'name'            => __( 'Thunderstorm With Light Drizzle', 'better-studio' ),
	'id'              => 'tr_owm_thunderstorm_with_light_drizzle',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_thunderstorm_with_drizzle']       = array(
	'name'            => __( 'Thunderstorm With Drizzle', 'better-studio' ),
	'id'              => 'tr_owm_thunderstorm_with_drizzle',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_thunderstorm_with_heavy_drizzle'] = array(
	'name'            => __( 'Thunderstorm With Heavy Drizzle', 'better-studio' ),
	'id'              => 'tr_owm_thunderstorm_with_heavy_drizzle',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_light_intensity_drizzle']         = array(
	'name'            => __( 'Light Intensity Drizzle', 'better-studio' ),
	'id'              => 'tr_owm_light_intensity_drizzle',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_drizzle']                         = array(
	'name'            => __( 'Drizzle', 'better-studio' ),
	'id'              => 'tr_owm_drizzle',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_heavy_intensity_drizzle']         = array(
	'name'            => __( 'Heavy Intensity Drizzle', 'better-studio' ),
	'id'              => 'tr_owm_heavy_intensity_drizzle',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_light_intensity_drizzle_rain']    = array(
	'name'            => __( 'Light Intensity Drizzle Rain', 'better-studio' ),
	'id'              => 'tr_owm_light_intensity_drizzle_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_drizzle_rain']                    = array(
	'name'            => __( 'Drizzle Rain', 'better-studio' ),
	'id'              => 'tr_owm_drizzle_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_heavy_intensity_drizzle_rain']    = array(
	'name'            => __( 'Heavy Intensity Drizzle Rain', 'better-studio' ),
	'id'              => 'tr_owm_heavy_intensity_drizzle_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_shower_rain_and_drizzle']         = array(
	'name'            => __( 'Shower Rain And Drizzle', 'better-studio' ),
	'id'              => 'tr_owm_shower_rain_and_drizzle',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_heavy_shower_rain_and_drizzle']   = array(
	'name'            => __( 'Heavy Shower Rain And Drizzle', 'better-studio' ),
	'id'              => 'tr_owm_heavy_shower_rain_and_drizzle',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_shower_drizzle']                  = array(
	'name'            => __( 'Shower Drizzle', 'better-studio' ),
	'id'              => 'tr_owm_shower_drizzle',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_light_rain']                      = array(
	'name'            => __( 'Light Rain', 'better-studio' ),
	'id'              => 'tr_owm_light_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_moderate_rain']                   = array(
	'name'            => __( 'Moderate Rain', 'better-studio' ),
	'id'              => 'tr_owm_moderate_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_heavy_intensity_rain']            = array(
	'name'            => __( 'Heavy Intensity Rain', 'better-studio' ),
	'id'              => 'tr_owm_heavy_intensity_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_very_heavy_rain']                 = array(
	'name'            => __( 'Very Heavy Rain', 'better-studio' ),
	'id'              => 'tr_owm_very_heavy_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_freezing_rain']                   = array(
	'name'            => __( 'Freezing Rain', 'better-studio' ),
	'id'              => 'tr_owm_freezing_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_light_intensity_shower_rain']     = array(
	'name'            => __( 'Light Intensity Shower Rain', 'better-studio' ),
	'id'              => 'tr_owm_light_intensity_shower_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_shower_rain']                     = array(
	'name'            => __( 'Shower Rain', 'better-studio' ),
	'id'              => 'tr_owm_shower_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_heavy_intensity_shower_rain']     = array(
	'name'            => __( 'Heavy Intensity Shower Rain', 'better-studio' ),
	'id'              => 'tr_owm_heavy_intensity_shower_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_ragged_shower_rain']              = array(
	'name'            => __( 'Ragged Shower Rain', 'better-studio' ),
	'id'              => 'tr_owm_ragged_shower_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_light_snow']                      = array(
	'name'            => __( 'Light Snow', 'better-studio' ),
	'id'              => 'tr_owm_light_snow',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_snow']                            = array(
	'name'            => __( 'Snow', 'better-studio' ),
	'id'              => 'tr_owm_snow',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_heavy_snow']                      = array(
	'name'            => __( 'Heavy Snow', 'better-studio' ),
	'id'              => 'tr_owm_heavy_snow',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_sleet']                           = array(
	'name'            => __( 'Sleet', 'better-studio' ),
	'id'              => 'tr_owm_sleet',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_shower_sleet']                    = array(
	'name'            => __( 'Shower Sleet', 'better-studio' ),
	'id'              => 'tr_owm_shower_sleet',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_light_rain_and_snow']             = array(
	'name'            => __( 'Light Rain And Snow', 'better-studio' ),
	'id'              => 'tr_owm_light_rain_and_snow',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_rain_and_snow']                   = array(
	'name'            => __( 'Rain And Snow', 'better-studio' ),
	'id'              => 'tr_owm_rain_and_snow',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_light_shower_snow']               = array(
	'name'            => __( 'Light Shower Snow', 'better-studio' ),
	'id'              => 'tr_owm_light_shower_snow',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_shower_snow']                     = array(
	'name'            => __( 'Shower Snow', 'better-studio' ),
	'id'              => 'tr_owm_shower_snow',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_heavy_shower_snow']               = array(
	'name'            => __( 'Heavy Shower Snow', 'better-studio' ),
	'id'              => 'tr_owm_heavy_shower_snow',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_mist']                            = array(
	'name'            => __( 'Mist', 'better-studio' ),
	'id'              => 'tr_owm_mist',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_smoke']                           = array(
	'name'            => __( 'Smoke', 'better-studio' ),
	'id'              => 'tr_owm_smoke',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_haze']                            = array(
	'name'            => __( 'Haze', 'better-studio' ),
	'id'              => 'tr_owm_haze',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_sand']                            = array(
	'name'            => __( 'Sand', 'better-studio' ),
	'id'              => 'tr_owm_sand',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_fog']                             = array(
	'name'            => __( 'Fog', 'better-studio' ),
	'id'              => 'tr_owm_fog',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_dust_whirls']                     = array(
	'name'            => __( 'Dust Whirls', 'better-studio' ),
	'id'              => 'tr_owm_dust_whirls',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_dust']                            = array(
	'name'            => __( 'Dust', 'better-studio' ),
	'id'              => 'tr_owm_dust',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_volcanic_ash']                    = array(
	'name'            => __( 'Volcanic Ash', 'better-studio' ),
	'id'              => 'tr_owm_volcanic_ash',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_squalls']                         = array(
	'name'            => __( 'Squalls', 'better-studio' ),
	'id'              => 'tr_owm_squalls',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_tornado']                         = array(
	'name'            => __( 'Tornado', 'better-studio' ),
	'id'              => 'tr_owm_tornado',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_clear_sky']                       = array(
	'name'            => __( 'Clear Sky', 'better-studio' ),
	'id'              => 'tr_owm_clear_sky',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_few_clouds']                      = array(
	'name'            => __( 'Few Clouds', 'better-studio' ),
	'id'              => 'tr_owm_few_clouds',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_scattered_clouds']                = array(
	'name'            => __( 'Scattered Clouds', 'better-studio' ),
	'id'              => 'tr_owm_scattered_clouds',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_broken_clouds']                   = array(
	'name'            => __( 'Broken Clouds', 'better-studio' ),
	'id'              => 'tr_owm_broken_clouds',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_overcast_clouds']                 = array(
	'name'            => __( 'Overcast Clouds', 'better-studio' ),
	'id'              => 'tr_owm_overcast_clouds',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_tropical_storm']                  = array(
	'name'            => __( 'Tropical Storm', 'better-studio' ),
	'id'              => 'tr_owm_tropical_storm',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_hurricane']                       = array(
	'name'            => __( 'Hurricane', 'better-studio' ),
	'id'              => 'tr_owm_hurricane',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_cold']                            = array(
	'name'            => __( 'Cold', 'better-studio' ),
	'id'              => 'tr_owm_cold',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_hot']                             = array(
	'name'            => __( 'Hot', 'better-studio' ),
	'id'              => 'tr_owm_hot',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_windy']                           = array(
	'name'            => __( 'Windy', 'better-studio' ),
	'id'              => 'tr_owm_windy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_hail']                            = array(
	'name'            => __( 'Hail', 'better-studio' ),
	'id'              => 'tr_owm_hail',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_calm']                            = array(
	'name'            => __( 'Calm', 'better-studio' ),
	'id'              => 'tr_owm_calm',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_light_breeze']                    = array(
	'name'            => __( 'Light Breeze', 'better-studio' ),
	'id'              => 'tr_owm_light_breeze',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_gentle_breeze']                   = array(
	'name'            => __( 'Gentle Breeze', 'better-studio' ),
	'id'              => 'tr_owm_gentle_breeze',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_moderate_breeze']                 = array(
	'name'            => __( 'Moderate Breeze', 'better-studio' ),
	'id'              => 'tr_owm_moderate_breeze',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_fresh_breeze']                    = array(
	'name'            => __( 'Fresh Breeze', 'better-studio' ),
	'id'              => 'tr_owm_fresh_breeze',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_strong_breeze']                   = array(
	'name'            => __( 'Strong Breeze', 'better-studio' ),
	'id'              => 'tr_owm_strong_breeze',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_high_wind']                       = array(
	'name'            => __( 'High Wind', 'better-studio' ),
	'id'              => 'tr_owm_high_wind',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_near_gale']                       = array(
	'name'            => __( 'Near Gale', 'better-studio' ),
	'id'              => 'tr_owm_near_gale',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_gale']                            = array(
	'name'            => __( 'Gale', 'better-studio' ),
	'id'              => 'tr_owm_gale',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_severe_gale']                     = array(
	'name'            => __( 'Severe Gale', 'better-studio' ),
	'id'              => 'tr_owm_severe_gale',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_storm']                           = array(
	'name'            => __( 'Storm', 'better-studio' ),
	'id'              => 'tr_owm_storm',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_violent_storm']                   = array(
	'name'            => __( 'Violent Storm', 'better-studio' ),
	'id'              => 'tr_owm_violent_storm',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_owm_hurricane']                       = array(
	'name'            => __( 'Hurricane', 'better-studio' ),
	'id'              => 'tr_owm_hurricane',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);


//
// Forecast.io Translation
//

$fields[]                                       = array(
	'name'  => __( 'Weather Forecast Translations', 'better-studio' ),
	'id'    => 'tr_forecast',
	'type'  => 'group',
	'state' => 'close',
);
$fields['tr_forecast_clear']                    = array(
	'name'            => __( 'Clear', 'better-studio' ),
	'id'              => 'tr_forecast_clear',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_rain']                     = array(
	'name'            => __( 'Rain', 'better-studio' ),
	'id'              => 'tr_forecast_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_light_rain']               = array(
	'name'            => __( 'Light Rain', 'better-studio' ),
	'id'              => 'tr_forecast_light_rain',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_drizzle']                  = array(
	'name'            => __( 'Drizzle', 'better-studio' ),
	'id'              => 'tr_forecast_drizzle',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_light_rain_and_windy']     = array(
	'name'            => __( 'Light Rain And Windy', 'better-studio' ),
	'id'              => 'tr_forecast_light_rain_and_windy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_flurries']                 = array(
	'name'            => __( 'Flurries', 'better-studio' ),
	'id'              => 'tr_forecast_flurries',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_flurries_df']              = array(
	'name'            => __( 'Flurries DF', 'better-studio' ),
	'id'              => 'tr_forecast_flurries_df',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
	'desc'            => __( 'DF: Daylight Factor', 'better-studio' ),
);
$fields['tr_forecast_cloudy']                   = array(
	'name'            => __( 'Cloudy', 'better-studio' ),
	'id'              => 'tr_forecast_cloudy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_mostly_cloudy']            = array(
	'name'            => __( 'Mostly Cloudy', 'better-studio' ),
	'id'              => 'tr_forecast_mostly_cloudy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_partly_cloudy']            = array(
	'name'            => __( 'Partly Cloudy', 'better-studio' ),
	'id'              => 'tr_forecast_partly_cloudy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_snow']                     = array(
	'name'            => __( 'Snow', 'better-studio' ),
	'id'              => 'tr_forecast_snow',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_light_snow']               = array(
	'name'            => __( 'Light Snow', 'better-studio' ),
	'id'              => 'tr_forecast_light_snow',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_snow_and_breezy']          = array(
	'name'            => __( 'Snow and Breezy', 'better-studio' ),
	'id'              => 'tr_forecast_snow_and_breezy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_snow_and_windy']           = array(
	'name'            => __( 'Snow and Windy', 'better-studio' ),
	'id'              => 'tr_forecast_snow_and_windy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_sleet']                    = array(
	'name'            => __( 'Sleet', 'better-studio' ),
	'id'              => 'tr_forecast_sleet',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_wind']                     = array(
	'name'            => __( 'Wind', 'better-studio' ),
	'id'              => 'tr_forecast_wind',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_windy_and_mostly_cloudy']  = array(
	'name'            => __( 'Windy And Most Cloudy', 'better-studio' ),
	'id'              => 'tr_forecast_windy_and_mostly_cloudy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_foggy']                    = array(
	'name'            => __( 'Foggy', 'better-studio' ),
	'id'              => 'tr_forecast_foggy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_thunderstorm']             = array(
	'name'            => __( 'Thunderstorm', 'better-studio' ),
	'id'              => 'tr_forecast_thunderstorm',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_overcast']                 = array(
	'name'            => __( 'Overcast', 'better-studio' ),
	'id'              => 'tr_forecast_overcast',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_overcast_df']              = array(
	'name'            => __( 'Overcast DF', 'better-studio' ),
	'id'              => 'tr_forecast_overcast_df',
	'type'            => 'text',
	'desc'            => __( 'DF: Daylight Factor', 'better-studio' ),
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_breezy_and_partly_cloudy'] = array(
	'name'            => __( 'Breezy and Partly Cloudy', 'better-studio' ),
	'id'              => 'tr_forecast_breezy_and_partly_cloudy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_breezy_and_mostly_cloudy'] = array(
	'name'            => __( 'Breezy and Mostly Cloudy', 'better-studio' ),
	'id'              => 'tr_forecast_breezy_and_mostly_cloudy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_breezy_and_overcast']      = array(
	'name'            => __( 'Breezy and Overcast', 'better-studio' ),
	'id'              => 'tr_forecast_breezy_and_overcast',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_humid_and_mostly_cloudy']  = array(
	'name'            => __( 'Humid and Mostly Cloudy', 'better-studio' ),
	'id'              => 'tr_forecast_humid_and_mostly_cloudy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_dry_and_partly_cloudy']    = array(
	'name'            => __( 'Dry and Partly Cloudy', 'better-studio' ),
	'id'              => 'tr_forecast_dry_and_partly_cloudy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_dry_and_partly_cloudy_df'] = array(
	'name'            => __( 'Dry and Partly Cloudy DF', 'better-studio' ),
	'id'              => 'tr_forecast_dry_and_partly_cloudy_df',
	'type'            => 'text',
	'desc'            => __( 'DF: Daylight Factor', 'better-studio' ),
	'container_class' => 'highlight-hover',
);

$fields['tr_forecast_dry_and_mostly_cloudy']    = array(
	'name'            => __( 'Dry and Mostly Cloudy', 'better-studio' ),
	'id'              => 'tr_forecast_dry_and_mostly_cloudy',
	'type'            => 'text',
	'container_class' => 'highlight-hover',
);
$fields['tr_forecast_dry_and_mostly_cloudy_df'] = array(
	'name'            => __( 'Dry and Mostly Cloudy DF', 'better-studio' ),
	'id'              => 'tr_forecast_dry_and_mostly_cloudy_df',
	'type'            => 'text',
	'desc'            => __( 'DF: Daylight Factor', 'better-studio' ),
	'container_class' => 'highlight-hover',
);


//
// Aeris Weather Translation
//

$fields[] = array(
	'name'  => __( 'Aeris Weather Translation', 'better-studio' ),
	'id'    => 'tr_aeris',
	'type'  => 'group',
	'state' => 'close',
);
$fields[] = array(
	'name'          => __( 'Sorry!', 'better-studio' ),
	'std'           => __( 'Aeris Weather source did not supports translation.', 'better-studio' ),
	'id'            => 'aeris-tr',
	'type'          => 'info',
	'state'         => 'open',
	'info-type'     => 'warning',
	'section_class' => 'widefat',
);


//
// Caching Options
//
$fields[]             = array(
	'name' => __( 'Caching Options', 'better-studio' ),
	'id'   => 'cache_options_title',
	'type' => 'tab',
	'icon' => 'bsai-database',
);
$fields['cache_time'] = array(
	'name'    => __( 'Maximum Lifetime of Cache', 'better-studio' ),
	'id'      => 'cache_time',
	'type'    => 'select',
	'options' => array(
		30  => __( '30 Minutes', 'better-studio' ),
		60  => __( '1 Hour', 'better-studio' ),
		90  => __( '1 Hour and 30 Minutes', 'better-studio' ),
		120 => __( '2 Hour', 'better-studio' ),
		150 => __( '2 Hour and 30 Minutes', 'better-studio' ),
		180 => __( '3 Hour', 'better-studio' ),
	)
);
$fields[]             = array(
	'name'        => __( 'Clear Data Base Saved Caches', 'better-studio' ),
	'id'          => 'cache_clear_all',
	'type'        => 'ajax_action',
	'button-name' => '<i class="fa fa-refresh"></i> ' . __( 'Purge All Caches', 'better-studio' ),
	'callback'    => 'Better_Weather::clear_cache_all',
	'confirm'     => __( 'Are you sure for deleting all caches?', 'better-studio' ),
	'desc'        => __( 'This allows you to clear all caches that are saved in data base.', 'better-studio' )
);

$fields[] = array(
	'name'       => __( 'Backup & Restore', 'better-studio' ),
	'id'         => 'backup_restore',
	'type'       => 'tab',
	'icon'       => 'bsai-export-import',
	'margin-top' => '30',
);
$fields[] = array(
	'name'      => __( 'Backup / Export', 'better-studio' ),
	'id'        => 'backup_export_options',
	'type'      => 'export',
	'file_name' => 'betterweather-options-backup',
	'panel_id'  => Better_Weather::$panel_id,
	'desc'      => __( 'This allows you to create a backup of your options and settings. Please note, it will not backup anything else.', 'better-studio' )
);
$fields[] = array(
	'name'     => __( 'Restore / Import', 'better-studio' ),
	'id'       => 'import_restore_options',
	'type'     => 'import',
	'panel_id' => Better_Weather::$panel_id,
	'desc'     => __( '<strong>It will override your current settings!</strong> Please make sure to select a valid backup file.', 'better-studio' )
);
