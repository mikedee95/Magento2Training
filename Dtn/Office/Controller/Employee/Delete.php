<?php

namespace Dtn\Office\Controller\Employee;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Dtn\Office\Model\EmployeeFactory;

class Delete extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory $pageFactory
     */
    protected $pageFactory;

    /**
     * @var \Dtn\Office\Model\EmployeeFactory $employeeFactory
     */
    protected $employeeFactory;

    /**
     * Delete constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param EmployeeFactory $employeeFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        EmployeeFactory $employeeFactory
    )
    {
        $this->employeeFactory = $employeeFactory;
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        $employeeId = $this->getRequest()->getParam('entity_id');

        if ($employeeId) {
            $employee = $this->employeeFactory->create()->load($employeeId);
            try {
                $employee->delete();
                $this->messageManager->addSuccessMessage('Employee was successfully deleted');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $this->_redirect('dtn_office/employee/index');
    }
}
