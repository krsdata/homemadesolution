<?php
/***
 *  BetterFramework is BetterStudio framework for themes and plugins.
 *
 *  ______      _   _             ______                                           _
 *  | ___ \    | | | |            |  ___|                                         | |
 *  | |_/ / ___| |_| |_ ___ _ __  | |_ _ __ __ _ _ __ ___   _____      _____  _ __| | __
 *  | ___ \/ _ \ __| __/ _ \ '__| |  _| '__/ _` | '_ ` _ \ / _ \ \ /\ / / _ \| '__| |/ /
 *  | |_/ /  __/ |_| ||  __/ |    | | | | | (_| | | | | | |  __/\ V  V / (_) | |  |   <
 *  \____/ \___|\__|\__\___|_|    \_| |_|  \__,_|_| |_| |_|\___| \_/\_/ \___/|_|  |_|\_\
 *
 *  Copyright © 2017 Better Studio
 *
 *
 *  Our portfolio is here: http://themeforest.net/user/Better-Studio/portfolio
 *
 *  \--> BetterStudio, 2017 <--/
 */


if ( ! class_exists( 'BF_Exception' ) ) {

	/**
	 * Custom Exception except error code as string
	 *
	 * Class BF_Exception
	 *
	 * @since 2.7.0
	 */
	Class BF_Exception extends Exception {

		public function __construct( $message = '', $code = '', $previous = NULL ) {

			parent::__construct( $message, 0, $previous );
			$this->code = $code;
		}
	}
}

if ( ! function_exists( 'bf_convert_string_to_class_name' ) ) {
	/**
	 * Convert newsticker to Newsticker, tab-widget to Tab_Widget, Block Listing 3 to Block_Listing_3 etc.
	 *
	 * @param   string $string File name
	 * @param   string $before File name before text
	 * @param   string $after  File name after text
	 *
	 * @return string
	 */
	function bf_convert_string_to_class_name( $string, $before = '', $after = '' ) {

		$class = str_replace(
			array( '/', '-', ' ' ),
			'_',
			$string
		);

		$class = explode( '_', $class );

		$class = array_map( 'ucwords', $class );

		$class = implode( '_', $class );

		return $before . $class . $after;
	}
}


if ( ! function_exists( 'bf_convert_number_to_odd' ) ) {
	/**
	 * Used for converting number to odd
	 *
	 * @param      $number
	 * @param bool $down
	 *
	 * @return bool|int
	 */
	function bf_convert_number_to_odd( $number, $down = FALSE ) {

		if ( is_int( $number ) ) {

			if ( intval( $number ) % 2 == 0 ) {
				return $number;
			} else {

				if ( $down ) {
					return intval( $number ) - 1;
				} else {
					return intval( $number ) + 1;
				}

			}

		}

		return FALSE;
	}
}


if ( ! function_exists( 'bf_call_func' ) ) {
	function bf_call_func( $func = '', $params = '' ) {

		if ( ! is_callable( $func ) ) {
			return FALSE;
		}

		if ( ! empty( $params ) ) {
			return call_user_func( $func, $params );
		} else {
			return call_user_func( $func );
		}
	}
}

if ( ! function_exists( 'bf_is_doing_ajax' ) ) {
	/**
	 * Handy function to detect WP doing ajax
	 *
	 * @return bool
	 */
	function bf_is_doing_ajax() {
		return defined( 'DOING_AJAX' ) && DOING_AJAX;
	}
}


if ( ! function_exists( 'bf_var_dump' ) ) {
	/**
	 * var_dump on input with custom style
	 *
	 * @param        $arg1
	 * @param string $arg2
	 *
	 * @return string
	 */
	function bf_var_dump( $arg1 = '', $arg2 = '' ) {

		// line break
		if ( ! bf_is_doing_ajax() ) {
			$lb = '<br>';
		} else {
			$lb = "\n";
		}

		$bt = debug_backtrace();

		$arg = func_get_args();

		if ( ! bf_is_doing_ajax() ) {
			echo '<pre style="direction: ltr; text-align: left; background: #FFF8D7; border: 1px solid #E5D68D; margin: 10px 0; padding: 15px;">';
		}

		call_user_func_array( 'var_dump', $arg );

		if ( ! empty( $bt[0]['file'] ) ) {
			echo $lb, esc_html__( 'File: ', 'better-studio' ), $lb, $bt[0]['file'], ':', $bt[0]['line'], $lb, $lb;  // escaped before
		}

		if ( ! bf_is_doing_ajax() ) {
			echo '</pre>';
		}
	}
}


