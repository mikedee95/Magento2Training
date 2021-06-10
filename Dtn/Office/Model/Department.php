<?php
namespace Dtn\Office\Model;

class Department extends \Magento\Framework\Model\AbstractModel{
    protected function _construct()
    {
        $this->_init('Dtn\Office\Model\ResourceModel\Department');
    }
}
