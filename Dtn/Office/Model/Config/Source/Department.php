<?php
namespace Dtn\Office\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Dtn\Office\Model\DepartmentFactory;

/**
 * Class Department
 * @package Dtn\Office\Model\Config\Source
 */
class Department implements ArrayInterface
{
    /**
     * @var DepartmentFactory $departmentFactory
     */
    protected $departmentFactory;

    /**
     * Department constructor.
     * @param DepartmentFactory $departmentFactory
     */
    public function __construct(
        DepartmentFactory $departmentFactory
    )
    {
        $this->departmentFactory = $departmentFactory;
    }

    /**
     * @return array|void
     */
    public function toOptionArray()
    {
        $department = $this->departmentFactory->create()->getCollection();
        $departmentOptions = [];

        foreach ($department as $items) {
            $departmentOptions[] = [
                "value" => $items->getId(),
                "label" => $items->getName()
            ];
        }

        return $departmentOptions;
    }
}
