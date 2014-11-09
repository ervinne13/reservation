
/* global form_utilities, image_utils, id */

(function () {

    $(document).ready(function () {
        initializeFormUtilities();
        initializeImageUtilities();
    });

    function initializeFormUtilities() {
        form_utilities.moduleUrl = "/items";
        form_utilities.updateObjectId = id;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
    }

    function initializeImageUtilities() {
        image_utils.initialize($('#input-item-image'), $('[name=image_url]'), null);
    }
})();