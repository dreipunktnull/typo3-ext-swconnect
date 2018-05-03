<?php

namespace DPN\SwConnect\Domain\Model;

class Unit
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $unit;

    /**
     * @var string
     */
    protected $name;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Unit
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     * @return Unit
     */
    public function setUnit(string $unit): self
    {
        $this->unit = $unit;
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
     * @return Unit
     */
    public function setName(string $name = ''): self
    {
        $this->name = $name;
        return $this;
    }
}
