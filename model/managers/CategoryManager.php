<?php

namespace Model\Managers;

use App\Manager;
use App\DAO;

class CategoryManager extends Manager
{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Category";
    protected $tableName = "category";

    public function __construct()
    {
        parent::connect();
    }

    public function findCategoryByName($name)
    {
        $sql = "SELECT * 
                FROM " . $this->tableName . " c
                WHERE c.name = :name";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['name' => $name], false),
            $this->className
        );
    }

    public function findAllCategories()
    {
        $sql = "SELECT c.name, c.id_category, COUNT(t.id_topic) AS nbTopics
                FROM category c
                LEFT JOIN topic t ON c.id_category = t.category_id
                GROUP BY c.id_category
                ORDER BY c.name";

        return $this->getMultipleResults(
            DAO::select($sql),
            $this->className
        );
    }

    public function findNbTopicsByCategory($id)
    {
        $sql = "SELECT COUNT(t.id_topic) AS nbTopics
        FROM category c
        LEFT JOIN topic t ON c.id_category = t.category_id
        WHERE c.id_category = :id
        ";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['id' => $id], false),
            $this->className
        );
    }
}
