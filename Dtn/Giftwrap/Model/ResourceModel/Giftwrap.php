<?php

namespace Dtn\Giftwrap\Model\ResourceModel;

/**
 * Giftwrap Resource Model
 */
class Giftwrap extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('dtn_wrapping', 'giftwrap_id');
    }
}
