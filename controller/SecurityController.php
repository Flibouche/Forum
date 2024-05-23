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

        $userManager = new UserManager();

        if (isset($_POST['submit'])) {

            $nickName = filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $nickName = ucfirst($nickName);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_VALIDATE_EMAIL);
            $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $profilePicture = "/public/uploads/profilePictures/default.webp";

            if ($nickName && $email && $pass1 & $pass2) {
                $verifyNickName = $userManager->findOneByNickName($nickName);
                $verifyEmail = $userManager->findOneByEmail($email);

                if ($verifyNickName || $verifyEmail) {
                    Session::addFlash("error", "This pseudo or email is already in use!");
                    $this->redirectTo("home");
                } else {
                    if ($pass1 == $pass2 && strlen($pass1) >= 5) {
                        $userManager->add(["nickName" => $nickName, "password" => password_hash($pass1, PASSWORD_DEFAULT), "email" => $email, "role" => '["ROLE_USER"]', "profilePicture" => $profilePicture]);
                        Session::addFlash("success", "Registered successfully !");
                        $this->redirectTo("home");
                    } else {
                        Session::addFlash("error", "Password should be at least 5 characters long and match !");
                        $this->redirectTo("home");
                    }
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

        if (isset($_POST['submit'])) {

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

    public function profile($id)
    {
        $userManager = new UserManager();
        $user = $userManager->findOneById($id);

        return [
            "view" => VIEW_DIR . "security/profile.php",
            "meta_description" => "Profile",
            "data" => [
                // Les utilisateurs récupérés, passés à la vue
                "user" => $user
            ]
        ];
    }

    public function uploadProfilePicture($id)
    {
        $userManager = new UserManager();
        $user = $userManager->findOneById($id);
        $userProfilePicture = $user->getProfilePicture();
        $defaultAvatar = "./public/uploads/profilePictures/default.webp";

        if (isset($_POST['submit'])) {
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                $tmpName = $_FILES['file']['tmp_name'];
                $name = $_FILES['file']['name'];
                $size = $_FILES['file']['size'];
                $error = $_FILES['file']['error'];
                $type = $_FILES['file']['type'];

                $tabExtension = explode('.', $name);

                $extension = strtolower(end($tabExtension));

                $allowedExtensions = ['jpg', 'png', 'jpeg', 'webp'];

                $maxSize = 10000000;

                $uniqueName = uniqid('', true);

                if ($size >= $maxSize) {
                    Session::addFlash("error", "Problem with size image !");
                    $this->redirectTo("security", "profile");
                } else if ($error > 0) {
                    Session::addFlash("error", "Error upload file !");
                    $this->redirectTo("security", "profile");
                } elseif (!in_array($extension, $allowedExtensions)) {
                    Session::addFlash("error", "Incorrect file extension!");
                    $this->redirectTo("security", "profile");
                } else {
                    if (isset($userProfilePicture) && $userProfilePicture !== $defaultAvatar) {
                        unlink($userProfilePicture);
                    }

                    $file = $uniqueName . '.' . $extension;
                    move_uploaded_file($tmpName, './public/uploads/profilePictures/' . $file);

                    $profilePicture = imagecreatefromstring(file_get_contents('./public/uploads/profilePictures/' . $file));
                    $webpPath = "./public/uploads/profilePictures/" . $uniqueName . ".webp";
                    imagewebp($profilePicture, $webpPath);
                    unlink('./public/uploads/profilePictures/' . $file);

                    $pathFile = $webpPath;

                    $data = [
                        "profilePicture" => $pathFile
                    ];

                    $userManager->update($data, $id);

                    Session::addFlash("success", "Test !");
                    $this->redirectTo("home");
                }
            }
        }
    }
}
