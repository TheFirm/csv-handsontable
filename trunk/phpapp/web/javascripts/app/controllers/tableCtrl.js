APP.controller('tableCtrl', function ($scope, $rootScope, $location, $timeout, TableDataService) {
    $scope.tableData = TableDataService.getData();
    $scope.checkedRows = [];
    $scope.tableHeaderSelects = [];
    $scope.possibleValues = [];
    $scope.allPossibleValues = [];

    //if empty table data, got to root path
    if (!$scope.tableData || Object.keys($scope.tableData).length === 0) {
        $location.path("/");
        return false;
    }

    if($scope.tableData.errors.hasOwnProperty('bestMatch')){
        //var confName = $scope.tableData.errors.bestMatch.configName;
        $scope.possibleValues = $scope.tableData.errors.bestMatch.configErrors.from_conf;
        $scope.allPossibleValues = $scope.tableData.errors.bestMatch.config;
    }

    $scope.tableHeaderSelects = [];

    //i'm very very sorry
    $timeout(function () {
        $('select').selectric('refresh');
    }, 1000);

    $scope.countUnknownColumns = 1;

    $scope.deleteColumn = function (index) {
        $scope.tableData.headers.splice(index, 1);
        $scope.tableData.rows.forEach(function (row) {
            delete row[index];
        });
    };

    $scope.addRow = function () {
        var row = [];
        $scope.tableData.headers.forEach(function () {
            row.push({value:"Unknown"});
        });
        $scope.tableData.rows.push(row);
    };

    $scope.addColumn = function () {
        var newHeaderName = "Unknown" + $scope.countUnknownColumns;
        $scope.tableData.headers.push({name:newHeaderName});
        $scope.countUnknownColumns++;
        $scope.tableData.rows.forEach(function (row) {
            row.push({value:"Unknown"});
        });
        //i'm very very sorry
        $timeout(function () {
            $('select').selectric('refresh');
        }, 1000);
    };

    $scope.mySelect = {};

    $scope.checkUncheckAllRows = function () {
        var newValue = !$scope.allRowsChecked();

        $scope.checkedRows.forEach(function (row) {
            row.checked = newValue;
        });
    };

    // Returns true if and only if all todos are done.
    $scope.allRowsChecked = function () {
        var countChecked = 0;
        $scope.checkedRows.forEach(function (checkItem) {
            return countChecked += checkItem.checked ? 1 : 0;
        });

        return (countChecked === $scope.checkedRows.length);
    };

    $scope.columnHasError = function (colIndex) {
        var colName = $scope.tableData.headers[colIndex].name;

        var errorInThisColumn = $scope.tableData.correctColumnNames &&
            $scope.tableData.correctColumnNames.indexOf(colName) === -1
            ;
        return errorInThisColumn;
    };

    $scope.selectOption = function (headerTitle, optionName) {
       return headerTitle == optionName;
    }

});