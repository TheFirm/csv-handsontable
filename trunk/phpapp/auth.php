<?php
/**
 * Created by PhpStorm.
 * User: boom
 * Date: 15.09.14
 * Time: 12:31
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'humanity_sdk/config.php';

if (!$api->hasAccessToken() && !$api->requestTokenWithAuthCode()) {
// No valid access token available, go to authorization server
    header('Location: ' . $api->getAuthorizeUri());
    exit;
}

//
//$credentials = $api->get('oauth/credentials');
//var_dump($credentials);
//$employees = $api->get("companies/{$credentials['company_id']}/employees");
//var_dump($employees);


