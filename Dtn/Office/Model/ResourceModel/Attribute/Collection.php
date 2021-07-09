<?php

namespace Dtn\Office\Model\ResourceModel\Attribute;

use Dtn\Office\Setup\Patch\EmployeeSetup;
use Magento\Framework\Event\ManagerInterface;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection as EavCollection;
use Magento\Eav\Model\Config;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Psr\Log\LoggerInterface;
use Magento\Eav\Model\EntityFactory as EavEntityFactory;


class Collection extends EavCollection
{
    /**
     * @var EavEntityFactory
     */
    protected $_eavEntityFactory;

    /**
     * Collection constructor.
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param Config $eavConfig
     * @param EavEntityFactory $eavEntityFactory
     * @param AdapterInterface|null $connection
     * @param AbstractDb|null $resource
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        Config $eavConfig,
        EavEntityFactory $eavEntityFactory,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    )
    {
        $this->_eavEntityFactory = $eavEntityFactory;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $eavConfig, $connection, $resource);
    }

    /**
     * Selection initialize
     * @return $this|Collection|void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function _initSelect()
    {
        $this->getSelect()->from(
            ['main_table' => $this->getResource()->getMainTable()]
        )->where('main_table.entity_id=?', $this->_eavEntityFactory->create()->setType(EmployeeSetup::ENTITY_TYPE_CODE)->getTypeId())->join(
            ['additional_table' => $this->getTable(EmployeeSetup::ENTITY_TYPE_CODE . '_eav_attribute')],
            'additional_table.attribute_id = main_table.attribute_id'
        );

        return $this;
    }

    /**
     * Get filter attribute
     * @return $this
     */
    public function getFilterAttributesOnly()
    {
        $this->getSelect()->where('additional_table.is_filterable', 1);
        return $this;
    }

    /**
     * Visibility to filter column
     * @param int $status
     * @return $this
     */
    public function addVisibilityFilter($status = 1)
    {
        $this->getSelect()->where('additional_table.is_visible', $status);
        return $this;
    }

    /**
     * Set entity filter type
     * @param int|\Magento\Eav\Model\Entity\Type $typeId
     * @return $this|Collection
     */
    public function setEntityTypeFilter($typeId)
    {
        return $this;
    }
}
