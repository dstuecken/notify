<?php
namespace NotifyTest;

use dstuecken\Notify\Handler\LoggerHandler;
use dstuecken\Notify\NotificationCenter;
use dstuecken\Notify\Type\DetailedNotification;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

Class LoggerHandlerTest
    extends TestCase
{

    protected function setUp()
    {
    }

    public function testNotify()
    {
        $notificationCenter = new NotificationCenter();
        $notificationCenter->addHandler(
            new LoggerHandler(
                new Logger(
                    'testLogger', array(
                        new StreamHandler('/dev/null')
                    )
                ), NotificationCenter::ERROR
            )
        );

        $not[] = $notificationCenter->error('There was an error.');
        $not[] = $notificationCenter->info('There was an info.');
        $not[] = $notificationCenter->debug('There was a debug.');

        $not[] = $notificationCenter->notify(
            new DetailedNotification('There is a notification', 'With a Title')
        );

        foreach ($not as $n)
        {
            $this->assertEquals(
                true,
                $n
            );
        }
    }
}
