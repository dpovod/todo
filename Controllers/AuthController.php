<?php

namespace Controllers;
//@todo: добавить в autoload
require_once __DIR__ . '/../Models/User.php';
use Illuminate\Support\Facades\Validator;
use Models\User;
use \View;

class AuthController extends \Controller {

    public function getLoginAction() {
        View::render('auth/login');
    }

    public function postLoginAction() {
        $request = $this->request;
        if (!User::logIn($request->get('email'), $request->get('password'))) {
            $_SESSION['errors'] = ['Неправильный email или пароль'];
            \Route::redirectTo('auth/login');
        } else {
            \Route::redirectTo('/');
        }
    }

    public function getRegisterAction() {
        View::render('auth/register');
    }

    public function postRegisterAction() {
        $request = $this->request;
        $validate = User::validate($request->getRequestData());

        if ($validate === true) {
            if (User::create($request->getRequestData())) {
                $_SESSION['success'] = 'Успешная регистрация';
                \Route::redirectTo('auth/login');
            } else {
                $_SESSION['errors'] = ['Ошибка'];
                \Route::redirectTo('auth/register');
            }
        } else {
            $_SESSION['errors'] = $validate;
            \Route::redirectTo('auth/register');
        }
    }

    public function getLogoutAction() {
        if (!empty($_SESSION['isLoggedIn'])) {
            unset($_SESSION['isLoggedIn']);
        }
        \Route::redirectTo('/');
    }
}
