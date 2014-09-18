
APP.factory('fileUploadResponseService', function ($rootScope) {
        var fileUploadResponse = {};

        return {
            setFileUploadResponse:function (data) {
                $rootScope.$emit("file.uploaded", data);
                $rootScope.$emit("popup.message", data);
                console.log('file.uploaded', data);
                fileUploadResponse = data;
            },
            getFileUploadResponse:function () {
                return fileUploadResponse;
            }
        };
    });