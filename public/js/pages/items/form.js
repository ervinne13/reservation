
/* global form_utilities, image_utils, id */

(function () {

    $(document).ready(function () {
        initializeUI();
        initializeFormUtilities();
        initializeImageUtilities();
        initializeEvents();
    });

    function initializeUI() {
        $('[name=cost]').autoNumeric();
        $('[name=reservation_cost]').autoNumeric();
    }

    function initializeFormUtilities() {
        form_utilities.moduleUrl = "/items";
        form_utilities.updateObjectId = id;
        form_utilities.validate = true;
        form_utilities.initializeDefaultProcessing($('.fields-container'));
    }

    function initializeImageUtilities() {
        image_utils.initialize($('#input-item-image'), $('[name=image_url]'), null);
    }

    function initializeEvents() {
        $('[name=cost]').change(computeDownpayment);
    }

    function computeDownpayment() {
        var cost = $('[name=cost]').autoNumeric('get');
        var downpayment = cost * 0.1;   //  10% of the cost

        $('[name=reservation_cost]').autoNumeric('set', downpayment);

    }

})();