<?php
/***
 *  BetterStudio Themes Core.
 *
 *  ______  _____   _____ _                           _____
 *  | ___ \/  ___| |_   _| |                         /  __ \
 *  | |_/ /\ `--.    | | | |__   ___ _ __ ___   ___  | /  \/ ___  _ __ ___
 *  | ___ \ `--. \   | | | '_ \ / _ \ '_ ` _ \ / _ \ | |    / _ \| '__/ _ \
 *  | |_/ //\__/ /   | | | | | |  __/ | | | | |  __/ | \__/\ (_) | | |  __/
 *  \____/ \____/    \_/ |_| |_|\___|_| |_| |_|\___|  \____/\___/|_|  \___|
 *
 *  Copyright © 2017 Better Studio
 *
 *
 *  Our portfolio is here: http://themeforest.net/user/Better-Studio/portfolio
 *
 *  \--> BetterStudio, 2017 <--/
 */


Publisher_Theme_Listing_Pagin_Manager::Run();

/**
 * Class Publisher_Theme_Listing_Pagin_Manager
 */
class Publisher_Theme_Listing_Pagin_Manager {

	/**
	 * enqueue static data just once!
	 *
	 * @var bool
	 */
	public $asset_imported = FALSE;

	/**
	 * Initialize
	 */
	public static function Run() {

		global $publisher_pagination_handler;

		if ( $publisher_pagination_handler === FALSE ) {
			return;
		}

		if ( ! $publisher_pagination_handler instanceof self ) {
			$publisher_pagination_handler = new self();
			$publisher_pagination_handler->init();
		}

		return $publisher_pagination_handler;
	}


	/**
	 * enqueue pagination static files
	 */
	public function import_assets() {

		if ( $this->asset_imported ) {
			return FALSE;
		}

		if ( defined( 'BF_DEV_MODE' ) && BF_DEV_MODE ) {
			$prefix = '';
		} else {
			$prefix = '.min';
		}

		$theme_version = Better_Framework()->theme()->get( 'Version' );

		bf_enqueue_script(
			'publisher-theme-pagination',
			Publisher_Theme_Core()->get_dir_url( 'listing-pagin/assets/js/bs-ajax-pagination' . $prefix . '.js' ),
			array( 'jquery' ),
			Publisher_Theme_Core()->get_dir_path( 'listing-pagin/assets/js/bs-ajax-pagination' . $prefix . '.js' ),
			$theme_version,
			TRUE
		);

		$bs_pagin_loc = array(
			'loading' => '<div class="bs-loading"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
		);

		bf_localize_script(
			'publisher-theme-pagination',
			'bs_pagination_loc',
			apply_filters( 'publisher-theme-core/pagination/localized-items', $bs_pagin_loc )
		);


		//enqueue slick carousel
		bf_enqueue_script(
			'bs-slick-script',
			Publisher_Theme_Core()->get_dir_url( 'listing-pagin/assets/js/slick' . $prefix . '.js' ),
			array( 'jquery' ),
			Publisher_Theme_Core()->get_dir_path( 'listing-pagin/assets/js/slick' . $prefix . '.js' ),
			$theme_version,
			TRUE
		);
		bf_enqueue_style(
			'bs-slick-style',
			Publisher_Theme_Core()->get_dir_url( 'listing-pagin/assets/css/slick' . $prefix . '.css' ),
			array(),
			Publisher_Theme_Core()->get_dir_path( 'listing-pagin/assets/css/slick' . $prefix . '.css' ),
			$theme_version
		);

		$this->asset_imported = TRUE;
	}


	/**
	 * register all actions & filters
	 */
	public function init() {
		add_action( 'wp_ajax_pagination_ajax', array( $this, 'pagination_ajax_response' ) );
		add_action( 'wp_ajax_nopriv_pagination_ajax', array( $this, 'pagination_ajax_response' ) );

		add_action( 'wp_ajax_deferred_loading', array( $this, 'deferred_loading_ajax_response' ) );
		add_action( 'wp_ajax_nopriv_deferred_loading', array( $this, 'deferred_loading_ajax_response' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'import_assets' ) );
	}


