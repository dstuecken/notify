<?php
namespace dstuecken\Notify\Type;

use dstuecken\Notify\Interfaces\NotificationInterface;
use dstuecken\Notify\Interfaces\TitleAwareInterface;

/**
 * Base notification class.
 *
 * @author Dennis Stücken <dstuecken@synetics.de>
 */
abstract class AbstractNotification implements
    NotificationInterface,
    TitleAwareInterface
{

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @param        $message
     * @param string $title
     * @param array  $attributes
     */
    public function __construct($message, $title = '')
    {
        $this->message    = $message;
        $this->title      = $title;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * Sets the message transported by this notification.
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Sets the titletransported by this notification.
     *
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}