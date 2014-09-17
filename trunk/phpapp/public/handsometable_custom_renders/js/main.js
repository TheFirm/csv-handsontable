checkFileApiSupport();

var $handsontable_container = $('#handsontable_data');

var data = {
    columns: [
        {data: "id", type: 'text'},
        {data: "name", type: 'text'},
        {data: "color", type: 'text'},
        {data: "date", type: 'text'}
    ],
    headers: ["Year", "L", "M", "K"],
    body: [
        {id: 1, name: "Ted", сolor: "orange", date: "2008-01-01"},
        {id: 2, name: "John", color: "black", date: null},
        {id: 3, name: "Al", color: "red", date: null},
        {id: 4, name: "Ben", color: "blue", date: null}
    ]
};

var handsomeTable = function () {
    var self = this;

    self.data = {};

    self.helpers = {
        addCheckboxesToProperty: function (checkboxProperty) {
            var data_with_checkboxs = [];
            self.data.body.forEach(function (item) {
                var modifiedItem = item;
                modifiedItem[checkboxProperty] = false;
                data_with_checkboxs.push(modifiedItem);
            });
            return data_with_checkboxs;
        },

        addColumn: function (property, type) {
            var columns_with_checkboxes = self.data.columns;
            var checkBoxObj = {
                data: property,
                type: type
            };
            columns_with_checkboxes.unshift(checkBoxObj);
            //return columns_with_checkboxes
        },
        removeColumn: function (index) {
            if (!confirm("Delete column?")) {
                return false;
            }
            var removedColumn = self.data.columns.splice(index, 1)[0];
            var removedColumnName = removedColumn.data;

            self.data.columns.forEach(function (item) {
                delete item[removedColumnName];
            });

            self.hansometableInstance.updateSettings({
                columns: self.data.columns,
                data: self.data.body
            });
        }
    };

    self.init = function ($handsontable_container, columns, headers, body) {
        self.$handsontable_container = $handsontable_container;
        self.data.columns = columns;
        self.data.headers = headers;
        self.data.headers.unshift("");
        self.data.body = body;

        self.helpers.addColumn("_is_selected", "checkbox");
        self.helpers.addCheckboxesToProperty("_is_selected");

        self.$handsontable_container.handsontable({
            data: self.data.body,
            colHeaders: true,
            columns: self.data.columns,

            colHeaders: function (colNum) {
                switch (colNum) {
                    case 0:
                        var txt = "<input type='checkbox' class='js-checker'";
                        txt += isChecked(self.data.body, "_is_selected") ? 'checked="checked"' : '';
                        txt += "> Select all";
                        return txt;

                    default:
                        var column_name = self.data.headers[colNum];
                        var html = "<p>" + column_name + "</p>" +
                            "<a class='js-edit_column_name' data-column-num='" + colNum + "'" + ">Edit</a>"
                            + "<a class='js-delete_column' data-column-num='" + colNum + "'" + ">Delete</a>";
                        return html;
                }
            },

            width: 800
            //,stretchH: 'last'
        });
        self.hansometableInstance = self.$handsontable_container.handsontable('getInstance');

        self.$handsontable_container.on('mouseup', 'input.js-checker', function (event) {
            var current = !$('input.js-checker').is(':checked'); //returns boolean
            for (var i = 0, ilen = self.data.body.length; i < ilen; i++) {
                self.data.body[i]._is_selected = current;
            }
            $handsontable_container.handsontable('render');
        });

        self.$handsontable_container.on('click', 'a.js-delete_column', function (event) {
            var $this = $(this);
            var colNum = $this.data("columnNum");
            self.helpers.removeColumn(colNum);
        });

        self.$handsontable_container.on('click', 'a.js-edit_column_name', function (event) {
            var $this = $(this);
            window.$$this = $this;
            var $title = $this.siblings('p');
            var $wrapper = $this.parent();
            $title.hide();
            $wrapper.append('<input type="text"></p>');

            var source = $("#edit_column_wrapper").html();
            var template = Handlebars.compile(source);
            console.log(template());

            var colNum = $this.data("columnNum");
            console.log($this, colNum);
        });
    }
};

var hto = new handsomeTable();
hto.init($handsontable_container, data.columns, data.headers, data.body);


//only for test
var ht = $handsontable_container.handsontable('getInstance');

function isChecked(data, propertyName) {
    for (var i = 0, ilen = data.length; i < ilen; i++) {
        if (!data[i][propertyName]) {
            return false;
        }
    }
    return true;
}
