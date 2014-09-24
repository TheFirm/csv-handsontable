<?php

require_once '../vendor/autoload.php';
require_once 'config.php';

if (!$api->hasAccessToken() && !$api->requestTokenWithAuthCode()) {
// No valid access token available, go to authorization server
    header('Location: ' . $api->getAuthorizeUri());
    exit;
}

header('Location: ../index.php');
