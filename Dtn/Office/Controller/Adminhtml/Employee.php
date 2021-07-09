<?php
namespace Dtn\Office\Controller\Adminhtml;

use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;

abstract class Employee extends Action
{
    /**
     * @var ForwardFactory
     */
    protected $forwardFactory;

    /**
     * @var LayoutFactory
     */
    protected $layoutFactory;

    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * Employee constructor.
     * @param Action\Context $context
     * @param ForwardFactory $forwardFactory
     * @param LayoutFactory $layoutFactory
     * @param PageFactory $pageFactory
     */
    public function __construct(Action\Context $context, ForwardFactory $forwardFactory, LayoutFactory $layoutFactory, PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
        $this->forwardFactory = $forwardFactory;
        $this->layoutFactory = $layoutFactory;

        parent::__construct($context);
    }

    /**
     * Initialize action for employee table
     * @return \Magento\Framework\View\Result\Page
     */
    protected function _initAction()
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('Dtn_Office:employee');
        $resultPage->addBreadcrumb(__('Office'),__('Office'));
        $resultPage->addBreadcrumb(__('Employee'),__('Employee'));

        return $resultPage;
    }
}
