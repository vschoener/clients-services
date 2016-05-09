<?php

namespace VSchoener\PHPClientsServices\Clients;
use VSchoener\PHPClientsServices\FileSystem\Directory;
use VSchoener\PHPClientsServices\FileSystem\File;

/**
 * Class FTP
 * @package VSchoener\PHPClientsServices\Clients
 */
final class FTP extends FileClientAbstract
{
    public function connect()
    {
        // TODO: Implement connect() method.
    }

    public function disconnect()
    {
        // TODO: Implement disconnect() method.
    }

    public function isConnected()
    {
        // TODO: Implement isConnected() method.
    }

    public function getResource()
    {
        // TODO: Implement getResource() method.
    }

    public function sendFile(File $localFile, $remoteLocation, $mode = 0644)
    {
        // TODO: Implement sendFile() method.
    }

    public function sendDirectory(Directory $localLocation, $remoteLocation, $folderMode = 0755, $fileMode = 0644)
    {
        // TODO: Implement sendDirectory() method.
    }

    public function storeFile($remoteLocation, Directory $localLocation)
    {
        // TODO: Implement storeFile() method.
    }

    public function storeFolder($remoteLocation, Directory $localLocation)
    {
        // TODO: Implement storeFolder() method.
    }
}