
/* global details, sg_table_row_utilities, form_utilities, docNo, utilities, mode */

(function () {

    var $detailsTable;

    $(document).ready(function () {
        details = JSON.parse(details);
//        utilities.markFieldLabelRequired("ALL");        

        initilizeEvents();
        initializeUI();

        loadIssuedToUserInfo();
        loadAppliesToAMLInfo();
        initializeDetailsTable();

        initializeFormUtils();
    });

    function initializeFormUtils() {
        form_utilities.moduleUrl = "/request-payments";
        form_utilities.updateObjectId = docNo;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'), $detailsTable);
    }

    function initilizeEvents() {
        $('[name=payment_by_username]').on('change', function () {
            loadIssuedToUserInfo();
        });

        $('[name=applies_to]').on('change', function () {
            loadAppliesToAMLInfo();
        });

        $('.post-button').click(function () {

            if ($(this).attr("id") == "action-save-and-post") {
                saveAndPost();
            } else {
                post();
            }

        });

    }

    function initializeUI() {
        $('.autonumeric').autoNumeric();

        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
        });
    }

    function loadIssuedToUserInfo() {
        var $selectedOption = $('[name=payment_by_username] option:selected');
        var fullName = $selectedOption.data('full-name');
        var address = $selectedOption.data('address');

        $('[name=payment_by_name]').val(fullName);
        $('[name=payment_by_address]').val(address);

    }

    function loadAppliesToAMLInfo() {
        var $selectedOption = $('[name=applies_to] option:selected');
        var air = $selectedOption.data('annual-interest-rate');
        var pir = $selectedOption.data('prevailing-interest-rate');
        var loanAmount = $selectedOption.data('loan-amount');
        var remainingAmount = $selectedOption.data('remaining-amount');
        var emp = $selectedOption.data('estimated-monthly-principal');
        var emi = $selectedOption.data('estimated-monthly-interest');
        console.log(air);
        $('[name=aml_annual_interest_rate]').val(air);
        $('[name=aml_prevailing_interest_rate]').val(pir);
        $('[name=aml_loan_amount]').val(loanAmount);
        $('[name=aml_remaining_amount]').val(remainingAmount);
        $('[name=aml_estimated_monthly_principal]').val(emp);
        $('[name=aml_estimated_monthly_interest]').val(emi);

    }

    function initializeDetailsTable() {
        $detailsTable = $('#tbl-details').SGTable({
            dropdownRowTemplate: '#rp-details-form-template',
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
                payment_type_code: {label: "Payment For:"},
                amount: {label: "Amount"},
                comment: {label: "Comment"}
            }
        });

        $detailsTable.setData(details);
        $detailsTable.on('openRow', function (e, id) {
            initializeDetailRow();
            initializeDetailEvents();
        });

        //  row events
        sg_table_row_utilities.initializeDeleteEvent('tbl-details', onDeleteConfirmed, onDeletedTemporaryRow);
    }

    function initializeDetailRow() {
        $('[name=amount]').autoNumeric();
    }

    function initializeDetailEvents() {
        sg_table_row_utilities.initializeDefaultEvents($detailsTable, $('#request-payment-detail-form'), getOpenRowData, onSaveOpenRow);

    }

    function getOpenRowData() {
        return form_utilities.formToJSON($('#request-payment-detail-form'));
    }

    function onSaveOpenRow(row) {
        computeTotal();
    }

    function onDeleteConfirmed(id) {
        $.ajax({
            url: '/request-payments-details/' + id,
            type: 'DELETE',
            success: function (result) {
                console.log(result);
                setTimeout(function () {
                    window.location.reload();
                }, globals.reloadRedirectWaitTime);
                swal("Removed!", "Deleted Request Payment Detail", "success");
            }
        });
    }

    function onDeletedTemporaryRow() {
        computeTotal();
    }

    function computeTotal() {
        var total = 0;
        $('.tbl-details-row').each(function () {
            total += parseFloat($(this).find('td[data-name=amount]').data('value'));
        });
        $('[name=total_payment]').autoNumeric('set', total);
    }

    //<editor-fold defaultstate="collapsed" desc="Posting Functions">

    function post(data) {

        if (!data) {
            data = {};
        }

        var url;
        if (mode == "ADD") {
            url = "/request-payments/post";
        } else if (mode == "EDIT" || mode == "") {
            url = "/request-payments/post/" + docNo;
        }

        try {
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function (response) {
                    console.log(response);
                    setTimeout(function () {
                        window.location.href = "/request-payments";
                    }, globals.reloadRedirectWaitTime);

                    swal("Success!", "Document successfully posted!", "success");
                },
                error: function (response) {
                    console.error(response.responseText);

                    if (form_utilities.errorHandler) {
                        form_utilities.errorHandler(response.responseText);
                    } else {
                        swal("Error!", response.responseText, "error");
                    }
                }
            });

        } catch (e) {
            if (e.statusText) {
                swal("Error!", e.statusText, "error");
            } else {
                console.error(e);
            }
        }

    }

    function saveAndPost() {
        var valid = true;
        if (form_utilities.validate) {
            valid = $('.fields-container').valid();
        }

        if (form_utilities.postValidate) {
            form_utilities.postValidate();
        }

        if (valid) {
            var type = $(this).attr('id');
            var data = form_utilities.formToJSON($('.fields-container'));
            if ($detailsTable) {
                data.details = JSON.stringify($detailsTable.getModifiedData());
            }

            post(data);
        }
    }

    //</editor-fold>


})();
