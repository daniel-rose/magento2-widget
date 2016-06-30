<?php

namespace DR\Widget\Test\Unit\Observer;

use DR\Widget\Observer\ChangeTemplate;
use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Model\Product\Type;
use Magento\Framework\Event;
use Magento\Framework\Event\Observer;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Widget\Block\Adminhtml\Widget\Instance\Edit\Tab\Main\Layout;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class ChangeTemplateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Observer|PHPUnit_Framework_MockObject_MockObject
     */
    protected $observerMock;

    /**
     * @var Event|PHPUnit_Framework_MockObject_MockObject
     */
    protected $eventMock;

    /**
     * @var Layout|PHPUnit_Framework_MockObject_MockObject
     */
    protected $block;

    /**
     * @var Type|PHPUnit_Framework_MockObject_MockObject
     */
    protected $productTypeMock;

    /**
     * @var Context|PHPUnit_Framework_MockObject_MockObject
     */
    protected $contextMock;

    /**
     * @var ChangeTemplate
     */
    protected $observer;

    protected function setUp()
    {
        parent::setUp();

        $objectManager = new ObjectManager($this);

        $this->observerMock = $this->getMockBuilder(Observer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventMock = $this->getMockBuilder(Event::class)
            ->disableOriginalConstructor()
            ->setMethods(['getBlock'])
            ->getMock();

        $this->contextMock = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productTypeMock = $this->getMockBuilder(Type::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->block = $objectManager->getObject(Layout::class, [
            'context' => $this->contextMock,
            'productType' => $this->productTypeMock
        ]);

        $this->observer = $objectManager->getObject(ChangeTemplate::class, []);
    }

    /**
     * @test
     */
    public function testExecuteWithBlockInstanceEqualsLayout()
    {
        $this->eventMock->expects($this->atLeastOnce())
            ->method('getBlock')
            ->willReturn($this->block);
        
        $this->observerMock->expects($this->atLeastOnce())
            ->method('getEvent')
            ->willReturn($this->eventMock);

        $this->observer->execute($this->observerMock);

        $this->assertEquals('DR_Widget::instance/edit/layout.phtml', $this->block->getTemplate());
    }
}