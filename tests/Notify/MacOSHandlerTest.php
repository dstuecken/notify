<?php
namespace NotifyTest;

use dstuecken\Notify\Handler\MacOSHandler;
use dstuecken\Notify\NotificationCenter;
use dstuecken\Notify\Type\DetailedNotification;

Class MacOSHandlerTest
    extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
    }

    public function testNotify()
    {
        $notificationCenter = new NotificationCenter();
        $notificationCenter->addHandler(
            new MacOSHandler(NotificationCenter::ERROR)
        );

        $not[] = $notificationCenter->notify(
            new DetailedNotification('This is a notification', 'With a Title')
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