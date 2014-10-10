APP.controller('tableCtrl', function ($scope, $rootScope, $location, $timeout, TableDataService) {
    console.log("tableCtrl");
    $scope.headers = TableDataService.getHeaders();
    $scope.rows = TableDataService.getRows();
    $scope.errors = TableDataService.getErrors();

    $scope.checkedRows = [];
    $scope.tableHeaderSelects = [];
    $scope.possibleValues = [];
    $scope.allPossibleValues = [];

    //if empty table data, got to root path
    console.log($scope.rows);
    if (!$scope.headers || Object.keys($scope.headers).length === 0) {
        $location.path("/");
        return false;
    }

    $scope.allPossibleValues = TableDataService.getAllPossibleValues();

    $scope.tableHeaderSelects = [];

    //i'm very very sorry
    $timeout(function () {
        $('select').selectric('refresh');
    }, 1000);

    $scope.countUnknownColumns = 1;

    $scope.deleteColumn = function (index) {
        $scope.headers.splice(index, 1);
        $scope.rows.forEach(function (row) {
            delete row[index];
        });
    };

    $scope.addRow = function () {
        var row = [];
        $scope.headers.forEach(function () {
            row.push({value:"Unknown"});
        });
        $scope.rows.push(row);
    };

    $scope.addColumn = function () {
        var newHeaderName = "Unknown" + $scope.countUnknownColumns;
        $scope.headers.push({name:newHeaderName});
        $scope.countUnknownColumns++;
        $scope.rows.forEach(function (row) {
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
        var colName = $scope.headers[colIndex].name;

        var errorInThisColumn = $scope.errors.notMatchedHeadersInFile &&
                $scope.errors.notMatchedHeadersInFile.indexOf(colName) !== -1
            ;
        return errorInThisColumn;
    };

    $scope.selectOption = function (headerTitle, optionName) {
       return headerTitle == optionName;
    }

});