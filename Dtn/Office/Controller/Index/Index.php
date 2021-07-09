<?php

namespace Son\Office\Controller\Index;

use Magento\Framework\App\Action\Context;
use Dtn\Office\Model\DepartmentFactory;
use Dtn\Office\Model\EmployeeFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var DepartmentFactory
     */
    protected $departmentFactory;

    /**
     * @var EmployeeFactory
     */
    protected $employeeFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param DepartmentFactory $departmentFactory
     * @param EmployeeFactory $employeeFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        DepartmentFactory $departmentFactory,
        EmployeeFactory $employeeFactory
    )
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->departmentFactory = $departmentFactory;
        $this->employeeFactory = $employeeFactory;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->pageFactory->create();
        return $resultPage;
    }
}
