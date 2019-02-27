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


/**
 * Handle Base Custom CSS Functionality in BetterFramework
 */
class BF_Custom_CSS {

	/**
	 * Contain all css's that must be generated
	 *
	 * @var array
	 */
	protected $fields = array();


	/**
	 * Contain final css that rendered.
	 *
	 * @var string
	 */
	protected $final_css = '';


	/**
	 * Contain Fonts That Must Be Import In Top Of CSS
	 *
	 * @var array
	 */
	protected $fonts = array();


	/**
	 * Used For Adding New Font To Fonts Queue
	 *
	 * @param string $family
	 * @param string $variants
	 * @param string $subsets
	 */
	public function set_fonts( $family = '', $variants = '', $subsets = '' ) {


		// If Font Currently is in Queue Then Add New Variant Or Subset
		if ( isset( $this->fonts[ $family ] ) ) {

			if ( ! in_array( $variants, $this->fonts[ $family ]['variants'] ) ) {
				$this->fonts[ $family ]['variants'][] = $variants;
			}

			if ( ! in_array( $subsets, $this->fonts[ $family ]['subsets'] ) ) {
				$this->fonts[ $family ]['subsets'][] = $subsets;
			}

		} // Add New Font to Queue
		else {

			$this->fonts[ $family ] = array(
				'variants' => array( $variants ),
				'subsets'  => array( $subsets ),
			);

		}

	}


	/**
	 * Used For Generating Fonts
	 *
	 * @param string $type
	 *
	 * @param string $protocol custom protocol
	 *
	 * @return array|string
	 */
	public function render_fonts( $type = 'google-fonts', $protocol = 'default' ) {

		if ( ! count( $this->fonts ) ) {
			return '';
		}

		$output = ''; // Final Out Put CSS

		$out_fonts = array(); // Array of Fonts, Each inner element separately

		// Collect all fonts in one url for better performance
		if ( $type == 'google-fonts' ) {
			$out_fonts['main'] = array();
		}

		// Create Each Font CSS
		foreach ( $this->fonts as $font_id => $font_information ) {

			//
			// Google Font
			//
			if ( $type == 'google-fonts' ) {

				$_font_have_subset = FALSE;

				$font_data = Better_Framework::fonts_manager()->google_fonts()->get_font( $font_id );

				if ( $font_data == FALSE ) {
					continue;
				} // font id is not valid google font

				$_font = str_replace( ' ', '+', $font_id );

				if ( in_array( 'italic', $font_information['variants'] ) ) {
					unset( $font_information['variants'][ array_search( 'italic', $font_information['variants'] ) ] );
					$font_information['variants'][] = '400italic';
				}

				if ( implode( ',', $font_information['variants'] ) != '' ) {
					$_font .= ':' . implode( ',', $font_information['variants'] );
				}

				// Remove Latin Subset because default subset is latin!
				// and if font have other subset then we make separate @import.
				foreach ( $font_information['subsets'] as $key => $value ) {
					if ( $value == 'latin' ) {
						unset( $font_information['subsets'][ $key ] );
					}
				}

				if ( implode( ',', $font_information['subsets'] ) != '' ) {
					$_font_have_subset = TRUE;
					$_font .= '&subset=' . implode( ',', $font_information['subsets'] );
				}

				// no subset
				if ( ! $_font_have_subset ) {
					array_push( $out_fonts['main'], $_font );
				} else {
					$out_fonts[][] = $_font;
				}
			}

			//
			// Custom Font
			//
			elseif ( $type == 'custom-fonts' || $type == 'theme-fonts' ) {

				if ( $type == 'custom-fonts' ) {
					$font_data = Better_Framework::fonts_manager()->custom_fonts()->get_font( $font_id );
				} else {
					$font_data = Better_Framework::fonts_manager()->theme_fonts()->get_font( $font_id );
				}

				if ( $font_data === FALSE ) {
					continue;
				} // font id is not valid or removed

				$main_src_printed = FALSE;

				$custom_output = '';

				$custom_output .= "
@font-face {
    font-family: '" . $font_id . "';";

				// .EOT
				if ( ! empty( $font_data['eot'] ) ) {

					$custom_output .= "
    src: url('" . $font_data['eot'] . "'); /* IE9 Compat Modes */
    src: url('" . $font_data['eot'] . "?#iefix') format('embedded-opentype') /* IE6-IE8 */";

					$main_src_printed = TRUE;

				}

				// .WOFF
				if ( ! empty( $font_data['woff'] ) ) {

					if ( $main_src_printed ) {

						$custom_output .= "
    , url('" . $font_data['woff'] . "') format('woff') /* Pretty Modern Browsers */";

					} else {

						$main_src_printed = TRUE;

						$custom_output .= "
    src: url('" . $font_data['woff'] . "') format('woff') /* Pretty Modern Browsers */";

					}
				}


				// .TTF
				if ( ! empty( $font_data['ttf'] ) ) {

					if ( $main_src_printed ) {

						$custom_output .= "
    , url('" . $font_data['ttf'] . "') format('truetype') /* Safari, Android, iOS */";

					} else {

						$main_src_printed = TRUE;

						$custom_output .= "
    src: url('" . $font_data['ttf'] . "') format('truetype') /* Safari, Android, iOS */";

					}
				}

				// .SVG
				if ( ! empty( $font_data['svg'] ) ) {

					if ( $main_src_printed ) {

						$custom_output .= "
    , url('" . $font_data['svg'] . "#" . $font_id . "') format('svg') /* Legacy iOS */";

					} else {

						$custom_output .= "
    src: url('" . $font_data['svg'] . "#" . $font_id . "') format('svg') /* Legacy iOS */";


					}
				}

				$custom_output .= ";
    font-weight: normal;
    font-style: normal;
}";

				$out_fonts[] = $custom_output;

			} // Google EA Fonts
			elseif ( $type == 'google-ea-fonts' ) {

				$font_data = Better_Framework::fonts_manager()->google_ea_fonts()->get_font( $font_id );

				if ( $font_data === FALSE ) {
					continue;
				} // font id is not valid or removed

				$out_fonts[] = $font_data['url'];
			}
		}


		//
		// Google Fonts final array of links
		//
		if ( $type == 'google-fonts' ) {

			$final_fonts = array();
			foreach ( $out_fonts as $key => $out_font ) {
				if ( count( $out_font ) > 0 ) {
					$final_fonts[] = Better_Framework::fonts_manager()->get_protocol( $protocol ) . 'fonts.googleapis.com/css?family=' . implode( '%7C', $out_font );
				}
			}

			return $final_fonts;
		}

		//
		// Google EA Fonts final array of links
		//
		if ( $type == 'google-ea-fonts' ) {
			return $out_fonts;
		}

		//
		// Custom Fonts final string of font-face
		//
		elseif ( $type == 'custom-fonts' || $type == 'theme-fonts' ) {

			foreach ( $out_fonts as $out_font ) {
				$output .= $out_font;
			}

			if ( ! empty( $output ) ) {
				$output .= "\n";
			}
		}

		return $output;
	}


