
/* global details, sg_table_row_utilities, form_utilities, docNo */

(function () {

    var $detailsTable;

    $(document).ready(function () {
        details = JSON.parse(details);
//        utilities.markFieldLabelRequired("ALL");        

        initilizeEvents();
        initializeUI();

        loadReferenceInvoiceRelatedData();
        initializeFormUtils();
    });

    function initializeFormUtils() {
        form_utilities.moduleUrl = "/amortization-loans";
        form_utilities.updateObjectId = docNo;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'), $detailsTable);
    }

    function initializeUI() {
        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
        });
    }

    function initilizeEvents() {
        $('[name=reference_invoice_number]').on('change', function () {
            loadReferenceInvoiceRelatedData();
        });

        $('[name=remaining_amount],[name=months_to_pay],[name=annual_interest_rate]').on('change', function () {
            loadEstimations();
        });

    }

    function loadReferenceInvoiceRelatedData() {
        var $field = $('[name=reference_invoice_number] option:selected');
        var username = $field.data('issued-to-username');
        var invoiceAmount = $field.data('invoice-amount');
        var invoiceDownPayment = $field.data('invoice-down-payment');

        $('[name=loan_by_username]').val(username);
        $('[name=loan_amount]').val(parseFloat(invoiceAmount) - parseFloat(invoiceDownPayment));
        $('[name=remaining_amount]').val(parseFloat(invoiceAmount) - parseFloat(invoiceDownPayment));
    }

    function loadEstimations() {
        var remainingAmount = $('[name=remaining_amount]').val();
        var monthsToPay = $('[name=months_to_pay]').val();
        var interest = $('[name=annual_interest_rate]').val();

        if (monthsToPay > 0) {
            $('[name=estimated_monthly_principal]').val(remainingAmount / monthsToPay);
        }

        console.log(remainingAmount);
        console.log(monthsToPay);

        if (interest > 0) {
            //  A = P(1 + rt)
            //  where totalAccruedAmount is the Accrued Amount (A)
            //  remainingAmount is Principal (P)
            //  rate = interest / 100 (r)
            //  time = monthsToPay / 12 (t)
            var totalAccruedAmount = remainingAmount * (1 + (interest / 100) * (monthsToPay / 12));
            //  accrued interest = accrued amount - principal
            var accruedInterest = totalAccruedAmount - remainingAmount;
            var monthlyAccruedInterest = accruedInterest / monthsToPay;

            $('[name=estimated_monthly_interest]').val(monthlyAccruedInterest);
        }

    }

})();
