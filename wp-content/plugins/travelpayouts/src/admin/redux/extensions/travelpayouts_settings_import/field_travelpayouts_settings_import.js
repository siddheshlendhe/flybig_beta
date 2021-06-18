(function ($) {
    "use strict";

    $("#travelpayouts_import_settings_button").on("click", function () {
        prepareUpload();
    });

    function prepareUpload() {
        const file = document.querySelector('#travelpayouts_import_settings_file');

        if (file) {
            const {files} = file; // мы берем массив files из file
            const [fileData] = files; // мы берем нулевую запись из массива files
            if (fileData) {
                let reader = new FileReader();
                reader.readAsText(fileData);
                reader.onload = function (e) {
                    let re = /\{.*\}|\[.*\]/g;
                    let jsonSettings = this.result.match(re);

                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'travelpayouts_import_file',
                            settings: JSON.parse(jsonSettings[0])
                        },
                        cache: false,
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            location.reload(true);
                        },
                        error: function () {
                            console.log('import error');
                        }
                    });
                };
            }
        }
    }
})(jQuery);