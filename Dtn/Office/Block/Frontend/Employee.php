<?php

namespace Dtn\Office\Block\Frontend;

use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Template;
use Dtn\Office\Model\EmployeeFactory;
use Dtn\Office\Model\DepartmentFactory;
use Magento\Framework\Registry;


class Employee extends Template
{

    /**
     * @var SerializerInterface $serializer
     */
    protected $serializer;

    /**
     * @var FormKey $formKey
     */
    protected $formKey;

    /**
     * @var Registry $_coreRegistry
     */

    protected $_coreRegistry;
    /**
     * @var \Dtn\Office\Model\ResourceModel\Employee\CollectionFactory $employeeFactory
     */
    protected $employeeFactory;

    /**
     * @var \Dtn\Office\Model\DepartmentFactory $departmentFactory
     */
    protected $departmentFactory;

    /**
     * Employee constructor.
     * @param Template\Context $context
     * @param FormKey $formKey
     * @param EmployeeFactory $employeeFactory
     * @param DepartmentFactory $departmentFactory
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        FormKey $formKey,
        EmployeeFactory $employeeFactory,
        DepartmentFactory $departmentFactory,
        Registry $registry,
        SerializerInterface $serializer,
        array $data = []
    )
    {
        $this->serializer = $serializer;
        $this->departmentFactory = $departmentFactory;
        $this->_coreRegistry = $registry;
        $this->employeeFactory = $employeeFactory;
        parent::__construct($context, $data);
        $this->formKey = $formKey;
    }

    /**
     * @return \Dtn\Office\Model\ResourceModel\Employee\Collection
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getEmployee(){
        //get values of current page
        $page=($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
        //get values of current limit
        $pageSize=($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 3;
        $collection = $this->employeeFactory->create()->getCollection();
        $collection->addAttributeToSelect('*');
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);
        return $collection;
    }

    /**
     * @return \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
     */
    public function getDepartmentCollection()
    {
        return $this->departmentFactory->create()->getCollection();
    }

    /**
     * @return Template
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function _prepareLayout()
    {
        if ($this->getEmployee()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'dtn.office.pager'
            )
                ->setAvailableLimit(array(3=>3,5=>5,10=>10,15=>15))
                ->setShowPerPage(true)->setCollection(
                    $this->getEmployee()
                );
            $this->setChild('pager', $pager);
            $this->getEmployee()->load();
        }
        return parent::_prepareLayout();
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * @return \Dtn\Office\Model\Employee
     */
    public function getCurrentEmployee()
    {
        $id = $this->_coreRegistry->registry('current_employee_id');
        $employee = $this->employeeFactory->create();
        $employee->load($id)->getData();
        return $employee;
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }
}
