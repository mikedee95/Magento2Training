<?php

namespace Dtn\Office\Controller\Employee;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Add extends Action
{
    protected $pageFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory
    )
    {
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->pageFactory->create();
        return $this->_redirect('dtn_office/employee/edit');
    }
}
