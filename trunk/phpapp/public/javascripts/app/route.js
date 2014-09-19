/**
 * Created by boom on 18.09.14.
 */

//Routes
APP.config(function($routeProvider, $locationProvider) {
    var TEMPLATE_PATH = '/public/javascripts/app/templates';
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
});

