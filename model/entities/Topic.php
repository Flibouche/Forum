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
    private $creationDate;
    private $isLocked;
    private $category;
    private $user;
    private $nbPosts;

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

    // ******************* Creation Date *******************
    
    public function getCreationDate()
    {
        return $this->creationDate;
    }
    
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }
    
    // ******************* Is Locked *******************
    
    public function getIsLocked()
    {
        return $this->isLocked;
    }

    public function setIsLocked($isLocked)
    {
        $this->isLocked = $isLocked;

        return $this;
    }
    
    // ******************* Category *******************

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;

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

    // ******************* NB Posts *******************

    public function getNbPosts()
    {
        return $this->nbPosts;
    }

    public function setNbPosts($nbPosts)
    {
        $this->nbPosts = $nbPosts;

        return $this;
    }

    // ******************* __toString *******************

    public function __toString()
    {
        return $this->title;
    }
}
