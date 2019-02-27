<?php

$fields['style_all_bg_img']   = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-clear-day.state-clear-day',
				'.better-weather.with-natural-background.state-clear-night.state-clear-night',
				'.better-weather.with-natural-background.state-rain.state-rain',
				'.better-weather.with-natural-background.state-snow.state-snow',
				'.better-weather.with-natural-background.state-sleet.state-sleet',
				'.better-weather.with-natural-background.state-wind.state-wind',
				'.better-weather.with-natural-background.state-fog.state-fog',
				'.better-weather.with-natural-background.state-thunderstorm.state-thunderstorm',
				'.better-weather.with-natural-background.state-cloudy.state-cloudy',
				'.better-weather.with-natural-background.state-partly-cloudy-day.state-partly-cloudy-day',
				'.better-weather.with-natural-background.state-partly-cloudy-night.state-partly-cloudy-night',
				'.better-weather.with-natural-background.state-sunrise.state-sunrise',
				'.better-weather.with-natural-background.state-sunset.state-sunset',
				'.better-weather.with-natural-background.state-sunset.state-sunset[max-width~="400px"]'
			),
			'prop'     => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
			'type'     => 'background-image'
		)
	)
);
$fields['style_all_bg_color'] = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-clear-day.state-clear-day',
				'.better-weather.with-natural-background.state-clear-night.state-clear-night',
				'.better-weather.with-natural-background.state-rain.state-rain',
				'.better-weather.with-natural-background.state-snow.state-snow',
				'.better-weather.with-natural-background.state-sleet.state-sleet',
				'.better-weather.with-natural-background.state-wind.state-wind',
				'.better-weather.with-natural-background.state-fog.state-fog',
				'.better-weather.with-natural-background.state-thunderstorm.state-thunderstorm',
				'.better-weather.with-natural-background.state-cloudy.state-cloudy',
				'.better-weather.with-natural-background.state-partly-cloudy-day.state-partly-cloudy-day',
				'.better-weather.with-natural-background.state-partly-cloudy-night.state-partly-cloudy-night',
				'.better-weather.with-natural-background.state-sunrise.state-sunrise',
				'.better-weather.with-natural-background.state-sunset.state-sunset',
				'.better-weather.with-natural-background.state-sunset.state-sunset[max-width~="400px"]'
			),
			'prop'     => 'background-color'
		)
	)
);


/**
 * => Style -> Clear Day
 */
$fields['style_clear_day_bg_img']   = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-clear-day.state-clear-day'
			),
			'prop'     => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
			'type'     => 'background-image'
		)
	)
);
$fields['style_clear_day_bg_color'] = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-clear-day.state-clear-day',
			),
			'prop'     => 'background-color'
		)
	)
);


/**
 * => Style -> Clear Night
 */
$fields['style_clear_night_bg_img']   = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-clear-night.state-clear-night'
			),
			'prop'     => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
			'type'     => 'background-image'
		)
	)
);
$fields['style_clear_night_bg_color'] = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-clear-night.state-clear-night',
			),
			'prop'     => 'background-color'
		)
	)
);


/**
 * => Style -> Rain
 */
$fields['style_rain_bg_img']   = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-rain.state-rain'
			),
			'prop'     => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
			'type'     => 'background-image'
		)
	)
);
$fields['style_rain_bg_color'] = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-rain.state-rain',
			),
			'prop'     => 'background-color'
		)
	)
);


/**
 * => Style -> Snow
 */
$fields['style_snow_bg_img']   = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-snow.state-snow'
			),
			'prop'     => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
			'type'     => 'background-image'
		)
	)
);
$fields['style_snow_bg_color'] = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-snow.state-snow',
			),
			'prop'     => 'background-color'
		)
	)
);


/**
 * => Style -> Cloudy
 */
$fields['style_cloudy_bg_img']   = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-cloudy.state-cloudy.state-cloudy.state-cloudy'
			),
			'prop'     => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
			'type'     => 'background-image',
			'after'    => '
					.better-weather.with-natural-background.state-cloudy.state-cloudy.style-modern[max-width~="170px"],
					.better-weather.with-natural-background.state-cloudy.state-cloudy.style-normal[max-width~="170px"],
					.better-weather.with-natural-background.state-cloudy.state-cloudy.style-normal[max-width~="300px"],
					.better-weather.with-natural-background.state-cloudy.state-cloudy.style-modern[max-width~="300px"],
					.better-weather.with-natural-background.state-cloudy.state-cloudy.style-normal[max-width~="400px"],
					.better-weather.with-natural-background.state-cloudy.state-cloudy.style-modern[max-width~="400px"],
					.better-weather.with-natural-background.state-cloudy.state-cloudy.style-normal[max-width~="400px"],
					.better-weather.with-natural-background.state-cloudy.state-cloudy.style-modern[max-width~="400px"],
					.better-weather.with-natural-background.state-cloudy.state-cloudy[max-width~="550px"],
					.better-weather.with-natural-background.state-cloudy.state-cloudy[max-width~="650px"],
					.better-weather.with-natural-background.state-cloudy.state-cloudy[max-width~="830px"],
					.better-weather.with-natural-background.state-cloudy.state-cloudy[max-width~="970px"],
					.better-weather.with-natural-background.state-cloudy.state-cloudy[max-width~="1170px"]
					 {
  background-position: center center !important; }',
		)
	),
);
$fields['style_cloudy_bg_color'] = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-cloudy.state-cloudy',
			),
			'prop'     => 'background-color'
		)
	)
);


