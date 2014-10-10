

APP.run(function ($rootScope, $http, TableDataService, $location, $route, editableOptions, editableThemes) {
    $rootScope.importData = function () {
        var data = {
            rows: TableDataService.getRows(),
            headers: TableDataService.getHeaders()
        };
        $http.post("/upload", data)
            .success(function (data, status, headers, config) {
                TableDataService.setData(data, true);
                $location.path("/dataTable");
                $route.reload();
            })
            .error(function (data, status, headers, config) {
                alert(data);
            });
    };

    $rootScope.TableDataService = TableDataService;

    editableOptions.theme = 'default';
    // overwrite submit and error button template
    editableThemes['default'].submitTpl = '<a href class="icon_btn success" data-ng-click="$form.$submit()"><i class="fa fa-check-circle-o"></i></a>';
    editableThemes['default'].cancelTpl = '<a href class="icon_btn error" data-ng-click="$form.$cancel()"><i class="fa fa-times-circle-o"></i></a>';

    var original = $location.path;
    $location.path = function (path, reload) {
        if (reload === false) {
            var lastRoute = $route.current;
            var un = $rootScope.$on('$locationChangeSuccess', function () {
                $route.current = lastRoute;
                un();
            });
        }
        return original.apply($location, [path]);
    };
});

