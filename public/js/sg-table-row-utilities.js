
var sg_table_row_utilities = {};

sg_table_row_utilities.initializeDefaultEvents = function ($sgtable, $detailForm, getOpenRowDataCallback, onSaveCallback) {

    if (!$sgtable) {
        throw new Error("$sgtable is required parameter (1)");
    }

    if (!getOpenRowDataCallback) {
        throw new Error("getOpenRowDataCallback is required parameter (2)");
    }

    $('#action-close-detail').click(function (e) {
        e.preventDefault();
        $sgtable.closeOpenRow();
    });


    $('#action-update-next-detail').click(function (e) {
        e.preventDefault();
        if ($detailForm.valid()) {
            var rowData = getOpenRowDataCallback();
            $sgtable.saveCurrentOpenRowAndNext(rowData);
            if (onSaveCallback) {
                onSaveCallback(rowData);
            }
        }
    });

    $('#action-update-close-detail').click(function (e) {
        e.preventDefault();

        if ($detailForm.valid()) {
            var rowData = getOpenRowDataCallback();
            $sgtable.saveCurrentOpenRowAndClose(rowData);
            if (onSaveCallback) {
                onSaveCallback(rowData);
            }
        }
    });

    $('#action-save-new-detail').click(function (e) {
        e.preventDefault();

        if ($detailForm.valid()) {
            var rowData = getOpenRowDataCallback();
            $sgtable.saveCurrentOpenRowAndNew(rowData);
            if (onSaveCallback) {
                onSaveCallback(rowData);
            }
        }
    });

    $('#action-save-close-detail').click(function (e) {
        e.preventDefault();

        if ($detailForm.valid()) {
            var rowData = getOpenRowDataCallback();
            $sgtable.saveCurrentOpenRowAndClose(rowData);
            if (onSaveCallback) {
                onSaveCallback(rowData);
            }
        }
    });
};

sg_table_row_utilities.initializeDeleteEvent = function (sgTableIdName, onDeleteConfirmedCallback, onDeletedTemporaryRowCallback, ignoreState) {
    $('#' + sgTableIdName).on('click', '.' + sgTableIdName + '-action-delete-row', function () {
        var id = $(this).data('id');
        var state = $('.' + sgTableIdName + '-row[data-id=' + id + ']').data('state');

        console.log("deleting: " + id);

        if (!ignoreState && state == "created") {
            //  delete directly            
            sg_table_row_utilities.deleteRowOnView(sgTableIdName, id);
            if (onDeletedTemporaryRowCallback) {
                onDeletedTemporaryRowCallback();
            }
        } else if (state == "unmodified" || state == "updated") {
            swal({
                title: "Are you sure?",
                text: "This record will be permanently deleted",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete detail",
                closeOnConfirm: false}, function () {

            }).then(function () {
                onDeleteConfirmedCallback(id);
            });
        }

    });

};

sg_table_row_utilities.deleteRowOnView = function (sgTableIdName, id) {
    $('.' + sgTableIdName + '-row[data-id=' + id + ']').remove();
};