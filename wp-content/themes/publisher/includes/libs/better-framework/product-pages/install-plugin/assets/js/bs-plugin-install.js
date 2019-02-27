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


(function ($) {
    var bs_product_plugin_manager = function () {

        this.$loading_el        = false;
        this.active_el          = false;
        this.plugin_ajax_action = false;

        this.init();
    }

    bs_product_plugin_manager.prototype = {
        init: function () {
            var self = this;

            $(document).ready(function () {

                self.install_plugin();
                self.update_plugin();

                self.active_plugin();
                self.deactivate_plugin();
            });
        },

        ajax_params: function (params) {
            var default_obj    = {},
                default_params = $("#bs-pages-hidden-params").serializeArray();

            if (default_params) {
                for (var i = 0; i < default_params.length; i++) {
                    default_obj[ default_params[ i ].name ] = default_params[ i ].value;
                }
            }

            return $.extend(default_obj, params);
        },

        ajax: function (params, success_callback) {
            var self = this;
            params   = this.ajax_params(params);

            $.ajax({
                 url: ajaxurl,
                 type: 'POST',
                 dataType: 'json',
                 data: $.extend(
                     {action: 'bs_pages_ajax', page_id: $("#bs-pages-current-id").val()},
                     params
                 )
             })
             .done(success_callback)
             .fail(function () {
                 self.show_error();
             })
        },


        plugin_show_message: function () {

            this
                .show()
                .siblings()
                .hide()
                .parent();
        },

        /**
         *  get message class by process action
         *
         * @param action {String}  action name passed to plugin_process method
         * @returns {string} message class name on success or empty string on failure.
         * @private
         */
        _get_message_class: function (action) {

            var classes = {

                install: '.installing',
                deactivate: '.uninstalling',
                update: '.updating',
                active: '.activating',
            };

            if (typeof classes[ action ])
                return classes[ action ];

            return '';
        },

        /**
         *
         * @param action {String} which action should start. install, deactivate or update
         */
        plugin_process: function (action) {

            var self      = this,
                linkClass = action + '-plugin';


            $('.bs-pages-plugin-item').on('click', '.' + linkClass + ' a', function (e) {
                e.preventDefault();

                self.active_el = this;
                var $box       = $(this).closest('.bs-pages-plugin-item'),
                    $this      = $box.find('.bs-pages-buttons');

                //remove disabled class from active plugin box
                $box.removeClass('plugin-disabled');

                //add disabled class to another plugin boxes
                $(".bs-product-pages-install-plugin")
                    .find('.bs-pages-plugin-item')
                    .not($box)
                    .addClass('plugin-disabled');

                self.deactivate_menu();
                self.deactivate_tabs();
                $(window).on('beforeunload.bs-demo-installer', function (e) {
                    return true;
                });

                $this
                    .delay(330)
                    .queue(function (n) {

                        //find message by class name to display user
                        var messageClass = self._get_message_class(action);
                        $this.hide();

                        self.plugin_show_message.call(
                            $this
                                .nextAll('.messages')
                                .find(messageClass)
                        );

                        //display progressbar to user
                        self.$loading_el = $this
                            .closest('.bs-pages-plugin-item')
                            .find('.bs-pages-progressbar')
                            .css('visibility', 'visible');

                        //default progress bar value is 10 percent
                        var default_percentage = $.inArray(action, [ 'deactivate', 'active' ]) === -1 ? 10 : 50;
                        self.$loading_el.css('width', default_percentage + '%');

                        var plugin_slug = $this.data('plugin-slug');

                        //get install or uninstall steps from server
                        self.ajax(
                            {bs_pages_action: 'get_steps', plugin_slug: plugin_slug, plugin_action: action},

                            function (response) {

                                if (response.success) {

                                    self.process_steps = response.result;

                                    //ajax request action param value
                                    self.plugin_ajax_action = action;
                                    self.plugin_ajax_request(plugin_slug, 0, 1, 1);
                                } else {
                                    self.show_error();
                                }
                            }
                        );
                        n();
                    })

            });
        },

        install_plugin: function () {

            this.plugin_process('install');
        },

        deactivate_plugin: function () {

            this.plugin_process('deactivate');
        },

        update_plugin: function () {

            this.plugin_process('update');
        },
        active_plugin: function () {

            this.plugin_process('active');
        },
        active_menu: function () {
            $('#adminmenuwrap').removeClass('installing-demo');
        },
        active_tabs: function () {
            $('.bs-product-pages-tabs-wrapper').removeClass('installing-demo');
        },
        deactivate_menu: function () {
            $('#adminmenuwrap').addClass('installing-demo');
        },
        deactivate_tabs: function () {
            $('.bs-product-pages-tabs-wrapper').addClass('installing-demo');
        },
        /**
         * final step changes
         *
         * @param action {String}  action name passed to plugin_process method
         * @returns {boolean} true on success or false ob failure.
         */
        plugin_process_complete: function (action) {

            if (!this.active_el)
                return false;


            var $box            = $(this.active_el).closest('.bs-pages-plugin-item'),
                $messages       = $box.find('.messages'),
                animation_delay = 330,
                successMessageSelector,
                self            = this;


            if (action === 'deactivate') {
                // in deactivating process
                successMessageSelector = '.uninstalled';

                $box
                    .removeClass('plugin-not-installed plugin-active')
                    .addClass('plugin-installed plugin-inactive');

            } else if (action === 'active') {
                // in activating process
                successMessageSelector = '.activated';

                $box
                    .removeClass('plugin-not-installed plugin-inactive')
                    .addClass('plugin-installed plugin-active');

            } else if (action === 'install') {
                // in installing process
                successMessageSelector = '.installed';

                $box
                    .removeClass('plugin-not-installed')
                    .addClass('plugin-installed');

            } else if (action === 'update') {
                // in updating process
                successMessageSelector = '.updated-message';

                $box.removeClass('plugin-update-available');

            } else if (action === 'rollback') {
                // in updating process
                successMessageSelector = '.rollback-complete';

                $box.removeClass('plugin-update-available');

            } else {

                return false;
            }

            // hide loading message and show complete message
            $messages.children().hide();
            $messages.find(successMessageSelector).show();

            //hide progress bar
            $box
                .find('.bs-pages-progressbar')
                .css('visibility', 'hidden')
                .delay(500)
                .queue(function (n) {
                    $(this).css('width', '0%');
                    n();
                });


            //remove disabled class for all boxes
            $(".bs-product-pages-install-plugin")
                .find('.bs-pages-plugin-item')
                .removeClass('plugin-disabled');

            if (this.process_steps.reload) {
                location.reload();
            }
            this.active_menu();
            this.active_tabs();
            $(window).off('beforeunload.bs-demo-installer');

            // Update Plugin Badge
            if ('update' === action) {
                var selector = 'li.toplevel_page_' + bs_plugin_install_loc.menu_slug +
                                ',#wp-admin-bar-'+bs_plugin_install_loc.menu_slug+'-parent',
                    $badge   = $(selector).find('.plugin-count'),
                    count    = parseInt($badge.html());

                if (count) {

                    if (count === 1) {
                        $badge.remove();
                    } else {
                        $badge.html(--count);
                    }

                }
            }

            return true;
        },

        show_error: function (error_message, error_code) {
            var self = this,
                loc  = jQuery.extend({}, bs_plugin_install_loc.on_error);

            if (error_message && error_code) {
                loc.body = loc.display_error
                              .replace('%ERROR_CODE%', error_code)
                              .replace('%ERROR_MSG%', error_message);
            }

            return $.bs_modal({
                content: loc,

                buttons: {
                    close_modal: {
                        label: loc.button_ok,
                        type: 'primary',
                        action: 'close',
                        clicked: function () {

                            //decrease progressbar with
                            setTimeout(function () {
                                    var width = Math.floor(self.$loading_el.width() / 2);
                                    self.$loading_el.css('width', width);
                                }
                                , this.options.animations.delay
                            );

                            var plugin_ajax_action = 'rollback';
                            //get plugin slug
                            var plugin_slug = $(self.active_el)
                                .closest('.bs-pages-plugin-item')
                                .find('.bs-pages-buttons')
                                .data('plugin-slug');

                            //rollback request
                            self.ajax(
                                {bs_pages_action: plugin_ajax_action, plugin_slug: plugin_slug},

                                function (response) {

                                    if (response.success) {

                                        self.plugin_process_complete(plugin_ajax_action);
                                    } else {
                                        //show error message
                                        $.bs_modal({
                                            content: $.extend(bs_plugin_install_loc.on_error, {body: loc.rollback_error}),
                                            buttons: {
                                                close_modal: {
                                                    label: loc.button_ok,
                                                    type: 'primary',
                                                    action: 'close',
                                                    clicked: function () {
                                                        self.plugin_process_complete(plugin_ajax_action);
                                                    }
                                                },
                                            }
                                        });
                                    }
                                }
                            );
                        }
                    },
                }
            });
        },

        plugin_ajax_request: function (plugin_slug, index, step_number, progress_step) {

            var self       = this,
                ajaxParams = {
                    plugin_slug: plugin_slug,
                    current_type: self.process_steps.types[ index ],
                    current_step: step_number,
                    bs_pages_action: self.plugin_ajax_action
                };

            self.ajax(
                ajaxParams,

                function (response) {

                    if (!response) {
                        self.show_error();
                        return;
                    }
                    if (response.success) {

                        //increase loading
                        if (self.$loading_el) {
                            self.$loading_el.css(
                                'width',
                                Math.floor(100 / self.process_steps.total * progress_step) + '%'
                            )
                        }


                        if (self.process_steps.steps_count <= index && self.process_steps.steps[ index ] <= step_number) {

                            self.plugin_process_complete(self.plugin_ajax_action);

                        } else {

                            //next step

                            if (self.process_steps.steps[ index ] <= step_number) {
                                index++;
                                step_number = 1;
                            } else {
                                step_number++;
                            }

                            self.plugin_ajax_request(plugin_slug, index, step_number, progress_step + 1);
                        }
                    } else {

                        if (response.result && response.result.is_error) {
                            response.result.error_message += "\n\n";
                            response.result.error_message += JSON.stringify(ajaxParams);
                            console.error(response.result.error_message, response.result.error_code);
                            var modal = self.show_error(response.result.error_message, response.result.error_code),
                                $info = modal.$modal.find('.bs-pages-error-section textarea');


                            $info.height($info[ 0 ].scrollHeight);
                            modal.make_vertical_center();
                        } else {
                            self.show_error();
                        }
                    }
                }
            );
        }
    };

    new bs_product_plugin_manager();
})(jQuery);