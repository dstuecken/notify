<?php
namespace NotifyTest;

use dstuecken\Notify\NotificationCenter;
use dstuecken\Notify\Handler\HeaderHandler;


Class NotifyHeaderTest
    extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
    }

    public function testNotify()
    {

        $notificationCenter = new NotificationCenter();
        $notificationCenter->addHandler(
            new HeaderHandler('Notify', NotificationCenter::ERROR)
        );

        $this->assertEquals(
            $notificationCenter->error('There was an error.'),
            true
        );
    }
}