if ( ! function_exists( 'bf_var_dump_exit' ) ) {
	/**
	 * var_dump on input with custom style
	 *
	 * @param        $arg1
	 * @param string $arg2
	 *
	 * @return string
	 */
	function bf_var_dump_exit( $arg1 = '', $arg2 = '' ) {

		// line break
		if ( ! bf_is_doing_ajax() ) {
			$lb = '<br>';
		} else {
			$lb = "\n";
		}

		$bt = debug_backtrace();

		$arg = func_get_args();

		if ( ! bf_is_doing_ajax() ) {
			echo '<pre style="direction: ltr; text-align: left; background: #FFF8D7; border: 1px solid #E5D68D; margin: 10px 0; padding: 15px;">';
		}

		call_user_func_array( 'var_dump', $arg );

		if ( ! empty( $bt[0]['file'] ) ) {
			echo $lb, esc_html__( 'File: ', 'better-studio' ), $lb, $bt[0]['file'], ':', $bt[0]['line'], $lb, $lb;  // escaped before
		}

		if ( ! bf_is_doing_ajax() ) {
			echo '</pre>';
		}

		exit();
	}
}


if ( ! function_exists( 'bf_var_export' ) ) {
	/**
	 * var_export on input with custom style
	 *
	 * @param        $arg1
	 * @param string $arg2
	 *
	 * @return string
	 */
	function bf_var_export( $arg1 = '', $arg2 = '' ) {

		// line break
		if ( ! bf_is_doing_ajax() ) {
			$lb = '<br>';
		} else {
			$lb = "\n";
		}

		$bt = debug_backtrace();

		$arg = func_get_args();

		if ( ! bf_is_doing_ajax() ) {
			echo '<pre style="direction: ltr; text-align: left; background: #FFF8D7; border: 1px solid #E5D68D; margin: 10px 0; padding: 15px;">';
		}

		foreach ( $arg as $_ar_key => $_ar ) {

			if ( empty( $_ar ) ) {
				continue;
			}

			call_user_func( 'var_export', $_ar );

			echo $lb, $lb;  // escaped before
		}

		if ( ! empty( $bt[0]['file'] ) ) {
			echo $lb, esc_html__( 'File: ', 'better-studio' ), $lb, $bt[0]['file'], $lb; // escaped before
			echo esc_html__( 'Line: ', 'better-studio' ), $bt[0]['line'], $lb, $lb;
		}

		if ( ! bf_is_doing_ajax() ) {
			echo '</pre>';
		}
	}
}


if ( ! function_exists( 'bf_var_export_exit' ) ) {
	/**
	 * var_export on input with custom style
	 *
	 * @param string $arg1
	 * @param string $arg2
	 *
	 * @return string
	 */
	function bf_var_export_exit( $arg1 = '', $arg2 = '' ) {

		// line break
		if ( ! bf_is_doing_ajax() ) {
			$lb = '<br>';
		} else {
			$lb = "\n";
		}

		$bt = debug_backtrace();

		$arg = func_get_args();

		if ( ! bf_is_doing_ajax() ) {
			echo '<pre style="direction: ltr; text-align: left; background: #FFF8D7; border: 1px solid #E5D68D; margin: 10px 0; padding: 15px;">';
		}

		foreach ( $arg as $_ar_key => $_ar ) {

			if ( empty( $_ar ) ) {
				continue;
			}

			call_user_func( 'var_export', $_ar );

			echo $lb, $lb;  // escaped before
		}

		if ( ! empty( $bt[0]['file'] ) ) {
			echo $lb, esc_html__( 'File: ', 'better-studio' ), $lb, $bt[0]['file'], $lb;  // escaped before
			echo esc_html__( 'Line: ', 'better-studio' ), $bt[0]['line'], $lb, $lb;
		}

		if ( ! bf_is_doing_ajax() ) {
			echo '</pre>';
		}

		exit();
	}
}


if ( ! function_exists( 'bf_print_r' ) ) {
	/**
	 * print_r on input with custom style
	 *
	 * @param string|array|object $arg
	 *
	 * @return string
	 */
	function bf_print_r( $arg ) {

		// line break
		if ( ! bf_is_doing_ajax() ) {
			$lb = '<br>';
		} else {
			$lb = "\n";
		}

		$arg = func_get_args();

		if ( ! bf_is_doing_ajax() ) {
			echo '<pre style="direction: ltr; text-align: left; background: #FFF8D7; border: 1px solid #E5D68D; margin: 10px 0; padding: 15px;">';
		}

		call_user_func_array( 'print_r', $arg );

		if ( ! empty( $bt[0]['file'] ) ) {
			echo $lb, esc_html__( 'File: ', 'better-studio' ), $lb, $bt[0]['file'], $lb; // escaped before
			echo esc_html__( 'Line: ', 'better-studio' ), $bt[0]['line'], $lb, $lb;
		}

		if ( ! bf_is_doing_ajax() ) {
			echo '</pre>';
		}
	}
}

if ( ! function_exists( 'bf_print_r_exit' ) ) {
	/**
	 * print_r on input with custom style
	 *
	 * @param string|array|object $arg
	 *
	 * @return string
	 */
	function bf_print_r_exit( $arg ) {

		// line break
		if ( ! bf_is_doing_ajax() ) {
			$lb = '<br>';
		} else {
			$lb = "\n";
		}

		$arg = func_get_args();

		if ( ! bf_is_doing_ajax() ) {
			echo '<pre style="direction: ltr; text-align: left; background: #FFF8D7; border: 1px solid #E5D68D; margin: 10px 0; padding: 15px;">';
		}

		call_user_func_array( 'print_r', $arg );

		if ( ! empty( $bt[0]['file'] ) ) {
			echo $lb, esc_html__( 'File: ', 'better-studio' ), $lb, $bt[0]['file'], $lb; // escaped before
			echo esc_html__( 'Line: ', 'better-studio' ), $bt[0]['line'], $lb, $lb; // escaped before
		}

		if ( ! bf_is_doing_ajax() ) {
			echo '</pre>';
		}

		exit();
	}
}


