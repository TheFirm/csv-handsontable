

APP.controller('fileUploadCtrl', function($scope, $route, $location, TableDataService) {
    $scope.successFileUpload = function (file, responseObj) {
        TableDataService.setData(responseObj);
        
        $scope.$apply(function () {
            $location.path('/dataTable');
        });
    }
});