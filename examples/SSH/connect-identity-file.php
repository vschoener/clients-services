<?php

require __DIR__.'/../../vendor/autoload.php';

/**
 * This example will show you how to connect a ssh server
 * using your .ssh/config file, just replace any {content} with your requirements
 */

// Environment is required for SSH Client
$environment = new \VSchoener\PHPClientsServices\Environment\Environment();
// Any clients require credentials
$credentials = new VSchoener\PHPClientsServices\Credentials\CredentialsSSH();

// This File instance will help during the SSH configuration load
$configFile = new \VSchoener\PHPClientsServices\FileSystem\File();

try {
    // Set the pass to your ssh connection
    $configFile->load('/home/{user}/.ssh/config');

    if (!$configFile->exist()) {
        throw new Exception('Your ssh config file could\'t be found');
    }

    $credentials->loadConfigFile($configFile, '{alias}');

    if (!$credentials->isAliasFound()) {
        throw new Exception('Alias has not be found');
    }

    $ssh = new \VSchoener\PHPClientsServices\Clients\SSH($credentials, $environment);
    $ssh->connect();

    // Display state about the connection and authentication
    echo 'SSH '.(!$ssh->isConnected() ? 'Not ' : '').'Connected'.PHP_EOL;
    echo 'SSH '.(!$ssh->isAuthenticated() ? 'Not ' : '').'Authenticated'.PHP_EOL;

    if ($ssh->isAuthenticated()) {
        echo 'Shell '.(!$ssh->isShellAvailable() ? 'Not ' : '').'Available'.PHP_EOL;
    }

    // Then disconnect
    $ssh->disconnect();
    unset($ssh, $credentials, $environment);
} catch (Exception $exception) {
    // Simple exception throw when requirement are not available
    echo $exception->getMessage().PHP_EOL;
}
