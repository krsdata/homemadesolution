<?php

/**
 * Used for retrieving social data from social sites and caching them
 */
class Better_Social_Counter_Data_Manager {


	/**
	 * Contain live instance object class
	 *
	 * @var Better_Social_Counter_Data_Manager
	 */
	private static $instance;


	/**
	 * Cached value for counts
	 *
	 * @var array
	 */
	private $cache = array();


	/**
	 * Contain sites that supported in class
	 *
	 * @var array
	 */
	private $supported_sites = array(
		'facebook',
		'twitter',
		'google',
		'youtube',
		'dribbble',
		'vimeo',
		'delicious',
		'soundcloud',
		'github',
		'behance',
		'vk',
		'vine',
		'pinterest',
		'flickr',
		'steam',
		'instagram',
		'forrst',
		'mailchimp',
		'envato',
		'posts',
		'comments',
		'members',
		'rss',
		'telegram',
		'line',
		'viber',
		'bbm',
		'appstore',
		'android',
	);


	/**
	 * Used for retrieving instance of class
	 *
	 * @param bool $fresh
	 *
	 * @return Better_Social_Counter_Data_Manager
	 */
	public static function self( $fresh = FALSE ) {

		// get fresh instance
		if ( $fresh ) {
			self::$instance = new Better_Social_Counter_Data_Manager();

			return self::$instance;
		}

		if ( isset( self::$instance ) && ( self::$instance instanceof Better_Social_Counter_Data_Manager ) ) {
			return self::$instance;
		}

		self::$instance = new Better_Social_Counter_Data_Manager();

		return self::$instance;
	}


	/**
	 * Used for retrieving data for a social site
	 *
	 * @param      $id
	 * @param bool $fresh
	 *
	 * @return bool|mixed
	 */
	public function get_transient( $id, $fresh = FALSE ) {

		if ( isset( $this->cache[ $id ] ) && ! $fresh ) {
			return $this->cache[ $id ];
		}

		// id = better framework social counter cache ;)
		$temp = get_transient( 'better_social_counter_data_' . $id );

		if ( $temp === FALSE ) {
			return FALSE;
		}

		$this->cache[ $id ] = $temp;

		return $temp;
	}


	/**
	 * Save a value in WP cache system
	 *
	 * @param $id
	 * @param $data
	 *
	 * @return bool
	 */
	public function set_transient( $id, $data ) {
		return set_transient( 'better_social_counter_data_' . $id, $data, Better_Social_Counter::get_option( 'cache_time' ) * HOUR_IN_SECONDS );
	}


	/**
	 * clear cache in WP cache system
	 *
	 * @param $id
	 *
	 * @return bool
	 */
	public function clear_transient( $id ) {
		return delete_transient( 'better_social_counter_data_' . $id );
	}


	/**
	 * Deletes cached data
	 *
	 * @param string $key
	 */
	public static function clear_cache( $key = 'all' ) {

		if ( $key == 'all' ) {

			global $wpdb;

			$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->options WHERE option_name LIKE %s", '_transient_better_social_counter_data_%' ) );
			$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->options WHERE option_name LIKE %s", '_transient_timeout_better_social_counter_data_%' ) );

		} else {

			self::self()->clear_transient( $key );

		}
	}


	/**
	 * Format number to human friendly style
	 *
	 * @param $number
	 *
	 * @return string
	 */
	private function format_number( $number ) {

		if ( ! is_numeric( $number ) ) {
			return $number;
		}

		if ( $number >= 1000000 ) {
			return round( ( $number / 1000 ) / 1000, 1 ) . "M";
		} elseif ( $number >= 100000 ) {
			return round( $number / 1000, 0 ) . "k";
		} else {
			return @number_format( $number );
		}
	}


	/**
	 * used for getting sites data in out of class
	 *
	 * @param string $id
	 *
	 * @return array
	 */
	public static function get_full_data( $id = '' ) {

		// at first create an instance of class
		self::self();

		// if id empty or invalid id
		if ( empty( $id ) || ! in_array( $id, self::self()->supported_sites ) ) {
			return '';
		}

		$id = str_replace( '-', '_', $id );

		$function = 'get_' . $id . '_full_data';

		if ( method_exists( self::self(), $function ) ) {
			return call_user_func( array( self::self(), $function ) );
		} else {
			return FALSE;
		}
	}


	/**
	 * used for getting sites data in out of class
	 *
	 * @param string $id
	 *
	 * @return array
	 */
	public static function get_short_data( $id = '' ) {

		// at first create an instance of class
		self::self();

		// if id empty or invalid id
		if ( empty( $id ) || ! in_array( $id, self::self()->supported_sites ) ) {
			return '';
		}

		$id = str_replace( '-', '_', $id );

		$function = 'get_' . $id . '_short_data';

		if ( method_exists( self::self(), $function ) ) {
			return call_user_func( array( self::self(), $function ) );
		} else {
			return FALSE;
		}
	}


	/**
	 * Get remote data
	 *
	 * @param      $url
	 * @param bool $json
	 *
	 * @return array|mixed|string
	 */
	private function remote_get( $url, $json = TRUE ) {

		$get_request = wp_remote_get( $url, array( 'timeout' => 18, 'sslverify' => FALSE ) );

		$request = wp_remote_retrieve_body( $get_request );

		if ( $json ) {
			$request = @json_decode( $request, TRUE );
		}

		return $request;
	}


