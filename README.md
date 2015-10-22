# notify
Framework agnostic and lightweight notification system implementing the PSR LoggerInterface with several handling adapters.

Usage

```php
<?php
$notificationCenter = new NotificationCenter();
$notificationCenter->addHandler(
    new HeaderHandler('Notify', NotificationCenter::ERROR)
);

$notificationCenter->error('There was an error.');
```
