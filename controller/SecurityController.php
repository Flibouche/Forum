<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;

use Model\Managers\UserManager;

class SecurityController extends AbstractController
{
    // contiendra les méthodes liées à l'authentification : register, login et logout

    public function register()
    {
        $session = new Session();
        $userManager = new UserManager();

        $nickName = filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
        $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($nickName && $email && $pass1 & $pass2) {
            $user = $userManager->findOneByEmail($email);

            if ($user) {
                Session::addFlash("error", "This pseudo or email is already use !");
                $this->redirectTo("home");
            } else {
                if ($pass1 == $pass2 && strlen($pass1) >= 5) {
                    $userManager->add(["nickName" => $nickName, "password" => password_hash($pass1, PASSWORD_DEFAULT), "email" => $email, "role" => "ROLE_USER"]);
                    Session::addFlash("success", "Registered successfully !");
                    $this->redirectTo("home");
                }
            }
        }

        return [
            "view" => VIEW_DIR . "security/register.php",
            "meta_description" => "Register to the forum"
        ];
    }

    public function login()
    {
        $session = new Session();
        $userManager = new UserManager();

        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($email && $password) {
            $user = $userManager->findOneByEmail($email);

            if ($user) {
                $hash = $user->getPassword();
                if (password_verify($password, $hash)) {
                    $session->setUser($user);
                    Session::addFlash("success", "You are connected !");
                    $this->redirectTo("home");
                }
            } else {
                Session::addFlash("error", "The pseudo/password is not correct !");
                $this->redirectTo("home");
            }
        }

        return [
            "view" => VIEW_DIR . "security/login.php",
            "meta_description" => "Login to the forum"
        ];
    }

    public function logout()
    {
        unset($_SESSION["user"]);
        $this->redirectTo("home");
    }

    public function profile()
    {
        return [
            "view" => VIEW_DIR . "security/profile.php",
            "meta_description" => "Profile"        
        ];
    }
}
