<?php
namespace dstuecken\Notify\Interfaces;

/**
 * This interfaces describes a notification with a title
 *
 * @author Dennis Stücken <dstuecken@synetics.de>
 * @package dstuecken\Notify\Interfaces
 */
interface TitleAwareInterface
{
    /**
     * Returns the Title or Headline of the message
     *
     * @return mixed
     */
    public function title();
}