<?php
namespace dstuecken\Notify\Interfaces;

/**
 * This interfaces describes a notification with attributes
 *
 * @author Dennis Stücken <dstuecken@i-doit.com>
 * @package dstuecken\Notify\Interfaces
 */
interface AttributeAwareInterface
{

    /**
     * Return a single attribute
     *
     * @return mixed
     */
    public function attribute($name);

    /**
     * Return all atrributes
     *
     * @return array
     */
    public function attributes();
}