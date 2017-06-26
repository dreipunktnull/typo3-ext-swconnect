<?php

namespace DPN\SwConnect\Domain\Model;

class Category
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $parentId;

    /**
     * @var int
     */
    protected $streamId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $position;

    /**
     * @var string
     */
    protected $metaTitle;

    /**
     * @var string
     */
    protected $metaKeywords;

    /**
     * @var string
     */
    protected $metaDescription;

    /**
     * @var string
     */
    protected $cmsHeadline;

    /**
     * @var string
     */
    protected $cmsText;

    /**
     * @var bool
     */
    protected $active;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var string
     */
    protected $productBoxLayout;

    /**
     * @var bool
     */
    protected $blog;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $external;

    /**
     * @var bool
     */
    protected $hideFilter;

    /**
     * @var bool
     */
    protected $hideTop;

    /**
     * @var \DateTime
     */
    protected $changed;

    /**
     * @var \DateTime
     */
    protected $added;

    /**
     * @var int
     */
    protected $mediaId;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Category
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param int $parentId
     * @return Category
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
        return $this;
    }

    /**
     * @return int
     */
    public function getStreamId()
    {
        return $this->streamId;
    }

    /**
     * @param int $streamId
     * @return Category
     */
    public function setStreamId($streamId = null)
    {
        $this->streamId = $streamId;
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
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return Category
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * @param string $metaTitle
     * @return Category
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;
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
     * @return Category
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
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
     * @return Category
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getCmsHeadline()
    {
        return $this->cmsHeadline;
    }

    /**
     * @param string $cmsHeadline
     * @return Category
     */
    public function setCmsHeadline($cmsHeadline)
    {
        $this->cmsHeadline = $cmsHeadline;
        return $this;
    }

    /**
     * @return string
     */
    public function getCmsText()
    {
        return $this->cmsText;
    }

    /**
     * @param string $cmsText
     * @return Category
     */
    public function setCmsText($cmsText)
    {
        $this->cmsText = $cmsText;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return Category
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     * @return Category
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return string
     */
    public function getProductBoxLayout()
    {
        return $this->productBoxLayout;
    }

    /**
     * @param string $productBoxLayout
     * @return Category
     */
    public function setProductBoxLayout($productBoxLayout)
    {
        $this->productBoxLayout = $productBoxLayout;
        return $this;
    }

    /**
     * @return bool
     */
    public function isBlog()
    {
        return $this->blog;
    }

    /**
     * @param bool $blog
     * @return Category
     */
    public function setBlog($blog)
    {
        $this->blog = $blog;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return Category
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getExternal()
    {
        return $this->external;
    }

    /**
     * @param string $external
     * @return Category
     */
    public function setExternal($external)
    {
        $this->external = $external;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHideFilter()
    {
        return $this->hideFilter;
    }

    /**
     * @param bool $hideFilter
     * @return Category
     */
    public function setHideFilter($hideFilter)
    {
        $this->hideFilter = $hideFilter;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHideTop()
    {
        return $this->hideTop;
    }

    /**
     * @param bool $hideTop
     * @return Category
     */
    public function setHideTop($hideTop)
    {
        $this->hideTop = $hideTop;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getChanged()
    {
        return $this->changed;
    }

    /**
     * @param \DateTime $changed
     * @return Category
     */
    public function setChanged(\DateTime $changed = null)
    {
        $this->changed = $changed;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * @param \DateTime $added
     * @return Category
     */
    public function setAdded(\DateTime $added = null)
    {
        $this->added = $added;
        return $this;
    }

    /**
     * @return int
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }

    /**
     * @param int $mediaId
     * @return Category
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;
        return $this;
    }
}
