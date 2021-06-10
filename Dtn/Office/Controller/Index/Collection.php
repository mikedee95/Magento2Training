<?php

namespace Dtn\Office\Controller\Index;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Dtn\Office\Model\ResourceModel\Employee\CollectionFactory;

class Collection extends Action {

    /**
     * @var pageFactory
     */
    protected $pageFactory;

    /**
     * @var employeeCollectionFactory
     */
    protected $employeeCollectionFactory;

    /**
     * Collection constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param \Dtn\Office\Model\ResourceModel\Employee\CollectionFactory $employeeCollectionFactory
     */
    public function __construct(Context $context,
                                PageFactory $pageFactory,
                                \Dtn\Office\Model\ResourceModel\Employee\CollectionFactory $employeeCollectionFactory)
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->employeeCollectionFactory = $employeeCollectionFactory;
    }

    /**
     * @return
     */
    public function execute()
    {
        $collection = $this->employeeCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('department_id',['like' => 5]);
        $collection->addAttributeToFilter('working_years',['gteq' => 2]);
        $collection->addAttributeToFilter('salary',['gteq' => 10000]);
        $collection->load();

        foreach ($collection as $employee) {
            var_dump($employee->getData());
        }

        exit();
    }
}

