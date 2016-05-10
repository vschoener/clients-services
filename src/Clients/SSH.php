<?php

namespace VSchoener\PHPClientsServices\Clients;

use VSchoener\PHPClientsServices\Credentials\CredentialsSSH;
use VSchoener\PHPClientsServices\Environment\Environment;

/**
 * Class SSH
 * @package VSchoener\PHPClientsServices\Clients
 */
final class SSH extends Client
{
    /** @var  array  */
    private $methods;

    /** @var  array */
    private $callbacks;

    /** @var  CredentialsSSH Only to tell our IDE the Credentials type */
    protected $credentials;

    /** @var  bool */
    private $authenticated;

    /** @var  Environment */
    private $environment;

    /** @var  bool */
    private $shellAvailable;

    /**
     * SSH constructor.
     * @param CredentialsSSH $credentials
     * @param Environment $environment
     * @throws \Exception
     */
    public function __construct(CredentialsSSH $credentials, Environment $environment = null)
    {
        if (!extension_loaded('ssh2')) {
            throw new \Exception('SSH2 module is require to use this class');
        }

        parent::__construct($credentials);

        $this->environment = $environment;
        $this->callbacks = null;
        $this->methods = null;
        $this->authenticated = false;
    }

    /**
     * @return $this
     */
    public function connect()
    {
        if (!$this->isConnected()) {
            $this->callbacks['disconnect'] = [$this, 'callbackDisconnect'];
            $this->resource = ssh2_connect(
                $this->credentials->getHost(),
                $this->credentials->getPort(),
                $this->getMethods(),
                $this->getCallbacks()
            );
            $this->authenticateConnection();

            // We need to know is shell is available
            $shell = $this->getShell('xterm');
            $this->shellAvailable = (bool) $shell;

            if (is_resource($shell)) {
                fclose($shell);
            }
        }

        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    private function authenticateConnection()
    {
        if (null == $this->resource) {
            return $this;
        }

        $identityFile = $this->credentials->getIdentityFile();

        if ($this->environment) {
            $identityFile = $this->environment->translateToCompleteRelativePath($identityFile);
        }

        $this->authenticated = false;
        // If identity file is set and exist, wa can try to authenticate user
        if (!empty($identityFile) && file_exists($identityFile)) {
            $this->authenticated = ssh2_auth_pubkey_file(
                $this->resource,
                $this->credentials->getUser(),
                $identityFile.'.pub',
                $identityFile,
                $this->credentials->getPass()
            );

            if (!$this->authenticated) {
                throw new \Exception('Could not authenticate SSH connection');
            }
        } else {

            $user = $this->credentials->getUser();
            $password = $this->credentials->getPass();

            if (empty($user) || empty($password)) {
                throw new \Exception('User or password are empty');
            }

            $this->authenticated = ssh2_auth_password(
                $this->resource,
                $this->credentials->getUser(),
                $this->credentials->getPass()
            );
        }

        return $this;
    }

    /**
     * @param $command
     * @return null
     */
    public function exec($command)
    {
        $result = null;

        if ($this->isAuthenticated() && $this->isShellAvailable()) {
            $stream = ssh2_exec($this->resource, $command);
            if (is_resource($stream)) {
                $errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);

                // For now were a blocking stream but this will be improved later
                stream_set_blocking($stream, true);
                stream_set_blocking($errorStream, true);

                $result = stream_get_contents($stream);
                if (empty($result)) {
                    $result = stream_get_contents($errorStream);
                }
            }
        }

        return $result;
    }

    /**
     * @param $term
     * @return null
     */
    public function getShell($term)
    {
        $shell = null;
        if ($this->isAuthenticated()) {
            $shell = @ssh2_shell($this->resource, $term);
        }

        return $shell;
    }

    /**
     * @param $reason
     * @param $message
     * @param $language
     */
    private function callbackDisconnect($reason, $message, $language)
    {
        $this->disconnect();
    }

    /**
     * @return $this
     */
    public function disconnect()
    {
        if ($this->isConnected() && $this->isAuthenticated() && $this->isShellAvailable()) {
            // Didn't found the right way to disconnect ssh connection.
            // It appears that the shell connection persist even with this.
            // I need a confirmation :)
             ssh2_exec($this->resource, 'exit');
        }
        $this->resource = null;
        $this->authenticated = false;
        return $this;
    }

    /**
     * @return bool
     */
    protected function hasRequiredCredentials()
    {
        $user = $this->credentials->getUser();

        return parent::hasRequiredCredentials() && !empty($user);
    }

    /**
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param array $methods
     */
    public function setMethods($methods)
    {
        $this->methods = $methods;
    }

    /**
     * @return array
     */
    public function getCallbacks()
    {
        return $this->callbacks;
    }

    /**
     * @param array $callbacks
     */
    public function setCallbacks($callbacks)
    {
        $this->callbacks = $callbacks;
    }

    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        return $this->authenticated;
    }

    /**
     * @return bool
     */
    public function isShellAvailable()
    {
        return $this->shellAvailable;
    }
}