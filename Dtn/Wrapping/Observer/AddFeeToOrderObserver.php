<?php

namespace Dtn\Wrapping\Observer;

use \Magento\Framework\Event\Observer;

class AddFeeToOrderObserver implements \Magento\Framework\Event\ObserverInterface
{
     /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * AddFeeToOrderObserver constructor.
     * @param \Magento\Checkout\Model\Session $checkoutSession
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        $this->_checkoutSession = $checkoutSession;
    }

    /**
     * Set payment fee to order
     *
     * @param EventObserver $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quote = $observer->getQuote();

        $giftwrapAmount     = $quote->getGiftwrapAmount();
        $baseGiftwrapAmount = $quote->getBaseGiftwrapAmount();
        $giftwrapInfo       = $quote->getGiftWrapInfo();
      
        if (!$giftwrapAmount || !$baseGiftwrapAmount) {
            return $this;
        }
        //Set giftwrap price  to order
        $order = $observer->getOrder();
        $order->setData('giftwrap_amount', $giftwrapAmount);
        $order->setData('base_giftwrap_amount', $baseGiftwrapAmount);
        $order->setData('gift_wrap_info', $giftwrapInfo);
         return $this;
    }
}