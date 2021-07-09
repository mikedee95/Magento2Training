<?php

namespace Dtn\Giftwrap\Model;

/**
 * Giftwrap Model
 *
 * @method \Dtn\Giftwrap\Model\ResourceModel\Page _getResource()
 * @method \Dtn\Giftwrap\Model\ResourceModel\Page getResource()
 */
class Giftwrap extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dtn\Giftwrap\Model\ResourceModel\Giftwrap');
    }

}
