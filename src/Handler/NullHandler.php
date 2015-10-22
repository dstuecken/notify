<?php
namespace dstuecken\Notify\Handler;

use dstuecken\Notify\Interfaces\HandlerInterface;
use dstuecken\Notify\Interfaces\NotificationInterface;

/**
 * Class NullHandler
 *
 * Does nothing
 *
 * @author  Dennis Stücken <dstuecken@i-doit.com>
 * @package dstuecken\Notify\Handler
 */
class NullHandler
    implements HandlerInterface
{

    /**
     * Handle a notification
     *
     * @return bool
     */
    public function handle(NotificationInterface $notification, $level)
    {
        return true;
    }

    /**
     * @param NotificationInterface $notification
     *
     * @return bool
     */
    public function shouldHandle(NotificationInterface $notification, $level)
    {
        return true;
    }

}