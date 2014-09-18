<?php

ini_set('xdebug.var_display_max_depth', 5);
ini_set('xdebug.var_display_max_children', 256);
ini_set('xdebug.var_display_max_data', 1024);

/**
 * Created by PhpStorm.
 * User: boom
 * Date: 15.09.14
 * Time: 18:39
 */

require_once 'auth.php';


if(isset($_FILES['file'])){
    if($_FILES['file']['size'] >= MAX_FILE_SIZE) {
        echo json_encode(array('success'=>'false','error'=>'File to large!'));
        exit;
    }
    if(!in_array($_FILES['file']['type'],$TYPE_FILES)) {
        echo json_encode(array('success'=>'false','error'=>'File format not supported!'));
        exit;
    }
    $path = $_FILES['file']['tmp_name'];
        $csvFileReader = new \Helpers\CSVFileReader($path);
        $csvFileReader->print_result();
}else{
//    $filename = __DIR__ . '/../../doc/samples/sample_server_response.json';
//    var_dump($filename);
//    if (!file_exists($filename)) {
//        die('No validator config file');
//    }
//    //$res = json_decode(file_get_contents($filename), true);
//    $up = new \Helpers\CSVFileReader(file_get_contents($filename),false);
//    $up->print_result();

    $json = file_get_contents('php://input');
    if($json){
        var_dump($json);
        $obj = json_decode($json);
        var_dump($obj);
    }
}



