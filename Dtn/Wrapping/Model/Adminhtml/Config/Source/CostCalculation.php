<?php

namespace Dtn\Wrapping\Model\Adminhtml\Config\Source;

class CostCalculation implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [0 => 'Per Gift Wrap', 1 => 'Per Order'];
    }
}