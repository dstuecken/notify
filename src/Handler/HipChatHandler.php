<?php
namespace dstuecken\Notify\Handler;

use dstuecken\Notify\Interfaces\AttributeAwareInterface;
use dstuecken\Notify\Interfaces\HandlerInterface;
use dstuecken\Notify\Interfaces\NotificationInterface;
use dstuecken\Notify\NotificationCenter;
use HipChat\HipChat;

/**
 * HipChatHandler
 *
 * Triggers a HipChat notification
 *
 * @author  Dennis Stücken <dstuecken@i-doit.com>
 * @package dstuecken\Notify\Handler
 */
class HipChatHandler
    extends AbstractHandler
    implements HandlerInterface
{

    /**
     * @var HipChat
     */
    protected $hipchat = null;

    /**
     * @var string
     */
    protected $room = '';

    /**
     * @var string
     */
    protected $from = 'dstuecken/Notify';

    /**
     * Maps Notification Alerts to the available notify-send icons
     *
     * @var array
     */
    private $levelMapping = [
        NotificationCenter::DEBUG     => HipChat::COLOR_GRAY,
        NotificationCenter::INFO      => HipChat::COLOR_GRAY,
        NotificationCenter::NOTICE    => HipChat::COLOR_GRAY,
        NotificationCenter::WARNING   => HipChat::COLOR_YELLOW,
        NotificationCenter::ERROR     => HipChat::COLOR_RED,
        NotificationCenter::CRITICAL  => HipChat::COLOR_RED,
        NotificationCenter::ALERT     => HipChat::COLOR_RED,
        NotificationCenter::EMERGENCY => HipChat::COLOR_PURPLE
    ];

    /**
     * Handle a notification
     *
     * @return bool
     */
    public function handle(NotificationInterface $notification, $level)
    {
        if ($notification instanceof AttributeAwareInterface)
        {
            $notify = $notification->attribute('notify');
            $format = $notification->attribute('format') ?: HipChat::FORMAT_HTML;
        }
        else
        {
            $format = HipChat::FORMAT_HTML;
            $notify = true;
        }

        return $this->hipchat->message_room(
            $this->room,
            $this->from,
            $notification->message(),
            $notify,
            $this->levelMapping[$level],
            $format
        );
    }

    /**
     * @return HipChat
     */
    public function hipchat()
    {
        return $this->hipchat;
    }

    /**
     * @param string $identifier
     */
    public function __construct(HipChat $hipchat, $hipchatRoom = '', $level = NotificationCenter::INFO, $from = null)
    {
        $this->room    = $hipchatRoom;
        $this->hipchat = $hipchat;
        $this->level   = $level;

        if ($from)
        {
            $this->from = $from;
        }
    }

}