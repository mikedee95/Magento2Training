<?php

namespace Dtn\Wrapping\Block\Adminhtml\GiftWrap;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Dtn\Wrapping\Model\ResourceModel\Giftwrap\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Dtn\Wrapping\Model\GiftWrap
     */
    protected $_giftwrap;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Dtn\Wrapping\Model\GiftWrap $giftWrapPage
     * @param \Dtn\Wrapping\Model\ResourceModel\Giftwrap\CollectionFactory $collectionFactory
     * @param \Magento\Core\Model\PageLayout\Config\Builder $pageLayoutBuilder
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Dtn\Wrapping\Model\Adminhtml\Config\Source\Storeview $storeList,
        \Dtn\Wrapping\Model\GiftWrap $giftWrap,
        \Dtn\Wrapping\Model\ResourceModel\GiftWrap\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->_storeList = $storeList;
        $this->_giftwrap = $giftwrap;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('giftWrapGrid');
        $this->setDefaultSort('giftwrap_id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare collection
     *
     * @return \Magento\Backend\Block\Widget\Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create();
        /* @var $collection \Dtn\Wrapping\Model\ResourceModel\GiftWrap\Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare columns
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn('giftwrap_id', [
            'header'    => __('ID'),
            'index'     => 'giftwrap_id',
        ]);
        
        $this->addColumn('title', [
            'header' => __('Title'), 
            'index' => 'title',
            
        ]);

        $this->addColumn(
            'store',
            [
                'header' => __('Store View'),
                'sortable' => true,
                'index' => 'store',
                'type' => 'options',
                'options' => $this->_storeList->toOptionArray()
            ]
        );

        $this->addColumn(
            'image',
            array(
                'header' => __('Image'),
                'index' => 'image',
                'filter' => false,
                'sortable' => false,
                'renderer'  => '\Dtn\Wrapping\Block\Adminhtml\GiftWrap\Grid\Renderer\Image',
            )
        );

        $this->addColumn(
            'price', [
            'header' => __('Additional Price'), 
            'index' => 'price',
            'renderer'  => '\Dtn\Wrapping\Block\Adminhtml\GiftWrap\Grid\Renderer\Price',
        ]);

        $this->addColumn(
            'is_active',
            array(
                'header' => __('Status'),
                'index' => 'is_active',
                'type' => 'options',
                'options' => [
                    0 => __('Disabled'),
                    1 => __('Enabled')
                ]
            )
        );
        
        $this->addColumn(
            'created_at',
            [
                'header' => __('Created'),
                'index' => 'created_at',
                'type' => 'datetime',
                'header_css_class' => 'col-date',
                'column_css_class' => 'col-date'
            ]
        );
        
        $this->addColumn(
            'action',
            [
                'header' => __('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => [
                            'base' => '*/*/edit',
                            'params' => ['store' => $this->getRequest()->getParam('store')]
                        ],
                        'field' => 'giftwrap_id'
                    ]
                ],
                'sortable' => false,
                'filter' => false,
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Row click url
     *
     * @param \Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['giftwrap_id' => $row->getId()]);
    }

    /**
     * Get grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
}
