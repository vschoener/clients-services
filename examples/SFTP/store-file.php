<?php

require __DIR__.'/../../vendor/autoload.php';

/**
 * This example will show you how to download a file on your server
 */

// Any clients require credentials
$credentials = new VSchoener\PHPClientsServices\Credentials\CredentialsSSH(
    'host',
    'user',
    'pass'
);

try {

    $ssh = new \VSchoener\PHPClientsServices\Clients\SSH($credentials);
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
    unset($sftp, $ssh, $credentials);
} catch (Exception $exception) {
    // Simple exception throw when requirement are not available
    echo $exception->getMessage().PHP_EOL;
}