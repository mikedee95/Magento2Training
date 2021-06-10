<?php
namespace Dtn\Office\Controller\Adminhtml;

use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;

abstract class Employee extends Action
{
    protected $forwardFactory;
    protected $layoutFactory;
    protected $pageFactory;

    public function __construct(Action\Context $context, ForwardFactory $forwardFactory, LayoutFactory $layoutFactory, PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
        $this->forwardFactory = $forwardFactory;
        $this->layoutFactory = $layoutFactory;

        parent::__construct($context);
    }

    protected function _initAction()
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('Dtn_Office:employee');
        $resultPage->addBreadcrumb(__('Office'),__('Office'));
        $resultPage->addBreadcrumb(__('Employee'),__('Employee'));

        return $resultPage;
    }
}
