<?php

namespace VSchoener\PHPClientsServices\FileSystem;

/**
 * Class FileFactory
 * @package VSchoener\PHPClientsServices\FileSystem
 */
class FileFactory
{
    /**
     * Detect the file parameters to instantiate the right object
     * @param $filePath
     * @return null|Directory|File
     */
    public static function getFileSystem($filePath)
    {
        $fileSystem = null;
        if (file_exists($filePath)) {
            if (is_dir($filePath)) {
                $fileSystem = new Directory();
            } elseif (is_file($filePath)) {
                $fileSystem = new File();
            }

            if ($fileSystem instanceof FileSystemAbstract) {
                $fileSystem->setFile($filePath);
            }
        }

        return $fileSystem;
    }
}