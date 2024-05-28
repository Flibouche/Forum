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

            $profilePicture = "./public/uploads/profilePictures/default.webp";

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

    public function profile()
    {
        $user = Session::getUser();

        return [
            "view" => VIEW_DIR . "security/profile.php",
            "meta_description" => "Profile of " . $user,
            "data" => [
                // Les utilisateurs récupérés, passés à la vue
                "user" => $user
            ]
        ];
    }

    public function listUsers()
    {
        // Initialisation du gestionnaire d'utilisateurs
        $userManager = new UserManager();

        // Récupération de tous les utilisateurs, triés par nickname de manière décroissante
        $users = $userManager->findAll(["nickName", "DESC"]);

        // Retourne les informations nécessaires pour afficher la vue
        return [
            // Chemin vers le fichier de vue qui affichera les utilisateurs
            "view" => VIEW_DIR . "security/listUsers.php",

            // Description meta pour la page, utile pour le SEO
            "meta_description" => "See users from the forum",

            // Données à passer à la vue
            "data" => [
                // Les utilisateurs récupérés, passés à la vue
                "users" => $users
            ]
        ];
    }

    public function ban($id)
    {

        $this->restrictTo("ROLE_ADMIN");

        $userManager = new UserManager();
        $user = $userManager->findOneById($id);

        if ($user) {
            $data = array(
                'isBanned' => 1
            );
        }

        $userManager->update($data, $id);

        Session::addFlash("success", "User banned succesfully !");
        $this->redirectTo("security", "listUsers");
    }

    public function unban($id)
    {
        $this->restrictTo("ROLE_ADMIN");

        $userManager = new UserManager();
        $user = $userManager->findOneById($id);

        if ($user) {
            $data = array(
                'isBanned' => 0
            );
        }

        $userManager->update($data, $id);

        Session::addFlash("success", "User unbanned succesfully !");
        $this->redirectTo("security", "listUsers");
    }

    public function uploadProfilePicture($id)
    {
        // Initialisation du gestionnaire d'utilisateurs
        $userManager = new UserManager();

        // Récupération de l'utilisateur correspondant à l'ID fourni
        $user = $userManager->findOneById($id);

        // Récupération du chemin de l'image de profil actuelle de l'utilisateur
        $userProfilePicture = $user->getProfilePicture();

        // Chemin de l'image par défaut
        $defaultAvatar = "./public/uploads/profilePictures/default.webp";

        // Vérification si le formulaire a été soumis
        if (isset($_POST['submit'])) {
            // Vérification si un fichier a été téléchargé
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                // Récupération des informations sur le fichier téléchargé
                $tmpName = $_FILES['file']['tmp_name'];
                $name = $_FILES['file']['name'];
                $size = $_FILES['file']['size'];
                $error = $_FILES['file']['error'];
                $type = $_FILES['file']['type'];

                // Extraction de l'extension du fichier
                $tabExtension = explode('.', $name);
                $extension = strtolower(end($tabExtension));

                // Extensions autorisées
                $allowedExtensions = ['jpg', 'png', 'jpeg', 'webp'];

                // Taille maximale autorisée
                $maxSize = 10000000;

                // Génération d'un nom unique pour le fichier
                $uniqueName = uniqid('', true);

                // Vérification de la taille du fichier
                if ($size >= $maxSize) {
                    // Affichage d'un message d'erreur
                    Session::addFlash("error", "Problem with size image !");
                    // Redirection vers la page de profil
                    $this->redirectTo("security", "profile");
                } elseif ($error > 0) {
                    Session::addFlash("error", "Error on the upload file !");
                    $this->redirectTo("security", "profile");
                } elseif (!in_array($extension, $allowedExtensions)) {
                    Session::addFlash("error", "Incorrect file extension !");
                    $this->redirectTo("security", "profile");
                }

                if ($userProfilePicture !== $defaultAvatar) {
                    unlink($userProfilePicture);
                }

                // Déplacement du fichier téléchargé vers le dossier des images de profil
                $file = $uniqueName . '.' . $extension;
                move_uploaded_file($tmpName, './public/uploads/profilePictures/' . $file);

                // Création de l'image à partir du fichier
                $profilePicture = imagecreatefromstring(file_get_contents('./public/uploads/profilePictures/' . $file));

                // Obtention des dimensions de l'image
                $width = imagesx($profilePicture);
                $height = imagesy($profilePicture);

                // Dimensions souhaitées pour l'image redimensionnée
                $newWidth = 200; // Nouvelle largeur souhaitée
                $newHeight = 200; // Nouvelle hauteur souhaitée

                // Création d'une nouvelle ressource image pour l'image redimensionnée
                $resizedProfilePicture = imagecreatetruecolor($newWidth, $newHeight);

                // Redimensionnement de l'image
                imagecopyresampled($resizedProfilePicture, $profilePicture, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                // Chemin pour l'image redimensionnée au format webp
                $resizedWebpPath = "./public/uploads/profilePictures/" . $uniqueName . "_resized.webp";

                // Conversion de l'image redimensionnée en format webp
                imagewebp($resizedProfilePicture, $resizedWebpPath);

                // Suppression de l'image JPG ou PNG téléchargée (en amont, elle a été convertie en webp)
                unlink('./public/uploads/profilePictures/' . $file);

                // Chemin du fichier pour la base de données
                $pathFile = $resizedWebpPath;

                // Données à mettre à jour dans la base de données
                $data = [
                    "profilePicture" => $pathFile
                ];

                // Mise à jour des données utilisateur dans la base de données
                $userManager->update($data, $id);

                // Suppression de l'utilisateur de la session
                unset($_SESSION["user"]);

                // Récupération des données de l'utilisateur mise à jour
                $user = $userManager->findOneById($id);

                // Mise à jour de la session avec les nouvelles données de l'utilisateur
                Session::setUser($user);

                // Affichage d'un message de succès
                Session::addFlash("success", "Profile picture uploaded successfully !");

                // Redirection vers la page de profil
                $this->redirectTo("security", "profile");
            } else {
                Session::addFlash("error", "There's no file uploaded !");
                $this->redirectTo("security", "profile");
            }
        }
    }
}
