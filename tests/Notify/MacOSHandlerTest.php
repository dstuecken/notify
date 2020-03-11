<?php
namespace NotifyTest;

use dstuecken\Notify\Handler\MacOSHandler;
use dstuecken\Notify\NotificationCenter;
use dstuecken\Notify\Type\DetailedNotification;
use PHPUnit\Framework\TestCase;

Class MacOSHandlerTest
    extends TestCase
{

    protected function setUp()
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
