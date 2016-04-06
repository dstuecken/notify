# Notify

Framework agnostic and lightweight notification system implementing the PSR LoggerInterface with several handling adapters.

Feel free to implement your own handlers!

[![Build Status](https://travis-ci.org/dstuecken/notify.svg)](https://travis-ci.org/dstuecken/notify)
[![License](https://poser.pugx.org/dstuecken/notify/license)](https://packagist.org/packages/dstuecken/notify)
[![Latest Stable Version](https://poser.pugx.org/dstuecken/notify/v/stable)](https://packagist.org/packages/dstuecken/notify)
[![Latest Unstable Version](https://poser.pugx.org/dstuecken/notify/v/unstable)](https://packagist.org/packages/dstuecken/notify)

## Requirements

* PHP 5.4

## Installation

### Using Composer

To install Notify with Composer, just add the following to your composer.json file:

```json
{
    "require": {
        "dstuecken/notify": "dev-master"
    }
}
```

or by running the following command:

```shell
composer require dstuecken/notify
```

## Usage

### Use the Header Handler

```php
<?php
$notificationCenter = new NotificationCenter();
$notificationCenter->addHandler(
    new HeaderHandler('Notify', NotificationCenter::ERROR)
);

$notificationCenter->error('There was an error.');
```

The Header handler is used to send an HTTP Header to the Browser in the following (changable) format: X-Notify-Notification.
This header can then be grabed by a javascript implementation to display a nice and clean javascript error message while continuing the application with a normal response.

### Use the Logger Handler

You can send your notifications to any LoggerInterface capable logger:

```php
<?php
$logger = new Logger('my-logger');

$notificationCenter = new NotificationCenter();
$notificationCenter->addHandler(
    new LoggerHandler($logger, NotificationCenter::ERROR)
);

$notificationCenter->error('There was an error.');
```

### Use the HipChat Handler

You can also send all your CRITICAL notifications to hipchat, for example:

```php
<?php
$hipchat = new HipChat\HipChat('apiKey123', );

$notificationCenter = new NotificationCenter();
$notificationCenter->addHandler(
    new HipChatHandler($hipchat, 'hipchat-room-id', NotificationCenter::CRITICAL, 'hipChatBotName')
);

$notificationCenter->error('There was an error.');
```

### Push your notifications to several Handlers

You can send your notifications to different handlers in different levels:

```php
<?php
$logger = new Logger('my-logger');

$notificationCenter = new NotificationCenter();
$notificationCenter
	->addHandler(
	    new HeaderHandler(
	        'Notify',
	        NotificationCenter::INFO
	    )
	)
	->addHandler(
	    new LoggerHandler(new Logger(), NotificationCenter::ERROR)
	);

$notificationCenter->error('There was an error.', HeaderHandler::formatAttributes(null, null, true));
```

## Currently implemented Handlers

### Header

Sends an HTTP Header, which can be observed by Javascript to represent errors as growl-like notification messages.

### Logger

Forwards your notifications to a Logger, which implements the LoggerInterface.

### MacOS

Displays a Mac OS X Notification Center Message.

### HipChat

Drops notifications on your hipchat rooms.

### NotifySend

Notify via Ubuntu's notification service.

### Syslog

Send your notifications to a syslog (using the PHP syslog() function).

### Smarty

Attach your notifications to a smarty template variable

### Memory

Forward notifications to an array

## Tests

Run phpunit tests with

```shell
phpunit --bootstrap tests/bootstrap.php tests
```
