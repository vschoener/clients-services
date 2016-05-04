
# PHP Clients Services

## Summary:

This is a PHP library which attempts to use the following services or clients more easily:
* SSH
* SFTP
* FTP

I chose to develop this package due to a lack of available libraries on this process.
The purpose is to centralized differents protocols connections into the same package.

I hate myself developing again and again the same code, so I hope you will enjoy it :)

## Information

Services and Clients could be the same naming, so let's just call it services.
This package will be improved later to add new services / clients.

For now it's under development and will support the following services:
- [x] SSH
- [ ] SFTP
- [ ] FTP
- [ ] ... Any new services could be added there later

Let's call it a Task list :)

## Version

There is no official release for now, I'm working on it and will publish any new improvements and fixed bugs during a while.
But I hope you guys will help me around with this.

The branch development is : **development** if you want to try it out

## Installation

### Requirements

Composer is required, if you don't know yet how to use it, you should visit the official website
 [Composer web site](https://getcomposer.org/)

The PHP version has to be >= 5.5.9.

### Installation

For now you have two way to install it. 
You can clone or fork the project and jump to the development branch

```
git clone git@github.com:vschoener/php-clients-services.git
cd php-clients-services
git branch development
```

Or download the zip associated to this branch and extract the content where you need it.

Once you are in the folder, just install it with composer :

```
php composer.phar install
```

I plan to register it on **packagist** once the initial task list is over.

## Demo
There is a examples folder containing code to show you how to use the libraries. Of course, there will be more later.

## Worflow 
You find what's planed and what's is done on the different services

### SSH Service
The ssh service is here to help you communication with your ssh connection.
For now it support:
- [x] Use a ssh config file with requested alias
- [x] Connection with IdentityFile read from you config ssh file
- [ ] Use simple credential authentication (user / password)
- [x] Exec any commands you want (simple tasks for now and blocking method)
- [ ] Implement shortcut methods to use classic shell command as ls, cd..

### SFTP
The sftp service is here to help communication with sftp connection.
Of cource this one depends of SSH Service.
For now it support:
- [ ] Request subsystem from SSH
- [ ] Browse to distant folder
- [ ] Download file from the server
- [ ] Upload file to the server
- [ ] Download directory from the server
- [ ] Upload directory to the server

### FTP
The ftp service is here to help communication with a ftp connecton
For niw it support:
- [ ] Passive mode
- [ ] Implicit mode
- [ ] SSL connection
- [ ] Browse to distant folder
- [ ] Download file from the server
- [ ] Upload file to the server
- [ ] Download directory from the server
- [ ] Upload directory to the server

## CI
As you see, there is not PHPUnit or other task to validate this project, but it will as soon as possible.

## Improvements list I see

* FileSystem will be externalised later with more feature but I needed something nice to manipulate ssh config file
* SSH exec should be able to be used in non blocking mode
