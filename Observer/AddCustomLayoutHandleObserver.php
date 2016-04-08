<?php

namespace DR\Widget\Observer;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AddCustomLayoutHandleObserver implements ObserverInterface
{
    /**
     * @var Http
     */
    protected $request;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * AddCustomLayoutHandleObserver constructor.
     * @param Http $request
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Http $request,
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->request = $request;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $layout = $observer->getEvent()->getLayout();
        $fullActionName = $observer->getEvent()->getFullActionName();
        $pageId = $this->request->get('page_id');

        switch ($fullActionName) {
            case 'cms_page_view':
                $layout->getUpdate()->addHandle('cms_page_view_id_' . $pageId);
                break;
        }
    }
}