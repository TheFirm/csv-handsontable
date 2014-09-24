
APP.controller('fileUploadCtrl', function($scope, $route, $location, $http, TableDataService) {

    $http.get('/supportedColumns').then(function(data,status){
        $scope.supportedColumns = data.data.SupportedColumns;
    });

    $scope.successFileUpload = function (file, responseObj) {
        TableDataService.setData(responseObj)
        $scope.$apply(function () {
            $location.path('/dataTable');
        });
    }
});