/**
 * => Style -> Partly Cloudy Day
 */
$fields['style_partly_cloudy_day_bg_img']   = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-partly-cloudy-day.state-partly-cloudy-day'
			),
			'prop'     => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
			'type'     => 'background-image',
			'after'    => '
					.better-weather.with-natural-background.state-partly-cloudy-day.state-partly-cloudy-day[max-width~="830px"],
					.better-weather.with-natural-background.state-partly-cloudy-day.state-partly-cloudy-day[max-width~="170px"],
					.better-weather.with-natural-background.state-partly-cloudy-day.state-partly-cloudy-day[max-width~="100px"],
					.better-weather.with-natural-background.state-partly-cloudy-day.state-partly-cloudy-day[max-width~="970px"],
					.better-weather.with-natural-background.state-partly-cloudy-day.state-partly-cloudy-day[max-width~="1170px"]{ background-position: center center !important; }',
		)
	),
);
$fields['style_partly_cloudy_day_bg_color'] = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-partly-cloudy-day.state-partly-cloudy-day',
			),
			'prop'     => 'background-color'
		)
	)
);


/**
 * => Style -> Partly Cloudy Night
 */
$fields['style_partly_cloudy_night_bg_img']   = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-partly-cloudy-night.state-partly-cloudy-night'
			),
			'prop'     => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
			'type'     => 'background-image',
			'after'    => '
					.better-weather.with-natural-background.state-partly-cloudy-night.state-partly-cloudy-night.have-next-days[max-width~="400px"],
					.better-weather.with-natural-background.state-partly-cloudy-night.state-partly-cloudy-night[max-width~="1170px"]{ background-position: center center !important; }',
		)
	),
);
$fields['style_partly_cloudy_night_bg_color'] = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-partly-cloudy-night.state-partly-cloudy-night',
			),
			'prop'     => 'background-color'
		)
	)
);


/**
 * => Style -> Sunrise
 */
$fields['style_sunrise_bg_img']   = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-sunrise.state-sunrise'
			),
			'prop'     => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
			'type'     => 'background-image',
			'after'    => '
					.better-weather.with-natural-background.state-sunrise.state-sunrise[max-width~="970px"],
					.better-weather.with-natural-background.state-sunrise.state-sunrise[max-width~="870px"],
					.better-weather.with-natural-background.state-sunrise.state-sunrise[max-width~="770px"],
					.better-weather.with-natural-background.state-sunrise.state-sunrise[max-width~="670px"],
					.better-weather.with-natural-background.state-sunrise.state-sunrise.style-modern[max-width~="400px"],
					.better-weather.with-natural-background.state-sunrise.state-sunrise.style-normal[max-width~="400px"],
					.better-weather.with-natural-background.state-sunrise.state-sunrise.style-modern[max-width~="300px"],
					.better-weather.with-natural-background.state-sunrise.state-sunrise.style-normal[max-width~="300px"],
					.better-weather.with-natural-background.state-sunrise.state-sunrise.style-modern[max-width~="170px"],
					.better-weather.with-natural-background.state-sunrise.state-sunrise.style-normal[max-width~="170px"],
					.better-weather.with-natural-background.state-sunrise.state-sunrise.have-next-days[max-width~="100px"],
					.better-weather.with-natural-background.state-sunrise.state-sunrise[max-width~="100px"],
					.better-weather.with-natural-background.state-sunrise.state-sunrise[max-width~="1070px"],
					.better-weather.with-natural-background.state-sunrise.state-sunrise[max-width~="1170px"]{ background-position: center center !important; }',
		)
	),
);
$fields['style_sunrise_bg_color'] = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-sunrise.state-sunrise',
			),
			'prop'     => 'background-color'
		)
	)
);


/**
 * => Style -> Sunset
 */
