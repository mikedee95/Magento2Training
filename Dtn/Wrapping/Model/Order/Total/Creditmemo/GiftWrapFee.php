<?php

namespace Dtn\Wrapping\Model\Order\Total\Creditmemo;

use Magento\Sales\Model\Order\Creditmemo\Total\AbstractTotal;

class GiftWrapFee extends AbstractTotal
{
    /**
     * @param \Magento\Sales\Model\Order\Creditmemo $creditmemo
     * @return $this
     */
    public function collect(\Magento\Sales\Model\Order\Creditmemo $creditmemo)
    {
        $order = $creditmemo->getOrder();
        if ($order->getGiftWrapAmount() > 0) {

            $feeAmount     = $order->getGiftWrapAmount();
            $basefeeAmount = $order->getBaseGiftWrapAmount();
            $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $feeAmount);
            $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $basefeeAmount);
            $creditmemo->setGiftWrapAmount($feeAmount);
            $creditmemo->setBaseGiftWrapAmount($basefeeAmount);
        }
        return $this;
    }
}
