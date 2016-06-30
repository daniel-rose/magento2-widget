<?php

namespace DR\Widget\Test\Unit\Plugin\Widget\Block\Adminhtml\Widget\Instance\Edit\Tab\Main;

use DR\Widget\Plugin\Widget\Block\Adminhtml\Widget\Instance\Edit\Tab\Main\Layout;
use Magento\Framework\Json\Helper\Data;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\UrlInterface;
use Magento\Widget\Block\Adminhtml\Widget\Instance\Edit\Tab\Main\Layout as LayoutBlock;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class LayoutTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var UrlInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected $urlBuilderMock;

    /**
     * @var Data|PHPUnit_Framework_MockObject_MockObject
     */
    protected $jsonHelperMock;

    /**
     * @var LayoutBlock|PHPUnit_Framework_MockObject_MockObject
     */
    protected $layoutBlockMock;

    /**
     * @var Layout|PHPUnit_Framework_MockObject_MockObject
     */
    protected $plugin;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        $objectManager = new ObjectManager($this);

        $this->jsonHelperMock = $this->getMockBuilder(Data::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->urlBuilderMock = $this->getMockBuilder(UrlInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->layoutBlockMock = $this->getMockBuilder(LayoutBlock::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = $objectManager->getObject(Layout::class, [
            'urlBuilder' => $this->urlBuilderMock,
            'jsonHelper' => $this->jsonHelperMock
        ]);
    }

    /**
     * @test
     */
    public function testAfterGetDisplayOnContainers()
    {
        $url = 'https://www.magento.com/admin/dr_widget/cms_page_widget/chooser';
        
        $this->urlBuilderMock->expects($this->atLeastOnce())
            ->method('getUrl')
            ->with('dr_widget/cms_page_widget/chooser', ['_current' => true])
            ->willReturn($url);
        
        $this->jsonHelperMock->expects($this->atLeastOnce())
            ->method('jsonEncode')
            ->with(['url' => $url])
            ->willReturn('{url: "https://magento.com/admin/dr_widget/cms_page_widget/chooser"}');

        $displayContainers = $this->plugin->afterGetDisplayOnContainers($this->layoutBlockMock, []);

        $this->assertEquals([
            'cms_pages' => [
                'label' => 'Cms Pages',
                'code' => 'cms_pages',
                'name' => 'cms_pages',
                'layout_handle' => 'cms_page_view',
                'is_anchor_only' => '',
                'product_type_id' => '',
                'additional' => '{url: "https://magento.com/admin/dr_widget/cms_page_widget/chooser"}'
            ]
        ], $displayContainers);
    }
}