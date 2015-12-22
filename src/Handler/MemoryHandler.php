<?php
namespace dstuecken\Notify\Handler;

use dstuecken\Notify\Interfaces\HandlerInterface;
use dstuecken\Notify\Interfaces\NotificationInterface;
use dstuecken\Notify\NotificationCenter;

/**
 * Class MemoryHandler
 *
 * Save all notifications in memory.
 *
 * @author  Dennis Stücken <dstuecken@i-doit.com>
 * @package dstuecken\Notify\Handler
 */
class MemoryHandler
    extends AbstractHandler
    implements HandlerInterface
{
    protected $memory = array();

    /**
     * @return array
     */
    public function get()
    {
        return $this->memory;
    }

    /**
     * Handle a notification
     *
     * @return bool
     */
    public function handle(NotificationInterface $notification, $level)
    {
        $this->memory[$level][] = $notification->message();

        return true;
    }

    /**
     * @param string $identifier
     */
    public function __construct($level = NotificationCenter::DEBUG)
    {
        $this->level      = $level;
    }

}