$fields['style_sunset_bg_img']   = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-sunset.state-sunset',
				'.better-weather.with-natural-background.state-sunset.state-sunset[max-width~="400px"]'
			),
			'prop'     => array(
				'background-image' => '%%value%% !important; background-position: center center !important;',
			),
			'type'     => 'background-image',
			'after'    => '
					.better-weather.with-natural-background.state-sunset.state-sunset[max-width~="970px"],
					.better-weather.with-natural-background.state-sunset.state-sunset[max-width~="870px"],
					.better-weather.with-natural-background.state-sunset.state-sunset[max-width~="770px"],
					.better-weather.with-natural-background.state-sunset.state-sunset[max-width~="670px"],
					.better-weather.with-natural-background.state-sunset.state-sunset[max-width~="570px"],
					.better-weather.with-natural-background.state-sunset.state-sunset[max-width~="470px"],
					.better-weather.with-natural-background.state-sunset.state-sunset[max-width~="400px"],
					.better-weather.with-natural-background.state-sunset.state-sunset.have-next-days[max-width~="400px"],
					.better-weather.with-natural-background.state-sunset.state-sunset[max-width~="350px"],
					.better-weather.with-natural-background.state-sunset.state-sunset[max-width~="300px"],
					.better-weather.with-natural-background.state-sunset.state-sunset.have-next-days[max-width~="250px"],
					.better-weather.with-natural-background.state-sunset.state-sunset[max-width~="250px"],
					.better-weather.with-natural-background.state-sunset.state-sunset[max-width~="200px"],
					.better-weather.with-natural-background.state-sunset.state-sunset.have-next-days[max-width~="200px"],
					.better-weather.with-natural-background.state-sunset.state-sunset.have-next-days[max-width~="170px"],
					.better-weather.with-natural-background.state-sunset.state-sunset.have-next-days[max-width~="470px"],
					.better-weather.with-natural-background.state-sunset.state-sunset[max-width~="170px"],
					.better-weather.with-natural-background.state-sunset.state-sunset[max-width~="120px"],
					.better-weather.with-natural-background.state-sunset.state-sunset.have-next-days[max-width~="120px"],
					.better-weather.with-natural-background.state-sunset.state-sunset[max-width~="1070px"]{background-position: center center !important; }',
		),
	),
);
$fields['style_sunset_bg_color'] = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-sunset.state-sunset',
			),
			'prop'     => 'background-color'
		)
	)
);

/**
 * => Style -> Sleet
 */
$fields['style_sleet_bg_img']   = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-sleet.state-sleet'
			),
			'prop'     => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
			'type'     => 'background-image'
		)
	)
);
$fields['style_sleet_bg_color'] = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-sleet.state-sleet',
			),
			'prop'     => 'background-color'
		)
	)
);


/**
 * => Style -> Wind
 */
$fields['style_wind_bg_img']   = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-wind.state-wind'
			),
			'prop'     => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
			'type'     => 'background-image'
		)
	)
);
$fields['style_wind_bg_color'] = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-wind.state-wind',
			),
			'prop'     => 'background-color'
		)
	)
);


/**
 * => Style -> Fog
 */
$fields['style_fog_bg_img']   = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-fog.state-fog'
			),
			'prop'     => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
			'type'     => 'background-image'
		)
	)
);
$fields['style_fog_bg_color'] = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-fog.state-fog',
			),
			'prop'     => 'background-color'
		)
	)
);


/**
 * => Style -> Thunderstorm
 */
$fields['style_thunderstorm_bg_img']   = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-thunderstorm.state-thunderstorm'
			),
			'after'    => '
					 .better-weather.with-natural-background.state-thunderstorm.state-thunderstorm[max-width~="970px"],
					 .better-weather.have-next-days.with-natural-background.state-thunderstorm.state-thunderstorm[max-width~="970px"],
					 .better-weather.with-natural-background.state-thunderstorm.state-thunderstorm[max-width~="830px"],
					 .better-weather.with-natural-background.state-thunderstorm.state-thunderstorm[max-width~="650px"],
					 .better-weather.with-natural-background.state-thunderstorm.state-thunderstorm[max-width~="550px"],
					 .better-weather.with-natural-background.state-thunderstorm.state-thunderstorm.style-modern[max-width~="400px"],
					 .better-weather.with-natural-background.state-thunderstorm.state-thunderstorm.style-normal[max-width~="400px"],
					 .better-weather.with-natural-background.state-thunderstorm.state-thunderstorm.style-modern[max-width~="300px"],
					 .better-weather.with-natural-background.state-thunderstorm.state-thunderstorm.style-normal[max-width~="300px"],
					 .better-weather.with-natural-background.state-thunderstorm.state-thunderstorm.style-modern[max-width~="170px"],
					 .better-weather.with-natural-background.state-thunderstorm.state-thunderstorm.style-normal[max-width~="170px"],
					 .better-weather.with-natural-background.state-thunderstorm.state-thunderstorm.style-normal[max-width~="100px"],
					 .better-weather.with-natural-background.state-thunderstorm.state-thunderstorm.style-modern[max-width~="100px"]
					 {
  background-position: center center !important; }',
			'prop'     => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
			'type'     => 'background-image'
		)
	)
);
$fields['style_thunderstorm_bg_color'] = array(
	'css' => array(
		array(
			'selector' => array(
				'.better-weather.with-natural-background.state-thunderstorm.state-thunderstorm',
			),
			'prop'     => 'background-color'
		)
	)
);
