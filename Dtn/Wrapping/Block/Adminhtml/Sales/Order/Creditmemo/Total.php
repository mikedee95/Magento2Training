<?php

namespace Dtn\Wrapping\Block\Adminhtml\Sales\Order\Creditmemo;

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

    public function getCreditmemo()
    {
        return $this->getParentBlock()->getCreditmemo();
    }
    /**
     * Initialize payment fee totals
     *
     * @return $this
     */
    public function initTotals()
    {
        $this->getParentBlock();
        $this->getCreditmemo();
        $this->getSource();
        $title = __('Gift Wrap Cost');
        if (!$this->getCreditmemo()->getOrder()->getGiftWrapAmount()) {
            return $this;
        }
        $fee = new \Magento\Framework\DataObject(
            [
                'code'   => 'giftwrap amount',
                'strong' => false,
                'value'  => $this->getCreditmemo()->getOrder()->getGiftWrapAmount(),
                'label'  => __($title),
            ]
        );

        $this->getParentBlock()->addTotalBefore($fee, 'grand_total');

        return $this;
    }

}