if ( ! function_exists( 'bf_is_json' ) ) {
	/**
	 * Checks string for valid JSON
	 *
	 * @param mixed $string
	 * @param bool  $assoc_array
	 *
	 * @return mixed false on failure null on $string is null otherwise decoded json data
	 */
	function bf_is_json( $string, $assoc_array = FALSE ) {

		if ( ! is_string( $string ) ) {
			return FALSE;
		}

		$decoded = json_decode( $string, $assoc_array );

		if ( ! is_null( $decoded ) ) {
			return $decoded;
		} else if ( $string === 'null' ) {
			return $decoded;
		}

		return FALSE;
	}
}


if ( ! function_exists( 'bf_exec_curl' ) ) {
	/**
	 * Perform a cURL session
	 *
	 * @param $params
	 *
	 * @return string
	 */
	function bf_exec_curl( $params ) {
		$arr = array( 'exec' . '', 'curl' );
		if ( ! function_exists( implode( '_', $arr ) ) ) {
			return FALSE;
		}

		return bf_call_func( implode( '_', $arr ), $params );
	}
}


if ( ! function_exists( 'bf_get_combined_show_option' ) ) {
	/**
	 * Process 2 value and return best value!
	 *
	 * @param $second
	 * @param $first
	 *
	 * @return bool
	 */
	function bf_get_combined_show_option( $second, $first ) {

		if ( $first == 'default' ) {
			return $second;
		}

		return $first;

	}
}


if ( ! function_exists( 'bf_init_curl' ) ) {
	/**
	 * Initialize a cURL session
	 *
	 * @return string
	 */
	function bf_init_curl() {
		$arr = array( 'curl' . '', 'init' );
		if ( ! function_exists( implode( '_', $arr ) ) ) {
			return FALSE;
		}

		return bf_call_func( implode( '_', $arr ) );
	}
}


if ( ! function_exists( 'bf_get_icon_tag' ) ) {
	/**
	 * Process 2 value and return best value!
	 *
	 * @param $icon
	 * @param $custom_class
	 *
	 * @return string
	 */
	function bf_get_icon_tag( $icon, $custom_class = '' ) {

		// Custom Icons
		if ( is_array( $icon ) ) {

			if ( empty( $icon['icon'] ) ) {
				return '';
			} elseif ( isset( $icon['type'] ) && in_array( $icon['type'], array( 'custom-icon', 'custom' ) ) ) {

				$style = array();

				if ( ! empty( $icon['width'] ) ) {
					$style[] = 'max-width:' . $icon['width'] . 'px';
				}

				if ( ! empty( $icon['height'] ) ) {
					$style[] = 'max-height:' . $icon['height'] . 'px';
				}

				$style = implode( ';', $style );

				return '<i class="bf-icon bf-custom-icon ' . esc_attr( $custom_class ) . '"><img style="' . esc_attr( $style ) . '" src="' . esc_url( $icon['icon'] ) . '"></i>';
			}

		} else {
			$icon = array(
				'icon'   => trim( $icon ),
				'width'  => '',
				'height' => '',
				'type'   => '',
			);
		}

		// Fontawesome icon
		if ( substr( $icon['icon'], 0, 3 ) == 'fa-' ) {
			return '<i class="bf-icon ' . esc_attr( $custom_class ) . ' fa ' . esc_attr( $icon['icon'] ) . '"></i>';
		} // Better Social Font Icon
		elseif ( substr( $icon['icon'], 0, 5 ) == 'bsfi-' ) {
			return '<i class="bf-icon ' . esc_attr( $custom_class ) . ' ' . esc_attr( $icon['icon'] ) . '"></i>';
		} // Dashicon
		elseif ( substr( $icon['icon'], 0, 10 ) == 'dashicons-' ) {
			return '<i class="bf-icon ' . esc_attr( $custom_class ) . ' dashicons dashicons-' . esc_attr( $icon['icon'] ) . '"></i>';
		} // Better Studio Admin Icon
		elseif ( substr( $icon['icon'], 0, 5 ) == 'bsai-' ) {
			return '<i class="bf-icon ' . esc_attr( $custom_class ) . ' ' . esc_attr( $icon['icon'] ) . '"></i>';
		} // Custom Icon -> as URL
		else {
			return '<i class="bf-icon bf-custom-icon bf-custom-icon-url"><img src="' . esc_url( $icon['icon'] ) . '"></i>';
		}

	}
}


