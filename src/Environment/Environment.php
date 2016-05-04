<?php

namespace VSchoener\PHPClientsServices\Environment;

/**
 * Class Environment
 * @package VSchoener\PHPClientsServices\Environment
 */
class Environment
{
    /**
     * Get Home directory user from different OS Detection
     * @return null
     */
    public function getHomeDirectory()
    {
        $home = getenv('HOME');

        // IF home is empty, and these entries are available, we are on Windows
        if (empty($home) && !empty($_SERVER['HOMEDRIVE']) && !empty($_SERVER['HOMEPATH'])) {
            $home = $_SERVER['HOMEDRIVE'] . $_SERVER['HOMEPATH'];
        }

        $home = str_replace('//', '/', $home.'/');
        return empty($home) ? null : $home;
    }

    /**
     * @return bool
     */
    public function isCLIEnvironment()
    {
        return php_sapi_name() == 'cli';
    }

    /**
     * @param string $path
     * @return string
     */
    public function translateToCompleteRelativePath($path)
    {
        if (strlen($path) && $path[0] == '~' && $path[1] == '/') {
            $homeDirectory = $this->getHomeDirectory();
            $path = $homeDirectory.substr($path, 2);
        }
        return $path;
    }
}