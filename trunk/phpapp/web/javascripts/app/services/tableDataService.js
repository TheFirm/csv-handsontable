APP.factory('TableDataService', function ($rootScope, $location, $route) {
    var fileUploadResponse = {};
    var isDataImported = false;

    var _private = {
        getErrorText: function () {
            var errorText = 'Error';
            var errors = fileUploadResponse.errors;
            if(errors.missingRequiredHeaders.length > 0 ){
                errorText = 'You are missing requires columns: ' + errors.missingRequiredHeaders.join(', ');
                fileUploadResponse.correctColumnNames = errors.missingRequiredHeaders;
            }
            return errorText;
        }
    };

    var pub = {
        setData: function (data, secondTime) {
            isDataImported = false;
            fileUploadResponse = data;

            $rootScope.$emit("file.uploaded", data);

            var message = {};
            if(pub.hasErrors()){
                message = {
                    error: true,
                    text: _private.getErrorText()
                };
            } else {
                isDataImported = true;
                message = {
                    error: false,
                    text: secondTime ? "Your data was imported" : "You have valid columns"
                };
                if(secondTime){
                    window.location.replace('/');
                }
            }

            $rootScope.$emit("popup.message", message);
        },

        getRows: function () {
            return fileUploadResponse.data && fileUploadResponse.data.rows;
        },

        getHeaders: function () {
            return fileUploadResponse.data && fileUploadResponse.data.headers;
        },

        getErrors: function () {
            return fileUploadResponse.errors;
        },

        getAllPossibleValues: function () {
            return fileUploadResponse.meta.allPossibleValues;
        },

        hasErrors: function () {
            return pub.isDataLoaded() && !fileUploadResponse.success;
        },

        isDataLoaded: function () {
            return fileUploadResponse?(fileUploadResponse && Object.keys(fileUploadResponse).length > 0):false
        },

        isDataImported: function () {
            return isDataImported;
        }
    };

    return pub;
});