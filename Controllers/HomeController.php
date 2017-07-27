<?php

namespace Controllers;

 class HomeController extends \Controller {

    public function getHomeAction() {
        \View::render('home');
    }
 }
