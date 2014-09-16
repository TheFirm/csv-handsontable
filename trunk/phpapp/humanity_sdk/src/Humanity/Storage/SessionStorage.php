<?php

namespace Humanity\Storage;

/**
 * Class SessionStorage
 * @package Humanity\Storage
 */
class SessionStorage implements StorageInterface {

    /**
     * Session storage construct.
     */
    public function __construct() {
        // Start session
        if ('' === session_id()) {
            session_start();
        }
    }

    /**
     * Gets token data.
     *
     * @return array
     */
    public function get() {
        if (!isset($_SESSION['humanity']['token'])) {
            return false;
        }

        return $_SESSION['humanity']['token'];
    }

    /**
     * Sets token data.
     *
     * @param array $data
     */
    public function set(array $data) {
        $_SESSION['humanity']['token'] = $data;
    }

    /**
     * Gets access token.
     *
     * @return string
     */
    public function getAccessToken() {
        if (!isset($_SESSION['humanity']['token']['access_token'])) {
            return false;
        }

        return $_SESSION['humanity']['token']['access_token'];
    }

    /**
     * Sets access token.
     *
     * @param string $accessToken
     */
    public function setAccessToken($accessToken) {
        $_SESSION['humanity']['token']['access_token'] = $accessToken;
    }

    /**
     * Gets token expiration.
     *
     * @return int
     */
    public function getExpiresIn() {
        if (!isset($_SESSION['humanity']['token']['expires_in'])) {
            return false;
        }

        return $_SESSION['humanity']['token']['expires_in'];
    }

    /**
     * Sets token expiration.
     *
     * @param int $expiresIn
     */
    public function setExpiresIn($expiresIn) {
        $_SESSION['humanity']['token']['expires_in'] = $expiresIn;
    }

    /**
     * Gets token type.
     *
     * @return string
     */
    public function getTokenType() {
        if (!isset($_SESSION['humanity']['token']['token_type'])) {
            return false;
        }

        return $_SESSION['humanity']['token']['token_type'];
    }

    /**
     * Sets token type.
     *
     * @param string $tokenType
     */
    public function setTokenType($tokenType) {
        $_SESSION['humanity']['token']['token_type'] = $tokenType;
    }

    /**
     * Gets scope.
     *
     * @return string
     */
    public function getScope() {
        if (!isset($_SESSION['humanity']['token']['scope'])) {
            return false;
        }

        return $_SESSION['humanity']['token']['scope'];
    }

    /**
     * Sets scope.
     *
     * @param array $scope
     */
    public function setScope($scope) {
        $_SESSION['humanity']['token']['scope'] = $scope;
    }

}