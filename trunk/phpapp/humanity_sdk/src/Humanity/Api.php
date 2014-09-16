<?php
namespace Humanity;

use Guzzle\Common\Exception\RuntimeException;
use Guzzle\Http\Client;
use Guzzle\Http\Message\RequestInterface;
use Humanity\Storage\SessionStorage;
use Humanity\Storage\StorageInterface;

/**
 * Class Api
 * @package Humanity
 */
class Api {

    /**
     * Authorize endpoint.
     * @var string
     */
    protected $_authorizeEndpoint = 'http://accounts.humanity.com/oauth2/authorize';

    /**
     * Token endpoint.
     * @var string
     */
    protected $_tokenEndpoint = 'http://accounts.humanity.com/oauth2/token';

    /**
     * API endpoint.
     * @var string
     */
    protected $_apiEndpoint = 'http://api.humanity.com/v1/';

    /**
     * Client id.
     * @var string
     */
    protected $_clientId;

    /**
     * Client secret.
     * @var string|null
     */
    protected $_clientSecret;

    /**
     * Redirect URI
     * @var string
     */
    protected $_redirectUri;

    /**
     * Token data storage.
     * @var StorageInterface
     */
    protected $_storage;


    /**
     * @param array $options
     * @param StorageInterface $storage
     */
    public function __construct(array $options, StorageInterface $storage = null) {
        $options = array_merge(array(
            'client_id' => null,
            'client_secret' => null,
            'redirect_uri' => null,
        ), $options);

        $this->setClientId($options['client_id']);
        $this->setClientSecret($options['client_secret']);
        $this->setRedirectUri($options['redirect_uri']);
        $this->setStorage($storage?: new SessionStorage());
    }

    /**
     * Gets authorize endpoint.
     *
     * @return string
     */
    public function getAuthorizeEndpoint() {
        return $this->_authorizeEndpoint;
    }

    /**
     * Sets authorize endpoint.
     *
     * @param string $authorizeEndpoint
     */
    public function setAuthorizeEndpoint($authorizeEndpoint) {
        $this->_authorizeEndpoint = $authorizeEndpoint;
    }

    /**
     * Gets token endpoint.
     *
     * @return string
     */
    public function getTokenEndpoint() {
        return $this->_tokenEndpoint;
    }

    /**
     * Sets token endpoint.
     *
     * @param string $tokenEndpoint
     */
    public function setTokenEndpoint($tokenEndpoint) {
        $this->_tokenEndpoint = $tokenEndpoint;
    }

    /**
     * Gets api endpoint.
     *
     * @return string
     */
    public function getApiEndpoint() {
        return $this->_apiEndpoint;
    }

    /**
     * Sets api endpoint.
     *
     * @param string $apiEndpoint
     */
    public function setApiEndpoint($apiEndpoint) {
        $this->_apiEndpoint = $apiEndpoint;
    }

    /**
     * Gets client id.
     *
     * @return string
     */
    public function getClientId() {
        return $this->_clientId;
    }

    /**
     * Sets client id.
     *
     * @param string $clientId
     * @throws Exception
     */
    public function setClientId($clientId) {
        if (!is_string($clientId) || !$clientId) {
            throw new Exception('Invalid client id');
        }

        $this->_clientId = $clientId;
    }

    /**
     * Gets client secret.
     *
     * @return null|string
     */
    public function getClientSecret() {
        return $this->_clientSecret;
    }

    /**
     * Sets client secret.
     *
     * @param string $clientSecret
     * @throws Exception
     */
    public function setClientSecret($clientSecret) {
        $this->_clientSecret = $clientSecret;
    }

    /**
     * Gets redirect uri.
     *
     * @return string
     */
    public function getRedirectUri() {
        return $this->_redirectUri;
    }

    /**
     * Sets redirect uri.
     *
     * @param string $redirectUri
     */
    public function setRedirectUri($redirectUri) {
        $this->_redirectUri = $redirectUri;
    }

