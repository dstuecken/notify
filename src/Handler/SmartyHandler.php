<?php
namespace dstuecken\Notify\Handler;

use dstuecken\Notify\Interfaces\AttributeAwareInterface;
use dstuecken\Notify\Interfaces\NotificationInterface;
use dstuecken\Notify\Interfaces\TitleAwareInterface;
use dstuecken\Notify\NotificationCenter;

/**
 * Class SmartyHandler
 * Sends notifications directly to the template system.
 *
 * @author  Dennis Stücken <dstuecken@me.com>
 * @package idoit\Notify\Handler
 */
class SmartyHandler
    extends HeaderHandler
{
    /**
     * @var  \Smarty
     */
    private $smarty;

    /**
     * @var  string
     */
    private $var;

    /**
     * Handle a notification.
     *
     * @return  boolean
     */
    public function handle(NotificationInterface $notification, $level)
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

        $variable = [
            'message' => $notification->message(),
            'type'    => isset($this->levelMapping[$level]) ? $this->levelMapping[$level] : self::STANDARD,
            'options' => $options
        ];

        $current = $this->smarty->getTemplateVars($this->var);

        if (!$current)
        {
            $this->smarty->assign($this->var, [$variable]);
        }
        else
        {
            $this->smarty->append($this->var, $variable);
        }

        return true;
    }

    /**
     * SmartyHandler constructor.
     *
     * @param  \Smarty $template
     * @param  string  $templateVariable
     * @param  integer $level
     * @param  string  $identifier
     */
    public function __construct(\Smarty $template, $templateVariable = 'notification', $level = NotificationCenter::INFO, $identifier = 'Smarty')
    {
        parent::__construct($identifier, $level);

        $this->smarty = $template;
        $this->var    = $templateVariable;
    }
}
