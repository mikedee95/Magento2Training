<?php
namespace Dtn\Knockout\Block;

use Dtn\Knockout\Model\ResourceModel\Employee\CollectionFactory;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Zend_Json;

class Employee extends Template
{

    /**
     * @var array
     */
    protected $layoutProcessors;
    /**
     * @var JsonFactory
     */
    private $jsonResultFactory;
    /**
     * @var CollectionFactory
     */
    protected $employeeCollectionFactory;
    /**
     * @var Http
     */
    protected $request;
    /**
     * @var \Dtn\Knockout\Model\Employee
     */
    protected $employee;

    /**
     * Employee constructor.
     * @param Context $context
     * @param CollectionFactory $employeeCollectionFactory
     * @param JsonFactory $jsonResultFactory
     * @param Http $request
     * @param \Dtn\Knockout\Model\Employee $employee
     * @param array $layoutProcessors
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $employeeCollectionFactory,
        JsonFactory $jsonResultFactory,
        Http $request,
        \Dtn\Knockout\Model\Employee $employee,
        array $layoutProcessors = [],
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->jsLayout = isset($data['jsLayout']) && is_array($data['jsLayout']) ? $data['jsLayout'] : [];
        $this->layoutProcessors = $layoutProcessors;
        $this->employeeCollectionFactory = $employeeCollectionFactory;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->employee = $employee;
        $this->request = $request;
    }

    public function getJsLayout()
    {
        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }
        return Zend_Json::encode($this->jsLayout); // call toJson() method to get a JSON presentation of jsLayout obj.
    }

    /**
     * get data employee
     * @return string
     */
    public function getEmployee()
    {
        /**
         * get Data employee
         */
        $employees = $this->employeeCollectionFactory->create();
        /**
         * process data
         */
        $result = array();
        foreach ($employees as $collection) {
            $result[] = $collection->getData();
        }
        return json_encode($result);
    }
}
