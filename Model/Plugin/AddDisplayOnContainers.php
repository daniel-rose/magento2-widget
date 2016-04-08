<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 07.04.16
 * Time: 10:11
 */

namespace DR\Widget\Model\Plugin;

use Magento\Framework\Json\Helper\Data;
use Magento\Framework\UrlInterface;
use Magento\Widget\Block\Adminhtml\Widget\Instance\Edit\Tab\Main\Layout;

class AddDisplayOnContainers
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
     * AddDisplayOnContainers constructor.
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


    public function afterGetDisplayOnContainers(Layout $layout, $displayOnContainers)
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