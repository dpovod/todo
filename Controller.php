<?php

class Controller {

    public $route;

    public $request;

    public $view;

    public function __construct(Route $route) {
        $this->view = new View();
        $this->route = $route;
        $this->request = $route->request;
    }

    public function setViewData($data) {
        $this->view->viewData = $data;
    }
}
