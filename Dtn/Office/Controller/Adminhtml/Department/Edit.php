<?php

namespace Dtn\Office\Controller\Adminhtml\Department;

use Dtn\Office\Controller\Adminhtml\Department;

/**
 * Class Edit
 * @package Dtn\Office\Controller\Adminhtml\Department
 */
class Edit extends Department
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        $modelDepartment = $this->_objectManager->create('Dtn\Office\Model\Department');

        if ($id) {
            $modelDepartment = $modelDepartment->load($id);
            if (!$modelDepartment->getId()) {
                $this->messageManager->addErrorMessage(__('This department is not existed.'));
                return $resultRedirect->setPath('dtn/*/', ['_current' => true]);
            }
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $modelDepartment->setData($data);
        }

        $resultPage = $this->pageFactory->create();
        if (!$modelDepartment->getId()) {
            $pageTitle = __('New Department');
        } else {
            $pageTitle =  __('Edit Department %1 ', $modelDepartment->getData('name') );
        }
        $resultPage->getConfig()->getTitle()->prepend($pageTitle);

        return $resultPage;
    }
}
