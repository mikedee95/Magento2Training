<?php

namespace Dtn\Office\Controller\Adminhtml\Department;


use Dtn\Office\Controller\Adminhtml\Department;

/**
 * Class Index
 * @package Dtn\Office\Controller\Adminhtml\Department
 */
class Index extends Department
{
    public function execute()
    {
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend('Department');

        return $resultPage;
    }
}
