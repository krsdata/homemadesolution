var bsLazy;
var docCookies = {
    getItem: function (sKey) {
        if (!sKey) {
            return null;
        }
        return decodeURIComponent(document.cookie.replace(new RegExp("(?:(?:^|.*;)\\s*" + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*([^;]*).*$)|^.*$"), "$1")) || null;
    },
    setItem: function (sKey, sValue, vEnd, sPath, sDomain, bSecure) {
        if (!sKey || /^(?:expires|max\-age|path|domain|secure)$/i.test(sKey)) {
            return false;
        }
        var sExpires = "";
        if (vEnd) {
            switch (vEnd.constructor) {
                case Number:
                    sExpires = vEnd === Infinity ? "; expires=Fri, 31 Dec 9999 23:59:59 GMT" : "; max-age=" + vEnd;
                    break;
                case String:
                    sExpires = "; expires=" + vEnd;
                    break;
                case Date:
                    sExpires = "; expires=" + vEnd.toUTCString();
                    break;
            }
        }
        document.cookie = encodeURIComponent(sKey) + "=" + encodeURIComponent(sValue) + sExpires + (sDomain ? "; domain=" + sDomain : "") + (sPath ? "; path=" + sPath : "") + (bSecure ? "; secure" : "");
        return true;
    },
    removeItem: function (sKey, sPath, sDomain) {
        if (!this.hasItem(sKey)) {
            return false;
        }
        document.cookie = encodeURIComponent(sKey) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT" + (sDomain ? "; domain=" + sDomain : "") + (sPath ? "; path=" + sPath : "");
        return true;
    },
    hasItem: function (sKey) {
        if (!sKey) {
            return false;
        }
        return (new RegExp("(?:^|;\\s*)" + encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=")).test(document.cookie);
    },
    keys: function () {
        var aKeys = document.cookie.replace(/((?:^|\s*;)[^\=]+)(?=;|$)|^\s*|\s*(?:\=[^;]*)?(?:\1|$)/g, "").split(/\s*(?:\=[^;]*)?;\s*/);
        for (var nLen = aKeys.length, nIdx = 0; nIdx < nLen; nIdx++) {
            aKeys[ nIdx ] = decodeURIComponent(aKeys[ nIdx ]);
        }
        return aKeys;
    }
};

var Publisher_Theme = (function ($) {
    "use strict";

    return {

        init: function () {

            // Pretty Photo Settings
            this.prettyPhotoSettings = {
                social_tools: false,
                show_title: false,
                deeplinking:false,
                markup: '<div class="pp_pic_holder"> ' +
                '<div class="ppt"></div> ' +
                '<div class="pp_content_container"> ' +
                '<div class="pp_content"> ' +
                '<div class="pp_loaderIcon"></div> ' +
                '<div class="pp_fade"> ' +
                '<a href="#" class="pp_expand" title="' + publisher_theme_global_loc.translations.lightbox_expand + '"></a> ' +
                '<a class="pp_close" href="#" title="' + publisher_theme_global_loc.translations.lightbox_close + '"></a> ' +
                '<div class="pp_hoverContainer"> ' +
                '<a class="pp_next" href="#"><i class="fa fa-chevron-right"></i></a> ' +
                '<a class="pp_previous" href="#"><i class="fa fa-chevron-left"></i></a> ' +
                '</div> ' +
                '<div id="pp_full_res"></div> ' +
                '<div class="pp_details"> ' +
                '<div class="pp_nav"> ' +
                '<a href="#" class="pp_arrow_previous"><i class="fa fa-backward"></i></a> ' +
                '<p class="currentTextHolder">0/0</p> ' +
                '<a href="#" class="pp_arrow_next"><i class="fa fa-forward"></i></a> ' +
                '</div> ' +
                '<p class="pp_description"></p> ' +
                '</div> ' +
                '</div> ' +
                '</div> ' +
                '</div> ' +
                '</div> ' +
                '<div class="pp_overlay"></div>',
                gallery_markup: '<div class="pp_gallery"> ' +
                '<a href="#" class="pp_arrow_previous"><i class="fa fa-chevron-left"></i></a> ' +
                '<div> ' +
                '<ul> ' +
                '{gallery} ' +
                '</ul> ' +
                '</div> ' +
                '<a href="#" class="pp_arrow_next"><i class="fa fa-chevron-right"></i></a> ' +
                '</div>'
            };
            // Setup Responsive Header
            this.setup_responsive_header();

            // Setup Back To Top Button
            this.back_to_top();

            this.handleAjaxifiedComments();

            this.setup_post();
            var bodyClasses = $(document.body).attr('class'),
                matches     = bodyClasses.toString().match(/\bpostid\-(\d+)\b/i);
            if (matches)
                this.handleInfinitySinglePostLoading(matches[ 1 ]);

            this.woo_commerce();

            this.visual_composer();

            this.init_off_canvas_menu();

            this.init_more_stories();

            this.init_continue_reading();
        },


        /**
         * Define elements that use elementQuery on local/cross domain
         */
        fix_element_query: function () {

            if (typeof elementQuery != 'function') {
                return;
            }

            elementQuery({
                ".listing": {
                    "max-width": [ "450px", "560px", "900px", "1000px" ]
                },
                ".listing-item-blog": {
                    "max-width": [ "420px", "560px" ]
                },
                ".listing-modern-grid": {
                    "max-width": [ "980px", "780px", "620px", "480px", "370px" ]
                },
                ".listing-mg-3-item": {
                    "max-width": [ "300px", "250px" ]
                },
                ".listing-mg-4-item": {
                    "max-width": [ "250px" ]
                },
                ".bs-slider": {
                    "max-width": [ "370px" ]
                },
                ".bs-slider-item": {
                    "max-width": [ "780px", "520px", "370px" ]
                },
                ".listing-item-classic": {
                    "max-width": [ "380px" ]
                },
                ".bs-shortcode-row": {
                    "max-width": [ "450px", "600px", "700px" ]
                }
            });

        },

        is_rtl: function () {
            return $('body').hasClass('rtl');
        },

        /**
         * Setup Menu
         */
        setup_responsive_header: function () {

            // Show/Hide Menu Box
            $('.responsive-header .menu-container .menu-handler').click(function (e) {

                e.preventDefault();

                var $container = $(this).parent();

                // Hide search box
                if ($container.hasClass('close')) {
                    $('.responsive-header .search-container').removeClass('open').addClass('close');
                }

                $container.toggleClass('open').toggleClass('close');

            });


            // Show/Hide Search Box
            $('.responsive-header .search-container .search-handler').click(function (e) {

                e.preventDefault();

                var $container = $(this).parent();

                // Hide menu box
                if ($container.hasClass('close')) {
                    $('.responsive-header .menu-container').removeClass('open').addClass('close');
                }

                $container.toggleClass('open').toggleClass('close');

            });

            // Clone main menu if is not available specifiably for responsive
            if ($('.responsive-header .menu-container .menu-box').is(':empty')) {

                // Appends cloned menu to page
                $('.responsive-header .menu-container .menu-box').html($('.main-menu.menu').clone().removeClass('main-menu').addClass('resp-menu').prop('id', 'resp-navigation'));
            }

            // remove abandoned mega menus
            $('.responsive-header .menu-container .menu-box .mega-menu.mega-grid-posts').remove();

            // Add show children list button
            $('.responsive-header .menu-container .resp-menu li > a').each(function () {

                var $li = $(this).parent();

                if (!$li.hasClass('menu-item-mega-grid-posts') && $li.children("ul,.mega-menu").length > 0) {
                    $li.append('<span class="children-button"><i class="fa fa-angle-down"></i></span>');
                }

                if ($li.hasClass('menu-item-mega-tabbed-grid-posts')) {
                    $li.find('.tab-content').remove();
                    var child_tabs = $li.find('.tabs-section').removeClass('tabs-section').addClass('sub-menu').clone();
                    $li.find('.mega-menu.tabbed-grid-posts').remove();
                    child_tabs.find('li a').removeAttr('data-target').removeAttr('data-deferred-init').removeAttr('data-toggle').removeAttr('data-deferred-event').removeAttr('class');
                    $li.append(child_tabs);
                }
            });

            // Show/Hide children list on click "children-button"
            $('.responsive-header .menu-container .resp-menu .children-button').click(function () {

                $(this).closest('li').toggleClass('open-sub');

                if ($(this).find('.fa-angle-down').length) {
                    $(this).find('.fa-angle-down').removeClass('fa-angle-down').addClass('fa-angle-up');
                } else {
                    $(this).find('.fa-angle-up').removeClass('fa-angle-up').addClass('fa-angle-down');
                }

                return false;
            });

            $('.responsive-header-container').bsPinning();


            $('.better-newsticker').betterNewsticker({
                control_nav: true
            });

        },


        refreshLazyImages: function() {

            if(typeof bsLazy === 'object') {
                bsLazy.revalidate();
            }
        },
        /**
         * Setup Menu
         */
        setup_menu: function () {

            var self = this;

            $('ul.menu.bsm-pure').addClass('bsm-initialized').removeClass('bsm-pure');

            // Trick to make menu animations awesome
            var bsm_helper_function_enter; // enter function for add bsm-enter
            var bsm_helper_function_leave; // enter function for add bsm-leave
            $('.menu.bsm-initialized li.menu-item-has-children').each(function () {

                var $this = $(this);

                if ($this.is(':hover')) {
                    $this.addClass('bsm-enter');
                } else {
                    $this.addClass('bsm-leave');
                }

            });

            $(document).on("mouseenter", 'li.menu-item-has-children', function () {
                var $this = $(this),
                    $that = $this;

                $this.removeClass('bsm-leave');

                bsm_helper_function_enter = function () {
                    $that.closest('.menu-item-has-children').addClass('bsm-enter');
                };

                setTimeout(
                    function () {
                        bsm_helper_function_enter();
                    }, 1);

                self.refreshLazyImages();

            }).on("mouseleave", 'li.menu-item-has-children', function () {
                var $this = $(this),
                    $that = $this;

                $this.removeClass('bsm-enter');

                bsm_helper_function_leave = function () {
                    $that.addClass('bsm-leave');
                };

                setTimeout(function () {
                    bsm_helper_function_leave();
                }, 200);
            }).on("afterChange",".bs-slider-items-container", function() {
                self.refreshLazyImages();
            });

            var _sticky_header_classes = '' +
                '#header .main-menu-wrapper,' +
                ' .site-header.header-style-5.full-width > .content-wrap,' +
                ' .site-header.header-style-5.boxed > .content-wrap > .container,' +
                ' .site-header.header-style-6.full-width > .content-wrap,' +
                ' .site-header.header-style-6.boxed > .content-wrap > .container,' +
                ' .site-header.header-style-8.full-width > .content-wrap,' +
                ' .site-header.header-style-8.boxed > .content-wrap > .container';

            var current_header_id = $('.site-header').attr("class").match(/header-style-[\w-]*\b/);
            if (current_header_id) {

                // Sticky main menu initializer
                if ($('body').hasClass('main-menu-sticky-smart'))
                    $(_sticky_header_classes).bsPinning({
                        smart: true,
                        wrapper_class: 'bspw-' + current_header_id[ 0 ]
                    });
                else if ($('body').hasClass('main-menu-sticky'))
                    $(_sticky_header_classes).bsPinning({
                        smart: false,
                        wrapper_class: 'bspw-header bspw-' + current_header_id[ 0 ]
                    });
            }

        },


        /**
         * Setup Sliders
         */
        setup_sliders: function () {

            if (!$.fn.flexslider) {
                return;
            }

            $('.gallery-slider .better-slider').flexslider({
                namespace: "better-",
                animation: "fade",
                controlNav: false,
                smoothHeight: true,
                animationSpeed: "200",
                start: function (slider) {
                    Publisher_Theme.fire_resize();
                }
            }).find('.better-control-nav').addClass('square');


            $('.bs-shortcode.bs-slider > .better-slider, .bs-shortcode.bs-instagram > .better-slider, .bs-shortcode.bs-dribbble > .better-slider, .bs-shortcode.bs-flickr > .better-slider').each(function () {
                var $this = $(this);

                $this.flexslider({
                    namespace: "better-",
                    animation: $this.data('animation'),
                    slideshowSpeed: $this.data('slideshowSpeed'),
                    animationSpeed: $this.data('animationSpeed'),
                    animationLoop: true,
                    directionNav: true,
                    pauseOnHover: true,
                    start: function (slider) {
                        jQuery(slider).find(".better-active-slide").addClass("slider-content-shown");
                        Publisher_Theme.fire_resize();
                    },
                    before: function (slider) {
                        jQuery(slider).find(".slider-content-shown").removeClass("slider-content-shown");
                    },
                    after: function (slider) {
                        jQuery(slider).find(".better-active-slide").addClass("slider-content-shown");
                    }
                }).find('.better-control-nav').addClass('circle');
            });

        },


        /**
         * Setup Video Players
         */
        setup_video_players: function () {

            $('.single-featured, .the-content, .sidebar, .post, .bs-embed, .entry-content').fitVids({
                ignore: '.bsp-player > iframe'
            });

        },

        /**
         * Handy function to sure the resize is fired.
         */
        fire_resize: function () {
            if (document.createEvent) { // W3C
                var ev = document.createEvent('Event');
                ev.initEvent('resize', true, true);
                window.dispatchEvent(ev);
            }
            else { // IE
                var element = document.documentElement;
                var event   = document.createEventObject();
                element.fireEvent("onresize", event);
            }
        },


        /**
         * Small style fixes with jquery that can't done with css!
         */
        small_style_fixes: function () {

            // Show/Hide Topbar search box
            $('.site-header .search-container .search-handler').click(function () {

                $(this).closest('.main-menu-container').toggleClass('search-open').toggleClass('search-close');

                var $search_container = $(this).closest('.search-container');

                $search_container.toggleClass('open').toggleClass('close');

                // Set focus to search input
                if ($search_container.hasClass('open')) {
                    $(this).find('.fa').removeClass('fa-search').addClass('fa-close')
                    $search_container.find('.search-field').focus();
                } else {
                    $(this).find('.fa').addClass('fa-search').removeClass('fa-close')
                    $search_container.find('.search-field').focusout();
                }

            });
            $(document).on('keyup', function (e) {
                if (e.keyCode == 27 && $('.search-container.open').length > 0) {

                    var $search_container = $('.site-header .search-container'),
                        $search_handler   = $search_container.find('.search-handler');

                    $search_container.removeClass('open').addClass('close');

                    $('.main-menu-container.search-open').removeClass('search-open').addClass('search-close');

                    if ($search_container.hasClass('open')) {
                        $search_handler.find('.fa').removeClass('fa-search').addClass('fa-close')
                        $search_container.find('.search-field').focus();
                    } else {
                        $search_handler.find('.fa').addClass('fa-search').removeClass('fa-close')
                        $search_container.find('.search-field').focusout();
                    }
                }
            });


            // Show/Hide Topbar search box
            $('.site-header .shop-cart-container').hover(function (e) {

                e.preventDefault();

                $(this).closest('.main-menu-container').toggleClass('cart-open').toggleClass('cart-close');

                var $search_container = $(this);

                $search_container.toggleClass('open').toggleClass('close');

            });

            // calendar widget fix
            $(".widget.widget_calendar table td a").each(function () {
                $(this).parent().addClass('active-day');
            });

            // IE 10 detection for style fixing
            if ($.browser.msie && $.browser.version == 10) {
                $("html").addClass("ie ie10");
            }

            // add term class to tab heading
            $('.section-heading.multi-tab a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

                if ($(this).hasClass('active')) {
                    e.preventDefault();
                    return;
                }

                if (typeof $(e.target).parent().attr('class') == 'undefined') {
                    return true;
                }

                var $parent    = $(e.target).closest('.section-heading'),
                    classNames = $(e.target).find('.h-text').attr('class').split(" ");

                var selected_tab_term = '';

                // find term class
                jQuery.each(classNames, function (index, value) {
                    if (value.match(/main-term-/)) {
                        selected_tab_term = value;
                        return false;
                    }
                });

                // remove term classes from parent
                jQuery.each($parent.attr('class').split(" "), function (index, value) {
                    if (value.match(/main-term-/)) {
                        $parent.removeClass(value);
                    }
                });

                $parent.addClass(selected_tab_term).find('a.active').removeClass('active');

                $(this).addClass('active');
            });

            // Fix for element query
            $('[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                Publisher_Theme.fire_resize();
            });
            $('[data-vc-accordion]').on('show.vc.accordion', function (e) {
                Publisher_Theme.fire_resize();
            });
            $(".panel-collapse").on("shown.bs.collapse", function (e) {
                Publisher_Theme.fire_resize();
            });
            $(".bs-accordion-shortcode .panel-heading a").on("click", function (e) {
                if (!$(this).closest('.panel-heading').hasClass('active'))
                    $(this).closest('.panel').addClass('open');
            });
            $(".panel-collapse").on("hide.bs.collapse", function (e) {
                $(e.target).closest('.panel').removeClass('open');
            });


            // BS_Listing Tabs animation fix
            $('.bs-listing a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                var $_target = $($(this).attr('href'));
                if ($_target.hasClass('active'))
                    return;
                $(this).closest('.bs-listing').find('.tab-pane').removeClass('bs-tab-animated');
                $_target.addClass('bs-tab-animated');
            });

            // Tabbed grid posts
            $('.tabbed-grid-posts .tabs-section > li > a').click(function () {
                if ($(this).attr('href') != '#') window.location = $(this).attr('href');
            }).hover(function () {
                $(this).tab('show');
            });
            $('.tabbed-grid-posts .tabs-section > li > a[data-toggle="tab"]').on('show.bs.tab', function (e) {
                var $_target = $($(this).data('target'));
                if ($_target.hasClass('active'))
                    return;
                $(this).closest('.tabbed-grid-posts').find('.tab-pane').removeClass('bs-tab-animated');
                $_target.addClass('bs-tab-animated');
            });

            // move to content
            $('.move-to-content .fa').click(function () {
                $('body,html').animate({
                        scrollTop: $('.content-column').offset().top - 25
                    }, 700
                );
            });

            $('.post-tp-4-header,.post-tp-5-header').each(function () {
                var $item          = $(this);
                var $item_parallax = $(this).find('.post-header-title');

                jQuery(window).scroll(function () {

                    var scroll        = jQuery(window).scrollTop();
                    var header_height = $item.height();

                    if (scroll < $item.offset().top || scroll > $item.offset().bottom) {
                        $item_parallax
                            .css({'-webkit-transform': 'translate3d(0px, 0px, 0px)'})
                            .css({'transform': 'translate3d(0px, 0px, 0px)'})
                            .css({'opacity': '1'});
                        return;
                    }

                    $item_parallax
                        .css({'-webkit-transform': 'translate3d(0px, ' + Math.ceil(( scroll - ( $item.offset().top ) ) / 5.3) + 'px, 0px)'})
                        .css({'transform': 'translate3d(0px, ' + Math.ceil(( scroll - ( $item.offset().top ) ) / 5.3) + 'px, 0px)'})
                        .css({'opacity': ( ( scroll - header_height ) / 333.333 ) * -1});

                });
            });

            $(".footer-instagram-3 .bs-instagram-photos").simplyScroll({frameRate: 70});

            // Login shortcode
            $('.remember-label').on('click', function () {
                $(this).siblings('input[type=checkbox]').click();
            });

            $('.modal.sign-in-modal').css({'display' : 'block', 'visibility':'hidden'});
            $('.bs-shortcode.bs-login-shortcode').each(function () {
                var $item = $(this);

                $item.attr('style', '');

                var login_height = $item.find('.bs-login-panel:first-child').outerHeight(),
                    reset_height = $item.find('.bs-login-panel.bs-login-reset-panel').outerHeight();

                $item.height(login_height)
                    .find('.bs-login.bs-type-login').height(login_height)
                    .find('.bs-login-panel').height(login_height);

                $item.find('.bs-login-panel.bs-login-reset-panel .bs-login-reset-panel-inner').css({
                    'position': 'absolute',
                    'top': '50%',
                    'width': '100%',
                    'margin-top': '-' + ( reset_height / 2 ) + 'px',
                });

            });
            $('.modal.sign-in-modal').css({'display' : 'none', 'visibility' : 'visible'});
            $('.bs-login .go-login-panel, .bs-login .go-reset-panel').click(function (e) {
                e.preventDefault();
                var $current_panel = $(this).closest('.bs-login-panel'),
                    $next_panel    = $current_panel.siblings('.bs-login-panel');

                $current_panel.removeClass('bs-current-login-panel');
                $next_panel.addClass('bs-current-login-panel');
            });

            // Single comments
            $('.post-share.single-post-share .post-share-btn.post-share-btn-comments').click(function () {
                $('body,html').animate({
                        scrollTop: $('form.comment-form').offset().top - 100
                    }, 1000
                );
            });

        },


        /**
         * Initializes sticky columns
         */
        init_sticky_columns: function () {

            // disabled on mobile screens
            if (!$.fn.hcSticky || window.innerWidth <= 700) {
                return;
            }

            // Sticky sidebars and columns
            var sticky_config             = {
                    wrapperClassName: 'wrapper-sticky'
                },
                $sticky_sidebars          = $([]),
                sticky_sidebars_destroyed = false,
                $body                     = $('body');

            if ($body.hasClass('main-menu-sticky-smart') || $body.hasClass('main-menu-sticky')) {
                sticky_config.top = $('#header .main-menu-wrapper').height();
            }

            if ($body.hasClass('active-sticky-sidebar') && $(window).width() > 780) {

                // All Visual Composer columns that have widgetized add-on and are not sticky
                $sticky_sidebars = $sticky_sidebars.add(
                    $('.wpb_widgetised_column').closest('.wpb_column').not(".sticky-column")
                );

                // all sidebar columns
                $sticky_sidebars = $sticky_sidebars.add($('.sidebar-column'));
            }

            // All columns with ".sticky-column" class
            $sticky_sidebars = $sticky_sidebars.add($('.wpb_column.sticky-column'));

            // make sticky all
            $sticky_sidebars.each(function (i, el) {
                var $el    = $(el),
                    config = $.extend({}, sticky_config);

                if ($el.hasClass('wpb_column')) {

                    var column_classes = [
                        'vc_hidden-lg',
                        'vc_hidden-md',
                        'vc_hidden-sm',
                        'vc_hidden-xs',
                        '.hidden-lg',
                        '.hidden-md',
                        '.hidden-sm',
                        '.hidden-xs'
                    ];

                    column_classes.forEach(function (item) {
                        if ($el.hasClass(item)) {
                            // $el.removeClass(item);
                            config.wrapperClassName += ' ' + item;
                        }
                    });
                }

                $el.hcSticky(config);
            });

            //Disable sticky if user resized browser!
            $(window).on('resize.bs-sticky-column', function () {
                if (window.innerWidth <= 780 && !sticky_sidebars_destroyed) {
                    $sticky_sidebars.each(function (i, el) {
                        $(el).hcSticky('off')
                             .hcSticky('destroy')
                             .data('hcSticky-destroy', true)
                             .removeAttr('style');

                        sticky_sidebars_destroyed = true;
                    });
                }
            });


            // Fix for DFP appear and disappear bug
            // Reference: http://stackoverflow.com/questions/33443518/google-pubads-appear-and-then-disappear
            if( typeof googletag == "object" && typeof googletag.pubads == "function" && typeof googletag.pubads().refresh == "function" ){
                googletag.pubads().refresh();
            }

        },


        /**
         * BetterStudio Editor Shortcodes Setup
         */
        betterstudio_editor_shortcodes: function () {

            $('.bs-accordion-shortcode').on('show.bs.collapse', function (e) {
                $(e.target).prev('.panel-heading').addClass('active');
            }).on('hide.bs.collapse', function (e) {
                $(e.target).prev('.panel-heading').removeClass('active');
            });

        },


        /**
         * Back to top button
         */
        back_to_top: function () {

            var $back_to_top = $('.back-top');

            if ($back_to_top.length == 0)
                return;

            $back_to_top.click(function () {
                $('body,html').animate({
                        scrollTop: 0
                    }, 700
                );
            });

            $(window).scroll(function () {
                ( $(this).scrollTop() > 300 ) ? $back_to_top.addClass('is-visible') : $back_to_top.removeClass('is-visible fade-out1 fade-out2 fade-out3 fade-out4');

                switch (true) {

                    case ( $(this).scrollTop() > 2400 ):
                        $back_to_top.addClass('fade-out4');
                        break;

                    case ( $(this).scrollTop() > 1700 ):
                        $back_to_top.removeClass('fade-out3').addClass('fade-out3');
                        break;

                    case ( $(this).scrollTop() > 1000 ):
                        $back_to_top.removeClass('fade-out4 fade-out3').addClass('fade-out2');
                        break;

                    case ( $(this).scrollTop() > 500 ):
                        $back_to_top.removeClass('fade-out4 fade-out3 fade-out2').addClass('fade-out1');
                        break;
                }

            });

        },


        /**
         * Setup Popup
         */
        popup: function () {

            // If light box is not active
            if (!$('body').hasClass('active-light-box')) {
                return;
            }

            // disabled on mobile screens
            if (!$.fn.prettyPhoto || $(window).width() < 700) {
                return;
            }

            var not_active_classes = publisher_theme_global_loc.lightbox.not_classes.split(' ');

            var filter_only_images = function () {

                var $this = $(this);

                if (!$this.attr('href'))
                    return false;

                if (typeof $this.data('not-rel') != 'undefined')
                    return false;

                var _disabled = false;
                if (not_active_classes.length > 0) {
                    not_active_classes.forEach(function (i, el_class) {

                        if (i == '') {
                            return;
                        }

                        if ($this.hasClass(i)) {
                            _disabled = true;
                        }
                    })
                }

                if (_disabled) {
                    return false;
                }

                return $this.attr('href').match(/\.(jp?g|png|bmp|jpeg|gif)((\?.+$)|$)/);
            };

            $('.entry-content a,.single-featured a.open-lightbox').has('img').filter(filter_only_images).attr('rel', 'prettyPhoto');

            var gallery_id = 1;

            $('.entry-content .gallery,.entry-content .tiled-gallery').each(function () {

                $(this).find('a').has('img').filter(filter_only_images).attr('rel', 'prettyPhoto[gallery_' + gallery_id + ']');

                gallery_id++;

            });

            $("a[rel^='prettyPhoto']").prettyPhoto(Publisher_Theme.prettyPhotoSettings);

        },


        /**
         * Setup Gallery
         */
        gallery: function () {

            if (!$.fn.fotorama) {
                return;
            }

            var $fotoramaDiv = jQuery('.fotorama').fotorama({
                width: '100%',
                loop: true,
                margin: 10,
                thumbwidth: 85,
                thumbheight: 62,
                thumbmargin: 9,
                transitionduration: 800,
                arrows: false,
                click: false,
                swipe: true
            }).on('fotorama:show', function (e, fotorama, extra) {

                var $gallery = $(this).closest('.better-gallery');

                $gallery.find('.count .current').html(fotorama.activeFrame.i);

            });

            // Activate light box gallery if active
            if ($('body').hasClass('active-light-box') && $.fn.prettyPhoto || $(window).width() < 700) {

                jQuery('.better-gallery').on('click', '.slide-link', function () {

                    event.preventDefault();

                    var $gallery   = $(this).closest('.better-gallery');
                    var gallery_id = $gallery.data('gallery-id');

                    var pps = Publisher_Theme.prettyPhotoSettings;

                    pps.changepicturecallback = function () {
                        $('#gallery-' + gallery_id).find('.fotorama').data('fotorama').show($('.pp_gallery').find('li').index($('.selected')));
                    };

                    $.fn.prettyPhoto(pps);

                    $.prettyPhoto.open(window[ "prt_gal_img_" + gallery_id ], window[ "prt_gal_cap_" + gallery_id ], window[ "prt_gal_cap_" + gallery_id ]);

                    $.prettyPhoto.changePage($('#gallery-' + gallery_id).find('.fotorama').data('fotorama').activeFrame.i - 1);

                    return false;
                });

            }

            // Next Button
            jQuery('.better-gallery .gallery-title .next').click(function () {

                var fotorama = $(this).closest('.better-gallery').find('.fotorama').data('fotorama');
                fotorama.show('>');

            });

            // Previous Button
            jQuery('.better-gallery .gallery-title .prev').click(function () {

                var fotorama = $(this).closest('.better-gallery').find('.fotorama').data('fotorama');
                fotorama.show('<');

            });

        },

        bsPrettyTabs: function () {

            // Collect menu items into "more"
            if (publisher_theme_global_loc.main_menu.more_menu === 'enable') {

                var haveNavItemsIcon = $("#header").hasClass('header-style-6');

                var moreContainer = '<a href="#" class="bs-pretty-tabs-more">';
                if (haveNavItemsIcon) {
                    moreContainer += '<i class="bf-icon fa fa-bars" aria-hidden="true"></i>';
                }
                moreContainer += publisher_theme_global_loc.translations.tabs_more + '</a><ul class="sub-menu bs-pretty-tabs-elements"></ul>';

                $('#main-navigation').parent().bsPrettyTabs({
                    menuContainerPosition: 'end',
                    menuContainerTag: 'li',
                    itemsWrapperSelector: '#main-navigation',
                    moreContainer: moreContainer,
                    initWrapperContainer: function ($wrapper) {
                        $wrapper.addClass('menu-item-has-children better-anim-fade');

                        if (haveNavItemsIcon) {
                            $wrapper.addClass('menu-have-icon menu-icon-type-fontawesome');
                        }

                        return $wrapper;
                    },
                    styleChangesAt: [ 992, 780 ]
                });
            }

            $('.section-heading.multi-tab').bsPrettyTabs({
                moreContainer: '<a href="#" class="bs-pretty-tabs-more other-link"><span class="h-text">' + publisher_theme_global_loc.translations.tabs_all + ' <i class="fa fa-caret-down" aria-hidden="true"></i></span></a><div class="bs-pretty-tabs-elements"></div>',
                mustDisplayClass: 'main-link',
                getContainerWidth: function (width) {
                    return width * 0.8;
                }
            });

            $("#top-navigation").bsPrettyTabs({
                menuContainerPosition: 'end',
                menuContainerTag: 'li',
                moreContainer: '<a href="#" class="bs-pretty-tabs-more">More <i class="fa fa-angle-down" aria-hidden="true"></i></a><ul class="bs-pretty-tabs-elements sub-menu"></ul>',
                getContainerWidth: function (width) {
                    return width * 0.9;
                }
            });
            $(".topbar").addClass('use-pretty-tabs');
        },

        /**
         * Handle pagination elements
         *
         * @param context
         */
        bsPagination: function (context) {

            if (!$.fn.Better_Ajax_Pagination) {
                return;
            }

            var self = this;

            $('.bs-ajax-pagination', context).parent()
                                             .Better_Ajax_Pagination({
                                                 after_response: function () {
                                                     //self.refreshLazyImages();
                                                 }
                                             });

        },


        /**
         *  Initialize lazy loading
         */
        initLazyLoad: function () {

            // Images
            if (typeof Blazy === "function") {

                bsLazy = new Blazy({
                    selector: '.img-holder,.img-cont,.bs-lazy,.bs-lazy-iframe-wrapper iframe,.wp-video-shortcode,img[data-src],iframe[data-src]',
                    loadInvisible:true,
                    successClass: ' ',
                    success: function (el) {

                        el.className = el.className + ' b-load-ready';
                        setTimeout(function () {
                            el.className = el.className.replace('b-load-ready', '') + ' b-loaded';
                        }, 100);
                    },
                    itemLoaded: function() {
                        if($.fn.fitVids) {
                            $(this.parentNode).fitVids();
                        }
                    }
                });
            }

            function loadFbLikeBox(locale) {

                locale = locale || 'en_US';

                (function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) return;
                    js = d.createElement(s);
                    js.id = id;
                    js.src = "//connect.facebook.net/"+locale+"/sdk.js#xfbml=1&version=v2.4";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
            }
            function loadGpBox(lang) {
                if (lang !== '') {
                    window.___gcfg = {lang: lang};
                }
                (function () {
                    var po = document.createElement('script');
                    po.type = 'text/javascript';
                    po.async = true;
                    po.src = 'https://apis.google.com/js/plusone.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(po, s);
                })();
            }
            var likeBoxExists = $("#fb-root").length;

            var $GPlus = $(".google-plus-block");

            // Blocks
            if (typeof OnScreen === 'function') {

                var os = new OnScreen({
                    tolerance: -100,
                    container: window
                });

                if(likeBoxExists) {

                    os.on('enter', ".fb-page", function(el) {
                        loadFbLikeBox(el.getAttribute('data-locale'));
                        os.off('enter', ".fb-page");
                    });
                }

                if( $GPlus.length  ) {

                    os.on('enter', ".google-plus-block", function(el) {
                        loadGpBox(el.getAttribute('data-locale'));
                        os.off('enter', ".google-plus-block");
                    });
                }
            } else {

                if(likeBoxExists) {
                    loadFbLikeBox($(".fb-page").data('locale'));
                }
                if($GPlus.length) {
                    loadGpBox($GPlus.data('locale'));
                }
            }
        },

        /**
         * Initialize and handle deferred blocks
         */
        initDeferredElements: function () {

            if (!$.fn.Better_Deferred_Loading) {
                return;
            }

            var self = this;
            $.fn.Better_Deferred_Loading({
                /**
                 * Handle new block pagination if exits
                 * @param $wrapper {jQuery}  new block wrapper jquery object
                 */
                afterSuccessDeferredAjax: function ($wrapper) {
                    self.bsPagination($wrapper);

                    self.refreshLazyImages();
                }
            });
        },

        handleAjaxifiedComments: function () {
            $(document).on('click', '.comment-ajaxified-placeholder', function (e) {
                e.preventDefault();

                var $this    = $(this),
                    $wrapper = $this.closest('.comments-template');

                $this.hide();
                var $loading = $('<div></div>', {
                    'class': 'deferred-loading-container',
                    height: 40
                });
                $loading.append('<div class="bs-pagin-loading-wrapper">' + publisher_theme_global_loc.loading + '</div>');
                $loading.appendTo($wrapper);

                $.ajax({
                        url: publisher_theme_global_loc.ajax_url,
                        type: 'post',
                        dataType: 'json',
                        data: $.extend(
                            $this.data(),
                            {
                                action: 'ajaxified-comments'
                            }
                        )
                    })
                    .done(function (res) {

                        var $parent = $wrapper.parent();
                        $wrapper.replaceWith(res.rawHTML);
                        $('.deferred-loading-container', $wrapper).remove();
                        $(document).trigger('ajaxified-comments-loaded', [ $wrapper, res ]);

                        if($.fn.Better_Deferred_Loading) {

                            $.fn.Better_Deferred_Loading({
                                context: $parent.find('.bs-comments-wrapper')
                            });
                        }
                    });
            });
        },


        handleInfinitySinglePostLoading: function (post_id) {

            if (!$('body').hasClass('single') || !$('body').hasClass('infinity-related-post'))
                return;

            if (typeof OnScreen !== 'function')
                return;

            var triggerEventID    = 'infinity-single-post-loading',
                $wrapper          = $('.content-column'),
                $firstPostWrapper = $wrapper.find('.single-post-content');
            var allPosts          = [
                    parseInt($firstPostWrapper.attr('id').replace(/[^0-9\.]/g, ''))
                ],
                self              = this,
                xhr;
            var os                = new OnScreen({
                    tolerance: -500,
                    container: window
                }),
                os2               = new OnScreen({
                    tolerance: 100,
                    container: window
                }), lastEnteredPost;


            function appendHtmlIfNeeded() {
                if (!$(triggerEventID).length) {
                    $("<div></div>", {
                        id: triggerEventID
                    }).appendTo($wrapper);
                }
            }

            function attachScrollIntoViewEvent(data) {

                var selector = ".content-column .post.post-" + data.post_id,
                    $element = $(selector);

                $element.data('post-permalink', data.permalink);
                $element.data('post-id', data.post_id);
                $element.data('post-count-calc', data.counter);

                os2.on('enter', selector, function (post) {
                    var $post         = $(post),
                        postId        = $post.data('post-id'),
                        count         = $post.data('post-count-calc'),
                        postPermalink = $post.data('post-permalink');

                    if (lastEnteredPost === postId) {
                        return false;
                    }

                    if (postPermalink) {
                        history.pushState({}, undefined, postPermalink);
                    }

                    if (count) {

                        // Send view hit to google analytics
                        if (typeof ga === "function") {
                            var a = $("<a></a>", {href: postPermalink})
                            ga('send', 'pageview', a[ 0 ].pathname);
                        }

                        $post.data('post-count-calc', false);
                    }

                    lastEnteredPost = postId;
                });
            }

            function onScreenEventHandler(el) {
                unRegisterOnScreenEvent();

                var $infContainer = $(el),
                    $loading      = $('<div></div>', {
                        'class': 'deferred-loading-container',
                        height: 200
                    });
                $loading.append('<div class="bs-pagin-loading-wrapper">' + publisher_theme_global_loc.loading + '</div>');
                $loading.appendTo($infContainer);

                if (xhr) {
                    xhr.abort();
                }

                xhr = $.ajax({
                           url: publisher_theme_global_loc.ajax_url,
                           type: 'post',
                           dataType: 'json',
                           data: {
                               action: 'ajax-get-post',
                               post_ID: post_id,
                               loaded_posts: allPosts
                           }
                       })
                       .done(function (res) {
                           $('.deferred-loading-container', $infContainer).remove();

                           if (res.rawHTML) {
                               $infContainer.before(res.rawHTML);
                           }

                           if (res.loaded_posts) {
                               allPosts = allPosts.concat(res.loaded_posts);
                           }

                           if (res.haveNext) {
                               registerOnScreenEvent();
                           }

                           self.setup_post();

                           /**
                            * Init appended post enter event
                            */
                           if (res.posts_info) {

                               res.posts_info.forEach(function (obj) {
                                   attachScrollIntoViewEvent({permalink: obj.link, post_id: obj.id, counter: true});
                               });
                           }
                       });
            }

            function registerOnScreenEvent() {
                os.on('enter', "#" + triggerEventID, onScreenEventHandler);
            }

            function unRegisterOnScreenEvent() {
                os.off('enter', "#" + triggerEventID);
            }

            appendHtmlIfNeeded();
            registerOnScreenEvent();

            /**
             * init exits post enter event
             */
            attachScrollIntoViewEvent({permalink: window.location.href, post_id: post_id});

        },

        setup_post: function () {

            this.initLazyLoad();

            // Setup gallery
            this.gallery();

            // Setup Sliders
            this.setup_sliders();

            // Setup Video Players
            this.setup_video_players();

            // Small Fixes With jQuery For Elements Styles
            this.small_style_fixes();

            // Initializes sticky columns
            this.init_sticky_columns();

            // BetterStudio Editor Shortcodes Setup
            this.betterstudio_editor_shortcodes();

            // Setup sticky menu
            this.setup_menu();

            // Setup Popup
            this.popup();

            // Define elements that use elementQuery
            this.fix_element_query();

            this.bsPrettyTabs();

            this.bsPagination();

            this.initDeferredElements();
        },

        woo_commerce: function () {

            // Ads highlighted to custom tab (section-heading)
            var _bs_inside_css_class_event_flag = false;
            $(".woocommerce div.product .woocommerce-tabs ul.tabs li").bind('cssClassChanged', function () {

                // flag to stop infinity calls of css class
                if (_bs_inside_css_class_event_flag == true) {
                    return;
                } else {
                    _bs_inside_css_class_event_flag = true;
                }

                if ($(this).hasClass('active')) {
                    $(this).closest('ul.tabs').find('a.active').removeClass('active');
                    $(this).find('a').addClass('active');
                }

                _bs_inside_css_class_event_flag = false;
            });

            // Update Menu Cart  Badge Count
            $(window).on('added_to_cart', function (e, data, data2) {

                if (typeof data[ 'total-items-in-cart' ] != 'undefined' && $('.main-menu-container .shop-cart-container').length >= 1) {
                    if ($('.main-menu-container .shop-cart-container .cart-handler .cart-count').length < 1) {
                        $('.main-menu-container .shop-cart-container .cart-handler').append('<span class="cart-count">' + data[ 'total-items-in-cart' ] + '</span>')
                    } else {
                        $('.main-menu-container .shop-cart-container .cart-handler .cart-count').html(data[ 'total-items-in-cart' ])
                    }
                }

            });

        },


        visual_composer: function () {

            // fix full width style
            if (!this.is_rtl()) {
                return;
            }

            function bs_fix_vc_full_width_row() {
                var $elements = jQuery('[data-vc-full-width="true"]');
                jQuery.each($elements, function () {
                    var $el = jQuery(this);
                    $el.css('right', $el.css('left')).css('left', '');
                });
            }

            // Fixes rows in RTL
            jQuery(document).on('vc-full-width-row', function () {
                bs_fix_vc_full_width_row();
            });

            // Run one time because it was not firing in Mac/Firefox and Windows/Edge some times
            bs_fix_vc_full_width_row();

        },
        init_off_canvas_menu: function () {

            var animation = 360,
                self = this;

            function isMenuOpen() {
                return $(document.body).hasClass('off-canvas-menu-open');
            }

            function toggleMenuStatus(status) {
                var menuAnimation = animation / 2,
                    isClose = status === 'close';

                $(".off-canvas-overlay")[isClose ? 'fadeOut' : 'fadeIn'](animation);

                $(".off-canvas-container").delay(menuAnimation).queue(function (n) {
                    var $this = $(this),
                        pos = $this.hasClass('right') ? 'right' : 'left';

                    var anim = {};
                    anim[pos] = isClose ? -300 : 0;

                    $this.show().animate(anim, menuAnimation);

                    n();
                });

                $(document.body)[isClose ? 'removeClass' : 'addClass']('off-canvas-menu-open');
            }

            function menuFallback() {

                var $container = $(".off-canvas-menu-fallback");
                if ($container.length === 0) {
                    return;
                }

                var $mainNav = $("#main-navigation").clone();
                $mainNav.removeAttr('id').removeAttr('class').addClass('menu clearfix bsm-initialized');

                // Remove All Mega Menus
                $mainNav.find('.mega-menu').each(function () {
                    var $this = $(this);

                    if ($this.hasClass('mega-type-link')) {
                        $this.replaceWith($this.find('.content-wrap > ul.mega-links').removeAttr('class').addClass('sub-menu'));
                    } else if ($this.hasClass('mega-type-link-list')) {
                        $this.replaceWith($this.find('ul.mega-links').removeAttr('class').addClass('sub-menu'));
                    } else if ($this.hasClass('tabbed-grid-posts')) {
                        var $sub_menu = $this.find('.tabs-section');
                        $sub_menu.removeAttr('class').addClass('sub-menu').find('li:first-child').remove();
                        $sub_menu.find('a')
                            .removeAttr('data-target')
                            .removeAttr('data-deferred-init')
                            .removeAttr('data-toggle')
                            .removeAttr('data-deferred-event');
                        $this.replaceWith($sub_menu);
                    }
                    else {
                        $this.closest('li').removeClass('menu-item-has-children');
                        $this.remove();
                    }
                });

                // Remove prerry tab
                $mainNav.find('li.bs-pretty-tabs-container').remove();

                $container.replaceWith($mainNav);
            }

            menuFallback();

            $(".off-canvas-menu-icon").on('click', function () {
                if (isMenuOpen()) {
                    toggleMenuStatus('close');
                } else {
                    self.refreshLazyImages();
                    toggleMenuStatus('open');
                }
            });

            $(".off-canvas-container").on('click', function (e) {

                if (!$(e.target).hasClass('off-canvas-container')) {
                    return true;
                }

                toggleMenuStatus('close');
            });

        },

        init_more_stories: function () {

            if (docCookies.getItem('hide-more-stories') === 'yes') {
                return;
            }

            var $container = $(".more-stories"),
                self       = this;

            if ($container.length === 0) {
                return;
            }

            var $window = $(window),
                edge    = parseInt($container.data('scroll-top')) || 450;

            function toggleStatus(show) {

                var anim    = {},
                    pos     = $container.hasClass('left') ? 'left' : 'right';
                anim[ pos ] = show ? 0 : $container.outerWidth() * -1;

                $container.show().animate(anim, 400, function () {
                    if (show) {
                        self.refreshLazyImages();
                    }
                });

                $container[ show ? 'addClass' : 'removeClass' ]('active');
            }

            $window.on('scroll.more-stories', function () {
                var show      = $window.scrollTop() > edge,
                    isVisible = $container.hasClass('active');

                if (show === isVisible) {
                    return;
                }

                toggleStatus(show);
            });

            $container.on('click', '.more-stories-close', function () {

                $window.off('scroll.more-stories');
                toggleStatus(false);

                /**
                 * Set Coolkie
                 */
                var cookieSettings = $container.data('close-settings').split(';'),
                    timeStr        = cookieSettings[ 0 ],
                    cookiePath     = cookieSettings[ 1 ] || '/';
                if (timeStr && timeStr != 'always') {
                    var factor = 0,
                        time   = 0;

                    if (timeStr !== 'session') {
                        var duration = timeStr.substr(-1).toUpperCase();
                        time         = timeStr.substr(0, timeStr.length - 1);

                        switch (duration) {
                            case 'H': // an Hour
                                factor = 60 * 60;
                                break;
                            case 'D':
                                factor = 60 * 60 * 24; // a Day
                                break;
                            case 'W':
                                factor = 60 * 60 * 24 * 7; // a Week
                                break;
                            case 'M':
                                factor = 60 * 60 * 24 * 7 * 30; // a Month
                                break;

                        }
                    }
                    docCookies.setItem("hide-more-stories", "yes", time * factor, cookiePath);
                }

                return false;
            });
        },

        init_continue_reading: function () {

            $(".continue-reading-btn").on('click', function (e) {
                var animTime = 750,
                    $content = $(".continue-reading-content"),
                    $container = $(".continue-reading-container"),
                    $this = $(this);

                e.preventDefault();

                $content.css('max-height', '3000px').delay(animTime).queue(function(n){
                    $content.removeClass('close');

                    $this.fadeOut(function() {
                        $container.remove()
                    });

                    $content.css('max-height', 'none');

                    n();
                });

            });
        }
    };// /return
})(jQuery);
/**
 * Publisher Ajax Search Handler
 */
// Load when ready
jQuery(document).ready(function () {

    var Publisher_Theme_Search = (function ($) {

        return {
            wrapperSelector: '.main-menu-container .search-container',


            $wrapper: false,
            _xhr: false,
            prevSearchQuery: false,
            _doingAjax: false,
            localize: $.extend(
                {
                    ajax_url: false,
                    previewMarkup: false
                },
                publisher_theme_ajax_search_loc
            ),

            ajaxRequestDelay: 300, // milliseconds
            /**
             * Sections class name
             */
            EL: {
                INPUT: 'search-field',
                PREVIEW: 'search-preview',
                LOADING: 'ajax-search-loading'
            },
            /**
             *
             */
            init: function () {
                this.$wrapper = $(this.wrapperSelector);
                this.prepareMarkup();
                this.bindEvents();
            },

            /**
             * Append required HTML to document
             */
            prepareMarkup: function () {
                var $previewSection = this.findElements(this.EL.PREVIEW);
                if (!$previewSection.length) {  // prevent multiple append
                    $previewSection = $('<div/>', {
                        'class': this.EL.PREVIEW
                    }).appendTo(this.$wrapper);

                    if (this.localize.previewMarkup) {
                        $previewSection.html(this.localize.previewMarkup);
                    }
                }


                var $loadingContainer = this.findElements(this.EL.LOADING);
                if (!$loadingContainer.length) {  // prevent multiple append
                    this._createLoadingELement()
                        .appendTo(this.$wrapper.find('.search-handler'))
                        .hide();
                    this._addLoadingInPreview();
                }
            },

            _createLoadingELement: function () {
                return $('<i/>', {
                    'class': 'fa fa-refresh fa-spin fa-fw ajax-loading-icon'
                });
            },
            /**
             * Remove existing HTML in preview section & add loading icon instead.
             *
             * @private
             */
            _addLoadingInPreview: function () {
                if (this._doingAjax) {
                    return;
                }
                var $loadingMarkup  = $('<span/>', {
                        'class': this.EL.LOADING,
                    }),
                    $previewSection = this.findSections(this.EL.PREVIEW),
                    section;
                $loadingMarkup.html('<i class="fa fa-refresh fa-spin fa-fw ajax-loading-icon"></i>');

                for (section in $previewSection) {
                    $previewSection[ section ].html(' ');
                    $loadingMarkup.clone().appendTo($previewSection[ section ]);
                }

            },
            /**
             *
             * @param {function} successCallback Callback function for success ajax response
             * @param {Object} args settings object
             * @private
             * @return {jqXHR}
             */
            _ajax: function (successCallback, data, args) {
                var self        = this,
                    settings    = $.extend(
                        {
                            url: this.localize.ajax_url,
                            data: $.extend(
                                {
                                    action: 'ajaxified-search'
                                },
                                data
                            )
                        },
                        args
                    );
                self._doingAjax = true;

            return $.ajax({
                        url: settings.url,
                        type: 'POST',
                        dataType: 'json',
                        data: settings.data,
                    })
                    .done(function () {
                        self._doingAjax = false;
                        successCallback.apply(this, arguments);
                    });
        },

            /**
             * Find element
             *
             * todo add more comment
             *
             * @param {string} section this.section.METHOD
             * @private {jQuery} jquery object
             */
            findElements: function (element) {
                return this.$wrapper.find("." + element);
            },

            /**
             * Find children(s) marked as section
             *
             *  To mark an element as section:
             *   - add data-section-name attribute with some value
             *   - EX: <div data-section-name="products" class="product-list"></div>
             *
             * todo refactor
             * todo add more comment
             *
             * @param {string} section this.section.METHOD
             * @return  {Object|false} object on success or false otherwise
             * @private
             */
            findSections: function (element) {
                var context;
                if (element)
                    context = this.findElements(element);
                else
                    context = this.$wrapper;

                if (context) {
                    var result = {};
                    $('[data-section-name]', context).each(function () {
                        var $this       = $(this),
                            sectionName = $this.data('section-name');

                        if (sectionName) {
                            result[ sectionName ] = $this;
                        }
                    });

                    return result;
                }

                return false;
            },
            /**
             * Get list of available sections name
             *
             * @return  {Array}
             */
            listSections: function () {
                var sections = this.findSections();
                if (sections) {
                    return Object.keys(sections);
                }

                return [];
            },
            /**
             * Attach required events
             */
            bindEvents: function () {
                var self = this;
                self.findElements(this.EL.INPUT)
                    .on('keyup.ajax-search', function (e) {
                        if (e.ctrlKey || e.metaKey) {
                            return;
                        }
                        var s = $.trim(this.value);
                        if (s !== self.prevSearchQuery) {
                            self.handleUserSearch.call(self, this);
                            self.prevSearchQuery = s;
                        }
                    });

                // .on('focus.ajax-search', function () {
                //     if (self.$wrapper.hasClass('result-results-exist')) {
                //         self.showPreviewSection();
                //     }
                // })
                // .on('click.ajax-search', function (e) {
                //
                //     e.stopPropagation();
                // });


            },

            hidePreviewSection: function () {

                $('.bs-pinning-wrapper').removeClass('stop-smarty-pinning');

                /**
                 * unpin main nav menu
                 */
                var $nav = $('#header .bs-pinning-block');
                if ($nav.hasClass('pinned'))
                    $nav.removeClass('pinned top normal').addClass('unpinned');
            },

            showPreviewSection: function () {
                $('.bs-pinning-wrapper').addClass('stop-smarty-pinning');
            },

            /**
             * Handle search action when user is typing
             */
            handleUserSearch: function (el) {
                var s = el.value; // search string
                var self = this;

                if (s) {
                    self.triggerLoading('on');
                    if (self._xhr)
                        self._xhr.abort();

                    self.$wrapper.finish()
                        .delay(self.ajaxRequestDelay)
                        .queue(
                            function () {
                                self._xhr = self._ajax(function (res) {
                                    self.appendHTML(res);
                                    self.triggerLoading('off');


                                    if(typeof bsLazy === 'object') {
                                        bsLazy.revalidate();
                                    }
                                }, {s: s, sections: self.listSections(), full_width: self.localize.full_width})
                            }
                        );
                } else {
                    self.hidePreviewSection();
                }
            },


            bindCloseEvent: function () {
                var $document = $(document),
                    self      = this;

                this.findElements(this.EL.PREVIEW).on('click.ajax-search', function (e) {
                    e.stopPropagation();
                });

                $('.search-container .search-handler').on('click', function (e) {
                    if (!$('.search-container').hasClass('open')) {
                        if (self.$wrapper.hasClass('result-results-exist')) {
                            self.showPreviewSection();
                        }
                    }
                });
            },


            /**
             * Insert HTML source in ajax search result section with
             *
             * @param {String} HTML html string to insert
             */
            appendHTML: function (response) {
                if (typeof response.sections === 'object') {
                    var previewSections = this.findSections(this.EL.PREVIEW);
                    if (previewSections) {
                        var section;
                        for (section in previewSections) {
                            if (typeof response.sections[ section ] === 'string') {
                                previewSections[ section ].html(response.sections[ section ]);
                            }
                        }
                        this.$wrapper.addClass('result-results-exist');
                    }
                }
                this.bindCloseEvent();
            },

            /**
             * Display/ hide loading
             * todo refactor
             *
             * @param {String} status off or on default off
             */
            triggerLoading: function (status) {
                var isLoadingVisible = status === 'on';

                var $loading = this.findElements(this.EL.LOADING);
                $loading[ isLoadingVisible ? 'show' : 'hide' ]();

                var $primaryLoading = $('.ajax-loading-icon', this.$wrapper);
                $primaryLoading[ isLoadingVisible ? 'show' : 'hide' ]();
                $primaryLoading.siblings()[ isLoadingVisible ? 'hide' : 'show' ]();

                if (isLoadingVisible) {
                    this.showPreviewSection();
                    this._addLoadingInPreview();
                }
            }

        };
    })(jQuery);


    Publisher_Theme.init();

    if (jQuery('body').hasClass('active-ajax-search')) {
        Publisher_Theme_Search.init();
    }

});

// Initialize JS
if (typeof OnScreen == 'function') {

    // main logo
    bsrj_retinajs(document.querySelectorAll('.site-header img#site-logo'));

    // mobile header logo
    bsrj_retinajs(document.querySelectorAll('.responsive-header .logo-container img'));

    // newsletter powered icons
    bsrj_retinajs(document.querySelectorAll('.bs-subscribe-newsletter .powered-by img'));

}

