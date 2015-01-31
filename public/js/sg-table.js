
/* global _, globals */

(function ($) {

    "use strict";

    //  Static Views    
    var closeRowActionIcon = '<i class="fa fa-caret-down"></i>';
    var openRowActionIcon = '<i class="fa fa-edit"></i>';
    var deleteRowActionIcon = '<i class="glyphicon glyphicon-remove"></i>';

    //  Events
    var EVENT_ON_OPEN_ROW = "openRow";

    //  Templates    
    var dropdownRowCreateActionsTemplate;
    var dropdownRowEditActionsTemplate;

    //  States
    var columnCount;

    //  Custom lightweight highlight
    $.fn.highlight = function () {
        $(this).each(function () {
            var el = $(this);
            $("<div/>")
                    .width(el.outerWidth())
                    .height(el.outerHeight())
                    .css({
                        "position": "absolute",
                        "left": el.offset().left,
                        "top": el.offset().top,
                        "background-color": "#1ab394",
                        "opacity": ".7",
                        "z-index": "9999999",
                        "border-top-left-radius": parseInt(el.css("borderTopLeftRadius"), 10),
                        "border-top-right-radius": parseInt(el.css("borderTopRightRadius"), 10),
                        "border-bottom-left-radius": parseInt(el.css("borderBottomLeftRadius"), 10),
                        "border-bottom-right-radius": parseInt(el.css("borderBottomRightRadius"), 10)
                    }).appendTo('body').fadeOut(1800).queue(function () {
                $(this).remove();
            });
        });
    };

    $.fn.SGTable = function (sgOptions) {
        this.sgOptions = validateAndInitializeOptions(sgOptions);

        var _this = this;
        this.indexedRowIdList = [];

        //  buffers
        this.deletedRows = [];

        //  
        /*     * ************************************************************************* */
        //  validatesOnSave<editor-fold defaultstate="collapsed" desc="Saving Functions (Composite Table Data Functions)">

        this.saveCurrentOpenRowAndClose = function (formData) {

            _this.saveCurrentOpenRow(formData);
            _this.closeOpenRow();

        };

        this.saveCurrentOpenRowAndNext = function (formData) {

            _this.saveCurrentOpenRow(formData);
            _this.openNextRow($(_this.selector + ' .dropdown-row').data('id'));

        };

        this.saveCurrentOpenRowAndNew = function (formData) {

            _this.saveCurrentOpenRow(formData);
            _this.openRowForCreate();
        };

        this.saveCurrentOpenRow = function (formData) {

            var rowId = $(_this.selector + ' .dropdown-row').data('id');
            var mode = $(_this.selector + ' .dropdown-row').data('mode');

            if (mode == "create") {
                _this.addRow(formData);
            } else {
                _this.updateRow(rowId, formData);
            }

        };

        //  </editor-fold>

        /*     * ************************************************************************* */
        //  <editor-fold defaultstate="collapsed" desc="Table Data Functions">

        this.getFullData = function () {
            var rowsSelector = $('.' + _this.generateRowClassName());
            var rows = [];
            rowsSelector.each(function () {
                var id = $(this).data('id');
                rows.push(_this.getRowData(id));
            });

            //  include deleted rows
            return rows.concat(this.deletedRows);
        };

        this.getModifiedData = function () {
            var $modifiedRows = $('.' + _this.generateRowClassName()).filter('[data-state="updated"],[data-state="created"]');
            var modifiedRows = [];
            $modifiedRows.each(function () {
                var id = $(this).data('id');
                modifiedRows.push(_this.getRowData(id));
            });

            //  include deleted rows
            return modifiedRows.concat(this.deletedRows);
        };

        this.getRowData = function (rowId) {
            var dataRowSelector = '.' + _this.generateRowClassName() + '[data-id=' + rowId + ']';
            var dataColSeletor = '.' + _this.generateRowClassName() + '[data-id=' + rowId + '] td.data-col';

            var rowState = $(dataRowSelector).data('state');
            var data = {
                rowState: rowState
            };

            $(dataColSeletor).each(function () {
                var name = $(this).data('name');
                var value = $(this).data('value');

                if (value !== undefined) {
                    data[name] = value;
                }

                if (_this.sgOptions.idColumn && rowState == "updated") {
                    data[_this.sgOptions.idColumn] = rowId;
                }

            });

            return data;
        };

        this.setData = function (data) {
            _this.clearTable();
            for (var i in data) {
                //  false = don't highlight
                _this.addRow(data[i], false, 'unmodified');
            }
        };

        this.indexRows = function () {
            var rowSelector = 'tr.' + _this.generateRowClassName();

            _this.indexedRowIdList = [];
            $(rowSelector).each(function () {
                _this.indexedRowIdList.push($(this).data('id'));
            });

        };

        this.updateRow = function (id, rowData, noHighlight) {
            var cols = _this.sgOptions.columns;
            var rowSelector = 'tr.' + _this.generateRowClassName() + '[data-id="' + id + '"]';

            var newState;
            if ($(rowSelector).data('state') == 'created') {
                newState = "created";
            } else {
                newState = "updated";
            }

            $(rowSelector).replaceWith(_this.generateRowHtml(id, cols, rowData, newState));

            _this.indexRows();

            if (noHighlight !== false) {
//                $(rowSelector).effect('highlight', {color: _this.sgOptions.highlightColor}, 1800);
                setTimeout(function () {
                    $(rowSelector).highlight();
                }, 150);
            }
        };

        this.addRow = function (rowData, noHighlight, state) {
            var cols = _this.sgOptions.columns;
            var id = rowData[_this.sgOptions.idColumn] ? rowData[_this.sgOptions.idColumn] : _this.generateTemporaryRowId();

            if ($(_this.selector + ' tbody').length === 0) {
                //  put a tbody tag if it's not present
                $(_this.selector).append('<tbody></tbody>');
            }

            if (!state) {
                state = 'created';
            }

//            $(_this.selector + ' tbody').prepend(_this.generateRowHtml(id, cols, rowData, state));
            $(_this.selector + ' tbody').append(_this.generateRowHtml(id, cols, rowData, state));

            _this.indexRows();

            if (noHighlight !== false) {
                setTimeout(function () {
                    $('tr.' + _this.generateRowClassName() + '[data-id="' + id + '"]').highlight();
                }, 150);
            }
        };

        //  </editor-fold>

        /*     * ************************************************************************* */
        //  <editor-fold defaultstate="collapsed" desc="Clear & Close Functions">

        this.clearTable = function () {
            $(_this.selector + ' tbody').html('');
        };

        this.closeOpenRow = function () {
            $('.dropdown-row').remove();
            $('.' + _this.getGeneratedRowEditButtonClassName()).removeClass('active');
            $('.' + _this.getGeneratedRowEditButtonClassName()).html(openRowActionIcon);
        };

        //  </editor-fold>

        /*     * ************************************************************************* */
        //  <editor-fold defaultstate="collapsed" desc="Html & Attribute Generator Functions">

        this.generateRowHtml = function (id, columns, rowData, state) {
            var rowHtml = '<tr class="' + _this.generateRowClassName() + ' " data-id=' + id + ' data-state="' + state + '">';

            if (_this.sgOptions.disableRowActions && _this.sgOptions.disableRowActions(id, columns, rowData, state)) {
                rowHtml += '<td></td>';
            } else {
                rowHtml += '<td>' + _this.generateRowActions(id) + '</td>';
            }

            for (var key in columns) {
                var displayStyle = '';

                if (columns[key].hidden) {
                    displayStyle = ' style="display: none;"';
                }

                var value = rowData[key];
                var display;

                if (state == "created" && !rowData[key] && columns[key].defaultValue) {
                    value = columns[key].defaultValue;
                }

                //  if the display should be different from the value
                if (columns[key].displaySourceField) {
                    display = rowData[columns[key].displaySourceField];
                } else {
                    display = value;
                }

                if (columns[key].format || columns[key].displayFormat) {
                    try {
                        display = format(columns[key], display, true);  //  true = format display
                    } catch (e) {
                        console.error("SGTable", "An exception occured while formatting " + key + " with value " + columns[key]);
                        throw e;
                    }
                }

                var additionalClass = columns[key].class ? columns[key].class : '';

                //  remove undefined and null
                display = display === undefined || display === null ? '' : display;
                value = value === undefined || value === null ? '' : value;
                rowHtml += '<td class="data-col ' + additionalClass + '" data-name="' + key + '"' + displayStyle + ' data-value="' + value + '">' + display + '</td>';
            }

            rowHtml += "</tr>";

            return rowHtml;
        };

        this.generateRowClassName = function () {
            //  substring removes #
            return $(this).selector.substring(1) + '-row';
        };

        this.generateTemporaryRowId = function () {

            //  check if the id's are numeric, if yes, get the greatest id and
            //  add 1 to it, otherwise, just get the number of rows and add 1
            var lastRowId = $($(this).selector + ' tbody tr:last').data('id');

            if (isNaN(lastRowId)) {
                return $($(this).selector + ' tbody tr').length;
            } else {

                var greatestId = 0;
                $($(this).selector + ' tbody tr').each(function () {
                    var id = $(this).data('id');
                    if (greatestId < id) {
                        greatestId = id;
                    }
                });

                return greatestId + 1;

            }

        };

        this.generateRowActions = function (id) {
            var editButtonClass = _this.getGeneratedRowEditButtonClassName();
            var deleteButtonClass = _this.getGeneratedRowDeleteButtonClassName();

            var editAction = '<a href="javascript:void(0)" class="' + editButtonClass + '" data-id="' + id + '">' + openRowActionIcon + '</a>';
            var deleteAction = '<a href="javascript:void(0)" class="' + deleteButtonClass + '" data-id="' + id + '">' + deleteRowActionIcon + '</a>';

            var actions = editAction + " " + deleteAction;

            return actions;
        };

        this.getGeneratedRowEditButtonClassName = function () {
            //  substring removes #
            return $(this).selector.substring(1) + '-action-edit-row';
        };

        this.getGeneratedRowDeleteButtonClassName = function () {
            //  substring removes #
            return $(this).selector.substring(1) + '-action-delete-row';
        };

        //  </editor-fold>

        /*     * ************************************************************************* */
        //  <editor-fold defaultstate="collapsed" desc="Open Row Functions">

        this.isRowCurrentlyOpened = function () {
            return $('.dropdown-row').length > 0;
        };

        this.openNextRow = function (currentRowId) {
            var currentRowIndex = _this.indexedRowIdList.indexOf(currentRowId);

            //  if a next row still exists, open it, otherwise, open a new row for
            //  creation
            if (currentRowIndex < _this.indexedRowIdList.length) {
                _this.openRowForEditing(_this.indexedRowIdList[currentRowIndex + 1]);
            } else {
                _this.openRowForCreate();
            }
        };

        this.openRowForCreate = function () {
            _this.closeOpenRow();
            $(_this.selector + ' .action-add-entry').closest('tr').after(_this.createOpenRow(0, 'create'));
            onRowOpened(_this, 0);
        };

        this.openRowForEditing = function (id) {
            var selector = '.' + _this.getGeneratedRowEditButtonClassName() + '[data-id=' + id + ']';
            var isActive = $(selector).hasClass('active');

            _this.closeOpenRow();

            if (!isActive) {
                $(selector).addClass('active');
                $(selector).html(closeRowActionIcon);
                $(selector).closest('tr').after(_this.createOpenRow(id, 'edit'));
                assignValuesToDropdownRowFields(_this, _this.getRowData(id));
                onRowOpened(_this, id);
            }
        };

        this.createOpenRow = function (id, mode) {
            var dropdownRow = this.dropdownRowTemplate({id: id, mode: mode});
            var actions = "";

            if (mode === 'edit') {
                actions = dropdownRowEditActionsTemplate({id: id});
            } else if (mode === 'create') {
                actions = dropdownRowCreateActionsTemplate({id: id});
            }

            if (actions) {
                dropdownRow += actions;
            }

            var dropdownRowWrapped = '<tr id="dropdown-row-' + id + '" data-id="' + id + '" data-mode="' + mode + '" class="dropdown-row"><td style="display: table-cell" colspan="' + columnCount + '">' + dropdownRow + '<div class="clearfix"></div></td></tr>';

            return dropdownRowWrapped;
        }

        //  </editor-fold>

        /*     * ************************************************************************* */
        //<editor-fold defaultstate="collapsed" desc="Deletion Functions">

        this.deleteRow = function (id) {
            var rowData = this.getRowData(id);

            if (rowData.rowState != "created") {
                //  all rows that are already saved in the database should be marked
                //  as deleted in the table data
                rowData.rowState = "deleted";
                this.deletedRows.push(rowData);
            }

            //  delete from view
            $('.' + this.generateRowClassName() + "[data-id=" + id + "]").remove();

            if (this.options.onDelete) {
                this.options.onDelete(rowData);
            }

        };

        //</editor-fold>


        generateHeaderRow(this);
        initializeComponents(this);

        //  make sure that there's a tbody
        if (!$(_this.selector + ' tbody').length) {
            //  add a tbody
            $(_this.selector).append('<tbody></tbody>');
        }

        if (this.sgOptions.addCreateColumn) {
            addCreateColumn(this);
        }

        initializeEvents(this);

        return this;
    };

    //      
    /*     * ************************************************************************* */
    //  <editor-fold defaultstate="collapsed" desc="Initializer Functions">

    function initializeComponents(sgTable) {
        //  values
        columnCount = $(sgTable.selector + ' thead tr th').length;

        if (columnCount <= 0) {
            columnCount = $(sgTable.selector + ' thead tr td').length;
        }

        //  templates
        var templateHtml = $(sgTable.sgOptions.dropdownRowTemplate).html();
        if (templateHtml) {
            sgTable.dropdownRowTemplate = _.template(templateHtml);
        } else {
            throw new Error("dropdownRowTemplate can't be blank!");
        }

        if (sgTable.sgOptions.dropdownRowCreateActionsTemplate) {
            var createActionsTemplateHtml = $(sgTable.sgOptions.dropdownRowCreateActionsTemplate).html();
            if (createActionsTemplateHtml) {
                dropdownRowCreateActionsTemplate = _.template(createActionsTemplateHtml);
            } else {
                console.warn('SGTable', "Warning! dropdownRowCreateActionsTemplate was specified but it was not found or is empty");
                dropdownRowCreateActionsTemplate = function () {
                    console.warn("SGTable", "No action to show");
                };
            }
        }

        if (sgTable.sgOptions.dropdownRowEditActionsTemplate) {
            var editActionsTemplateHtml = $(sgTable.sgOptions.dropdownRowEditActionsTemplate).html();
            if (editActionsTemplateHtml) {
                dropdownRowEditActionsTemplate = _.template(editActionsTemplateHtml);
            } else {
                console.warn('SGTable', "Warning! dropdownRowEditActionsTemplate was specified but it was not found or is empty");
                dropdownRowEditActionsTemplate = function () {
                    console.warn("SGTable", "No action to show");
                };
            }
        }

    }

    function validateAndInitializeOptions(options) {

        //  Note: errors are thrown instead of exception to force definition of 
        //  options and dropdownRowTemplate
        if (options === undefined) {
            throw new Error('options of SGTable is required!');
        }

        if (options.dropdownRowTemplate === undefined) {
            throw new Error('dropdownRowTemplate in options of SGTable is required!');
        }

        options.dropdownRowTemplate = options.dropdownRowTemplate ? options.dropdownRowTemplate : this.selector + '-row';
        if (!$(options.dropdownRowTemplate).length && $(options.dropdownRowTemplate).html()) {
            throw new Error(options.dropdownRowTemplate + " does not exist");
        }

        //  optional options / defaults
        if (!options.columns) {
            options.columns = {};
        }

        if (!options.columnDefs) {
            options.columnDefs = [];
        }

        if (options.hideIdColumn === undefined) {
            options.hideIdColumn = true;
        }

        if (options.highlightColor === undefined) {
            //  default: violet
            options.highlightColor = "#605ca8";
        }

        if (options.closeRowActionIcon !== undefined) {
            closeRowActionIcon = options.closeRowActionIcon;
        }


        if (options.openRowActionIcon !== undefined) {
            openRowActionIcon = options.openRowActionIcon;
        }

        if (options.addCreateColumn === undefined) {
            options.addCreateColumn = true;
        }

        return options;
    }

    function initializeEvents(sgTable) {
        $(sgTable.selector + ' .action-add-entry').click(function (e) {
            e.preventDefault;
            sgTable.openRowForCreate();
        });

        var editButton = sgTable.getGeneratedRowEditButtonClassName();
        $(sgTable.selector).on('click', '.' + editButton, function () {
            var id = $(this).data('id');
            sgTable.openRowForEditing(id);
        });

        var deleteButton = sgTable.getGeneratedRowDeleteButtonClassName();
        $(sgTable.selector).on('click', '.' + deleteButton, function () {
            var id = $(this).data('id');

            confirm("Are you sure you want to delete this entry?", function (confirmed) {
                if (confirmed) {
                    sgTable.deleteRow(id);
                }
            });

        });

    }

    //  </editor-fold>

    /*     * ************************************************************************* */
    //  <editor-fold defaultstate="collapsed" desc="HTML Generator Functions">

    function generateHeaderRow(sgTable) {
        var cols = sgTable.sgOptions.columns;
        var rowHtml = "<thead><tr>";

        //  add actions column
        rowHtml += '<th></th>';

        //  add all columns
        for (var key in cols) {
            var displayStyle = '';

            if (cols[key].hidden) {
                displayStyle = ' style="display: none;"';
            }

            var additionalClass = cols[key].class ? cols[key].class : '';

            rowHtml += '<th' + displayStyle + ' class=' + additionalClass + '>' + cols[key].label + '</th>';

        }

        rowHtml += "</tr></thead>";
        $(sgTable.selector).html(rowHtml);
    }

    function addCreateColumn(el) {
        var row = '<tfoot><tr><td colspan="' + columnCount + '" style="text-align: center;"><a href="javascript:void(0)" class="action-add-entry">Add Entry</a></td></tr></tfoot>';
        $(el.selector).append(row);
    }

    //  </editor-fold>

    /*     * ************************************************************************* */
    //  <editor-fold defaultstate="collapsed" desc="Event Functions">

    function onRowOpened(sgTable, id) {
        sgTable.trigger(EVENT_ON_OPEN_ROW, [id]);

        if (sgTable.sgOptions.autoFocusField) {
            $('[name=' + sgTable.sgOptions.autoFocusField + ']').focus();
        }
    }

    //  </editor-fold>

    /*     * ************************************************************************* */
    //  <editor-fold defaultstate="collapsed" desc="Data Functions">

    function assignValuesToDropdownRowFields(sgTable, rowValues) {
        var cols = sgTable.sgOptions.columns;

        for (var key in cols) {
            var value;
            if ($.fn.autoNumeric && cols[key].autoNumeric) {
                value = rowValues[key];

                if (!$('.dropdown-row [name=' + key + ']').data('autoNumeric')) {
                    $('.dropdown-row [name=' + key + ']').autoNumeric();
                }

            } else if (cols[key].stringifyOnAssignValue) {
                value = JSON.stringify(rowValues[key]);
            } else {
                value = format(cols[key], rowValues[key]);
            }

            // lazy values are for fields that require somethings to be done first before setting their value            
            $('.dropdown-row [name=' + key + ']').attr('data-lazy-value', value);

            if ($('.dropdown-row [name=' + key + ']').data('autoNumeric')) {
                $('.dropdown-row [name=' + key + ']').autoNumeric('set', value);
            } else {
                $('.dropdown-row [name=' + key + ']').val(value);
            }

            if (cols[key].type == 'checkbox' && value == 1) {
                $('.dropdown-row [name=' + key + ']').attr('checked', '');
            } else if (cols[key].type == 'select') {
                var content = $('.dropdown-row [name=' + key + ']').html().trim();
                var selectedOption = $('.dropdown-row [name=' + key + '] option:selected').text();
                var optionCount = $('.dropdown-row [name=' + key + '] option').length;

//                console.log("Content", content);
//                console.log("selectedOption", selectedOption);
//                console.log("optionCount", optionCount);

                if (value && (content == "" || (optionCount <= 1 && selectedOption == ""))) {
                    //  if this select is empty, add an option then set the value again
                    $('.dropdown-row [name=' + key + ']').html('<option value="' + value + '">' + value.trim() + '</option>');
                    $('.dropdown-row [name=' + key + ']').val(value);
                }
            }
        }
    }

    //  </editor-fold>

    /*     * ************************************************************************* */
    //  <editor-fold defaultstate="collapsed" desc="Formatter Functions">

    function format(columnData, value, display) {

        display = display ? display : false;    //  avoid undefined
        columnDataFormat = display ? columnData.displayFormat : columnData.valueFormat;

        var columnDataFormat;
        var format;
        var formattedValue;

        //  use specific formatting (display or value), if not available, use
        //  generic formatting (format)
        if (columnDataFormat) {
            format = columnDataFormat;
        } else if (columnData.format) {
            format = columnData.format;
        }

        switch (format) {
            case 'integer' :
                formattedValue = Math.round(value);
                break;
            case 'numeric' :
                formattedValue = parseFloat(value);
                formattedValue = formattedValue.toFixed(2);
                break;
            case 'currency' :
                formattedValue = formatCurrency(value);
                break;
            case 'json':
                formattedValue = JSON.stringify(value);
                console.log("Converted to JSON: " + formattedValue);
                break;
            default:
                formattedValue = value;
        }

        return formattedValue;
    }

    function formatCurrency(number, decimals, decimalSeparator, thousandsSeparator) {

        /*
         according to [http://stackoverflow.com/questions/411352/how-best-to-determine-if-an-argument-is-not-sent-to-the-javascript-function]
         the fastest way to check for not defined parameter is to use typeof value === 'undefined' 
         rather than doing value === undefined or just value.
         */
        thousandsSeparator = (typeof thousandsSeparator === 'undefined') ? ',' : thousandsSeparator; //if you don't want to use a thousands separator you can pass empty string as thousands_sep value        

        //  check if number is already in currency format, if yes, don't bother with it
        if (number.indexOf(thousandsSeparator) > 0) {
            return number;
        }

        number = parseFloat(number);

        decimals = isNaN(decimals) ? 2 : Math.abs(decimals); //if decimal is zero we must take it, it means user does not want to show any decimal
        decimalSeparator = decimalSeparator || '.'; //if no decimal separator is passed we use the dot as default decimal separator (we MUST use a decimal separator)

        var sign = (number < 0) ? '-' : '';
        //extracting the absolute value of the integer part of the number and converting to string
        var absValue = parseInt(number = Math.abs(number).toFixed(decimals)) + '';
        var thousandCount = ((thousandCount = absValue.length) > 3) ? thousandCount % 3 : 0;

        return sign + (thousandCount ? absValue.substr(0, thousandCount) + thousandsSeparator : '') + absValue.substr(thousandCount).replace(/(\d{3})(?=\d)/g, "$1" + thousandsSeparator) + (decimals ? decimalSeparator + Math.abs(number - absValue).toFixed(decimals).slice(2) : '');
    }

    //  </editor-fold>

})(jQuery);