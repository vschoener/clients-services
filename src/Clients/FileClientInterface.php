<?php

namespace VSchoener\PHPClientsServices\Clients;

use VSchoener\PHPClientsServices\FileSystem\Directory;
use VSchoener\PHPClientsServices\FileSystem\File;

/**
 * Interface FileClientInterface
 * @package VSchoener\PHPClientsServices\Clients
 */
interface FileClientInterface
{
    public function sendFile(File $localFile, $remoteLocation, $mode = 0644);

    public function sendDirectory(Directory $localLocation, $remoteLocation, $folderMode = 0755, $fileMode = 0644);

    public function storeFile($remoteLocation, Directory $localLocation, $fileName);

    public function storeFolder($remoteLocation, Directory $localLocation);
}