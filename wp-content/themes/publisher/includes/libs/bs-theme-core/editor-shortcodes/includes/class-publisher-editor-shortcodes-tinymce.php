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


/**
 * Handles admin functionality of shortcodes
 */
class Publisher_Editor_Shortcodes_TinyMCE {

	function __construct() {

		if ( ! current_user_can( 'edit_pages' ) && ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$shortcodes = Publisher_Theme_Editor_Shortcodes::get_shortcodes();

		// Check if WYSIWYG is enabled
		if ( 'true' == get_user_option( 'rich_editing' ) && ! empty( $shortcodes ) ) {

			add_filter( 'mce_buttons', array( $this, 'editor_button' ) );

			add_filter( 'mce_external_plugins', array( $this, 'editor_plugin' ) );

			add_action( 'wp_ajax_betterstudio_editor_shortcode_plugin', array( $this, 'render_plugin_js' ) );

		}

		add_action( 'admin_enqueue_scripts', array( $this, 'editor_static_files' ) );
		add_action( 'admin_print_styles', array( $this, 'enqueue_dynamic_css' ) );
	}


	/**
	 * Filter Callback: Adds style
	 */
	public function editor_static_files() {

		wp_enqueue_script( 'bs-shortcode-editor-dep', Publisher_Theme_Editor_Shortcodes::url( 'assets/js/editor-scripts.js' ) );
		wp_enqueue_style( 'betterstudio-editor-shortcodes', Publisher_Theme_Editor_Shortcodes::url( 'assets/css/bs-shortcodes-editor.css' ) );

	}


	public function enqueue_dynamic_css() {
		?>
		<style type="text/css">
			i.mce-ico.mce-i-betterstudio_shortcodes:before {
				content: '\e<?php echo Publisher_Theme_Editor_Shortcodes::Run()->get_config( 'icon', '000' ); ?>' !important;
				color: <?php echo Publisher_Theme_Editor_Shortcodes::Run()->get_config( 'icon-color', '#3272a0' );?> !important;
			}
		</style>
		<?php
	}

	/**
	 * Filter Callback: Adds shortcode list button to TinyMCE
	 *
	 * @param array $buttons
	 *
	 * @return array
	 */
	public function editor_button( $buttons ) {

		array_unshift( $buttons, 'betterstudio_shortcodes', 'separator' );

		return $buttons;
	}


	/**
	 * Filter Callback: Registers js file for shortcode button
	 *
	 * @param $plugin_array
	 *
	 * @return array
	 */
	public function editor_plugin( $plugin_array ) {

		$plugin_array['betterstudio_shortcodes'] = admin_url( 'admin-ajax.php' ) . '?action=betterstudio_editor_shortcode_plugin';

		return $plugin_array;
	}


	/**
	 * Render item and all nested items ( unlimited child )
	 *
	 * @param      $item_key
	 * @param      $item
	 * @param bool $echo
	 *
	 * @return string
	 */
	public function render_item( $item_key, $item, $echo = TRUE ) {

		$output = '';

		// Renders simple buttons
		if ( isset( $item['type'] ) && $item['type'] == 'button' ) {

			$output .= $this->render_single_button( $item_key, $item, FALSE );

		}
		// Renders Separator
		if ( isset( $item['type'] ) && $item['type'] == 'separator' ) {

			$output .= $this->render_separator( FALSE );

		} // Renders drop down menu items
		elseif ( isset( $item['type'] ) && $item['type'] == 'menu' ) {

			if ( isset( $item['items'] ) ) {

				$output .= $this->render_menu( $item_key, $item, FALSE );

			}

		}

		if ( $echo ) {
			echo $output; // escaped before
		} else {
			return $output;
		}

	}


	/**
	 * Renders Separator
	 *
	 * @param bool $echo
	 *
	 * @return string
	 */
	public function render_separator( $echo = TRUE ) {

		$output = "{
                    text: 'separator',";

		if ( isset( $item['classes'] ) ) {
			$output .= "classes: '" . $item['classes'] . ' ' . "bs-separator',";
		} else {
			$output .= "classes: 'bs-separator',";
		}

		$output .= "},";

		if ( $echo ) {
			echo $output; // escaped before
		} else {
			return $output;
		}

	}


	/**
	 * Renders menu element
	 *
	 * @param      $item_key
	 * @param      $item
	 * @param bool $echo
	 *
	 * @return string
	 */
	public function render_menu( $item_key, $item, $echo = TRUE ) {

		$output = "{
                    text: '" . $item['label'] . "',";

		if ( isset( $item['classes'] ) ) {
			$output .= "classes: '" . $item['classes'] . ' ' . $item_key . "',";
		} else {
			$output .= "classes: '" . $item_key . "',";
		}

		if ( isset( $item['icon'] ) ) {
			$output .= "icon: '" . $item['icon'] . "',";
		}

		$output .= ' onshow: onShow, ';
		$output .= "menu: [";

		foreach ( (array) $item['items'] as $_item_key => $_item_value ) {
			$output .= $this->render_item( $_item_key, $_item_value, FALSE );
		}

		$output .= "]},";

		if ( $echo ) {
			echo $output; // escaped before
		} else {
			return $output;
		}
	}


	/**
	 * Used for rendering single button
	 *
	 * @param      $item_key
	 * @param      $item
	 * @param bool $echo
	 *
	 * @return string
	 */
	public function render_single_button( $item_key, $item, $echo = TRUE ) {

		$output = "
            {
                text: '" . $item['label'] . "',";

		if ( isset( $item['classes'] ) ) {
			$output .= "classes: '" . $item['classes'] . ' ' . $item_key . "',";
		} else {
			$output .= "classes: '" . $item_key . "',";
		}

		if ( isset( $item['icon'] ) ) {
			$output .= "icon: '" . $item['icon'] . "',";
		}

		$have_command = FALSE;
		if ( ! empty( $item['formatter'] ) ) {
			$have_command = TRUE;
			$output .= "
                command: '" . $item['formatter'] . "',
                onPostRender: PostRenderEvent,
			";
		} else if ( ! empty( $item['command'] ) ) {
			$have_command = TRUE;
			$output .= "
                command: '" . $item['command'] . "',
                onPostRender: PostRenderEvent,
			";
		}

		if ( ! empty( $item['active_conditions'] ) ) {
			$output .= '
            onPostRender: PostRenderEvent,
			activeConditions: ' . json_encode( $item['active_conditions'] );
			$output .= ',
			';
		}

		if ( ! $have_command ) {
			$output .= '
			command: "' . $item_key . '-active",
		';
		}
		$output .= 'onclick: function() {
			';

		$append_rawjs_event = FALSE;
		if ( ! empty( $item['formatter'] ) ) {
			$output .= 'formatterClickEvent.call(this);
			';
		} else if ( ! empty( $item['command'] ) ) {
			$output .= 'commandClickEvent.call(this);
			';
		} else {
			$append_rawjs_event = TRUE;
			$output .= 'rawJsBeforeClickEvent.call(this);
			';
		}

		if ( ! empty( $item['onclick_raw_js'] ) ) {
			$output .= $item['onclick_raw_js'];
		}

		if ( ! empty( $item['wrap_before'] ) && ! empty( $item['wrap_after'] ) ) {
			$output .= "
                    var content = editor.selection.getContent({'format':'html'});
                    editor.insertContent( '" . $item['wrap_before'] . "' + content + '" . $item['wrap_after'] . "' );
                ";
		} else if ( ! empty( $item['content'] ) ) {
			$output .= "editor.insertContent('" . $item['content'] . "');";
		}
		if ( $append_rawjs_event ) {
			$output .= 'rawJsAfterClickEvent.call(this);
			';

		}

		$output .= "
                }
            },
        ";

		if ( $echo ) {
			echo $output; // escaped before
		} else {
			return $output;
		}

	}


