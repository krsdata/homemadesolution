var pramukhime_options = {'mce_enabled':false, 'page_enabled':false};

(function($) {
	var $document = $( document );
	$document.ready( function(){ 
		
		// if not enabled for the page, return
		if (!pramukhime_options.page_enabled) {
			return;
		}
		// bind event to drop down
		$("#pramukhime-select-lang").change(function() {
			var lang = $("#pramukhime-select-lang").val().split(':');
			pramukhIME.setLanguage(lang[1], lang[0] || '' );
		});
		
		
		// V and ^ button click event
		$('#pramukhime-more').click(function() {
			var newclass = 'pi-more-down';
			var btn = $('#pramukhime-more i');
			if (btn.hasClass('pi-more-down')) {
				newclass = 'pi-more-up';
			}
			// swap class
			btn.removeClass().addClass(newclass);
			pramukhime_updateui();
		});
		
		// < and > button click event
		$('#pramukhime-more-side').click(function() {
			
			var btn = $('#pramukhime-more-side i');
			var newclass = 'pi-more-left';
			if (btn.hasClass('pi-more-right')) {
				// hide everything
				$('#pramukhime-content-english').hide();
				$('#pramukhime-content-detail').hide();
				$('#pramukhime-content-heading').hide();
				$('#pramukhime-promo-link').hide();
				
			} else {
				$('#pramukhime-content-heading').show();
				$('#pramukhime-promo-link').show();
				newclass = 'pi-more-right';
				pramukhime_updateui();
			}
			// swap class
			btn.removeClass().addClass(newclass);
		});
		
		// toggle language button click event
		$('#pramukhime-toggle-lang').click(function() {
			pramukhIME.toggleLanguage();
		});
		
		// reset settings button click event
		$('#pramukhime-reset').click(function() {
			pramukhime_resetsettings();
			$("#pramukhime-reset-message").show();
			// hide the reset message after 3 seconds
			setTimeout(function() {$("#pramukhime-reset-message").hide();}, 3000);
		});
		
		// digit in english checkbox click event
		$('#pramukhime-digitinenglish').click (function() {
			var lang = pramukhIME.getLanguage();
			lang.language = 'all';
			lang['digitInEnglish'] = this.checked;
			// pass array of object for this function
			pramukhIME.setSettings([lang]);
		});
		
		// typing rule drop down change event
		$('#pramukhime-typingrules').change (function() {
			var lang = pramukhIME.getLanguage();
			
			lang['advancedRule'] = this.options[this.selectedIndex].value;
			// pass array of object for this function
			pramukhIME.setSettings([lang]);
		});
		
		// This should be setup only when no tinymce
		if (!pramukhime_options.mce_enabled) {
			pramukhime_setup();
		}
		
	});
})(jQuery);

function pramukhime_setup() {
	var $ = jQuery;

	if(pramukhime_options.page_enabled) {
		// If admin bar is present, show the drop down below it
		if($("#wpadminbar").length)
		{
			$("#pramukhime-layer").css({'top': $("#wpadminbar").height() + 'px'});
		}
		
		if(!pramukhime_options.mce_enabled) {
			// set toggle key
			pramukhIME.setToggleKey(pramukhime_options.toggle_key.key, pramukhime_options.toggle_key.ctrl, pramukhime_options.toggle_key.alt);
			
			// add language. pramukhIME is already enabled from the php page
			pramukhIME.addKeyboard(pramukhime_options.kb_class);
			
		}
	}
	try {
		pramukhime_setupinitialsettings();
	} catch(err) {
		// die silently. May be configuration is wrong.
	}
	
	
	if(pramukhime_options.page_enabled) {
		pramukhIME.enable();
		// Register on change so that any subsequent change is stored
		pramukhIME.on('languagechange', pramukhime_onlanguagechange);
		pramukhIME.on('settingschange', pramukhime_onsettingschange);
	}
}

function pramukhime_setupinitialsettings() {
	var stored = true;
	if (typeof Storage === 'undefined' || typeof localStorage === 'undefined') {
		stored=false;
	}
	var pramukhime_settings = jQuery.parseJSON(localStorage.getItem('pramukhime_settings_400'));
	if (pramukhime_settings === null || typeof pramukhime_settings === 'undefined') {
		stored = false;
	}
	if (stored) {
		pramukhIME.setSettings(pramukhime_settings.settings);
		// set previously selected language
		pramukhIME.setLanguage(pramukhime_settings.lastSelectedLanguage.language, pramukhime_settings.lastSelectedLanguage.kb);
		// set currently selected language
		pramukhIME.setLanguage(pramukhime_settings.selectedLanguage.language, pramukhime_settings.selectedLanguage.kb);
	} else {
		// select the default selected language
		pramukhIME.setLanguage(pramukhime_options.default_language.split(":")[1],pramukhime_options.default_language.split(":")[0]);
	}
	
	// manually call this function
	pramukhime_onlanguagechange();
}