	/**
	 * Used for checking if a social site fields is prepared for getting data
	 *
	 * @param $id
	 *
	 * @return bool
	 */
	public function is_active( $id ) {

		if ( ! in_array( $id, $this->supported_sites ) ) {
			return FALSE;
		}

		switch ( $id ) {

			case 'facebook':
				return Better_Social_Counter::get_option( 'facebook_page' ) !== '';
				break;

			case 'twitter':
				return Better_Social_Counter::get_option( 'twitter_username' ) !== '';
				break;

			case 'google':
				return Better_Social_Counter::get_option( 'google_page' ) !== '';
				break;

			case 'youtube':
				return Better_Social_Counter::get_option( 'youtube_username' ) !== '';
				break;

			case 'dribbble':
				return Better_Social_Counter::get_option( 'dribbble_username' ) !== '';
				break;

			case 'vimeo':
				if ( Better_Social_Counter::get_option( 'vimeo_username' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'delicious':
				if ( Better_Social_Counter::get_option( 'delicious_username' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'soundcloud':
				if ( Better_Social_Counter::get_option( 'soundcloud_username' ) == '' ||
				     Better_Social_Counter::get_option( 'soundcloud_api_key' ) == ''
				) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'github':
				if ( Better_Social_Counter::get_option( 'github_username' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'behance':
				return Better_Social_Counter::get_option( 'behance_username' ) !== '';
				break;

			case 'vk':
				if ( Better_Social_Counter::get_option( 'vk_username' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'vine':
				if ( Better_Social_Counter::get_option( 'vine_profile' ) == '' ||
				     Better_Social_Counter::get_option( 'vine_email' ) == '' ||
				     Better_Social_Counter::get_option( 'vine_pass' ) == ''
				) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'pinterest':
				if ( Better_Social_Counter::get_option( 'pinterest_username' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'flickr':
				return Better_Social_Counter::get_option( 'flickr_group' ) !== '';
				break;

			case 'steam':
				if ( Better_Social_Counter::get_option( 'steam_group' ) == '' ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'instagram':
				if ( Better_Social_Counter::get_option( 'instagram_username' ) == '' ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'telegram':
				if ( Better_Social_Counter::get_option( 'telegram_link' ) == '' ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'line':
				if ( Better_Social_Counter::get_option( 'line_link' ) == '' ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'viber':
				if ( Better_Social_Counter::get_option( 'viber_link' ) == '' ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'bbm':
				if ( Better_Social_Counter::get_option( 'bbm_link' ) == '' ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'appstore':
				if ( Better_Social_Counter::get_option( 'appstore_link' ) == '' ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'android':
				if ( Better_Social_Counter::get_option( 'android_link' ) == '' ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'forrst':
				if ( Better_Social_Counter::get_option( 'forrst_username' ) == '' ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'mailchimp':
				if ( Better_Social_Counter::get_option( 'mailchimp_list_id' ) == '' ||
				     Better_Social_Counter::get_option( 'mailchimp_list_url' ) == '' ||
				     Better_Social_Counter::get_option( 'mailchimp_api_key' ) == ''
				) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'envato':
				if ( Better_Social_Counter::get_option( 'envato_username' ) == '' ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'posts':
				if ( ! Better_Social_Counter::get_option( 'posts_enabled' ) ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'comments':
				if ( ! Better_Social_Counter::get_option( 'comments_enabled' ) ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'members':
				if ( ! Better_Social_Counter::get_option( 'members_enabled' ) ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'rss':
				return TRUE;
				break;
		}
	}


	/**
	 * Used for checking if a social site fields is prepared for getting data
	 *
	 * minimum requirements will be checked.
	 *
	 * @param $id
	 *
	 * @return bool
	 */
	public function is_min_active( $id ) {

		if ( ! in_array( $id, $this->supported_sites ) ) {
			return FALSE;
		}

		switch ( $id ) {

			case 'facebook':
			case 'twitter':
			case 'google':
			case 'youtube':
			case 'dribbble':
			case 'behance':
			case 'flickr':

				return $this->is_active( $id );
				break;

			case 'vimeo':
				if ( Better_Social_Counter::get_option( 'vimeo_username' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'telegram':
				if ( Better_Social_Counter::get_option( 'telegram_link' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'line':
				if ( Better_Social_Counter::get_option( 'line_link' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'viber':
				if ( Better_Social_Counter::get_option( 'viber_link' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'bbm':
				if ( Better_Social_Counter::get_option( 'bbm_link' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'appstore':
				if ( Better_Social_Counter::get_option( 'appstore_link' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'android':
				if ( Better_Social_Counter::get_option( 'android_link' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'delicious':
				if ( Better_Social_Counter::get_option( 'delicious_username' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'soundcloud':
				if ( Better_Social_Counter::get_option( 'soundcloud_username' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'github':
				if ( Better_Social_Counter::get_option( 'github_username' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'vk':
				if ( Better_Social_Counter::get_option( 'vk_username' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'vine':
				if ( Better_Social_Counter::get_option( 'vine_profile' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'pinterest':
				if ( Better_Social_Counter::get_option( 'pinterest_username' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'steam':
				if ( Better_Social_Counter::get_option( 'steam_group' ) == '' ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'instagram':
				if ( Better_Social_Counter::get_option( 'instagram_username' ) == '' ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'forrst':
				if ( Better_Social_Counter::get_option( 'forrst_username' ) == '' ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'mailchimp':
				if ( Better_Social_Counter::get_option( 'mailchimp_list_id' ) == '' ) {
					return FALSE;
				} else {
					return TRUE;
				}
				break;

			case 'envato':
				if ( Better_Social_Counter::get_option( 'envato_username' ) == '' ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'posts':
				if ( ! Better_Social_Counter::get_option( 'posts_enabled' ) ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'comments':
				if ( ! Better_Social_Counter::get_option( 'comments_enabled' ) ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'members':
				if ( ! Better_Social_Counter::get_option( 'members_enabled' ) ) {
					return FALSE;
				}

				return TRUE;
				break;

			case 'rss':
				return TRUE;
				break;

		}
	}


	/**
	 * Used for retrieving an array that contain sites list with specified active sites for widgets backend fields
	 *
	 * @return array
	 */
	function get_widget_options_list() {

		$result       = array();
		$active_items = array();

		//
		// Facebook
		//
		$facebook_active = $this->is_active( 'facebook' );

		$temp = array(
			'facebook' => array(
				'label'     => 'Facebook',
				'css-class' => $facebook_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $facebook_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['facebook'] = $temp['facebook'];
		}


		//
		// Twitter
		//
		$twitter_active = $this->is_active( 'twitter' );

		$temp = array(
			'twitter' => array(
				'label'     => 'Twitter',
				'css-class' => $twitter_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $twitter_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['twitter'] = $temp['twitter'];
		}


		//
		// Google+
		//
		$google_active = $this->is_active( 'google' );

		$temp = array(
			'google' => array(
				'label'     => 'Google+',
				'css-class' => $google_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $google_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['google'] = $temp['google'];
		}


		//
		// Youtube
		//
		$youtube_active = $this->is_active( 'youtube' );

		$temp = array(
			'youtube' => array(
				'label'     => 'Youtube',
				'css-class' => $youtube_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $youtube_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['youtube'] = $temp['youtube'];
		}


		//
		// Telegram
		//
		$telegram_active = $this->is_active( 'telegram' );

		$temp = array(
			'telegram' => array(
				'label'     => 'Telegram',
				'css-class' => $telegram_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $telegram_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['telegram'] = $temp['telegram'];
		}


		//
		// Line
		//
		$line_active = $this->is_active( 'line' );

		$temp = array(
			'line' => array(
				'label'     => 'Line',
				'css-class' => $line_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $line_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['line'] = $temp['line'];
		}


		//
		// Viber
		//
		$viber_active = $this->is_active( 'viber' );

		$temp = array(
			'viber' => array(
				'label'     => 'Viber',
				'css-class' => $viber_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $viber_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['viber'] = $temp['viber'];
		}


		//
		// BBM
		//
		$bbm_active = $this->is_active( 'bbm' );

		$temp = array(
			'bbm' => array(
				'label'     => 'Blackberry',
				'css-class' => $bbm_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $bbm_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['bbm'] = $temp['bbm'];
		}


		//
		// AppStore
		//
		$appstore_active = $this->is_active( 'appstore' );

		$temp = array(
			'appstore' => array(
				'label'     => 'AppStore',
				'css-class' => $appstore_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $appstore_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['appstore'] = $temp['appstore'];
		}


		//
		// Google Play
		//
		$android_active = $this->is_active( 'android' );

		$temp = array(
			'android' => array(
				'label'     => 'Google Play',
				'css-class' => $android_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $android_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['android'] = $temp['android'];
		}


		//
		// Dribbble
		//
		$dribbble_active = $this->is_active( 'dribbble' );

		$temp = array(
			'dribbble' => array(
				'label'     => 'Dribbble',
				'css-class' => $dribbble_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $dribbble_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['dribbble'] = $temp['dribbble'];
		}


		//
		// Vimeo
		//
		$vimeo_active = $this->is_active( 'vimeo' );

		$temp = array(
			'vimeo' => array(
				'label'     => 'Vimeo',
				'css-class' => $vimeo_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $vimeo_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['vimeo'] = $temp['vimeo'];
		}


		//
		// Delicious
		//
		$delicious_active = $this->is_active( 'delicious' );

		$temp = array(
			'delicious' => array(
				'label'     => 'Delicious',
				'css-class' => $delicious_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $delicious_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['delicious'] = $temp['delicious'];
		}


		//
		// SoundCloud
		//
		$soundcloud_active = $this->is_active( 'soundcloud' );

		$temp = array(
			'soundcloud' => array(
				'label'     => 'SoundCloud',
				'css-class' => $soundcloud_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $soundcloud_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['soundcloud'] = $temp['soundcloud'];
		}


		//
		// Github
		//
		$github_active = $this->is_active( 'github' );

		$temp = array(
			'github' => array(
				'label'     => 'Github',
				'css-class' => $github_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $github_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['github'] = $temp['github'];
		}


		//
		// Behance
		//
		$behance_active = $this->is_active( 'behance' );

		$temp = array(
			'behance' => array(
				'label'     => 'Behance',
				'css-class' => $behance_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $behance_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['behance'] = $temp['behance'];
		}


		//
		// VK
		//
		$vk_active = $this->is_active( 'vk' );

		$temp = array(
			'vk' => array(
				'label'     => 'VK',
				'css-class' => $vk_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $vk_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['vk'] = $temp['vk'];
		}


		//
		// Vine
		//
		$vine_active = $this->is_active( 'vine' );

		$temp = array(
			'vine' => array(
				'label'     => 'Vine',
				'css-class' => $vine_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $vine_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['vine'] = $temp['vine'];
		}


		//
		// Pinterest
		//
		$pinterest = $this->is_active( 'pinterest' );

		$temp = array(
			'pinterest' => array(
				'label'     => 'Pinterest',
				'css-class' => $pinterest ? 'active-item' : 'disable-item'
			)
		);

		if ( $pinterest ) {
			$active_items = $active_items + $temp;
		} else {
			$result['pinterest'] = $temp['pinterest'];
		}


		//
		// Flickr
		//
		$flickr_active = $this->is_active( 'flickr' );

		$temp = array(
			'flickr' => array(
				'label'     => 'Flickr',
				'css-class' => $flickr_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $flickr_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['flickr'] = $temp['flickr'];
		}


		//
		// Steam
		//
		$steam_active = $this->is_active( 'steam' );

		$temp = array(
			'steam' => array(
				'label'     => 'Steam',
				'css-class' => $steam_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $steam_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['steam'] = $temp['steam'];
		}


		//
		// Instagram
		//
		$instagram_active = $this->is_active( 'instagram' );

		$temp = array(
			'instagram' => array(
				'label'     => 'Instagram',
				'css-class' => $instagram_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $instagram_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['instagram'] = $temp['instagram'];
		}


		//
		// Forrst
		//
		$forrst_active = $this->is_active( 'forrst' );

		$temp = array(
			'forrst' => array(
				'label'     => 'Forrst',
				'css-class' => $forrst_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $forrst_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['forrst'] = $temp['forrst'];
		}


		//
		// Mailchimp
		//
		$mailchimp_active = $this->is_active( 'mailchimp' );

		$temp = array(
			'mailchimp' => array(
				'label'     => 'Mailchimp',
				'css-class' => $mailchimp_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $mailchimp_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['mailchimp'] = $temp['mailchimp'];
		}


		//
		// Envato
		//
		$envato_active = $this->is_active( 'envato' );

		$temp = array(
			'envato' => array(
				'label'     => 'Envato',
				'css-class' => $envato_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $envato_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['envato'] = $temp['envato'];
		}


		//
		// Posts
		//
		$posts_active = $this->is_active( 'posts' );

		$temp = array(
			'posts' => array(
				'label'     => 'Posts',
				'css-class' => $posts_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $posts_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['posts'] = $temp['posts'];
		}


		//
		// Comments
		//
		$comments_active = $this->is_active( 'comments' );

		$temp = array(
			'comments' => array(
				'label'     => 'Comments',
				'css-class' => $comments_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $comments_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['comments'] = $temp['comments'];
		}


		//
		// Members
		//
		$members_active = $this->is_active( 'members' );

		$temp = array(
			'members' => array(
				'label'     => 'Members',
				'css-class' => $members_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $members_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['members'] = $temp['members'];
		}


		//
		// RSS
		//
		$active_items['rss'] = array(
			'label'     => 'RSS',
			'css-class' => 'active-item'
		);

		// add active sites to top of list
		$result = $active_items + $result;

		return $result;
	}


	/**
	 * Used for retrieving an array that contain sites list with specified active sites for widgets backend fields
	 *
	 * @return array
	 */
	function get_deferred_widget_options_list() {

		$result       = array();
		$active_items = array();

		$saved_options = get_option( 'better_social_counter_options' );

		//
		// Facebook
		//
		$facebook_active = TRUE;

		if ( empty( $saved_options['facebook_page'] ) ||
		     empty( $saved_options['facebook_app_secret'] ) ||
		     empty( $saved_options['facebook_app_id'] )
		) {
			$facebook_active = FALSE;
		}

		$temp = array(
			'facebook' => array(
				'label'     => 'Facebook',
				'css-class' => $facebook_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $facebook_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['facebook'] = $temp['facebook'];
		}


		//
		// Twitter
		//
		$twitter_active = TRUE;

		if ( empty( $saved_options['twitter_api_key'] ) ||
		     empty( $saved_options['twitter_api_secret'] ) ||
		     empty( $saved_options['twitter_username'] )
		) {
			$twitter_active = FALSE;
		}

		$temp = array(
			'twitter' => array(
				'label'     => 'Twitter',
				'css-class' => $twitter_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $twitter_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['twitter'] = $temp['twitter'];
		}


		//
		// Google+
		//
		$google_active = TRUE;

		if ( empty( $saved_options['google_page'] ) || empty( $saved_options['google_page_key'] ) ) {
			$google_active = FALSE;
		}

		$temp = array(
			'google' => array(
				'label'     => 'Google+',
				'css-class' => $google_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $google_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['google'] = $temp['google'];
		}


		//
		// Telegram
		//
		$telegram_active = TRUE;

		if ( empty( $saved_options['telegram_link'] ) ) {
			$telegram_active = FALSE;
		}

		$temp = array(
			'telegram' => array(
				'label'     => 'Telegram',
				'css-class' => $telegram_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $telegram_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['telegram'] = $temp['telegram'];
		}


		//
		// Line
		//
		$line_active = TRUE;

		if ( empty( $saved_options['line_link'] ) ) {
			$line_active = FALSE;
		}

		$temp = array(
			'line' => array(
				'label'     => 'Line',
				'css-class' => $line_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $line_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['line'] = $temp['line'];
		}


		//
		// Viber
		//
		$viber_active = TRUE;

		if ( empty( $saved_options['viber_link'] ) ) {
			$viber_active = FALSE;
		}

		$temp = array(
			'line' => array(
				'label'     => 'Viber',
				'css-class' => $viber_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $viber_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['viber'] = $temp['viber'];
		}


		//
		// BBM
		//
		$bbm_active = TRUE;

		if ( empty( $saved_options['bbm_link'] ) ) {
			$bbm_active = FALSE;
		}

		$temp = array(
			'line' => array(
				'label'     => 'Blackberry',
				'css-class' => $bbm_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $bbm_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['bbm'] = $temp['bbm'];
		}


		//
		// AppStore
		//
		$appstore_active = TRUE;

		if ( empty( $saved_options['appstore_link'] ) ) {
			$appstore_active = FALSE;
		}

		$temp = array(
			'line' => array(
				'label'     => 'AppStore',
				'css-class' => $appstore_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $appstore_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['appstore'] = $temp['appstore'];
		}


		//
		// Google Play
		//
		$android_active = TRUE;

		if ( empty( $saved_options['android_link'] ) ) {
			$android_active = FALSE;
		}

		$temp = array(
			'line' => array(
				'label'     => 'Google Play',
				'css-class' => $android_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $android_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['android'] = $temp['android'];
		}


		//
		// Youtube
		//
		$youtube_active = TRUE;

		if ( empty( $saved_options['youtube_username'] ) || empty( $saved_options['youtube_api_key'] ) ) {
			$youtube_active = FALSE;
		}

		$temp = array(
			'youtube' => array(
				'label'     => 'Youtube',
				'css-class' => $youtube_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $youtube_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['youtube'] = $temp['youtube'];
		}


		//
		// Dribbble
		//
		$dribbble_active = TRUE;

		if ( empty( $saved_options['dribbble_username'] ) || empty( $saved_options['dribbble_access_token'] ) ) {
			$dribbble_active = FALSE;
		}

		$temp = array(
			'dribbble' => array(
				'label'     => 'Dribbble',
				'css-class' => $dribbble_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $dribbble_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['dribbble'] = $temp['dribbble'];
		}


		//
		// Vimeo
		//
		$vimeo_active = TRUE;

		if ( empty( $saved_options['vimeo_username'] ) ) {
			$vimeo_active = FALSE;
		}

		$temp = array(
			'vimeo' => array(
				'label'     => 'Vimeo',
				'css-class' => $vimeo_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $vimeo_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['vimeo'] = $temp['vimeo'];
		}


		//
		// Delicious
		//
		$delicious_active = TRUE;

		if ( empty( $saved_options['delicious_username'] ) ) {
			$delicious_active = FALSE;
		}

		$temp = array(
			'delicious' => array(
				'label'     => 'Delicious',
				'css-class' => $delicious_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $delicious_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['delicious'] = $temp['delicious'];
		}


		//
		// SoundCloud
		//
		$soundcloud_active = TRUE;

		if ( empty( $saved_options['soundcloud_username'] ) || empty( $saved_options['soundcloud_api_key'] ) ) {
			$soundcloud_active = FALSE;
		}

		$temp = array(
			'soundcloud' => array(
				'label'     => 'SoundCloud',
				'css-class' => $soundcloud_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $soundcloud_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['soundcloud'] = $temp['soundcloud'];
		}


		//
		// Github
		//
		$github_active = TRUE;

		if ( empty( $saved_options['github_username'] ) ) {
			$github_active = FALSE;
		}

		$temp = array(
			'github' => array(
				'label'     => 'Github',
				'css-class' => $github_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $github_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['github'] = $temp['github'];
		}


		//
		// Behance
		//
		$behance_active = TRUE;

		if ( empty( $saved_options['behance_username'] ) ) {
			$behance_active = FALSE;
		}

		$temp = array(
			'behance' => array(
				'label'     => 'Behance',
				'css-class' => $behance_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $behance_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['behance'] = $temp['behance'];
		}


		//
		// VK
		//
		$vk_active = TRUE;

		if ( empty( $saved_options['vk_username'] ) ) {
			$vk_active = FALSE;
		}

		$temp = array(
			'vk' => array(
				'label'     => 'VK',
				'css-class' => $vk_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $vk_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['vk'] = $temp['vk'];
		}


		//
		// Vine
		//
		$vine_active = TRUE;

		if ( empty( $saved_options['vine_profile'] ) || empty( $saved_options['vine_email'] ) || empty( $saved_options['vine_pass'] ) ) {
			$vine_active = FALSE;
		}

		$temp = array(
			'vine' => array(
				'label'     => 'Vine',
				'css-class' => $vine_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $vine_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['vine'] = $temp['vine'];
		}


		//
		// Pinterest
		//
		$pinterest = TRUE;

		if ( empty( $saved_options['pinterest_username'] ) ) {
			$pinterest = FALSE;
		}

		$temp = array(
			'pinterest' => array(
				'label'     => 'Pinterest',
				'css-class' => $pinterest ? 'active-item' : 'disable-item'
			)
		);

		if ( $pinterest ) {
			$active_items = $active_items + $temp;
		} else {
			$result['pinterest'] = $temp['pinterest'];
		}


		//
		// Flickr
		//
		$flickr_active = TRUE;

		if ( empty( $saved_options['flickr_group'] ) || empty( $saved_options['flickr_key'] ) ) {
			$flickr_active = FALSE;
		}

		$temp = array(
			'flickr' => array(
				'label'     => 'Flickr',
				'css-class' => $flickr_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $flickr_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['flickr'] = $temp['flickr'];
		}


		//
		// Steam
		//
		$steam_active = TRUE;

		if ( empty( $saved_options['steam_group'] ) ) {
			$steam_active = FALSE;
		}

		$temp = array(
			'steam' => array(
				'label'     => 'Steam',
				'css-class' => $steam_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $steam_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['steam'] = $temp['steam'];
		}


		//
		// Instagram
		//
		$instagram_active = TRUE;

		if ( empty( $saved_options['instagram_username'] ) ) {
			$instagram_active = FALSE;
		}

		$temp = array(
			'instagram' => array(
				'label'     => 'Instagram',
				'css-class' => $instagram_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $instagram_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['instagram'] = $temp['instagram'];
		}


		//
		// Forrst
		//
		$forrst_active = TRUE;

		if ( empty( $saved_options['forrst_username'] ) ) {
			$forrst_active = FALSE;
		}

		$temp = array(
			'forrst' => array(
				'label'     => 'Forrst',
				'css-class' => $forrst_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $forrst_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['forrst'] = $temp['forrst'];
		}


		//
		// Mailchimp
		//
		$mailchimp_active = TRUE;

		if ( empty( $saved_options['mailchimp_list_id'] ) || empty( $saved_options['mailchimp_list_url'] ) || empty( $saved_options['mailchimp_api_key'] ) ) {
			$mailchimp_active = FALSE;
		}

		$temp = array(
			'mailchimp' => array(
				'label'     => 'Mailchimp',
				'css-class' => $mailchimp_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $mailchimp_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['mailchimp'] = $temp['mailchimp'];
		}


		//
		// Envato
		//
		$envato_active = TRUE;

		if ( empty( $saved_options['envato_username'] ) ) {
			$envato_active = FALSE;
		}

		$temp = array(
			'envato' => array(
				'label'     => 'Envato',
				'css-class' => $envato_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $envato_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['envato'] = $temp['envato'];
		}


		//
		// Posts
		//
		$posts_active = TRUE;

		if ( empty( $saved_options['posts_enabled'] ) && $saved_options['posts_enabled'] == FALSE ) {
			$posts_active = FALSE;
		}

		$temp = array(
			'posts' => array(
				'label'     => 'Posts',
				'css-class' => $posts_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $posts_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['posts'] = $temp['posts'];
		}


		//
		// Comments
		//
		$comments_active = TRUE;

		if ( empty( $saved_options['comments_enabled'] ) && $saved_options['comments_enabled'] == FALSE ) {
			$comments_active = FALSE;
		}

		$temp = array(
			'comments' => array(
				'label'     => 'Comments',
				'css-class' => $comments_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $comments_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['comments'] = $temp['comments'];
		}

		//
		// Members
		//
		$members_active = TRUE;

		if ( empty( $saved_options['members_enabled'] ) && $saved_options['members_enabled'] == FALSE ) {
			$members_active = FALSE;
		}

		$temp = array(
			'members' => array(
				'label'     => 'Members',
				'css-class' => $members_active ? 'active-item' : 'disable-item'
			)
		);

		if ( $members_active ) {
			$active_items = $active_items + $temp;
		} else {
			$result['members'] = $temp['members'];
		}


		// add active sites to top of list
		$result = $active_items + $result;

		return $result;
	}


	/**
	 * Returns sites list for select option
	 *
	 * @param bool $remove_extra remove extra sites for banner shortcode
	 *
	 * @return array
	 */
	public function get_select_options_for_banner( $remove_extra = TRUE, $add_select = FALSE ) {

		// Temp for active sites
		$sites_list = array(
			'' => __( '-- Select Site--', 'better-studio' ),
		);

		// Make final select options
		foreach ( self::get_widget_options_list() as $id => $site ) {

			if ( $site['css-class'] == 'disable-item' ) {
				$sites_list[ $id ] = array(
					'label'    => $site['label'] . ' ' . __( '( Disable )', 'better-studio' ),
					'disabled' => TRUE
				);
			} else {
				$sites_list[ $id ] = $site['label'];
			}
		}

		// Remove extra items
		if ( $remove_extra ) {
			unset( $sites_list['posts'] );
			unset( $sites_list['comments'] );
			unset( $sites_list['members'] );
		}

		return $sites_list;
	}


	/**
	 * Used for retrieving data for facebook
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_facebook_full_data( $id = 'facebook' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( 'facebook' ) ) !== FALSE ) {
			return $cached;
		}

		$page      = Better_Social_Counter::get_option( 'facebook_page' );
		$fan_count = 0;
		$request   = BetterFramework_Oculus::request(
			'get-facebook-fan-count',
			array(
				'data'         => compact( 'page' ),
				'group'        => 'social-counter',
				'use_wp_error' => FALSE
			)
		);
		if ( isset( $request->fan_count ) ) {
			$fan_count = $request->fan_count;
		}

		// Final result
		$final_result = array(
			'link'       => 'https://www.facebook.com/' . $page,
			'count'      => $this->format_number( $fan_count ),
			'title'      => Better_Social_Counter::get_option( 'facebook_title' ),
			'title_join' => Better_Social_Counter::get_option( 'facebook_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'facebook_button' ),
			'name'       => Better_Social_Counter::get_option( 'facebook_name' ),
		);

		$this->set_transient( 'facebook', $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving short data for facebook
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_facebook_short_data( $id = 'facebook' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'link'       => 'https://www.facebook.com/' . Better_Social_Counter::get_option( 'facebook_page' ),
			'title'      => Better_Social_Counter::get_option( 'facebook_title' ),
			'title_join' => Better_Social_Counter::get_option( 'facebook_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'facebook_name' ),
		);

	}


	/**
	 * Used for retrieving data for twitter
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_twitter_full_data( $id = 'twitter' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$username        = Better_Social_Counter::get_option( 'twitter_username' );
		$followers_count = 0;
		$request         = BetterFramework_Oculus::request(
			'get-twitter-followers-count',
			array(
				'data'         => compact( 'username' ),
				'group'        => 'social-counter',
				'use_wp_error' => FALSE
			)
		);

		if ( isset( $request->followers_count ) ) {
			$followers_count = $request->followers_count;
		}

		// Final result
		$final_result = array(
			'link'       => 'https://twitter.com/' . $username,
			'count'      => $this->format_number( $followers_count ),
			'title'      => Better_Social_Counter::get_option( 'twitter_title' ),
			'title_join' => Better_Social_Counter::get_option( 'twitter_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'twitter_button' ),
			'name'       => Better_Social_Counter::get_option( 'twitter_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for twitter
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_twitter_short_data( $id = 'twitter' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'link'       => 'https://twitter.com/' . Better_Social_Counter::get_option( 'twitter_username' ),
			'title'      => Better_Social_Counter::get_option( 'twitter_title' ),
			'title_join' => Better_Social_Counter::get_option( 'twitter_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'twitter_name' ),
		);
	}


	/**
	 * Used for retrieving data for Google Plus
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_google_full_data( $id = 'google' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$page      = Better_Social_Counter::get_option( 'google_page' );
		$followers = 0;
		$request   = BetterFramework_Oculus::request(
			'get-google-plus-followers',
			array(
				'data'         => compact( 'page' ),
				'group'        => 'social-counter',
				'use_wp_error' => FALSE
			)
		);

		if ( isset( $request->followers ) ) {
			$followers = $request->followers;
		}

		if ( ! preg_match( '/^(\d{20,22})$/', $page ) ) {
			$page = '+' . $page;
		}

		// Final result
		$final_result = array(
			'link'       => 'https://plus.google.com/' . $page,
			'count'      => $this->format_number( $followers ),
			'title'      => Better_Social_Counter::get_option( 'google_title' ),
			'title_join' => Better_Social_Counter::get_option( 'google_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'google_button' ),
			'name'       => Better_Social_Counter::get_option( 'google_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for Google Plus
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_google_short_data( $id = 'google' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		$page = Better_Social_Counter::get_option( 'google_page' );

		if ( ! preg_match( '/^(\d{20,22})$/', $page ) ) {
			$page = '+' . $page;
		}

		return array(
			'link'       => 'https://plus.google.com/' . $page,
			'title'      => Better_Social_Counter::get_option( 'google_title' ),
			'title_join' => Better_Social_Counter::get_option( 'google_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'google_name' ),
		);
	}


	/**
	 * Used for retrieving data for Youtube
	 *
	 * @param string $user_name
	 *
	 * @return bool|mixed
	 */
	private function get_youtube_full_data( $id = 'youtube' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$user_name  = Better_Social_Counter::get_option( 'youtube_username' );
		$subscriber = 0;
		$type       = '';
		$request    = BetterFramework_Oculus::request(
			'get-youtube-subscriber',
			array(
				'data'         => array(
					'id' => $user_name
				),
				'group'        => 'social-counter',
				'use_wp_error' => FALSE
			)
		);

		if ( isset( $request->subscriber ) ) {
			$subscriber = &$request->subscriber;
		}
		if ( isset( $request->type ) ) {
			$type = &$request->type;
		}

		// Final result
		$final_result = array(
			'link'       => '#',
			'count'      => $this->format_number( $subscriber ),
			'title'      => Better_Social_Counter::get_option( 'youtube_title' ),
			'title_join' => Better_Social_Counter::get_option( 'youtube_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'youtube_button' ),
			'name'       => Better_Social_Counter::get_option( 'youtube_name' )
		);

		if ( $type == 'channel' ) {
			$final_result['link'] = 'https://youtube.com/channel/' . $user_name;
		} else if ( $type == 'user' ) {
			$final_result['link'] = 'https://youtube.com/user/' . $user_name;
		}

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for Youtube
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_youtube_short_data( $id = 'youtube' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return $this->get_youtube_full_data( $id );
	}


	/**
	 * Used for retrieving data for Dribbble
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_dribbble_full_data( $id = 'dribbble' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$username        = Better_Social_Counter::get_option( 'dribbble_username' );
		$followers_count = 0;
		$request         = BetterFramework_Oculus::request(
			'get-dribbble-followers-count',
			array(
				'data'         => compact( 'username' ),
				'group'        => 'social-counter',
				'use_wp_error' => FALSE
			)
		);

		if ( isset( $request->followers_count ) ) {
			$followers_count = &$request->followers_count;
		}

		// Final result
		$final_result = array(
			'link'       => 'https://dribbble.com/' . $username,
			'count'      => $this->format_number( $followers_count ),
			'title'      => Better_Social_Counter::get_option( 'dribbble_title' ),
			'title_join' => Better_Social_Counter::get_option( 'dribbble_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'dribbble_button' ),
			'name'       => Better_Social_Counter::get_option( 'dribbble_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for Dribbble
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_dribbble_short_data( $id = 'dribbble' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'link'       => 'https://dribbble.com/' . Better_Social_Counter::get_option( 'dribbble_username' ),
			'title'      => Better_Social_Counter::get_option( 'dribbble_title' ),
			'title_join' => Better_Social_Counter::get_option( 'dribbble_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'dribbble_name' ),
		);
	}


	/**
	 * Used for retrieving data for Vimeo
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_vimeo_full_data( $id = 'vimeo' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$vimeo_type = Better_Social_Counter::get_option( 'vimeo_type' );

		$data = array();

		if ( $vimeo_type === 'user' ) {
			$data['username'] = Better_Social_Counter::get_option( 'vimeo_username' );
		} else {
			$data['channel'] = Better_Social_Counter::get_option( 'vimeo_username' );
		}

		$data['field'] = Better_Social_Counter::get_option( 'vimeo_data' );

		$request = BetterFramework_Oculus::request(
			'get-vimeo-info',
			array(
				'data'         => $data,
				'group'        => 'social-counter',
				'use_wp_error' => FALSE
			)
		);

		if ( isset( $request->total ) ) {
			$count = $request->total;
		} else {
			$count = 0;
		}

		$link = 'https://vimeo.com/';

		if ( $vimeo_type == 'channel' ) {
			$link .= 'channels/' . $data['channel'];
		} else {
			$link .= $data['username'];
		}

		// Final result
		$final_result = array(
			'link'       => $link,
			'count'      => $this->format_number( $count ),
			'title'      => Better_Social_Counter::get_option( 'vimeo_title' ),
			'title_join' => Better_Social_Counter::get_option( 'vimeo_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'vimeo_button' ),
			'name'       => Better_Social_Counter::get_option( 'vimeo_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for Vimeo
	 *
	 * @param string $id
	 *
	 * @return array
	 */
	private function get_vimeo_short_data( $id = 'vimeo' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		$vimeo_username = Better_Social_Counter::get_option( 'vimeo_username' );

		$vimeo_type = Better_Social_Counter::get_option( 'vimeo_type' );

		$link = 'https://vimeo.com/';

		if ( $vimeo_type == 'channel' ) {
			$link .= 'channels/' . $vimeo_username;
		} else {
			$link .= $vimeo_username;
		}

		return array(
			'link'       => $link,
			'title'      => Better_Social_Counter::get_option( 'vimeo_title' ),
			'title_join' => Better_Social_Counter::get_option( 'vimeo_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'vimeo_name' ),
		);
	}


	/**
	 * Used for retrieving data for Delicious
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_delicious_full_data( $id = 'delicious' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$delicious_username = Better_Social_Counter::get_option( 'delicious_username' );

		try {

			$data = $this->remote_get( "http://feeds.del.icio.us/v2/json/userinfo/" . $delicious_username );

			$result = (int) $data[2]['n'];

		} catch( Exception $e ) {
			$result = 0;
		}

		if ( ! isset( $result ) ) {
			$result = 0;
		}

		// Final result
		$final_result = array(
			'link'       => "https://del.icio.us/" . $delicious_username,
			'count'      => $this->format_number( $result ),
			'title'      => Better_Social_Counter::get_option( 'delicious_title' ),
			'title_join' => Better_Social_Counter::get_option( 'delicious_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'delicious_button' ),
			'name'       => Better_Social_Counter::get_option( 'delicious_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for Delicious
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_delicious_short_data( $id = 'delicious' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'link'       => "https://del.icio.us/" . Better_Social_Counter::get_option( 'delicious_username' ),
			'title'      => Better_Social_Counter::get_option( 'delicious_title' ),
			'title_join' => Better_Social_Counter::get_option( 'delicious_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'delicious_name' ),
		);
	}


	/**
	 * Used for retrieving data for SoundCloud
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_soundcloud_full_data( $id = 'soundcloud' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$soundcloud_username = Better_Social_Counter::get_option( 'soundcloud_username' );

		try {

			$data = $this->remote_get( "http://api.soundcloud.com/users/" . $soundcloud_username . ".json?consumer_key=" . Better_Social_Counter::get_option( 'soundcloud_api_key' ) );

			$result = (int) $data['followers_count'];

		} catch( Exception $e ) {
			$result = 0;
		}

		if ( ! isset( $result ) ) {
			$result = 0;
		}

		// Final result
		$final_result = array(
			'link'       => "https://soundcloud.com/" . $soundcloud_username,
			'count'      => $this->format_number( $result ),
			'title'      => Better_Social_Counter::get_option( 'soundcloud_title' ),
			'title_join' => Better_Social_Counter::get_option( 'soundcloud_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'soundcloud_button' ),
			'name'       => Better_Social_Counter::get_option( 'soundcloud_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for SoundCloud
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_soundcloud_short_data( $id = 'soundcloud' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'link'       => "https://soundcloud.com/" . Better_Social_Counter::get_option( 'soundcloud_username' ),
			'title'      => Better_Social_Counter::get_option( 'soundcloud_title' ),
			'title_join' => Better_Social_Counter::get_option( 'soundcloud_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'soundcloud_name' ),
		);
	}


	/**
	 * Used for retrieving data for Github
	 * TODO: add git hub repositories count
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_github_full_data( $id = 'github' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$github_username = Better_Social_Counter::get_option( 'github_username' );

		try {

			$data = $this->remote_get( "https://api.github.com/users/" . $github_username );

			$result = (int) $data['followers'];

		} catch( Exception $e ) {
			$result = 0;
		}

		if ( ! isset( $result ) ) {
			$result = 0;
		}

		// Final result
		$final_result = array(
			'link'       => "https://github.com/" . $github_username,
			'count'      => $this->format_number( $result ),
			'title'      => Better_Social_Counter::get_option( 'github_title' ),
			'title_join' => Better_Social_Counter::get_option( 'github_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'github_button' ),
			'name'       => Better_Social_Counter::get_option( 'github_name' )
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for Github
	 * TODO: add git hub repositories count
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_github_short_data( $id = 'github' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'link'       => "https://github.com/" . Better_Social_Counter::get_option( 'github_username' ),
			'title'      => Better_Social_Counter::get_option( 'github_title' ),
			'title_join' => Better_Social_Counter::get_option( 'github_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'github_name' )
		);
	}


	/**
	 * Used for retrieving data for behance
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_behance_full_data( $id = 'behance' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$username        = Better_Social_Counter::get_option( 'behance_username' );
		$followers_count = 0;
		$request         = BetterFramework_Oculus::request(
			'get-behance-followers-count',
			array(
				'data'         => compact( 'username' ),
				'group'        => 'social-counter',
				'use_wp_error' => FALSE
			)
		);

		if ( isset( $request->followers_count ) ) {
			$followers_count = &$request->followers_count;
		}

		// Final result
		$final_result = array(
			'link'       => "https://www.behance.net/" . $username,
			'count'      => $this->format_number( $followers_count ),
			'title'      => Better_Social_Counter::get_option( 'behance_title' ),
			'title_join' => Better_Social_Counter::get_option( 'behance_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'behance_button' ),
			'name'       => Better_Social_Counter::get_option( 'behance_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for behance
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_behance_short_data( $id = 'behance' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'link'       => "https://www.behance.net/" . Better_Social_Counter::get_option( 'behance_username' ),
			'title'      => Better_Social_Counter::get_option( 'behance_title' ),
			'title_join' => Better_Social_Counter::get_option( 'behance_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'behance_name' ),
		);
	}


	/**
	 * Used for retrieving data for VK
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_vk_full_data( $id = 'vk' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$vk_username = Better_Social_Counter::get_option( 'vk_username' );

		try {

			$data = $this->remote_get( "http://api.vk.com/method/groups.getById?gid=" . $vk_username . "&fields=members_count" );

			$result = (int) $data['response'][0]['members_count'];

		} catch( Exception $e ) {
			$result = 0;
		}

		if ( ! isset( $result ) ) {
			$result = 0;
		}

		// Final result
		$final_result = array(
			'link'       => "https://vk.com/" . $vk_username,
			'count'      => $this->format_number( $result ),
			'title'      => Better_Social_Counter::get_option( 'vk_title' ),
			'title_join' => Better_Social_Counter::get_option( 'vk_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'vk_button' ),
			'name'       => Better_Social_Counter::get_option( 'vk_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for VK
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_vk_short_data( $id = 'vk' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'link'       => "https://vk.com/" . Better_Social_Counter::get_option( 'vk_username' ),
			'title'      => Better_Social_Counter::get_option( 'vk_title' ),
			'title_join' => Better_Social_Counter::get_option( 'vk_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'vk_name' ),
		);
	}


	/**
	 * Used for retrieving data for Vine
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_vine_full_data( $id = 'vine' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		try {
			if ( ! class_exists( 'BSC_Vine' ) ) {
				require_once Better_Social_Counter()->dir_path() . 'includes/libs/class-bsc-vine.php';
			}

			$vine = new BF_Vine( Better_Social_Counter::get_option( 'vine_email' ), Better_Social_Counter::get_option( 'vine_pass' ) );

			$result = $vine->me();

			$result = $result['followerCount'];

		} catch( Exception $e ) {
			$result = 0;
		}

		if ( ! isset( $result ) ) {
			$result = 0;
		}

		// Final result
		$final_result = array(
			'link'       => "https://vine.com/" . Better_Social_Counter::get_option( 'vine_profile' ),
			'count'      => $this->format_number( $result ),
			'title'      => Better_Social_Counter::get_option( 'vine_title' ),
			'title_join' => Better_Social_Counter::get_option( 'vine_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'vine_button' ),
			'name'       => Better_Social_Counter::get_option( 'vine_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for Vine
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_vine_short_data( $id = 'vine' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'link'       => "http://vine.com/" . Better_Social_Counter::get_option( 'vine_profile' ),
			'title'      => Better_Social_Counter::get_option( 'vine_title' ),
			'title_join' => Better_Social_Counter::get_option( 'vine_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'vine_name' ),
		);
	}


	/**
	 * Used for retrieving data for Pinterest
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_pinterest_full_data( $id = 'pinterest' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$pinterest_username = Better_Social_Counter::get_option( 'pinterest_username' );

		try {

			$prev = libxml_use_internal_errors( TRUE );
			$html = $this->remote_get( "http://www.pinterest.com/" . $pinterest_username, FALSE );

			if ( class_exists( 'DOMDocument' ) && $html ) {
				$doc = new DOMDocument();

				@$doc->loadHTML( $html );
				libxml_use_internal_errors( $prev );

				$metas = $doc->getElementsByTagName( 'meta' );

				for ( $i = 0; $i < $metas->length; $i ++ ) {

					$meta = $metas->item( $i );

					if ( $meta->getAttribute( 'name' ) == 'pinterestapp:followers' ) {

						$result = $meta->getAttribute( 'content' );

						break;

					}

				}
			} else {
				$result = 0;
			}


		} catch( Exception $e ) {
			$result = 0;
		}

		if ( ! isset( $result ) ) {
			$result = 0;
		}

		// Final result
		$final_result = array(
			'link'       => "https://www.pinterest.com/" . $pinterest_username,
			'count'      => $this->format_number( $result ),
			'title'      => Better_Social_Counter::get_option( 'pinterest_title' ),
			'title_join' => Better_Social_Counter::get_option( 'pinterest_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'pinterest_button' ),
			'name'       => Better_Social_Counter::get_option( 'pinterest_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for Pinterest
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_pinterest_short_data( $id = 'pinterest' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'link'       => "https://www.pinterest.com/" . Better_Social_Counter::get_option( 'pinterest_username' ),
			'title'      => Better_Social_Counter::get_option( 'pinterest_title' ),
			'title_join' => Better_Social_Counter::get_option( 'pinterest_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'pinterest_name' ),
		);
	}


	/**
	 * Used for retrieving data for Flickr
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_flickr_full_data( $id = 'flickr' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$group_slug = Better_Social_Counter::get_option( 'flickr_group' );
		$members    = 0;
		$request    = BetterFramework_Oculus::request(
			'get-flickr-group-members',
			array(
				'data'         => compact( 'group_slug' ),
				'group'        => 'social-counter',
				'use_wp_error' => FALSE
			)
		);

		if ( isset( $request->group_members ) ) {
			$members = &$request->group_members;
		}

		// final result
		$final_result = array(
			'link'       => "https://www.flickr.com/groups/$group_slug",
			'count'      => $this->format_number( $members ),
			'title'      => Better_Social_Counter::get_option( 'flickr_title' ),
			'title_join' => Better_Social_Counter::get_option( 'flickr_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'flickr_button' ),
			'name'       => Better_Social_Counter::get_option( 'flickr_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for Flickr
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_flickr_short_data( $id = 'flickr' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'link'       => "https://www.flickr.com/groups/" . Better_Social_Counter::get_option( 'flickr_group' ),
			'title'      => Better_Social_Counter::get_option( 'flickr_title' ),
			'title_join' => Better_Social_Counter::get_option( 'flickr_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'flickr_name' ),
		);
	}


	/**
	 * Used for retrieving data for Steam
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_steam_full_data( $id = 'steam' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$steam_group = Better_Social_Counter::get_option( 'steam_group' );

		try {
			$prev = libxml_use_internal_errors( TRUE );
			$data = $this->remote_get( "http://steamcommunity.com/groups/$steam_group/memberslistxml", FALSE );

			if ( class_exists( 'SimpleXmlElement' ) ) {
				$data = @new SimpleXmlElement( $data );

				$result = (int) $data->groupDetails->memberCount;
			} else {
				$result = 0;
			}

			libxml_use_internal_errors( $prev );
			libxml_clear_errors();

		} catch ( Exception $e ) {
			$result = 0;
		}

		if ( ! isset( $result ) ) {
			$result = 0;
		}

		// Final result
		$final_result = array(
			'link'       => "https://steamcommunity.com/groups/$steam_group",
			'count'      => $this->format_number( $result ),
			'title'      => Better_Social_Counter::get_option( 'steam_title' ),
			'title_join' => Better_Social_Counter::get_option( 'steam_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'steam_button' ),
			'name'       => Better_Social_Counter::get_option( 'steam_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for Steam
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_steam_short_data( $id = 'steam' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'link'       => "https://steamcommunity.com/groups/" . Better_Social_Counter::get_option( 'steam_group' ),
			'title'      => Better_Social_Counter::get_option( 'steam_title' ),
			'title_join' => Better_Social_Counter::get_option( 'steam_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'steam_name' ),
		);
	}


	/**
	 * Used for retrieving data for Instagram
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_instagram_full_data( $id = 'instagram' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$instagram_username = Better_Social_Counter::get_option( 'instagram_username' );

		try {

			$data = $this->remote_get( "http://instagram.com/{$instagram_username}#", FALSE );

			$pattern = "/\"followed_by\":[ ]*{\"count\":(.*?)}/";

			preg_match( $pattern, $data, $matches );

			if ( ! empty( $matches[1] ) ) {

				$result = (int) $matches[1];

			} else {
				$result = 0;
			}

		} catch( Exception $e ) {
			$result = 0;
		}

		if ( ! isset( $result ) ) {
			$result = 0;
		}

		// Final result
		$final_result = array(
			'link'       => "https://instagram.com/$instagram_username",
			'count'      => $this->format_number( $result ),
			'title'      => Better_Social_Counter::get_option( 'instagram_title' ),
			'title_join' => Better_Social_Counter::get_option( 'instagram_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'instagram_button' ),
			'name'       => Better_Social_Counter::get_option( 'instagram_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for Instagram
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_instagram_short_data( $id = 'instagram' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'link'       => "https://instagram.com/" . Better_Social_Counter::get_option( 'instagram_username' ),
			'title'      => Better_Social_Counter::get_option( 'instagram_title' ),
			'title_join' => Better_Social_Counter::get_option( 'instagram_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'instagram_name' ),
		);
	}


	/**
	 * Used for retrieving data for Forrst
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_forrst_full_data( $id = 'forrst' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$forrst_username = Better_Social_Counter::get_option( 'forrst_username' );

		try {

			$data = $this->remote_get( "http://forrst.com/api/v2/users/info?username=" . $forrst_username );

			$result = (int) $data['resp']['typecast_followers'];

		} catch( Exception $e ) {
			$result = 0;
		}

		if ( ! isset( $result ) ) {
			$result = 0;
		}

		// final result
		$final_result = array(
			'link'       => "https://zurb.com/forrst/people/" . $forrst_username,
			'count'      => $this->format_number( $result ),
			'title'      => Better_Social_Counter::get_option( 'forrst_title' ),
			'title_join' => Better_Social_Counter::get_option( 'forrst_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'forrst_button' ),
			'name'       => Better_Social_Counter::get_option( 'forrst_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for Forrst
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_forrst_short_data( $id = 'forrst' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'link'       => "https://zurb.com/forrst/people/" . Better_Social_Counter::get_option( 'forrst_username' ),
			'title'      => Better_Social_Counter::get_option( 'forrst_title' ),
			'title_join' => Better_Social_Counter::get_option( 'forrst_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'forrst_name' ),
		);
	}


	/**
	 * Used for retrieving data for Mailchimp
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_mailchimp_full_data( $id = 'mailchimp' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		try {

			// Mail chimp API wrapper
			require_once Better_Social_Counter()->dir_path() . 'includes/libs/mailchimp/class-mcapi.php';

			$mc_list_id = Better_Social_Counter::get_option( 'mailchimp_list_id' );

			$mc_api_key = Better_Social_Counter::get_option( 'mailchimp_api_key' );

			$mc_api = new MCAPI( $mc_api_key );

			$lists = $mc_api->lists();

			$result = 0;

			if ( isset( $lists['data'] ) ) {
				foreach ( (array) $lists['data'] as $list ) {

					if ( $list['id'] == $mc_list_id ) {

						$result = $list['stats']['member_count'];
						break;

					}
				}
			}

		} catch( Exception $e ) {
			$result = 0;
		}

		if ( ! isset( $result ) ) {
			$result = 0;
		}

		// final result
		$final_result = array(
			'link'       => Better_Social_Counter::get_option( 'mailchimp_list_url' ),
			'count'      => $this->format_number( $result ),
			'title'      => Better_Social_Counter::get_option( 'mailchimp_title' ),
			'title_join' => Better_Social_Counter::get_option( 'mailchimp_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'mailchimp_button' ),
			'name'       => Better_Social_Counter::get_option( 'mailchimp_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for Mailchimp
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_mailchimp_short_data( $id = 'mailchimp' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'link'       => Better_Social_Counter::get_option( 'mailchimp_list_url' ),
			'title'      => Better_Social_Counter::get_option( 'mailchimp_title' ),
			'title_join' => Better_Social_Counter::get_option( 'mailchimp_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'mailchimp_name' ),
		);
	}


	/**
	 * Used for retrieving data for Envato
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_envato_full_data( $id = 'envato' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$envato_username    = Better_Social_Counter()->get_option( 'envato_username' );
		$envato_marketplace = Better_Social_Counter()->get_option( 'envato_marketplace' );

		if ( empty( $envato_marketplace ) ) {
			$envato_marketplace = 'themeforest';
		}

		try {

			$data = $this->remote_get( "http://marketplace.envato.com/api/edge/user:$envato_username.json" );

			if ( isset( $data['user']['followers'] ) ) {
				$result = (int) $data['user']['followers'];
			}

		} catch( Exception $e ) {
			$result = 0;
		}

		if ( ! isset( $result ) ) {
			$result = 0;
		}

		// final result
		$final_result = array(
			'link'       => 'https://' . $envato_marketplace . '.net/user/' . $envato_username . '?ref=' . $envato_username,
			'count'      => $this->format_number( $result ),
			'title'      => Better_Social_Counter::get_option( 'envato_title' ),
			'title_join' => Better_Social_Counter::get_option( 'envato_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'envato_button' ),
			'name'       => Better_Social_Counter::get_option( 'envato_' . $envato_marketplace . '_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving data for Envato
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_envato_short_data( $id = 'envato' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		$envato_username    = Better_Social_Counter()->get_option( 'envato_username' );
		$envato_marketplace = Better_Social_Counter()->get_option( 'envato_marketplace' );

		if ( empty( $envato_marketplace ) ) {
			$envato_marketplace = 'themeforest';
		}

		$final_result = array(
			'link'       => 'https://' . $envato_marketplace . '.net/user/' . $envato_username . '?ref=' . $envato_username,
			'title'      => Better_Social_Counter::get_option( 'envato_title' ),
			'title_join' => Better_Social_Counter::get_option( 'envato_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'envato_' . $envato_marketplace . '_name' ),
		);

		return $final_result;
	}


	/**
	 * Used for retrieving posts data
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_posts_full_data( $id = 'posts' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		try {

			$count_posts = wp_count_posts();

			$result = $count_posts->publish;

		} catch( Exception $e ) {
			$result = 0;
		}

		if ( ! isset( $result ) ) {
			$result = 0;
		}

		// final result
		$final_result = array(
			'count'      => $this->format_number( $result ),
			'title'      => Better_Social_Counter::get_option( 'posts_title' ),
			'title_join' => Better_Social_Counter::get_option( 'posts_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'posts_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving posts data
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_posts_short_data( $id = 'posts' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'title'      => Better_Social_Counter::get_option( 'posts_title' ),
			'title_join' => Better_Social_Counter::get_option( 'posts_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'posts_name' ),
		);
	}


	/**
	 * Used for retrieving comments data
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_comments_full_data( $id = 'comments' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		try {

			$comments_count = wp_count_comments();

			$result = $comments_count->approved;

		} catch( Exception $e ) {
			$result = 0;
		}

		if ( ! isset( $result ) ) {
			$result = 0;
		}

		// final result
		$final_result = array(
			'count'      => $this->format_number( $result ),
			'title'      => Better_Social_Counter::get_option( 'comments_title' ),
			'title_join' => Better_Social_Counter::get_option( 'comments_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'comments_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving comments data
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_comments_short_data( $id = 'comments' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'title'      => Better_Social_Counter::get_option( 'comments_title' ),
			'title_join' => Better_Social_Counter::get_option( 'comments_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'comments_name' ),
		);
	}


	/**
	 * Used for retrieving members data
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_members_full_data( $id = 'members' ) {

		if ( ! $this->is_active( $id ) ) {
			return FALSE;
		}

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		try {

			$members_count = count_users();

			$result = $members_count['total_users'];

		} catch( Exception $e ) {
			$result = 0;
		}

		if ( ! isset( $result ) ) {
			$result = 0;
		}

		// final result
		$final_result = array(
			'count'      => $this->format_number( $result ),
			'title'      => Better_Social_Counter::get_option( 'members_title' ),
			'title_join' => Better_Social_Counter::get_option( 'members_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'members_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving members data
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_members_short_data( $id = 'members' ) {

		if ( ! $this->is_min_active( $id ) ) {
			return FALSE;
		}

		return array(
			'title'      => Better_Social_Counter::get_option( 'members_title' ),
			'title_join' => Better_Social_Counter::get_option( 'members_title_join' ),
			'name'       => Better_Social_Counter::get_option( 'members_name' ),
		);
	}

	/**
	 * Used for retrieving RSS data
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_rss_full_data( $id = 'rss' ) {

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$type = Better_Social_Counter::get_option( 'rss_type' );
		$link = '';

		if ( $type === 'custom_link' ) {
			$link = Better_Social_Counter::get_option( 'rss_type_custom' );
		} elseif ( $type === 'category' ) {
			if ( $cat = Better_Social_Counter::get_option( 'rss_type_category' ) ) {
				$link = get_category_feed_link( $cat );
			}
		}

		if ( empty( $link ) ) {
			$link = get_bloginfo( 'rss_url' );
		}

		// final result
		$final_result = array(
			'link'       => $link,
			'count'      => 'RSS',
			'title'      => Better_Social_Counter::get_option( 'rss_title' ),
			'title_join' => Better_Social_Counter::get_option( 'rss_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'rss_button' ),
			'name'       => Better_Social_Counter::get_option( 'rss_name' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving RSS data
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_rss_short_data( $id = 'rss' ) {
		return $this->get_rss_full_data( $id );
	}


	/**
	 * Used for retrieving Telegram data
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_telegram_full_data( $id = 'telegram' ) {

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$link = Better_Social_Counter::get_option( 'telegram_link' );

		// final result
		$final_result = array(
			'link'       => $link,
			'count'      => Better_Social_Counter::get_option( 'telegram_name' ),
			'title'      => Better_Social_Counter::get_option( 'telegram_title' ),
			'title_join' => Better_Social_Counter::get_option( 'telegram_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'telegram_button' ),
			'name'       => Better_Social_Counter::get_option( 'telegram_title_join' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving Telegram data
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_telegram_short_data( $id = 'rss' ) {
		return $this->get_telegram_full_data( $id );
	}


	/**
	 * Used for retrieving Line data
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_line_full_data( $id = 'line' ) {

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$link = Better_Social_Counter::get_option( 'line_link' );

		// final result
		$final_result = array(
			'link'       => $link,
			'count'      => Better_Social_Counter::get_option( 'line_name' ),
			'title'      => Better_Social_Counter::get_option( 'line_title' ),
			'title_join' => Better_Social_Counter::get_option( 'line_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'line_button' ),
			'name'       => Better_Social_Counter::get_option( 'line_title_join' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving Line data
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_line_short_data( $id = 'line' ) {
		return $this->get_line_full_data( $id );
	}


	/**
	 * Used for retrieving Viber data
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_viber_full_data( $id = 'viber' ) {

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$link = Better_Social_Counter::get_option( 'viber_link' );

		// final result
		$final_result = array(
			'link'       => $link,
			'count'      => Better_Social_Counter::get_option( 'viber_name' ),
			'title'      => Better_Social_Counter::get_option( 'viber_title' ),
			'title_join' => Better_Social_Counter::get_option( 'viber_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'viber_button' ),
			'name'       => Better_Social_Counter::get_option( 'viber_title_join' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving Viber data
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_viber_short_data( $id = 'viber' ) {
		return $this->get_viber_full_data( $id );
	}


	/**
	 * Used for retrieving BlackBerry data
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_bbm_full_data( $id = 'bbm' ) {

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$link = Better_Social_Counter::get_option( 'bbm_link' );

		// final result
		$final_result = array(
			'link'       => $link,
			'count'      => Better_Social_Counter::get_option( 'bbm_name' ),
			'title'      => Better_Social_Counter::get_option( 'bbm_title' ),
			'title_join' => Better_Social_Counter::get_option( 'bbm_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'bbm_button' ),
			'name'       => Better_Social_Counter::get_option( 'bbm_title_join' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving BlackBerry data
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_bbm_short_data( $id = 'bbm' ) {
		return $this->get_bbm_full_data( $id );
	}


	/**
	 * Used for retrieving AppStore data
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_appstore_full_data( $id = 'appstore' ) {

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$link = Better_Social_Counter::get_option( 'appstore_link' );

		// final result
		$final_result = array(
			'link'       => $link,
			'count'      => Better_Social_Counter::get_option( 'appstore_name' ),
			'title'      => Better_Social_Counter::get_option( 'appstore_title' ),
			'title_join' => Better_Social_Counter::get_option( 'appstore_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'appstore_button' ),
			'name'       => Better_Social_Counter::get_option( 'appstore_title_join' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving AppStore data
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_appstore_short_data( $id = 'appstore' ) {
		return $this->get_appstore_full_data( $id );
	}


	/**
	 * Used for retrieving Google Play data
	 *
	 * @param string $id
	 *
	 * @return bool|mixed
	 */
	private function get_android_full_data( $id = 'android' ) {

		if ( ( $cached = $this->get_transient( $id ) ) !== FALSE ) {
			return $cached;
		}

		$link = Better_Social_Counter::get_option( 'android_link' );

		// final result
		$final_result = array(
			'link'       => $link,
			'count'      => Better_Social_Counter::get_option( 'android_name' ),
			'title'      => Better_Social_Counter::get_option( 'android_title' ),
			'title_join' => Better_Social_Counter::get_option( 'android_title_join' ),
			'button'     => Better_Social_Counter::get_option( 'android_button' ),
			'name'       => Better_Social_Counter::get_option( 'android_title_join' ),
		);

		$this->set_transient( $id, $final_result );

		return $final_result;
	}


	/**
	 * Used for retrieving Google Play data
	 *
	 * @param string $id
	 *
	 * @return array|bool
	 */
	private function get_android_short_data( $id = 'android' ) {
		return $this->get_android_full_data( $id );
	}

}
