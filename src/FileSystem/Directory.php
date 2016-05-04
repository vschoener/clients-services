<?php

namespace VSchoener\PHPClientsServices\FileSystem;

/**
 * Class Directory
 * @package VSchoener\PHPClientsServices\FileSystem
 */
class Directory extends FileSystemAbstract
{
    /** @var  resource */
    private $context;

    public function __construct()
    {
        $this->context = null;
    }

    /**
     * @return resource
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param resource $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
    * @return $this
    */
    public function open()
    {
        if ($this->isFileSet()) {
            $this->resource = opendir($this->getPath(), $this->getContext());
        }
        return $this;
    }
    
    /**
     * @return bool
     */
    public function hasContentToRead()
    {
        return $this->isOpen() && !feof($this->resource);
    }

    /**
     * @return bool
     */
    public function read()
    {
        // TODO: Read content directory as 'ls' command
        return false;
    }

    /**
     * @return $this
     */
    public function close()
    {
        if ($this->isOpen()) {
            closedir($this->resource);
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isClose()
    {
        return !$this->isOpen();
    }
}