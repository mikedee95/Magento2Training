<?php

namespace Dtn\Wrapping\Model\ResourceModel;


class GiftWrapQuote extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('dtn_giftwrapquote', 'giftwrap_id');
    }
}
