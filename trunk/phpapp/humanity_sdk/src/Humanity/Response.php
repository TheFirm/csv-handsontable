<?php
namespace Humanity;

use ArrayObject;

/**
 * Class Response
 * @package Humanity
 */
class Response extends ArrayObject {

    /**
     * @var int
     */
    protected $_status;

    /**
     * @var array|null
     */
    protected $_error;

    /**
     * @param array $response
     */
    public function __construct(array $response) {
        parent::__construct($response['data']?: array(), ArrayObject::ARRAY_AS_PROPS);
        $this->_status = $response['status'];
        $this->_error = $response['error'];
    }

    /**
     * Gets status.
     *
     * @return int
     */
    public function getStatus() {
        return $this->_status;
    }

    /**
     * Sets status.
     *
     * @param int $status
     */
    public function setStatus($status) {
        $this->_status = $status;
    }

    /**
     * Gets error.
     *
     * @return array|null
     */
    public function getError() {
        return $this->_error;
    }

    /**
     * Sets error.
     *
     * @param array|null $error
     */
    public function setError($error) {
        $this->_error = $error;
    }

}