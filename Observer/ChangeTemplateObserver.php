<?php

namespace DR\Widget\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Widget\Block\Adminhtml\Widget\Instance\Edit\Tab\Main\Layout;

class ChangeTemplateObserver implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();

        if ($block instanceof Layout) {
            $block->setTemplate('DR_Widget::instance/edit/layout.phtml');
        }
    }
}