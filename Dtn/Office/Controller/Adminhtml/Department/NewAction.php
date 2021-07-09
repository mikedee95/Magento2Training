<?php

namespace Dtn\Office\Controller\Adminhtml\Department;

use Magento\Framework\Controller\ResultFactory;
use Dtn\Office\Controller\Adminhtml\Department;

/**
 * Class NewAction
 * @package Dtn\Office\Controller\Adminhtml\Department
 */
class NewAction extends Department
{
    /**
     * Chay den Edit
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)->forward('edit');
    }
}
