<?php
/**
 * Created by PhpStorm.
 * User: oops
 * Date: 10/9/2014
 * Time: 11:11 PM
 */

namespace Helpers;

/**
 * Class HumanityApiClient
 * @package Helpers
 *
 * @property \Humanity\Api $apiClient
 */
class HumanityApiClient{
    protected $apiClient;

    function __construct($conf)
    {
        $this->init($conf);
    }

    public function authorize() {
        if (!$this->apiClient->hasAccessToken() && !$this->apiClient->requestTokenWithAuthCode()) {
            // No valid access token available, go to authorization server
            header('Location: ' . $this->apiClient->getAuthorizeUri());
            exit;
        }
        return $this;
    }

    protected function init($conf){
        $this->apiClient = new \Humanity\Api($conf['humanity-sdk']);

        $endPoints = $conf['humanity-sdk']['endPoints'];
        // This is changed to match our endpoints
        $this->apiClient->setAuthorizeEndpoint($endPoints['authorize']);
        $this->apiClient->setTokenEndpoint($endPoints['token']);
        $this->apiClient->setApiEndpoint($endPoints['api']);

        $this->apiClient->requestTokenWithAuthCode();
    }
} 