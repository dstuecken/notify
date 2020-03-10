<?php
namespace dstuecken\Notify\Handler;

use dstuecken\Notify\Interfaces\HandlerInterface;
use dstuecken\Notify\Interfaces\NotificationInterface;
use dstuecken\Notify\Interfaces\TitleAwareInterface;

/**
 * MacOSHandler
 *
 * Triggers a mac os x notification based on the Mac OS X Notification Center
 *
 * @author  Dennis Stücken <dstuecken@me.com>
 * @package dstuecken\Notify\Handler
 */
class MacOSHandler
    extends AbstractShellCommandHandler
    implements HandlerInterface
{
    /**
     * @var string
     */
    protected $shellCommand = 'osascript';

    /**
     * Handle a notification
     *
     * @return bool
     */
    public function handle(NotificationInterface $notification, $level)
    {
        if ($notification instanceof TitleAwareInterface)
        {
            $command = $this->shellCommand . ' -e \'display notification "' . addslashes($notification->message()) . '" with title "' . addslashes($notification->title()) . '"\'';
        }
        else
        {
            $command = $this->shellCommand . ' -e \'display notification "' . addslashes($notification->message()) . '"\'';
        }

        exec($command . ' > /dev/null', $output, $code);

        return $code === 0;
    }

}
