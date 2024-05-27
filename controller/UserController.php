<?php

namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\PostManager;
use Model\Managers\UserManager;

class UserController extends AbstractController implements ControllerInterface
{
    public function listUsers()
    {
        // Initialisation du gestionnaire d'utilisateurs
        $userManager = new UserManager();

        // Récupération de tous les utilisateurs, triés par nickname de manière décroissante
        $users = $userManager->findAll(["nickName", "DESC"]);

        // Retourne les informations nécessaires pour afficher la vue
        return [
            // Chemin vers le fichier de vue qui affichera les utilisateurs
            "view" => VIEW_DIR . "user/listUsers.php",

            // Description meta pour la page, utile pour le SEO
            "meta_description" => "Liste des utilisateurs",

            // Données à passer à la vue
            "data" => [
                // Les utilisateurs récupérés, passés à la vue
                "users" => $users
            ]
        ];
    }

    public function displayUser($id)
    {
        // Initialisation du gestionnaire d'utilisateurs
        $userManager = new UserManager();

        // Récupération de l'utilisateur correspondant au pseudo fourni
        $user = $userManager->findOneById($id);
        // $nbTopics = $userManager->findTopicsByUser($id);
        // $user = $userManager->findOneByNickName($nickName);

        if (!$user) {
            $this->redirectTo("home", "index");
        } else {
            // Retourne les informations nécessaires pour afficher la vue
            return [
                // Chemin vers le fichier de vue qui affichera les informations de l'utilisateur
                "view" => VIEW_DIR . "user/displayUser.php",

                // Description meta pour la page, utile pour le SEO
                "meta_description" => "Information de l'utilisateur : " . $user,

                // Données à passer à la vue
                "data" => [
                    // L'utilisateur récupéré, passé à la vue
                    "user" => $user
                ]
            ];
        }
    }
}
