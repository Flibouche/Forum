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

    public function register($data)
    {
        $keys = array_keys($data);

        $values = array_values($data);

        $sql = "INSERT INTO " . $this->tableName . "
                (" . implode(',', $keys) . ") 
                VALUES
                ('" . implode("','", $values) . "')";
        try {
            return DAO::insert($sql);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }
}