	protected function _js_functions() {
		echo '
        var bs = new BetterStudio_ShortCodes();

        function PostRenderEvent() {
            bs.BS_PostRenderEvent(this);
        }

        function commandClickEvent() {
            bs.BS_CommandClickEvent(this);
        }

        function rawJsBeforeClickEvent() {
            bs.BS_RawJsBeforeClickEvent(this);
        }
        function rawJsAfterClickEvent() {
            bs.BS_RawJsAfterClickEvent(this);
        }

        function formatterClickEvent() {
            bs.BS_FormatterClickEvent(this);
        }

        function onShow() {
            bs.BS_TriggerSubMenu(this.settings.menu);
        }

        function move_caret_first_col(editor) {
            bs.columnMoveCaretFirst(editor, "bs-shortcode-row");
        }

        function toggleClass(classes, removeClassPattern,node) {
            bs.toggleClass(classes, removeClassPattern,node);
        }

		function newButton(btnType) {
            bs.insertButton(btnType);
		}
		var textPaddingPattern = /^bs\-padding\-\d+\-\d+$/,
			introClassPattern  = /\bbs\-intro\-?.*\b/;
		';
	}

	/**
	 * Renders editor plugin js
	 *
	 * TODO Add support versions before 3.9
	 */
	public function render_plugin_js() {

		// Check auth
		if ( ! is_user_logged_in() || ! current_user_can( 'edit_posts' ) ) {
			die( esc_html( __( 'You do not have the right type of authorization. You must be logged in and be able to edit pages and posts.', 'publisher' ) ) );
		}

		// javascript will be output
		header( 'Content-type: application/x-javascript' );

		echo "(function() {\n";
		$this->_js_functions();

		echo "        tinymce.PluginManager.add( 'betterstudio_shortcodes', function( editor, url ) {
                    editor.addButton( 'betterstudio_shortcodes', {
                        text: '" . Publisher_Theme_Editor_Shortcodes::Run()->get_config( 'name', __( 'Shortcodes', 'publisher' ) ) . "',
                        icon: 'betterstudio_shortcodes',
                        type: 'menubutton',

                        menu: [";

		foreach ( (array) Publisher_Theme_Editor_Shortcodes::get_shortcodes() as $item_key => $item_value ) {
			echo $this->render_item( $item_key, $item_value, FALSE ); // escaped before inside generator
		}

		echo "
                    ]

                    });
                });";
		echo "\n    })();";

		die(); // end ajax request

	}
}