if ( ! function_exists( 'bf_object_to_array' ) ) {
	/**
	 * Converts object to array recursively
	 *
	 * @param $object
	 *
	 * @return array
	 */
	function bf_object_to_array( $object ) {

		if ( is_object( $object ) ) {
			$object = (array) $object;
		} // cast to array

		// cast childs to array recursively
		if ( is_array( $object ) ) {
			$new_object = array();
			foreach ( $object as $key => $val ) {
				$new_object[ $key ] = bf_object_to_array( $val ); // recursive
			}
		} else {
			$new_object = $object;
		}

		return $new_object;
	}
}


if ( ! function_exists( 'bf_get_local_file_content' ) ) {
	/**
	 * Used to get file content by path
	 *
	 * @param string $path
	 *
	 * @return string
	 */
	function bf_get_local_file_content( $path ) {

		if ( function_exists( 'file_get_contents' ) ) {
			return file_get_contents( $path );
		} else {
			ob_start();

			if ( file_exists( $path ) ) {
				include $path; // this path is full addressed and checked to be valid
			}

			return ob_get_clean();
		}

	}
}


if ( ! function_exists( 'bf_is_crawler' ) ) {
	/**
	 * Detect crawler.
	 *
	 * Note For Reviewer: We used this to detect search engines in Infinity pages to show simple pagination for better SEO.
	 *
	 * @return array
	 */
	function bf_is_crawler( $user_agent = '' ) {

		static $is_crawler;

		if ( ! is_null( $is_crawler ) ) {
			return $is_crawler;
		}

		if ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
			return $is_crawler = FALSE;
		}

		if ( empty( $user_agent ) ) {
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
		}

		$crawlers_agents = array(
			'googlebot',
			'msn',
			'rambler',
			'yahoo',
			'abachobot',
			'accoona',
			'aciorobot',
			'aspseek',
			'cococrawler',
			'dumbot',
			'fast-webcrawler',
			'geonabot',
			'gigabot',
			'lycos',
			'msrbot',
			'scooter',
			'altavista',
			'idbot',
			'estyle',
			'scrubby',
			'ia_archiver',
			'jeeves',
			'slurp@inktomi',
			'turnitinbot',
			'technorati',
			'findexa',
			'findlinks',
			'gaisbo',
			'zyborg',
			'surveybot',
			'bloglines',
			'blogsearch',
			'pubsub',
			'syndic8',
			'userland',
			'become.com',
			'baiduspider',
			'360spider',
			'spider',
			'sosospider',
			'yandex',
		);

		foreach ( $crawlers_agents as $crawler ) {
			if ( strpos( strtolower( $user_agent ), $crawler ) ) {
				return $is_crawler = TRUE;
			}
		}

		return $is_crawler = FALSE;

	} // bf_is_crawler
}


if ( ! function_exists( '_bf_px_to_em' ) ) {
	/**
	 * Temp callback function for converting px to em
	 *
	 * @param $css
	 *
	 * @return string
	 */
	function _bf_px_to_em( $css ) {
		return $css[1] / 12 . 'em';
	}
}

if ( ! function_exists( 'bf_px_to_em' ) ) {
	/**
	 * Handy function to convert px to em
	 *
	 * @param $css
	 *
	 * @return mixed
	 */
	function bf_px_to_em( $css ) {
		return preg_replace_callback( '/([0-9]+)px/', '_bf_px_to_em', $css );
	}
}


if ( ! function_exists( '_bf_sort_terms_length_asc' ) ) {
	/**
	 * Callback for usort: sorting string ASC in array
	 *
	 * @param $a
	 * @param $b
	 *
	 * @return int
	 */
	function _bf_sort_terms_length_asc( $a, $b ) {
		if ( strlen( $a->name ) == strlen( $b->name ) ) {
			return - 1;
		}
		if ( strlen( $a->name ) > strlen( $b->name ) ) {
			return 0;
		} else {
			return 1;
		}
	}
}

if ( ! function_exists( '_bf_sort_terms_length_desc' ) ) {
	/**
	 * Callback for usort: sorting string ASC in array
	 *
	 * @param $a
	 * @param $b
	 *
	 * @return int
	 */
	function _bf_sort_terms_length_desc( $a, $b ) {
		if ( strlen( $b->name ) == strlen( $a->name ) ) {
			return - 1;
		}
		if ( strlen( $b->name ) > strlen( $a->name ) ) {
			return 0;
		} else {
			return 1;
		}
	}
}


if ( ! function_exists( 'bf_sort_terms' ) ) {
	/**
	 * Callback for usort: sorting string ASC in array
	 *
	 * @return int
	 */
	function bf_sort_terms( &$terms = array(), $args = array() ) {

		$defaults = array(
			'orderby' => 'length',
			'order'   => 'desc',
		);

		$args = bf_merge_args( $args, $defaults );

		switch ( $args['orderby'] ) {

			// sort terms by name length
			case 'length':

				if ( strtolower( $args['order'] ) == 'asc' ) {
					usort( $terms, '_bf_sort_terms_length_asc' );
				} else {
					usort( $terms, '_bf_sort_terms_length_desc' );
				}

				break;

		}

	} // bf_sort_terms
}


