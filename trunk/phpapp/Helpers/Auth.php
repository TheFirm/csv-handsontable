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

        // This is changed to match our endpoints
        $api->setAuthorizeEndpoint('https://master-accounts.dev.humanity.com/oauth2/authorize');
        $api->setTokenEndpoint('https://master-accounts.dev.humanity.com/oauth2/token');
        $api->setApiEndpoint('https://master-api.dev.humanity.com/v1/');

        if (!$api->hasAccessToken() && !$api->requestTokenWithAuthCode()) {
            // No valid access token available, go to authorization server
            header('Location: ' . $api->getAuthorizeUri());
            exit;
        }

        return $api;
    }
} 