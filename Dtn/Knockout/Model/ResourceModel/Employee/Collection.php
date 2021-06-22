<?php
namespace Dtn\Knockout\Model\ResourceModel\Employee;

use Dtn\Knockout\Model\ResourceModel\Employee;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection{
    public function _construct()
    {
        $this->_init(\Dtn\Knockout\Model\Employee::class,
                    \Dtn\Knockout\Model\ResourceModel\Employee::class);
        }
}
