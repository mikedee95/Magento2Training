<?php

namespace Dtn\Wrapping\Controller\Index;

class Index extends \Magento\Framework\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
	
	/**
     * @param \Magento\Framework\App\Action\Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
	
    /**
     * Default Giftwrap Index page
     *
     * @return void
     */
    public function execute()
    { 
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Giftwrap for Order #').str_pad($this->getRequest()->getParam('order_id'), 9, '0', STR_PAD_LEFT));
        return $resultPage;
    }
}