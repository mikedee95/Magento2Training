<?php
namespace Dtn\Office\Setup\Patch\Schema;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;

class AddSpecialRequestColumnQuoteTable implements SchemaPatchInterface{

    private $moduleDataSetup;
    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [];
    }

    public function apply()
    {
        $this->moduleDataSetup->startSetup();


        $this->moduleDataSetup->getConnection()->addColumn(
            $this->moduleDataSetup->getTable('quote'),
            'special_request',
            [
                'type' => Table::TYPE_TEXT,
                'length' => 255,
                'nullable' => true,
                'comment'  => 'Special Request',
            ]
        );


        $this->moduleDataSetup->endSetup();
    }
}
