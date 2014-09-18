

APP.controller('fileUploadCtrl', function($scope, $route, $location, fileUploadResponseService) {
    $scope.successFileUpload = function (file, responseObj) {
        fileUploadResponseService.setFileUploadResponse(responseObj);
        
        $scope.$apply(function () {
            $location.path('/dataTable');
        });
    }
});