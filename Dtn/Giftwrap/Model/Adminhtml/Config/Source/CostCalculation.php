<?php

namespace Dtn\Giftwrap\Model\Adminhtml\Config\Source;

class CostCalculation implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return string[]
     */
	public function toOptionArray()
    {
    	return [0 => 'Per Gift Wrap', 1 => 'Per Order'];
    }
}
