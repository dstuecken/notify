<?php
namespace dstuecken\Notify\Handler;

use dstuecken\Notify\Interfaces\AttributeAwareInterface;
use dstuecken\Notify\Interfaces\AttributeFormatterInterface;
use dstuecken\Notify\Interfaces\HandlerInterface;
use dstuecken\Notify\Interfaces\NotificationInterface;
use dstuecken\Notify\Interfaces\TitleAwareInterface;
use dstuecken\Notify\NotificationCenter;

/**
 * Class HeaderHandler
 *
 * Sends various HTTP Header Notifications to be interpreted by a javascript implementation.
 *
 * @author  Dennis Stücken <dstuecken@me.com>
 * @package dstuecken\Notify\Handler
 */
class HeaderHandler
    extends AbstractHandler
    implements HandlerInterface, AttributeFormatterInterface
{

    /**
     * The standard notification-type.
     */
    const STANDARD = 0;

    /**
     * The success notification-type.
     */
    const SUCCESS = 1;

    /**
     * The error notification-type.
     */
    const ERROR = 2;

    /**
     * The info notification-type.
     */
    const INFO = 3;

    /**
     * The warning notification-type.
     */
    const WARNING = 4;

    /**
     * @var int
     */
    protected static $messageindex = 0;

    /**
     * @var string
     */
    protected $identifier = 'Notify';

    /**
     * The notification types.
     *
     * @return  array
     */
    protected static $types = [
        'standard' => self::STANDARD,
        'success'  => self::SUCCESS,
        'error'    => self::ERROR,
        'info'     => self::INFO,
        'warning'  => self::WARNING
    ];

    /**
     * Maps Notification Alerts to the Header Notification types
     *
     * @var array
     */
    protected $levelMapping = [
        NotificationCenter::DEBUG     => self::STANDARD,
        NotificationCenter::INFO      => self::SUCCESS,
        NotificationCenter::NOTICE    => self::INFO,
        NotificationCenter::WARNING   => self::WARNING,
        NotificationCenter::ERROR     => self::ERROR,
        NotificationCenter::CRITICAL  => self::ERROR,
        NotificationCenter::ALERT     => self::ERROR,
        NotificationCenter::EMERGENCY => self::ERROR
    ];

    /**
     * @inheritdoc
     */
    public static function getTypes()
    {
        return self::$types;
    } // function

    /**
     * Handle a notification
     *
     * @return bool
     */
    public function handle(NotificationInterface $notification, $level)
    {
        if (!headers_sent())
        {
            if ($notification instanceof AttributeAwareInterface)
            {
                $options = $notification->attributes();
            }
            else
            {
                $options = [];
            }

            if ($notification instanceof TitleAwareInterface)
            {
                $options['header'] = $notification->title();
            }

            header(
                'X-' . $this->identifier . '-Notification-' . self::$messageindex++ . ':' .
                json_encode(
                    [
                        'message' => $notification->message(),
                        'type'    => isset($this->levelMapping[$level]) ? $this->levelMapping[$level] : self::STANDARD,
                        'options' => $options
                    ]
                )
            );

            return true;
        }

        return true;
    }

    /**
     * Static method for retrieving the options-array.
     *
     * @param   string  $destroy_callback
     * @param   string  $create_callback
     * @param   boolean $sticky
     * @param   integer $life
     * @param   string  $classname
     * @param   integer $width
     *
     * @return  array
     *
     */
    public static function formatAttributes($destroy_callback = null, $create_callback = null, $sticky = null, $life = null, $classname = null, $width = null)
    {
        $options = [];

        if ($destroy_callback !== null)
        {
            $options['destroyed'] = $destroy_callback;
        } // if

        if ($create_callback !== null)
        {
            $options['created'] = $create_callback;
        } // if

        if ($sticky !== null)
        {
            $options['sticky'] = !!$sticky;
        } // if

        if ($life !== null)
        {
            $options['life'] = $life;
        } // if

        if ($classname !== null)
        {
            $options['className'] = $classname;
        } // if

        if ($width !== null)
        {
            $options['width'] = $width;
        } // if

        return $options;
    } // function

    /**
     * @param string $identifier
     */
    public function __construct($identifier = 'Notify', $level = NotificationCenter::INFO)
    {
        $this->identifier = $identifier;
        $this->level      = $level;
    }

}
