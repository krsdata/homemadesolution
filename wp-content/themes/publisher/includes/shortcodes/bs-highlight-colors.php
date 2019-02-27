<?php
/**
 * bs-highlight-colors.php
 *---------------------------
 * [bs-highlight-color] and [bs-highlight-bg] shortcodes
 *
 */

/**
 * Publisher Highlight color shortcode
 */
class Publisher_Highlight_Color_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-highlight-color';

		$_options = array(
			'defaults'       => array(
				'color' => '',
			),
			'have_widget'    => FALSE,
			'have_vc_add_on' => FALSE,
		);

		if ( isset( $options['shortcode_class'] ) ) {
			$_options['shortcode_class'] = $options['shortcode_class'];
		}

		parent::__construct( $id, $_options );

	}

	/**
	 * Handle displaying of shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function display( array $atts, $content = '' ) {
		return '<span class="main-color">' . $content . '</span>'; // escaped before
	}
}


/**
 * Publisher Highlight color shortcode
 */
class Publisher_Highlight_BG_Shortcode extends BF_Shortcode {

	function __construct( $id, $options ) {

		$id = 'bs-highlight-bg';

		$_options = array(
			'defaults'       => array(
				'color' => '',
			),
			'have_widget'    => FALSE,
			'have_vc_add_on' => FALSE,
		);

		if ( isset( $options['shortcode_class'] ) ) {
			$_options['shortcode_class'] = $options['shortcode_class'];
		}

		parent::__construct( $id, $_options );

	}

	/**
	 * Handle displaying of shortcode
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	function display( array $atts, $content = '' ) {
		return '<span class="main-bg-color">' . $content . '</span>'; // escaped before
	}
}
