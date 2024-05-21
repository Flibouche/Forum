<?php

namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\PostManager;
use Model\Managers\TopicManager;
use Model\Managers\UserManager;

class ForumController extends AbstractController implements ControllerInterface
{

    public function index()
    {
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categoryManager->findAll(["name", "DESC"]);

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR . "forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories
            ]
        ];
    }

    public function listTopicsByCategory($id)
    {

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id);

        return [
            "view" => VIEW_DIR . "forum/listTopics.php",
            "meta_description" => "Liste des topics par catégorie : " . $category,
            "data" => [
                "category" => $category,
                "topics" => $topics
            ]
        ];
    }

    public function listUsers()
    {

        $userManager = new UserManager();
        $users = $userManager->findAll(["nickName", "DESC"]);
        // var_dump($users->current());die;

        return [
            "view" => VIEW_DIR . "forum/listUsers.php",
            "meta_description" => "Liste des utilisateurs",
            "data" => [
                "users" => $users
            ]
        ];
    }

    public function displayUser($id)
    {
        // Afficher les informations de la personne

        $userManager = new UserManager();
        $user = $userManager->findOneById($id);

        return [
            "view" => VIEW_DIR . "forum/displayUser.php",
            "meta_description" => "Information de l'utilisateur : " . $user,
            "data" => [
                "user" => $user
            ]
        ];
    }

    public function listPosts($id)
    {

        $topicManager = new TopicManager();
        $postManager = new PostManager();
        $topic = $topicManager->findOneById($id);
        $posts = $postManager->findPostsByTopic($id);

        return [
            "view" => VIEW_DIR . "forum/listPosts.php",
            "meta_description" => "Liste des posts du topic",
            "data" => [
                "topic" => $topic,
                "posts" => $posts
            ]
        ];
    }

    public function addPost($id)
    {
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        $postManager = new PostManager();

        // Si l'utilisateur est connecté
        // if (Session::getUser()) {
        // Récupération de l'ID de l'utilisateur connecté (pour l'affecter au post crée)
        // $user = $_SESSION['user']->getId();

        // Si on soumet le formulaire
        if (isset($_POST['submit'])) {
            // On vérifie que les données existent et qu'elles sont valides
            if (isset($_POST['content']) && (!empty($_POST['content']))) {
                $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                // if (Session::getTokenCSRF() =/= $_POST['csrfToken']) {
                // $this->redirectTo("security, "logOut");
                // }
                // Si le filtre passe
                if ($content) {
                    // Ajout du post en BDD + message de confirmation
                    $postManager->add(["topic_id" => $id, "user_id" => 1, "content" => $content]);
                    Session::addFlash("success", "Post added successfully !");
                    $this->redirectTo("forum", "listPosts", $id);
                }
            }
        }
        // }
    }

    public function addTopic($id)
    {
        // Pour ajouter un topic il faudra ajouter un message automatiquement
        // La méthode add sera appelé 2 fois
        // topicManager add idtopic car le post aura besoin de l'ID du topic (stocker dans une variable)

        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topicManager = new TopicManager();
        $postManager = new PostManager();

        if (isset($_POST['submit'])) {
            if (isset($_POST['title']) && (!empty($_POST['title']))) {

                $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                if ($title) {
                    $idTopic = $topicManager->add(["category_id" => $id, "user_id" => 1, "title" => $title]);

                    if (isset($_POST['content']) && (!empty($_POST['content']))) {

                        $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                        if ($content) {
                            $postManager->add(["topic_id" => $idTopic, "user_id" => 1, "content" => $content]);
                            Session::addFlash("success", "Topic added successfully !");
                            $this->redirectTo("forum", "listTopic", $id);
                        }
                    }
                } else {
                    Session::addFlash("error", "Please enter a post");
                    $this->redirectTo("forum", "listTopic");
                }
            }
        }
    }
}
