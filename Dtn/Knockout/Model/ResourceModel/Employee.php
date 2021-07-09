<?php
namespace Dtn\Knockout\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Employee extends AbstractDb{
    protected function _construct()
    {
        $this->_init('dtn_knockout_employee','employee_id');
    }
}
