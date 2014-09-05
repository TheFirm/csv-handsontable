function checkFileApiSupport(){
    if (window.File && window.FileReader && window.FileList && window.Blob) {
        // Great success! All the File APIs are supported.
    } else {
        alert('The File APIs are not fully supported in this browser.');
    }
}


function displayData(results){
    var headers = results[0];
    results.shift();
    $('#handsontable_data').handsontable({
        data: results
        ,rowHeaders: true
        //,colHeaders: true
        ,colHeaders: headers
        ,width: 800
        //,stretchH: 'last'
    });
}

function handleDragOver(evt) {
    evt.stopPropagation();
    evt.preventDefault();
    evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
}

function isFileExtentionValid(f){
    return /\.csv$/.test(f.name);
}
