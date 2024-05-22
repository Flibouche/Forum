<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class PostManager extends Manager
{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Post";
    protected $tableName = "post";

    public function __construct()
    {
        parent::connect();
    }

    public function findPostsByTopic($id)
    {

        $sql = "SELECT * 
        FROM " . $this->tableName . " p
        WHERE p.topic_id = :id";

        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }

    public function findOneByContent($content)
    {

        $sql = "SELECT * 
                FROM " . $this->tableName . " p
                WHERE p.content = :content";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['content' => $content], false),
            $this->className
        );
    }

    public function countPostsByTopic($id)
    {

        $sql = "SELECT COUNT(*) as post_count
        FROM " . $this->tableName . " p
        WHERE p.topic_id = :id
        ";

        return $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]),
            $this->className
        );
    }
}
