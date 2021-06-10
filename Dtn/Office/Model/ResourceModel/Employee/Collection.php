<?php
namespace Dtn\Office\Model\ResourceModel\Employee;

use Magento\Eav\Model\Entity\Collection\AbstractCollection;

class Collection extends AbstractCollection{
    protected function _construct()
    {
        $this->_init('Dtn\Office\Model\Employee','Dtn\Office\Model\ResourceModel\Employee');
    }
}
