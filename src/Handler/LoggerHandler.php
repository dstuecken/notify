<?php
namespace dstuecken\Notify\Handler;

use dstuecken\Notify\Interfaces\HandlerInterface;
use dstuecken\Notify\Interfaces\NotificationInterface;
use dstuecken\Notify\NotificationCenter;
use Psr\Log\LoggerInterface;

/**
 * Class LoggerHandler
 *
 * Sends all notifications to a logger
 *
 * @author  Dennis Stücken <dstuecken@i-doit.com>
 * @package dstuecken\Notify\Handler
 */
class LoggerHandler
    extends AbstractHandler
    implements HandlerInterface
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Handle a notification
     *
     * @return bool
     */
    public function handle(NotificationInterface $notification, $level)
    {
        return $this->logger->log($level, $notification->message());
    }

    /**
     * @param string $identifier
     */
    public function __construct(LoggerInterface $logger, $level = NotificationCenter::INFO)
    {
        $this->logger = $logger;
        $this->level  = $level;
    }

}