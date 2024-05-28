<?php

namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class User extends Entity
{

    private $id;
    private $nickName;
    private $password;
    private $email;
    private $role;
    private $inscriptionDate;
    private $profilePicture;
    private $isBanned;
    private $nbTopics;
    private $nbPosts;
    private $lastTopic;
    private $lastPost;

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

    // ******************* NickName *******************

    public function getNickName()
    {
        return $this->nickName;
    }

    public function setNickName($nickName)
    {
        $this->nickName = $nickName;

        return $this;
    }

    // ******************* Password *******************

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    // ******************* Email *******************

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    // ******************* Role *******************
    
    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    public function hasRole($role)
    {
        if (in_array($role, json_decode($this->getRole()))) {
            return true;
        }
        return false;
    }

    // ******************* Role *******************

    public function getInscriptionDate()
    {
        return $this->inscriptionDate;
    }

    public function setInscriptionDate($inscriptionDate)
    {
        $this->inscriptionDate = $inscriptionDate;

        return $this;
    }

    // ******************* Profile Picture *******************
    
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    // ******************* Is Banned *******************

    public function getIsBanned()
    {
        return $this->isBanned;
    }

    public function setIsBanned($isBanned)
    {
        $this->isBanned = $isBanned;

        return $this;
    }

    // ******************* NB Topics *******************
    
    public function getNbTopics()
    {
        return $this->nbTopics;
    }

    public function setNbTopics($nbTopics)
    {
        $this->nbTopics = $nbTopics;

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

    // ******************* Last Topic *******************
    
    public function getLastTopic()
    {
        return $this->lastTopic;
    }

    public function setLastTopic($lastTopic)
    {
        $this->lastTopic = $lastTopic;

        return $this;
    }
    
    // ******************* Last Post *******************

    public function getLastPost()
    {
        return $this->lastPost;
    }

    public function setLastPost($lastPost)
    {
        $this->lastPost = $lastPost;

        return $this;
    }

    // ******************* __toString *******************

    public function __toString()
    {
        return $this->nickName;
    }
}
