var Publisher_Theme_Admin = (function ($) {
    "use strict";

    return {

        init: function () {
            this.blocks_switch();
            this.attach_events();
            this.mailchimp();
            this.custom_width_field();
            this.set_up_vc_listing_settings_override();
        },

        mailchimp: function () {

            // widget
            $(document).on('change', '.widget-mailchimp-code-field textarea', function (e, target) {
                var match = $(this).val().match(/action="([^"]*?)"/i);

                if (match != undefined && match[1] !== undefined) {
                    $(this).closest('.widget-mailchimp-code-field').siblings('.widget-mailchimp-url-field').find('input').val(match[1]);
                }
            });

            // Visual Composer
            $(document).on('change', '.wpb_el_type_textarea_raw_html textarea[name="mailchimp-code"]', function () {
                var match = $(this).val().match(/action="([^"]*?)"/i);

                if (match != undefined && match[1] !== undefined) {
                    $(this).closest('.wpb_el_type_textarea_raw_html').siblings('div[data-vc-shortcode-param-name="mailchimp-url"]').find('textarea[name="mailchimp-url"]').val(match[1]);
                }
            });
        },

        attach_events: function () {

            var self = this;
            $(document).on('bf-ajax-tab-loaded', function (e, target) {
                self.blocks_switch(target);
            });


            jQuery(document).ajaxSuccess(function (e, xhr, settings) {

                var _data = $.unserialize(settings.data);

                if (_data.action == "save-widget") {
                    var wID = _data['widget-id'],
                        $widget = $("input.widget-id[value='" + wID + "']").closest('.widget');

                    self.blocks_switch($widget);
                }

            });

        },

        blocks_switch: function (context) {


            $('.blocks-field .blocks-switch span, .blocks-field .title', context).on('click', function () {
                var $this = $(this),
                    $parent = $this.closest('.blocks-field').find('.blocks-switch'),
                    $field = $parent.find('input'),
                    $section = $parent.closest('.bf-controls'),
                    $relations = $section.find('.blocks-field[data-related-to="' + $this.closest('.blocks-field').data('id') + '"]');

                if ($parent.hasClass('checked')) {
                    $parent.removeClass('checked').addClass('unchecked');
                    $field.attr('value', 0).change();
                    $relations.addClass('disabled');
                } else {
                    $parent.removeClass('unchecked').addClass('checked');
                    $field.attr('value', 1).change();
                    $relations.removeClass('disabled');
                }

            });


            $('.blocks-field .blocks-checkbox-label', context).on('click', function () {

                var $this = $(this),
                    $field = $this.siblings('.blocks-checkbox');

                if ($field.hasClass('checked')) {
                    $field.removeClass('checked').addClass('unchecked');
                    $field.attr('value', 0).change();
                } else {
                    $field.removeClass('unchecked').addClass('checked');
                    $field.attr('value', 1).change();
                }

            });

        },

        custom_width_field: function () {
            var options = {
                columnMinWidth: 150,          // px
                wrapper2ColumnMinWidth: 600,  // px
                wrapper3ColumnMinWidth: 1000, // px
                wrapperMaxWidth: 1640,        // px
                transformPxRatio: 10,
                borderSpacing: 4
            };

            function uiContextFromUiObject(ui) {
                return ui.element.closest('.resizable-width-container');
            }

            function sanitizeWidth(width) {
                if (width % 2) {
                    width++;
                }

                return width;
            }

            function calcTotalWidthPercentage($cols) {
                var result = 0;
                $cols.each(function () {
                    result += $(this).data('width-prc');
                });

                return result;
            }

            function getColumns(ui) {

                var columnsToChange = [
                    ui.element,
                    ui.element.next('.resizable-width-column')
                ];

                var $context = uiContextFromUiObject(ui),
                    $columns = $(".resizable-width-column", $context),
                    $allCols = $columns;

                columnsToChange.forEach(function (el) {
                    $columns = $columns.not(el);
                });

                return [$columns, $allCols.not($columns)];
            }

            function updateColumnWidthPercentageLabel(e, ui) {
                var $context = uiContextFromUiObject(ui),
                    $cols = getColumns(ui),
                    allColsWidth = $('.resizable-width-section', $context).outerWidth(),
                    $columns = $cols[1],
                    percentage = 100 - calcTotalWidthPercentage($cols[0]);

                $columns.filter(':not(:last)').each(function () {
                    var $col = $(this),
                        colWidthPrc = Math.ceil($col.outerWidth() * 100 / allColsWidth);

                    $col.data('width-prc', colWidthPrc)
                        .find('.resizable-width-labels-percentage')
                        .text(colWidthPrc + '%');

                    $('input.col-' + ($col.data('index')) + '-width', $context).val(colWidthPrc);

                    percentage -= colWidthPrc;
                });

                percentage = Math.abs(percentage);
                var $lastCol = $columns.filter(':last');

                $lastCol.data('width-prc', percentage)
                    .find('.resizable-width-labels-percentage')
                    .text(percentage + '%');

                $('input.col-' + ($lastCol.data('index')) + '-width', $context).val(percentage);
            }

            function updateColumnWidthPxLabel(e, ui) {

                var $context = uiContextFromUiObject(ui),
                    $cols = getColumns(ui),
                    $columns = $cols[1],
                    total = $('input.total-width', $context).val(),
                    totalRemain = total - Math.ceil(calcTotalWidthPercentage($cols[0]) / 100 * total);

                if (!$columns.length) {
                    $columns = $('.resizable-width-column', $context);
                    totalRemain = total;
                }

                $columns.filter(':not(:last)').each(function (idx) {
                    var $col = $(this),
                        percentage = $col.data('width-prc'),
                        px = Math.ceil(percentage / 100 * total);


                    $col.data('width-px', px)
                        .find('.resizable-width-labels-px').text(px + 'px');

                    if (px <= options.columnMinWidth) {
                        $col.resizable('option', 'minWidth', $col.outerWidth());
                    }
                    totalRemain -= px;
                });

                $columns.filter(':last')
                    .data('width-px', totalRemain)
                    .find('.resizable-width-labels-px')
                    .text(totalRemain + 'px');
            }

            function fixNotResizingColumnsWidth(ui) {

                var columnsToChange = [
                    ui.element,
                    ui.element.next('.resizable-width-column')
                ];

                var $context = uiContextFromUiObject(ui),
                    $columns = $(".resizable-width-column", $context);

                columnsToChange.forEach(function (el) {
                    $columns = $columns.not(el);
                });

                $columns.each(function () { //Not Resizing Columns
                    var $col = $(this);

                    var w = $col.outerWidth();

                    $col.outerWidth(w).css({'min-width': w, 'max-width': w});
                });


                columnsToChange.forEach(function (el) {
                    el.attr('style', '');
                });
            }

            function getColumnsCount($cols) {
                return $cols.data('columns') || 2;
            }

            function limitMinColumnWidth(ui) {

                var $context = uiContextFromUiObject(ui),
                    $columnsWrapper = $(".resizable-width-columns-wrapper", $context),
                    total = $('input.total-width', $context).val(),
                    calcBorderSpacing = Math.max(2, (getColumnsCount($columnsWrapper) - 1)) * options.borderSpacing,
                    wrapperWidth = $columnsWrapper.width();

                var minWidth = Math.floor(options.columnMinWidth * wrapperWidth / total);
                ui.originalElement.resizable('option', 'minWidth', minWidth);


                var bothColumnWidth = ui.originalElement.next('.resizable-width-column').width() + ui.originalElement.width() + calcBorderSpacing,
                    maxWidth = bothColumnWidth - minWidth;
                ui.originalElement.resizable('option', 'maxWidth', maxWidth);
            }


            /**
             * Fix Initial Columns Width
             */
            (function () {
                $('.resizable-width-column').each(function () {
                    var $col = $(this);

                    var widthPrc = $col.data('width-prc');

                    if (widthPrc) {
                        $col.outerWidth(widthPrc + '%');
                    }
                });
            })();

            /**
             * Handle column width resizable
             */
            $(".resizable-width-columns").each(function () {
                $(".resizable-width-column:not(:last)", this).resizable({
                    handles: 'e',
                    minHeight: 250,
                    maxHeight: 250,

                    stop: function (event, ui) { // Convert px width to percentage
                        var totalWidth = 0,
                            widthStatus = [];

                        $(".resizable-width-column", ui.element.parent()).each(function () {
                            var $this = $(this),
                                cellWidth = $this.outerWidth();

                            totalWidth += cellWidth;
                            widthStatus.push([$this, cellWidth]);
                        }).promise().done(function () {
                            totalWidth /= 100;

                            for (var i = 0; i < widthStatus.length; i++) {
                                var $el = widthStatus[i][0];

                                $el.width((widthStatus[i][1] / totalWidth) + '%');
                            }
                        });

                    },
                    resize: function (e, ui) {
                        updateColumnWidthPercentageLabel(e, ui);
                        updateColumnWidthPxLabel(e, ui);
                    },
                    start: function (e, ui) {

                        limitMinColumnWidth(ui);
                        fixNotResizingColumnsWidth(ui);
                    }
                });
            });


            /**
             * Handle container width resizable
             */
            $(".resizable-width-container").each(function () {
                var $context = $(this),
                    $cols = $context.find('.resizable-width-columns-wrapper'),
                    columnsCount = getColumnsCount($cols),
                    minWidth = ( ( columnsCount == 2 ? 44 : 70 ) * columnsCount),
                    wrapperMinWidth = columnsCount == 2 ? options.wrapper2ColumnMinWidth : options.wrapper3ColumnMinWidth;

                function convertRealPX2ColumnPX(number) {
                    return (
                            (number - wrapperMinWidth) / (options.transformPxRatio / 2)
                        ) + minWidth;
                }

                var maxWidth = convertRealPX2ColumnPX(options.wrapperMaxWidth);

                /**
                 * Fix initial wrapper width
                 */
                var _initialWidth = convertRealPX2ColumnPX($cols.data('total'));
                $(".resizable-width-total-wrapper", $context).width(_initialWidth);
                $cols.width(_initialWidth);

                /**
                 * init container width resizable
                 */
                $cols.resizable({
                    minHeight: 280,
                    maxHeight: 280,
                    handles: 'e,w',
                    minWidth: minWidth,
                    maxWidth: maxWidth,
                    resize: function (e, ui) {

                        if (ui.size.width % 2) {
                            return;
                        }

                        var $context = uiContextFromUiObject(ui),
                            calcSize = wrapperMinWidth + (((ui.size.width - minWidth) / 2) * options.transformPxRatio);

                        calcSize = sanitizeWidth(calcSize);

                        $(".resizable-width-total-wrapper", $context).outerWidth(ui.size.width).css('left', ui.position.left);
                        $(".resizable-width-total-number", $context).text(Math.ceil(calcSize) + 'px');
                        $('input.total-width', $context).val(calcSize);

                        updateColumnWidthPxLabel(e, ui);
                    },
                    start: function (e, ui) {
                        ui.element.find('.resizable-width-column')
                            .css({'min-width': '', 'max-width': ''});

                        // transform width unit to percentage
                        var $context = uiContextFromUiObject(ui);
                        $('.resizable-width-column', $context).each(function () {
                            var $col = $(this),
                                widthPrc = $col.find('.resizable-width-labels-percentage').text();

                            $col.outerWidth(widthPrc);
                        });
                    }
                }).data('resize-options', {maxWidth: maxWidth});
            });
        },

        set_up_vc_listing_settings_override: function () {

            var self = this;

            $(document).on('change', '.wpb_edit_form_elements .advanced-block-settings :input', function () {

                // console.info('changed');
                var $this    = $(this),
                    $context = $('.wpb_edit_form_elements'),
                    isActive = $("input[name='override-listing-settings']", $context).val(),
                    $hidden  = $("input[name='listing-settings']", $context);

                var value = '';

                if (isActive !== '0') {
                    value = $this.closest('.advanced-block-settings').bf_serialize();
                }

                if ($hidden.length === 0) {
                    $('<input/>', {
                        'name': 'listing-settings',
                        'class': 'wpb_vc_param_value',
                        'value': value,
                        'type': 'hidden'
                    }).appendTo($context);
                } else {

                    $hidden.val(value)
                }
            });

            $(document).on('change', '.wpb_edit_form_elements input[name="override-listing-settings"]', function () {
                if (this.value === '0') {
                    $(".wpb_edit_form_elements input[name='listing-settings']").remove();
                }
            });


            $(document).ajaxSuccess(function (e, xhr, settings) {

                var data = $.unserialize(settings.data);

                if (data.action !== 'vc_edit_form') {
                    return;
                }

                var $context = $('.wpb_edit_form_elements');

                self.blocks_switch($context);

                $('.blocks-field :input:first', $context).trigger('change');
            });

        }
    };// /return
})(jQuery);

// Load when ready
jQuery(document).ready(function () {
    Publisher_Theme_Admin.init();
});
