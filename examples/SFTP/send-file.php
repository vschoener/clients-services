<?php

require __DIR__.'/../../vendor/autoload.php';

/**
 * This example will show you how to upload a file on your server
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
        if ($file->create(__DIR__ . '/test.txt')) {
            $sftp->sendFile($file, 'test.txt');
            echo 'File ' . (!$sftp->isLastFileUploaded() ? 'Not ' : '') . 'Uploaded' . PHP_EOL;
        } else {
            echo 'Can\'t create local file for the current test'.PHP_EOL;
        }

        // Then disconnect
        $sftp->disconnect();
    }
    unset($sftp, $ssh, $credentials);
} catch (Exception $exception) {
    // Simple exception throw when requirement are not available
    echo $exception->getMessage().PHP_EOL;
}