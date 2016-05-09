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

    const READ_OPEN_MODE = 'r';

    /**
     * File constructor.
     */
    public function __construct()
    {
        $this->mode = File::READ_OPEN_MODE;
    }

    /**
     * @param $path
     * @return $this
     * @throws \Exception
     */
    public function load($path)
    {
        if (!is_file($path)) {
            throw new \Exception(sprintf('[%s]: is not a file', $path));
        }

        return parent::load($path);
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
        if ($this->exist()) {
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
     * @param $filePath
     * @param int $mode
     * @return bool
     */
    public function create($filePath, $mode = 0644)
    {
        if (!file_exists($filePath)) {
            if (!touch($filePath)) {
                return false;
            }
            chmod($filePath, $mode);
        }

        // Then load the file
        $this->load($filePath);
        return true;
    }

    /**
     * Move the begin of the content file
     */
    public function moveCursorToBeginFile()
    {
        // TODO: Implement method
    }
}