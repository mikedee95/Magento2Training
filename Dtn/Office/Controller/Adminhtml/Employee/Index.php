<?php
namespace Dtn\Office\Controller\Adminhtml\Employee;
use Dtn\Office\Controller\Adminhtml\Employee;

class Index extends Employee
{
    public function execute()
    {
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend('Employee');

        return $resultPage;
    }
}
