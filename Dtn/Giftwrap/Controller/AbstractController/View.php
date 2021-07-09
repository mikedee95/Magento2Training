<?php

namespace Dtn\Giftwrap\Controller\AbstractController;

use Magento\Framework\App\Action;
use Magento\Framework\View\Result\PageFactory;
use phpDocumentor\Reflection\Types\This;

abstract class View extends Action\Action
{
    /**
     * @var \Dtn\Giftwrap\Controller\AbstractController\GiftwrapLoaderInterface
     */
    protected $giftwrapLoader;

	/**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param OrderLoaderInterface $orderLoader
	 * @param PageFactory $resultPageFactory
     */
    public function __construct(Action\Context $context, GiftwrapLoaderInterface $giftwrapLoader, PageFactory $resultPageFactory)
    {
        $this->giftwrapLoader = $giftwrapLoader;
		$this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Giftwrap view page
     *
     * @return void
     */
    public function execute()
    {
        if (!$this->giftwrapLoader->load($this->_request, $this->_response)) {
            return;
        }

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
		return $resultPage;
    }

}
