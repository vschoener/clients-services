<?php

namespace VSchoener\PHPClientsServices\FileSystem;

/**
 * Interface FileSystemInterface
 * @package VSchoener\PHPClientsServices\FileSystem
 */
interface FileSystemInterface
{
    public function open();

    public function close();

    public function setFile($filePath);

    public function read();
}