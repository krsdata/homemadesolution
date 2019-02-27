<?php

/**
 * Used for handling all actions about Fontawesome in PHP
 */
class BF_Fontawesome {

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
	 * Version on current Awesomefont
	 * @var string
	 */
	public $version = '4.7.0';


	function __construct() {

		// Categories

		$this->categories = array(
			1  => array(
				'id'    => 1,
				'label' => '41 New Icons In 4.7'
			),
			2  => array(
				'id'    => 2,
				'label' => 'Web Application Icons'
			),
			3  => array(
				'id'    => 3,
				'label' => 'Accessibility Icons'
			),
			4  => array(
				'id'    => 4,
				'label' => 'Hand Icons'
			),
			5  => array(
				'id'    => 5,
				'label' => 'Transportation Icons'
			),
			6  => array(
				'id'    => 6,
				'label' => 'Gender Icons'
			),
			7  => array(
				'id'    => 7,
				'label' => 'File Type Icons'
			),
			8  => array(
				'id'    => 8,
				'label' => 'Spinner Icons'
			),
			9  => array(
				'id'    => 9,
				'label' => 'Form Control Icons'
			),
			10 => array(
				'id'    => 10,
				'label' => 'Payment Icons'
			),
			11 => array(
				'id'    => 11,
				'label' => 'Chart Icons'
			),
			12 => array(
				'id'    => 12,
				'label' => 'Currency Icons'
			),
			13 => array(
				'id'    => 13,
				'label' => 'Text Editor Icons'
			),
			14 => array(
				'id'    => 14,
				'label' => 'Directional Icons'
			),
			15 => array(
				'id'    => 15,
				'label' => 'Video Player Icons'
			),
			16 => array(
				'id'    => 16,
				'label' => 'Brand Icons'
			),
			17 => array(
				'id'    => 17,
				'label' => 'Medical Icons'
			),
		);

		// Cat 1


		$this->icons = array(
			'fa-address-book'                        => array(
				'label'    => 'Address Book',
				'category' => array( 1, 2 )
			),
			'fa-address-book-o'                      => array(
				'label'    => 'Address Book <span class="text-muted">(Outline)</span>',
				'category' => array( 1, 2 )
			),
			'fa-address-card'                        => array(
				'label'    => 'Address Card',
				'category' => array( 1, 2 )
			),
			'fa-address-card-o'                      => array(
				'label'    => 'Address Card <span class="text-muted">(Outline)</span>',
				'category' => array( 1, 2 )
			),
			'fa-bandcamp'                            => array(
				'label'    => 'Bandcamp',
				'category' => array( 1, 16 )
			),
			'fa-bath'                                => array(
				'label'    => 'Bath',
				'category' => array( 1, 2 )
			),
			'fa-bathtub'                             => array(
				'label'    => 'Bathtub',
				'category' => array( 1, 2 )
			),
			'fa-drivers-license'                     => array(
				'label'    => 'Drivers License',
				'category' => array( 1, 2 )
			),
			'fa-drivers-license-o'                   => array(
				'label'    => 'Drivers License <span class="text-muted">(Outline)</span>',
				'category' => array( 1, 2 )
			),
			'fa-eercast'                             => array(
				'label'    => 'Eercast',
				'category' => array( 1, 16 )
			),
			'fa-envelope-open'                       => array(
				'label'    => 'Envelope Open',
				'category' => array( 1, 2 )
			),
			'fa-envelope-open-o'                     => array(
				'label'    => 'Envelope Open <span class="text-muted">(Outline)</span>',
				'category' => array( 1, 2 )
			),
			'fa-etsy'                                => array(
				'label'    => 'Etsy',
				'category' => array( 1, 16 )
			),
			'fa-free-code-camp'                      => array(
				'label'    => 'Free Code Camp',
				'category' => array( 1, 16 )
			),
			'fa-grav'                                => array(
				'label'    => 'Grav',
				'category' => array( 1, 16 )
			),
			'fa-handshake-o'                         => array(
				'label'    => 'Handshake <span class="text-muted">(Outline)</span>',
				'category' => array( 1, 2 )
			),
			'fa-id-badge'                            => array(
				'label'    => 'Id Badge',
				'category' => array( 1, 2 )
			),
			'fa-id-card'                             => array(
				'label'    => 'Id Card',
				'category' => array( 1, 2 )
			),
			'fa-id-card-o'                           => array(
				'label'    => 'Id Card <span class="text-muted">(Outline)</span>',
				'category' => array( 1, 2 )
			),
			'fa-imdb'                                => array(
				'label'    => 'Imdb',
				'category' => array( 1, 16 )
			),
			'fa-linode'                              => array(
				'label'    => 'Linode',
				'category' => array( 1, 16 )
			),
			'fa-meetup'                              => array(
				'label'    => 'Meetup',
				'category' => array( 1, 16 )
			),
			'fa-microchip'                           => array(
				'label'    => 'Microchip',
				'category' => array( 1, 2 )
			),
			'fa-podcast'                             => array(
				'label'    => 'Podcast',
				'category' => array( 1, 2 )
			),
			'fa-quora'                               => array(
				'label'    => 'Quora',
				'category' => array( 1, 16 )
			),
			'fa-ravelry'                             => array(
				'label'    => 'Ravelry',
				'category' => array( 1, 16 )
			),
			'fa-s15'                                 => array(
				'label'    => 'S15',
				'category' => array( 1, 2 )
			),
			'fa-shower'                              => array(
				'label'    => 'Shower',
				'category' => array( 1, 2 )
			),
			'fa-snowflake-o'                         => array(
				'label'    => 'Snowflake <span class="text-muted">(Outline)</span>',
				'category' => array( 1, 2 )
			),
			'fa-superpowers'                         => array(
				'label'    => 'Superpowers',
				'category' => array( 1, 16 )
			),
			'fa-telegram'                            => array(
				'label'    => 'Telegram',
				'category' => array( 1, 16 )
			),
			'fa-thermometer'                         => array(
				'label'    => 'Thermometer',
				'category' => array( 1, 2 )
			),
			'fa-thermometer-0'                       => array(
				'label'    => 'Thermometer 0',
				'category' => array( 1, 2 )
			),
			'fa-thermometer-1'                       => array(
				'label'    => 'Thermometer 1',
				'category' => array( 1, 2 )
			),
			'fa-thermometer-2'                       => array(
				'label'    => 'Thermometer 2',
				'category' => array( 1, 2 )
			),
			'fa-thermometer-3'                       => array(
				'label'    => 'Thermometer 3',
				'category' => array( 1, 2 )
			),
			'fa-thermometer-4'                       => array(
				'label'    => 'Thermometer 4',
				'category' => array( 1, 2 )
			),
			'fa-thermometer-empty'                   => array(
				'label'    => 'Thermometer Empty',
				'category' => array( 1, 2 )
			),
			'fa-thermometer-full'                    => array(
				'label'    => 'Thermometer Full',
				'category' => array( 1, 2 )
			),
			'fa-thermometer-half'                    => array(
				'label'    => 'Thermometer Half',
				'category' => array( 1, 2 )
			),
			'fa-thermometer-quarter'                 => array(
				'label'    => 'Thermometer Quarter',
				'category' => array( 1, 2 )
			),
			'fa-thermometer-three-quarters'          => array(
				'label'    => 'Thermometer Three Quarters',
				'category' => array( 1, 2 )
			),
			'fa-times-rectangle'                     => array(
				'label'    => 'Times Rectangle',
				'category' => array( 1, 2 )
			),
			'fa-times-rectangle-o'                   => array(
				'label'    => 'Times Rectangle <span class="text-muted">(Outline)</span>',
				'category' => array( 1, 2 )
			),
			'fa-user-circle'                         => array(
				'label'    => 'User Circle',
				'category' => array( 1, 2 )
			),
			'fa-user-circle-o'                       => array(
				'label'    => 'User Circle <span class="text-muted">(Outline)</span>',
				'category' => array( 1, 2 )
			),
			'fa-user-o'                              => array(
				'label'    => 'User <span class="text-muted">(Outline)</span>',
				'category' => array( 1, 2 )
			),
			'fa-vcard'                               => array(
				'label'    => 'Vcard',
				'category' => array( 1, 2 )
			),
			'fa-vcard-o'                             => array(
				'label'    => 'Vcard <span class="text-muted">(Outline)</span>',
				'category' => array( 1, 2 )
			),
			'fa-window-close'                        => array(
				'label'    => 'Window Close',
				'category' => array( 1, 2 )
			),
			'fa-window-close-o'                      => array(
				'label'    => 'Window Close <span class="text-muted">(Outline)</span>',
				'category' => array( 1, 2 )
			),
			'fa-window-maximize'                     => array(
				'label'    => 'Window Maximize',
				'category' => array( 1, 2 )
			),
			'fa-window-minimize'                     => array(
				'label'    => 'Window Minimize',
				'category' => array( 1, 2 )
			),
			'fa-window-restore'                      => array(
				'label'    => 'Window Restore',
				'category' => array( 1, 2 )
			),
			'fa-wpexplorer'                          => array(
				'label'    => 'Wpexplorer',
				'category' => array( 1, 16 )
			),
			'fa-adjust'                              => array(
				'label'    => 'Adjust',
				'category' => array( 2 )
			),
			'fa-american-sign-language-interpreting' => array(
				'label'    => 'American Sign Language Interpreting',
				'category' => array( 2, 3 )
			),
			'fa-anchor'                              => array(
				'label'    => 'Anchor',
				'category' => array( 2 )
			),
			'fa-archive'                             => array(
				'label'    => 'Archive',
				'category' => array( 2 )
			),
			'fa-area-chart'                          => array(
				'label'    => 'Area Chart',
				'category' => array( 2, 11 )
			),
			'fa-arrows'                              => array(
				'label'    => 'Arrows',
				'category' => array( 2, 14 )
			),
			'fa-arrows-h'                            => array(
				'label'    => 'Arrows H',
				'category' => array( 2, 14 )
			),
			'fa-arrows-v'                            => array(
				'label'    => 'Arrows V',
				'category' => array( 2, 14 )
			),
			'fa-asl-interpreting'                    => array(
				'label'    => 'Asl Interpreting',
				'category' => array( 2, 3 )
			),
			'fa-assistive-listening-systems'         => array(
				'label'    => 'Assistive Listening Systems',
				'category' => array( 2, 3 )
			),
			'fa-asterisk'                            => array(
				'label'    => 'Asterisk',
				'category' => array( 2 )
			),
			'fa-at'                                  => array(
				'label'    => 'At',
				'category' => array( 2 )
			),
			'fa-audio-description'                   => array(
				'label'    => 'Audio Description',
				'category' => array( 2, 3 )
			),
			'fa-automobile'                          => array(
				'label'    => 'Automobile',
				'category' => array( 2, 5 )
			),
			'fa-balance-scale'                       => array(
				'label'    => 'Balance Scale',
				'category' => array( 2 )
			),
			'fa-ban'                                 => array(
				'label'    => 'Ban',
				'category' => array( 2 )
			),
			'fa-bank'                                => array(
				'label'    => 'Bank',
				'category' => array( 2 )
			),
			'fa-bar-chart'                           => array(
				'label'    => 'Bar Chart',
				'category' => array( 2, 11 )
			),
			'fa-bar-chart-o'                         => array(
				'label'    => 'Bar Chart <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 11 )
			),
			'fa-barcode'                             => array(
				'label'    => 'Barcode',
				'category' => array( 2 )
			),
			'fa-bars'                                => array(
				'label'    => 'Bars',
				'category' => array( 2 )
			),
			'fa-battery'                             => array(
				'label'    => 'Battery',
				'category' => array( 2 )
			),
			'fa-battery-0'                           => array(
				'label'    => 'Battery 0',
				'category' => array( 2 )
			),
			'fa-battery-1'                           => array(
				'label'    => 'Battery 1',
				'category' => array( 2 )
			),
			'fa-battery-2'                           => array(
				'label'    => 'Battery 2',
				'category' => array( 2 )
			),
			'fa-battery-3'                           => array(
				'label'    => 'Battery 3',
				'category' => array( 2 )
			),
			'fa-battery-4'                           => array(
				'label'    => 'Battery 4',
				'category' => array( 2 )
			),
			'fa-battery-empty'                       => array(
				'label'    => 'Battery Empty',
				'category' => array( 2 )
			),
			'fa-battery-full'                        => array(
				'label'    => 'Battery Full',
				'category' => array( 2 )
			),
			'fa-battery-half'                        => array(
				'label'    => 'Battery Half',
				'category' => array( 2 )
			),
			'fa-battery-quarter'                     => array(
				'label'    => 'Battery Quarter',
				'category' => array( 2 )
			),
			'fa-battery-three-quarters'              => array(
				'label'    => 'Battery Three Quarters',
				'category' => array( 2 )
			),
			'fa-bed'                                 => array(
				'label'    => 'Bed',
				'category' => array( 2 )
			),
			'fa-beer'                                => array(
				'label'    => 'Beer',
				'category' => array( 2 )
			),
			'fa-bell'                                => array(
				'label'    => 'Bell',
				'category' => array( 2 )
			),
			'fa-bell-o'                              => array(
				'label'    => 'Bell <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-bell-slash'                          => array(
				'label'    => 'Bell Slash',
				'category' => array( 2 )
			),
			'fa-bell-slash-o'                        => array(
				'label'    => 'Bell Slash <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-bicycle'                             => array(
				'label'    => 'Bicycle',
				'category' => array( 2, 5 )
			),
			'fa-binoculars'                          => array(
				'label'    => 'Binoculars',
				'category' => array( 2 )
			),
			'fa-birthday-cake'                       => array(
				'label'    => 'Birthday Cake',
				'category' => array( 2 )
			),
			'fa-blind'                               => array(
				'label'    => 'Blind',
				'category' => array( 2, 3 )
			),
			'fa-bluetooth'                           => array(
				'label'    => 'Bluetooth',
				'category' => array( 2, 16 )
			),
			'fa-bluetooth-b'                         => array(
				'label'    => 'Bluetooth B',
				'category' => array( 2, 16 )
			),
			'fa-bolt'                                => array(
				'label'    => 'Bolt',
				'category' => array( 2 )
			),
			'fa-bomb'                                => array(
				'label'    => 'Bomb',
				'category' => array( 2 )
			),
			'fa-book'                                => array(
				'label'    => 'Book',
				'category' => array( 2 )
			),
			'fa-bookmark'                            => array(
				'label'    => 'Bookmark',
				'category' => array( 2 )
			),
			'fa-bookmark-o'                          => array(
				'label'    => 'Bookmark <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-braille'                             => array(
				'label'    => 'Braille',
				'category' => array( 2, 3 )
			),
			'fa-briefcase'                           => array(
				'label'    => 'Briefcase',
				'category' => array( 2 )
			),
			'fa-bug'                                 => array(
				'label'    => 'Bug',
				'category' => array( 2 )
			),
			'fa-building'                            => array(
				'label'    => 'Building',
				'category' => array( 2 )
			),
			'fa-building-o'                          => array(
				'label'    => 'Building <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-bullhorn'                            => array(
				'label'    => 'Bullhorn',
				'category' => array( 2 )
			),
			'fa-bullseye'                            => array(
				'label'    => 'Bullseye',
				'category' => array( 2 )
			),
			'fa-bus'                                 => array(
				'label'    => 'Bus',
				'category' => array( 2, 5 )
			),
			'fa-cab'                                 => array(
				'label'    => 'Cab',
				'category' => array( 2, 5 )
			),
			'fa-calculator'                          => array(
				'label'    => 'Calculator',
				'category' => array( 2 )
			),
			'fa-calendar'                            => array(
				'label'    => 'Calendar',
				'category' => array( 2 )
			),
			'fa-calendar-check-o'                    => array(
				'label'    => 'Calendar Check <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-calendar-minus-o'                    => array(
				'label'    => 'Calendar Minus <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-calendar-o'                          => array(
				'label'    => 'Calendar <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-calendar-plus-o'                     => array(
				'label'    => 'Calendar Plus <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-calendar-times-o'                    => array(
				'label'    => 'Calendar Times <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-camera'                              => array(
				'label'    => 'Camera',
				'category' => array( 2 )
			),
			'fa-camera-retro'                        => array(
				'label'    => 'Camera Retro',
				'category' => array( 2 )
			),
			'fa-car'                                 => array(
				'label'    => 'Car',
				'category' => array( 2, 5 )
			),
			'fa-caret-square-o-down'                 => array(
				'label'    => 'Caret Square Down <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 14 )
			),
			'fa-caret-square-o-left'                 => array(
				'label'    => 'Caret Square Left <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 14 )
			),
			'fa-caret-square-o-right'                => array(
				'label'    => 'Caret Square Right <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 14 )
			),
			'fa-caret-square-o-up'                   => array(
				'label'    => 'Caret Square Up <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 14 )
			),
			'fa-cart-arrow-down'                     => array(
				'label'    => 'Cart Arrow Down',
				'category' => array( 2 )
			),
			'fa-cart-plus'                           => array(
				'label'    => 'Cart Plus',
				'category' => array( 2 )
			),
			'fa-cc'                                  => array(
				'label'    => 'Cc',
				'category' => array( 2, 3 )
			),
			'fa-certificate'                         => array(
				'label'    => 'Certificate',
				'category' => array( 2 )
			),
			'fa-check'                               => array(
				'label'    => 'Check',
				'category' => array( 2 )
			),
			'fa-check-circle'                        => array(
				'label'    => 'Check Circle',
				'category' => array( 2 )
			),
			'fa-check-circle-o'                      => array(
				'label'    => 'Check Circle <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-check-square'                        => array(
				'label'    => 'Check Square',
				'category' => array( 2, 9 )
			),
			'fa-check-square-o'                      => array(
				'label'    => 'Check Square <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 9 )
			),
			'fa-child'                               => array(
				'label'    => 'Child',
				'category' => array( 2 )
			),
			'fa-circle'                              => array(
				'label'    => 'Circle',
				'category' => array( 2, 9 )
			),
			'fa-circle-o'                            => array(
				'label'    => 'Circle <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 9 )
			),
			'fa-circle-o-notch'                      => array(
				'label'    => 'Circle Notch <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 8 )
			),
			'fa-circle-thin'                         => array(
				'label'    => 'Circle Thin',
				'category' => array( 2 )
			),
			'fa-clock-o'                             => array(
				'label'    => 'Clock <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-clone'                               => array(
				'label'    => 'Clone',
				'category' => array( 2 )
			),
			'fa-close'                               => array(
				'label'    => 'Close',
				'category' => array( 2 )
			),
			'fa-cloud'                               => array(
				'label'    => 'Cloud',
				'category' => array( 2 )
			),
			'fa-cloud-download'                      => array(
				'label'    => 'Cloud Download',
				'category' => array( 2 )
			),
			'fa-cloud-upload'                        => array(
				'label'    => 'Cloud Upload',
				'category' => array( 2 )
			),
			'fa-code'                                => array(
				'label'    => 'Code',
				'category' => array( 2 )
			),
			'fa-code-fork'                           => array(
				'label'    => 'Code Fork',
				'category' => array( 2 )
			),
			'fa-coffee'                              => array(
				'label'    => 'Coffee',
				'category' => array( 2 )
			),
			'fa-cog'                                 => array(
				'label'    => 'Cog',
				'category' => array( 2, 8 )
			),
			'fa-cogs'                                => array(
				'label'    => 'Cogs',
				'category' => array( 2 )
			),
			'fa-comment'                             => array(
				'label'    => 'Comment',
				'category' => array( 2 )
			),
			'fa-comment-o'                           => array(
				'label'    => 'Comment <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-commenting'                          => array(
				'label'    => 'Commenting',
				'category' => array( 2 )
			),
			'fa-commenting-o'                        => array(
				'label'    => 'Commenting <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-comments'                            => array(
				'label'    => 'Comments',
				'category' => array( 2 )
			),
			'fa-comments-o'                          => array(
				'label'    => 'Comments <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-compass'                             => array(
				'label'    => 'Compass',
				'category' => array( 2 )
			),
			'fa-copyright'                           => array(
				'label'    => 'Copyright',
				'category' => array( 2 )
			),
			'fa-creative-commons'                    => array(
				'label'    => 'Creative Commons',
				'category' => array( 2 )
			),
			'fa-credit-card'                         => array(
				'label'    => 'Credit Card',
				'category' => array( 2, 10 )
			),
			'fa-credit-card-alt'                     => array(
				'label'    => 'Credit Card Alt',
				'category' => array( 2, 10 )
			),
			'fa-crop'                                => array(
				'label'    => 'Crop',
				'category' => array( 2 )
			),
			'fa-crosshairs'                          => array(
				'label'    => 'Crosshairs',
				'category' => array( 2 )
			),
			'fa-cube'                                => array(
				'label'    => 'Cube',
				'category' => array( 2 )
			),
			'fa-cubes'                               => array(
				'label'    => 'Cubes',
				'category' => array( 2 )
			),
			'fa-cutlery'                             => array(
				'label'    => 'Cutlery',
				'category' => array( 2 )
			),
			'fa-dashboard'                           => array(
				'label'    => 'Dashboard',
				'category' => array( 2 )
			),
			'fa-database'                            => array(
				'label'    => 'Database',
				'category' => array( 2 )
			),
			'fa-deaf'                                => array(
				'label'    => 'Deaf',
				'category' => array( 2, 3 )
			),
			'fa-deafness'                            => array(
				'label'    => 'Deafness',
				'category' => array( 2, 3 )
			),
			'fa-desktop'                             => array(
				'label'    => 'Desktop',
				'category' => array( 2 )
			),
			'fa-diamond'                             => array(
				'label'    => 'Diamond',
				'category' => array( 2 )
			),
			'fa-dot-circle-o'                        => array(
				'label'    => 'Dot Circle <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 9 )
			),
			'fa-download'                            => array(
				'label'    => 'Download',
				'category' => array( 2 )
			),
			'fa-edit'                                => array(
				'label'    => 'Edit',
				'category' => array( 2 )
			),
			'fa-ellipsis-h'                          => array(
				'label'    => 'Ellipsis H',
				'category' => array( 2 )
			),
			'fa-ellipsis-v'                          => array(
				'label'    => 'Ellipsis V',
				'category' => array( 2 )
			),
			'fa-envelope'                            => array(
				'label'    => 'Envelope',
				'category' => array( 2 )
			),
			'fa-envelope-o'                          => array(
				'label'    => 'Envelope <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-envelope-square'                     => array(
				'label'    => 'Envelope Square',
				'category' => array( 2 )
			),
			'fa-eraser'                              => array(
				'label'    => 'Eraser',
				'category' => array( 2, 13 )
			),
			'fa-exchange'                            => array(
				'label'    => 'Exchange',
				'category' => array( 2, 14 )
			),
			'fa-exclamation'                         => array(
				'label'    => 'Exclamation',
				'category' => array( 2 )
			),
			'fa-exclamation-circle'                  => array(
				'label'    => 'Exclamation Circle',
				'category' => array( 2 )
			),
			'fa-exclamation-triangle'                => array(
				'label'    => 'Exclamation Triangle',
				'category' => array( 2 )
			),
			'fa-external-link'                       => array(
				'label'    => 'External Link',
				'category' => array( 2 )
			),
			'fa-external-link-square'                => array(
				'label'    => 'External Link Square',
				'category' => array( 2 )
			),
			'fa-eye'                                 => array(
				'label'    => 'Eye',
				'category' => array( 2 )
			),
			'fa-eye-slash'                           => array(
				'label'    => 'Eye Slash',
				'category' => array( 2 )
			),
			'fa-eyedropper'                          => array(
				'label'    => 'Eyedropper',
				'category' => array( 2 )
			),
			'fa-fax'                                 => array(
				'label'    => 'Fax',
				'category' => array( 2 )
			),
			'fa-feed'                                => array(
				'label'    => 'Feed',
				'category' => array( 2 )
			),
			'fa-female'                              => array(
				'label'    => 'Female',
				'category' => array( 2 )
			),
			'fa-fighter-jet'                         => array(
				'label'    => 'Fighter Jet',
				'category' => array( 2, 5 )
			),
			'fa-file-archive-o'                      => array(
				'label'    => 'File Archive <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 7 )
			),
			'fa-file-audio-o'                        => array(
				'label'    => 'File Audio <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 7 )
			),
			'fa-file-code-o'                         => array(
				'label'    => 'File Code <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 7 )
			),
			'fa-file-excel-o'                        => array(
				'label'    => 'File Excel <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 7 )
			),
			'fa-file-image-o'                        => array(
				'label'    => 'File Image <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 7 )
			),
			'fa-file-movie-o'                        => array(
				'label'    => 'File Movie <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 7 )
			),
			'fa-file-pdf-o'                          => array(
				'label'    => 'File Pdf <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 7 )
			),
			'fa-file-photo-o'                        => array(
				'label'    => 'File Photo <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 7 )
			),
			'fa-file-picture-o'                      => array(
				'label'    => 'File Picture <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 7 )
			),
			'fa-file-powerpoint-o'                   => array(
				'label'    => 'File Powerpoint <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 7 )
			),
			'fa-file-sound-o'                        => array(
				'label'    => 'File Sound <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 7 )
			),
			'fa-file-video-o'                        => array(
				'label'    => 'File Video <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 7 )
			),
			'fa-file-word-o'                         => array(
				'label'    => 'File Word <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 7 )
			),
			'fa-file-zip-o'                          => array(
				'label'    => 'File Zip <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 7 )
			),
			'fa-film'                                => array(
				'label'    => 'Film',
				'category' => array( 2 )
			),
			'fa-filter'                              => array(
				'label'    => 'Filter',
				'category' => array( 2 )
			),
			'fa-fire'                                => array(
				'label'    => 'Fire',
				'category' => array( 2 )
			),
			'fa-fire-extinguisher'                   => array(
				'label'    => 'Fire Extinguisher',
				'category' => array( 2 )
			),
			'fa-flag'                                => array(
				'label'    => 'Flag',
				'category' => array( 2 )
			),
			'fa-flag-checkered'                      => array(
				'label'    => 'Flag Checkered',
				'category' => array( 2 )
			),
			'fa-flag-o'                              => array(
				'label'    => 'Flag <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-flash'                               => array(
				'label'    => 'Flash',
				'category' => array( 2 )
			),
			'fa-flask'                               => array(
				'label'    => 'Flask',
				'category' => array( 2 )
			),
			'fa-folder'                              => array(
				'label'    => 'Folder',
				'category' => array( 2 )
			),
			'fa-folder-o'                            => array(
				'label'    => 'Folder <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-folder-open'                         => array(
				'label'    => 'Folder Open',
				'category' => array( 2 )
			),
			'fa-folder-open-o'                       => array(
				'label'    => 'Folder Open <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-frown-o'                             => array(
				'label'    => 'Frown <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-futbol-o'                            => array(
				'label'    => 'Futbol <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-gamepad'                             => array(
				'label'    => 'Gamepad',
				'category' => array( 2 )
			),
			'fa-gavel'                               => array(
				'label'    => 'Gavel',
				'category' => array( 2 )
			),
			'fa-gear'                                => array(
				'label'    => 'Gear',
				'category' => array( 2, 8 )
			),
			'fa-gears'                               => array(
				'label'    => 'Gears',
				'category' => array( 2 )
			),
			'fa-gift'                                => array(
				'label'    => 'Gift',
				'category' => array( 2 )
			),
			'fa-glass'                               => array(
				'label'    => 'Glass',
				'category' => array( 2 )
			),
			'fa-globe'                               => array(
				'label'    => 'Globe',
				'category' => array( 2 )
			),
			'fa-graduation-cap'                      => array(
				'label'    => 'Graduation Cap',
				'category' => array( 2 )
			),
			'fa-group'                               => array(
				'label'    => 'Group',
				'category' => array( 2 )
			),
			'fa-hand-grab-o'                         => array(
				'label'    => 'Hand Grab <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 4 )
			),
			'fa-hand-lizard-o'                       => array(
				'label'    => 'Hand Lizard <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 4 )
			),
			'fa-hand-paper-o'                        => array(
				'label'    => 'Hand Paper <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 4 )
			),
			'fa-hand-peace-o'                        => array(
				'label'    => 'Hand Peace <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 4 )
			),
			'fa-hand-pointer-o'                      => array(
				'label'    => 'Hand Pointer <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 4 )
			),
			'fa-hand-rock-o'                         => array(
				'label'    => 'Hand Rock <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 4 )
			),
			'fa-hand-scissors-o'                     => array(
				'label'    => 'Hand Scissors <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 4 )
			),
			'fa-hand-spock-o'                        => array(
				'label'    => 'Hand Spock <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 4 )
			),
			'fa-hand-stop-o'                         => array(
				'label'    => 'Hand Stop <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 4 )
			),
			'fa-hard-of-hearing'                     => array(
				'label'    => 'Hard Of Hearing',
				'category' => array( 2, 3 )
			),
			'fa-hashtag'                             => array(
				'label'    => 'Hashtag',
				'category' => array( 2 )
			),
			'fa-hdd-o'                               => array(
				'label'    => 'Hdd <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-headphones'                          => array(
				'label'    => 'Headphones',
				'category' => array( 2 )
			),
			'fa-heart'                               => array(
				'label'    => 'Heart',
				'category' => array( 2, 17 )
			),
			'fa-heart-o'                             => array(
				'label'    => 'Heart <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 17 )
			),
			'fa-heartbeat'                           => array(
				'label'    => 'Heartbeat',
				'category' => array( 2, 17 )
			),
			'fa-history'                             => array(
				'label'    => 'History',
				'category' => array( 2 )
			),
			'fa-home'                                => array(
				'label'    => 'Home',
				'category' => array( 2 )
			),
			'fa-hotel'                               => array(
				'label'    => 'Hotel',
				'category' => array( 2 )
			),
			'fa-hourglass'                           => array(
				'label'    => 'Hourglass',
				'category' => array( 2 )
			),
			'fa-hourglass-1'                         => array(
				'label'    => 'Hourglass 1',
				'category' => array( 2 )
			),
			'fa-hourglass-2'                         => array(
				'label'    => 'Hourglass 2',
				'category' => array( 2 )
			),
			'fa-hourglass-3'                         => array(
				'label'    => 'Hourglass 3',
				'category' => array( 2 )
			),
			'fa-hourglass-end'                       => array(
				'label'    => 'Hourglass End',
				'category' => array( 2 )
			),
			'fa-hourglass-half'                      => array(
				'label'    => 'Hourglass Half',
				'category' => array( 2 )
			),
			'fa-hourglass-o'                         => array(
				'label'    => 'Hourglass <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-hourglass-start'                     => array(
				'label'    => 'Hourglass Start',
				'category' => array( 2 )
			),
			'fa-i-cursor'                            => array(
				'label'    => 'I Cursor',
				'category' => array( 2 )
			),
			'fa-image'                               => array(
				'label'    => 'Image',
				'category' => array( 2 )
			),
			'fa-inbox'                               => array(
				'label'    => 'Inbox',
				'category' => array( 2 )
			),
			'fa-industry'                            => array(
				'label'    => 'Industry',
				'category' => array( 2 )
			),
			'fa-info'                                => array(
				'label'    => 'Info',
				'category' => array( 2 )
			),
			'fa-info-circle'                         => array(
				'label'    => 'Info Circle',
				'category' => array( 2 )
			),
			'fa-institution'                         => array(
				'label'    => 'Institution',
				'category' => array( 2 )
			),
			'fa-key'                                 => array(
				'label'    => 'Key',
				'category' => array( 2 )
			),
			'fa-keyboard-o'                          => array(
				'label'    => 'Keyboard <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-language'                            => array(
				'label'    => 'Language',
				'category' => array( 2 )
			),
			'fa-laptop'                              => array(
				'label'    => 'Laptop',
				'category' => array( 2 )
			),
			'fa-leaf'                                => array(
				'label'    => 'Leaf',
				'category' => array( 2 )
			),
			'fa-legal'                               => array(
				'label'    => 'Legal',
				'category' => array( 2 )
			),
			'fa-lemon-o'                             => array(
				'label'    => 'Lemon <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-level-down'                          => array(
				'label'    => 'Level Down',
				'category' => array( 2 )
			),
			'fa-level-up'                            => array(
				'label'    => 'Level Up',
				'category' => array( 2 )
			),
			'fa-life-bouy'                           => array(
				'label'    => 'Life Bouy',
				'category' => array( 2 )
			),
			'fa-life-buoy'                           => array(
				'label'    => 'Life Buoy',
				'category' => array( 2 )
			),
			'fa-life-ring'                           => array(
				'label'    => 'Life Ring',
				'category' => array( 2 )
			),
			'fa-life-saver'                          => array(
				'label'    => 'Life Saver',
				'category' => array( 2 )
			),
			'fa-lightbulb-o'                         => array(
				'label'    => 'Lightbulb <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-line-chart'                          => array(
				'label'    => 'Line Chart',
				'category' => array( 2, 11 )
			),
			'fa-location-arrow'                      => array(
				'label'    => 'Location Arrow',
				'category' => array( 2 )
			),
			'fa-lock'                                => array(
				'label'    => 'Lock',
				'category' => array( 2 )
			),
			'fa-low-vision'                          => array(
				'label'    => 'Low Vision',
				'category' => array( 2, 3 )
			),
			'fa-magic'                               => array(
				'label'    => 'Magic',
				'category' => array( 2 )
			),
			'fa-magnet'                              => array(
				'label'    => 'Magnet',
				'category' => array( 2 )
			),
			'fa-mail-forward'                        => array(
				'label'    => 'Mail Forward',
				'category' => array( 2 )
			),
			'fa-mail-reply'                          => array(
				'label'    => 'Mail Reply',
				'category' => array( 2 )
			),
			'fa-mail-reply-all'                      => array(
				'label'    => 'Mail Reply All',
				'category' => array( 2 )
			),
			'fa-male'                                => array(
				'label'    => 'Male',
				'category' => array( 2 )
			),
			'fa-map'                                 => array(
				'label'    => 'Map',
				'category' => array( 2 )
			),
			'fa-map-marker'                          => array(
				'label'    => 'Map Marker',
				'category' => array( 2 )
			),
			'fa-map-o'                               => array(
				'label'    => 'Map <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-map-pin'                             => array(
				'label'    => 'Map Pin',
				'category' => array( 2 )
			),
			'fa-map-signs'                           => array(
				'label'    => 'Map Signs',
				'category' => array( 2 )
			),
			'fa-meh-o'                               => array(
				'label'    => 'Meh <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-microphone'                          => array(
				'label'    => 'Microphone',
				'category' => array( 2 )
			),
			'fa-microphone-slash'                    => array(
				'label'    => 'Microphone Slash',
				'category' => array( 2 )
			),
			'fa-minus'                               => array(
				'label'    => 'Minus',
				'category' => array( 2 )
			),
			'fa-minus-circle'                        => array(
				'label'    => 'Minus Circle',
				'category' => array( 2 )
			),
			'fa-minus-square'                        => array(
				'label'    => 'Minus Square',
				'category' => array( 2, 9 )
			),
			'fa-minus-square-o'                      => array(
				'label'    => 'Minus Square <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 9 )
			),
			'fa-mobile'                              => array(
				'label'    => 'Mobile',
				'category' => array( 2 )
			),
			'fa-mobile-phone'                        => array(
				'label'    => 'Mobile Phone',
				'category' => array( 2 )
			),
			'fa-money'                               => array(
				'label'    => 'Money',
				'category' => array( 2, 12 )
			),
			'fa-moon-o'                              => array(
				'label'    => 'Moon <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-mortar-board'                        => array(
				'label'    => 'Mortar Board',
				'category' => array( 2 )
			),
			'fa-motorcycle'                          => array(
				'label'    => 'Motorcycle',
				'category' => array( 2, 5 )
			),
			'fa-mouse-pointer'                       => array(
				'label'    => 'Mouse Pointer',
				'category' => array( 2 )
			),
			'fa-music'                               => array(
				'label'    => 'Music',
				'category' => array( 2 )
			),
			'fa-navicon'                             => array(
				'label'    => 'Navicon',
				'category' => array( 2 )
			),
			'fa-newspaper-o'                         => array(
				'label'    => 'Newspaper <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-object-group'                        => array(
				'label'    => 'Object Group',
				'category' => array( 2 )
			),
			'fa-object-ungroup'                      => array(
				'label'    => 'Object Ungroup',
				'category' => array( 2 )
			),
			'fa-paint-brush'                         => array(
				'label'    => 'Paint Brush',
				'category' => array( 2 )
			),
			'fa-paper-plane'                         => array(
				'label'    => 'Paper Plane',
				'category' => array( 2 )
			),
			'fa-paper-plane-o'                       => array(
				'label'    => 'Paper Plane <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-paw'                                 => array(
				'label'    => 'Paw',
				'category' => array( 2 )
			),
			'fa-pencil'                              => array(
				'label'    => 'Pencil',
				'category' => array( 2 )
			),
			'fa-pencil-square'                       => array(
				'label'    => 'Pencil Square',
				'category' => array( 2 )
			),
			'fa-pencil-square-o'                     => array(
				'label'    => 'Pencil Square <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-percent'                             => array(
				'label'    => 'Percent',
				'category' => array( 2 )
			),
			'fa-phone'                               => array(
				'label'    => 'Phone',
				'category' => array( 2 )
			),
			'fa-phone-square'                        => array(
				'label'    => 'Phone Square',
				'category' => array( 2 )
			),
			'fa-photo'                               => array(
				'label'    => 'Photo',
				'category' => array( 2 )
			),
			'fa-picture-o'                           => array(
				'label'    => 'Picture <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-pie-chart'                           => array(
				'label'    => 'Pie Chart',
				'category' => array( 2, 11 )
			),
			'fa-plane'                               => array(
				'label'    => 'Plane',
				'category' => array( 2, 5 )
			),
			'fa-plug'                                => array(
				'label'    => 'Plug',
				'category' => array( 2 )
			),
			'fa-plus'                                => array(
				'label'    => 'Plus',
				'category' => array( 2 )
			),
			'fa-plus-circle'                         => array(
				'label'    => 'Plus Circle',
				'category' => array( 2 )
			),
			'fa-plus-square'                         => array(
				'label'    => 'Plus Square',
				'category' => array( 2, 9, 17 )
			),
			'fa-plus-square-o'                       => array(
				'label'    => 'Plus Square <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 9 )
			),
			'fa-power-off'                           => array(
				'label'    => 'Power Off',
				'category' => array( 2 )
			),
			'fa-print'                               => array(
				'label'    => 'Print',
				'category' => array( 2 )
			),
			'fa-puzzle-piece'                        => array(
				'label'    => 'Puzzle Piece',
				'category' => array( 2 )
			),
			'fa-qrcode'                              => array(
				'label'    => 'Qrcode',
				'category' => array( 2 )
			),
			'fa-question'                            => array(
				'label'    => 'Question',
				'category' => array( 2 )
			),
			'fa-question-circle'                     => array(
				'label'    => 'Question Circle',
				'category' => array( 2 )
			),
			'fa-question-circle-o'                   => array(
				'label'    => 'Question Circle <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 3 )
			),
			'fa-quote-left'                          => array(
				'label'    => 'Quote Left',
				'category' => array( 2 )
			),
			'fa-quote-right'                         => array(
				'label'    => 'Quote Right',
				'category' => array( 2 )
			),
			'fa-random'                              => array(
				'label'    => 'Random',
				'category' => array( 2, 15 )
			),
			'fa-recycle'                             => array(
				'label'    => 'Recycle',
				'category' => array( 2 )
			),
			'fa-refresh'                             => array(
				'label'    => 'Refresh',
				'category' => array( 2, 8 )
			),
			'fa-registered'                          => array(
				'label'    => 'Registered',
				'category' => array( 2 )
			),
			'fa-remove'                              => array(
				'label'    => 'Remove',
				'category' => array( 2 )
			),
			'fa-reorder'                             => array(
				'label'    => 'Reorder',
				'category' => array( 2 )
			),
			'fa-reply'                               => array(
				'label'    => 'Reply',
				'category' => array( 2 )
			),
			'fa-reply-all'                           => array(
				'label'    => 'Reply All',
				'category' => array( 2 )
			),
			'fa-retweet'                             => array(
				'label'    => 'Retweet',
				'category' => array( 2 )
			),
			'fa-road'                                => array(
				'label'    => 'Road',
				'category' => array( 2 )
			),
			'fa-rocket'                              => array(
				'label'    => 'Rocket',
				'category' => array( 2, 5 )
			),
			'fa-rss'                                 => array(
				'label'    => 'Rss',
				'category' => array( 2 )
			),
			'fa-rss-square'                          => array(
				'label'    => 'Rss Square',
				'category' => array( 2 )
			),
			'fa-search'                              => array(
				'label'    => 'Search',
				'category' => array( 2 )
			),
			'fa-search-minus'                        => array(
				'label'    => 'Search Minus',
				'category' => array( 2 )
			),
			'fa-search-plus'                         => array(
				'label'    => 'Search Plus',
				'category' => array( 2 )
			),
			'fa-send'                                => array(
				'label'    => 'Send',
				'category' => array( 2 )
			),
			'fa-send-o'                              => array(
				'label'    => 'Send <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-server'                              => array(
				'label'    => 'Server',
				'category' => array( 2 )
			),
			'fa-share'                               => array(
				'label'    => 'Share',
				'category' => array( 2 )
			),
			'fa-share-alt'                           => array(
				'label'    => 'Share Alt',
				'category' => array( 2, 16 )
			),
			'fa-share-alt-square'                    => array(
				'label'    => 'Share Alt Square',
				'category' => array( 2, 16 )
			),
			'fa-share-square'                        => array(
				'label'    => 'Share Square',
				'category' => array( 2 )
			),
			'fa-share-square-o'                      => array(
				'label'    => 'Share Square <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-shield'                              => array(
				'label'    => 'Shield',
				'category' => array( 2 )
			),
			'fa-ship'                                => array(
				'label'    => 'Ship',
				'category' => array( 2, 5 )
			),
			'fa-shopping-bag'                        => array(
				'label'    => 'Shopping Bag',
				'category' => array( 2 )
			),
			'fa-shopping-basket'                     => array(
				'label'    => 'Shopping Basket',
				'category' => array( 2 )
			),
			'fa-shopping-cart'                       => array(
				'label'    => 'Shopping Cart',
				'category' => array( 2 )
			),
			'fa-sign-in'                             => array(
				'label'    => 'Sign In',
				'category' => array( 2 )
			),
			'fa-sign-language'                       => array(
				'label'    => 'Sign Language',
				'category' => array( 2, 3 )
			),
			'fa-sign-out'                            => array(
				'label'    => 'Sign Out',
				'category' => array( 2 )
			),
			'fa-signal'                              => array(
				'label'    => 'Signal',
				'category' => array( 2 )
			),
			'fa-signing'                             => array(
				'label'    => 'Signing',
				'category' => array( 2, 3 )
			),
			'fa-sitemap'                             => array(
				'label'    => 'Sitemap',
				'category' => array( 2 )
			),
			'fa-sliders'                             => array(
				'label'    => 'Sliders',
				'category' => array( 2 )
			),
			'fa-smile-o'                             => array(
				'label'    => 'Smile <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-soccer-ball-o'                       => array(
				'label'    => 'Soccer Ball <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-sort'                                => array(
				'label'    => 'Sort',
				'category' => array( 2 )
			),
			'fa-sort-alpha-asc'                      => array(
				'label'    => 'Sort Alpha Asc',
				'category' => array( 2 )
			),
			'fa-sort-alpha-desc'                     => array(
				'label'    => 'Sort Alpha Desc',
				'category' => array( 2 )
			),
			'fa-sort-amount-asc'                     => array(
				'label'    => 'Sort Amount Asc',
				'category' => array( 2 )
			),
			'fa-sort-amount-desc'                    => array(
				'label'    => 'Sort Amount Desc',
				'category' => array( 2 )
			),
			'fa-sort-asc'                            => array(
				'label'    => 'Sort Asc',
				'category' => array( 2 )
			),
			'fa-sort-desc'                           => array(
				'label'    => 'Sort Desc',
				'category' => array( 2 )
			),
			'fa-sort-down'                           => array(
				'label'    => 'Sort Down',
				'category' => array( 2 )
			),
			'fa-sort-numeric-asc'                    => array(
				'label'    => 'Sort Numeric Asc',
				'category' => array( 2 )
			),
			'fa-sort-numeric-desc'                   => array(
				'label'    => 'Sort Numeric Desc',
				'category' => array( 2 )
			),
			'fa-sort-up'                             => array(
				'label'    => 'Sort Up',
				'category' => array( 2 )
			),
			'fa-space-shuttle'                       => array(
				'label'    => 'Space Shuttle',
				'category' => array( 2, 5 )
			),
			'fa-spinner'                             => array(
				'label'    => 'Spinner',
				'category' => array( 2, 8 )
			),
			'fa-spoon'                               => array(
				'label'    => 'Spoon',
				'category' => array( 2 )
			),
			'fa-square'                              => array(
				'label'    => 'Square',
				'category' => array( 2, 9 )
			),
			'fa-square-o'                            => array(
				'label'    => 'Square <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 9 )
			),
			'fa-star'                                => array(
				'label'    => 'Star',
				'category' => array( 2 )
			),
			'fa-star-half'                           => array(
				'label'    => 'Star Half',
				'category' => array( 2 )
			),
			'fa-star-half-empty'                     => array(
				'label'    => 'Star Half Empty',
				'category' => array( 2 )
			),
			'fa-star-half-full'                      => array(
				'label'    => 'Star Half Full',
				'category' => array( 2 )
			),
			'fa-star-half-o'                         => array(
				'label'    => 'Star Half <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-star-o'                              => array(
				'label'    => 'Star <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-sticky-note'                         => array(
				'label'    => 'Sticky Note',
				'category' => array( 2 )
			),
			'fa-sticky-note-o'                       => array(
				'label'    => 'Sticky Note <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-street-view'                         => array(
				'label'    => 'Street View',
				'category' => array( 2 )
			),
			'fa-suitcase'                            => array(
				'label'    => 'Suitcase',
				'category' => array( 2 )
			),
			'fa-sun-o'                               => array(
				'label'    => 'Sun <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-support'                             => array(
				'label'    => 'Support',
				'category' => array( 2 )
			),
			'fa-tablet'                              => array(
				'label'    => 'Tablet',
				'category' => array( 2 )
			),
			'fa-tachometer'                          => array(
				'label'    => 'Tachometer',
				'category' => array( 2 )
			),
			'fa-tag'                                 => array(
				'label'    => 'Tag',
				'category' => array( 2 )
			),
			'fa-tags'                                => array(
				'label'    => 'Tags',
				'category' => array( 2 )
			),
			'fa-tasks'                               => array(
				'label'    => 'Tasks',
				'category' => array( 2 )
			),
			'fa-taxi'                                => array(
				'label'    => 'Taxi',
				'category' => array( 2, 5 )
			),
			'fa-television'                          => array(
				'label'    => 'Television',
				'category' => array( 2 )
			),
			'fa-terminal'                            => array(
				'label'    => 'Terminal',
				'category' => array( 2 )
			),
			'fa-thumb-tack'                          => array(
				'label'    => 'Thumb Tack',
				'category' => array( 2 )
			),
			'fa-thumbs-down'                         => array(
				'label'    => 'Thumbs Down',
				'category' => array( 2, 4 )
			),
			'fa-thumbs-o-down'                       => array(
				'label'    => 'Thumbs Down <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 4 )
			),
			'fa-thumbs-o-up'                         => array(
				'label'    => 'Thumbs Up <span class="text-muted">(Outline)</span>',
				'category' => array( 2, 4 )
			),
			'fa-thumbs-up'                           => array(
				'label'    => 'Thumbs Up',
				'category' => array( 2, 4 )
			),
			'fa-ticket'                              => array(
				'label'    => 'Ticket',
				'category' => array( 2 )
			),
			'fa-times'                               => array(
				'label'    => 'Times',
				'category' => array( 2 )
			),
			'fa-times-circle'                        => array(
				'label'    => 'Times Circle',
				'category' => array( 2 )
			),
			'fa-times-circle-o'                      => array(
				'label'    => 'Times Circle <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-tint'                                => array(
				'label'    => 'Tint',
				'category' => array( 2 )
			),
			'fa-toggle-down'                         => array(
				'label'    => 'Toggle Down',
				'category' => array( 2, 14 )
			),
			'fa-toggle-left'                         => array(
				'label'    => 'Toggle Left',
				'category' => array( 2, 14 )
			),
			'fa-toggle-off'                          => array(
				'label'    => 'Toggle Off',
				'category' => array( 2 )
			),
			'fa-toggle-on'                           => array(
				'label'    => 'Toggle On',
				'category' => array( 2 )
			),
			'fa-toggle-right'                        => array(
				'label'    => 'Toggle Right',
				'category' => array( 2, 14 )
			),
			'fa-toggle-up'                           => array(
				'label'    => 'Toggle Up',
				'category' => array( 2, 14 )
			),
			'fa-trademark'                           => array(
				'label'    => 'Trademark',
				'category' => array( 2 )
			),
			'fa-trash'                               => array(
				'label'    => 'Trash',
				'category' => array( 2 )
			),
			'fa-trash-o'                             => array(
				'label'    => 'Trash <span class="text-muted">(Outline)</span>',
				'category' => array( 2 )
			),
			'fa-tree'                                => array(
				'label'    => 'Tree',
				'category' => array( 2 )
			),
			'fa-trophy'                              => array(
				'label'    => 'Trophy',
				'category' => array( 2 )
			),
			'fa-truck'                               => array(
				'label'    => 'Truck',
				'category' => array( 2, 5 )
			),
			'fa-tty'                                 => array(
				'label'    => 'Tty',
				'category' => array( 2, 3 )
			),
			'fa-tv'                                  => array(
				'label'    => 'Tv',
				'category' => array( 2 )
			),
			'fa-umbrella'                            => array(
				'label'    => 'Umbrella',
				'category' => array( 2 )
			),
			'fa-universal-access'                    => array(
				'label'    => 'Universal Access',
				'category' => array( 2, 3 )
			),
			'fa-university'                          => array(
				'label'    => 'University',
				'category' => array( 2 )
			),
			'fa-unlock'                              => array(
				'label'    => 'Unlock',
				'category' => array( 2 )
			),
			'fa-unlock-alt'                          => array(
				'label'    => 'Unlock Alt',
				'category' => array( 2 )
			),
			'fa-unsorted'                            => array(
				'label'    => 'Unsorted',
				'category' => array( 2 )
			),
			'fa-upload'                              => array(
				'label'    => 'Upload',
				'category' => array( 2 )
			),
			'fa-user'                                => array(
				'label'    => 'User',
				'category' => array( 2 )
			),
			'fa-user-plus'                           => array(
				'label'    => 'User Plus',
				'category' => array( 2 )
			),
			'fa-user-secret'                         => array(
				'label'    => 'User Secret',
				'category' => array( 2 )
			),
			'fa-user-times'                          => array(
				'label'    => 'User Times',
				'category' => array( 2 )
			),
			'fa-users'                               => array(
				'label'    => 'Users',
				'category' => array( 2 )
			),
			'fa-video-camera'                        => array(
				'label'    => 'Video Camera',
				'category' => array( 2 )
			),
			'fa-volume-control-phone'                => array(
				'label'    => 'Volume Control Phone',
				'category' => array( 2, 3 )
			),
			'fa-volume-down'                         => array(
				'label'    => 'Volume Down',
				'category' => array( 2 )
			),
			'fa-volume-off'                          => array(
				'label'    => 'Volume Off',
				'category' => array( 2 )
			),
			'fa-volume-up'                           => array(
				'label'    => 'Volume Up',
				'category' => array( 2 )
			),
			'fa-warning'                             => array(
				'label'    => 'Warning',
				'category' => array( 2 )
			),
			'fa-wheelchair'                          => array(
				'label'    => 'Wheelchair',
				'category' => array( 2, 3, 5, 17 )
			),
			'fa-wheelchair-alt'                      => array(
				'label'    => 'Wheelchair Alt',
				'category' => array( 2, 3, 5, 17 )
			),
			'fa-wifi'                                => array(
				'label'    => 'Wifi',
				'category' => array( 2 )
			),
			'fa-wrench'                              => array(
				'label'    => 'Wrench',
				'category' => array( 2 )
			),
			'fa-hand-o-down'                         => array(
				'label'    => 'Hand Down <span class="text-muted">(Outline)</span>',
				'category' => array( 4, 14 )
			),
			'fa-hand-o-left'                         => array(
				'label'    => 'Hand Left <span class="text-muted">(Outline)</span>',
				'category' => array( 4, 14 )
			),
			'fa-hand-o-right'                        => array(
				'label'    => 'Hand Right <span class="text-muted">(Outline)</span>',
				'category' => array( 4, 14 )
			),
			'fa-hand-o-up'                           => array(
				'label'    => 'Hand Up <span class="text-muted">(Outline)</span>',
				'category' => array( 4, 14 )
			),
			'fa-ambulance'                           => array(
				'label'    => 'Ambulance',
				'category' => array( 5, 17 )
			),
			'fa-subway'                              => array(
				'label'    => 'Subway',
				'category' => array( 5 )
			),
			'fa-train'                               => array(
				'label'    => 'Train',
				'category' => array( 5 )
			),
			'fa-genderless'                          => array(
				'label'    => 'Genderless',
				'category' => array( 6 )
			),
			'fa-intersex'                            => array(
				'label'    => 'Intersex',
				'category' => array( 6 )
			),
			'fa-mars'                                => array(
				'label'    => 'Mars',
				'category' => array( 6 )
			),
			'fa-mars-double'                         => array(
				'label'    => 'Mars Double',
				'category' => array( 6 )
			),
			'fa-mars-stroke'                         => array(
				'label'    => 'Mars Stroke',
				'category' => array( 6 )
			),
			'fa-mars-stroke-h'                       => array(
				'label'    => 'Mars Stroke H',
				'category' => array( 6 )
			),
			'fa-mars-stroke-v'                       => array(
				'label'    => 'Mars Stroke V',
				'category' => array( 6 )
			),
			'fa-mercury'                             => array(
				'label'    => 'Mercury',
				'category' => array( 6 )
			),
			'fa-neuter'                              => array(
				'label'    => 'Neuter',
				'category' => array( 6 )
			),
			'fa-transgender'                         => array(
				'label'    => 'Transgender',
				'category' => array( 6 )
			),
			'fa-transgender-alt'                     => array(
				'label'    => 'Transgender Alt',
				'category' => array( 6 )
			),
			'fa-venus'                               => array(
				'label'    => 'Venus',
				'category' => array( 6 )
			),
			'fa-venus-double'                        => array(
				'label'    => 'Venus Double',
				'category' => array( 6 )
			),
			'fa-venus-mars'                          => array(
				'label'    => 'Venus Mars',
				'category' => array( 6 )
			),
			'fa-file'                                => array(
				'label'    => 'File',
				'category' => array( 7, 13 )
			),
			'fa-file-o'                              => array(
				'label'    => 'File <span class="text-muted">(Outline)</span>',
				'category' => array( 7, 13 )
			),
			'fa-file-text'                           => array(
				'label'    => 'File Text',
				'category' => array( 7, 13 )
			),
			'fa-file-text-o'                         => array(
				'label'    => 'File Text <span class="text-muted">(Outline)</span>',
				'category' => array( 7, 13 )
			),
			'fa-cc-amex'                             => array(
				'label'    => 'Cc Amex',
				'category' => array( 10, 16 )
			),
			'fa-cc-diners-club'                      => array(
				'label'    => 'Cc Diners Club',
				'category' => array( 10, 16 )
			),
			'fa-cc-discover'                         => array(
				'label'    => 'Cc Discover',
				'category' => array( 10, 16 )
			),
			'fa-cc-jcb'                              => array(
				'label'    => 'Cc Jcb',
				'category' => array( 10, 16 )
			),
			'fa-cc-mastercard'                       => array(
				'label'    => 'Cc Mastercard',
				'category' => array( 10, 16 )
			),
			'fa-cc-paypal'                           => array(
				'label'    => 'Cc Paypal',
				'category' => array( 10, 16 )
			),
			'fa-cc-stripe'                           => array(
				'label'    => 'Cc Stripe',
				'category' => array( 10, 16 )
			),
			'fa-cc-visa'                             => array(
				'label'    => 'Cc Visa',
				'category' => array( 10, 16 )
			),
			'fa-google-wallet'                       => array(
				'label'    => 'Google Wallet',
				'category' => array( 10, 16 )
			),
			'fa-paypal'                              => array(
				'label'    => 'Paypal',
				'category' => array( 10, 16 )
			),
			'fa-bitcoin'                             => array(
				'label'    => 'Bitcoin',
				'category' => array( 12, 16 )
			),
			'fa-btc'                                 => array(
				'label'    => 'Btc',
				'category' => array( 12, 16 )
			),
			'fa-cny'                                 => array(
				'label'    => 'Cny',
				'category' => array( 12 )
			),
			'fa-dollar'                              => array(
				'label'    => 'Dollar',
				'category' => array( 12 )
			),
			'fa-eur'                                 => array(
				'label'    => 'Eur',
				'category' => array( 12 )
			),
			'fa-euro'                                => array(
				'label'    => 'Euro',
				'category' => array( 12 )
			),
			'fa-gbp'                                 => array(
				'label'    => 'Gbp',
				'category' => array( 12 )
			),
			'fa-gg'                                  => array(
				'label'    => 'Gg',
				'category' => array( 12, 16 )
			),
			'fa-gg-circle'                           => array(
				'label'    => 'Gg Circle',
				'category' => array( 12, 16 )
			),
			'fa-ils'                                 => array(
				'label'    => 'Ils',
				'category' => array( 12 )
			),
			'fa-inr'                                 => array(
				'label'    => 'Inr',
				'category' => array( 12 )
			),
			'fa-jpy'                                 => array(
				'label'    => 'Jpy',
				'category' => array( 12 )
			),
			'fa-krw'                                 => array(
				'label'    => 'Krw',
				'category' => array( 12 )
			),
			'fa-rmb'                                 => array(
				'label'    => 'Rmb',
				'category' => array( 12 )
			),
			'fa-rouble'                              => array(
				'label'    => 'Rouble',
				'category' => array( 12 )
			),
			'fa-rub'                                 => array(
				'label'    => 'Rub',
				'category' => array( 12 )
			),
			'fa-ruble'                               => array(
				'label'    => 'Ruble',
				'category' => array( 12 )
			),
			'fa-rupee'                               => array(
				'label'    => 'Rupee',
				'category' => array( 12 )
			),
			'fa-shekel'                              => array(
				'label'    => 'Shekel',
				'category' => array( 12 )
			),
			'fa-sheqel'                              => array(
				'label'    => 'Sheqel',
				'category' => array( 12 )
			),
			'fa-try'                                 => array(
				'label'    => 'Try',
				'category' => array( 12 )
			),
			'fa-turkish-lira'                        => array(
				'label'    => 'Turkish Lira',
				'category' => array( 12 )
			),
			'fa-usd'                                 => array(
				'label'    => 'Usd',
				'category' => array( 12 )
			),
			'fa-won'                                 => array(
				'label'    => 'Won',
				'category' => array( 12 )
			),
			'fa-yen'                                 => array(
				'label'    => 'Yen',
				'category' => array( 12 )
			),
			'fa-align-center'                        => array(
				'label'    => 'Align Center',
				'category' => array( 13 )
			),
			'fa-align-justify'                       => array(
				'label'    => 'Align Justify',
				'category' => array( 13 )
			),
			'fa-align-left'                          => array(
				'label'    => 'Align Left',
				'category' => array( 13 )
			),
			'fa-align-right'                         => array(
				'label'    => 'Align Right',
				'category' => array( 13 )
			),
			'fa-bold'                                => array(
				'label'    => 'Bold',
				'category' => array( 13 )
			),
			'fa-chain'                               => array(
				'label'    => 'Chain',
				'category' => array( 13 )
			),
			'fa-chain-broken'                        => array(
				'label'    => 'Chain Broken',
				'category' => array( 13 )
			),
			'fa-clipboard'                           => array(
				'label'    => 'Clipboard',
				'category' => array( 13 )
			),
			'fa-columns'                             => array(
				'label'    => 'Columns',
				'category' => array( 13 )
			),
			'fa-copy'                                => array(
				'label'    => 'Copy',
				'category' => array( 13 )
			),
			'fa-cut'                                 => array(
				'label'    => 'Cut',
				'category' => array( 13 )
			),
			'fa-dedent'                              => array(
				'label'    => 'Dedent',
				'category' => array( 13 )
			),
			'fa-files-o'                             => array(
				'label'    => 'Files <span class="text-muted">(Outline)</span>',
				'category' => array( 13 )
			),
			'fa-floppy-o'                            => array(
				'label'    => 'Floppy <span class="text-muted">(Outline)</span>',
				'category' => array( 13 )
			),
			'fa-font'                                => array(
				'label'    => 'Font',
				'category' => array( 13 )
			),
			'fa-header'                              => array(
				'label'    => 'Header',
				'category' => array( 13 )
			),
			'fa-indent'                              => array(
				'label'    => 'Indent',
				'category' => array( 13 )
			),
			'fa-italic'                              => array(
				'label'    => 'Italic',
				'category' => array( 13 )
			),
			'fa-link'                                => array(
				'label'    => 'Link',
				'category' => array( 13 )
			),
			'fa-list'                                => array(
				'label'    => 'List',
				'category' => array( 13 )
			),
			'fa-list-alt'                            => array(
				'label'    => 'List Alt',
				'category' => array( 13 )
			),
			'fa-list-ol'                             => array(
				'label'    => 'List Ol',
				'category' => array( 13 )
			),
			'fa-list-ul'                             => array(
				'label'    => 'List Ul',
				'category' => array( 13 )
			),
			'fa-outdent'                             => array(
				'label'    => 'Outdent',
				'category' => array( 13 )
			),
			'fa-paperclip'                           => array(
				'label'    => 'Paperclip',
				'category' => array( 13 )
			),
			'fa-paragraph'                           => array(
				'label'    => 'Paragraph',
				'category' => array( 13 )
			),
			'fa-paste'                               => array(
				'label'    => 'Paste',
				'category' => array( 13 )
			),
			'fa-repeat'                              => array(
				'label'    => 'Repeat',
				'category' => array( 13 )
			),
			'fa-rotate-left'                         => array(
				'label'    => 'Rotate Left',
				'category' => array( 13 )
			),
			'fa-rotate-right'                        => array(
				'label'    => 'Rotate Right',
				'category' => array( 13 )
			),
			'fa-save'                                => array(
				'label'    => 'Save',
				'category' => array( 13 )
			),
			'fa-scissors'                            => array(
				'label'    => 'Scissors',
				'category' => array( 13 )
			),
			'fa-strikethrough'                       => array(
				'label'    => 'Strikethrough',
				'category' => array( 13 )
			),
			'fa-subscript'                           => array(
				'label'    => 'Subscript',
				'category' => array( 13 )
			),
			'fa-superscript'                         => array(
				'label'    => 'Superscript',
				'category' => array( 13 )
			),
			'fa-table'                               => array(
				'label'    => 'Table',
				'category' => array( 13 )
			),
			'fa-text-height'                         => array(
				'label'    => 'Text Height',
				'category' => array( 13 )
			),
			'fa-text-width'                          => array(
				'label'    => 'Text Width',
				'category' => array( 13 )
			),
			'fa-th'                                  => array(
				'label'    => 'Th',
				'category' => array( 13 )
			),
			'fa-th-large'                            => array(
				'label'    => 'Th Large',
				'category' => array( 13 )
			),
			'fa-th-list'                             => array(
				'label'    => 'Th List',
				'category' => array( 13 )
			),
			'fa-underline'                           => array(
				'label'    => 'Underline',
				'category' => array( 13 )
			),
			'fa-undo'                                => array(
				'label'    => 'Undo',
				'category' => array( 13 )
			),
			'fa-unlink'                              => array(
				'label'    => 'Unlink',
				'category' => array( 13 )
			),
			'fa-angle-double-down'                   => array(
				'label'    => 'Angle Double Down',
				'category' => array( 14 )
			),
			'fa-angle-double-left'                   => array(
				'label'    => 'Angle Double Left',
				'category' => array( 14 )
			),
			'fa-angle-double-right'                  => array(
				'label'    => 'Angle Double Right',
				'category' => array( 14 )
			),
			'fa-angle-double-up'                     => array(
				'label'    => 'Angle Double Up',
				'category' => array( 14 )
			),
			'fa-angle-down'                          => array(
				'label'    => 'Angle Down',
				'category' => array( 14 )
			),
			'fa-angle-left'                          => array(
				'label'    => 'Angle Left',
				'category' => array( 14 )
			),
			'fa-angle-right'                         => array(
				'label'    => 'Angle Right',
				'category' => array( 14 )
			),
			'fa-angle-up'                            => array(
				'label'    => 'Angle Up',
				'category' => array( 14 )
			),
			'fa-arrow-circle-down'                   => array(
				'label'    => 'Arrow Circle Down',
				'category' => array( 14 )
			),
			'fa-arrow-circle-left'                   => array(
				'label'    => 'Arrow Circle Left',
				'category' => array( 14 )
			),
			'fa-arrow-circle-o-down'                 => array(
				'label'    => 'Arrow Circle Down <span class="text-muted">(Outline)</span>',
				'category' => array( 14 )
			),
			'fa-arrow-circle-o-left'                 => array(
				'label'    => 'Arrow Circle Left <span class="text-muted">(Outline)</span>',
				'category' => array( 14 )
			),
			'fa-arrow-circle-o-right'                => array(
				'label'    => 'Arrow Circle Right <span class="text-muted">(Outline)</span>',
				'category' => array( 14 )
			),
			'fa-arrow-circle-o-up'                   => array(
				'label'    => 'Arrow Circle Up <span class="text-muted">(Outline)</span>',
				'category' => array( 14 )
			),
			'fa-arrow-circle-right'                  => array(
				'label'    => 'Arrow Circle Right',
				'category' => array( 14 )
			),
			'fa-arrow-circle-up'                     => array(
				'label'    => 'Arrow Circle Up',
				'category' => array( 14 )
			),
			'fa-arrow-down'                          => array(
				'label'    => 'Arrow Down',
				'category' => array( 14 )
			),
			'fa-arrow-left'                          => array(
				'label'    => 'Arrow Left',
				'category' => array( 14 )
			),
			'fa-arrow-right'                         => array(
				'label'    => 'Arrow Right',
				'category' => array( 14 )
			),
			'fa-arrow-up'                            => array(
				'label'    => 'Arrow Up',
				'category' => array( 14 )
			),
			'fa-arrows-alt'                          => array(
				'label'    => 'Arrows Alt',
				'category' => array( 14, 15 )
			),
			'fa-caret-down'                          => array(
				'label'    => 'Caret Down',
				'category' => array( 14 )
			),
			'fa-caret-left'                          => array(
				'label'    => 'Caret Left',
				'category' => array( 14 )
			),
			'fa-caret-right'                         => array(
				'label'    => 'Caret Right',
				'category' => array( 14 )
			),
			'fa-caret-up'                            => array(
				'label'    => 'Caret Up',
				'category' => array( 14 )
			),
			'fa-chevron-circle-down'                 => array(
				'label'    => 'Chevron Circle Down',
				'category' => array( 14 )
			),
			'fa-chevron-circle-left'                 => array(
				'label'    => 'Chevron Circle Left',
				'category' => array( 14 )
			),
			'fa-chevron-circle-right'                => array(
				'label'    => 'Chevron Circle Right',
				'category' => array( 14 )
			),
			'fa-chevron-circle-up'                   => array(
				'label'    => 'Chevron Circle Up',
				'category' => array( 14 )
			),
			'fa-chevron-down'                        => array(
				'label'    => 'Chevron Down',
				'category' => array( 14 )
			),
			'fa-chevron-left'                        => array(
				'label'    => 'Chevron Left',
				'category' => array( 14 )
			),
			'fa-chevron-right'                       => array(
				'label'    => 'Chevron Right',
				'category' => array( 14 )
			),
			'fa-chevron-up'                          => array(
				'label'    => 'Chevron Up',
				'category' => array( 14 )
			),
			'fa-long-arrow-down'                     => array(
				'label'    => 'Long Arrow Down',
				'category' => array( 14 )
			),
			'fa-long-arrow-left'                     => array(
				'label'    => 'Long Arrow Left',
				'category' => array( 14 )
			),
			'fa-long-arrow-right'                    => array(
				'label'    => 'Long Arrow Right',
				'category' => array( 14 )
			),
			'fa-long-arrow-up'                       => array(
				'label'    => 'Long Arrow Up',
				'category' => array( 14 )
			),
			'fa-backward'                            => array(
				'label'    => 'Backward',
				'category' => array( 15 )
			),
			'fa-compress'                            => array(
				'label'    => 'Compress',
				'category' => array( 15 )
			),
			'fa-eject'                               => array(
				'label'    => 'Eject',
				'category' => array( 15 )
			),
			'fa-expand'                              => array(
				'label'    => 'Expand',
				'category' => array( 15 )
			),
			'fa-fast-backward'                       => array(
				'label'    => 'Fast Backward',
				'category' => array( 15 )
			),
			'fa-fast-forward'                        => array(
				'label'    => 'Fast Forward',
				'category' => array( 15 )
			),
			'fa-forward'                             => array(
				'label'    => 'Forward',
				'category' => array( 15 )
			),
			'fa-pause'                               => array(
				'label'    => 'Pause',
				'category' => array( 15 )
			),
			'fa-pause-circle'                        => array(
				'label'    => 'Pause Circle',
				'category' => array( 15 )
			),
			'fa-pause-circle-o'                      => array(
				'label'    => 'Pause Circle <span class="text-muted">(Outline)</span>',
				'category' => array( 15 )
			),
			'fa-play'                                => array(
				'label'    => 'Play',
				'category' => array( 15 )
			),
			'fa-play-circle'                         => array(
				'label'    => 'Play Circle',
				'category' => array( 15 )
			),
			'fa-play-circle-o'                       => array(
				'label'    => 'Play Circle <span class="text-muted">(Outline)</span>',
				'category' => array( 15 )
			),
			'fa-step-backward'                       => array(
				'label'    => 'Step Backward',
				'category' => array( 15 )
			),
			'fa-step-forward'                        => array(
				'label'    => 'Step Forward',
				'category' => array( 15 )
			),
			'fa-stop'                                => array(
				'label'    => 'Stop',
				'category' => array( 15 )
			),
			'fa-stop-circle'                         => array(
				'label'    => 'Stop Circle',
				'category' => array( 15 )
			),
			'fa-stop-circle-o'                       => array(
				'label'    => 'Stop Circle <span class="text-muted">(Outline)</span>',
				'category' => array( 15 )
			),
			'fa-youtube-play'                        => array(
				'label'    => 'Youtube Play',
				'category' => array( 15, 16 )
			),
			'fa-500px'                               => array(
				'label'    => '500px',
				'category' => array( 16 )
			),
			'fa-adn'                                 => array(
				'label'    => 'Adn',
				'category' => array( 16 )
			),
			'fa-amazon'                              => array(
				'label'    => 'Amazon',
				'category' => array( 16 )
			),
			'fa-android'                             => array(
				'label'    => 'Android',
				'category' => array( 16 )
			),
			'fa-angellist'                           => array(
				'label'    => 'Angellist',
				'category' => array( 16 )
			),
			'fa-apple'                               => array(
				'label'    => 'Apple',
				'category' => array( 16 )
			),
			'fa-behance'                             => array(
				'label'    => 'Behance',
				'category' => array( 16 )
			),
			'fa-behance-square'                      => array(
				'label'    => 'Behance Square',
				'category' => array( 16 )
			),
			'fa-bitbucket'                           => array(
				'label'    => 'Bitbucket',
				'category' => array( 16 )
			),
			'fa-bitbucket-square'                    => array(
				'label'    => 'Bitbucket Square',
				'category' => array( 16 )
			),
			'fa-black-tie'                           => array(
				'label'    => 'Black Tie',
				'category' => array( 16 )
			),
			'fa-buysellads'                          => array(
				'label'    => 'Buysellads',
				'category' => array( 16 )
			),
			'fa-chrome'                              => array(
				'label'    => 'Chrome',
				'category' => array( 16 )
			),
			'fa-codepen'                             => array(
				'label'    => 'Codepen',
				'category' => array( 16 )
			),
			'fa-codiepie'                            => array(
				'label'    => 'Codiepie',
				'category' => array( 16 )
			),
			'fa-connectdevelop'                      => array(
				'label'    => 'Connectdevelop',
				'category' => array( 16 )
			),
			'fa-contao'                              => array(
				'label'    => 'Contao',
				'category' => array( 16 )
			),
			'fa-css3'                                => array(
				'label'    => 'Css3',
				'category' => array( 16 )
			),
			'fa-dashcube'                            => array(
				'label'    => 'Dashcube',
				'category' => array( 16 )
			),
			'fa-delicious'                           => array(
				'label'    => 'Delicious',
				'category' => array( 16 )
			),
			'fa-deviantart'                          => array(
				'label'    => 'Deviantart',
				'category' => array( 16 )
			),
			'fa-digg'                                => array(
				'label'    => 'Digg',
				'category' => array( 16 )
			),
			'fa-dribbble'                            => array(
				'label'    => 'Dribbble',
				'category' => array( 16 )
			),
			'fa-dropbox'                             => array(
				'label'    => 'Dropbox',
				'category' => array( 16 )
			),
			'fa-drupal'                              => array(
				'label'    => 'Drupal',
				'category' => array( 16 )
			),
			'fa-edge'                                => array(
				'label'    => 'Edge',
				'category' => array( 16 )
			),
			'fa-empire'                              => array(
				'label'    => 'Empire',
				'category' => array( 16 )
			),
			'fa-envira'                              => array(
				'label'    => 'Envira',
				'category' => array( 16 )
			),
			'fa-expeditedssl'                        => array(
				'label'    => 'Expeditedssl',
				'category' => array( 16 )
			),
			'fa-fa'                                  => array(
				'label'    => 'Fa',
				'category' => array( 16 )
			),
			'fa-facebook'                            => array(
				'label'    => 'Facebook',
				'category' => array( 16 )
			),
			'fa-facebook-f'                          => array(
				'label'    => 'Facebook F',
				'category' => array( 16 )
			),
			'fa-facebook-official'                   => array(
				'label'    => 'Facebook Official',
				'category' => array( 16 )
			),
			'fa-facebook-square'                     => array(
				'label'    => 'Facebook Square',
				'category' => array( 16 )
			),
			'fa-firefox'                             => array(
				'label'    => 'Firefox',
				'category' => array( 16 )
			),
			'fa-first-order'                         => array(
				'label'    => 'First Order',
				'category' => array( 16 )
			),
			'fa-flickr'                              => array(
				'label'    => 'Flickr',
				'category' => array( 16 )
			),
			'fa-font-awesome'                        => array(
				'label'    => 'Font Awesome',
				'category' => array( 16 )
			),
			'fa-fonticons'                           => array(
				'label'    => 'Fonticons',
				'category' => array( 16 )
			),
			'fa-fort-awesome'                        => array(
				'label'    => 'Fort Awesome',
				'category' => array( 16 )
			),
			'fa-forumbee'                            => array(
				'label'    => 'Forumbee',
				'category' => array( 16 )
			),
			'fa-foursquare'                          => array(
				'label'    => 'Foursquare',
				'category' => array( 16 )
			),
			'fa-ge'                                  => array(
				'label'    => 'Ge',
				'category' => array( 16 )
			),
			'fa-get-pocket'                          => array(
				'label'    => 'Get Pocket',
				'category' => array( 16 )
			),
			'fa-git'                                 => array(
				'label'    => 'Git',
				'category' => array( 16 )
			),
			'fa-git-square'                          => array(
				'label'    => 'Git Square',
				'category' => array( 16 )
			),
			'fa-github'                              => array(
				'label'    => 'Github',
				'category' => array( 16 )
			),
			'fa-github-alt'                          => array(
				'label'    => 'Github Alt',
				'category' => array( 16 )
			),
			'fa-github-square'                       => array(
				'label'    => 'Github Square',
				'category' => array( 16 )
			),
			'fa-gitlab'                              => array(
				'label'    => 'Gitlab',
				'category' => array( 16 )
			),
			'fa-gittip'                              => array(
				'label'    => 'Gittip',
				'category' => array( 16 )
			),
			'fa-glide'                               => array(
				'label'    => 'Glide',
				'category' => array( 16 )
			),
			'fa-glide-g'                             => array(
				'label'    => 'Glide G',
				'category' => array( 16 )
			),
			'fa-google'                              => array(
				'label'    => 'Google',
				'category' => array( 16 )
			),
			'fa-google-plus'                         => array(
				'label'    => 'Google Plus',
				'category' => array( 16 )
			),
			'fa-google-plus-circle'                  => array(
				'label'    => 'Google Plus Circle',
				'category' => array( 16 )
			),
			'fa-google-plus-official'                => array(
				'label'    => 'Google Plus Official',
				'category' => array( 16 )
			),
			'fa-google-plus-square'                  => array(
				'label'    => 'Google Plus Square',
				'category' => array( 16 )
			),
			'fa-gratipay'                            => array(
				'label'    => 'Gratipay',
				'category' => array( 16 )
			),
			'fa-hacker-news'                         => array(
				'label'    => 'Hacker News',
				'category' => array( 16 )
			),
			'fa-houzz'                               => array(
				'label'    => 'Houzz',
				'category' => array( 16 )
			),
			'fa-html5'                               => array(
				'label'    => 'Html5',
				'category' => array( 16 )
			),
			'fa-instagram'                           => array(
				'label'    => 'Instagram',
				'category' => array( 16 )
			),
			'fa-internet-explorer'                   => array(
				'label'    => 'Internet Explorer',
				'category' => array( 16 )
			),
			'fa-ioxhost'                             => array(
				'label'    => 'Ioxhost',
				'category' => array( 16 )
			),
			'fa-joomla'                              => array(
				'label'    => 'Joomla',
				'category' => array( 16 )
			),
			'fa-jsfiddle'                            => array(
				'label'    => 'Jsfiddle',
				'category' => array( 16 )
			),
			'fa-lastfm'                              => array(
				'label'    => 'Lastfm',
				'category' => array( 16 )
			),
			'fa-lastfm-square'                       => array(
				'label'    => 'Lastfm Square',
				'category' => array( 16 )
			),
			'fa-leanpub'                             => array(
				'label'    => 'Leanpub',
				'category' => array( 16 )
			),
			'fa-linkedin'                            => array(
				'label'    => 'Linkedin',
				'category' => array( 16 )
			),
			'fa-linkedin-square'                     => array(
				'label'    => 'Linkedin Square',
				'category' => array( 16 )
			),
			'fa-linux'                               => array(
				'label'    => 'Linux',
				'category' => array( 16 )
			),
			'fa-maxcdn'                              => array(
				'label'    => 'Maxcdn',
				'category' => array( 16 )
			),
			'fa-meanpath'                            => array(
				'label'    => 'Meanpath',
				'category' => array( 16 )
			),
			'fa-medium'                              => array(
				'label'    => 'Medium',
				'category' => array( 16 )
			),
			'fa-mixcloud'                            => array(
				'label'    => 'Mixcloud',
				'category' => array( 16 )
			),
			'fa-modx'                                => array(
				'label'    => 'Modx',
				'category' => array( 16 )
			),
			'fa-odnoklassniki'                       => array(
				'label'    => 'Odnoklassniki',
				'category' => array( 16 )
			),
			'fa-odnoklassniki-square'                => array(
				'label'    => 'Odnoklassniki Square',
				'category' => array( 16 )
			),
			'fa-opencart'                            => array(
				'label'    => 'Opencart',
				'category' => array( 16 )
			),
			'fa-openid'                              => array(
				'label'    => 'Openid',
				'category' => array( 16 )
			),
			'fa-opera'                               => array(
				'label'    => 'Opera',
				'category' => array( 16 )
			),
			'fa-optin-monster'                       => array(
				'label'    => 'Optin Monster',
				'category' => array( 16 )
			),
			'fa-pagelines'                           => array(
				'label'    => 'Pagelines',
				'category' => array( 16 )
			),
			'fa-pied-piper'                          => array(
				'label'    => 'Pied Piper',
				'category' => array( 16 )
			),
			'fa-pied-piper-alt'                      => array(
				'label'    => 'Pied Piper Alt',
				'category' => array( 16 )
			),
			'fa-pied-piper-pp'                       => array(
				'label'    => 'Pied Piper Pp',
				'category' => array( 16 )
			),
			'fa-pinterest'                           => array(
				'label'    => 'Pinterest',
				'category' => array( 16 )
			),
			'fa-pinterest-p'                         => array(
				'label'    => 'Pinterest P',
				'category' => array( 16 )
			),
			'fa-pinterest-square'                    => array(
				'label'    => 'Pinterest Square',
				'category' => array( 16 )
			),
			'fa-product-hunt'                        => array(
				'label'    => 'Product Hunt',
				'category' => array( 16 )
			),
			'fa-qq'                                  => array(
				'label'    => 'Qq',
				'category' => array( 16 )
			),
			'fa-ra'                                  => array(
				'label'    => 'Ra',
				'category' => array( 16 )
			),
			'fa-rebel'                               => array(
				'label'    => 'Rebel',
				'category' => array( 16 )
			),
			'fa-reddit'                              => array(
				'label'    => 'Reddit',
				'category' => array( 16 )
			),
			'fa-reddit-alien'                        => array(
				'label'    => 'Reddit Alien',
				'category' => array( 16 )
			),
			'fa-reddit-square'                       => array(
				'label'    => 'Reddit Square',
				'category' => array( 16 )
			),
			'fa-renren'                              => array(
				'label'    => 'Renren',
				'category' => array( 16 )
			),
			'fa-resistance'                          => array(
				'label'    => 'Resistance',
				'category' => array( 16 )
			),
			'fa-safari'                              => array(
				'label'    => 'Safari',
				'category' => array( 16 )
			),
			'fa-scribd'                              => array(
				'label'    => 'Scribd',
				'category' => array( 16 )
			),
			'fa-sellsy'                              => array(
				'label'    => 'Sellsy',
				'category' => array( 16 )
			),
			'fa-shirtsinbulk'                        => array(
				'label'    => 'Shirtsinbulk',
				'category' => array( 16 )
			),
			'fa-simplybuilt'                         => array(
				'label'    => 'Simplybuilt',
				'category' => array( 16 )
			),
			'fa-skyatlas'                            => array(
				'label'    => 'Skyatlas',
				'category' => array( 16 )
			),
			'fa-skype'                               => array(
				'label'    => 'Skype',
				'category' => array( 16 )
			),
			'fa-slack'                               => array(
				'label'    => 'Slack',
				'category' => array( 16 )
			),
			'fa-slideshare'                          => array(
				'label'    => 'Slideshare',
				'category' => array( 16 )
			),
			'fa-snapchat'                            => array(
				'label'    => 'Snapchat',
				'category' => array( 16 )
			),
			'fa-snapchat-ghost'                      => array(
				'label'    => 'Snapchat Ghost',
				'category' => array( 16 )
			),
			'fa-snapchat-square'                     => array(
				'label'    => 'Snapchat Square',
				'category' => array( 16 )
			),
			'fa-soundcloud'                          => array(
				'label'    => 'Soundcloud',
				'category' => array( 16 )
			),
			'fa-spotify'                             => array(
				'label'    => 'Spotify',
				'category' => array( 16 )
			),
			'fa-stack-exchange'                      => array(
				'label'    => 'Stack Exchange',
				'category' => array( 16 )
			),
			'fa-stack-overflow'                      => array(
				'label'    => 'Stack Overflow',
				'category' => array( 16 )
			),
			'fa-steam'                               => array(
				'label'    => 'Steam',
				'category' => array( 16 )
			),
			'fa-steam-square'                        => array(
				'label'    => 'Steam Square',
				'category' => array( 16 )
			),
			'fa-stumbleupon'                         => array(
				'label'    => 'Stumbleupon',
				'category' => array( 16 )
			),
			'fa-stumbleupon-circle'                  => array(
				'label'    => 'Stumbleupon Circle',
				'category' => array( 16 )
			),
			'fa-tencent-weibo'                       => array(
				'label'    => 'Tencent Weibo',
				'category' => array( 16 )
			),
			'fa-themeisle'                           => array(
				'label'    => 'Themeisle',
				'category' => array( 16 )
			),
			'fa-trello'                              => array(
				'label'    => 'Trello',
				'category' => array( 16 )
			),
			'fa-tripadvisor'                         => array(
				'label'    => 'Tripadvisor',
				'category' => array( 16 )
			),
			'fa-tumblr'                              => array(
				'label'    => 'Tumblr',
				'category' => array( 16 )
			),
			'fa-tumblr-square'                       => array(
				'label'    => 'Tumblr Square',
				'category' => array( 16 )
			),
			'fa-twitch'                              => array(
				'label'    => 'Twitch',
				'category' => array( 16 )
			),
			'fa-twitter'                             => array(
				'label'    => 'Twitter',
				'category' => array( 16 )
			),
			'fa-twitter-square'                      => array(
				'label'    => 'Twitter Square',
				'category' => array( 16 )
			),
			'fa-usb'                                 => array(
				'label'    => 'Usb',
				'category' => array( 16 )
			),
			'fa-viacoin'                             => array(
				'label'    => 'Viacoin',
				'category' => array( 16 )
			),
			'fa-viadeo'                              => array(
				'label'    => 'Viadeo',
				'category' => array( 16 )
			),
			'fa-viadeo-square'                       => array(
				'label'    => 'Viadeo Square',
				'category' => array( 16 )
			),
			'fa-vimeo'                               => array(
				'label'    => 'Vimeo',
				'category' => array( 16 )
			),
			'fa-vimeo-square'                        => array(
				'label'    => 'Vimeo Square',
				'category' => array( 16 )
			),
			'fa-vine'                                => array(
				'label'    => 'Vine',
				'category' => array( 16 )
			),
			'fa-vk'                                  => array(
				'label'    => 'Vk',
				'category' => array( 16 )
			),
			'fa-wechat'                              => array(
				'label'    => 'Wechat',
				'category' => array( 16 )
			),
			'fa-weibo'                               => array(
				'label'    => 'Weibo',
				'category' => array( 16 )
			),
			'fa-weixin'                              => array(
				'label'    => 'Weixin',
				'category' => array( 16 )
			),
			'fa-whatsapp'                            => array(
				'label'    => 'Whatsapp',
				'category' => array( 16 )
			),
			'fa-wikipedia-w'                         => array(
				'label'    => 'Wikipedia W',
				'category' => array( 16 )
			),
			'fa-windows'                             => array(
				'label'    => 'Windows',
				'category' => array( 16 )
			),
			'fa-wordpress'                           => array(
				'label'    => 'Wordpress',
				'category' => array( 16 )
			),
			'fa-wpbeginner'                          => array(
				'label'    => 'Wpbeginner',
				'category' => array( 16 )
			),
			'fa-wpforms'                             => array(
				'label'    => 'Wpforms',
				'category' => array( 16 )
			),
			'fa-xing'                                => array(
				'label'    => 'Xing',
				'category' => array( 16 )
			),
			'fa-xing-square'                         => array(
				'label'    => 'Xing Square',
				'category' => array( 16 )
			),
			'fa-y-combinator'                        => array(
				'label'    => 'Y Combinator',
				'category' => array( 16 )
			),
			'fa-y-combinator-square'                 => array(
				'label'    => 'Y Combinator Square',
				'category' => array( 16 )
			),
			'fa-yahoo'                               => array(
				'label'    => 'Yahoo',
				'category' => array( 16 )
			),
			'fa-yc'                                  => array(
				'label'    => 'Yc',
				'category' => array( 16 )
			),
			'fa-yc-square'                           => array(
				'label'    => 'Yc Square',
				'category' => array( 16 )
			),
			'fa-yelp'                                => array(
				'label'    => 'Yelp',
				'category' => array( 16 )
			),
			'fa-yoast'                               => array(
				'label'    => 'Yoast',
				'category' => array( 16 )
			),
			'fa-youtube'                             => array(
				'label'    => 'Youtube',
				'category' => array( 16 )
			),
			'fa-youtube-square'                      => array(
				'label'    => 'Youtube Square',
				'category' => array( 16 )
			),
			'fa-h-square'                            => array(
				'label'    => 'H Square',
				'category' => array( 17 )
			),
			'fa-hospital-o'                          => array(
				'label'    => 'Hospital <span class="text-muted">(Outline)</span>',
				'category' => array( 17 )
			),
			'fa-medkit'                              => array(
				'label'    => 'Medkit',
				'category' => array( 17 )
			),
			'fa-stethoscope'                         => array(
				'label'    => 'Stethoscope',
				'category' => array( 17 )
			),
			'fa-user-md'                             => array(
				'label'    => 'User Md',
				'category' => array( 17 )
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

		$classes = apply_filters( 'better_fontawesome_icons_classes', $classes );

		if ( ! isset( $this->icons[ $icon_key ] ) ) {
			return '';
		}

		return '<i class="bf-icon fa ' . $icon_key . ' ' . $classes . '"></i>';

	}
}