	/**
	 * Handle ajax request
	 *
	 * @param array   $args
	 *
	 * @return array|void array on success or false on failure. array{
	 *
	 * @type array    $response response array TODO: document this
	 * @type array    $atts     list of retrieved attributes
	 * @type WP_Query $wp_query the query used to fetch posts
	 * @type string   $view     {@see get_json_data}
	 * @type string   $type     {@see get_json_data}
	 * }
	 */
	public function handle_ajax_response( $args = array() ) {

		$required_keys = array(
			'view'         => '',
			'current_page' => '',
		);

		// checking for valid ajax params
		if ( array_diff_key( $required_keys, $_REQUEST ) ) {
			die();
		}

		$type         = isset( $_REQUEST['type'] ) && is_string( $_REQUEST['type'] ) ? $_REQUEST['type'] : 'bs_listing';
		$current_page = max( intval( $_REQUEST['current_page'] ), 1 );
		$view         = &$_REQUEST['view'];
		$response     = array();
		$atts         = array();

		// support duplicate posts in ajax
		if ( ! empty( $_REQUEST['remove_duplicates'] ) && ! empty( $_REQUEST['remove_duplicates_ids'] ) && class_exists( 'Publisher_Theme_Duplicate_Posts' ) ) {
			Publisher_Theme_Duplicate_Posts::$temporary_activate_ajax = TRUE;
			Publisher_Theme_Duplicate_Posts::$appeared_posts          = array_flip( explode( ',', $_REQUEST['remove_duplicates_ids'] ) );
		}

		// Set primary cat
		if ( isset( $_REQUEST['query-main-term'] ) ) {
			publisher_set_prop( 'listing-main-term', $_REQUEST['query-main-term'] );
		}

		// prepare $wp_query and $response for bs_listing and custom query types
		if ( ! empty( $_REQUEST['query'] ) && $this->type_use_wp_query( $type ) ) {
			// first verify token

			if ( empty( $_REQUEST['_bs_pagin_token'] ) || ! publisher_pagin_hash_verify( $_REQUEST['_bs_pagin_token'], $_REQUEST['query'] ) ) {
				die( 'INVALID TOKEN!' );
			}

			// parse query args
			$query_args          = publisher_pagin_filter_wp_query_args( $_REQUEST['query'], $view );
			$query_args          = publisher_pagin_create_query_args( $query_args, $current_page );
			$query_args['paged'] = $current_page;

			/**
			 * parse attributes
			 *
			 * merge $query_args with extra params that returned by publisher-theme-core/pagination/filter-data/{VIEW CLASS} filter functions
			 * @see this->filter_data() documentation
			 */
			$atts = array_merge( $query_args, $this->filter_data( $_REQUEST['query'], $view ) );
			if ( isset( $args['additional_atts'] ) ) {
				$atts = array_merge( $atts, $args['additional_atts'] );
			}
			if ( isset( $atts['cat'] ) ) {
				$atts['category'] = $atts['cat'];
			}

			// simple pagination not working on ajax requests, so use ajax navigation instead
			if ( isset( $atts['paginate'] ) && stristr( $atts['paginate'], 'simple' ) ) {
				$atts['paginate'] = 'next_prev';
			}

			if ( ! empty( $query_args['posts_per_page'] ) && ! empty( $atts['pagination_query_count'] ) ) {
				$slide_posts                  = intval( $query_args['posts_per_page'] );
				$query_args['posts_per_page'] = $slide_posts * intval( $atts['pagination_query_count'] );
				publisher_set_prop( 'posts-count', $slide_posts );
			}

			$wp_query = $this->set_post_query( $query_args, $view, $atts );

			// Fix for offset pagination
			if ( ! empty( $_REQUEST['query']['offset'] ) ) {
				$response['pages']     = bf_get_wp_query_total_pages( $wp_query, $_REQUEST['query']['offset'], $query_args['posts_per_page'] );
				$response['have_next'] = $response['pages'] > $current_page;
				$response['have_prev'] = $current_page > 1;
			} else {
				$response['pages']     = $wp_query->max_num_pages;
				$response['have_next'] = $wp_query->max_num_pages > $current_page;
				$response['have_prev'] = $current_page > 1;
			}

			if ( ! $response['pages'] ) {
				die( json_encode( array( 'error' => __( 'Invalid Request', 'publisher' ) ) ) );
			}
		}

		$args = bf_merge_args( $args, array(
			'buffer_output'          => TRUE,
			'listing_content_method' => 'display_content',
			'additional_atts'        => array()
		) );

		if ( $args['buffer_output'] ) {
			ob_start();
		}

		// if type if listing, fire display_content method of listing class
		if ( $type === 'bs_listing' ) {
			$class = &$view;

			if ( class_exists( $class ) ) {
				$instance = new $class( '', $query_args );

				// filter again after creating instance from class
				$atts = array_merge( $query_args, $this->filter_data( $_REQUEST['query'], $view ) );
				if ( isset( $args['additional_atts'] ) ) {
					$atts = array_merge( $atts, $args['additional_atts'] );
				}

				self::set_general_props( $atts );

				if (
					is_string( $args['listing_content_method'] ) &&
					is_callable( array( $instance, $args['listing_content_method'] ) )
				) {
					//use to update user pagination label
					$pagin_type        = isset( $_REQUEST['pagin_type'] ) ? $_REQUEST['pagin_type'] : '';
					$response['label'] = $this->get_pagination_label( $current_page, $response['pages'] );

					$method             = $args['listing_content_method'];
					$response['output'] = $instance->$method( $atts, '', $pagin_type );

					// add it to custom wrapper or not!
					if ( ! empty( $atts['bs-pagin-add-to'] ) ) {
						$response['add-to']   = $atts['bs-pagin-add-to'];
						$response['add-type'] = ! empty( $atts['bs-pagin-add-type'] ) ? $atts['bs-pagin-add-type'] : 'append';
					}

					$events = array( $instance, 'events' );
					if ( is_callable( $events ) ) {
						$registered_events  = call_user_func( $events, $atts );
						$response['events'] = $this->filter_js_events( $registered_events );
					}
				}

				if ( $args['buffer_output'] ) {
					$response['output'] = ob_get_contents();
				}

				publisher_clear_props(); // clear listing props
			}
		} // If its a custom WP_Query
		elseif ( $type === 'wp_query' ) {

			//handle custom callback if possible
			$callback = &$view;

			if ( is_callable( $callback ) ) {
				call_user_func_array( $callback, array( &$response, &$wp_query, &$view, &$type, &$atts ) );
			}

			if ( $args['buffer_output'] ) {
				$response['output'] = ob_get_contents();
			}

			$response['label'] = $this->get_pagination_label( $current_page, $response['pages'] );

			// add it to custom wrapper or add it to custom item in page!
			if ( empty( $response['add-to'] ) ) {

				$classes = array(
					'bs-pagination-response',
					'bs-pagination-custom'
				);
				if ( is_string( $callback ) ) {
					$classes[] = 'bs-pagination-' . $callback;
				}

				$response['output'] = '<div class="' . implode( ' ', array_map( 'sanitize_html_class', $classes ) ) . '">' . $response['output'] /* escaped before */ . '</div>';
			}

		} else {
			//handle custom callback if possible
			$callback = &$view;

			if ( is_callable( $callback ) ) {
				/**
				 * this function should to give $response as reference and add following items to it
				 * -> pages
				 * -> have_next
				 * -> have_prev
				 */
				call_user_func_array( $callback, array( &$response ) );
			}

			if ( $args['buffer_output'] ) {
				$response['output'] = ob_get_contents();
			}


			// add it to custom wrapper or add it to custom item in page!
			if ( empty( $response['add-to'] ) ) {

				$classes = array(
					'bs-pagination-response',
					'bs-pagination-custom'
				);

				if ( is_string( $callback ) ) {
					$classes[] = 'bs-pagination-' . $callback;
				}

				$response['output'] = '<div class="' . implode( ' ', array_map( 'sanitize_html_class', $classes ) ) . '">' . $response['output'] /* escaped before */ . '</div>';
			}

		}

		if ( $args['buffer_output'] ) {
			ob_end_clean();
		}

		return $response;
	} // handle_ajax_response


