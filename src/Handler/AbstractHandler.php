<?php
namespace dstuecken\Notify\Handler;

use dstuecken\Notify\Interfaces\HandlerInterface;
use dstuecken\Notify\Interfaces\NotificationInterface;

/**
 * Abstract handler
 *
 * Provides basic functionality
 *
 * @author  Dennis Stücken <dstuecken@i-doit.com>
 * @package dstuecken\Notify\Handler
 */
abstract class AbstractHandler
{
    /**
     * @var int
     */
    protected $level;

    /**
     * @param NotificationInterface $notification The notification itself
     * @param int                   $level        Level of the current notification
     *
     * @return bool
     */
    public function shouldHandle(NotificationInterface $notification, $level)
    {
        return $level >= $this->level;
    }

}