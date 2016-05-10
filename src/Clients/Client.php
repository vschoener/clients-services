<?php

namespace VSchoener\PHPClientsServices\Clients;
use VSchoener\PHPClientsServices\Credentials\CredentialsAbstract;

/**
 * Class Client
 * @package VSchoener\PHPClientsServices\Clients
 */
abstract class Client implements ClientInterface
{
    use ResourceTrait;

    /** @var  CredentialsAbstract */
    protected $credentials;

    /**
     * Client constructor.
     * @param CredentialsAbstract $credentials
     * @throws \Exception
     */
    public function __construct(CredentialsAbstract $credentials)
    {
        if (null == $credentials) {
            throw new \Exception('Credentials is required');
        }

        $this->resource = null;
        $this->credentials = $credentials;

        if (!$this->hasRequiredCredentials()) {
            throw new \Exception('Your Credentials is not fully set');
        }
    }

    /**
     * @return bool
     */
    protected function hasRequiredCredentials()
    {
        $host = $this->credentials->getHost();
        $user = $this->credentials->getUser();

        return !empty($host) && !empty($user);
    }

    /**
     * @return bool
     */
    public function isConnected()
    {
        return $this->isResourceAvailable();
    }

    /**
     * @return CredentialsAbstract
     */
    public function getCredentials()
    {
        return $this->credentials;
    }
}