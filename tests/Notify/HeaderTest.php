<?php

use dstuecken\Notify\NotificationCenter;
use dstuecken\Notify\Handler\HeaderHandler;


Class NotifyHeaderTest
    extends \PHPUnit_Framework_TestCase
{
    public function testNotify()
    {

        $notificationCenter = new NotificationCenter();
        $notificationCenter->addHandler(
            new HeaderHandler('Notify', NotificationCenter::ERROR)
        );


        $notificationCenter->error('There was an error.');

        $this->assertEquals($isSent, true);
    }
}