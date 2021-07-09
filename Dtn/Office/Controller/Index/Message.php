<?php

namespace  Dtn\Office\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Message extends Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * Message constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     */
    public function __construct(Context $context, PageFactory $pageFactory)
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->pageFactory->create();

        $this->messageManager->addSuccessMessage('Success-1');
        $this->messageManager->addSuccessMessage('Success-2');
        $this->messageManager->addNoticeMessage('Notice-1');
        $this->messageManager->addNoticeMessage('Notice-2');
        $this->messageManager->addWarningMessage('Warning-1');
        $this->messageManager->addWarningMessage('Warning-2');
        $this->messageManager->addErrorMessage('Error-1');
        $this->messageManager->addErrorMessage('Error-2');

        return $resultPage;
    }
}
