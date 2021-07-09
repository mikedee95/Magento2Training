<?php
namespace Dtn\Knockout\Model;
use Magento\Framework\Model\AbstractModel;

class Employee extends AbstractModel{
    protected function _construct()
    {
        $this->_init(\Dtn\Knockout\Model\ResourceModel\Employee::class);
    }
}
