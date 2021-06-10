<?php

namespace Dtn\Checkout\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class SaveToOrder
 * @package Son\Checkout\Observer
 */
class SaveToOrder implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return $this|void
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();
        $order->setData('special_request', $quote->getSpecialRequest());
        return $this;
    }
}