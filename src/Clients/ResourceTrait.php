<?php

namespace VSchoener\PHPClientsServices\Clients;

/**
 * Class ResourceTrait
 * @package VSchoener\PHPClientsServices\Clients
 */
Trait ResourceTrait
{
    /** @var  resource */
    protected $resource;

    /**
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return bool
     */
    public function isResourceAvailable()
    {
        return $this->resource && is_resource($this->resource);
    }
}