<?php
namespace Dtn\Office\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\View\Result\PageFactory;

abstract class Department extends Action
{
    protected $forwardFactory;
    protected $layoutFactory;
    protected $pageFactory;

    public function __construct(Action\Context $context, LayoutFactory $layoutFactory, ForwardFactory $forwardFactory, PageFactory $pageFactory)
    {
        $this->layoutFactory = $layoutFactory;
        $this->forwardFactory = $forwardFactory;
        $this->pageFactory = $pageFactory;

        parent::__construct($context);
    }


    protected function _initAction()
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('Dtn_Office:department');
        $resultPage->addBreadcrumb(__('Office'),__('Office'));
        $resultPage->addBreadcrumb(__('Department'),__('Department'));
        return $resultPage;
    }
}
