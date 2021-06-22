<?php
namespace Dtn\Knockout\Controller\Employee;

class Delete extends \Magento\Framework\App\Action\Action{

    /**
     *@var PageFactory
     */
    protected $_pageFactory;

    /**
     *@var EmployeeFactory
     */
    private $employeeFactory;

    /**
     *@var JsonFactory
     */
    private $resultJsonFactory;


    /**
     * Delete constructor.
     * @param PageFactory $pageFactory
     * @param Context $context
     * @param JsonFactory $resultJsonFactory
     * @param EmployeeFactory $employeeFactory
     */
    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $pageFactory, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Dtn\Knockout\Model\EmployeeFactory $employeeFactory)
    {
        $this->_pageFactory = $pageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->employeeFactory = $employeeFactory;

        parent::__construct($context);
    }

    /**
     * Delete employee after existed check
     */
    public function execute()
    {
        $employee = $this->employeeFactory->create();
        $data = $this->getRequest()->getParams('data');
        try {
            $employee->load($data['employee_id'])->delete();
        } catch (\Exception $e){
        }
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($data);
    }
}