    /**
     * Gets storage instance.
     *
     * @return StorageInterface
     */
    public function getStorage() {
        return $this->_storage;
    }

    /**
     * Sets storage instance.
     *
     * @param StorageInterface $storage
     */
    public function setStorage($storage) {
        $this->_storage = $storage;
    }

    /**
     * Gets authorize URI.
     *
     * @todo Set scope. Currently Humanity API doesn't support scope.
     * @todo Implement state.
     * @todo Remove company_id.
     *
     * @return string
     */
    public function getAuthorizeUri() {
        $data = array (
            'client_id' => $this->_clientId,
            'response_type' => 'code',
            'state' => '123123',
            'company_id' => '',
        );

        if (null !== $this->_redirectUri) {
            $data['redirect_uri'] = $this->_redirectUri;
        }

        return $this->_authorizeEndpoint . '?' . http_build_query($data, null, '&');
    }

    /**
     * Request token with authorization code.
     *
     * @todo Implement state.
     *
     * @return bool
     * @throws Exception
     */
    public function requestTokenWithAuthCode() {
        $authorizationCode = filter_input(INPUT_GET, 'code');

        if (!$authorizationCode) {
            return false;
        }

        $data = array (
            'client_id' => $this->_clientId,
            'client_secret' => $this->_clientSecret,
            'code' => $authorizationCode,
            'grant_type' => 'authorization_code'
        );

        if (null !== $this->_redirectUri) {
            $data['redirect_uri'] = $this->_redirectUri;
        }

        $client = new Client();

        try {
            $request = $client->post($this->_tokenEndpoint);
            $request->addPostFields($data);
            $request->addHeader('Accept', 'application/json');

            $responseData = $request->send()->json();
            $this->_storage->set($responseData);
        } catch (RuntimeException $e) {
            throw new Exception('Can\'t grant access token.');
        }

        return true;
    }

    /**
     * Checks if access token is granted.
     *
     * @return bool
     */
    public function hasAccessToken() {
        return (bool) $this->_storage->getAccessToken();
    }

    /**
     * Execute GET http method.
     *
     * @param $resource
     * @param array $arguments
     * @return Response
     */
    public function get($resource, array $arguments = array()) {
        $client = new Client($this->_apiEndpoint);
        $request = $client->get($resource);
        $request->addHeader('Accept', 'application/json');

        $this->_prepareQueryString($request, $arguments);

        return new Response($request->send()->json());
    }

    /**
     * Execute POST http method.
     *
     * @param $resource
     * @param array $arguments
     * @return Response
     */
    public function post($resource, array $arguments = array()) {
        $client = new Client($this->_apiEndpoint);
        $request = $client->post($resource, null, $arguments);
        $request->addHeader('Accept', 'application/json');

        $this->_prepareQueryString($request);

        return new Response($request->send()->json());
    }

    /**
     * Execute PUT http method.
     *
     * @param $resource
     * @param array $arguments
     * @return Response
     */
    public function put($resource, array $arguments = array()) {
        $client = new Client($this->_apiEndpoint);
        $request = $client->put($resource, null, $arguments);
        $request->addHeader('Accept', 'application/json');

        $this->_prepareQueryString($request);

        return new Response($request->send()->json());
    }

    /**
     * Execute DELETE http method.
     *
     * @param $resource
     * @param array $arguments
     * @return Response
     */
    public function delete($resource, array $arguments = array()) {
        $client = new Client($this->_apiEndpoint);
        $request = $client->delete($resource, null, $arguments);
        $request->addHeader('Accept', 'application/json');

        $this->_prepareQueryString($request);

        return new Response($request->send()->json());
    }

    /**
     * Prepare query string for request.
     *
     * @param RequestInterface $request
     * @param array $arguments
     */
    protected function _prepareQueryString(RequestInterface $request, array $arguments = array()) {
        $query = $request->getQuery();
        $query->merge($arguments);
        $query->set('access_token', $this->_storage->getAccessToken());
        $query->set('suppress_response_codes', 1);
    }
}