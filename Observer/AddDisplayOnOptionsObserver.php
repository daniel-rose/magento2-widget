<?php

namespace DR\Widget\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\Element\Html\Select;

class AddDisplayOnOptionsObserver implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();

        if ($block instanceof Select && $block->getName() == 'widget_instance[<%- data.id %>][page_group]') {
            $options = $block->getOptions();

            $options[] = [
                'label' => $block->escapeJsQuote(__('Cms')),
                'value' => [
                    ['value' => 'cms_pages', 'label' => $block->escapeJsQuote(__('Pages'))]
                ]
            ];

            $block->setOptions($options);
        }
    }
}