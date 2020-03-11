<?php
namespace NotifyTest;

use dstuecken\Notify\Handler\HeaderHandler;
use dstuecken\Notify\Handler\NullHandler;
use dstuecken\Notify\NotificationCenter;
use PHPUnit\Framework\TestCase;

Class MultipleHandlersTest
    extends TestCase
{
    protected function setUp()
    {
    }

    public function testNotify()
    {
        $notificationCenter = new NotificationCenter();
        $notificationCenter
            ->addHandler(
                new HeaderHandler(
                    'Notify',
                    NotificationCenter::ERROR
                )
            )
            ->addHandler(
                new NullHandler()
            );

        $this->assertEquals(
            $notificationCenter->error('There was an error.'),
            true
        );
    }
}
