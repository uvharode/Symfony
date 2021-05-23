<?php

namespace App\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="articles")
 */
class Article
{

    /**
     * @MongoDB\Id
     */
    protected $id;
    /** @MongoDB\Field(type="string") */
    protected $title;
    /** @MongoDB\Field(type="string") */
    protected $author;
    /** @MongoDB\Field(type="string") */
    protected $content;
    

    public function getId()
    {
        return $this->id;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }
    public function getTitle()
    {
        return $this->title;
    }

    public function setAuthor(string $author)
    {
        $this->author = $author;
        return $this;
    }
    public function getAuthor()
    {
        return $this->author;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }
    public function getContent()
    {
        return $this->content;
    }

}