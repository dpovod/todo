<?php

namespace Controllers;
use \Controller;
use \View;

 class HomeController extends Controller {

    public function getHomeAction() {
        View::render('home');
    }
 }
