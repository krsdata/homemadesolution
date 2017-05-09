<?php
/*
 * @copyright 2005-2017 Vishal Monpara
 * Plugin Name: PramukhIME Indic
 * Plugin URI: http://www.vishalon.net/pramukhime/wordpress-plugin
 * Version: 4.0.0
 * Description: Easily type in your favourite Indian language with "The way you speak, the way you type" rule with this plugin. Supported Languages: Assamese, Bengali, Bodo, Dogri, Gujarati, Hindi, Kannada, Kashmiri, Konkani, Maithili, Malayalam, Manipuri, Meitei (Manipuri), Marathi, Marathi(Modi) Nepali, Odia, Punjabi, Sanskrit, Santali (Ol Chiki), Sindhi, Sora, Tamil and Telugu
 * Author: Vishal Monpara
 * Author URI: http://www.vishalon.net
 * License: Split License. Read readme.html for more details
 */

// If this file is called directly, abort. 
if ( ! defined( 'WPINC' ) ) {
	die;
}

if (!class_exists('PramukhIME')) 
{
	class PramukhIME
	{
		var $plugin_version = "4.0.0";
		var $settings = array();
		var $defaultSettings;
		var $mce_enabled = false;
		var $page_enabled = false;
		var $plugin_settings_id = '';
		var $default_lang = '';
		var $toggle_key_json = '';
		var $langs = array();
		function PramukhIME()
    	{
			// E = Enabled, T = Text (=title), V = Value
			$this->defaultSettings = array('language_list' => array(
						array("E" => 1, "T" => "English", "V" => "English"),
						array("E" => 1, "T" => "Assamese", "V" => "Assamese"),
						array("E" => 1, "T" => "Bengali", "V" => "Bengali"),
						array("E" => 1, "T" => "Bodo", "V" => "Bodo"),
						array("E" => 1, "T" => "Dogri", "V" => "Dogri"),
						array("E" => 1, "T" => "Gujarati", "V" => "Gujarati"),
						array("E" => 1, "T" => "Hindi", "V" => "Hindi"),
						array("E" => 1, "T" => "Kannada", "V" => "Kannada"),
						array("E" => 1, "T" => "Kashmiri", "V" => "Kashmiri"),
						array("E" => 1, "T" => "Konkani", "V" => "Konkani"),
						array("E" => 1, "T" => "Maithili", "V" => "Maithili"),
						array("E" => 1, "T" => "Malayalam", "V" => "Malayalam"),
						array("E" => 1, "T" => "Manipuri", "V" => "Manipuri"),
						array("E" => 1, "T" => "Marathi", "V" => "Marathi"),
						array("E" => 1, "T" => "Marathi (Modi)", "V" => "MarathiModi"),
						array("E" => 1, "T" => "Meitei (Manipuri)", "V" => "Meitei"),
						array("E" => 1, "T" => "Nepali", "V" => "Nepali"),
						array("E" => 1, "T" => "Odia", "V" => "Odia"),
						array("E" => 1, "T" => "Punjabi", "V" => "Punjabi"),
						array("E" => 1, "T" => "Sanskrit", "V" => "Sanskrit"),
						array("E" => 1, "T" => "Santali (Ol Chiki)", "V" => "Santali"),
						array("E" => 1, "T" => "Sindhi", "V" => "Sindhi"),
						array("E" => 1, "T" => "Sora", "V" => "Sora"),
						array("E" => 1, "T" => "Tamil", "V" => "Tamil"),
						array("E" => 1, "T" => "Telugu", "V" => "Telugu")
					),
					'visual_editor_enable_pramukhime' => 1,
					'visitor_enable_pramukhime' => 1,
					'dashboard_enable_pramukhime' => 1,
					'show_promo_link' => 1,
					'toggle_shortcut_ctrl' => 0,
					'toggle_shortcut_alt' => 0,
					'toggle_shortcut_key' => 120,
					'toggle_shortcut_title' => 'F9',
					'current_version' => $this->plugin_version
				);
			// get option
			$this->settings = get_option('pramukhime_options');
			// if not array, use the default settings
			if(!is_array($this->settings))
			{
				$this->settings = $this->defaultSettings;
			}
			// loop through all the languages and build final array
			foreach($this->settings["language_list"] as $key => $value)
			{
				// If enabled add to an array
				if(1 == $value['E'])
				{
					if('English' == $value["V"])
					{
						$val = "pramukhime:" . strtolower($value["V"]);
						
					}
					else{
						$val = "pramukhindic:" . strtolower($value["V"]);
					}
					$this->langs[$val] = $value["T"];
					if($this->default_lang == '')
					{
						$this->default_lang = $val;
					}
				}
			}
			// calculate toggle title json
			$toggle_title = '';
			$this->toggle_key_json = "'toggle_key':{'key':".$this->settings["toggle_shortcut_key"].",'ctrl':";
			$value = 'false';
			if(1 == $this->settings["toggle_shortcut_ctrl"])
			{
				$toggle_title .= 'Ctrl+';
				$value = 'true';
			}
			$this->toggle_key_json .= $value .", 'alt':";
			
			// reset
			$value = 'false';
			if(1 == $this->settings["toggle_shortcut_alt"])
			{
				$toggle_title .= 'Alt+';
				$value = 'true';
			}
			$this->toggle_key_json .= $value . ", 'title':'" . $toggle_title . $this->settings["toggle_shortcut_title"]."'}";
			
			add_action('admin_menu', array(&$this, 'admin_menu'));
			add_action( 'wp_enqueue_scripts', array(&$this, 'register_scripts') );
			add_action( 'admin_enqueue_scripts', array(&$this, 'register_scripts') );
    	}
		
		function register_scripts()
		{
			$is_admin = is_admin();
			$admin_page_enabled = (1 == $this->settings["dashboard_enable_pramukhime"] && $is_admin);
			$visitor_page_enabled = (1 == $this->settings["visitor_enable_pramukhime"] && !$is_admin);
			
			$dependant_js = array('jquery');
			// register script
			wp_register_script("pramukhime", plugins_url( 'pramukhime/js/pramukhime.js', __FILE__ ), array(), $this->plugin_version);
			wp_register_script("pramukhlib", plugins_url( 'pramukhime/js/pramukhindic.js', __FILE__ ), array(), $this->plugin_version);
			wp_register_script("pramukhlibhelper", plugins_url( 'js/pramukhime-helper.js', __FILE__ ), $dependant_js, $this->plugin_version);
			wp_register_script("json3", plugins_url( 'js/json3.min.js', __FILE__ ), $dependant_js, $this->plugin_version);
			
			if ($is_admin)
			{
				// Show the plugin "Settings" link on plugins page
				add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'add_action_links') );
				$screen = get_current_screen();
				if ( current_user_can('edit_posts') || current_user_can('edit_pages') )
				{
					// if rich editing and pramukhime is enabled then add more filters
					if ('true' == get_user_option('rich_editing') && 1 == $this->settings['visual_editor_enable_pramukhime'] && 'post' == $screen->base)
					{
						$this->mce_enabled = true;
						add_action("wp_tiny_mce_init", array(&$this, 'add_mce_preinit'));
						add_filter("mce_external_plugins", array(&$this, 'add_mce_plugin'));
						add_filter("tiny_mce_before_init", array(&$this, 'add_mce_settings'));
						add_filter('mce_buttons', array(&$this,'add_mce_buttons'));
					}
				}
				
				
				if ($screen->id == $this->plugin_settings_id) 
				{
					wp_register_script("pramukhlibadmin", plugins_url( 'js/pramukhime-admin.js', __FILE__ ), array( 'jquery-ui-sortable','jquery-ui-draggable'), $this->plugin_version, 1);
					wp_enqueue_script("pramukhlibadmin");
					wp_enqueue_style('pramukhimeadmin', plugins_url('css/pramukhime-admin.css', __FILE__), array(), $this->plugin_version);
				}
			}
			
			
			if ($visitor_page_enabled || $admin_page_enabled)
			{
				$this->page_enabled = true;
				// Load css
				wp_enqueue_style('dashicons');
				wp_enqueue_style('pramukhime', plugins_url('css/pramukhime.css', __FILE__), array(), $this->plugin_version);
				
				
				if(!$this->mce_enabled)
				{
					// load css
					wp_enqueue_style('pramukhindic', plugins_url('pramukhime/css/pramukhindic.css', __FILE__), array(), $this->plugin_version);
					// Load javascript
					wp_enqueue_script("pramukhime");
					wp_enqueue_script("pramukhlib");
				}
				
				wp_enqueue_script("pramukhlibhelper");
				wp_enqueue_script("json3");
				
				add_action('wp_footer', array(&$this,'add_pramukhime_dropdown'));
				add_action('admin_footer', array(&$this,'add_pramukhime_dropdown'));
				
			} else if ($this->mce_enabled) {
				wp_enqueue_script("pramukhlibhelper");
				wp_enqueue_script("json3");
			}
			
			
		}
		
		// Add PramukhIME settings under WP Settings menu
		function admin_menu() {
			$this->plugin_settings_id = add_options_page("PramukhIME Settings", "PramukhIME", 'manage_options', plugin_basename(__FILE__), array(&$this, 'show_options_page'));
		}
		// Adds "Settings" link under the plugin name in "Installed Plugins" page
		function add_action_links ( $links ) {
			$mylinks = array(
			'<a href="' . admin_url( 'options-general.php?page='. plugin_basename(__FILE__) ) . '">Settings</a>',
			);
			return array_merge( $links, $mylinks );
		}
		
		function add_mce_plugin($plugins) {
			 return array('pramukhime' => plugins_url( 'pramukhime/plugin.js', __FILE__ ));
		}
		
		function &add_mce_buttons($buttons) 
		{
			array_unshift($buttons, "pramukhime", "pramukhimehelp", "pramukhimesettings", "pramukhimeresetsettings", "pramukhimetogglelanguage");
			return $buttons;
		}
		
		function add_mce_preinit($mce_settings)
		{
			echo "<script type='text/javascript'>
			jQuery.extend('pramukhime_options',{'mce_enabled':true, 'default_language':'" . $this->default_lang . "'});
			tinymce.on('SetupEditor', function(ed) { ed.on('init', function(e) {
				var intervalId;
				var checkInit = function() {
					if (typeof pramukhIME !== 'undefined' && typeof PramukhIndic !== 'undefined') {
						clearInterval(intervalId);
						pramukhime_setup();
					}
				}
				intervalId = setInterval(checkInit, 100);
			}); });</script>";
			
		}
		
		function add_mce_settings($init)
    	{
			$temp_language = array();
			
			foreach($this->langs as $key => $value)
			{
				$temp_language[] = "{'text':'" . addslashes(esc_html($value)) . "', 'value':'" . $key . "'}";
			}
			
			$init['pramukhime_options'] = "{'languages':[" . implode(',', $temp_language) . "],". $this->toggle_key_json ."}";
    		return $init;
			
    	}
		
		
		function add_pramukhime_dropdown()
		{
			$plugin_url = plugins_url( '', __FILE__ );
			
			$options_html = '';
			$js_variable = "jQuery.extend(pramukhime_options,  {'url': '". $plugin_url . "/pramukhime/',". $this->toggle_key_json;
			
			
			$js_variable .= ", 'languages':{";
			
			$pramukhime_languages = array();

			foreach($this->langs as $key => $value)
			{
				$options_html .="<option value='" . $key . "'>" . esc_html($value) . "</option>";
				$pramukhime_languages[] = "'" . $key . "': '" . addslashes(esc_html($value)) . "'" ;
					
			}
			// 'page_enabled' is always true because that is the only way, it should have come to this function
			$js_variable .= implode(',', $pramukhime_languages) . "}, 'kb_class': 'PramukhIndic', 'mce_enabled':" . ($this->mce_enabled ? 'true': 'false') . ", 'page_enabled':true, 'default_language':'" . $this->default_lang . "'} );";
			
			
			
			?>
			<div id="pramukhime-layer">
				<div id='pramukhime-content'>
						<span id="pramukhime-content-heading">
						Type in <select name='pramukhime-select-lang' id='pramukhime-select-lang' ><?php echo $options_html; ?></select>
						<button type="button" class="pi-btn" id="pramukhime-toggle-lang" title="Toggle language" tabindex="-1">
							<i class="pi-pramukhime-english"></i>
						</button>
						<button type="button" class="pi-btn" id="pramukhime-more" title="Show More" tabindex="-1">
							<i class="pi-more-down"></i>
						</button>
						</span>
						<button type="button" class="pi-btn" id="pramukhime-more-side" title="Shrink/Expand" tabindex="-1">
							<i class="pi-more-right"></i>
						</button>
				</div>
				<?php 
					if(1 == $this->settings["show_promo_link"])
					{
						echo "<div id='pramukhime-promo-link'>Powered By <a href='http://www.vishalon.net/pramukhime' target='_blank'>PramukhIME</a></div>";
					}
					else
					{
						echo "<!-- Typing in Indian language is powered by PramukhIME (http://www.vishalon.net/pramukhime) -->";
					}
						
				?>
				<div id="pramukhime-content-english">
					Details available only for Indian languages
				</div>
				<div id="pramukhime-content-detail">
					<div class="pi-ui-title">Settings <button type="button" class="pi-btn" id="pramukhime-reset" title="Reset settings"  tabindex="-1"><i class="pi-reset"></i></button>
						<span id="pramukhime-reset-message">Settings reset</span>
					</div>
					<div id="pramukhime-settings-digitinenglish">
						<label><input type="checkbox" id="pramukhime-digitinenglish" /> Digit In English (for all languages)</label>
					</div>
					<div id="pramukhime-settings-typingrule">
						<label for="pramukhime-typingrules">Advanced Typing Rule</label>
						<select id="pramukhime-typingrules" title="Select Typing Rule">
							<option value="panchamakshar">Panchamakshar</option>
							<option value="anusvar">Anusvar</option>
						</select>
					</div>
					<div class="pi-ui-title">Help</div>
					<div id="pramukhime-content-help">
						<img src="<?php echo $plugin_url . '/pramukhime/img/pramukhime-english.png'; ?>" id="pramukhime-help-image" alt="Indian language typing help" />
					</div>
					<a target="_blank" id="pramukhime-help-link">View Detailed Help <span class="pi-external"></span></a>
				</div>
			</div>
			<script language="JavaScript" type="text/javascript">
			<?php echo $js_variable; ?>
			</script>
			<?php
		} // add_pramukhime_dropdown
		
		function getIfSet($var, $ifset, $ifnotset, $array = NULL)
		{
			if(!isset($array))
			{
				$array = $_POST;
			}
			if(!empty($array[$var]) && isset($array[$var]))
			{
				return $ifset;
			}
			return $ifnotset;
		}
		function getSet($var, $ifnotset, $array = NULL)
		{
			if(!isset($array))
			{
				$array = $_POST;
			}
			if(!empty($array[$var]) && isset($array[$var]))
			{
				$val = sanitize_text_field(stripslashes(trim($array[$var])));
				return $val;
			}
			return $ifnotset;
		}
		
		function show_options_page() {
			
			if ( $_POST && plugin_basename(__FILE__) == $_GET['page'] ) {
				check_admin_referer('update_pramukhime_settings');
				if(!empty($_POST['pramukhime-plugin-submit']) && isset($_POST['pramukhime-plugin-submit']))
				{
				
				// Initialize with default settings
					$settings = array(
							'language_list' => array(),
							'visual_editor_enable_pramukhime' => 1,
							'visitor_enable_pramukhime' => 1,
							'dashboard_enable_pramukhime' => 1,
							'show_promo_link' => 0,
							'toggle_shortcut_ctrl' => 0,
							'toggle_shortcut_alt' => 0,
							'toggle_shortcut_key' => 120,
							'toggle_shortcut_title' => 'F9',
							'current_version' => $this->plugin_version
						);
					$settings['visual_editor_enable_pramukhime'] = $this->getIfSet('visual_editor_enable_pramukhime', 1, 0);
					$settings['visitor_enable_pramukhime'] = $this->getIfSet('visitor_enable_pramukhime', 1, 0);
					$settings['dashboard_enable_pramukhime'] = $this->getIfSet('dashboard_enable_pramukhime', 1, 0);
					$settings['show_promo_link'] = $this->getIfSet('show_promo_link', 1, 0);
					$settings['toggle_shortcut_ctrl'] = $this->getIfSet('toggle_shortcut_ctrl', 1, 0);
					$settings['toggle_shortcut_alt'] = $this->getIfSet('toggle_shortcut_alt', 1, 0);
					$settings['toggle_shortcut_key'] = $this->getSet('toggle_shortcut_key', 120);
					$settings['toggle_shortcut_title'] = $this->getSet('toggle_shortcut_title', 'F9');
					
					// $_POST['language'] must be present so not checking for it
					
					foreach($_POST['language'] as $key => $value)
					{
						$element = array(); 
						$lang = $this->getSet('language','', $value);
						// store value only if language is set
						if('' != $lang)
						{
							$element["V"] = $lang;
							$element["T"] = $this->getSet('title',$lang, $value);
							$element["E"] = $this->getIfSet('enabled', 1, 0, $value);
							
							// add it to the main settings
							$settings['language_list'][] = $element;
						}
						// else don't do anything and ignore the whole node
					}
					
					
					$this->settings = $settings;
					// Save option
					update_option('pramukhime_options', $this->settings);
					
					echo "<br />" . '<div id="message" class="updated notice is-dismissible"><p><strong>' . __('Settings saved. Refresh the page to view updated settings.') . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>' . "\n";
					
					
				}
				elseif (!empty($_POST['pramukhime-plugin-reset']) && isset($_POST['pramukhime-plugin-reset']))
				{
					// reset settings
					$this->settings = $this->defaultSettings;
					// Save option
					update_option('pramukhime_options', $this->settings);
					
					echo "<br />" . '<div id="message" class="updated notice is-dismissible"><p><strong>' . __('Settings reset.') . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>' . "\n";
					
					
				}
			} // end if $_post
		
			$counter = 0;
		
			
		
		
			?>
			<div class="wrap">
				<h1>PramukhIME Settings</h1>
				<form name="pramukhimesetting" method="post" action="">
				<?php wp_nonce_field( 'update_pramukhime_settings' ); ?>
				<div id="widgets-right" class="single-sidebar">
					<div class="sidebars-column-1">
						<div class="widgets-holder-wrap">
							<div id="sidebar-1" class="widgets-sortables">
								<div class="sidebar-name">
									<h3>Available Languages</h3>
								</div>
								<div class="sidebar-description"><p class="description">Enable language and customize the language name shown in the language selection list. Sort the language list using drag and drop.</p></div>
								<div>
								<input type="button" class="button" value="Select All" id="pramukhime-selectall" />&nbsp;<input type="button" class="button" value="Deselect All"  id="pramukhime-deselectall" />&nbsp;
								<br /><br />
								</div>
								<?php foreach ($this->settings["language_list"] as $key => $value) 
								{
								?>
								<div id='language-<?php echo $counter;?>' class='widget'>
									<div class="widget-top">
										<div class="pi-language-title" id='language-title-<?php echo $counter;?>'>
											<div class="pi-language-list">
												<input class="checkbox" type="checkbox"  id="language-<?php echo $counter;?>-enabled" name="language[<?php echo $counter;?>][enabled]" <?php checked($value["E"], 1); ?> />
												<label for="language-<?php echo $counter;?>-title"><?php echo $value["V"]; ?></label>
											</div>
											<div class="pi-language-customname">
												<input id="language-<?php echo $counter;?>-title" name="language[<?php echo $counter;?>][title]" type="text" value="<?php echo esc_html($value["T"]); ?>" />
												<input type="hidden" id="language-<?php echo $counter;?>-language" name="language[<?php echo $counter;?>][language]" value="<?php echo $value["V"]; ?>" />
												<span class="widget-action"></span>
											</div>
											
										</div>
									</div>
								</div>
								<?php
									$counter++;
								}
								?>
							</div>
						</div>
					</div>
				</div>
				<h3 class="title">Advanced Options</h3>
				<p>Advanced options to tweak PramukhIME for your needs</p>
				<table class="form-table">
					<tr>
						<th scope="row">Enable PramukhIME</th>
						<td>
							<label for="visual_editor_enable_pramukhime"><input name="visual_editor_enable_pramukhime" id="visual_editor_enable_pramukhime" value="1" type="checkbox" <?php checked($this->settings["visual_editor_enable_pramukhime"], '1'); ?> /> Visual Editor</label><br />
							<label for="visitor_enable_pramukhime"><input name="visitor_enable_pramukhime" id="visitor_enable_pramukhime" value="1" type="checkbox" <?php checked($this->settings["visitor_enable_pramukhime"], 1); ?> /> Visitors/subscribers</label><br />
							<label for="dashboard_enable_pramukhime"><input name="dashboard_enable_pramukhime" id="dashboard_enable_pramukhime" value="1" type="checkbox" <?php checked($this->settings["dashboard_enable_pramukhime"], 1); ?> /> Admin Panel</label>
						</td>
					</tr>
					<tr>
						<th scope="row">Toggle Shortcut</th>
						<td>
							<label for="toggle_shortcut_ctrl"><input name="toggle_shortcut_ctrl" id="toggle_shortcut_ctrl" value="1" type="checkbox" <?php checked($this->settings["toggle_shortcut_ctrl"], 1); ?> /> Ctrl</label>
							<label for="toggle_shortcut_alt"><input name="toggle_shortcut_alt" id="toggle_shortcut_alt" value="1" type="checkbox" <?php checked($this->settings["toggle_shortcut_alt"], 1); ?> /> Alt</label>
							<label for="toggle_shortcut_key">
								<select id="toggle_shortcut_key" name="toggle_shortcut_key" >
									<?php 
										// Add F1-F12 
										for($counter = 112; $counter <= 123; $counter++)
										{
											echo "<option value='" . $counter . "' " . selected($this->settings["toggle_shortcut_key"], $counter) .  ">F" . ($counter - 111) . "</option>";
										}
										 // small "a"
										for($counter = 65; $counter <= 90; $counter++)
										{
											echo "<option value='" . $counter . "' " . selected($this->settings["toggle_shortcut_key"], $counter) .  ">" . chr($counter) . "</option>";
										}
										
									?>
								</select>
							 Shortcut key to toggle between current and last selected language</label>
							 <input type="hidden" id="toggle_shortcut_title" name="toggle_shortcut_title" value="<?php echo $this->settings["toggle_shortcut_title"];?>" />
						</td>
					</tr>
					<tr style="display:none">
						<th scope="row">Promote my language</th>
						<td>
							<label for="show_promo_link"><input name="show_promo_link" id="show_promo_link" value="1" type="checkbox" <?php checked($this->settings["show_promo_link"], 1); ?> /> I am helping spread my language by showing &quot;Powered by PramukhIME&quot; link</label>
						</td>
					</tr>
				</table>
			<p class="submit">
				<input id="pramukhime-plugin-submit" class="button button-primary" type="submit" name="pramukhime-plugin-submit" value="Save Changes" />
				<input id="pramukhime-plugin-reset" class="button" type="submit" name="pramukhime-plugin-reset" value="Reset Settings" />
			</p>

	</form>
			</div>
			<?php
		}
		
	} // End class
	
$pramukhIME = new PramukhIME();

} // End If

?>
