<?php

namespace Dtn\Giftwrap\Block;
/**
 * Giftwrap content block
 */
class Giftwrap extends \Magento\Framework\View\Element\Template
{
    /**
     * Giftwrap collection
     *
     * @var Dtn\Giftwrap\Model\ResourceModel\Giftwrap\Collection
     */
    protected $_giftwrapCollection = null;

    /**
     * Giftwrap factory
     *
     * @var \Dtn\Giftwrap\Model\GiftwrapFactory
     */
    protected $_giftwrapCollectionFactory;

    /** @var \Dtn\Giftwrap\Helper\Data */
    protected $_dataHelper;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Dtn\Giftwrap\Model\ResourceModel\Giftwrap\CollectionFactory $giftwrapCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Dtn\Giftwrap\Model\ResourceModel\Giftwrap\CollectionFactory $giftwrapCollectionFactory,
        \Magento\Sales\Model\Order $orderModel,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Pricing\Helper\Data $pricingHelper,
        \Dtn\Giftwrap\Model\GiftwrapFactory $giftWrapModel,
        \Dtn\Giftwrap\Helper\Data $dataHelper,
        array $data = []
    ) {
        $this->_giftwrapCollectionFactory = $giftwrapCollectionFactory;
        $this->_dataHelper = $dataHelper;
        $this->_orderModel = $orderModel;
        $this->_request = $context->getRequest();
        $this->_storeManager = $context->getStoreManager();
        $this->_coreRegistry = $registry;
        $this->_giftWrapModel = $giftWrapModel;
        $this->productFactory = $productFactory;
        $this->_pricingHelper = $pricingHelper;
        parent::__construct(
            $context,
            $data
        );
    }

    public function getOrderDetails($orderId)
    {
        return $this->_orderModel->load($orderId)->getData();
    }

    public function getOrderId()
    {
        if(!empty($this->_request->getParam('order_id'))){
            return $this->_request->getParam('order_id');
        } else {
            return $this->_coreRegistry->registry('current_order')->getId();
        }
    }

    public function getProductBySku($sku)
    {
        $product = $this->productFactory->create();
        return $product->load($product->getIdBySku($sku));
    }
    public function getPageTitle()
    {
        return __('Giftwrap for Order #').str_pad($this->getOrderId(), 9, '0', STR_PAD_LEFT);
    }

    public function getGiftWrapData($giftwrap_id)
    {
        return $this->_giftWrapModel->create()->load($giftwrap_id)->getData();
    }

    public function getGiftBoxImageUrl($imagePath)
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).$imagePath;
    }

    public function getFomattedPrice($price)
    {
        return $this->_pricingHelper->currency($price, true, false);
    }
    /**
     * Retrieve giftwrap collection
     *
     * @return Dtn\Giftwrap\Model\ResourceModel\Giftwrap\Collection
     */
    protected function _getCollection()
    {
        $collection = $this->_giftwrapCollectionFactory->create();
        return $collection;
    }

    /**
     * Retrieve prepared giftwrap collection
     *
     * @return Dtn\Giftwrap\Model\ResourceModel\Giftwrap\Collection
     */
    public function getCollection()
    {
        if (is_null($this->_giftwrapCollection)) {
            $this->_giftwrapCollection = $this->_getCollection();
            $this->_giftwrapCollection->setCurPage($this->getCurrentPage());
            $this->_giftwrapCollection->setPageSize($this->_dataHelper->getGiftwrapPerPage());
            $this->_giftwrapCollection->setOrder('published_at','asc');
        }

        return $this->_giftwrapCollection;
    }

    /**
     * Fetch the current page for the giftwrap list
     *
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->getData('current_page') ? $this->getData('current_page') : 1;
    }

    /**
     * Return URL to item's view page
     *
     * @param Dtn\Giftwrap\Model\Giftwrap $giftwrapItem
     * @return string
     */
    public function getItemUrl($giftwrapItem)
    {
        return $this->getUrl('*/*/view', array('id' => $giftwrapItem->getId()));
    }

    /**
     * Return URL for resized Giftwrap Item image
     *
     * @param Dtn\Giftwrap\Model\Giftwrap $item
     * @param integer $width
     * @return string|false
     */
    public function getImageUrl($item, $width)
    {
        return $this->_dataHelper->resize($item, $width);
    }

    /**
     * Get a pager
     *
     * @return string|null
     */
    public function getPager()
    {
        $pager = $this->getChildBlock('giftwrap_list_pager');
        if ($pager instanceof \Magento\Framework\Object) {
            $giftwrapPerPage = $this->_dataHelper->getGiftwrapPerPage();

            $pager->setAvailableLimit([$giftwrapPerPage => $giftwrapPerPage]);
            $pager->setTotalNum($this->getCollection()->getSize());
            $pager->setCollection($this->getCollection());
            $pager->setShowPerPage(TRUE);
            $pager->setFrameLength(
                $this->_scopeConfig->getValue(
                    'design/pagination/pagination_frame',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                )
            )->setJump(
                $this->_scopeConfig->getValue(
                    'design/pagination/pagination_frame_skip',
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                )
            );

            return $pager->toHtml();
        }

        return NULL;
    }
}
