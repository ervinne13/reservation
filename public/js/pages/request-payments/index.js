
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
                url: "/request-payments/datatable"
            },
            order: [1, "desc"],
            columns: [
                {data: 'document_number'},
                {data: 'document_number'},
                {data: 'document_date'},
                {data: 'due_date'},
                {data: 'total_payment'},
                {data: 'payment_by_name'},
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
                }
            ]
        });
    }

})();
