/**
 * Created by boom on 18.09.14.
 */

//Routes
APP.config(function($routeProvider, $locationProvider) {
    var TEMPLATE_PATH = '/public/javascripts/app/templates';
    $routeProvider
        .when('/', {
            templateUrl: TEMPLATE_PATH+'/dropfile.html',
            controller: 'DropFile'
        })
        .when('/validator', {
            templateUrl: TEMPLATE_PATH+'/validator.html',
            controller: 'validator'
        });

    // configure html5 to get links working on jsfiddle
    $locationProvider.html5Mode(true);
});

