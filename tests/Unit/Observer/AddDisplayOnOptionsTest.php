<?php

namespace DR\Widget\Test\Unit\Observer;

use DR\Widget\Observer\AddDisplayOnOptions;
use Magento\Backend\Block\Template;
use Magento\Framework\Event;
use Magento\Framework\Event\Observer;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\View\Element\Html\Select;
use Magento\Framework\View\Element\Html\Date;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class AddDisplayOnOptionsTest extends PHPUnit_Framework_TestCase
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
     * @var Select
     */
    protected $selectBlock;

    /**
     * @var Date|PHPUnit_Framework_MockObject_MockObject
     */
    protected $dateBlockMock;

    /**
     * @var AddDisplayOnOptions
     */
    protected $addDisplayOnOptionsObserver;

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
            ->setMethods(['getBlock'])
            ->getMock();
        
        $this->dateBlockMock = $this->getMockBuilder(Date::class)
            ->disableOriginalConstructor()
            ->setMethods(['getName'])
            ->getMock();

        $this->selectBlock = $objectManager->getObject(Select::class, []);

        $this->addDisplayOnOptionsObserver = $objectManager->getObject(AddDisplayOnOptions::class, []);
    }

    /**
     * @test
     */
    public function testExecuteWithBlockInstanceEqualsSelect()
    {
        $this->eventMock->expects($this->atLeastOnce())
            ->method('getBlock')
            ->willReturn($this->selectBlock);

        $this->observerMock->expects($this->atLeastOnce())
            ->method('getEvent')
            ->willReturn($this->eventMock);

        $this->selectBlock->setName('widget_instance[<%- data.id %>][page_group]');

        $this->addDisplayOnOptionsObserver->execute($this->observerMock);

        $this->assertEquals([
            0 => [
                'label' => $this->selectBlock->escapeJsQuote(__('Cms')),
                'value' => [
                    ['value' => 'cms_pages', 'label' => $this->selectBlock->escapeJsQuote(__('Pages'))]
                ],
                'params' => []
            ]
        ], $this->selectBlock->getOptions());
    }

    /**
     * @test
     */
    public function testExecuteWithBlockInstanceEqualsSelectAndWrongName()
    {
        $this->eventMock->expects($this->atLeastOnce())
            ->method('getBlock')
            ->willReturn($this->selectBlock);

        $this->observerMock->expects($this->atLeastOnce())
            ->method('getEvent')
            ->willReturn($this->eventMock);

        $this->selectBlock->setName('foo');

        $this->addDisplayOnOptionsObserver->execute($this->observerMock);

        $this->assertEquals([], $this->selectBlock->getOptions());
    }

    /**
     * @test
     */
    public function testExecuteWithBlockInstanceNotEqualsSelect()
    {
        $this->eventMock->expects($this->atLeastOnce())
            ->method('getBlock')
            ->willReturn($this->dateBlockMock);

        $this->observerMock->expects($this->atLeastOnce())
            ->method('getEvent')
            ->willReturn($this->eventMock);

        $this->dateBlockMock->expects($this->never())
            ->method('getName');

        $this->addDisplayOnOptionsObserver->execute($this->observerMock);
    }
}