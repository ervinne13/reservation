
/* global form_utilities, image_utils, id */

(function () {
    $(document).ready(function () {
        initializeFormUtilities();

    });

    function initializeFormUtilities() {
        form_utilities.moduleUrl = "/categories";
        form_utilities.updateObjectId = id;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
    }


})();