<?php

namespace DR\Widget\Observer;

use Magento\Framework\Event;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Widget\Block\Adminhtml\Widget\Instance\Edit\Tab\Main\Layout;

class ChangeTemplate implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        if (!$observer || !($observer instanceof Observer)) {
            return;
        }

        $event = $observer->getEvent();

        if (!$event || !($event instanceof Event)) {
            return;
        }

        $block = $observer->getEvent()->getBlock();

        if ($block instanceof Layout) {
            $block->setTemplate('DR_Widget::instance/edit/layout.phtml');
        }
    }
}