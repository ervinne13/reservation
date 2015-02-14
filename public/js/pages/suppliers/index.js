
/* global datatable_utilities, baseURL */

(function () {

    var $datatable;
    $(document).ready(function () {
        initializeTable();
        initializeEvents();
    });

    function initializeTable() {

        var url = "/suppliers/datatable";
        if (status) {
            url = "/suppliers/status/" + status + "/datatable";
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
                {data: 'name'},
                {data: 'description'},
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
                }
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
                confirmButtonText: "Yes, delete supplier"
            }).then(function () {
                deleteItem(id);
            });
        });

    }

    function deleteItem(itemId) {

        var url = baseURL + "/suppliers/" + itemId;

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
