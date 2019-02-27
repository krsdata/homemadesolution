<?php

/**
 * Used for handling all actions about BS Icons in PHP
 */
class BF_BS_Icons {

	/**
	 * List of all icons
	 *
	 * @var array
	 */
	public $icons = array();


	/**
	 * List of all categories
	 *
	 * @var array
	 */
	public $categories = array();


	/**
	 * Version on current BS Font Icons
	 *
	 * @var string
	 */
	public $version = '1.0.0';


	function __construct() {

		// Categories

		$this->categories = array(
			'bs-cat-1' => array(
				'id'    => 'bs-cat-1',
				'label' => 'BS Icons'
			),
		);

		$this->icons = array(
			'bsfi-facebook'     => array(
				'label'    => 'Facebook',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-twitter'      => array(
				'label'    => 'Twitter',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-dribbble'     => array(
				'label'    => 'Dribbble',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-vimeo'        => array(
				'label'    => 'Viemo',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-rss'          => array(
				'label'    => 'RSS',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-github'       => array(
				'label'    => 'Github',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-vk'           => array(
				'label'    => 'VK',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-delicious'    => array(
				'label'    => 'Delicious',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-youtube'      => array(
				'label'    => 'Youtube',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-soundcloud'   => array(
				'label'    => 'SoundCloud',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-behance'      => array(
				'label'    => 'Behance',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-pinterest'    => array(
				'label'    => 'Pinterest',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-vine'         => array(
				'label'    => 'Vine',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-steam'        => array(
				'label'    => 'Steam',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-flickr'       => array(
				'label'    => 'Flickr',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-envato'       => array(
				'label'    => 'Envato',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-forrst'       => array(
				'label'    => 'Forrst',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-mailchimp'    => array(
				'label'    => 'MailChimp',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-linkedin'     => array(
				'label'    => 'Linkedin',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-tumblr'       => array(
				'label'    => 'Tumblr',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-500px'        => array(
				'label'    => '500px',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-members'      => array(
				'label'    => 'Members',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-comments'     => array(
				'label'    => 'Comments',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-posts'        => array(
				'label'    => 'Posts',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-instagram'    => array(
				'label'    => 'Instagram',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-whatsapp'     => array(
				'label'    => 'Whatsapp',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-line'         => array(
				'label'    => 'Line',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-blackberry'   => array(
				'label'    => 'BlackBerry',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-viber'        => array(
				'label'    => 'Viber',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-skype'        => array(
				'label'    => 'Skype',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-gplus'        => array(
				'label'    => 'Google Plus',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-telegram'     => array(
				'label'    => 'Telegram',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-apple'        => array(
				'label'    => 'Apple',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-android'      => array(
				'label'    => 'Android',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-fire-1'       => array(
				'label'    => 'Fire 1',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-fire-2'       => array(
				'label'    => 'Fire 2',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-fire-3'       => array(
				'label'    => 'Fire 3',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-fire-4'       => array(
				'label'    => 'Fire 4',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-betterstudio' => array(
				'label'    => 'BetterStudio',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-publisher'    => array(
				'label'    => 'Publisher',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-google'       => array(
				'label'    => 'Google+ <span class="text-muted">Alias</span>',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-bbm'          => array(
				'label'    => 'BBM <span class="text-muted">Alias</span>',
				'category' => array( 'bs-cat-1' )
			),
			'bsfi-appstore'     => array(
				'label'    => 'AppStore <span class="text-muted">Alias</span>',
				'category' => array( 'bs-cat-1' )
			),
		);

		// Count each category icons
		$this->countCategoriesIcons();

	}

	/**
	 * Counts icons in each category
	 */
	function countCategoriesIcons() {

		foreach ( (array) $this->icons as $icon ) {

			if ( isset( $icon['category'] ) && count( $icon['category'] ) ) {

				foreach ( $icon['category'] as $key => $category ) {

					if ( ! isset( $this->categories[ $category ] ) ) {
						continue;
					}

					if ( isset( $this->categories[ $category ]['counts'] ) ) {
						$this->categories[ $category ]['counts'] = intval( $this->categories[ $category ]['counts'] ) + 1;
					} else {
						$this->categories[ $category ]['counts'] = 1;
					}
				}
			}
		}

	}


	/**
	 * Generate tag icon
	 *
	 * @param $icon_key
	 * @param $classes
	 *
	 * @return string
	 */
	function getIconTag( $icon_key, $classes = '' ) {

		$classes = apply_filters( 'better_bs_icons_classes', $classes );

		if ( ! isset( $this->icons[ $icon_key ] ) ) {
			return '';
		}

		return '<i class="bf-icon ' . $icon_key . ' ' . $classes . '"></i>';

	}
}
