<?php

namespace DPN\SwConnect\Domain\Model;

class Currency
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $default;

    /**
     * @var float
     */
    protected $factor;

    /**
     * @var string
     */
    protected $symbol;

    /**
     * @var int
     */
    protected $symbolPosition;

    /**
     * @var int
     */
    protected $position;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Currency
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return Currency
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;
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
     * @return Currency
     */
    public function setName($name = ''): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param int $default
     * @return Currency
     */
    public function setDefault($default = 0): self
    {
        $this->default = $default;
        return $this;
    }

    /**
     * @return float
     */
    public function getFactor()
    {
        return $this->factor;
    }

    /**
     * @param float $factor
     * @return Currency
     */
    public function setFactor($factor = 0.0): self
    {
        $this->factor = $factor;
        return $this;
    }

    /**
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @param string $symbol
     * @return Currency
     */
    public function setSymbol($symbol = ''): self
    {
        $this->symbol = $symbol;
        return $this;
    }

    /**
     * @return int
     */
    public function getSymbolPosition()
    {
        return $this->symbolPosition;
    }

    /**
     * @param int $symbolPosition
     * @return Currency
     */
    public function setSymbolPosition($symbolPosition = 0): self
    {
        $this->symbolPosition = $symbolPosition;
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
     * @return Currency
     */
    public function setPosition($position = 0): self
    {
        $this->position = $position;
        return $this;
    }
}
