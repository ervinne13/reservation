
/* global details, sg_table_row_utilities, form_utilities, docNo, utilities */

(function () {

    var $detailsTable;

    $(document).ready(function () {
        details = JSON.parse(details);
//        utilities.markFieldLabelRequired("ALL");        

        initilizeEvents();

        loadIssuedToUserInfo();
        initializeDetailsTable();

        initializeFormUtils();
    });

    function initializeFormUtils() {
        form_utilities.moduleUrl = "/sales-invoices";
        form_utilities.updateObjectId = docNo;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'), $detailsTable);
    }

    function initilizeEvents() {
        $('[name=issued_to_username]').on('change', function () {
            loadIssuedToUserInfo();
        });
    }

    function loadIssuedToUserInfo() {
        var $field = $('[name=issued_to_username] option:selected');
        var fullName = $field.data('full-name');
        var address = $field.data('address');

        $('[name=issued_to_name]').val(fullName);
        $('[name=issued_to_address]').val(address);

    }

    function initializeDetailsTable() {
        $detailsTable = $('#tbl-details').SGTable({
            dropdownRowTemplate: '#si-details-form-template',
            dropdownRowCreateActionsTemplate: '#details-form-create-actions-template',
            dropdownRowEditActionsTemplate: '#details-form-edit-actions-template',
            idColumn: 'line_number',
            displayInlineActions: true,
            autoFocusField: 'item_id',
            highlighColor: '#F78B3E',
            closeRowActionIcon: '<i class="fa fa-chevron-up"></i>',
            openRowActionIcon: '<i class="fa fa-edit"></i>',
            deleteRowActionIcon: '<i class="fa fa-remove"></i>',
            enableDeleteRows: true,
            columns: {
                line_number: {label: "", hidden: true},
                document_number: {label: "", hidden: true},
                item_id: {label: "Item ID.", hidden: true},
                item_model: {label: "Item Model"},
                item_name: {label: "Item Name"},
                item_cost: {label: "Item Cost"},
                item_qty: {label: "Item Qty"},
                sub_total: {label: "Sub Total"},
            }
        });

        $detailsTable.setData(details);
        $detailsTable.on('openRow', function (e, id) {
            initializeDetailForm();
            initializeDetailEvents();
        });

        //  row events
        sg_table_row_utilities.initializeDeleteEvent('tbl-details', onDeleteConfirmed, onDeleteTemporaryRow);
    }

    function initializeDetailForm() {
        loadItemFieldsValues();
    }

    function initializeDetailEvents() {

        $('[name=item_id]').on('change', function () {
            loadItemFieldsValues();
            computeSubTotal();
        });

        $('[name=item_qty]').on('change', function () {
            computeSubTotal();
        });

        sg_table_row_utilities.initializeDefaultEvents($detailsTable, $('#sales-invoice-detail-form'), getOpenRowData, onSaveOpenRow);

    }

    function getOpenRowData() {
        return form_utilities.formToJSON($('#sales-invoice-detail-form'));
    }

    function onSaveOpenRow(row) {
        computeTotal();
    }

    function loadItemFieldsValues() {
        var $field = $('[name=item_id] option:selected');
        var name = $field.data('name');
        var model = $field.data('model');
        var cost = $field.data('cost');

        $('[name=item_name]').val(name);
        $('[name=item_model]').val(model);
        $('[name=item_cost]').val(cost);
    }

    function computeSubTotal() {

        var itemCost = $('[name=item_cost]').val();
        var itemQty = $('[name=item_qty]').val();

        if (!isNaN(itemCost) && !isNaN(itemQty)) {
            $('[name=sub_total]').val(itemCost * itemQty);
        }
    }

    function onDeleteConfirmed(id) {
        $.ajax({
            url: '/sales-invoice-details/' + id,
            type: 'DELETE',
            success: function (result) {
                console.log(result);
                setTimeout(function () {
                    window.location.reload();
                }, globals.reloadRedirectWaitTime);
                swal("Removed!", "Deleted Sales Invoice Detail", "success");
            }
        });
    }

    function onDeleteTemporaryRow() {
        computeTotal();
    }

    function computeTotal() {
        var total = 0;
        $('.tbl-details-row').each(function () {
            total += parseFloat($(this).find('td[data-name=item_cost]').data('value'));
        });
        $('[name=total_amount]').val(total);
    }

})();
