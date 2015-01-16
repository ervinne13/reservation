
/* global baseURL, id */

(function () {

    $(document).ready(function () {

//        initializeUI();
        initializeEvents();

    });   

    function initializeEvents() {

        $('#action-update-status').click(updateStatus);
        $('#action-convert-si').click(convertToSalesInvoice);

    }

    function updateStatus() {
        var url = baseURL + "/reservations/" + id;
        var data = {
            status: $('[name=status]').val()
        };

        $.ajax({
            url: url,
            type: 'PUT',
            data: data,
//        dataType: 'json',
            success: function (response) {
                console.log(response);
                swal("Success", "Status Updated!", "success");
                setTimeout(function () {
                    location.href = baseURL + "/reservations";
                }, 2000);
            },
            error: function (error) {
                console.error(error);
            }
        });

    }

    function convertToSalesInvoice() {

        var url = baseURL + "/reservations/" + id + "/convert";
        $.get(url, function (salesInvoice) {
            console.log(salesInvoice);
            swal("Success", "Sales Invoice Generated!", "success");
            setTimeout(function () {
                location.href = baseURL + "/sales-invoices/" + salesInvoice.document_number + "/edit";
            }, 2000);
        });

    }

})();
