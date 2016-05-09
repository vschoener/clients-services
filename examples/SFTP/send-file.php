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
    $credentials->setHost('');
    $credentials->setUser('');
    $credentials->setPass('');
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
        if ($file->create(__DIR__ . '/test.txt')) {
            $sftp->sendFile($file, 'test.txt');
            echo 'File ' . (!$sftp->isLastFileUploaded() ? 'Not ' : '') . 'Uploaded' . PHP_EOL;
        } else {
            echo 'Can\'t create local file for the current test'.PHP_EOL;
        }

        // Then disconnect
        $sftp->disconnect();
    }
    unset($sftp, $ssh, $credentials, $environment);
} catch (Exception $exception) {
    // Simple exception throw when requirement are not available
    echo $exception->getMessage().PHP_EOL;
}