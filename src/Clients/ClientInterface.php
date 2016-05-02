<?php

namespace VSchoener\PHPClientsServices\Clients;

/**
 * Interface ClientInterface
 * @package VSchoener\PHPClientsServices\Clients
 */
interface ClientInterface
{
    public function connect();

    public function disconnect();

    public function isConnected();

    public function getResource();
}