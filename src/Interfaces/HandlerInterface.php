<?php
namespace dstuecken\Notify\Interfaces;

/**
 * This interfaces is responsible for doing stuff with the notifications
 *
 * @author  Dennis Stücken <dstuecken@me.com>
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
