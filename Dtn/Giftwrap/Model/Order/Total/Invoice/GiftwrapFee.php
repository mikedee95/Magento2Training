<?php

namespace Dtn\Giftwrap\Model\Order\Total\Invoice;

use Magento\Sales\Model\Order\Invoice\Total\AbstractTotal;

class GiftwrapFee extends AbstractTotal
{

    /**
     * @param \Magento\Sales\Model\Order\Invoice $invoice
     * @return $this|GiftwrapFee
     */
    public function collect(\Magento\Sales\Model\Order\Invoice $invoice)
    {

        $amount = $invoice->getOrder()->getGiftwrapAmount();
        $invoice->setGiftwrapAmount($amount);
        $amount = $invoice->getOrder()->getBaseGiftwrapAmount();
        $invoice->setBaseGiftwrapAmount($amount);
        $invoice->setGrandTotal($invoice->getGrandTotal() + $invoice->getGiftwrapAmount());
        $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $invoice->getBaseGiftwrapAmount());

        return $this;
    }

}
