<?php
namespace dstuecken\Notify\Interfaces;

use dstuecken\Notify\Interfaces\NotificationInterface;

/**
 * This interfaces is responsible for doing stuff with the notifications
 *
 * @author Dennis Stücken <dstuecken@i-doit.com>
 * @package dstuecken\Notify\Interfaces
 */
interface HandlerInterface
{

    /**
     * Handle a notification
     *
     * @return bool
     */
    public function handle(NotificationInterface $notification, $level);

    /**
     * @param NotificationInterface $notification
     *
     * @return bool
     */
    public function shouldHandle(NotificationInterface $notification, $level);
}