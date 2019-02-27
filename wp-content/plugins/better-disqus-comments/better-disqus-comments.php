<?php
/*
Plugin Name: Better Disqus Comments
Plugin URI: http://betterstudio.com
Description: Take advantage of powerful and unique features by integrating Disqus comments on your website instead of the standard WordPress commenting system.
Version: 1.2.1
Author: BetterStudio
Author URI: http://betterstudio.com
License: GPL2
*/


/**
 * Better_Disqus_Comments class wrapper for make changes safe in future
 *
 * @return Better_Disqus_Comments
 */
function Better_Disqus_Comments() {
	return Better_Disqus_Comments::self();
}


// Initialize Better Disqus Comments
Better_Disqus_Comments();


/**
 * Class Better_Disqus_Comments
 */
class Better_Disqus_Comments {


	/**
	 * Contains Better_Disqus_Comments version number that used for assets for preventing cache mechanism
	 *
	 * @var string
	 */
	private static $version = '1.2.1';


	/**
	 * Contains plugin option panel ID
	 *
	 * @var string
	 */
	private static $panel_id = 'better_disqus_comments';

	/**
	 * Comments loading type: ajaxified|plain
	 *
	 * @var string
	 */
	private $comments_type;
	/**
	 * Inner array of instances
	 *
	 * @var array
	 */
	protected static $instances = array();


	function __construct() {

		include self::dir_path( 'includes/options/panel.php' );

		// Initialize
		add_action( 'better-framework/after_setup', array( $this, 'bf_init' ) );

		load_plugin_textdomain( 'better-studio', FALSE, 'better-disqus-comments/languages' );

	}


	/**
	 * Used for accessing plugin directory URL
	 *
	 * @param string $address
	 *
	 * @return string
	 */
	public static function dir_url( $address = '' ) {

		return plugin_dir_url( __FILE__ ) . $address;

	}


	/**
	 * Used for accessing plugin directory path
	 *
	 * @param string $address
	 *
	 * @return string
	 */
	public static function dir_path( $address = '' ) {

		return plugin_dir_path( __FILE__ ) . $address;

	}


	/**
	 * Returns plugin current Version
	 *
	 * @return string
	 */
	public static function get_version() {

		return self::$version;

	}


	/**
	 * Build the required object instance
	 *
	 * @param   string $object
	 * @param   bool   $fresh
	 * @param   bool   $just_include
	 *
	 * @return  Better_Disqus_Comments|null
	 */
	public static function factory( $object = 'self', $fresh = FALSE, $just_include = FALSE ) {

		if ( isset( self::$instances[ $object ] ) && ! $fresh ) {
			return self::$instances[ $object ];
		}

		switch ( $object ) {

			/**
			 * Main Better_Disqus_Comments Class
			 */
			case 'self':
				$class = 'Better_Disqus_Comments';
				break;

			default:
				return NULL;
		}


		// Just prepare/includes files
		if ( $just_include ) {
			return;
		}

		// don't cache fresh objects
		if ( $fresh ) {
			return new $class;
		}

		self::$instances[ $object ] = new $class;

		return self::$instances[ $object ];
	}


	/**
	 * Used for accessing alive instance of Better_Disqus_Comments
	 *
	 * @since 1.0
	 *
	 * @return Better_Disqus_Comments
	 */
	public static function self() {

		return self::factory();

	}


	/**
	 * Used for retrieving options simply and safely for next versions
	 *
	 * @param $option_key
	 *
	 * @return mixed|null
	 */
	public static function get_option( $option_key ) {

		return bf_get_option( $option_key, self::$panel_id );

	}


