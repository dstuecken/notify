<?php
namespace dstuecken\Notify;

use dstuecken\Notify\Handler\HeaderHandler;
use dstuecken\Notify\Interfaces\HandlerInterface;
use dstuecken\Notify\Interfaces\NotificationInterface;
use dstuecken\Notify\Type\DetailedNotification;
use Psr\Log\LoggerInterface;

/**
 * Class NotificationCenter
 *
 * @package dstuecken\Notify
 * @author Dennis Stücken <dstuecken@synetics.de>
 */
class NotificationCenter
    implements LoggerInterface
{

    /**
     * Debug
     */
    const DEBUG = 100;

    /**
     * Informative
     */
    const INFO = 200;

    /**
     * Notices
     */
    const NOTICE = 250;

    /**
     * Warnings or Exceptions
     */
    const WARNING = 300;

    /**
     * Runtime errors
     */
    const ERROR = 400;

    /**
     * Critical problems
     */
    const CRITICAL = 500;

    /**
     * Alerts
     */
    const ALERT = 550;

    /**
     * Problematic issues
     */
    const EMERGENCY = 600;

    /**
     * The handler stack
     *
     * @var HandlerInterface[]
     */
    protected $handlers;

    /**
     * @var NotificationInterface[]
     */
    protected $notifications = array();

    /**
     * @param HandlerInterface[] $handlers Optional stack of handlers, the first one in the array is called first, etc.
     */
    public function __construct(array $handlers = array())
    {
        $this->handlers = $handlers;
    }

    /**
     * Push handler to stack.
     *
     * @param HandlerInterface $handler
     *
     * @return $this
     */
    public function addHandler(HandlerInterface $handler)
    {
        array_unshift($this->handlers, $handler);

        return $this;
    }

    /**
     * Pops last handler from stack
     *
     * @return HandlerInterface
     */
    public function popHandler()
    {
        if (!$this->handlers)
        {
            throw new \LogicException('Your handler stack is empty.');
        }

        return array_shift($this->handlers);
    }

    /**
     * Returns all the handlers associated to this manager.
     *
     * @return HandlerInterface[]
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * Handles notification for every handler
     *
     * @param NotificationInterface $notification the notification instanceitself
     * @param int                   $level        Level of this notification
     *
     * @return bool
     */
    public function notify(NotificationInterface $notification, $level = self::INFO)
    {
        if (!$this->handlers)
        {
            $this->addHandler(new HeaderHandler());
        }

        foreach ($this->getHandlers() as $handler)
        {
            if ($handler->shouldHandle($notification, $level))
            {
                if (false === $handler->handle($notification, $level))
                {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Adds a new notification message to the queue as an attribute aware notification
     *
     * @param  mixed  $level   The log level
     * @param  string $message notification message (body)
     * @param  array  $context notification parameters
     *
     * @return bool record processed or not?
     */
    public function log($level, $message, array $context = array())
    {
        return $this->notify(
            $level,
            new DetailedNotification($message, '', $context)
        );
    }

    /**
     * Debug level notification
     *
     * @param  string $message notification message (body)
     * @param  array  $context notification parameters
     *
     * @return bool record processed or not?
     */
    public function debug($message, array $context = array())
    {
        return $this->notify(
            new DetailedNotification($message, '', $context),
            static::DEBUG
        );
    }

    /**
     * Info level notification
     *
     * @param  string $message notification message (body)
     * @param  array  $context notification parameters
     *
     * @return bool record processed or not?
     */
    public function info($message, array $context = array())
    {
        return $this->notify(
            new DetailedNotification($message, '', $context),
            static::INFO
        );
    }

    /**
     * Notice level notification
     *
     * @param  string $message notification message (body)
     * @param  array  $context notification parameters
     *
     * @return bool record processed or not?
     */
    public function notice($message, array $context = array())
    {
        return $this->notify(
            new DetailedNotification($message, '', $context),
            static::NOTICE
        );
    }

    /**
     * Warning level notification
     *
     * @param  string $message notification message (body)
     * @param  array  $context notification parameters
     *
     * @return bool record processed or not?
     */
    public function warning($message, array $context = array())
    {
        return $this->notify(
            new DetailedNotification($message, '', $context),
            static::WARNING
        );
    }

    /**
     * Error level notification
     *
     * @param  string $message notification message (body)
     * @param  array  $context notification parameters
     *
     * @return bool record processed or not?
     */
    public function error($message, array $context = array())
    {
        return $this->notify(
            new DetailedNotification($message, '', $context),
            static::ERROR
        );
    }

    /**
     * Critical level notification
     *
     * @param  string $message notification message (body)
     * @param  array  $context notification parameters
     *
     * @return bool record processed or not?
     */
    public function critical($message, array $context = array())
    {
        return $this->notify(
            new DetailedNotification($message, '', $context),
            static::CRITICAL
        );
    }

    /**
     * Alert level notification
     *
     * @param  string $message notification message (body)
     * @param  array  $context notification parameters
     *
     * @return bool record processed or not?
     */
    public function alert($message, array $context = array())
    {
        return $this->notify(
            new DetailedNotification($message, '', $context),
            static::ALERT
        );
    }

    /**
     * Emergency level notification
     *
     * @param  string $message notification message (body)
     * @param  array  $context notification parameters
     *
     * @return bool record processed or not?
     */
    public function emergency($message, array $context = array())
    {
        return $this->notify(
            new DetailedNotification($message, '', $context),
            static::EMERGENCY
        );
    }

}