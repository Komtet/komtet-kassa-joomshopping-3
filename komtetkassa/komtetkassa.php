<?php

JLoader::register('komtetHelper', JPATH_PLUGINS.'/system/komtetkassa/helpers/komtethelper.php');

class plgSystemKomtetkassa extends JPlugin
{

    protected $autoloadLanguage = true;

    public function isShouldFiscalize($pm_system_id)
    {
        $pm_methods_ids = explode(',', $this->params->get('pm_methods'));
        foreach ($pm_methods_ids as $pm_m_id)
        {
            $pm_m_id = trim($pm_m_id);
        }

        if (in_array($pm_system_id, $pm_methods_ids))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function __construct(& $subject, $config)
    {
        parent::__construct($subject, $config);
    }

    public function fiscalize($order, $params)
    {
        komtetHelper::fiscalize($order, $params);
        return;
    }

    public function onAfterDisplayCheckoutFinish(&$text, &$order, &$pm_method)
    {
        if($this->isShouldFiscalize($order->payment_method_id))
        {
            $this->fiscalize($order, $this->params);
        }
        return true;
    }

    public function onAfterChangeOrderStatusAdmin(&$order, &$order_status, &$status_id, &$notify, &$comments, &$include, &$view_order)
    {       
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__jshopping_orders', 'order'));
        $query->where($db->quoteName('order.order_id')." = ".$db->quote($order));
        $db->setQuery($query);
        $_order = $db->loadObjectList();

        if ( !in_array($order_status, array(0,1,3)) && $this->isShouldFiscalize($_order[0]->payment_method_id))
        {
            $this->fiscalize($_order[0], $this->params);
        }
        return true;
    }

    public function onStep7BefereNotify(&$order, &$jshopCheckoutBuy, &$pmconfigs)
    {
        if ( !in_array($order->order_status, array(0,3)) && $this->isShouldFiscalize($order->payment_method_id))
        {
            $this->fiscalize($order, $this->params);
        }
        return true;
    }

}