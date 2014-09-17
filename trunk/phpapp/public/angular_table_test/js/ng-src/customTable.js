var customTableModule = angular.module('customTable', []);

//customTableModule.run(function($rootScope) {
//    $rootScope.test = new Date();
//});

angular.module('customTable').controller('MyController', function($scope, localLoader) {

    localLoader.fetch("sample_server_response.json").then(function(data) {
        $scope.tableData = data;
        window.w = $scope.tableData.data;
    });

    $scope.countUnknownColumns = 1;

    $scope.deleteColumn = function (index) {
        if (!confirm("Delete column?")) {
            return false;
        }

        var removedColumn = $scope.tableData.headers.splice(index, 1);
        $scope.tableData.data.forEach(function (rowItem) {
            delete rowItem[removedColumn];
        });
        $scope.$apply();
    };

    $scope.editHeader = function (colNum, newValue) {
        var oldHeaderValue = $scope.tableData.headers[colNum];
        $scope.tableData.headers[colNum] = newValue;

        $scope.tableData.data.forEach(function (dataItem) {
            if(dataItem.hasOwnProperty(oldHeaderValue)){
                dataItem[newValue] = dataItem[oldHeaderValue];
                delete dataItem[oldHeaderValue];
            } else {
                dataItem[newValue] = "";
            }
        });
        $scope.$apply();
    };

    $scope.editCell = function (rowNum, colNum, newValue) {
        var rowItem = $scope.tableData.data[rowNum];

        var i = 0;
        for(var cellItem in rowItem){
            if(rowItem.hasOwnProperty(cellItem)){
                if(i === colNum){
                    debugger;
                    rowItem[cellItem] = newValue;
                    break;
                } else {
                    i++;
                }
            }
        }
        $scope.$apply();
    };

    $scope.addRow = function () {
        var rowItem = {};
        $scope.tableData.headers.forEach(function (headerTitle) {
            rowItem[headerTitle] = "";
        });
        $scope.tableData.data.push(rowItem);
        $scope.$apply();
    };

    $scope.addColumn = function () {
        var newHeaderName = "Unknown" + $scope.countUnknownColumns;
        $scope.tableData.headers.push(newHeaderName);
        $scope.countUnknownColumns++;
        $scope.tableData.data.forEach(function (dataItem) {
            dataItem[newHeaderName] = "";
        });
        $scope.$apply();
    };

    window.editCell = $scope.editCell;
    window.addRow = $scope.addRow;
    window.editHeader = $scope.editHeader;
    window.addColumn = $scope.addColumn;
});