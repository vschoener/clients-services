<?php

namespace VSchoener\PHPClientsServices\Clients;

/**
 * Class SFTP
 * @package VSchoener\PHPClientsServices\Clients
 */
final class SFTP extends Client
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
}