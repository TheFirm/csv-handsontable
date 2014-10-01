<?php
namespace Humanity\Storage;

/**
 * Interface StorageInterface
 * @package Humanity\Storage
 */
interface StorageInterface {

    /**
     * Sets token data.
     *
     * @param array $data
     */
    public function set(array $data);

    /**
     * Gets token data.
     *
     * @return array
     */
    public function get();

    /**
     * Gets access token.
     *
     * @return string
     */
    public function getAccessToken();

    /**
     * Sets access token.
     *
     * @param string $accessToken
     */
    public function setAccessToken($accessToken);

    /**
     * Gets token expiration.
     *
     * @return int
     */
    public function getExpiresIn();

    /**
     * Sets token expiration.
     *
     * @param int $expiresIn
     */
    public function setExpiresIn($expiresIn);

    /**
     * Gets token type.
     *
     * @return string
     */
    public function getTokenType();

    /**
     * Sets token type.
     *
     * @param string $tokenType
     */
    public function setTokenType($tokenType);

    /**
     * Gets scope.
     *
     * @return string
     */
    public function getScope();

    /**
     * Sets scope.
     *
     * @param array $scope
     */
    public function setScope($scope);

} 