<?php
/**
 * Created by PhpStorm.
 * User: boom
 * Date: 15.09.14
 * Time: 18:39
 */

require_once 'auth.php';

//const MAX_FILE_SIZE = 1000000;
//$TYPE_FILES = array('text/csv');
//
//if($_FILES['file']['size'] >= MAX_FILE_SIZE) {
//    echo json_encode(array('success'=>'false','error'=>'File to large!'));
//    exit;
//}
//
//if(!in_array($_FILES['file']['type'],$TYPE_FILES)) {
//    echo json_encode(array('success'=>'false','error'=>'File format not supported!'));
//    exit;
//}
$path = '../../doc/samples/employees.csv';//$_FILES['file']['tmp_name'];
$up = new \Helpers\CSVFileReader;
$up->read($path);
echo $up->validation();

