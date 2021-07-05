<?php

namespace Dtn\Wrapping\Model;

class GiftWrapQuote extends \Magento\Framework\Model\AbstractModel
{
	const CACHE_TAG = 'dtn_giftwrapquote';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dtn\Wrapping\Model\ResourceModel\GiftWrapQuote');
    }
    
   
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
