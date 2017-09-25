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
     * @var double
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
    public function setId(int $id): Currency
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
    public function setCurrency(string $currency): Currency
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
    public function setName($name = ''): Currency
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
    public function setDefault($default = 0): Currency
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
     * @param double $factor
     * @return Currency
     */
    public function setFactor($factor = 0.0): Currency
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
    public function setSymbol($symbol = ''): Currency
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
    public function setSymbolPosition($symbolPosition = 0): Currency
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
    public function setPosition($position = 0): Currency
    {
        $this->position = $position;
        return $this;
    }
}