	/**
	 * Callback: Handles all pagination ajax request
	 *
	 * Action: wp_ajax_pagination_ajax , wp_ajax_nopriv_pagination_ajax
	 */
	public function pagination_ajax_response() {
		die( json_encode( $this->handle_ajax_response() ) );

	} // pagination_ajax_response


	/**
	 * Callback: Handles deferred loading ajax request
	 *
	 * Action: wp_ajax_deferred_loading , wp_ajax_nopriv_deferred_loading
	 */
	public function deferred_loading_ajax_response() {
		$type = isset( $_REQUEST['type'] ) && is_string( $_REQUEST['type'] ) ? $_REQUEST['type'] : 'bs_listing';

		die( json_encode( $this->handle_ajax_response( array(
			'buffer_output'          => $type !== 'bs_listing',
			'listing_content_method' => 'display',
			'additional_atts'        => array(
				'hide_heading'      => TRUE,
				'hide_main_wrapper' => TRUE,
			)
		) ) ) );
	} // deferred_loading_ajax_response


	/**
	 * @param string $type listing type
	 *
	 * @return bool
	 */
	public function type_use_wp_query( $type ) {

		$_check = array(
			'bs_listing' => '',
			'wp_query'   => ''
		);

		return isset( $_check[ $type ] );
	}


