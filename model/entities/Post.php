<?php

namespace Model\Entities;

use App\Entity;

final class Post extends Entity
{

    private $id;
    private $content;
    private $publicationDate;
    private $user;
    private $topic;
    private $test;

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
    
    // ******************* Content *******************

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    // ******************* Publication Date *******************
    
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
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
    
    // ******************* Topic *******************

    public function getTopic()
    {
        return $this->topic;
    }

    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }

    // ******************* __toString *******************

    public function __toString()
    {
        return $this->content;
    }
}