	/**
	 * Add new line to active fields
	 */
	private function add_new_line() {

		$this->fields[] = array( 'newline' => TRUE );

	}


	/**
	 * Render a block array to css code
	 *
	 * @param   array  $block
	 * @param   string $value
	 * @param   bool   $add_to_final
	 *
	 * @return string
	 */
	private function render_block( $block, $value = '', $add_to_final = TRUE ) {
		$output = '';

		$after_value = '';

		$after_block = '';

		// Uncompressed in dev mode
		if ( bf_is( 'dev' ) ) {
			$ln_char  = "\n";
			$tab_char = "\t";
		} else {
			$ln_char  = "";
			$tab_char = "";
		}

		if ( isset( $block['newline'] ) ) {
			$output .= "\r\n";
		}

		if ( isset( $block['comment'] ) || ! empty( $block['comment'] ) ) {
			$output .= '/* ' . $block['comment'] . ' */' . "\r\n";
		}


		// Filters
		if ( isset( $block['filter'] ) ) {

			//
			// Last versions compatibility
			//
			if ( ( $index = array_search( 'woocommerce', $block['filter'] ) ) !== FALSE ) {
				$block['filter'][ $index ] = array(
					'type'      => 'function',
					'condition' => 'is_woocommerce',
				);
			}
			if ( ( $index = array_search( 'bbpress', $block['filter'] ) ) !== FALSE ) {
				$block['filter'][ $index ] = array(
					'type'      => 'class',
					'condition' => 'bbpress',
				);
			}
			if ( ( $index = array_search( 'buddypress', $block['filter'] ) ) !== FALSE ) {
				$block['filter'][ $index ] = array(
					'type'      => 'function',
					'condition' => 'bp_is_active',
				);
			}

			if ( ( $index = array_search( 'wpml', $block['filter'] ) ) !== FALSE ) {
				$block['filter'][ $index ] = array(
					'type'      => 'constantn',
					'condition' => 'ICL_SITEPRESS_VERSIOe',
				);
			}
			//
			// /End Last versions compatibility
			//
			foreach ( $block['filter'] as $filter ) {
				// should be array
				if ( ! is_array( $filter ) ) {
					continue;
				}

				switch ( $filter['type'] ) {

					case 'function':
						if ( ! function_exists( $filter['condition'] ) ) {
							return;
						}
						break;

					case 'class':
						if ( ! class_exists( $filter['condition'] ) ) {
							return;
						}
						break;

					case 'constant':
						if ( ! defined( $filter['condition'] ) ) {
							return;
						}
						break;

				}

			}

		}

		// Before than css code. For example used for adding media queries!.
		if ( isset( $block['before'] ) ) {
			$output .= str_replace( '%%value%%', $value, $block['before'] ) . $ln_char;
		}

		// Prepare Selectors.
		if ( isset( $block['selector'] ) ) {
			if ( ! is_array( $block['selector'] ) ) {
				$output .= $block['selector'] . '{' . $ln_char;
			} else {
				$output .= implode( ',' . $ln_char, $block['selector'] ) . '{' . $ln_char;
			}
		}

		// Prepare Value For Font Field
		if ( isset( $block['type'] ) && $block['type'] == 'font' ) {

			// If font is not enable then don't echo css
			if ( isset( $value['enable'] ) && ! $value['enable'] ) {
				return '';
			}

			if ( isset( $block['exclude'] ) ) {
				foreach ( (array) $block['exclude'] as $exclude ) {
					unset( $value[ $exclude ] );
				}
			}

			$font_stacks = Better_Framework::fonts_manager()->font_stacks()->get_font( $value['family'] );

			if ( $font_stacks ) {
				$output .= $tab_char . 'font-family:' . $font_stacks['stack'] . ';' . $ln_char;
			} else {
				$output .= $tab_char . 'font-family:\'' . $value['family'] . '\';' . $ln_char;
			}

			// new api fix
			if ( $value['variant'] == 'regular' ) {
				$value['variant'] = '400';
			} elseif ( $value['variant'] == 'italic' ) {
				$value['variant'] = '400italic';
			}

			if ( preg_match( '/\d{3}\w./i', $value['variant'] ) ) {
				$pretty_variant = preg_replace( '/(\d{3})/i', '${1} ', $value['variant'] );
				$pretty_variant = explode( ' ', $pretty_variant );
			} else {
				$pretty_variant[] = $value['variant'];
			}

			if ( isset( $pretty_variant[0] ) ) {
				$output .= $tab_char . 'font-weight:' . $pretty_variant[0] . ';' . $ln_char;
			}

			if ( isset( $pretty_variant[1] ) ) {
				$output .= $tab_char . 'font-style:' . $pretty_variant[1] . ';' . $ln_char;
			}


			$line_height_id = 'line-height';

			if ( isset( $value['line_height'] ) ) {
				$line_height_id = 'line_height';
			} // older versions compatibility

			if ( isset( $value[ $line_height_id ] ) && ! empty( $value[ $line_height_id ] ) ) {
				$output .= $tab_char . 'line-height:' . $value[ $line_height_id ] . 'px;' . $ln_char;
			}

			if ( isset( $value['size'] ) ) {
				$output .= $tab_char . 'font-size:' . $value['size'] . 'px;' . $ln_char;
			}

			if ( isset( $value['align'] ) ) {
				$output .= $tab_char . 'text-align:' . $value['align'] . ';' . $ln_char;
			}

			if ( isset( $value['transform'] ) ) {
				$output .= $tab_char . 'text-transform:' . $value['transform'] . ';' . $ln_char;
			}

			if ( isset( $value['color'] ) ) {
				$output .= $tab_char . 'color:' . $value['color'] . ';' . $ln_char;
			}

			if ( ! empty( $value['letter-spacing'] ) ) {
				$output .= $tab_char . 'letter-spacing:' . $value['letter-spacing'] . ';' . $ln_char;
			}

			// Add Font To Fonts Queue
			$this->set_fonts( $value['family'], $value['variant'], $value['subset'] );
		}

		// prepare value for "background-image" type
		if ( isset( $block['type'] ) && $block['type'] == 'background-image' ) {

			if ( empty( $value ) || empty( $value['img'] ) ) {
				return '';
			}

			// Full Cover Image
			if ( $value['type'] == 'cover' ) {
				$after_value .= $tab_char . 'background-repeat: no-repeat;background-position: center center; -webkit-background-size: cover; -moz-background-size: cover;-o-background-size: cover; background-size: cover;'
				                . 'filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' . $value['img'] . '\', sizingMethod=\'scale\');
-ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' . $value['img'] . '\', sizingMethod=\'scale\')";'
				                . $ln_char;

				$value = 'url(' . $value['img'] . ')';
			} // Fit Cover
			elseif ( $value['type'] == 'fit-cover' ) {
				$after_value .= $tab_char . 'background-repeat: no-repeat;background-position: center center; -webkit-background-size: contain; -moz-background-size: contain;-o-background-size: contain; background-size: contain;'
				                . 'filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' . $value['img'] . '\', sizingMethod=\'scale\');
-ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' . $value['img'] . '\', sizingMethod=\'scale\')";'
				                . $ln_char;

				$value = 'url(' . $value['img'] . ')';
			} // Parallax Image
			elseif ( $value['type'] == 'parallax' ) {
				$after_value .= $tab_char . 'background-repeat: no-repeat;background-attachment: fixed; background-position: center center; -webkit-background-size: cover; -moz-background-size: cover;-o-background-size: cover; background-size: cover;'
				                . 'filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' . $value['img'] . '\', sizingMethod=\'scale\');
-ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' . $value['img'] . '\', sizingMethod=\'scale\')";'
				                . $ln_char;

				$value = 'url(' . $value['img'] . ')';
			} else {
				switch ( $value['type'] ) {

					case 'repeat':
					case 'cover':
					case 'repeat-y':
					case 'repeat-x':
						$after_value .= $tab_char . 'background-repeat:' . $value['type'] . ';' . $ln_char;
						break;

					case 'top-left':
						$after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
						$after_value .= $tab_char . 'background-position: top left;' . $ln_char;
						break;

					case 'top-center':
						$after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
						$after_value .= $tab_char . 'background-position: top center;' . $ln_char;
						break;

					case 'top-right':
						$after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
						$after_value .= $tab_char . 'background-position: top right;' . $ln_char;
						break;

					case 'left-center':
						$after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
						$after_value .= $tab_char . 'background-position: left center;' . $ln_char;
						break;

					case 'center-center':
						$after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
						$after_value .= $tab_char . 'background-position: center center;' . $ln_char;
						break;

					case 'right-center':
						$after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
						$after_value .= $tab_char . 'background-position: right center;' . $ln_char;
						break;

					case 'bottom-left':
						$after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
						$after_value .= $tab_char . 'background-position: bottom left;' . $ln_char;
						break;

					case 'bottom-center':
						$after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
						$after_value .= $tab_char . 'background-position: bottom center;' . $ln_char;
						break;

					case 'bottom-right':
						$after_value .= $tab_char . 'background-repeat: no-repeat;' . $ln_char;
						$after_value .= $tab_char . 'background-position: bottom right;' . $ln_char;
						break;

				}
				$value = 'url(' . $value['img'] . ')';
			}

		}

		// prepare value for "color" type
		if ( isset( $block['type'] ) && $block['type'] == 'color' ) {
			if ( preg_match( '/%%value([-|+]\d*)%%/', $block['value'], $change ) ) {
				Better_Framework::factory( 'color' );
				$value = preg_replace( '/(%%value[-|+]\d*%%)/', BF_Color::change_color( $value, intval( $change[1] ) ), $block['value'] );
			} elseif ( preg_match( '/%%value-opacity-(.*)%%/', $block['value'], $opacity ) ) {
				Better_Framework::factory( 'color' );
				$value = preg_replace( '/(%%value-opacity-.*%%)/', BF_Color::hex_to_rgba( $value, $opacity[1] ), $block['value'] );
			}
		}

		// prepare value for "border" type
		if ( isset( $block['type'] ) && $block['type'] == 'border' ) {

			if ( isset( $value['all'] ) ) {

				$output .= $tab_char . 'border:';

				if ( isset( $value['all']['width'] ) ) {
					$output .= $value['all']['width'] . 'px ';
				}
				if ( isset( $value['all']['style'] ) ) {
					$output .= $value['all']['style'] . ' ';
				}
				if ( isset( $value['all']['color'] ) ) {
					$output .= $value['all']['color'] . ' ';
				}

				$output .= ';' . $ln_char;

			} else {

				if ( isset( $value['top'] ) ) {

					$output .= $tab_char . 'border-top:';

					if ( isset( $value['top']['width'] ) ) {
						$output .= $value['top']['width'] . 'px ';
					}
					if ( isset( $value['top']['style'] ) ) {
						$output .= $value['top']['style'] . ' ';
					}
					if ( isset( $value['top']['color'] ) ) {
						$output .= $value['top']['color'] . ' ';
					}

					$output .= ';' . $ln_char;

				}

				if ( isset( $value['right'] ) ) {

					$output .= $tab_char . 'border-right:';

					if ( isset( $value['right']['width'] ) ) {
						$output .= $value['right']['width'] . 'px ';
					}
					if ( isset( $value['right']['style'] ) ) {
						$output .= $value['right']['style'] . ' ';
					}
					if ( isset( $value['right']['color'] ) ) {
						$output .= $value['right']['color'] . ' ';
					}

					$output .= ';' . $ln_char;

				}
				if ( isset( $value['bottom'] ) ) {

					$output .= $tab_char . 'border-bottom:';

					if ( isset( $value['bottom']['width'] ) ) {
						$output .= $value['bottom']['width'] . 'px ';
					}
					if ( isset( $value['bottom']['style'] ) ) {
						$output .= $value['bottom']['style'] . ' ';
					}
					if ( isset( $value['bottom']['color'] ) ) {
						$output .= $value['bottom']['color'] . ' ';
					}

					$output .= ';' . $ln_char;

				}

				if ( isset( $value['left'] ) ) {

					$output .= $tab_char . 'border-left:';

					if ( isset( $value['left']['width'] ) ) {
						$output .= $value['left']['width'] . 'px ';
					}
					if ( isset( $value['left']['style'] ) ) {
						$output .= $value['left']['style'] . ' ';
					}
					if ( isset( $value['left']['color'] ) ) {
						$output .= $value['left']['color'] . ' ';
					}

					$output .= ';' . $ln_char;

				}

			}

		}

		// Prepare Properties
		if ( isset( $block['prop'] ) ) {

			foreach ( (array) $block['prop'] as $key => $val ) {

				// Customized value template for property
				if ( strpos( $val, '%%value%%' ) !== FALSE ) {

					$output .= $tab_char . $key . ':';
					$output .= str_replace( '%%value%%', $value, $val ) . ';' . $ln_char;

				} // Simply set value to property
				else {

					if ( ! is_int( $key ) ) {

						$output .= $tab_char . $key . ':' . $val . ';' . $ln_char;

					} else {

						$output .= $tab_char . $val . ':' . $value . ';' . $ln_char;

					}

				}
			}

		}

		// add after value
		if ( isset( $after_value ) && $after_value != '' ) {
			$output .= $after_value;
		}

		// Remove last ';'
		$output = rtrim( $output, ';' );

		if ( isset( $block['selector'] ) ) {
			$output .= "}" . $ln_char;
		}

		// After css code. For example used for adding media queries!.
		if ( isset( $block['after'] ) ) {
			$output .= str_replace( '%%value%%', $value, $block['after'] ) . $ln_char;
		}

		if ( $add_to_final ) {
			$this->final_css .= $output;
		}

		return $output;
	}


