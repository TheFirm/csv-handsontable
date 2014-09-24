<?php
require_once '../vendor/autoload.php';
require_once 'config.php';


if (!$api->hasAccessToken()) {
    header('Location: oauth.php');
    exit;
}

$credentials = $api->get('oauth/credentials');
var_dump($credentials);
$employees = $api->get("companies/{$credentials['company_id']}/employees");
var_dump($employees);

