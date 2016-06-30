<?php

namespace DR\Widget\Plugin\Widget\Block\Adminhtml\Widget\Instance\Edit\Tab\Main;

use Magento\Framework\Json\Helper\Data;
use Magento\Framework\UrlInterface;
use Magento\Widget\Block\Adminhtml\Widget\Instance\Edit\Tab\Main\Layout as LayoutBlock;

class Layout
{
    /**
     * @var Data
     */
    protected $jsonHelper;

    /**
     * Url Builder
     *
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor
     *
     * @param UrlInterface $urlBuilder
     * @param Data $jsonHelper
     */
    public function __construct(
        UrlInterface $urlBuilder,
        Data $jsonHelper
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->jsonHelper = $jsonHelper;
    }


    /**
     * After method getDisplayOnContainers()
     *
     * @param LayoutBlock $layout
     * @param array $displayOnContainers
     * @return array
     */
    public function afterGetDisplayOnContainers(LayoutBlock $layout, $displayOnContainers)
    {
        $additional = [
            'url' => $this->urlBuilder->getUrl('dr_widget/cms_page_widget/chooser', ['_current' => true])
        ];

        $displayOnContainers['cms_pages'] = [
            'label' => 'Cms Pages',
            'code' => 'cms_pages',
            'name' => 'cms_pages',
            'layout_handle' => 'cms_page_view',
            'is_anchor_only' => '',
            'product_type_id' => '',
            'additional' => $this->jsonHelper->jsonEncode($additional)
        ];

        return $displayOnContainers;
    }
}