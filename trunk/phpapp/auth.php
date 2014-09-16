<?php
/**
 * Created by PhpStorm.
 * User: boom
 * Date: 15.09.14
 * Time: 12:31
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';
require_once 'humanity_sdk/config.php';

if (!$api->hasAccessToken()) {
    var_dump('No auth');
//    header('Location: auth.php');
//    exit;
}


