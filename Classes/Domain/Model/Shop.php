<?php

namespace DPN\SwConnect\Domain\Model;

class Shop
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $mainId;

    /**
     * @var int
     */
    protected $categoryId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    protected $position;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string[]
     */
    protected $hosts;

    /**
     * @var bool
     */
    protected $secure;

    /**
     * @var bool
     */
    protected $alwaysSecure;

    /**
     * @var string
     */
    protected $secureHost;

    /**
     * @var string
     */
    protected $secureBasePath;

    /**
     * @var bool
     */
    protected $default;

    /**
     * @var bool
     */
    protected $active;

    /**
     * @var bool
     */
    protected $customerScope;

    /**
     * @var Currency
     */
    protected $currency;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Shop
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getMainId()
    {
        return $this->mainId;
    }

    /**
     * @param int $mainId
     * @return Shop
     */
    public function setMainId($mainId = null): self
    {
        $this->mainId = $mainId;
        return $this;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     * @return Shop
     */
    public function setCategoryId($categoryId): self
    {
        $this->categoryId = $categoryId;
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
     * @return Shop
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Shop
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
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
     * @return Shop
     */
    public function setPosition(int $position): self
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return Shop
     */
    public function setHost($host = ''): self
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @param string $basePath
     * @return Shop
     */
    public function setBasePath($basePath = ''): self
    {
        $this->basePath = $basePath;
        return $this;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     * @return Shop
     */
    public function setBaseUrl($baseUrl = ''): self
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getHosts()
    {
        return $this->hosts;
    }

    /**
     * @param string[] $hosts
     * @return Shop
     */
    public function setHosts($hosts = [])
    {
        $this->hosts = $hosts;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSecure()
    {
        return $this->secure;
    }

    /**
     * @param bool $secure
     * @return Shop
     */
    public function setSecure($secure = false): self
    {
        $this->secure = $secure;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAlwaysSecure()
    {
        return $this->alwaysSecure;
    }

    /**
     * @param bool $alwaysSecure
     * @return Shop
     */
    public function setAlwaysSecure(bool $alwaysSecure): self
    {
        $this->alwaysSecure = $alwaysSecure;
        return $this;
    }

    /**
     * @return string
     */
    public function getSecureHost()
    {
        return $this->secureHost;
    }

    /**
     * @param string $secureHost
     * @return Shop
     */
    public function setSecureHost($secureHost = ''): self
    {
        $this->secureHost = $secureHost;
        return $this;
    }

    /**
     * @return string
     */
    public function getSecureBasePath()
    {
        return $this->secureBasePath;
    }

    /**
     * @param string $secureBasePath
     * @return Shop
     */
    public function setSecureBasePath($secureBasePath = ''): self
    {
        $this->secureBasePath = $secureBasePath;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDefault()
    {
        return $this->default;
    }

    /**
     * @param bool $default
     * @return Shop
     */
    public function setDefault($default = false): self
    {
        $this->default = $default;
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
     * @return Shop
     */
    public function setActive($active = false): self
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCustomerScope()
    {
        return $this->customerScope;
    }

    /**
     * @param bool $customerScope
     * @return Shop
     */
    public function setCustomerScope($customerScope = false): self
    {
        $this->customerScope = $customerScope;
        return $this;
    }

    /**
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     * @return Shop
     */
    public function setCurrency(Currency $currency): self
    {
        $this->currency = $currency;
        return $this;
    }
}
