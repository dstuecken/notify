<?php
namespace dstuecken\Notify\Interfaces;

/**
 * This interfaces is responsible for pre-formatting the AttributeAware attributes
 *
 * @author Dennis Stücken <dstuecken@synetics.de>
 * @package dstuecken\Notify\Interfaces
 */
interface AttributeFormatterInterface
{

    /**
     * Return a single attribute
     *
     * @param list of parameters
     *
     * @return array
     */
    public static function formatAttributes();

}