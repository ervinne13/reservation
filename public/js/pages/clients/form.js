
/* global form_utilities, id, _, mode, baseURL */

(function () {

    var passwordFieldsTemplate;

    $(document).ready(function () {

        //  initialize templates
        passwordFieldsTemplate = _.template($('#password-fields-template').html());

        initializeFormUtils();
        initializeEvents();

        //  show password fields for creation
        if (mode == "ADD") {
            showPasswordFields(true);
        }
    });

    function initializeFormUtils() {
        form_utilities.moduleUrl = "/clients";
        form_utilities.updateObjectId = id;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
        form_utilities.postValidate = function () {
            var password1 = $('[name=password]').val();
            var password2 = $('[name=password_repeat]').val();

            if (password1 != password2) {

                form_utilities.setFieldError('password', 'Passwords do not match');
                form_utilities.setFieldError('password_repeat', 'Passwords do not match');

                swal("Error", "Passwords must match", "error");
                return false;
            }

            return true;

        };
    }

    function initializeEvents() {

        $('#action-show-passwords-field').click(function () {
            showPasswordFields(true);
        });

        $('#action-reset-password').click(function () {
            swal({
                title: "Are you sure?",
                text: 'This will reset the clients password',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, reset password"
            }).then(function () {
                resetPassword();
            });
        });

    }

    function resetPassword() {
        var url = baseURL + "/clients/" + id + "/reset-password";
        $.get(url, function (newPassword) {
            swal("Success", "Password reset, new password is " + newPassword + ". Please ask the user to change this after the he logs in", "success");
        });
    }

    function showPasswordFields(show) {
        if (show) {
            $('#password-fields-container').html(passwordFieldsTemplate());
        } else {
            $('#password-fields-container').html('');
        }
    }

})();
