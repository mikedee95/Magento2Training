<?php

namespace Dtn\Wrapping\Model\ResourceModel\GiftWrapQuote;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dtn\Wrapping\Model\GiftWrapQuote', 'Dtn\Wrapping\Model\ResourceModel\GiftWrapQuote');
    }
}
