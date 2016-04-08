<?php

namespace DR\Widget\Controller\Adminhtml\Cms\Page\Widget;

use DR\Widget\Block\Adminhtml\Cms\Page\Widget\Chooser as ChooserBlock;
use Magento\Backend\App\Action;
use Magento\Backend\Block\Widget\Grid\Serializer;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Chooser extends Action
{
    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $uniqId = $this->getRequest()->getParam('uniq_id');

        $resultRaw = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $layout = $this->_view->getLayout();

        $chooser = $layout->createBlock(ChooserBlock::class, '', [
                'data' => [
                    'id' => $uniqId
                ]
            ]
        );

        /* @var $serializer Serializer */
        $serializer = $layout->createBlock(
            Serializer::class,
            '',
            [
                'data' => [
                    'grid_block' => $chooser,
                    'callback' => 'getSelectedPages',
                    'input_element_name' => 'selected_pages',
                    'reload_param_name' => 'selected_pages',
                ]
            ]
        );


        return $resultRaw->setContents($chooser->toHtml() . $serializer->toHtml());
    }
}