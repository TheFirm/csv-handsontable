<?php
/**
 * Created by PhpStorm.
 * User: boom
 * Date: 15.09.14
 * Time: 12:28
 */

$api = new Humanity\Api(array(
    'client_id' => '90102200730124288',
    'client_secret' => null,
    'redirect_uri' => 'http://localhost/oauth',
));

$api->setAuthorizeEndpoint('http://www.master.accounts.humanity.com/oauth2/authorize');
$api->setTokenEndpoint('http://www.master.accounts.humanity.com/oauth2/token');
$api->setApiEndpoint('http://www.master.api.humanity.com/v1/');