	/**
	 * @param array  $atts array of the pagination config {@see set_tabs_atts for more information}
	 * @param string $view if $type is bs_listing, view is listing class name, otherwise view is function callback name
	 * @param string $type bs_listing | callback | wp_query
	 *
	 * @return string json data to handle ajax
	 */
	public function get_json_data( &$atts, $view, $type ) {

		//Fixed: category process issue
		if ( isset( $atts['cat'] ) && empty( $atts['category'] ) ) {
			$atts['category'] = $atts['cat'];
		}
		if ( isset( $atts['posts_per_page'] ) ) {
			$atts['count'] = intval( $atts['posts_per_page'] );
		}

		if ( $type === 'bs_listing' ) {
			$data = array(
				'query'        => publisher_pagin_filter_wp_query_args( $atts, $view ),
				'type'         => $type,
				'view'         => $view,
				'current_page' => 1,
				'ajax_url'     => admin_url( 'admin-ajax.php', 'relative' )
			);
		} else {
			unset( $atts['query'] ); // Bug Fixed
			$data = array(
				'query'        => publisher_pagin_filter_pagin_args( $atts ),
				'type'         => $type,
				'view'         => $view,
				'current_page' => 1,
				'ajax_url'     => admin_url( 'admin-ajax.php', 'relative' )
			);

			// Custom data that should passed
			if ( isset( $atts['data'] ) ) {
				$data['data'] = $atts['data'];
			}
		}

		// Add remove duplicate posts support for block
		if ( class_exists( 'Publisher_Theme_Duplicate_Posts' ) && Publisher_Theme_Duplicate_Posts::is_active() && ! publisher_get_global( Publisher_Theme_Duplicate_Posts::$temporary_disable_global, FALSE ) && ! empty( $atts['remove_duplicates_ids'] ) ) {
			$data['remove_duplicates']     = '1';
			$data['remove_duplicates_ids'] = $atts['remove_duplicates_ids'];
		}

		if ( isset( $atts['query-main-term'] ) ) {
			$data['query-main-term'] = $atts['query-main-term'];
		}

		$data = array_merge( $data, $this->filter_data( $atts, $view ) );

		// converts boolean fields
		$data['query'] = bf_map_deep( $data['query'], 'publisher_pagin_js_data_filter' );

		if ( $this->type_use_wp_query( $type ) && isset( $data['query'] ) && is_array( $data['query'] ) ) {

			/**
			 * append security token
			 * @see pagination_ajax_response
			 */

			$data['_bs_pagin_token'] = publisher_pagin_hash_generate( $data['query'] );
		}

		return json_encode( $data );

	} // get_json_data


	/**
	 * Filter $atts array and return some $atts indexes
	 *
	 * register function for bs-pagination/filter-data/{VIEW CLASS} filter and
	 * return each index of $atts class need to pass display_content() method
	 *
	 *
	 * @param $data array $atts array
	 * @param $view string view name
	 *
	 * @return array
	 */
	protected function filter_data( $data, $view ) {
		if ( ! is_string( $view ) || ! is_array( $data ) ) {
			return $view;
		}

		return array_intersect_key( $data, array_flip(
			apply_filters( 'publisher-theme-core/pagination/filter-data/' . $view, self::get_valid_indexes_data()
			) ) );
	} // filter_data

	/**
	 * List of atts index we are always need in ajax requests
	 *
	 * @return array
	 */
	public static function get_valid_indexes_data() {
		return array(
			/**
			 * need this attributes to display pagination on deferred ajax load {@see deferred_loading_ajax_response}
			 */
			'paginate',
			'pagination-show-label',
			'pagination_query_count',

			//pass these attr indexes through ajax request
			'columns',
			'data',
			// handle category tabs on ajax requests
			//			'tabs',
			//			'tabs_cat_filter'
		);
	} // get_valid_indexes_data


	protected function filter_js_events( $events ) {
		if ( ! is_array( $events ) || empty( $events ) ) {
			return array();
		}

		return array_intersect_key( $events, array_flip( $this->get_supported_events() ) );
	} // filter_js_events


	protected function get_supported_events() {

		return array(
			'before_append',
			'after_append',
			'after_response',
		);
	}