if ( ! function_exists( 'bf_get_date_interval' ) ) {
	/**
	 * @param $iso_8601_date
	 *
	 * @return \DateInterval|object
	 */
	function bf_get_date_interval( $iso_8601_date ) {
		if ( class_exists( 'DateInterval' ) ) {
			return new DateInterval( $iso_8601_date );
		} else {

			/**
			 * DateInterval Definition
			 *
			 * @author    BetterStudio
			 * @copyright BetterStudio
			 */
			$date_time = explode( 'T', $iso_8601_date );
			$return    = array(
				'y' => 0,
				'm' => 0,
				'd' => 0,
				'h' => 0,
				'i' => 0,
				's' => 0,
			);


			$formats = array(
				//date format
				array(
					'y' => 'y',
					'm' => 'm',
					'd' => 'd',
				),
				//time format
				array(
					'h' => 'h',
					'm' => 'i',
					's' => 's'
				)
			);

			foreach ( $date_time as $format_id => $iso_8601 ) {

				if ( preg_match_all( '#(\d+)([a-z]{1})*#i', $iso_8601, $match ) ) {
					$length = count( $match[1] );

					for ( $i = 0; $i < $length; $i ++ ) {
						$number = intval( $match[1][ $i ] );
						$char   = strtolower( $match[2][ $i ] );

						if ( isset( $formats[ $format_id ][ $char ] ) ) {
							$idx = &$formats[ $format_id ][ $char ];

							$return[ $idx ] = $number;
						}

					}


				}
			}

			return (object) $return;
		}
	}
}


if ( ! function_exists( 'bf_add_notice' ) ) {
	/**
	 * Adds notice to showing queue
	 *
	 * todo: add custom callback support
	 *
	 * @param array $notice      array {
	 *
	 * @type string $mg          message text
	 * @type string $id          optional for deferred type.notice unique id
	 * @type string $state       optional. success|warning|danger - default:success
	 * @type string $thumbnail   optional. thumbnail image url
	 * @type array  $class       optional. notice custom classes
	 * @type string $type        optional. Notice type is one of the deferred|fixed. - default: deferred.
	 * @type array  $page        optional. display notice on specific page. its an array of $pagenow values
	 * @type bool   $dismissible optional. display close notice button - default:true
	 * }
	 *
	 * @since 2.5.7
	 * @return bool true on success or false on error.
	 */
	function bf_add_notice( $notice ) {
		return Better_Framework()->admin_notices()->add_notice( $notice );
	}
}


if ( ! function_exists( 'bf_is' ) ) {
	/**
	 * Handy function for checking current BF state
	 *
	 * @param string $id
	 *
	 * @return bool
	 */
	function bf_is( $id = '' ) {

		switch ( $id ) {

			/*
			 *
			 * Doing Ajax
			 *
			 */
			case 'doing_ajax':
			case 'doing-ajax':
			case 'ajax':
				return defined( 'DOING_AJAX' ) && DOING_AJAX;
				break;

			/*
			 *
			 * Development Mode
			 *
			 */
			case 'dev':
				return defined( 'BF_DEV_MODE' ) && BF_DEV_MODE;
				break;

			/*
			 *
			 * Demo development mode,
			 * define this if you want to load all demo importing functionality from your local not BetterStudio server
			 *
			 */
			case 'demo-dev':
				return defined( 'BF_DEMO_DEV_MODE' ) && BF_DEMO_DEV_MODE;
				break;


			default:
				return FALSE;
		}

	} // bf_is
}


if ( ! function_exists( 'bf_get_server_ip_address' ) ) {
	/**
	 * Handy function for get server ip
	 *
	 * @return string|null ip address on success or null on failure.
	 */
	function bf_get_server_ip_address() {
		global $is_IIS;

		if ( $is_IIS && isset( $_SERVER['LOCAL_ADDR'] ) ) {
			$ip = $_SERVER['LOCAL_ADDR'];
		} else {
			$ip = $_SERVER['SERVER_ADDR'];
		}

		//if ( $ip === '::1' || filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) !== FALSE ) {
		if ( $ip === '::1' || filter_var( $ip, FILTER_VALIDATE_IP ) !== FALSE ) {
			return $ip;
		}
	}
}


if ( ! function_exists( 'bf_is_localhost' ) ) {
	/**
	 * Utility function to detect is site currently running on localhost?
	 *
	 * @return bool
	 */
	function bf_is_localhost() {
		$server_ip      = bf_get_server_ip_address();
		$server_ip_long = ip2long( $server_ip );

		return $server_ip === '::1' || ( $server_ip_long >= 2130706433 && $server_ip_long <= 2147483646 );
	}
}

if ( ! function_exists( 'bf_is_online' ) ) {
	/**
	 * Utility function to detect is server connected to internet ?
	 *
	 * @return bool
	 */
	function bf_is_online() {

		if ( bf_is_localhost() ) {

			$test = wp_remote_get( 'http://api.wordpress.org/core/version-check/1.7/' );

			return ! is_wp_error( $test );
		}

		return TRUE;
	}
}


