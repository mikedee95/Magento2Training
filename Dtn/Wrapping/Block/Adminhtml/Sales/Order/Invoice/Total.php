<?php

namespace Dtn\Wrapping\Block\Adminhtml\Sales\Order\Invoice;

class Total extends \Magento\Framework\View\Element\Template
{
    /**
     * Get data (totals) source model
     *
     * @return \Magento\Framework\DataObject
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }

    /**
     * @return mixed
     */
    public function getInvoice()
    {
        return $this->getParentBlock()->getInvoice();
    }
    /**
     * Initialize payment giftwrap totals
     *
     * @return $this
     */
    public function initTotals()
    {
        $this->getParentBlock();
        $this->getInvoice();
        $this->getSource();
        $title = __('Gift Wrap Cost');

        if (!$this->getInvoice()->getOrder()->getGiftWrapAmount()) {
            return $this;
        }
        $total = new \Magento\Framework\DataObject(
            [
                'code'  => 'giftwrap_amount',
                'value' => $this->getInvoice()->getOrder()->getGiftWrapAmount(),
                'label' => __($title),
            ]
        );

        $this->getParentBlock()->addTotalBefore($total, 'grand_total');
        return $this;
    }
}