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

try {

    // Set your host information    
    $credentials->setHost('share.batiwiz.com');
    $credentials->setUser('vincent');
    $credentials->setPass('vincent$42');
    $credentials->setPort(22);

    $ssh = new \VSchoener\PHPClientsServices\Clients\SSH($credentials, $environment);
    $sftp = new \VSchoener\PHPClientsServices\Clients\SFTP($ssh);

    $sftp->connect();

    // Display SSH connection and Authentication state
    echo 'SSH '.(!$ssh->isConnected() ? 'Not ' : '').'Connected'.PHP_EOL;
    echo 'SSH '.(!$ssh->isAuthenticated() ? 'Not ' : '').'Authenticated'.PHP_EOL;

    // Display state about the connection and authentication
    echo 'SFTP '.(!$sftp->isConnected() ? 'Not ' : '').'Connected'.PHP_EOL;

    if ($sftp->isConnected()) {
        $file = new \VSchoener\PHPClientsServices\FileSystem\File();

        $directory = new \VSchoener\PHPClientsServices\FileSystem\Directory();
        if ($directory->create(__DIR__.'/store')) {
            $sftp->storeFile('foo', $directory, 'foo');
            echo 'File ' . (!$sftp->isLastFileDownloaded() ? 'Not ' : '') . 'Downloaded' . PHP_EOL;
        } else {
            echo 'Can\'t create directory'.PHP_EOL;
        }

        // Then disconnect
        $sftp->disconnect();
    }
    unset($sftp, $ssh, $credentials, $environment);
} catch (Exception $exception) {
    // Simple exception throw when requirement are not available
    echo $exception->getMessage().PHP_EOL;
}