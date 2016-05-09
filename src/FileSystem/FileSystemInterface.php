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

    public function load($path);

    public function read();

    public function create($filePath, $mode = 0644);
}