/**
 * Created by boom on 18.09.14.
 */

APP.controller('alertCtrl', function($scope, $rootScope, $route, $routeParams) {
    console.log('Controller: alertCtrl');

    $rootScope.$on('popup.message', function(event, data) {
        console.log(data);

        if(data.success){
            $scope.message = {
                error: false,
                text: "All ok"
            };
        } else {
            $scope.message = {
                error: true,
                text: "Invalid data (!!!todo column names, or numbers)"
            };
        }
    });

});