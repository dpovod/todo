<?php

require_once "Request.php";

class Route {

    public $controller = 'HomeController';

    public $action = 'getHomeAction';

    public $request;

    private $url = '';

    private $fullUrl = '';

    public function __construct() {
        $routeParts = explode('/', $_SERVER['REQUEST_URI']);
        $controllerName = null;

        if (!empty($routeParts[1])) {
            $controllerName = ucfirst($routeParts[1]);
            $this->controller = $controllerName . 'Controller';
        }

        if (!empty($routeParts[2])) {
            $routeParts[2] = preg_replace('/\?.+/', '', $routeParts[2]);
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $this->action = 'get'. ucfirst($routeParts[2]) . 'Action';
            } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $this->action = 'post'. ucfirst($routeParts[2]) . 'Action';
            }
        }

        if (!empty($routeParts[1]) && !empty($routeParts[2])) {
            $this->url = $routeParts[1] . '/' . $routeParts[2];
        }

        $this->fullUrl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $this->request = new Request();
    }

    public function start() {
        $controllerPath = 'Controllers/' . $this->controller . '.php';

        if (file_exists($controllerPath)) {
            include $controllerPath;
            $this->controller = "Controllers\\" . $this->controller;
        } else {
            self::abort404();
        }

        $controller = new $this->controller($this);
        $action = $this->action;
        if (method_exists($controller, $action)) {
            $controller->$action();
            $this->request->clearTmpSessionVariables();
        } else {
            self::abort404();
        }
    }

    public static function abort404() {
        header('HTTP/1.1 404 Not Found');
        header('Status: 404 Not Found');
        View::render('404');
        exit();
    }

    public static function redirectTo($link) {
        if ($link == '/') {
            $link = '';
        }
        header('Location: http://' . $_SERVER['SERVER_NAME'] . '/' . $link);
        exit;
    }

    public function getCurrentBaseUrl() {
        return $this->url;
    }

    public function getFullUrl() {
        return $this->fullUrl;
    }

    public function getFullUrlWithNewParameter($paramName = '', $paramValue = '') {
        $request = $this->request;

        $url = $this->fullUrl;

        if ($request->has($paramName)) {
            $value = $request->get($paramName);
            $url = str_replace($paramName . '=' . $value, $paramName . '=' . $paramValue, $url);
        } else {
            if (strpos($url, '?') !== false) {
                $url = $url . '&' . $paramName . '=' . $paramValue;
            } else {
                $url = $url . '?' . $paramName . '=' . $paramValue;
            }
        }

        return $url;
    }
}
