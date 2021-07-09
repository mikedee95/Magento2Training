<?php

namespace Dtn\Office\Controller\Employee;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Dtn\Office\Model\EmployeeFactory;

class Update extends Action
{
    /**
     * @var \Dtn\Office\Model\EmployeeFactory $employeeFactory
     */
    protected $employeeFactory;

    /**
     * update constructor.
     * @param EmployeeFactory $employeeFactory
     * @param Context $context
     */
    public function __construct(
        EmployeeFactory $employeeFactory,
        Context $context
    )
    {
        $this->employeeFactory = $employeeFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        $employeeData = $this->getRequest()->getParams();
        $employee = $this->employeeFactory->create();

        if ($employee->getId()) {
            $employeeId = $employeeData['entity_id'];
            $employee->load($employeeId);
        }

        $employee->setData($employeeData);

        if ($employee->save()) {
            $this->messageManager->addSuccessMessage('Employee was successfully saved');
        } else {
            $this->messageManager->addErrorMessage('Failed, please try again.');
        }

        return $this->_redirect('dtn_office/employee/index');
    }
}

