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

jQuery(function ($) {
    var $document = jQuery(document);

    $document.on('tinymce-editor-init', function () {

        $document.on("change", ".affect-editor-on-change :input", function () {
            var input_match = this.name.match(/\[([^\]]+)\]$/);
            if (!input_match)
                return false;
            var input_name = input_match[ 1 ];

            jQuery("#content_ifr").contents().find("body").attr("data-" + input_name, this.value);
        }).find(".affect-editor-on-change")
                 .find(':checked,:selected')
                 .change();
    });
});