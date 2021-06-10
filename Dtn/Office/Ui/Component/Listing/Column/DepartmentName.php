<?php

namespace Dtn\Office\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Dtn\Office\Model\DepartmentFactory;

/**
 * Class DepartmentName
 * @package Dtn\Office\Ui\Component\Listing\Column
 */
class DepartmentName extends Column
{

    protected $departmentFactory;

    /**
     * DepartmentName constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param DepartmentFactory $departmentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        DepartmentFactory $departmentFactory,
        array $components = [],
        array $data = [])
    {
        $this->departmentFactory = $departmentFactory;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $departmentId = $this->departmentFactory->create()->load($item['department_id']);
                $item['department_id'] = $departmentId->getData('name');
            }
        }
        return $dataSource;
    }
}
