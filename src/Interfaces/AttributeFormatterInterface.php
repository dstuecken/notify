<?php
namespace dstuecken\Notify\Interfaces;

/**
 * This interfaces is responsible for pre-formatting the AttributeAware attributes
 *
 * @author  Dennis Stücken <dstuecken@me.com>
 * @package dstuecken\Notify\Interfaces
 */
interface AttributeFormatterInterface
{

    /**
     * Format given list of attributes. Attributes can be passed as a single or multiple parameters.
     *
     * @return array
     */
    public static function formatAttributes();

}
