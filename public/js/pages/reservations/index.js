
/* global datatable_utilities */

(function () {

    var $datatable;

    $(document).ready(function () {
        initializeTable();
        initializeEvents();
    });

    function initializeTable() {
        $datatable = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: "/reservations/datatable"
            },
            order: [1, "desc"],
            columns: [
                {data: 'id'},
                {data: 'reserved_by.full_name', name: 'reservedBy.full_name'},
                {data: 'reserved_by.contact_number_1', name: 'reservedBy.contact_number_1'},
                {data: 'status'},
                {data: 'item.name'},
                {data: 'qty_to_reserve'},
                {data: 'reservation_amount'},
                {data: 'reservation_amount'}
            ],
            columnDefs: [
                {bSearchable: false, aTargets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (id, type, rowData, meta) {
                        var actions = [
                            datatable_utilities.getDefaultViewAction(id),
                            datatable_utilities.getDefaultDeleteAction(id)
                        ];

                        return datatable_utilities.getInlineActionsView(actions);
                    }
                },
                {
                    targets: 6,
                    render: datatable_utilities.formatCurrency
                }
                ,
                {
                    targets: 7,
                    render: function (reservationAmount, type, rowData) {

                        var amount = reservationAmount * rowData.qty_to_reserve;

                        return datatable_utilities.formatCurrency(amount);
                    }
                }
            ]
        });
    }

    function initializeEvents() {
        form_utilities.initializeDefaultDeleteInViewAction($datatable, "#datatable", baseURL + "/reservations", "Reservation successfullly deleted");
    }

})();
