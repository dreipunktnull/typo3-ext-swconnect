<?php

namespace DPN\SwConnect\Domain\Model;

/**
 * Model class for the Shopware software version.
 */
class Version
{
    /**
     * @var  string
     */
    protected $version;

    /**
     * @var string
     */
    protected $revision;

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     * @return Version
     */
    public function setVersion($version = ''): self
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return string
     */
    public function getRevision()
    {
        return $this->revision;
    }

    /**
     * @param string $revision
     * @return Version
     */
    public function setRevision($revision = ''): self
    {
        $this->revision = $revision;
        return $this;
    }
}
