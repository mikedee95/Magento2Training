<?php
namespace Dtn\Knockout\Controller\Employee;


class Create extends \Magento\Framework\App\Action\Action
{   
    /**
    *@var PageFactory
    */
    protected $_pageFactory;

    /**
     *@var EmployeeFactory
     */
    protected $_employeeFactory;

    /**
     *@var Data
     */
    private $helper;

    /**
     *@var JsonFactory
     */
    private $resultJsonFactory;


    /**
     * Create constructor.
     * @param Context $context
     * @param Data $helper
     * @param PageFactory $pageFactory
     * @param JsonFactory $resultJsonFactory
     * @param EmployeeFactory $employeeFactory
     */
    public function __construct(\Magento\Framework\App\Action\Context $context,
                                \Magento\Framework\Json\Helper\Data $helper,
                                \Magento\Framework\View\Result\PageFactory $pageFactory,
                                \Dtn\Knockout\Model\EmployeeFactory $employeeFactory,
                                \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory)
    {
        $this->_pageFactory = $pageFactory;
        $this->_employeeFactory = $employeeFactory;
        $this->helper = $helper;
        $this->resultJsonFactory = $resultJsonFactory;

        return parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->helper->jsonDecode($this->getRequest()->getContent());
        // var_dump($data);
        if(empty($data['employee_id'])){
            unset($data['employee_id']);
        $employee = $this->_employeeFactory->create();
    } else {
        $id = $data['employee_id'];
        $employee = $this->_employeeFactory->create()->load($id);
        if($employee->getId()){
            $employee = $this->_employeeFactory->create()->load($id);
        }
    }
    $employee->setData($data);
    try {
        $save = $employee->save();
        if($save){
            $response[]=[
                'employee_id' => $employee->getId(),
                'department' => $employee->getDepartment(),
                'email' => $employee->getEmail(),
                'firstname' => $employee->getFirstname(),
                'lastname' => $employee->getLastname(),
                'dob' => $employee->getDob(),
                'salary' => $employee->getSalary(),
                'note' => $employee->getNote()
            ];
        }
    } catch(\Exception $e){}
    $resultJson = $this->resultJsonFactory->create();
    return $resultJson->setData($response, true);
 }
}