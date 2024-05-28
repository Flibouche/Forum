<?php

namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\PostManager;
use Model\Managers\UserManager;

class UserController extends AbstractController implements ControllerInterface
{
    public function displayUser($id)
    {
        // Initialisation du gestionnaire d'utilisateurs
        $userManager = new UserManager();

        $user = $userManager->findOneById($id);
        $topics = $userManager->findNbTopicsByUser($id);
        $posts = $userManager->findNbPostsByUser($id);
        $lastTopic = $userManager->findLastTopic($id);
        $lastPost = $userManager->findLastPost($id);

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
                    "user" => $user,
                    "topics" => $topics,
                    "posts" => $posts,
                    "lastTopic" => $lastTopic,
                    "lastPost" => $lastPost
                ]
            ];
        }
    }
}
