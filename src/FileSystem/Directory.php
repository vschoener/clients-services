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

    /** @var bool  */
    private $createRecursively;

    /**
     * Directory constructor.
     */
    public function __construct()
    {
        $this->context = null;
        $this->createRecursively = false;
    }

    /**
     * @param $path
     * @return $this
     * @throws \Exception
     */
    public function load($path)
    {
        if (!is_dir($path)) {
            throw new \Exception(sprintf('[%s]: is not a directory', $path));
        }

        return parent::load($path);
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
        if ($this->exist()) {
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

    /**
     * @param $filePath
     * @param int $mode
     * @return bool
     * @throws \Exception
     */
    public function create($filePath, $mode = 0755)
    {
        if (!file_exists($filePath)) {
            if (!mkdir($filePath, $mode, $this->createRecursively)) {
                return false;
            }
        }

        // Then load the directory
        $this->load($filePath);
        return true;
    }

    /**
     * @param bool $state
     * @return $this
     */
    public function setCreateRecursively($state)
    {
        $this->createRecursively = (bool) $state;
        return $this;
    }
}