<?php
namespace dstuecken\Notify\Handler;

use dstuecken\Notify\Interfaces\HandlerInterface;
use dstuecken\Notify\Interfaces\NotificationInterface;
use dstuecken\Notify\NotificationCenter;

/**
 * MacOSHandler
 *
 * Triggers a mac os x notification based on the Mac OS X Notification Center
 *
 * @author  Dennis Stücken <dstuecken@i-doit.com>
 * @package dstuecken\Notify\Handler
 */
class MacOSHandler
    extends AbstractHandler
    implements HandlerInterface
{
    /**
     * @var string
     */
    protected $osaScriptBin = 'osascript';

    /**
     * @var bool
     */
    protected $osaScriptAvailable = NULL;

    /**
     * Handle a notification
     *
     * @return bool
     */
    public function handle(NotificationInterface $notification, $level)
    {
        if (is_a($notification, 'dstuecken\Notify\TitleAwareInterface'))
        {
            $command = $this->osaScriptBin . ' -e \'display notification "' . addslashes($notification->message()) . '" with title "' . addslashes($notification->title()) . '"\'';
        }
        else
        {
            $command = $this->osaScriptBin . ' -e \'display notification "' . addslashes($notification->message()) . '"\'';
        }

        exec($command . ' > /dev/null', $output, $code);

        return $code === 0;
    }

    /**
     * @param NotificationInterface $notification The notification itself
     * @param int                   $level        Level of the current notification
     *
     * @return bool
     */
    public function shouldHandle(NotificationInterface $notification, $level)
    {
        return $this->osaScriptAvailable ? $this->level >= $level : false;
    }

    /**
     * Checks if osasend is usable by querying WHICH(1).
     *
     * @return bool
     */
    public function available()
    {
        if ($this->osaScriptAvailable === NULL)
        {
            exec("which {$this->osaScriptBin} > /dev/null", $output, $code);
            $this->osaScriptAvailable = ($code === 0);
        }

        return $this->osaScriptAvailable;
    }

    /**
     * @param string $identifier
     */
    public function __construct($level = NotificationCenter::INFO)
    {
        $this->level = $level;
        $this->available();
    }

}