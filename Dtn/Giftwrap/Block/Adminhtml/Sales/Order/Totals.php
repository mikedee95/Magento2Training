<?php

namespace Dtn\Giftwrap\Block\Adminhtml\Sales\Order;

class Totals extends \Magento\Framework\View\Element\Template
{

    /**
     * Retrieve current order model instance
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        return $this->getParentBlock()->getOrder();
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }

    /**
     * Total fee initialization
     * @return $this
     */
    public function initTotals()
    {
        $this->getParentBlock();
        $this->_order = $this->getOrder();
        $this->getSource();
        $title = __("Gift Wrap");
        if (!$this->_order->getGiftwrapAmount()) {
            return $this;
        }

        $total = new \Magento\Framework\DataObject(
            [
                'code'  => 'giftwrap_amount',
                'value' => $this->getSource()->getGiftwrapAmount(),
                'label' => __($title),
            ]
        );
        $this->getParentBlock()->addTotalBefore($total, 'grand_total');

        return $this;
    }
}
