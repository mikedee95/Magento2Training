<?php

namespace Dtn\Wrapping\Model\Order\Total\Invoice;

use Magento\Sales\Model\Order\Invoice\Total\AbstractTotal;

class GiftWrapFee extends AbstractTotal
{

    public function collect(\Magento\Sales\Model\Order\Invoice $invoice)
    {

        $amount = $invoice->getOrder()->getGiftWrapAmount();
        $invoice->setGiftWrapAmount($amount);
        $amount = $invoice->getOrder()->getBaseGiftWrapAmount();
        $invoice->setBaseGiftWrapAmount($amount);
        $invoice->setGrandTotal($invoice->getGrandTotal() + $invoice->getGiftWrapAmount());
        $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $invoice->getBaseGiftWrapAmount());

        return $this;
    }

}
