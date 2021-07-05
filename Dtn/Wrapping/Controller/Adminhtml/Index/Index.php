<?php

namespace Dtn\Wrapping\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Check the permission to run it
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dtn_Wrapping::giftwrap_manage');
    }

    /**
     * Giftwrap List action
     *
     * @return void
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Dtn_Wrapping::giftwrap_manage'
        )->addBreadcrumb(
            __('Gift Wrap'),
            __('Gift Wrap')
        )->addBreadcrumb(
            __('Manage Gift Wrap'),
            __('Manage Gift Wrap')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Gift Wrap'));
        return $resultPage;
    }
}
