
/* global datatable_utilities, baseURL */

(function () {

    var datatable;

    $(document).ready(function () {
        initializeTable();
    });

    function initializeTable() {

        var url = "/items/datatable";
        if (status) {
            url = "/items/status/" + status + "/datatable";
        }

        datatable = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            search: {
                caseInsensitive: true
            },
            ajax: {
                url: url
            },
            order: [1, "desc"],
            columns: [
                {data: 'id'},
                {data: 'model'},
                {data: 'name'},
                {data: 'stock'},
                {data: 'cost'},
                {data: 'stock'},
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
                },
                {
                    targets: 3,
                    render: function (stock, type, rowData, meta) {

                        if (stock >= 3) {
                            return '<label class="text-success">In Stock</label>';
                        } else if (stock < 3 && stock > 0) {
                            return '<label class="text-warning">Critical Stock</label>';
                        } else if (stock == 0) {
                            return '<label class="text-danger">Out of Stock</label>';
                        } else if (stock < 0) {
                            return '<label class="text-danger">HAS COMMITTED STOCKS</label>';
                        }

                    }
                },
                {
                    targets: 5,
                    render: function (stock, type, rowData, meta) {

                        if (stock < 0) {
                            return 0;
                        } else {
                            return stock;
                        }

                    }
                },
                {
                    targets: 6,
                    render: function (stock, type, rowData, meta) {

                        if (stock > 0) {
                            return 0;
                        } else {
                            return stock * -1;
                        }

                    }
                }
            ]
        });
    }


})();
