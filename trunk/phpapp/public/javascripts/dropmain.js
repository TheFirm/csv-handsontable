
(function(){
    var $fileUpload = $('.fileUpload');

    $('#drop_zone').on('dragenter', function () {
        $fileUpload.css('display', 'none');
    }).on('dragleave', function () {
        $fileUpload.css('display', 'inline-block');
    });
})();

