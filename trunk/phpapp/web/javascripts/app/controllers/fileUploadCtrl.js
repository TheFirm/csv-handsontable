APP.controller('fileUploadCtrl', function($rootScope, $scope, $route, $location, $http, TableDataService) {
    $http.get('/supportedColumns').then(function(data,status){
        $scope.supportedColumns = data.data.SupportedColumns;
    });

    $scope.successFileUpload = function (file, responseObj) {
        if(responseObj.error){
            $rootScope.$emit("popup.message",  responseObj);
        }else{
            TableDataService.setData(responseObj);
            $scope.$apply(function () {
                $location.path('/dataTable');
            });
        }
    }
});