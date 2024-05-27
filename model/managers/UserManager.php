<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class UserManager extends Manager
{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\User";
    protected $tableName = "user";

    public function __construct()
    {
        parent::connect();
    }

    public function findOneByNickName($nickName)
    {
        $sql = "SELECT * 
                FROM " . $this->tableName . " u 
                WHERE u.nickName = :nickName";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['nickName' => $nickName], false),
            $this->className
        );
    }

    public function findOneByEmail($email)
    {

        $sql = "SELECT * 
                FROM " . $this->tableName . " u 
                WHERE u.email = :email";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['email' => $email], false),
            $this->className
        );
    }

    // Find user with nb topics
    public function findTopicsByUser($id)
    {

        $sql = "SELECT u.id_user, u.nickName, COUNT(t.id_topic) AS nbTopics
                FROM user u
                LEFT JOIN topic t ON u.id_user = t.user_id
                WHERE u.id_user = :id
                ";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['id' => $id], false),
            $this->className
        );
    }

    // find users with nb posts
    public function findPostsByUser()
    {

        $sql = "SELECT u.id_user, u.nickName, COUNT(p.id_post) AS nbPosts
                FROM user u
                LEFT JOIN post p ON u.id_user = p.user_id
                GROUP BY u.id_user";

        return $this->getMultipleResults(
            DAO::select($sql),
            $this->className
        );
    }

    public function findLastPost($id)
    {

        $sql = "SELECT u.id_user, u.nickName, (p.content) AS lastPost, p.publicationDate
                FROM user u
                LEFT JOIN post p ON u.id_user = p.user_id
                WHERE id_user = :id
                ORDER BY publicationDate DESC
                LIMIT 1";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['id_user' => $id], false),
            $this->className
        );
    }
}
