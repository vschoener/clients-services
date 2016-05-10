<?php

require __DIR__.'/../../vendor/autoload.php';

/**
 * This example will show you how to connect a ssh server
 * using your .ssh/config file, just replace any {content} with your requirements
 */

// Any clients require credentials
$credentials = new VSchoener\PHPClientsServices\Credentials\CredentialsSSH(
    'host',
    'user',
    'pass'
);

try {

    $ssh = new \VSchoener\PHPClientsServices\Clients\SSH($credentials);
    $ssh->connect();

    // Display state about the connection and authentication
    echo 'SSH '.(!$ssh->isConnected() ? 'Not ' : '').'Connected'.PHP_EOL;
    echo 'SSH '.(!$ssh->isAuthenticated() ? 'Not ' : '').'Authenticated'.PHP_EOL;

    if ($ssh->isAuthenticated()) {
        echo 'Shell '.(!$ssh->isShellAvailable() ? 'Not ' : '').'Available'.PHP_EOL;
    }

    // Then disconnect
    $ssh->disconnect();
    unset($ssh, $credentials);
} catch (Exception $exception) {
    // Simple exception throw when requirement are not available
    echo $exception->getMessage().PHP_EOL;
}