	/**
	 * Pagination exclusive wrapper start tag
	 *
	 * @see Publisher_Theme_Listing_Shortcode::display()
	 *
	 * @param array   $atts          the pagination config array
	 * @param integer $iteration     number of query iteration
	 * @param string  $extra_classes additional wrapper class
	 * @param bool    $return
	 *
	 * @see get_json_data for argument description
	 * @return string output string if $return set to true
	 */
	public function wrapper_start( &$atts, $iteration = 1, $extra_classes = '', $return = FALSE ) {
		//$iteration greater than 1 means slider mode is active
		if ( $iteration > 1 ) {
			$extra_classes .= ' bs-slider-item bs-items-' . $iteration;
		}

		// Support duplicate posts per block
		if ( class_exists( 'Publisher_Theme_Duplicate_Posts' ) && Publisher_Theme_Duplicate_Posts::is_active() && ! publisher_get_global( Publisher_Theme_Duplicate_Posts::$temporary_disable_global, FALSE ) ) {
			$atts['remove_duplicates_ids'] = implode( ',', array_keys( Publisher_Theme_Duplicate_Posts::get_appeared_posts() ) );
		}

		if ( $return ) {
			ob_start();
		}

		?>
		<div class="bs-pagination-wrapper main-term-<?php echo esc_attr( publisher_get_prop( 'listing-main-term', 'none' ) );
		echo ' ';
		echo isset( $atts['paginate'] ) ? esc_attr( $atts['paginate'] ) : '';
		echo ' ', $extra_classes ?>">
		<?php
		if ( $return ) {
			return ob_get_clean();
		}
	}


	/**
	 * Pagination exclusive wrapper end tag
	 *
	 * @param bool $return
	 *
	 * @see Publisher_Theme_Listing_Shortcode::display()
	 * @return string output string if $return set to true
	 */
	public function wrapper_end( $return = FALSE ) {
		if ( $return ) {
			ob_start();
		}

		?>
		</div>
		<?php
		if ( $return ) {
			return ob_get_clean();
		}
	}


	/**
	 * Calculates query total pages
	 *
	 * @param $atts
	 * @param $wp_query
	 *
	 * @see get_json_data for argument description
	 * @return float|int
	 */
	public function get_query_total_pages( &$atts, &$wp_query ) {

		if ( isset( $atts['offset'] ) && intval( $atts['offset'] ) > 0 ) {
			$total = bf_get_wp_query_total_pages( $wp_query, $atts['offset'] );
		} else {
			$total = $wp_query->max_num_pages;
		}

		return $total;
	} // get_query_total_pages


	/**
	 * Generate & echo pagination html output
	 *
	 * @param $atts
	 * @param $wp_query
	 * @param $view
	 * @param $type
	 *
	 * @see get_json_data for argument description
	 */
	public function display_pagination( &$atts, &$wp_query, $view, $type ) {

		$total_pages = $this->get_query_total_pages( $atts, $wp_query );

		$_check = array(
			'bs_listing' => '',
			'wp_query'   => '',
		);

		if ( isset( $_check[ $type ] ) ) {
			if ( empty( $atts['have_pagination'] ) ) {
				return;
			}
			if ( empty( $atts['have_slider'] ) && $total_pages < 2 ) {
				return;
			}
		} else {
			if ( $total_pages < 2 ) {
				return;
			}
		}

		unset( $_check ); // clear memory

		$options = apply_filters( 'publisher-theme-core/pagination/view-handler', array(), $atts, $wp_query, $view, $type, $this );
		$options = bf_merge_args( $options, $this->default_pagination_view_handler( $atts, $wp_query, $view, $type ) );

		if ( $options['enqueue_scripts'] ) {
			$this->import_assets();
		}

		if ( ! empty( $options['raw_html'] ) ) {
			echo $options['before_pagination']; // escaped before
			echo $options['raw_html']; // escaped before
			echo $options['after_pagination']; // escaped before
		}

	} // display_pagination


	/**
	 *  Get pagination label ["? of (total pages)" label]
	 *
	 * @param int $current_page current page number
	 * @param int $total_pages  total pages number
	 *
	 * @return string translated text
	 */
	public function get_pagination_label( $current_page, $total_pages ) {

		return sprintf(
			$this->get_translation( 'bs_pagin_pages_label', __( '%s of %s', 'publisher' ) ),
			number_format_i18n( $current_page ),
			number_format_i18n( $total_pages )
		);
	}


	/**
	 * todo delete extra tags, should be there only on tag with text and all strings should be added by JS in front-End
	 *
	 * @param string $id      Used for retrieving a translation from panel
	 * @param string $default Default text if translation was empty
	 *
	 * @return string
	 */
	public function get_translation( $id, $default = '' ) {
		$text = publisher_translation_get( $id );

		return empty( $text ) ? $default : $text;
	}

