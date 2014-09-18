$("div#drop_zone").dropzone({
    url: "/upload.php",
    dictDefaultMessage: "",
    init: function() {
        this.on("addedfile", function(file) {
            $('.fileUpload').css('display','inline-block');
        });
    }
});

$('#drop_zone').on('dragenter',function(){
    $('.fileUpload').css('display','none');
});

$('#drop_zone').on('dragleave',function(){
    $('.fileUpload').css('display','inline-block');
});