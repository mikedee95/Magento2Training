<?php
namespace Dtn\Office\Controller\Index;

use Dtn\Office\Model\EmployeeFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;

class Edit extends Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var EmployeeFactory
     */
    protected $employeeFactory;

    /**
     * Edit constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param EmployeeFactory $employeeFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        EmployeeFactory $employeeFactory
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->employeeFactory = $employeeFactory;
    }

    /**
     * Index Action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->pageFactory->create();
        return $resultPage;
    }
}