	/**
	 * Generate pagination html output
	 *
	 * @param array      $atts
	 * @param WP_Query   $wp_query
	 * @param array      $view
	 * @param string     $type pagination type
	 * @param string|int $id
	 *
	 * @see get_json_data for argument description
	 * @return string
	 */
	public function get_pagination_styles_output( &$atts, &$wp_query, &$view, &$type, &$id ) {

		static $left_angle, $right_angle;

		if ( ! $left_angle ) {
			$left_angle  = is_rtl() ? 'right' : 'left';
			$right_angle = is_rtl() ? 'left' : 'right';
		}

		if ( ! empty( $atts['next_page_link'] ) ) {
			$next_page_link = 'href="' . esc_url( $atts['next_page_link'] ) . '"';
		} else {
			$next_page_link = '';
		}

		ob_start();
		switch ( $atts['paginate'] ) {
			case 'simple_numbered':
				publisher_get_pagination();
				break;
			case 'simple_next_prev':

				global $wp_rewrite;
				// Setting up default values based on the current URL.
				$pagenum_link = html_entity_decode( get_pagenum_link() );
				$url_parts    = explode( '?', $pagenum_link );
				$pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';

				// URL base depends on permalink settings.
				$format = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
				$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

				//setup links label
				$options              = array();
				$options['next-text'] = '<i class="fa fa-caret-' . $left_angle . '"></i> ' . publisher_translation_get( 'pagination_older' );
				$options['prev-text'] = publisher_translation_get( 'pagination_newer' ) . ' <i class="fa fa-caret-' . $right_angle . '"></i>';

				//setup page variables
				$current_page = $wp_query->query_vars['paged'];
				$offset       = empty( $wp_query->query_vars['offset'] ) ? 0 : $wp_query->query_vars['offset'];
				$total        = bf_get_wp_query_total_pages( $wp_query, $offset, $wp_query->query_vars['posts_per_page'] );

				if ( $current_page > 1 ) :
					?>
					<a class="btn-bs-pagination prev" href="<?php
					$link = str_replace( '%_%', 2 == $current_page ? '' : $format, $pagenum_link );
					$link = str_replace( '%#%', $current_page - 1, $link );
					echo esc_url( $link );
					?>">
						<?php echo $options['prev-text']; // escaped before in top
						?>
					</a>
				<?php endif;
				if ( $current_page && ( $current_page < $total || - 1 == $total ) ) :
					?>
					<a class="btn-bs-pagination next" href="<?php
					$link = str_replace( '%_%', $format, $pagenum_link );
					$link = str_replace( '%#%', $current_page + 1, $link );
					echo esc_url( $link );
					?>">
						<?php echo $options['next-text']; // escaped before  in top
						?>
					</a>
					<?php
				endif;

				break;
			case 'next_prev':
				?>
				<a class="btn-bs-pagination prev disabled" rel="prev" data-id="<?php echo esc_attr( $id ); ?>"
				   title="<?php
				   echo esc_attr( $this->get_translation( 'bs_pagin_prev_label', __( 'Previous', 'publisher' ) ) ); ?>">
					<i class="fa fa-caret-<?php echo $left_angle; ?>"
					   aria-hidden="true"></i> <?php publisher_translation_echo( 'bs_pagin_prev' ); ?>
				</a>
				<a <?php echo $next_page_link; // escaped before 
				?> rel="next" class="btn-bs-pagination next"
				   data-id="<?php echo esc_attr( $id ); ?>" title="<?php
				echo esc_attr( $this->get_translation( 'bs_pagin_next_label', __( 'Next', 'publisher' ) ) ); ?>">
					<?php publisher_translation_echo( 'bs_pagin_next' ); ?> <i
						class="fa fa-caret-<?php echo $right_angle; ?>" aria-hidden="true"></i>
				</a>
				<?php if ( ! empty( $atts['pagination-show-label'] ) ) : ?>
				<span class="bs-pagination-label label-light"><?php

					switch ( $type ) {

						case 'bs_listing':
						case 'wp_query':
							// Fix for offset pagination
							if ( ! empty( $atts['offset'] ) ) {
								$max_pages = bf_get_wp_query_total_pages( $wp_query, $atts['offset'], $atts['count'] );
							} else {
								$max_pages = $wp_query->max_num_pages;
							}

							echo $this->get_pagination_label( 1, $max_pages ); // escaped before

							break;

						default:
							echo $atts['pagination-show-label'];  // escaped before in top

					}

					?></span>
			<?php endif;
				break;

			case 'more_btn_infinity':
			case 'more_btn':
			case 'infinity':
				$label = $this->get_translation( 'bs_pagin_more_label', esc_html__( 'Load More Posts', 'publisher' ) );
				$loading_label = $this->get_translation( 'bs_pagin_loading_label', esc_html__( 'Loading ...', 'publisher' ) );
				$no_more = $this->get_translation( 'bs_pagin_no_more', esc_html__( 'No more posts.', 'publisher' ) );

				?>
				<a <?php echo $next_page_link; // escaped before 
				?> rel="next" class="btn-bs-pagination" data-id="<?php echo esc_attr( $id ); ?>"
				   title="<?php echo esc_attr( $label ); ?>">
			<span class="loading" style="display: none;">
				<i class="fa fa-refresh fa-spin fa-fw"></i>
			</span>
			<span class="loading" style="display: none;">
				<?php echo $loading_label; // escaped before
				?>
			</span>

			<span class="loaded txt">
				<?php echo $label; // escaped before 
				?>
			</span>

			<span class="loaded icon">
				<i class="fa fa-caret-down" aria-hidden="true"></i>
			</span>

			<span class="no-more" style="display: none;">
				<?php echo $no_more; // escaped before 
				?> 
			</span>

				</a>

				<?php
				break;
		}

		return ob_get_clean();
	} // get_pagination_styles_output

