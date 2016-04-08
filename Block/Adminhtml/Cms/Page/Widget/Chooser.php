<?php

namespace DR\Widget\Block\Adminhtml\Cms\Page\Widget;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Widget\Block\Adminhtml\Widget\Chooser as BaseChooser;

class Chooser extends Extended
{
    /**
     * @var array
     */
    protected $selectedPages = [];

    /**
     * @var PageRepositoryInterface
     */
    protected $pageRepository;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Chooser constructor.
     * @param Context $context
     * @param Data $backendHelper
     * @param PageRepositoryInterface $pageRepository
     * @param CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        PageRepositoryInterface $pageRepository,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->pageRepository = $pageRepository;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Block construction, prepare grid params
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setDefaultSort('name');
        $this->setUseAjax(true);
    }

    /**
     * Prepare chooser element HTML
     *
     * @param AbstractElement $element Form Element
     * @return AbstractElement
     */
    public function prepareElementHtml(AbstractElement $element)
    {
        $uniqId = $this->mathRandom->getUniqueHash($element->getId());

        $sourceUrl = $this->getUrl(
            'dr_widget/cms_page_widget/chooser',
            ['uniq_id' => $uniqId]
        );

        $chooser = $this->getLayout()->createBlock(
            BaseChooser::class
        )->setElement(
            $element
        )->setConfig(
            $this->getConfig()
        )->setFieldsetId(
            $this->getFieldsetId()
        )->setSourceUrl(
            $sourceUrl
        )->setUniqId(
            $uniqId
        );

        if ($element->getValue()) {
            try {
                $pageId = (int)$element->getValue();
                $page = $this->pageRepository->getById($pageId);

                $chooser->setLabel($this->escapeHtml($page->getTitle()));
            } catch (\Exception $e) {}
        }

        $element->setData('after_element_html', $chooser->toHtml());

        return $element;
    }

    /**
     * Checkbox Check JS Callback
     *
     * @return string
     */
    public function getCheckboxCheckCallback()
    {
        return "function (grid, element) {
            $(grid.containerId).fire('entity:changed', {element: element});
        }";
    }

    /**
     * Filter checked/unchecked rows in grid
     *
     * @param Column $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_pages') {
            $selected = $this->getSelectedPages();
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('page_id', ['in' => $selected]);
            } else {
                $this->getCollection()->addFieldToFilter('page_id', ['nin' => $selected]);
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

    /**
     * Prepare pages collection
     *
     * @return Extended
     */
    protected function _prepareCollection()
    {
        $collection = $this->collectionFactory->create();

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare columns for pages grid
     *
     * @return Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_pages',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'in_pages',
                'inline_css' => 'checkbox entities',
                'field_name' => 'in_pages',
                'values' => $this->getSelectedPages(),
                'align' => 'center',
                'index' => 'page_id',
                'use_index' => true
            ]
        );

        $this->addColumn(
            'page_id',
            [
                'header' => __('ID'),
                'sortable' => true,
                'index' => 'page_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'chooser_identifier',
            [
                'header' => __('Identifier'),
                'name' => 'chooser_identifier',
                'index' => 'identifier',
                'header_css_class' => 'col-identifier',
                'column_css_class' => 'col-identifier'
            ]
        );

        $this->addColumn(
            'chooser_title',
            [
                'header' => __('Title'),
                'name' => 'chooser_title',
                'index' => 'title',
                'header_css_class' => 'col-title',
                'column_css_class' => 'col-title'
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Adds additional parameter to URL for loading only pages grid
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl(
            'dr_widget/cms_page_widget/chooser',
            [
                '_current' => true,
                'uniq_id' => $this->getId()
            ]
        );
    }

    /**
     * Setter
     *
     * @param array $selectedPages
     * @return $this
     */
    public function setSelectedPages($selectedPages)
    {
        $this->selectedPages = $selectedPages;
        return $this;
    }

    /**
     * Getter
     *
     * @return array
     */
    public function getSelectedPages()
    {
        if ($selectedPages = $this->getRequest()->getParam('selected_pages', null)) {
            $this->setSelectedPages($selectedPages);
        }
        return $this->selectedPages;
    }
}
