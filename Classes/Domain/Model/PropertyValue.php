<?php

namespace DPN\SwConnect\Domain\Model;

class PropertyValue
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var int
     */
    protected $position;

    /**
     * @var int
     */
    protected $optionId;

    /**
     * @var string
     */
    protected $valueNumeric;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PropertyValue
     */
    public function setId(int $id): PropertyValue
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return PropertyValue
     */
    public function setValue(string $value): PropertyValue
    {
        $this->value = $value;
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
     * @return PropertyValue
     */
    public function setPosition(int $position): PropertyValue
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return int
     */
    public function getOptionId()
    {
        return $this->optionId;
    }

    /**
     * @param int $optionId
     * @return PropertyValue
     */
    public function setOptionId(int $optionId): PropertyValue
    {
        $this->optionId = $optionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getValueNumeric()
    {
        return $this->valueNumeric;
    }

    /**
     * @param string $valueNumeric
     * @return PropertyValue
     */
    public function setValueNumeric(string $valueNumeric): PropertyValue
    {
        $this->valueNumeric = $valueNumeric;
        return $this;
    }
}
