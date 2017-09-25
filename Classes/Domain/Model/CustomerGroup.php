<?php

namespace DPN\SwConnect\Domain\Model;

class CustomerGroup
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var boolean
     */
    protected $tax;

    /**
     * @var boolean
     */
    protected $taxInput;

    /**
     * @var boolean
     */
    protected $mode;

    /**
     * @var float
     */
    protected $discount;

    /**
     * @var int
     */
    protected $minimumOrder;

    /**
     * @var int
     */
    protected $minimumOrderSurcharge;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return CustomerGroup
     */
    public function setId(int $id): CustomerGroup
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return CustomerGroup
     */
    public function setKey($key = null): CustomerGroup
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTax()
    {
        return $this->tax;
    }

    /**
     * @param bool $tax
     * @return CustomerGroup
     */
    public function setTax(bool $tax): CustomerGroup
    {
        $this->tax = $tax;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTaxInput()
    {
        return $this->taxInput;
    }

    /**
     * @param bool $taxInput
     * @return CustomerGroup
     */
    public function setTaxInput(bool $taxInput): CustomerGroup
    {
        $this->taxInput = $taxInput;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMode()
    {
        return $this->mode;
    }

    /**
     * @param bool $mode
     * @return CustomerGroup
     */
    public function setMode(bool $mode): CustomerGroup
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param float $discount
     * @return CustomerGroup
     */
    public function setDiscount($discount = 0): CustomerGroup
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return int
     */
    public function getMinimumOrder()
    {
        return $this->minimumOrder;
    }

    /**
     * @param int $minimumOrder
     * @return CustomerGroup
     */
    public function setMinimumOrder(int $minimumOrder = 0): CustomerGroup
    {
        $this->minimumOrder = $minimumOrder;
        return $this;
    }

    /**
     * @return int
     */
    public function getMinimumOrderSurcharge()
    {
        return $this->minimumOrderSurcharge;
    }

    /**
     * @param int $minimumOrderSurcharge
     * @return CustomerGroup
     */
    public function setMinimumOrderSurcharge(int $minimumOrderSurcharge = 0): CustomerGroup
    {
        $this->minimumOrderSurcharge = $minimumOrderSurcharge;
        return $this;
    }
}
