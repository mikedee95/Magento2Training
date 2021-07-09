<?php

namespace Dtn\Giftwrap\Model\ResourceModel;


class Giftwrapquote extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('dtn_wrapping_quote','giftwrap_id');
    }
}
