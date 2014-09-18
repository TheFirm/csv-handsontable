/**
 * Created by boom on 18.09.14.
 */
var TemplatePath = '/public/javascripts/app/templates';
//Routes
APP.config(function($routeProvider, $locationProvider) {
    $routeProvider
        .when('/', {
            templateUrl: TemplatePath+'/dropfile.html',
            controller: 'DropFile'
        })
        .when('/validator', {
            templateUrl: TemplatePath+'/validator.html',
            controller: 'validator'
        });

    // configure html5 to get links working on jsfiddle
    //$locationProvider.html5Mode(true);
});

