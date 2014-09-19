/**
 * Created by boom on 18.09.14.
 */

//Routes
APP.config(function($routeProvider, $locationProvider ) {
    var TEMPLATE_PATH = '/javascripts/app/templates';
    $routeProvider
        .when('/', {
            templateUrl: TEMPLATE_PATH+'/fileUpload.html',
            controller: 'fileUploadCtrl'
        })
        .when('/dataTable', {
            templateUrl: TEMPLATE_PATH+'/dataTable.html',
            controller: 'tableCtrl'
        });



    // configure html5 to get links working on jsfiddle
    //$locationProvider.html5Mode(true);
}).run(function ($rootScope, $http, fileUploadResponseService, $location, $route, editableOptions) {
    $rootScope.importData = function () {
        $http.post("/uploadfile", fileUploadResponseService.getFileUploadResponse())
            .success(function (data, status, headers, config) {
                console.log(data);
                fileUploadResponseService.setFileUploadResponse(data);
                $location.path("/dataTable");
                $route.reload();
            })
            .error(function (data, status, headers, config) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
            });
    };

    editableOptions.mode = 'popup';
});

