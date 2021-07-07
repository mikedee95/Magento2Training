<?php

namespace Excellence\Giftwrap\Model\ResourceModel\Giftwrapquote;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dtn\Giftwrap\Model\Giftwrapquote', 'Dtn\Giftwrap\Model\ResourceModel\Giftwrapquote');
    }
}
