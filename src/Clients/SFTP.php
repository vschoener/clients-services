<?php

namespace VSchoener\PHPClientsServices\Clients;
use VSchoener\PHPClientsServices\FileSystem\Directory;
use VSchoener\PHPClientsServices\FileSystem\File;

/**
 * Class SFTP
 * @package VSchoener\PHPClientsServices\Clients
 */
final class SFTP extends FileClientAbstract
{
    /** @var  SSH */
    private $ssh;

    /**
     * SFTP constructor.
     * @param SSH $ssh
     * @throws \Exception
     */
    public function __construct(SSH $ssh)
    {
        $this->ssh = $ssh;

        if (!($ssh instanceof SSH)) {
            throw new \Exception('SFTP require an SSH instance');
        }

        // SSH handle the credentials part but it's require for our parent.
        // Set let's pass the SSH one and have a trace in this object
        parent::__construct($ssh->getCredentials());
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function connect()
    {
        if (!$this->isConnected()) {
            $this->ssh->connect();
            if ($this->ssh->isAuthenticated()) {

                $this->resource = ssh2_sftp($this->ssh->getResource());

                if (!$this->isResourceAvailable()) {
                    throw new \Exception('Can\'t connect to SFTP server');
                }
            }
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function disconnect()
    {
        $this->resource = null;
        $this->ssh->disconnect();
        return $this;
    }

    /**
     * @param File $localFile
     * @param $remoteLocation
     * @param int $mode
     * @return $this
     */
    public function sendFile(File $localFile, $remoteLocation, $mode = 0644)
    {
        if ($this->ssh->isAuthenticated() && $localFile->exist() && $localFile->isReadable()) {
            $this->lastFileUploaded = ssh2_scp_send($this->ssh->getResource(), $localFile->getPath(), $remoteLocation, $mode);
        }

        return $this;
    }

    public function sendDirectory(Directory $localLocation, $remoteLocation, $folderMode = 0755, $fileMode = 0644)
    {
        // TODO: Implement sendDirectory() method.
    }

    /**
     * @param $remoteLocation
     * @param Directory $localLocation
     * @param string $fileName
     * @return $this
     */
    public function storeFile($remoteLocation, Directory $localLocation, $fileName)
    {
        if ($this->ssh->isAuthenticated() && $localLocation->exist() && $localLocation->isWritable()) {
            $this->lastFileDownloaded = ssh2_scp_recv($this->ssh->getResource(), $remoteLocation, $localLocation->getPath().'/'.$fileName);
        }
        return $this;
    }

    public function storeFolder($remoteLocation, Directory $localLocation)
    {
        // TODO: Implement storeFolder() method.
    }


}