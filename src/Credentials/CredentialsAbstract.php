<?php

namespace VSchoener\PHPClientsServices\Credentials;
use VSchoener\PHPClientsServices\Environment\Environment;

/**
 * Class CredentialsAbstract
 * @package VSchoener\PHPClientsServices\Credentials
 */
abstract class CredentialsAbstract implements CredentialsInterface
{
    /** @var  string */
    private $host;

    /** @var  int */
    private $port;

    /** @var  string */
    private $user;

    /** @var  string */
    private $pass;

    /** @var  Environment */
    protected $environment;

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return CredentialsAbstract
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return (int) $this->port;
    }

    /**
     * @param int $port
     * @return CredentialsAbstract
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     * @return CredentialsAbstract
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @param string $pass
     * @return CredentialsAbstract
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
        return $this;
    }
}