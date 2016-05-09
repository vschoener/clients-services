<?php

namespace VSchoener\PHPClientsServices\Clients;

/**
 * Class FileClientAbstract
 * @package VSchoener\PHPClientsServices\Clients
 */
abstract class FileClientAbstract extends Client implements FileClientInterface
{
    /** @var  bool */
    protected $lastFileUploaded;

    /** @var  bool */
    protected $lastFileDownloaded;

    /**
     * @return bool
     */
    public function isLastFileUploaded()
    {
        return $this->lastFileUploaded;
    }

    /**
     * @return bool
     */
    public function isLastFileDownloaded()
    {
        return $this->lastFileDownloaded;
    }
}