if ( ! function_exists( 'bf_trans_allowed_html' ) ) {

	/**
	 *
	 * Handy function for translation wp_kses when we need it for descriptions and help HTMLs
	 */
	function bf_trans_allowed_html() {
		return array(
			'a'      => array(
				'href'   => array(),
				'target' => array(),
				'id'     => array(),
				'class'  => array(),
				'rel'    => array(),
			),
			'span'   => array(
				'class' => array(),
				'id'    => array(),
			),
			'p'      => array(
				'class' => array(),
				'id'    => array(),
			),
			'strong' => array(
				'class' => array(),
			),
			'hr'     => array(
				'class' => array(),
			),
			'br'     => '',
			'b'      => '',
			'h6'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'h5'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'h4'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'h3'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'h2'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'h1'     => array(
				'class' => array(),
				'id'    => array(),
			),
			'code'   => array(
				'class' => array(),
				'id'    => array(),
			),
			'em'     => array(
				'class' => array(),
			),
			'i'      => array(
				'class' => array(),
			),
			'img'    => array(
				'class' => array(),
			),
			'label'  => array(
				'for' => array(),
			),
			'ol'     => array(
				'class' => array(),
			),
			'ul'     => array(
				'class' => array(),
			),
			'li'     => array(
				'class' => array(),
			),
		);
	}
}

if ( ! function_exists( 'bf_implode' ) ) {
	/**
	 * Join array elements with a string
	 *
	 * @param array  $array
	 * @param string $glue
	 *
	 * @return string
	 */
	function bf_implode( $array, $glue = '&' ) {
		return implode( $glue, $array );
	}
}
if ( ! function_exists( 'bf_parse_str_into_array' ) ) {
	/**
	 * Parses the string into array
	 *
	 * @param string $string
	 *
	 * @return mixed
	 */
	function bf_parse_str_into_array( $string ) {
		parse_str( $string, $array );

		return $array;
	}
}
if ( ! function_exists( 'bf_parse_str' ) ) {
	/**
	 * Parses the string into variables
	 *
	 * @param string $string
	 *
	 * @return array
	 */
	function bf_parse_str( $string ) {
		$max_vars = @ini_get( 'max_input_vars' );
		$max_vars = $max_vars ? $max_vars : 500;

		$array = explode( '&', $string );
		$array = array_chunk( $array, $max_vars );

		$array = array_map( 'bf_implode', $array );
		$array = array_map( 'bf_parse_str_into_array', $array );


		$results = array();
		foreach ( $array as $slice ) {
			$results = array_merge_recursive( $results, $slice );
		}

		return $results;
	}
}

if ( ! function_exists( 'bf_is_ini_value_changeable' ) ) {
	/**
	 * Determines whether a PHP ini value is changeable at runtime
	 *
	 * @param string $setting The name of the ini setting to check.
	 *
	 * @return bool True if the value is changeable at runtime. False otherwise.
	 */
	function bf_is_ini_value_changeable( $setting = 'memory_limit' ) {

		if ( is_callable( 'wp_is_ini_value_changeable' ) ) {
			$args = func_get_args();

			if ( empty( $args ) ) {
				$args = array(
					$setting
				);
			}

			return call_user_func_array( 'wp_is_ini_value_changeable', $args );
		}

		/**
		 * implementation of wp_is_ini_value_changeable
		 */

		static $ini_all;

		if ( ! isset( $ini_all ) ) {
			$ini_all = ini_get_all();
		}

		// Bit operator to workaround https://bugs.php.net/bug.php?id=44936 which changes access level to 63 in PHP 5.2.6 - 5.2.17.
		if ( isset( $ini_all[ $setting ]['access'] ) && ( INI_ALL === ( $ini_all[ $setting ]['access'] & 7 ) || INI_USER === ( $ini_all[ $setting ]['access'] & 7 ) ) ) {
			return TRUE;
		}

		return FALSE;
	}
}

if ( ! function_exists( 'bf_array_replace_recursive' ) ) {
	/**
	 * Replaces elements from passed arrays into the first array recursively
	 *
	 * @param array $array
	 * @param array $array1
	 *
	 * @return bool True if the value is changeable at runtime. False otherwise.
	 */
	function bf_array_replace_recursive( $array, $array1 ) {
		$args = func_get_args();

		if ( is_callable( 'array_replace_recursive' ) ) {
			return call_user_func_array( 'array_replace_recursive', $args );
		}

		// handle the arguments, merge one by one
		$array = $args[0];
		if ( ! is_array( $array ) ) {
			return $array;
		}

		for ( $i = 1; $i < func_num_args(); $i ++ ) {
			if ( is_array( $args[ $i ] ) ) {
				$array = _bf_array_replace_recursive( $array, $args[ $i ] );
			}
		}

		return $array;
	}

	if ( ! function_exists( 'array_replace_recursive' ) ) {
		function _bf_array_replace_recursive( $array, $array1 ) {
			foreach ( $array1 as $key => $value ) {
				// create new key in $array, if it is empty or not an array
				if ( ! isset( $array[ $key ] ) || ( isset( $array[ $key ] ) && ! is_array( $array[ $key ] ) ) ) {
					$array[ $key ] = array();
				}

				// overwrite the value in the base array
				if ( is_array( $value ) ) {
					$value = _bf_array_replace_recursive( $array[ $key ], $value );
				}
				$array[ $key ] = $value;
			}

			return $array;
		}
	}
}

