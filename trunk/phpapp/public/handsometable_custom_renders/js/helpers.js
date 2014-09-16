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

}

function isFileExtentionValid(f){
    return /\.csv$/.test(f.name);
}
