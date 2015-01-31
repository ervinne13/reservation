
/* global baseURL, id, utilities, SMSUtility */

(function () {

    $(document).ready(function () {

//        initializeUI();
        initializeEvents();
        SMSUtility.initialize();

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
                
                notifyStatusChanged();
                
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

//        notifyReservationProcessed();

        var url = baseURL + "/reservations/" + id + "/convert";
        $.get(url, function (salesInvoice) {
            console.log(salesInvoice);
            swal("Success", "Sales Invoice Generated!", "success");

            notifyReservationProcessed();

            setTimeout(function () {
                location.href = baseURL + "/sales-invoices/" + salesInvoice.document_number + "/edit";
            }, 2000);
        });

    }

    function notifyStatusChanged() {
        var itemName = $('[name=item_name]').val();
        var status = $('[name=status]').val();

        notifyClient("Your reservation (" + itemName + ") is now " + status);
    }

    function notifyReservationProcessed() {
        var itemName = $('[name=item_name]').val();
        var dueDate = new Date();
        dueDate.setMonth(dueDate.getMonth() + 1);
        var dueDateDisplay = moment(dueDate).format('MMMM Do YYYY');

        var dueAmount = ((item.cost * reservation.qty_to_reserve) - (reservation.reservation_amount * reservation.qty_to_reserve)) / reservation.terms;
        console.log(dueAmount);
        var dueAmountDisplay = formatMoney(parseFloat(dueAmount));

        notifyClient("Your reservation (" + itemName + ") is now confirmed. Please settle your due: " + dueAmountDisplay + " by " + dueDateDisplay + ".");

    }

    function notifyClient(message) {

        var contactNumber1 = $('[name=contact_number_1]').val();
        var contactNumber2 = $('[name=contact_number_2]').val();

        if (contactNumber1) {
            SMSUtility.sendSMS(contactNumber1, message);
        }

        if (contactNumber2) {
            SMSUtility.sendSMS(contactNumber2, message);
        }

    }

    function formatMoney(n, c, d, t) {
        var
                c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    }
    ;

})();
