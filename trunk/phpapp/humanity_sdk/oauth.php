<?php
/**
 * Created by PhpStorm.
 * User: boom
 * Date: 15.09.14
 * Time: 12:32
 */

require_once '../vendor/autoload.php';
require_once 'config.php';

if (!$api->hasAccessToken() && !$api->requestTokenWithAuthCode()) {
// No valid access token available, go to authorization server
    header('Location: ' . $api->getAuthorizeUri());
    exit;
}

header('Location: ../');
