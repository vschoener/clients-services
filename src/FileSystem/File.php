<?php

namespace VSchoener\PHPClientsServices\FileSystem;

/**
 * Class File
 * @package VSchoener\PHPClientsServices\FileSystem
 */
final class File extends FileSystemAbstract
{
    /** @var  string */
    private $mode;

    const MODE_READ = 'r';

    /**
     * File constructor.
     */
    public function __construct()
    {
        $this->mode = File::MODE_READ;
    }

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param mixed $mode
     * @return $this
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @return $this
     */
    public function open()
    {
        if ($this->isFileSet()) {
            $this->resource = fopen($this->getPath(), $this->getMode());
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
        $line = false;
        if ($this->isOpen() && $this->hasContentToRead()) {
            $line = fgets($this->resource);
        }

        return $line;
    }
    
    /**
     * @return $this
     */
    public function close()
    {
        if ($this->isOpen()) {
            fclose($this->resource);
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
     * Move the begin of the content file
     */
    public function moveCursorToBeginFile()
    {

    }
}