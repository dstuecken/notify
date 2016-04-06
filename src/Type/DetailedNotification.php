<?php
namespace dstuecken\Notify\Type;

use dstuecken\Notify\Interfaces\AttributeAwareInterface;

/**
 * Class DetailedNotification
 *
 * @author  Dennis Stücken <dstuecken@i-doit.com>
 * @package dstuecken\Notify\NotificationType
 */
class DetailedNotification
    extends AbstractNotification
    implements AttributeAwareInterface
{
    /**
     * Additional notification attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Returns an attribute.
     *
     * @param string $name Key-name of the attribute
     *
     * @return mixed
     */
    public function attribute($name)
    {
        if (isset($this->attributes[$name]))
        {
            return $this->attributes[$name];
        }

        return '';
    }

    /**
     * @inheritDoc
     */
    public function attributes()
    {
        return $this->attributes;
    }

    /**
     * @param string $message    The notification message
     * @param string $title      The notification title
     * @param array  $attributes Optional attributes
     */
    public function __construct($message, $title = '', $attributes = [])
    {
        parent::__construct($message, $title);
        $this->attributes = $attributes;
    }

}