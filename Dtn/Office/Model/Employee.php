<?php

namespace Dtn\Office\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Model\ResourceModel\AbstractResource;

class Employee extends AbstractModel
{
    const ENTITY = 'dtn_office_employee';

    protected $departmentFactory;

    public function __construct(DepartmentFactory $departmentFactory, Context $context, Registry $registry, AbstractResource $resource = null, AbstractDb $resourceCollection = null, array $data = [])
    {
        $this->departmentFactory = $departmentFactory;
        parent::__construct( $context, $registry, $resource, $resourceCollection,$data);
    }

    public function _construct()
    {
        $this->_init('Dtn\Office\Model\ResourceModel\Employee');
    }

    public function getDepartment()
    {
        $department = $this->departmentFactory->create();
        $department->load($this->getDepartmentId());
        return $department;
    }

}
