<?php

namespace DPN\SwConnect\Domain\Model;

class Supplier
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $image;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $metaDescription;

    /**
     * @var string
     */
    protected $metaKeywords;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Supplier
     */
    public function setId(int $id): Supplier
    {
        $this->id = $id;
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
     * @return Supplier
     */
    public function setName(string $name = null): Supplier
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return Supplier
     */
    public function setImage(string $image = null): Supplier
    {
        $this->image = $image;
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
     * @return Supplier
     */
    public function setLink(string $link = null): Supplier
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Supplier
     */
    public function setDescription(string $description = null): Supplier
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param string $metaDescription
     * @return Supplier
     */
    public function setMetaDescription(string $metaDescription = null): Supplier
    {
        $this->metaDescription = $metaDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * @param string $metaKeywords
     * @return Supplier
     */
    public function setMetaKeywords(string $metaKeywords = null): Supplier
    {
        $this->metaKeywords = $metaKeywords;
        return $this;
    }
}
