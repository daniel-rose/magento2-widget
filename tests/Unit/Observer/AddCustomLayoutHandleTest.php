<?php

namespace DR\Widget\Test\Unit\Observer;

use DR\Widget\Observer\AddCustomLayoutHandle;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Event;
use Magento\Framework\Event\Observer;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\View\Layout\ProcessorInterface;
use Magento\Framework\View\LayoutInterface;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class AddCustomLayoutHandleTest extends PHPUnit_Framework_TestCase
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
     * @var Http|PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestMock;

    /**
     * @var LayoutInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected $layoutMock;

    /**
     * @var ProcessorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    protected $updateMock;

    /**
     * @var AddCustomLayoutHandle
     */
    protected $addCustomLayoutHandleObserver;
    
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
        
        $objectManager = new ObjectManager($this);
        
        $this->observerMock = $this->getMockBuilder(Observer::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->eventMock = $this->getMockBuilder(Event::class)
            ->disableOriginalConstructor()
            ->setMethods(['getLayout', 'getFullActionName'])
            ->getMock();
        
        $this->requestMock = $this->getMockBuilder(Http::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->layoutMock = $this->getMockBuilder(LayoutInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->updateMock = $this->getMockBuilder(ProcessorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->addCustomLayoutHandleObserver = $objectManager->getObject(AddCustomLayoutHandle::class, [
            'request' => $this->requestMock
        ]);
    }

    /**
     * @test
     */
    public function testExecuteWithFullActionNameEqualsCmsPageView() {
        $pageId = 1;

        $this->requestMock->expects($this->atLeastOnce())
            ->method('get')
            ->with('page_id')
            ->willReturn($pageId);

        $this->updateMock->expects($this->atLeastOnce())
            ->method('addHandle')
            ->with('cms_page_view_id_' . $pageId);

        $this->layoutMock->expects($this->atLeastOnce())
            ->method('getUpdate')
            ->willReturn($this->updateMock);
        
        $this->eventMock->expects($this->atLeastOnce())
            ->method('getLayout')
            ->willReturn($this->layoutMock);

        $this->eventMock->expects($this->atLeastOnce())
            ->method('getFullActionName')
            ->willReturn('cms_page_view');
        
        $this->observerMock->expects($this->atLeastOnce())
            ->method('getEvent')
            ->willReturn($this->eventMock);
        
        $this->addCustomLayoutHandleObserver->execute($this->observerMock);
    }

    /**
     * @test
     */
    public function testExecuteWithFullActionNameNotEqualsCmsPageView() {
        $pageId = null;

        $this->requestMock->expects($this->atLeastOnce())
            ->method('get')
            ->with('page_id')
            ->willReturn($pageId);

        $this->updateMock->expects($this->never())
            ->method('addHandle');

        $this->layoutMock->expects($this->never())
            ->method('getUpdate')
            ->willReturn($this->updateMock);

        $this->eventMock->expects($this->atLeastOnce())
            ->method('getLayout')
            ->willReturn($this->layoutMock);

        $this->eventMock->expects($this->atLeastOnce())
            ->method('getFullActionName')
            ->willReturn('catalog_product_view');

        $this->observerMock->expects($this->atLeastOnce())
            ->method('getEvent')
            ->willReturn($this->eventMock);

        $this->addCustomLayoutHandleObserver->execute($this->observerMock);
    }
}