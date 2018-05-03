<?php

namespace DPN\SwConnect\Domain\Model;

class Price
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
    protected $articleDetailsId;

    /**
     * @var string
     */
    protected $customerGroupKey;

    /**
     * @var mixed
     */
    protected $from;

    /**
     * @var mixed
     */
    protected $to;

    /**
     * @var float|int
     */
    protected $price;

    /**
     * @var int
     */
    protected $pseudoPrice;

    /**
     * @var int
     */
    protected $basePrice;

    /**
     * @var float
     */
    protected $percent;

    /**
     * @var CustomerGroup
     */
    protected $customerGroup;

    /**
     * @var string
     */
    protected $grossFormatted;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Price
     */
    public function setId(int $id): self
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
     * @return Price
     */
    public function setArticleId(int $articleId): self
    {
        $this->articleId = $articleId;
        return $this;
    }

    /**
     * @return int
     */
    public function getArticleDetailsId()
    {
        return $this->articleDetailsId;
    }

    /**
     * @param int $articleDetailsId
     * @return Price
     */
    public function setArticleDetailsId(int $articleDetailsId): self
    {
        $this->articleDetailsId = $articleDetailsId;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerGroupKey()
    {
        return $this->customerGroupKey;
    }

    /**
     * @param string $customerGroupKey
     * @return Price
     */
    public function setCustomerGroupKey(string $customerGroupKey): self
    {
        $this->customerGroupKey = $customerGroupKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     * @return Price
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     * @return Price
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return float|int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float|int $price
     * @return Price
     */
    public function setPrice($price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getPseudoPrice()
    {
        return $this->pseudoPrice;
    }

    /**
     * @param int $pseudoPrice
     * @return Price
     */
    public function setPseudoPrice(int $pseudoPrice): self
    {
        $this->pseudoPrice = $pseudoPrice;
        return $this;
    }

    /**
     * @return int
     */
    public function getBasePrice()
    {
        return $this->basePrice;
    }

    /**
     * @param int $basePrice
     * @return Price
     */
    public function setBasePrice(int $basePrice): self
    {
        $this->basePrice = $basePrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * @param float $percent
     * @return Price
     */
    public function setPercent($percent = 0.0): self
    {
        $this->percent = $percent;
        return $this;
    }

    /**
     * @return CustomerGroup
     */
    public function getCustomerGroup()
    {
        return $this->customerGroup;
    }

    /**
     * @param CustomerGroup $customerGroup
     * @return Price
     */
    public function setCustomerGroup(CustomerGroup $customerGroup): self
    {
        $this->customerGroup = $customerGroup;
        return $this;
    }

    /**
     * @return string
     */
    public function getGrossFormatted()
    {
        return $this->grossFormatted;
    }

    /**
     * @param string $grossFormatted
     * @return Price
     */
    public function setGrossFormatted($grossFormatted = '')
    {
        $this->grossFormatted = $grossFormatted;
        return $this;
    }
}
