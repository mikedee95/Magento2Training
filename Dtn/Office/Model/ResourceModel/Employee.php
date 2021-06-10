<?php
namespace Dtn\Office\Model\ResourceModel;
use Magento\Eav\Model\Entity\AbstractEntity;

class Employee extends AbstractEntity{
    protected function _construct()
    {
        $this->_read = 'dtn_office_employee_read';
        $this->_write = 'dtn_office_employee_write';
    }

    public function getEntityType()
    {
        if(empty($this->_type)){
            $this->setType(\Dtn\Office\Model\Employee::ENTITY);
        }
        return parent::getEntityType();
    }
}
