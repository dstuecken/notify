<?php
namespace NotifyTest;

use dstuecken\Notify\Handler\HipChatHandler;
use dstuecken\Notify\NotificationCenter;
use dstuecken\Notify\Type\DetailedNotification;

Class HipChatHandlerTest
    extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \HipChat\HipChat
     */
    protected $hipchat;

    public function setUp()
    {
        $this->hipchat = $this->getMock('HipChat\HipChat', array(), array('1234567890'));
    }

    public function testNotify()
    {
        $notificationCenter = new NotificationCenter();
        $notificationCenter->addHandler(
            new HipChatHandler(
                $this->hipchat, NotificationCenter::ERROR
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