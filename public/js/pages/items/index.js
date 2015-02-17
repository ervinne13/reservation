
/* global datatable_utilities, baseURL */

(function () {

    var $datatable;
    $(document).ready(function () {
        initializeTable();
        initializeEvents();
    });

    function initializeTable() {

        var url = "/items/datatable";
        if (status) {
            url = "/items/status/" + status + "/datatable";
        }

        $datatable = $('#datatable').DataTable({
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
                {data: 'id'},
                {data: 'model'},
                {data: 'name'},
                {data: 'stock'},
                {data: 'cost'},
                {data: 'stock'},
//                {data: 'stock'},                
                {data: 'category.name'},
                {data: 'supplier.name'},
                {data: 'fuel_type.name', name: 'fuel_type.name'}
            ],
            columnDefs: [
                {bSearchable: false, aTargets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (id, type, rowData, meta) {

                        var actions = [
                            datatable_utilities.getDefaultEditAction(id),
                            datatable_utilities.getDefaultDeleteAction(id)
                        ];
                        return datatable_utilities.getInlineActionsView(actions);
                    }
                },
                {
                    targets: 4,
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
                    render: datatable_utilities.formatCurrency
                },
                {
                    targets: 6,
                    render: function (stock, type, rowData, meta) {

                        if (stock < 0) {
                            return 0;
                        } else {
                            return stock;
                        }

                    }
                },
//                {
//                    targets: 7,
//                    render: function (stock, type, rowData, meta) {
//
//                        if (stock > 0) {
//                            return 0;
//                        } else {
//                            return stock * -1;
//                        }
//
//                    }
//                }
            ]
        });
    }

    function initializeEvents() {

        $('#datatable').on('click', '.action-delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            swal({
                title: "Are you sure?",
                text: "This record will be permanently deleted",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete item"
            }).then(function () {
                deleteItem(id);
            });
        });

    }

    function deleteItem(itemId) {        

        var url = baseURL + "/items/" + itemId;

        $.ajax({
            url: url,
            type: 'DELETE',
            success: function (response) {
                console.log(response);
                $datatable.ajax.reload();
                swal("SUCCESS", "Item successfully deleted", 'success');
            },
            error: function (response) {
                swal("Error", response.responseText, 'error');
            }
        });

    }

})();
