<?php

/**
 * Giftwrap Resource Collection
 */
namespace Dtn\Wrapping\Model\ResourceModel\Giftwrap;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dtn\Wrapping\Model\GiftWrap', 'Dtn\Wrapping\Model\ResourceModel\GiftWrap');
    }
}
