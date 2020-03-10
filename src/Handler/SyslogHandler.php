<?php
namespace dstuecken\Notify\Handler;

use dstuecken\Notify\Interfaces\HandlerInterface;
use dstuecken\Notify\Interfaces\NotificationInterface;
use dstuecken\Notify\NotificationCenter;

/**
 * Class SyslogHandler
 *
 * Triggers a syslog message via syslog() function (http://php.net/manual/en/function.syslog.php).
 *
 * @author  Dennis Stücken <dstuecken@me.com>
 * @package dstuecken\Notify\Handler
 */
class SyslogHandler
    extends AbstractHandler
    implements HandlerInterface
{
    /**
     * Maps Syslog Log Levels to the Header Notification Levels
     *
     * @var array
     */
    private $levelMapping = [
        NotificationCenter::DEBUG     => LOG_DEBUG,
        NotificationCenter::INFO      => LOG_INFO,
        NotificationCenter::NOTICE    => LOG_NOTICE,
        NotificationCenter::WARNING   => LOG_WARNING,
        NotificationCenter::ERROR     => LOG_ERR,
        NotificationCenter::CRITICAL  => LOG_CRIT,
        NotificationCenter::ALERT     => LOG_ALERT,
        NotificationCenter::EMERGENCY => LOG_EMERG
    ];

    /**
     * Handle a notification
     *
     * @return bool
     */
    public function handle(NotificationInterface $notification, $level)
    {
        syslog($this->levelMapping[$level], $notification->message());

        return true;
    }

    /**
     * @param string $identifier
     */
    public function __construct($level = NotificationCenter::CRITICAL)
    {
        $this->level = $level;
    }

}
