
/* global datatable_utilities, baseURL */

(function () {

    var datatable;

    $(document).ready(function () {
        initializeTable();
    });

    function initializeTable() {
        datatable = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: "/amortization-loans/datatable"
            },
            order: [1, "desc"],
            columns: [
                {data: 'document_number'},
                {data: 'document_number'},
                {data: 'document_date'},
                {data: 'reference_invoice_number'},
                {data: 'loan_by_username'},
                {data: 'loan_amount'},
                {data: 'remaining_amount'},
                {data: 'date_received'},
                {data: 'remarks'},
                {data: 'status'}
            ],
            columnDefs: [
                {bSearchable: false, aTargets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (id, type, rowData, meta) {
                        var actions;

                        if (rowData.status == "Open") {
                            actions = [
                                datatable_utilities.getDefaultEditAction(id),
                                datatable_utilities.getDefaultViewAction(id)
                            ];
                        } else {
                            actions = [
                                datatable_utilities.getDefaultViewAction(id)
                            ];
                        }

                        return datatable_utilities.getInlineActionsView(actions);
                    }
                },
                {
                    targets: [5, 6],
                    render: datatable_utilities.formatCurrency
                }
            ]
        });
    }

})();