function pramukhime_resetsettings() {
	if (typeof Storage === 'undefined' || typeof localStorage === 'undefined') {
		// don't do anything
	} else {
		localStorage.removeItem('pramukhime_settings_400');
	}
	// reset the settings
	pramukhIME.resetSettings();
}

function pramukhime_savesettings() {
	if (typeof Storage === 'undefined' || typeof localStorage === 'undefined') {
		return;
	}
	// 400 represents the version number
	var pramukhime_settings = jQuery.parseJSON(localStorage.getItem('pramukhime_settings_400')) || { 'settings': {}, 'selectedLanguage': {} };
	// Get the current settings for the selected language
	var current_settings = pramukhIME.getSettings();
	// overwrite stored settings with the new settings
	pramukhime_settings.settings = current_settings;
	pramukhime_settings.selectedLanguage = pramukhIME.getLanguage();
	pramukhime_settings.lastSelectedLanguage = pramukhIME.getLastLanguage();
	localStorage.setItem('pramukhime_settings_400', JSON.stringify(pramukhime_settings));
}

function pramukhime_updateui() {
	var $ = jQuery;
	var selectedLang = $('#pramukhime-select-lang').val();
	var btn = $('#pramukhime-more i');
	
	var showDetail = !btn.hasClass('pi-more-down');
	if (selectedLang === 'pramukhime:english') {
		if(showDetail) {
			$('#pramukhime-content-english').show();
			
		} else {
			$('#pramukhime-content-english').hide();
			
		}
		$('#pramukhime-content-detail').hide();
		
	} else {
		if (showDetail) {
			$('#pramukhime-content-detail').show();
		} else {
			$('#pramukhime-content-detail').hide();
		}
		$('#pramukhime-content-english').hide();
	}
	
}

function pramukhime_updatesettingsui() {
	// Update settings dialog
	var $ = jQuery;
	var current_settings = pramukhIME.getSetting();
	// if no advanced rules available
	if (current_settings.length >=2 && typeof current_settings[1].advancedRuleValues !== 'undefined') {
		if (current_settings[1].advancedRuleValues.length === 0) {
			$('#pramukhime-settings-typingrule').hide();
		} else {
			$('#pramukhime-settings-typingrule').show();
			$('#pramukhime-typingrules').val(current_settings[1].advancedRule);
		}
	}
	if (typeof current_settings[0].digitInEnglish !== 'undefined') {
		$('#pramukhime-digitinenglish')[0].checked = current_settings[0].digitInEnglish;
	}
}

var pramukhime_onsettingschange = function() {
	if(pramukhime_options.page_enabled) {
		// Update settings ui
		pramukhime_updatesettingsui();
	}
	
	// save the value in the storage
	pramukhime_savesettings();
};

// callback function
var pramukhime_onlanguagechange = function(data) {
	if(!pramukhime_options.page_enabled) {
		return;
	}
	// Not using "data" because we need to execute this function at the beginning
	var $ = jQuery;
	var currentlang = pramukhIME.getLanguage();
	var lastlang = pramukhIME.getLastLanguage();
	// set drop down value, help image and help url (dies silently if it does not exists)
	$("#pramukhime-select-lang").val(currentlang.kb + ':' + currentlang.language);
	$("#pramukhime-help-image").attr('src', pramukhime_options.url + 'img/' + pramukhIME.getHelpImage());
	$("#pramukhime-help-link").attr('href', pramukhime_options.url + 'help/' + pramukhIME.getHelp());
	$("#pramukhime-toggle-lang i").removeClass().addClass("pi-" + lastlang.kb + '-' + lastlang.language);
	
	// Update the shortcut key
	var kblang = lastlang.kb + ':' + lastlang.language, value;
	$('#pramukhime-select-lang > option').each(function() {
		if (this.value === kblang) {
			value = pramukhime_options.languages[lastlang.kb + ':' + lastlang.language];
			this.text = value + ' (' + pramukhime_options.toggle_key.title + ')'; 
			
		} else {
			this.text = pramukhime_options.languages[this.value];
		}
	});
	// Update settings ui and save
	pramukhime_onsettingschange();
};
