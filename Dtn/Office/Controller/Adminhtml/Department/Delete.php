<?php

namespace Dtn\Office\Controller\Adminhtml\Department;

use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;
use Dtn\Office\Controller\Adminhtml\Department;
use Dtn\Office\Model\DepartmentFactory;

/**
 * Class Delete
 * @package Dtn\Office\Controller\Adminhtml\Department
 */
class Delete extends Department
{
    /**
     * @var DepartmentFactory $departmentFactory
     */
    protected $departmentFactory;

    /**
     * Delete constructor.
     * @param Context $context
     * @param LayoutFactory $layoutFactory
     * @param PageFactory $pageFactory
     * @param ForwardFactory $forwardFactory
     * @param DepartmentFactory $departmentFactory
     */
    public function __construct(
        Context $context,
        LayoutFactory $layoutFactory,
        PageFactory $pageFactory,
        ForwardFactory $forwardFactory,
        DepartmentFactory $departmentFactory
    )
    {
        $this->departmentFactory = $departmentFactory;
        parent::__construct($context, $layoutFactory, $forwardFactory, $pageFactory);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $departmentId = $this->getRequest()->getParam('entity_id');
        if ($departmentId > 0) {
            $department = $this->departmentFactory->create()->load($this->getRequest()->getParam('entity_id'));
            try {
                $department -> delete();
                $this->messageManager->addSuccessMessage('Department was deleted successfully');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/');
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}

