<?php

namespace VSchoener\PHPClientsServices\FileSystem;
use VSchoener\PHPClientsServices\Clients\ResourceTrait;

/**
 * Class FileSystemAbstract
 * @package VSchoener\PHPClientsServices\FileSystem
 */
abstract class FileSystemAbstract implements FileSystemInterface
{
    use ResourceTrait;
    
    const DIRECTORY = 'DIR';

    const FILE = 'FILE';

    /** @var  string */
    private $path;

    /** @var  string */
    private $dirName;

    /** @var string  */
    private $baseName;

    /** @var string  */
    private $fileName;

    /** @var string  */
    private $extension;

    /** @var  int */
    private $size;

    /** @var  string */
    private $type;

    /** @var  bool */
    private $readable;

    /** @var  bool */
    private $fileLoaded;

    /**
     * @return bool
     */
    public function exist()
    {
        return $this->fileLoaded;
    }

    /**
     * @param $filePath
     * @return $this
     * @throws \Exception
     */
    public function setFile($filePath)
    {
        if ($this->fileLoaded && $filePath == $this->getPath()) {
            return $this;
        }
        
        $this->fileLoaded = false;
        if (!is_file($filePath) || !file_exists($filePath)) {
            throw new \Exception(sprintf('[%s]: is not a file or doesn\'t exist', $filePath));
        }

        $info = pathinfo($filePath);
        $this->path = $filePath;
        $this->baseName = array_key_exists('basename', $info) ? $info['basename'] : '';
        $this->dirName = array_key_exists('dirname', $info) ? $info['dirname'] : '';
        $this->fileName = array_key_exists('filename', $info) ? $info['filename'] : '';
        $this->extension = array_key_exists('extension', $info) ? $info['extension'] : '';
        $this->size = filesize($filePath);
        $this->readable = is_readable($filePath);
        
        // Handle file, not Stream for now
        $this->type = is_dir($filePath) ? self::DIRECTORY : (is_file($filePath) ? self::FILE : null);

        $info = null;
        unset($info);

        $this->fileLoaded = true;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function isOpen()
    {
        return $this->isResourceAvailable();
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getDirName()
    {
        return $this->dirName;
    }

    /**
     * @return string
     */
    public function getBaseName()
    {
        return $this->baseName;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function isReadable()
    {
        return $this->readable;
    }
}