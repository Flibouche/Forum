<?php

namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class Topic extends Entity
{

    private $id;
    private $title;
    private $user;
    private $category;
    private $creationDate;
    private $closed;

    public function __construct($data)
    {
        $this->hydrate($data);
    }

    // ******************* ID *******************

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    // ******************* Title *******************

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    // ******************* User *******************

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    // ******************* __toString *******************

    public function __toString()
    {
        return $this->title;
    }
}
