<?php

namespace Dtn\Giftwrap\Model\Order\Total\Creditmemo;

use Magento\Sales\Model\Order\Creditmemo\Total\AbstractTotal;

class GiftwrapFee extends AbstractTotal
{
    /**
     * @param \Magento\Sales\Model\Order\Creditmemo $creditmemo
     * @return $this
     */
    public function collect(\Magento\Sales\Model\Order\Creditmemo $creditmemo)
    {
        $order = $creditmemo->getOrder();
        if ($order->getGiftwrapAmount() > 0) {

            $feeAmount     = $order->getGiftwrapAmount();
            $basefeeAmount = $order->getBaseGiftwrapAmount();
            $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $feeAmount);
            $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $basefeeAmount);
            $creditmemo->setGiftwrapAmount($feeAmount);
            $creditmemo->setBaseGiftwrapAmount($basefeeAmount);
        }
        return $this;
    }
}
