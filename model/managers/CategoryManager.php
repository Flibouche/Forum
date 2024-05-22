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
}
