<?php
namespace dstuecken\Notify\Handler;

use dstuecken\Notify\Interfaces\NotificationInterface;
use dstuecken\Notify\NotificationCenter;

/**
 * Abstract Shell Command handler
 *
 * Provides basic functionality for calling a shell command
 *
 * @author  Dennis Stücken <dstuecken@me.com>
 * @package dstuecken\Notify\Handler
 */
abstract class AbstractShellCommandHandler
    extends AbstractHandler
{
    /**
     * @var string
     */
    protected $shellCommand = '';

    /**
     * @var bool
     */
    protected $shellCommandAvailable = null;

    /**
     * @param NotificationInterface $notification The notification itself
     * @param int                   $level        Level of the current notification
     *
     * @return bool
     */
    public function shouldHandle(NotificationInterface $notification, $level)
    {
        return $this->shellCommandAvailable ? $this->level >= $level : false;
    }

    /**
     * Checks if osasend is usable by querying WHICH(1).
     *
     * @return bool
     */
    public function available()
    {
        if ($this->shellCommandAvailable === null)
        {
            exec("which {$this->shellCommand} > /dev/null", $output, $code);
            $this->shellCommandAvailable = ($code === 0);
        }

        return $this->shellCommandAvailable;
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