	/**
	 * List of pagination style
	 *
	 * @return array
	 */
	public static function pagination_styles() {
		return array(
			'next_prev'         => array(
				'name'  => __( 'Next Prev buttons', 'publisher' ),
				'group' => 'ajax'
			),
			'more_btn'          => array(
				'name'  => __( 'Load more button', 'publisher' ),
				'group' => 'ajax'
			),
			'more_btn_infinity' => array(
				'name'  => __( 'Load more button + Infinity loading', 'publisher' ),
				'group' => 'ajax'
			),
			'infinity'          => array(
				'name'  => __( 'Infinity loading', 'publisher' ),
				'group' => 'ajax'
			),
			'slider'            => array(
				'name'  => __( 'Slider', 'publisher' ),
				'group' => 'slider'
			),
			'simple_numbered'   => array(
				'name'  => __( 'Simple Numbered Buttons', 'publisher' ),
				'group' => 'simple'
			),
			'simple_next_prev'  => array(
				'name'  => __( 'Simple Next Previous Buttons', 'publisher' ),
				'group' => 'simple'
			),
		);
	} // pagination_styles

	/**
	 * Set a bunch of attribute that use to display pagination
	 *
	 * @param array    $atts                   new array indexes {
	 *
	 * @type bool|null $paginate               is pagination active
	 * @type bool      $have_pagination        display pagination or not
	 * @type bool      $deferred_load_block    deferred load inactive tabs via ajax request
	 * @type bool      $have_slider            is pagination slider type
	 * @type bool      $pagination_query_count number of slider slide
	 * }
	 */
	public function set_tabs_atts( array &$atts ) {

		$atts['deferred_load_block'] = isset( $atts['tabs_content_type'] ) &&
		                               'deferred' === $atts['tabs_content_type']; // enable deferred tab loading

		if ( ! isset( $atts['paginate'] ) ) {
			return;
		}

		if ( array_key_exists( $atts['paginate'], self::pagination_styles() ) ) {
			$atts['have_pagination'] = TRUE;
			$atts['have_slider']     = $atts['paginate'] === 'slider';

			if ( $atts['have_slider'] ) {
				$atts['pagination_query_count'] = empty( $atts['pagination-slides-count'] ) ? 3 : intval( $atts['pagination-slides-count'] );
			}
		} else {
			unset( $atts['paginate'] );
		}

	} // set_tabs_atts

