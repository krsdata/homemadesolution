////////////////////////////////////////////////////////////////////////////////////////
// Events                                                                             //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constants                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Variables                                                                          //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Constructor & Destructor                                                           //
////////////////////////////////////////////////////////////////////////////////////////	
jQuery(document).ready(function () {
	jQuery("[type=text], [type=number]").keypress(function(event){
		event = event || window.event;
		if(event.keyCode == 13){
			return false;
		}
	});
	jQuery(".ytwd_edit, .ytwd_edit_table").tooltip();	
	
});



////////////////////////////////////////////////////////////////////////////////////////
// Public Methods                                                                     //
////////////////////////////////////////////////////////////////////////////////////////

function ytwdOpenMediaUploader(e,id,callback){
    if(typeof callback == "undefined"){
        callback = false;
    }
    e.preventDefault();
	var custom_uploader = wp.media({
        title: 'Upload',
        button: {
            text: 'Upload'
        },
        multiple: false  
    })
    .on('select', function() {
       var attachment = custom_uploader.state().get('selection').first().toJSON();
       jQuery('#' + id).val(attachment.url);
       jQuery('.' + id + "_view").html('<img src="' + attachment.url + '" height="25"><span class="' + id + '_delete" onclick="jQuery(\'#' + id + '\').val(\'\');jQuery(\'.' + id + '_view\').html(\'\');if(callback){callback();}">x</span>');
       if(callback){
            callback();
       }
    })
    .open();
	
	return false;

}
function ytwdFormSubmit(task){
	if(typeof task == "undefinded"){
		task == "";
	}
	var adminForm = jQuery("#adminForm");	
	if(task != ""){
		ytwdFormInputSet("task",task);
		switch(task){
			case "save" :
			case "apply" :           
			case "save2copy" :           
				  fillInputs();
                  if(checkFields("wd-required") == false){
                    return false;
                  }                  
				break;
		
		}
	}
	adminForm.submit();

}

function removeRedBorder(obj){
	jQuery(obj).removeClass("wd-required-active");
}

function checkFields(fieldClass){
    var isValid = true;
    jQuery("." + fieldClass).removeClass("wd-required-active"); 
    jQuery("." + fieldClass).each(function(){
       if (jQuery(this).val() == ""){
            jQuery(this).addClass("wd-required-active");         
            isValid = false;                        
       } 
    });

    if(isValid == false){
        alert("Please Fill Required Fields.");
        return false;
    } 
   return true;
}

function wdTabs(tabs){
    var activeClass = tabs + "_active";
    var tabsContainer = tabs + "_container";
    var tabsContainerItem = tabs + "_container_item";
    jQuery("." + tabs + " li a").click(function(){
		jQuery("." + tabsContainerItem ).hide();
		jQuery("." + tabs + " li a").removeClass(activeClass);
		jQuery(jQuery(this).attr("href")).show();
		jQuery(this).addClass(activeClass);
        
        jQuery("#" + activeClass).val(jQuery(this).attr("href").substr(1));        
		return false;
	});
}

////////////////////////////////////////////////////////////////////////////////////////
// Getters & Setters                                                                  //
////////////////////////////////////////////////////////////////////////////////////////
function ytwdFormInputSet(name, value){
	jQuery("[name=" + name + "]").val(value);
}

function fillInputs(){
	switch(ytwdGlobal.page){
		case "youtube_ytwd" :
			break;
		case "settings_gmwd" :

			break;            
		
	}
}
////////////////////////////////////////////////////////////////////////////////////////
// Private Methods                                                                    //
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
// Listeners                                                                          //
////////////////////////////////////////////////////////////////////////////////////////