
/* global datatable_utilities, baseURL */

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
                url: "/clients/datatable"
            },
            order: [1, "desc"],
            columns: [
                {data: 'username'},
                {data: 'username'},
                {data: 'is_delinquent'},
                {data: 'full_name'},
                {data: 'contact_number_1'},
                {data: 'contact_number_2'},
                {data: 'landline_number'}
            ],
            columnDefs: [
                {bSearchable: false, aTargets: [0]},
                {orderable: false, targets: [0]},
                {
                    targets: 0,
                    render: function (id, type, rowData, meta) {
                        var actions = [
                            datatable_utilities.getDefaultEditAction(id)
                        ];

                        if (!rowData.is_active) {
                            actions.push(getActivateAction(id));
                        } else {
                            actions.push(datatable_utilities.getDefaultDeleteAction(id));
                        }

                        return datatable_utilities.getInlineActionsView(actions);
                    }
                },
                {
                    targets: 2,
                    render: function (isDelinquent, type, rowData, meta) {
                        return isDelinquent == 1 ? "Yes" : "No";
                    }
                }
            ]
        });
    }

    function getDeactivateAction(id) {
        return {
            id: id,
            href: 'javascript:void(0)',
            name: "deactivate",
            displayName: "Deactivate",
            icon: "fa-times"
        };
    }

    function getActivateAction(id) {
        return {
            id: id,
            href: 'javascript:void(0)',
            name: "activate",
            displayName: "Activate",
            icon: "fa-check"
        };
    }

    function initializeEvents() {

        $("#datatable").on('click', '.action-delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            swal({
                title: "Are you sure?",
                text: "This record will be permanently deleted",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete record"
            }).then(function () {
                var url = baseURL + "/clients/" + id;

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    success: function (response) {
                        console.log(response);
                        $datatable.ajax.reload();
                        swal("SUCCESS", "Client successfullly deleted", 'success');
                    },
                    error: function (response) {
                        askDeactivate(id, response.responseText);
                    }
                });
            });
        });

        $(document).on('click', '.action-deactivate', function () {
            var id = $(this).data('id');
            changeActiveStatus(id, false);
        });

        $(document).on('click', '.action-activate', function () {
            var id = $(this).data('id');
            changeActiveStatus(id, true);
        });

    }

    function askDeactivate(id, errorMessage) {
        swal({
            title: "Failed to Delete Client?",
            text: errorMessage + ". Do you want to disable client instead?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, deactivate client"
        }).then(function () {
            changeActiveStatus(id, false);
        });
    }

    function changeActiveStatus(id, isActive) {

        var url = baseURL + "/clients/" + id + "/" + (isActive ? "activate" : "deactivate");
        $.get(url, function (response) {
            swal("Success", "User is now " + (isActive ? "active" : "inactive"), 'success');
            $datatable.ajax.reload();
        });

    }

})();
