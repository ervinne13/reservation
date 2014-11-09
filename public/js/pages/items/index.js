
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
                url: "/items/datatable"
            },
            order: [1, "desc"],
            columns: [
                {data: 'id'},
                {data: 'model'},
                {data: 'name'},
                {data: 'cost'},
                {data: 'stock'},
                {data: 'description'}
            ],
            columnDefs: [
                {bSearchable: false, aTargets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (id, type, rowData, meta) {

                        var actions = [datatable_utilities.getDefaultEditAction(id)];
                        return datatable_utilities.getInlineActionsView(actions);

                    }
                }
            ]
        });
    }


})();
