<?php

namespace DPN\SwConnect\Domain\Model;

class Link
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
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var string
     */
    protected $target;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Link
     */
    public function setId(int $id): Link
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getArticleId(): int
    {
        return $this->articleId;
    }

    /**
     * @param int $articleId
     * @return Link
     */
    public function setArticleId(int $articleId): Link
    {
        $this->articleId = $articleId;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Link
     */
    public function setName(string $name): Link
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return Link
     */
    public function setLink(string $link): Link
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param string $target
     * @return Link
     */
    public function setTarget(string $target): Link
    {
        $this->target = $target;
        return $this;
    }
}
