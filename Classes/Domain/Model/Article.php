<?php

namespace DPN\SwConnect\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use TYPO3\CMS\Core\Collection\CollectionInterface;

class Article
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $mainDetailId;

    /**
     * @var int
     */
    protected $supplierId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $descriptionLong;

    /**
     * @var \DateTime
     */
    protected $added;

    /**
     * @var int
     */
    protected $pseudoSales;

    /**
     * @var bool
     */
    protected $highlight;

    /**
     * @var string
     */
    protected $keywords;

    /**
     * @var string
     */
    protected $metaTitle;

    /**
     * @var \DateTime
     */
    protected $changed;

    /**
     * @var bool
     */
    protected $priceGroupActive;

    /**
     * @var bool
     */
    protected $lastStock;

    /**
     * @var Attribute
     */
    protected $attribute;

    /**
     * @var true
     */
    protected $active;

    /**
     * @var Image[]
     */
    protected $images;

    /**
     * @var ArticleDetail
     */
    protected $mainDetail;

    /**
     * @var Category[]
     */
    protected $categories;

    /**
     * @var Tax
     */
    protected $tax;

    /**
     * @var PropertyValue[]
     */
    protected $propertyValues;

    /**
     * @var CustomerGroup[]
     */
    protected $customerGroups;

    /**
     * @var Link[]
     */
    protected $links;

    /**
     * @var Supplier
     */
    protected $supplier;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->customerGroups = new ArrayCollection();
        $this->links = new ArrayCollection();
        $this->propertyValues = new ArrayCollection();
    }

    /**
     * @return Image[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param Image[] $images
     * @return Article
     */
    public function setImages(array $images = [])
    {
        $this->images = $images;
        return $this;
    }

    /**
     * @param Image $image
     */
    public function addImage(Image $image = null)
    {
        $this->images[] = $image;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Article
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getMainDetailId()
    {
        return $this->mainDetailId;
    }

    /**
     * @param int $mainDetailId
     * @return Article
     */
    public function setMainDetailId($mainDetailId = null)
    {
        $this->mainDetailId = $mainDetailId;

        return $this;
    }

    /**
     * @return int
     */
    public function getSupplierId()
    {
        return $this->supplierId;
    }

    /**
     * @param int $supplierId
     * @return Article
     */
    public function setSupplierId($supplierId = null)
    {
        $this->supplierId = $supplierId;

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
     * @return Article
     */
    public function setName($name = null)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Article
     */
    public function setDescription($description = '')
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescriptionLong()
    {
        return $this->descriptionLong;
    }

    /**
     * @param string $descriptionLong
     * @return Article
     */
    public function setDescriptionLong($descriptionLong = '')
    {
        $this->descriptionLong = $descriptionLong;
        return $this;
    }

    /**
     * @return true
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return Article
     */
    public function setActive($active)
    {
        $this->active = $active;
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
     * @return Article
     */
    public function setAdded(\DateTime $added = null)
    {
        $this->added = $added;
        return $this;
    }

    /**
     * @return int
     */
    public function getPseudoSales()
    {
        return $this->pseudoSales;
    }

    /**
     * @param int $pseudoSales
     * @return Article
     */
    public function setPseudoSales($pseudoSales)
    {
        $this->pseudoSales = $pseudoSales;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHighlight()
    {
        return $this->highlight;
    }

    /**
     * @param bool $highlight
     * @return Article
     */
    public function setHighlight($highlight)
    {
        $this->highlight = $highlight;
        return $this;
    }

    /**
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param string $keywords
     * @return Article
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
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
     * @return Article
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;
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
     * @return Article
     */
    public function setChanged(\DateTime $changed = null)
    {
        $this->changed = $changed;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPriceGroupActive()
    {
        return $this->priceGroupActive;
    }

    /**
     * @param bool $priceGroupActive
     * @return Article
     */
    public function setPriceGroupActive($priceGroupActive)
    {
        $this->priceGroupActive = $priceGroupActive;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLastStock()
    {
        return $this->lastStock;
    }

    /**
     * @param bool $lastStock
     * @return Article
     */
    public function setLastStock($lastStock)
    {
        $this->lastStock = $lastStock;
        return $this;
    }

    /**
     * @return Attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param Attribute $attribute
     * @return Article
     */
    public function setAttribute(Attribute $attribute = null)
    {
        $this->attribute = $attribute;
        return $this;
    }

    /**
     * @param ArticleDetail $mainDetail
     * @return Article
     */
    public function setMainDetail(ArticleDetail $mainDetail = null)
    {
        $this->mainDetail = $mainDetail;
        return $this;
    }

    /**
     * @return ArticleDetail
     */
    public function getMainDetail()
    {
        return $this->mainDetail;
    }

    /**
     * @return Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Category[] $categories
     * @return Article
     */
    public function setCategories($categories)
    {
        if (is_array($categories)) {
            $this->categories = new ArrayCollection($categories);
        } elseif ($categories instanceof CollectionInterface) {
            $this->categories = $categories;
        }

        return $this;
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        $this->categories->add($category);
    }

    /**
     * @return Tax
     */
    public function getTax(): Tax
    {
        return $this->tax;
    }

    /**
     * @param Tax $tax
     * @return Article
     */
    public function setTax(Tax $tax) : Article
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * @param PropertyValue[] $propertyValues
     * @return Article
     */
    public function setPropertyValues($propertyValues): Article
    {
        if (is_array($propertyValues)) {
            $this->propertyValues = new ArrayCollection($propertyValues);
        } elseif ($propertyValues instanceof CollectionInterface) {
            $this->propertyValues = $propertyValues;
        }

        return $this;
    }

    /**
     * @return PropertyValue[]
     */
    public function getPropertyValues()
    {
        return $this->propertyValues;
    }

    /**
     * @param PropertyValue $propertyValue
     */
    public function addPropertyValue(PropertyValue $propertyValue)
    {
        $this->propertyValues->add($propertyValue);
    }

    /**
     * @param PropertyValue $propertyValue
     */
    public function removePropertyValue(PropertyValue $propertyValue)
    {
        if ($this->propertyValues->contains($propertyValue)) {
            $this->propertyValues->removeElement($propertyValue);
        }
    }

    /**
     * @param CustomerGroup[] $customerGroups
     * @return Article
     */
    public function setCustomerGroups($customerGroups): Article
    {
        if (is_array($customerGroups)) {
            $this->customerGroups = new ArrayCollection($customerGroups);
        } elseif ($customerGroups instanceof CollectionInterface) {
            $this->customerGroups = $customerGroups;
        }

        return $this;
    }

    /**
     * @return CustomerGroup[]
     */
    public function getCustomerGroups()
    {
        return $this->customerGroups;
    }

    /**
     * @param CustomerGroup $customerGroup
     */
    public function addCustomerGroup(CustomerGroup $customerGroup)
    {
        $this->customerGroups->add($customerGroup);
    }

    /**
     * @param CustomerGroup $customerGroup
     */
    public function removeCustomerGroup(CustomerGroup $customerGroup)
    {
        if ($this->customerGroups->contains($customerGroup)) {
            $this->customerGroups->removeElement($customerGroup);
        }
    }

    /**
     * @return Link[]
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param Link[] $links
     * @return Article
     */
    public function setLinks($links): Article
    {
        if (is_array($links)) {
            $this->links = new ArrayCollection($links);
        } elseif ($links instanceof CollectionInterface) {
            $this->links = $links;
        }

        return $this;
    }

    /**
     * @param Link $link
     */
    public function addLink(Link $link)
    {
        $this->links->add($link);
    }

    /**
     * @param Link $link
     */
    public function removeLink(Link $link)
    {
        if ($this->links->contains($link)) {
            $this->links->removeElement($link);
        }
    }

    /**
     * @param Supplier $supplier
     * @return Article
     */
    public function setSupplier(Supplier $supplier): Article
    {
        $this->supplier = $supplier;
        return $this;
    }

    /**
     * @return Supplier
     */
    public function getSupplier()
    {
        return $this->supplier;
    }
}