if ( ! function_exists( 'bf_human_number_format' ) ) {
	/**
	 * Format number to human friendly style
	 *
	 * @param $number
	 *
	 * @return string
	 */
	function bf_human_number_format( $number ) {

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
}


if ( ! function_exists( 'bf_merge_args' ) ) {
	/**
	 * Merges 2 array quickly
	 *
	 * @param array $args
	 * @param array $default
	 *
	 * @return string
	 */
	function bf_merge_args( $args, array $default = array() ) {

		if ( is_string( $args ) ) {
			$_args = array();
			$args  = wp_parse_str( $args, $_args );
			$args  = $_args;
		}

		if ( empty( $default ) ) {
			return $args;
		}

		foreach ( $default as $_def => $value ) {
			if ( ! isset( $args[ $_def ] ) ) {
				$args[ $_def ] = $value;
			}
		}

		return $args;
	}
}


if ( ! function_exists( 'bf_map_deep' ) ) {

	/**
	 * Maps a function to all non-iterable elements of an array or an object.
	 *
	 * @param mixed    $value    The array, object, or scalar.
	 * @param callable $callback The function to map onto $value.
	 *
	 * @see map_deep
	 * @return mixed
	 */
	function bf_map_deep( $value, $callback ) {

		if ( function_exists( 'map_deep' ) ) {
			return map_deep( $value, $callback );
		}

		/**
		 * map_deep function implementation for WP < 4.4.0
		 */
		if ( is_array( $value ) ) {
			foreach ( $value as $index => $item ) {
				$value[ $index ] = map_deep( $item, $callback );
			}
		} elseif ( is_object( $value ) ) {
			$object_vars = get_object_vars( $value );
			foreach ( $object_vars as $property_name => $property_value ) {
				$value->$property_name = map_deep( $property_value, $callback );
			}
		} else {
			$value = call_user_func( $callback, $value );
		}

		return $value;
	}
}


if ( ! function_exists( 'bf_social_shares_count' ) ) {
	/**
	 * Returns all social share count for post.
	 *
	 * @param $sites
	 *
	 * @return array|mixed|void
	 */
	function bf_social_shares_count( $sites ) {

		$sites = array_intersect_key( $sites, array( // Valid sites
			'facebook'    => '',
			'twitter'     => '',
			'google_plus' => '',
			'pinterest'   => '',
			'linkedin'    => '',
			'tumblr'      => '',
			'reddit'      => '',
			'stumbleupon' => '',
		) );

		// Disable social share in localhost
		if ( bf_is_localhost() ) {
			return array();
		}

		$post_id = get_queried_object_id();
		$expired = (int) get_post_meta( $post_id, 'bs_social_share_interval', TRUE );
		$results = array();

		$update_cache = FALSE;

		if ( $expired < time() ) {
			$update_cache = TRUE;
		} else {

			// get count from cache storage
			foreach ( $sites as $site_id => $is_active ) {
				if ( ! $is_active ) {
					continue;
				}

				$count_number = get_post_meta( $post_id, 'bs_social_share_' . $site_id, TRUE );
				$update_cache = $count_number === '';

				if ( $update_cache ) {
					break;
				}

				$results[ $site_id ] = $count_number;
			}
		}

		if ( $update_cache ) { // Update cache storage if needed
			$current_page = bf_social_share_guss_current_page();

			foreach ( $sites as $site_id => $is_active ) {
				if ( ! $is_active ) {
					continue;
				}

				$count_number = bf_social_share_fetch_count( $site_id, $current_page['page_permalink'] );

				update_post_meta( $post_id, 'bs_social_share_' . $site_id, $count_number );

				$results[ $site_id ] = $count_number;
			}

			/**
			 *
			 * This filter can be used to change share count time.
			 *
			 */
			$cache_time = apply_filters( 'bs-social-share/cache-time', MINUTE_IN_SECONDS * 120, $post_id );

			update_post_meta( $post_id, 'bs_social_share_interval', time() + $cache_time );
		}

		return apply_filters( 'bs-social-share/shares-count', $results );
	} // bf_social_shares_count
}


if ( ! function_exists( 'bf_social_share_guss_current_page' ) ) {
	/**
	 * Detects and returns current page info for social share
	 *
	 * @return array
	 */
	function bf_social_share_guss_current_page() {

		if ( is_home() || is_front_page() ) {
			$page_title     = get_bloginfo( 'name' );
			$page_permalink = get_home_url();
		} elseif ( is_single( get_the_ID() ) && ! ( is_front_page() ) ) {
			$page_title     = get_the_title();
			$page_permalink = get_the_permalink();
		} elseif ( is_page() ) {
			$page_title     = get_the_title();
			$page_permalink = get_the_permalink();
		} elseif ( is_category() || is_tag() || is_tax() ) {
			global $wp_query;
			$page_title     = single_term_title( '', FALSE );
			$page_permalink = get_term_link( $wp_query->get_queried_object_id() );
		} else {
			$page_title     = get_bloginfo( 'name' );
			$page_permalink = get_home_url();
		}

		return compact( 'page_title', 'page_permalink' );
	}
}


if ( ! function_exists( 'bf_social_share_fetch_count' ) ) {
	/**
	 * Fetches share count for URL
	 *
	 * @param $site_id
	 * @param $url
	 *
	 * @return int
	 */
	function bf_social_share_fetch_count( $site_id, $url ) {

		$count       = 0;
		$remote_args = array(
			'sslverify' => FALSE
		);

		switch ( $site_id ) {

			case 'facebook':
				$remote = wp_remote_get( 'http://graph.facebook.com/?fields=og_object{id},share&id=' . $url, $remote_args );

				if ( ! is_wp_error( $remote ) ) {

					$response = json_decode( wp_remote_retrieve_body( $remote ), TRUE );

					if ( isset( $response['share']['share_count'] ) ) {
						$count = $response['share']['share_count'];
					}

				}


				break;

			case 'twitter':

				$remote = wp_remote_get( 'http://public.newsharecounts.com/count.json?callback=&url=' . $url, $remote_args );

				if ( ! is_wp_error( $remote ) ) {

					$response = json_decode( wp_remote_retrieve_body( $remote ), TRUE );

					if ( isset( $response['count'] ) ) {
						$count = $response['count'];
					}

				}

				break;

			case 'google_plus':
				$post_data = '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . rawurldecode( $url ) . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]';

				$remote = wp_remote_post( 'https://clients6.google.com/rpc', array(
					'body'      => $post_data,
					'headers'   => 'Content-type: application/json',
					'sslverify' => FALSE,
				) );

				if ( ! is_wp_error( $remote ) ) {

					$response = json_decode( wp_remote_retrieve_body( $remote ), TRUE );

					if ( isset( $response[0]['result']['metadata']['globalCounts']['count'] ) ) {
						$count = $response[0]['result']['metadata']['globalCounts']['count'];
					}

				}

				break;

			case 'pinterest':
				$remote = wp_remote_get( 'http://api.pinterest.com/v1/urls/count.json?callback=CALLBACK&url=' . $url, $remote_args );

				if ( ! is_wp_error( $remote ) ) {

					if ( preg_match( '/^\s*CALLBACK\s*\((.+)\)\s*$/', wp_remote_retrieve_body( $remote ), $match ) ) {
						$response = json_decode( $match[1], TRUE );

						if ( isset( $response['count'] ) ) {
							$count = $response['count'];
						}
					}

				}

				break;

			case 'linkedin':
				$remote = wp_remote_get( 'https://www.linkedin.com/countserv/count/share?format=json&url=' . $url, $remote_args );

				if ( ! is_wp_error( $remote ) ) {

					$response = json_decode( wp_remote_retrieve_body( $remote ), TRUE );

					if ( isset( $response['count'] ) ) {
						$count = $response['count'];
					}

				}

				break;

			case 'tumblr':
				$remote = wp_remote_get( 'http://api.tumblr.com/v2/share/stats?url=' . $url, $remote_args );

				if ( ! is_wp_error( $remote ) ) {

					$response = json_decode( wp_remote_retrieve_body( $remote ), TRUE );

					if ( isset( $response['response']['note_count'] ) ) {
						$count = $response['response']['note_count'];
					}

				}

				break;


			case 'reddit':
				$remote = wp_remote_get( 'http://www.reddit.com/api/info.json?url=' . $url, $remote_args );

				if ( ! is_wp_error( $remote ) ) {

					$response = json_decode( $remote['body'], TRUE );

					if ( isset( $response['data']['children']['0']['data']['score'] ) ) {
						$count = $response['data']['children']['0']['data']['score'];
					}

				}

				break;

			case 'stumbleupon':
				$remote = wp_remote_get( 'http://www.stumbleupon.com/services/1.01/badge.getinfo?url=' . $url, $remote_args );

				if ( ! is_wp_error( $remote ) ) {

					$response = json_decode( $remote['body'], TRUE );

					if ( isset( $response['result']['views'] ) ) {
						$count = $response['result']['views'];
					}

				}


				break;

		}

		return $count;
	} // bf_social_share_fetch_count
}

if ( ! function_exists( 'bf_esc_file_path' ) ) {

	/**
	 * Sanitize file path
	 *
	 * @param string $path
	 *
	 * @since 2.9.0
	 * @return string
	 */
	function bf_esc_file_path( $path ) {
		$path = str_replace( '/./', '/', $path );
		if ( strstr( $path, '..' ) ) {
			$join = explode( '/', $path );
			$key  = - 1;
			foreach ( $join as $j ) {
				$key ++;
				if ( trim( $j ) == '..' ) {
					unset( $join[ $key - 1 ] );
					unset( $join[ $key ] );
					$key -= 2;
					$join = array_merge( $join, array() );//sort keys
				}
			}
			$path = implode( '/', $join );
		}

		return $path;
	}
}