<?php

namespace DPN\SwConnect\Domain\Model;

class Attribute
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $articleId;

    /**
     * @var int
     */
    protected $articleDetailId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Attribute
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * @param int $articleId
     * @return Attribute
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;
        return $this;
    }

    /**
     * @return int
     */
    public function getArticleDetailId()
    {
        return $this->articleDetailId;
    }

    /**
     * @param int $articleDetailId
     * @return Attribute
     */
    public function setArticleDetailId($articleDetailId)
    {
        $this->articleDetailId = $articleDetailId;
        return $this;
    }
}
