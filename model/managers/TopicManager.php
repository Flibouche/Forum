<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class TopicManager extends Manager
{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";

    public function __construct()
    {
        parent::connect();
    }

    // récupérer tous les topics d'une catégorie spécifique (par son id)
    public function findTopicsByCategory($id)
    {

        $sql = "SELECT * 
                FROM " . $this->tableName . " t 
                WHERE t.category_id = :id";

        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }

    public function findTopicByTitle($title)
    {
        $sql = "SELECT * 
                FROM " . $this->tableName . " t
                WHERE t.title = :title";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['title' => $title], false),
            $this->className
        );
    }

    public function findPostsByTopics()
    {
        $sql = "SELECT t.title, t.id_topic, COUNT(p.id_post) AS nbPosts
                FROM topic t
                LEFT JOIN post p ON t.id_topic = p.topic_id
                GROUP BY t.id_topic";

        return $this->getMultipleResults(
            DAO::select($sql),
            $this->className
        );
    }
}