	/**
	 * handle default pagination html output
	 *
	 * @param array    $atts
	 * @param WP_Query $wp_query
	 * @param string   $view
	 * @param string   $type
	 *
	 * @see get_json_data for argument description
	 * @return array
	 */
	public function default_pagination_view_handler( &$atts, &$wp_query, &$view, &$type ) {
		$id = mt_rand();

		$classes = '';
		$pagin   = &$atts['paginate'];
		if ( is_callable( 'Publisher_Theme_Listing_Shortcode::pagination_styles' ) ) {
			$paginations = Publisher_Theme_Listing_Shortcode::pagination_styles();
			if ( isset( $paginations[ $pagin ]['group'] ) ) {

				$classes .= sprintf( 'bs-%s-pagination', $paginations[ $pagin ]['group'] );
			}
		}

		return array(
			'enqueue_scripts'   => TRUE,
			'before_pagination' => '<div class="bs-pagination ' . $classes . ' ' . esc_attr( $pagin ) . ' main-term-' . publisher_get_prop( 'listing-main-term', 'none' ) . ' clearfix">
			<script>var bs_ajax_paginate_' . $id . ' = \'' . $this->get_json_data( $atts, $view, $type ) . '\';</script>',

			'after_pagination' => '</div>',
			'raw_html'         => $this->get_pagination_styles_output( $atts, $wp_query, $view, $type, $id )
		);
	} // default_pagination_view_handler


	/**
	 * Print default html for deferred tab that contain ajax request params
	 *
	 * @param array  $atts
	 * @param string $view
	 * @param string $type
	 * @param string $id
	 *
	 * @see get_json_data for argument description
	 * @return array
	 */
	public function display_deferred_html( &$atts, &$view, &$type, $id = '' ) {
		if ( empty( $id ) ) {
			$id = mt_rand();
		}
		$id = 'bsd_' . $id;
		?>
		<div class="bs-deferred-load-wrapper" id="<?php echo esc_attr( $id ); ?>">
			<script>var bs_deferred_loading_<?php echo esc_js( $id ); ?> = '<?php echo $this->get_json_data( $atts, $view, $type, 1 );  // escaped before ?>';</script>
		</div>
		<?php

		$this->import_assets();
	}


	/**
	 * Set Post Query if not set
	 *
	 * @param string|array $wp_query_args {@see WP_Query::parse_query doc}
	 * @param string       $view
	 * @param array        $atts
	 *
	 * @return \WP_Query
	 */
	public function set_post_query( $wp_query_args, $view = '', $atts = array() ) {

		// if set query multiple times on ajax requests, its not work correctly!
		if ( bf_is_doing_ajax() ) {
			static $singleton = FALSE;
			if ( $singleton ) {
				return publisher_get_query();
			}
			$singleton = TRUE;
		}

		$query = apply_filters( 'publisher-theme-core/pagination-manager/query/args', $wp_query_args, $view, $atts );

		/**
		 * Optimize Query
		 */

		$optimization = array();

		if ( empty( $atts['paginate'] ) ) {

			$query['no_found_rows'] = TRUE;

			if ( empty( $query['posts_per_page'] ) ) {
				$query['posts_per_page'] = get_option( 'posts_per_page' );
			}

			if ( $query['posts_per_page'] > 0 ) {
				$query['posts_per_page'] ++;
			}

			$_paged = isset( $query['paged'] ) ? $query['paged'] : 1;

			if ( $_paged > 1 && empty( $query['offset'] ) ) {
				$query['offset'] = absint( ( $_paged - 1 ) * ( $query['posts_per_page'] - 1 ) );
				unset( $query['paged'] );
			}

			$optimization['found-rows'] = TRUE;

			$wp_query = new WP_Query( $query );
			$posts    = sizeof( $wp_query->posts );

			if ( ceil( $posts / ( $query['posts_per_page'] - 1 ) ) > 1 ) {

				$wp_query->max_num_pages = $_paged + 1;
				$wp_query->found_posts   = $posts - 1;

				array_pop( $wp_query->posts );
				$wp_query->post_count --;

			} else {
				$wp_query->max_num_pages = $_paged;
				$wp_query->found_posts   = $posts;
			}

		} else {
			$wp_query = new WP_Query( $query );
		}

		publisher_set_query( $wp_query, 'cache_posts=1' );

		if ( $optimization ) {
			$wp_query->_bs_optimization = $optimization;
		}

		return $wp_query;
	}


	/**
	 * Set general theme prop
	 *
	 * @param array $atts shortcode attributes
	 *
	 * @since 1.1.0
	 */
	public static function set_general_props( &$atts ) {

		if ( ! empty( $atts['override-listing-settings'] ) && ! empty( $atts['listing-settings'] ) ) {

			if ( is_string( $atts['listing-settings'] ) ) {

				$str = str_replace( '&amp;', '&', $atts['listing-settings'] );

				$atts['listing-settings'] = array();

				wp_parse_str( $str, $atts['listing-settings'] );
			}

			publisher_set_prop( 'block-settings-override', $atts['listing-settings'] );
		}
	}
}
