<?php
namespace dstuecken\Notify\Handler;

use dstuecken\Notify\Interfaces\AttributeFormatterInterface;
use dstuecken\Notify\Interfaces\HandlerInterface;
use dstuecken\Notify\Interfaces\NotificationInterface;
use dstuecken\Notify\NotificationCenter;

/**
 * Class HeaderHandler
 *
 * Sends various HTTP Header Notifications to be interpreted by a javascript implementation.
 *
 * @author  Dennis Stücken <dstuecken@i-doit.com>
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
    protected static $types = array(
        'standard' => self::STANDARD,
        'success'  => self::SUCCESS,
        'error'    => self::ERROR,
        'info'     => self::INFO,
        'warning'  => self::WARNING
    );

    /**
     * Maps Notification Alerts to the Header Notification types
     *
     * @var array
     */
    protected $levelMapping = array(
        NotificationCenter::DEBUG     => self::STANDARD,
        NotificationCenter::INFO      => self::SUCCESS,
        NotificationCenter::NOTICE    => self::INFO,
        NotificationCenter::WARNING   => self::WARNING,
        NotificationCenter::ERROR     => self::ERROR,
        NotificationCenter::CRITICAL  => self::ERROR,
        NotificationCenter::ALERT     => self::ERROR,
        NotificationCenter::EMERGENCY => self::ERROR
    );

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
            if (is_a($notification, 'dstuecken\Notify\AttributeAwareInterface'))
            {
                $options = $notification->attributes();
            }
            else
            {
                $options = array();
            }

            if (is_a($notification, 'dstuecken\Notify\TitleAwareInterface'))
            {
                $options['header'] = $notification->title();
            }

            header(
                'X-' . $this->identifier . '-Notification-' . self::$messageindex++ . ':' .
                json_encode(
                    array(
                        'message' => $notification->message(),
                        'type'    => isset($this->levelMapping[$level]) ? $this->levelMapping[$level] : self::STANDARD,
                        'options' => $options
                    )
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
    public static function formatAttributes($destroy_callback = NULL, $create_callback = NULL, $sticky = NULL, $life = NULL, $classname = NULL, $width = NULL)
    {
        $options = array();

        if ($destroy_callback !== NULL)
        {
            $options['destroyed'] = $destroy_callback;
        } // if

        if ($create_callback !== NULL)
        {
            $options['created'] = $create_callback;
        } // if

        if ($sticky !== NULL)
        {
            $options['sticky'] = !!$sticky;
        } // if

        if ($life !== NULL)
        {
            $options['life'] = $life;
        } // if

        if ($classname !== NULL)
        {
            $options['className'] = $classname;
        } // if

        if ($width !== NULL)
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