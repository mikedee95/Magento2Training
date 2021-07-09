<?php

namespace Dtn\Office\Ui\Component\Employee;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Dtn\Office\Model\ResourceModel\Employee\CollectionFactory;

/**
 * Class DataProvider
 * @package Dtn\Office\Model\Employee
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var $collection
     */
    protected $collection;

    /**
     * @var Loadeddata
     */
    protected $loadedData;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = [])
    {
        $colection = $collectionFactory->create();
        $colection->addAttributeToSelect('*');
        $this->collection = $colection;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array|Loadeddata
     */
    public function getData()
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        foreach ($items as $employee)
        {
            $this->loadedData[$employee->getData('entity_id')] = $employee->getData();
        }

        return $this->loadedData;
    }
}
