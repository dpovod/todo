<?php

namespace Models;
use Illuminate\Database\Eloquent\Model as Model;

class User extends Model {

    public static function validate ($data) {
        $errors = [];

        if (empty($data['email'])) {
            $errors[] = 'Пустой email';
        }

        if (empty($data['password'])) {
            $errors[] = 'Пустой пароль';
        }

        if (empty($errors)) {
            $email = preg_replace('/.*<script(.*?)>(.*?)<\/script>/', '', $data['email']);

            if (empty($email)) {
                $errors[] = 'Пустой email';
            } else {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Неверный email';
                } else {
                    $user = User::where('email', $email)->first();

                    if (!empty($user)) {
                        $errors[] = 'Этот email уже используется';
                    }
                }
            }
        }

        if (!empty($errors)) {
            return $errors;
        }

        return true;
    }

    public static function create($data) {
        try {
            $user = new User();
            $user->email = $data['email'];
            $user->password = md5($data['password']);

            return $user->save();
        } catch (\Exception $e) {
            return false;
        }

    }

    public static function logIn($email, $password) {
        $user = User::where('email', $email)
            ->where('password', md5($password))
            ->first();

        if (!empty($user)) {
            $_SESSION['isLoggedIn'] = 1;
            $_SESSION['email'] = $email;
            return true;
        }

        return false;
    }

    public static function logOut() {
        unset($_SESSION['isLoggedIn']);
        unset($_SESSION['email']);
    }

    public static function getLoggedUserEmail() {
        if (!empty($_SESSION['email'])) {
            return $_SESSION['email'];
        } else {
            return null;
        }
    }
}
