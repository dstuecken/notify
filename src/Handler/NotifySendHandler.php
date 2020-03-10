<?php
namespace dstuecken\Notify\Handler;

use dstuecken\Notify\Interfaces\AttributeAwareInterface;
use dstuecken\Notify\Interfaces\HandlerInterface;
use dstuecken\Notify\Interfaces\NotificationInterface;
use dstuecken\Notify\Interfaces\TitleAwareInterface;
use dstuecken\Notify\NotificationCenter;

/**
 * NotifySendHandler
 *
 * Triggers an Ubuntu notification based on the notify-send shell command
 *
 * @author  Dennis Stücken <dstuecken@me.com>
 * @package dstuecken\Notify\Handler
 */
class NotifySendHandler
    extends AbstractShellCommandHandler
    implements HandlerInterface
{
    /**
     * @var string
     */
    protected $shellCommand = 'notify-send';

    /**
     * Maps Notification Alerts to the available notify-send icons
     *
     * @var array
     */
    private $levelMapping = [
        NotificationCenter::DEBUG     => 'low',
        NotificationCenter::INFO      => 'low',
        NotificationCenter::NOTICE    => 'low',
        NotificationCenter::WARNING   => 'normal',
        NotificationCenter::ERROR     => 'normal',
        NotificationCenter::CRITICAL  => 'critical',
        NotificationCenter::ALERT     => 'critical',
        NotificationCenter::EMERGENCY => 'critical'
    ];

    /**
     * Handle a notification
     *
     * @return bool
     */
    public function handle(NotificationInterface $notification, $level)
    {
        if ($notification instanceof TitleAwareInterface)
        {
            $command = $this->shellCommand . ' ' . escapeshellarg($notification->message()) . ' ' . escapeshellarg($notification->title());
        }
        else
        {
            $command = $this->shellCommand . ' ' . escapeshellarg($notification->message());
        }

        if ($notification instanceof AttributeAwareInterface)
        {
            $expiry = (int) $notification->attribute('expiry');

            if ($expiry)
            {
                $command .= "-t " . $expiry . " ";
            }

            $icon = $notification->attribute('icon');

            if ($expiry)
            {
                $command .= "-i " . $icon . " ";
            }
        }

        $command .= "-u " . $this->levelMapping[$level] . " ";

        exec($command . ' > /dev/null', $output, $code);

        return $code === 0;
    }

}