	/**
	 *  Init the plugin
	 */
	function bf_init() {

		if ( is_admin() && ! apply_filters( 'better-disqus-comments/allow-multiple', FALSE ) ) {

			if ( $this->get_option( 'shortname' ) && function_exists( 'Better_Facebook_Comments' ) && Better_Facebook_Comments()->get_option( 'app_id' ) ) {
				Better_Framework()->admin_notices()->add_notice( array(
					'id'  => 'facebook-and-disqus-same-time',
					'msg' => __( 'You activated both <strong>Facebook Comments</strong> and <strong>Disqus Comments</strong>. Please ensure that only one comment plugin is active at a time.', 'better-studio' )
				) );
			} else {
				Better_Framework()->admin_notices()->remove_notice( 'facebook-and-disqus-same-time' );
			}
		}


		if ( apply_filters( 'better-disqus-comments/override-template', $this->get_option( 'shortname' ) != '' ) ) {
			// Change default template
			add_filter( 'comments_template', array( $this, 'custom_comments_template' ) );
		}


		if ( ! is_admin() ) {

			// Update comments link
			add_filter( 'better-studio/theme/meta/comments/link', array(
				$this,
				'better_studio_themes_comment_link'
			), 10, 2 );

			// Clear themes comments count text in meta
			add_filter( 'better-studio/themes/meta/comments/text', array(
				$this,
				'better_studio_themes_comment_text'
			) );

		}

		// Add disqus count js
		Better_Framework()->assets_manager()->add_js( " var disqus_shortname = '" . $this->get_option( 'shortname' ) . "';
            (function () {
                var s = document.createElement('script'); s.async = true;
                s.type = 'text/javascript';
                s.src = '//' + disqus_shortname + '.disqus.com/count.js';
                (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
            }());" );

		add_action( 'wp_footer', array( $this, 'wp_footer' ) );

	}

	public function get_script() {

		ob_start();
		?>
		(function(){
		var disqus_shortname = '<?php echo esc_attr( $this->get_option( 'shortname' ) ) ?>';
		function appendDisqusScript() {
		var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
		dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
		(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
		};
		<?php

		if ( $this->comments_type === 'ajaxified' ) :
			echo 'jQuery(document).on("ajaxified-comments-loaded",appendDisqusScript);';
		else:
			echo 'appendDisqusScript();';
		endif;

		?>
		})();
		<?php

		return ob_get_clean();
	}

	public function output() {

		ob_start();
		?>
		<script><?php echo $this->get_script() ?></script>

		<?php

		return ob_get_clean();
	}

	/**
	 *  Init the plugin
	 */
	function wp_footer() {

		// Add Disqus main js file
		if ( is_singular() ) {

			Better_Framework()->assets_manager()->add_js( $this->get_script() );
		}

	}


	/**
	 * Finds appropriate template file and return path
	 * This make option to change template in themes
	 *
	 * @return string
	 */
	function get_template() {

		if ( is_child_theme() ) {
			// Use child theme specified template for Disqus comments
			if ( file_exists( get_stylesheet_directory() . '/better-disqus-comments.php' ) ) {
				return get_stylesheet_directory() . '/better-disqus-comments.php';
			}
		}

		// Use theme specified template for search page
		if ( file_exists( get_template_directory() . '/better-disqus-comments.php' ) ) {
			return get_template_directory() . '/better-disqus-comments.php';
		}

		return $this->dir_path( 'templates/better-disqus-comments.php' );

	}


	/**
	 * Changes WP comments template with diqus template
	 *
	 * @param string $template absolute path to comment template file
	 *
	 * @return string
	 */
	function custom_comments_template( $template ) {

		// Automatic AMP
		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
			return $template;
		}

		// Better AMP
		if ( function_exists( 'is_better_amp' ) && is_better_amp() ) {
			return $template;
		}

		if ( ! apply_filters( 'better-disqus-comments/override-template', $this->get_option( 'shortname' ) != '' ) ) {
			return $template;
		}

		$is_ajaxified = basename( $template ) === 'comments-ajaxified.php';

		$this->comments_type = $is_ajaxified ? 'ajaxified' : 'plain';
		if ( $is_ajaxified ) {
			return $template;
		}

		return $this->get_template();

	}


	/**
	 * Callback: Used to clear themes meta text to better style in front-end
	 *
	 * Filter: better-studio/themes/meta/comments/text
	 *
	 * @param $text
	 *
	 * @return string
	 */
	function better_studio_themes_comment_text( $text ) {

		if ( apply_filters( 'better-disqus-comments/disable-aggregate', FALSE ) ) {
			return $text;
		}

		if ( is_single( get_the_ID() ) && is_main_query() && ! apply_filters( 'better-disqus-comments/allow-multiple', TRUE ) ) {
			return $text;
		} else {
			return '';
		}

	}


	/**
	 * Callback: Used to change themes meta link to support disqus count
	 *
	 * Filter: better-studio/themes/meta/comments/link
	 *
	 * @param $link string
	 *
	 * @return string
	 */
	function better_studio_themes_comment_link( $link ) {

		if ( apply_filters( 'better-disqus-comments/disable-aggregate', FALSE ) ) {
			return $link;
		}

		if ( is_single( get_the_ID() ) && is_main_query() && apply_filters( 'better-disqus-comments/allow-multiple', FALSE ) ) {
			return $link;
		} else {
			return get_permalink() . '#disqus_thread';
		}

	}

}
