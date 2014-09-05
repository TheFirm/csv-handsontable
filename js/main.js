
checkFileApiSupport();

$("div#drop_zone").dropzone({
    url: "/",
    autoProcessQueue: false,

    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 1,

    init: function() {
        this.on("addedfile", function(file) {
            if(!isFileExtentionValid(file)){
                alert('Only CSV file supported.');
            } else {
                Papa.parse(file, {
                    complete: function(results) {
                        displayData(results.data);
                    }
                });
            }
        });
    }
});