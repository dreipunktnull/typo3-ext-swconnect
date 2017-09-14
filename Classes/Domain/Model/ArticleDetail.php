<?php

namespace DPN\SwConnect\Domain\Model;

class ArticleDetail
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
    protected $unitId;

    /**
     * @var string
     */
    protected $number;

    /**
     * @var int
     */
    protected $supplierNumber;

    /**
     * @var int
     */
    protected $kind;

    /**
     * @var string
     */
    protected $additionalText;

    /**
     * @var bool
     */
    protected $active;

    /**
     * @var int
     */
    protected $inStock;

    /**
     * @var int
     */
    protected $stockMin;

    /**
     * @var float
     */
    protected $weight;

    /**
     * @var string
     */
    protected $widht;

    /**
     * @var string
     */
    protected $height;

    /**
     * @var string
     */
    protected $len;

    /**
     * @var string
     */
    protected $ean;

    /**
     * @var string
     */
    protected $purchasePrice;

    /**
     * @var int
     */
    protected $position;

    /**
     * @var string
     */
    protected $seoUrl;

    /**
     * @var Article[]
     */
    protected $prices;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ArticleDetail
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
     * @return ArticleDetail
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;
        return $this;
    }

    /**
     * @return int
     */
    public function getUnitId()
    {
        return $this->unitId;
    }

    /**
     * @param int $unitId
     * @return ArticleDetail
     */
    public function setUnitId($unitId)
    {
        $this->unitId = $unitId;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return ArticleDetail
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return int
     */
    public function getSupplierNumber()
    {
        return $this->supplierNumber;
    }

    /**
     * @param int $supplierNumber
     * @return ArticleDetail
     */
    public function setSupplierNumber($supplierNumber)
    {
        $this->supplierNumber = $supplierNumber;
        return $this;
    }

    /**
     * @return int
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * @param int $kind
     * @return ArticleDetail
     */
    public function setKind($kind)
    {
        $this->kind = $kind;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdditionalText()
    {
        return $this->additionalText;
    }

    /**
     * @param string $additionalText
     * @return ArticleDetail
     */
    public function setAdditionalText($additionalText)
    {
        $this->additionalText = $additionalText;
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
     * @return ArticleDetail
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return int
     */
    public function getInStock()
    {
        return $this->inStock;
    }

    /**
     * @param int $inStock
     * @return ArticleDetail
     */
    public function setInStock($inStock)
    {
        $this->inStock = $inStock;
        return $this;
    }

    /**
     * @return int
     */
    public function getStockMin()
    {
        return $this->stockMin;
    }

    /**
     * @param int $stockMin
     * @return ArticleDetail
     */
    public function setStockMin($stockMin)
    {
        $this->stockMin = $stockMin;
        return $this;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     * @return ArticleDetail
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return string
     */
    public function getWidht()
    {
        return $this->widht;
    }

    /**
     * @param string $widht
     * @return ArticleDetail
     */
    public function setWidht($widht)
    {
        $this->widht = $widht;
        return $this;
    }

    /**
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param string $height
     * @return ArticleDetail
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return string
     */
    public function getLen()
    {
        return $this->len;
    }

    /**
     * @param string $len
     * @return ArticleDetail
     */
    public function setLen($len)
    {
        $this->len = $len;
        return $this;
    }

    /**
     * @return string
     */
    public function getEan()
    {
        return $this->ean;
    }

    /**
     * @param string $ean
     * @return ArticleDetail
     */
    public function setEan($ean)
    {
        $this->ean = $ean;
        return $this;
    }

    /**
     * @return string
     */
    public function getPurchasePrice()
    {
        return $this->purchasePrice;
    }

    /**
     * @param string $purchasePrice
     * @return ArticleDetail
     */
    public function setPurchasePrice($purchasePrice)
    {
        $this->purchasePrice = $purchasePrice;
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
     * @return ArticleDetail
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return string
     */
    public function getSeoUrl()
    {
        return $this->seoUrl;
    }

    /**
     * @param string $seoUrl
     */
    public function setSeoUrl(string $seoUrl = null)
    {
        $this->seoUrl = $seoUrl;
    }

    /**
     * @return Article[]
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @param Article[] $prices
     */
    public function setPrices(array $prices = [])
    {
        $this->prices = $prices;
    }
}
