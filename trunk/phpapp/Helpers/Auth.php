<?php

namespace Helpers;

use Humanity\Api;

class Auth {

    /**
     * @param $conf string[] humanity-sdk config array
     * @return \Humanity\Api
     * @throws \Humanity\Exception
     */
    public static function authorize($conf) {
        $api = new Api($conf['humanity-sdk']);

        $endPoints = $conf['humanity-sdk']['endPoints'];
        // This is changed to match our endpoints
        $api->setAuthorizeEndpoint($endPoints['authorize']);
        $api->setTokenEndpoint($endPoints['token']);
        $api->setApiEndpoint($endPoints['api']);

        if (!$api->hasAccessToken() && !$api->requestTokenWithAuthCode()) {
            // No valid access token available, go to authorization server
            header('Location: ' . $api->getAuthorizeUri());
            exit;
        }

        return $api;
    }
} 