
APP.factory('fileUploadResponseService', function ($rootScope) {
        var fileUploadResponse = {};

        return {
            setFileUploadResponse:function (data) {
                $rootScope.$emit("file.uploaded", data);
                console.log('file.uploaded');
                fileUploadResponse = data;
            },
            getFileUploadResponse:function () {
                return fileUploadResponse;
            }
        };
    });