<?php

namespace Dtn\Wrapping\Model;

/**
 * Giftwrap Model
 *
 * @method \Dtn\Wrapping\Model\ResourceModel\Page _getResource()
 * @method \Dtn\Wrapping\Model\ResourceModel\Page getResource()
 */
class GiftWrap extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dtn\Wrapping\Model\ResourceModel\GiftWrap');
    }

}
