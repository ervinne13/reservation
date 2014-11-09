
var utilities = {};

utilities.loadingStateHtml = '<div class="loading-overlay overlay"><i class="fa fa-refresh fa-spin"></i></div>';

utilities.setBoxLoading = function ($element, show) {

    if (show) {
        $element.append(utilities.loadingStateHtml);
    } else {

        $element.find('.loading-overlay').remove();
    }

};

utilities.reloadWithWaitFunction = function () {
    return function () {
        setTimeout(function () {
            window.location.reload();
        }, globals.reloadRedirectWaitTime);
    };
};

utilities.redirectWithWaitFunction = function (redirectTo) {
    return function () {
        setTimeout(function () {
            window.location.href = redirectTo;
        }, globals.reloadRedirectWaitTime);
    };
};

utilities.trimHttp = function (url) {
    return url.substring(7, url.length);
};

utilities.trimPort = function (url) {
    if (url.indexOf(":") > 0) {
        var splittedUrl = url.split(':');
        console.log(splittedUrl);
        return splittedUrl[0];
    } else {
        return url;
    }

};

/**
 * TODO: fix html rendering of span
 * @param {type} $field
 * @returns {undefined}
 */
utilities.markFieldLabelRequired = function ($field) {
    if ($field == "ALL") {
        $('.required').each(function () {
            var $label = $(this).siblings('label');
            $label.text($label.text() + ' <span class="text-danger">*</span>');
        });
    } else {
        var $label = $field.siblings('label')[0];
        $label.text($label.text() + ' <span class="text-danger">*</span>');
    }
};