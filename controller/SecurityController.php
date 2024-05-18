<?php

namespace Controller;

use App\AbstractController;
use App\ControllerInterface;

class SecurityController extends AbstractController
{
    // contiendra les méthodes liées à l'authentification : register, login et logout

    public function register()
    {
        return [
            "view" => VIEW_DIR . "security/register.php",
            "meta_description" => "Register to the forum"
        ];

        $nickName = filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
        $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function login()
    {
        return [
            "view" => VIEW_DIR . "security/login.php",
            "meta_description" => "Login to the forum"
        ];
    }

    public function logout()
    {
        unset($_SESSION["user"]);
        header("location:index.php");
        exit;
    }
}