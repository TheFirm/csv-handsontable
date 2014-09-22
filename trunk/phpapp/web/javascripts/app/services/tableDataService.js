APP.factory('TableDataService', function ($rootScope) {
    var fileUploadResponse = {};
    var isDataImported = false;

    var _private = {
        getErrorText: function () {
            var errorText = 'Error';
            var bestMatch = fileUploadResponse.errors.bestMatch;
            var configName = Object.keys(bestMatch)[0];
            var errors = bestMatch[configName];

            if(errors.from_file.length === 0 && errors.from_conf.length !== 0){
                errorText = 'You are missing columns: ' + errors.from_conf.join(', ');
            } else if(errors.from_file.length !== 0 && errors.from_conf.length === 0){
                errorText = 'You have to much columns: ' + errors.from_file.join(', ');
            } else if(errors.from_file.length !== 0 && errors.from_conf.length !== 0){
                errorText = 'You have errors in columns: ' + errors.from_file.join(', ');
                fileUploadResponse.columnsWithErrors = errors.from_file;
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
            }

            $rootScope.$emit("popup.message", message);
        },

        getData: function () {
            return fileUploadResponse;
        },

        hasErrors: function () {
            return pub.isDataLoaded() && !fileUploadResponse.success;
        },

        isDataLoaded: function () {
            return Object.keys(fileUploadResponse).length > 0
        },

        isDataImported: function () {
            return isDataImported;
        }
    };

    return pub;
});