	/**
	 * Render all fields css
	 *
	 * @return string
	 */
	function render_css() {

		foreach ( (array) $this->fields as $field ) {

			// new line field
			if ( isset( $field['newline'] ) ) {
				$this->render_block( $field, '' );
				continue;
			}

			// continue when value in empty
			if ( ! isset( $field['value'] ) && empty( $field['value'] ) ) {
				continue;
			}

			$value = $field['value'];

			unset( $field['value'] );

			// Custom callbacks for generating CSS
			if ( isset( $field['callback'] ) && is_callable( $field['callback'] ) ) {
				call_user_func_array( $field['callback'], array( &$field, &$value ) );
			}

			foreach ( (array) $field as $block ) {
				if ( is_array( $block ) ) {
					$this->render_block( $block, $value );
				}
			}
		}

		return $this->final_css;
	}


	/**
	 * display css
	 */
	function display() {

		status_header( 200 );
		header( "Content-type: text/css; charset: utf-8" );

		$this->load_all_fields();

		$final_css = $this->render_css();

		echo $this->render_fonts(); // escaped before in generating

		echo $final_css; // escaped before in generating

	}


	/**
	 * Returns current css field id that integrated with style system
	 *
	 * @param   string $panel_id
	 *
	 * @return  string
	 */
	function get_css_id( $panel_id ) {

		// If panel haven't style feature
		if ( ! isset( BF_Options::$panels[ $panel_id ]['style'] ) ) {
			return 'css';
		}

		$style = get_option( $panel_id . '_current_style' );

		if ( $style == 'default' ) {
			return 'css';
		} else {
			return 'css-' . $style;
		}

	}
}