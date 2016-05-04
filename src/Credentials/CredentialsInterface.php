<?php

namespace VSchoener\PHPClientsServices\Credentials;

/**
 * Interface Credentials
 * @package VSchoener\PHPClientsServices\Credentials
 */
interface CredentialsInterface
{
    public function setHost($host);

    public function setPort($port);

    public function setUser($login);

    public function setPass($pass);

    public function getHost();

    public function getPort();

    public function getUser();

    public function getPass();

    public function getSettings();
}