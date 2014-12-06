
/* global phoneNumbers, sg_table_row_utilities, bankAccounts */

(function () {

    var $phoneNumbersTable, $bankAccountsTable;

    $(document).ready(function () {
        initializePhoneNumbersTable();
        initializeBankAccountsTable();
    });

    function initializePhoneNumbersTable() {
        $phoneNumbersTable = $('#tbl-phone-numbers').SGTable({
            dropdownRowTemplate: '#phone-number-row-template',
            dropdownRowCreateActionsTemplate: '#details-form-create-actions-template',
            dropdownRowEditActionsTemplate: '#details-form-edit-actions-template',
            idColumn: 'number',
            displayInlineActions: true,
            autoFocusField: 'number',
            highlighColor: '#F78B3E',
            closeRowActionIcon: '<i class="fa fa-chevron-up"></i>',
            openRowActionIcon: '<i class="fa fa-edit"></i>',
            deleteRowActionIcon: '<i class="fa fa-remove"></i>',
            enableDeleteRows: true,
            columns: {
                number: {label: "Number"},
                owner_name: {label: "Owner Name"}
            }
        });

        $phoneNumbersTable.setData(phoneNumbers);
        $phoneNumbersTable.on('openRow', function (e, id) {

            sg_table_row_utilities.initializeDefaultEvents($phoneNumbersTable, $('#phone-number-row-form'), getOpenPhoneNumberData, onPhoneNumberSave);
        });

        //  true = ignoreState = will always ask for confirmation
        $('#tbl-phone-numbers').on('click', '.tbl-phone-numbers-action-delete-row', function () {
            var id = $(this).data('id');
            swal({
                title: "Are you sure?",
                text: "This record will be permanently deleted",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete detail",
                closeOnConfirm: false}, function () {

            }).then(function () {
                onDeletePhoneNumberConfirmed(id);
            });
        });
    }

    function initializeBankAccountsTable() {
        $bankAccountsTable = $('#tbl-bank-accounts').SGTable({
            dropdownRowTemplate: '#bank-account-row-template',
            dropdownRowCreateActionsTemplate: '#details-form-create-actions-template',
            dropdownRowEditActionsTemplate: '#details-form-edit-actions-template',
            idColumn: 'account_number',
            displayInlineActions: true,
            autoFocusField: 'account_number',
            highlighColor: '#F78B3E',
            closeRowActionIcon: '<i class="fa fa-chevron-up"></i>',
            openRowActionIcon: '<i class="fa fa-edit"></i>',
            deleteRowActionIcon: '<i class="fa fa-remove"></i>',
            enableDeleteRows: true,
            columns: {
                account_number: {label: "Account Number"},
                account_name: {label: "Account Name"}
            }
        });

        $bankAccountsTable.setData(bankAccounts);
        $bankAccountsTable.on('openRow', function (e, id) {

            sg_table_row_utilities.initializeDefaultEvents(
                    $bankAccountsTable, $('#phone-number-row-form'), getBankAccountData, onBankAccountSave
                    );
        });

        //  true = ignoreState = will always ask for confirmation
        $('#tbl-bank-accounts').on('click', '.tbl-bank-accounts-action-delete-row', function () {
            var id = $(this).data('id');
            swal({
                title: "Are you sure?",
                text: "This record will be permanently deleted",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete detail",
                closeOnConfirm: false}, function () {

            }).then(function () {
                onDeleteBankAccountConfirmed(id);
            });
        });
    }

    function getOpenPhoneNumberData() {
        return {
            number: $('[name=number]').val(),
            owner_name: $('[name=owner_name]').val()
        };
    }

    function getBankAccountData() {
        return{
            account_number: $('[name=account_number]').val(),
            account_name: $('[name=account_name]').val()
        };
    }

    function onPhoneNumberSave(phoneNumberData) {
        console.log(phoneNumberData);
    }

    function onBankAccountSave(bankAccount) {
        console.log(bankAccount);
    }

    function onDeletePhoneNumberConfirmed(phoneNumber) {
        console.log(phoneNumber);

        sg_table_row_utilities.deleteRowOnView("tbl-phone-numbers", phoneNumber);

    }

    function onDeleteBankAccountConfirmed(accountNumber) {
        console.log(accountNumber);

        sg_table_row_utilities.deleteRowOnView("tbl-bank-accounts", accountNumber);
    }

})();
