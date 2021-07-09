<?php

/**
 * Giftwrap Resource Collection
 */
namespace Dtn\Giftwrap\Model\ResourceModel\Giftwrap;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dtn\Giftwrap\Model\Giftwrap', 'Dtn\Giftwrap\Model\ResourceModel\Giftwrap');
    }
}
