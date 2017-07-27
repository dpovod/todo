<?php

class Request {

    private $requestData;

    private $method = 'GET';

    public function __construct() {
        session_start();

        $this->method = $_SERVER['REQUEST_METHOD'];

        if ($this->method == 'GET') {
            $this->requestData = $_GET;
        } elseif ($this->method == 'POST') {
            $this->requestData = array_merge($_POST, $_GET);
        }
    }

    public static function isUserLoggedIn() {
        if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getRequestData() {
        return $this->requestData;
    }

    public function get($parameter, $defaultValue = null) {
        if (!empty($this->requestData[$parameter])) {
            return $this->requestData[$parameter];
        } else {
            return $defaultValue;
        }
    }

    public function has($parameter) {
        if (!empty($this->requestData[$parameter])) {
            return true;
        } else {
            return false;
        }
    }

    public function getMethod() {
        return $this->method;
    }

    public function clearTmpSessionVariables() {
        if (isset($_SESSION['success'])) {
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }
    }
}
