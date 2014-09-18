/**
 * Created by boom on 18.09.14.
 */

APP.controller('errorCtrl', function($scope, $rootScope, $route, $routeParams) {
    console.log('Controller: errorCtrl');

    $rootScope.$on('errorEvent', function(event, mass) {
        console.log(mass);
        $scope.error = mass.success;
    });

});