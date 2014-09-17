angular.module('customTable').factory('localLoader', function($q, $timeout, $http) {
    var LocalLoader = {
        fetch: function(filename) {
            var deferred = $q.defer();

            $timeout(function() {
                $http.get(filename).success(function(data) {
                    deferred.resolve(data);
                });
            }, 30);

            return deferred.promise;
        }
    };

    return LocalLoader;
});