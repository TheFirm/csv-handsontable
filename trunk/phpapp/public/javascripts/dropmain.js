$("div#drop_zone").dropzone({
    url: "/upload.php",
    dictDefaultMessage: "",
    init: function () {
        this.on("addedfile", function (file) {
            $('.fileUpload').css('display', 'inline-block');
        });

        this.on("success", function () {
            console.log(arguments);
        });
    }
});

$('#drop_zone').on('dragenter', function () {
    $('.fileUpload').css('display', 'none');
}).on('dragleave', function () {
    $('.fileUpload').css('display', 'inline-block');
});