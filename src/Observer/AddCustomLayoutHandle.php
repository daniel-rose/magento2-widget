<?php

namespace DR\Widget\Observer;

use Magento\Framework\App\Request\Http;
use Magento\Framework\Event;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AddCustomLayoutHandle implements ObserverInterface
{
    /**
     * @var Http
     */
    protected $request;

    /**
     * Constructor
     *
     * @param Http $request
     */
    public function __construct(
        Http $request
    )
    {
        $this->request = $request;
    }

    /**
     * Execute
     *
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

        $layout = $event->getLayout();
        $fullActionName = $event->getFullActionName();
        $pageId = $this->request->get('page_id');

        if ($fullActionName === 'cms_page_view' && $pageId) {
            $layout->getUpdate()->addHandle('cms_page_view_id_' . $pageId);
        }
    }
}