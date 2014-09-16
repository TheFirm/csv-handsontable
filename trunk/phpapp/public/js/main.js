
checkFileApiSupport();

//$("div#drop_zone").dropzone({
//    url: "/upload.php",
//    autoProcessQueue: true,
//
//    paramName: "file", // The name that will be used to transfer the file
//    maxFilesize: 1,
//
//    init: function() {
//        this.on("addedfile", function(file) {
//            this.removeAllFiles();
//            if(!isFileExtentionValid(file)){
//                alert('Only CSV file supported.');
//            } else {
//                Papa.parse(file, {
//                    complete: function(results) {
//                        displayData(results.data);
//                    }
//                });
//            }
//        });
//    }
//});