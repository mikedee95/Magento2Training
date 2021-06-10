<?php

namespace Dtn\Office\Controller\Adminhtml\Employee;

use Dtn\Office\Controller\Adminhtml\Employee;

/**
 * Class Save
 * @package Dtn\Office\Controller\Adminhtml\Employee
 */
class Save extends Employee
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $modelId = (int)$this->getRequest()->getParam('entity_id');
        $data = $this->getRequest()->getPostValue();
        if(!$data) {
            return $resultRedirect->setPath('*/*/');
        }

        if($modelId) {
            $model = $this->_objectManager->create('Dtn\Office\Model\Employee')
                ->load($modelId);
        } else {
            $model = $this->_objectManager->create('Dtn\Office\Model\Employee');
        }

        $model->setData($data);
        try {
            $model->save();
            $this->messageManager->addSuccessMessage('Employee was saved successfully');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return  $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('entity_id')]);
        }

        if ($this->getRequest()->getParam('back') == 'edit') {
            return  $resultRedirect->setPath('*/*/edit', ['id' =>$model->getId()]);
        }
        return $resultRedirect->setPath('*/*/');

    }
}
