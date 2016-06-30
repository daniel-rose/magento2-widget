<?php

namespace DR\Widget\Observer;

use Magento\Framework\Event;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Element\Html\Select;

class AddDisplayOnOptions implements ObserverInterface
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

        if (!$block || !($block instanceof Select) || $block->getName() !== 'widget_instance[<%- data.id %>][page_group]') {
            return;
        }
        
        $label = $block->escapeJsQuote(__('Cms'));
        $value = [
            ['value' => 'cms_pages', 'label' => $block->escapeJsQuote(__('Pages'))]
        ];

        $block->addOption($value, $label);
    }
}