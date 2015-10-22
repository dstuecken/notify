<?php
namespace dstuecken\Notify\Type;

use dstuecken\Notify\AbstractNotification;

/**
 * Class DetailedNotification
 *
 * @author Dennis Stücken <dstuecken@synetics.de>
 * @package dstuecken\Notify\NotificationType
 */
class DetailedNotification extends AbstractNotification
{
    /**
     * Additional notification attributes
     *
     * @var array
     */
    protected $attributes = array();

    /**
     * Returns a parameter.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function parameter($id)
    {
        if (isset($this->attributes[$id]))
        {
            return $this->attributes[$id];
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

}