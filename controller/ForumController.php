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
        // Initialisation des gestionnaires de topics et de catégories
        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
    
        // Récupération de la catégorie correspondante à l'ID fourni
        $category = $categoryManager->findOneById($id);
    
        // Récupération des topics associés à la catégorie
        $topics = $topicManager->findTopicsByCategory($id);
    
        // Retourne les informations nécessaires pour afficher la vue
        return [
            // Chemin vers le fichier de vue qui affichera les topics
            "view" => VIEW_DIR . "forum/listTopics.php",
            
            // Description meta pour la page, utile pour le SEO
            "meta_description" => "Liste des topics par catégorie : " . $category,
            
            // Données à passer à la vue
            "data" => [
                // La catégorie récupérée, passée à la vue
                "category" => $category,
                
                // Les topics associés à la catégorie, passés à la vue
                "topics" => $topics
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
            "view" => VIEW_DIR . "forum/listUsers.php",
    
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
    
        // Récupération de l'utilisateur correspondant à l'ID fourni
        $user = $userManager->findOneById($id);
    
        // Retourne les informations nécessaires pour afficher la vue
        return [
            // Chemin vers le fichier de vue qui affichera les informations de l'utilisateur
            "view" => VIEW_DIR . "forum/displayUser.php",
            
            // Description meta pour la page, utile pour le SEO
            "meta_description" => "Information de l'utilisateur : " . $user,
            
            // Données à passer à la vue
            "data" => [
                // L'utilisateur récupéré, passé à la vue
                "user" => $user
            ]
        ];
    }

    public function listPosts($id)
    {
        // Initialisation des gestionnaires de topics et de posts
        $topicManager = new TopicManager();
        $postManager = new PostManager();
    
        // Récupération du topic correspondant à l'ID fourni
        $topic = $topicManager->findOneById($id);
    
        // Récupération des posts associés au topic
        $posts = $postManager->findPostsByTopic($id);
    
        // Retourne les informations nécessaires pour afficher la vue
        return [
            // Chemin vers le fichier de vue qui affichera les posts
            "view" => VIEW_DIR . "forum/listPosts.php",
            
            // Description meta pour la page, utile pour le SEO
            "meta_description" => "Liste des posts du topic",
            
            // Données à passer à la vue
            "data" => [
                // Le topic récupéré, passé à la vue
                "topic" => $topic,
                
                // Les posts associés au topic, passés à la vue
                "posts" => $posts
            ]
        ];
    }
    
    public function addPost($id)
    {
        // Initialisation des gestionnaires de topics et de posts
        $topicManager = new TopicManager();
        $postManager = new PostManager();
    
        // Récupération du topic correspondant à l'ID fourni
        $topic = $topicManager->findOneById($id);
    
        // if (Session::getUser()) {}
        // $user = $_SESSION['user']->getId();
        
        // Vérification si le formulaire a été soumis
        if (isset($_POST['submit'])) {
            // Vérifie que le champ 'content' est défini et non vide
            if (isset($_POST['content']) && (!empty($_POST['content']))) {
                // Sanitize le contenu du post pour éviter les injections de code
                $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
                // Si le contenu est valide, ajoute un nouveau post
                if ($content) {
                    // Ajout du post avec l'ID du topic et un ID utilisateur statique (à remplacer par l'ID réel de l'utilisateur connecté)
                    $postManager->add(["topic_id" => $id, "user_id" => 1, "content" => $content]);
    
                    // Ajoute un message de succès et redirige vers la liste des posts du topic
                    Session::addFlash("success", "Post added successfully !");
                    $this->redirectTo("forum", "listPosts", $id);
                }
            }
        }
    }

    public function addTopic($id)
    {
        // Initialisation des gestionnaires de catégories, de sujets et de messages
        $categoryManager = new CategoryManager();
        $topicManager = new TopicManager();
        $postManager = new PostManager();
    
        // Récupération de la catégorie correspondante à l'ID fourni
        $category = $categoryManager->findOneById($id);
    
        // Vérifie si le formulaire a été soumis
        if (isset($_POST['submit'])) {
    
            // Vérifie si le champ 'title' est défini et non vide
            if (isset($_POST['title']) && (!empty($_POST['title']))) {
    
                // Sanitize et capitaliser le titre
                $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $title = ucfirst($title);
    
                // Si le titre est valide, ajoute un nouveau topic
                if ($title) {
                    // Ajout du topic et récupération de l'ID du nouveau topic
                    $idTopic = $topicManager->add(["category_id" => $id, "user_id" => 1, "title" => $title]);
    
                    // Vérifie si le champ 'content' est défini et non vide
                    if (isset($_POST['content']) && (!empty($_POST['content']))) {
    
                        // Sanitize le contenu
                        $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
                        // Si le contenu est valide, ajoute un nouveau post associé au topic
                        if ($content) {
                            $postManager->add(["topic_id" => $idTopic, "user_id" => 1, "content" => $content]);
    
                            // Ajoute un message de succès et redirige vers la liste des topics de la catégorie
                            Session::addFlash("success", "Topic added successfully !");
                            $this->redirectTo("forum", "listTopic", $id);
                        }
                    }
                } else {
                    // Si le titre n'est pas valide, ajoute un message d'erreur
                    Session::addFlash("error", "Please enter a post");
                    $this->redirectTo("forum", "listTopic");
                }
            }
        }
    }

    public function deleteTopic($id)
    {
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);

        if (!$topic) {
            Session::addFlash("error", "It doesn't work !");
            $this->redirectTo("home", "index");
        } else {
            $topicManager->delete($id);
            Session::addFlash("success", "Topic deleted !");
            $this->redirectTo("forum", "listTopic");
        }
    }

    public function deletePost($id)
    {
        $topicManager = new TopicManager();
        $topic = $topicManager->findOneById($id);
        $postManager = new postManager();
        $post = $postManager->findOneById($id);

        if (!$post) {
            Session::addFlash("error", "It doesn't work !");
            $this->redirectTo("home", "index");
        } else {
            $postManager->delete($id);
            Session::addFlash("success", "Post deleted !");
            $this->redirectTo("forum", "listsPosts", $id);
        }
    }

    public function addCategory($id)
    {
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findCategoryByName($id);

        if (isset($_POST['submit'])) {
            if (isset($_POST['name']) && (!empty($_POST['name']))) {

                $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $name = ucfirst($name);

                if ($name) {
                    $topicManager->add(["category_id" => $id, "user_id" => 1, "title" => $title]);
                }
            }
        }
    }
}

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