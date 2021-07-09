<?php


namespace Dtn\Office\Controller\Adminhtml\Department;

use Dtn\Office\Controller\Adminhtml\Department;

/**
 * Class Save
 * @package Dtn\Office\Controller\Adminhtml\Department
 */
class Save extends Department
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $modelId = (int)$this->getRequest()->getParam('entity_id');
        $data['name'] = $this->getRequest()->getPostValue('name');
        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }

        if ($modelId) {
            $model = $this->_objectManager->create('Dtn\Office\Model\Department')
                ->load($modelId);
            $data['entity_id'] = $modelId;
        } else {
            $model = $this->_objectManager->create('Dtn\Office\Model\Department');
        }

        $model->setData($data);
        try {
            $model->save();
            $this->messageManager->addSuccessMessage('Department was saved successfully');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('entity_id')]);
        }

        if ($this->getRequest()->getParam('back') == 'edit') {
            return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
        }
        return $resultRedirect->setPath('*/*/');

    }
}
