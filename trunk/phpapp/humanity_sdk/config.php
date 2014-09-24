<?php

$api = new Humanity\Api(array(
    'client_id' => '95982517764489216',
    'client_secret' => null,
    'redirect_uri' => 'http://www.humanity.dev/php_sdk/oauth.php',
));

// This is changed to match our endpoints
$api->setAuthorizeEndpoint('https://master-accounts.dev.humanity.com/oauth2/authorize');
$api->setTokenEndpoint('https://master-accounts.dev.humanity.com/oauth2/token');
$api->setApiEndpoint('https://master-api.dev.humanity.com/v1/');