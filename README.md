# Notify

Framework agnostic and lightweight notification system implementing the PSR LoggerInterface with several handling adapters.

Feel free to implement your own handlers!

[![Build Status](https://travis-ci.org/dstuecken/notify.svg)](https://travis-ci.org/dstuecken/notify)

## Requirements

* PHP 5.3

## Installation

### Using Composer

To install Notify with Composer, just add the following to your composer.json file:

```json
{
    "require": {
        "dstuecken/notify": "0.*"
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

$notificationCenter->error('There was an error.');
```

## Currently implemented Handlers

### Header

Sends an HTTP Header, which can be observed by Javascript to represent errors as growl-like notification messages.

### Logger

Forwards your notifications to a Logger.

### MacOS

Displays a Mac OS X Notification Center Message.


### HipChat



## Tests

Run phpunit tests with

```shell
phpunit --bootstrap tests/bootstrap.php tests
```
