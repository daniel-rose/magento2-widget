<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 07.04.16
 * Time: 11:30
 */

namespace DR\Widget\Model\Widget;


class Instance extends \Magento\Widget\Model\Widget\Instance
{
    /**
     * @var array
     */
    protected $additionalLayoutHandles;

    /**
     * @var array
     */
    protected $additionalSpecificEntitiesLayoutHandles;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Escaper $escaper
     * @param \Magento\Framework\View\FileSystem $viewFileSystem
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Catalog\Model\Product\Type $productType
     * @param \Magento\Widget\Model\Config\Reader $reader
     * @param \Magento\Widget\Model\Widget $widgetModel
     * @param \Magento\Widget\Model\NamespaceResolver $namespaceResolver
     * @param \Magento\Framework\Math\Random $mathRandom
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Widget\Helper\Conditions $conditionsHelper
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $layoutHandles
     * @param array $specificEntitiesLayoutHandles
     * @param array $relatedCacheTypes
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Escaper $escaper,
        \Magento\Framework\View\FileSystem $viewFileSystem,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Catalog\Model\Product\Type $productType,
        \Magento\Widget\Model\Config\Reader $reader,
        \Magento\Widget\Model\Widget $widgetModel,
        \Magento\Widget\Model\NamespaceResolver $namespaceResolver,
        \Magento\Framework\Math\Random $mathRandom,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Widget\Helper\Conditions $conditionsHelper,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $layoutHandles = [],
        array $specificEntitiesLayoutHandles = [],
        array $relatedCacheTypes = [],
        array $data = []
    ) {
        $this->additionalLayoutHandles = $layoutHandles;
        $this->additionalSpecificEntitiesLayoutHandles = $specificEntitiesLayoutHandles;

        parent::__construct(
            $context,
            $registry,
            $escaper,
            $viewFileSystem,
            $cacheTypeList,
            $productType,
            $reader,
            $widgetModel,
            $namespaceResolver,
            $mathRandom,
            $filesystem,
            $conditionsHelper,
            $resource,
            $resourceCollection,
            $relatedCacheTypes,
            $data
        );
    }

    /**
     * Internal Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_layoutHandles = array_merge($this->_layoutHandles, $this->additionalLayoutHandles);
        $this->_specificEntitiesLayoutHandles = array_merge($this->_specificEntitiesLayoutHandles, $this->additionalSpecificEntitiesLayoutHandles);
    }
}