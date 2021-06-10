<?php

namespace Dtn\Office\Model\Department;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Dtn\Office\Model\ResourceModel\Department\CollectionFactory;
use Dtn\Office\Model\Department;

/**
 * Class DataProvider
 * @package Son\Office\Model\Department
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
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
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

        foreach ($items as $department)
        {
            $this->loadedData[$department->getData('entity_id')] = $department->getData();
        }

        return $this->loadedData;
    }
}
