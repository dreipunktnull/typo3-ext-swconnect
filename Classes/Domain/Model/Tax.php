<?php

namespace DPN\SwConnect\Domain\Model;

class Tax
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $tax;

    /**
     * @var string
     */
    protected $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Tax
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTax(): string
    {
        return $this->tax;
    }

    /**
     * @param string $tax
     * @return Tax
     */
    public function setTax(string $tax): self
    {
        $this->tax = $tax;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Tax
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}
