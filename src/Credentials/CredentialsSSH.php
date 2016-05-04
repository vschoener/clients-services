<?php

namespace VSchoener\PHPClientsServices\Credentials;


use VSchoener\PHPClientsServices\FileSystem\File;

/**
 * Class CredentialsSSH
 * @package VSchoener\PHPClientsServices\Clients\Credentials
 */
final class CredentialsSSH extends CredentialsAbstract
{
    const HOST = 'host';

    const USER = 'user';

    const HOST_NAME = 'hostname';

    const PORT = 'port';

    const IDENTITY_FILE = 'identityfile';

    const PROXY_COMMAND = 'proxycommand';

    /** @var  File $fileSystem */
    private $fileSystem;

    /** @var  string */
    private $identityFile;

    /** @var  string */
    private $proxyCommand;

    /**
     * @param File $fileSystem
     * @param $alias
     */
    public function loadConfigFile(File $fileSystem, $alias)
    {
        $this->fileSystem = clone $fileSystem;

        $aliasFound = false;
        if ($this->fileSystem->isReadable() && $fileSystem->open()->isOpen()) {
            while ($fileSystem->hasContentToRead() && ($line = $fileSystem->read())) {

                // First let's prepare key and value using a proper regex
                $key = $value = false;
                if (preg_match('/^\s*(\S+)\s*[=| ](.*)$/', $line, $match)) {
                    $key = strtolower($match[1]);
                    $value = $match[2];
                }

                // First we check if we are matching an 'host' key with requested 'alias'
                if (!$aliasFound && ($key == CredentialsSSH::HOST && $value == $alias)) {
                    $aliasFound = true;
                    continue;
                }

                // We know alias is found and settings can be saved
                if ($aliasFound) {

                    // If we got an 'host' key again, we're done
                    if ($key == CredentialsSSH::HOST) {
                        break;
                    }

                    // Load configuration with proper setter
                    switch ($key) {
                        case CredentialsSSH::HOST_NAME:
                            $this->setHost($value);
                            break;
                        case CredentialsSSH::USER:
                            $this->setUser($value);
                            break;
                        case CredentialsSSH::PORT:
                            $this->setPort($value);
                            break;
                        case CredentialsSSH::IDENTITY_FILE:
                            $this->setIdentityFile($value);
                            break;
                        case CredentialsSSH::PROXY_COMMAND:
                            $this->setProxyCommand($value);
                            break;
                    }
                }
            }

            // Handle default port
            $port = $this->getPort();
            if (empty($port) || !$port) {
                $this->setPort(22);
            }
        }
    }

    /**
     * Get loaded settings
     *
     * @return array
     */
    public function getSettings()
    {
        return [
            CredentialsSSH::HOST_NAME => $this->getHost(),
            CredentialsSSH::PORT => $this->getPort(),
            CredentialsSSH::USER => $this->getUser(),
            CredentialsSSH::IDENTITY_FILE => $this->getIdentityFile(),
            CredentialsSSH::PROXY_COMMAND => $this->getProxyCommand(),
        ];
    }

    /**
     * @return string
     */
    public function getIdentityFile()
    {
        return $this->identityFile;
    }

    /**
     * @param string $identityFile
     */
    public function setIdentityFile($identityFile)
    {
        $this->identityFile = $identityFile;
    }

    /**
     * @return string
     */
    public function getProxyCommand()
    {
        return $this->proxyCommand;
    }

    /**
     * @param string $proxyCommand
     */
    public function setProxyCommand($proxyCommand)
    {
        $this->proxyCommand = $proxyCommand;
    }

    /**
     * Shortcut for a better reading access with SSH
     * @return string
     */
    public function getPassPhrase()
    {
        return $this->getPass();
    }

    /**
     * Shortcut for a better reading access with SSH
     * @param string $passPhrase
     */
    public function setPassPhrase($passPhrase)
    {
        $this->setPass($passPhrase);
    }
}