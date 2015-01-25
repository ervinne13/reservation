
/* global form_utilities, image_utils, id */

(function () {

    var fileList = [];

    $(document).ready(function () {
        initializeUI();
        initializeFormUtilities();
        initializeImageUtilities();
        initializeEvents();

        initializeDropzone();

    });

    function initializeUI() {
        $('[name=cost]').autoNumeric();
        $('[name=reservation_cost]').autoNumeric();
    }

    function initializeFormUtilities() {
        form_utilities.moduleUrl = "/items";
        form_utilities.updateObjectId = id;
        form_utilities.validate = true;
        form_utilities.preProcessData = preProcessData;
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

    function preProcessData(data) {

        data.images = fileList;

        return data;
    }

    function initializeDropzone() {

        Dropzone.autoDiscover = false;

        $("#dropzone").dropzone({
            url: "/files/upload",
            addRemoveLinks: true,
            maxFilesize: 5,
            dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
            dictResponseError: 'Error uploading file!',
            headers: {
                'X-CSRFToken': $('meta[name="_token"]').attr('content')
            },
            init: function () {

                var dropzone = this;
                if (id) {
                    var url = baseURL + "/items/" + id + "/files";
                    $.get(url, function (files) {

                        for (var i in files) {

                            var fileName = files[i].name;

                            if (files[i].name.indexOf("/uploads/") === 0) {
                                fileName = files[i].name.substring(9);
                            }

                            fileList.push({
                                server_filename: fileName,
                                filename: files[i].name
                            });

                            dropzone.options.addedfile.call(dropzone, files[i]);
                            dropzone.options.thumbnail.call(dropzone, files[i], files[i].name);
                        }

                    });
                }
            },
            success: function (image, response) {
                console.log(image);
                console.log(response);

                fileList.push({
                    server_filename: response,
                    filename: image.name
                });

            },
            removedfile: function (file) {
                var removedFile = null;

                for (var i in fileList) {
                    if (fileList[i].filename == file.name) {
                        removedFile = fileList[i].server_filename;
                        delete fileList[i];
                        break;
                    }
                }

                if (removedFile) {
                    var url = baseURL + "/files/remove";
                    var data = {file: removedFile};
                    $.post(url, data, function (response) {
                        console.log(response);
                    });
                }

                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            }
        });

    }

})();