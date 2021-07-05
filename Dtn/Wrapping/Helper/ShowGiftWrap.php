<?php

namespace Dtn\Wrapping\Helper;
use Magento\Store\Model\StoreManagerInterface;
/**
 * Giftwrap content block
 */
class ShowGiftWrap extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Giftwrap collection
     *
     * @var Dtn\Wrapping\Model\ResourceModel\GiftWrap\Collection
     */
    protected $_giftWrapCollection = null;

    /**
     * Giftwrap factory
     *
     * @var \Dtn\Wrapping\Model\GiftWrapFactory
     */
    protected $_giftWrapCollectionFactory;

    /** @var \Dtn\Wrapping\Helper\Data */
    protected $_dataHelper;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Dtn\Wrapping\Model\ResourceModel\GiftWrap\CollectionFactory $giftWrapCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Dtn\Wrapping\Model\ResourceModel\GiftWrap\CollectionFactory $giftWrapCollectionFactory,
        \Magento\Sales\Model\Order $orderModel,
        StoreManagerInterface $storemanager,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Pricing\Helper\Data $pricingHelper,
        \Dtn\Wrapping\Model\GiftWrapFactory $giftWrapModel,
        \Dtn\Wrapping\Helper\Data $dataHelper
    ) {
        $this->_giftWrapCollectionFactory = $giftWrapCollectionFactory;
        $this->_dataHelper = $dataHelper;
        $this->_orderModel = $orderModel;
        $this->_request = $context->getRequest();
        $this->_storeManager = $storemanager;
        $this->_coreRegistry = $registry;
        $this->_giftWrapModel = $giftWrapModel;
        $this->productFactory = $productFactory;
        $this->_pricingHelper = $pricingHelper;
        parent::__construct(
            $context
        );
    }

    public function getOrderDetails($orderId)
    {
        return $this->_orderModel->load($orderId)->getData();
    }

    public function getOrder($orderId)
    {
        return $this->_orderModel->load($orderId);
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
}
