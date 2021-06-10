<?php

namespace Dtn\Office\Setup\Patch\Data;

use Dtn\Office\Setup\Patch\EmployeeSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;

class InstallDefaultAttributes implements DataPatchInterface, PatchVersionInterface
{
    private $moduleDataSetup;
    private $employeeSetupFactory;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup,
                                EmployeeSetupFactory $employeeSetupFactory)
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->employeeSetupFactory = $employeeSetupFactory;
    }

    public function apply()
    {
        $employeeSetup = $this->employeeSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $employeeSetup->installEntities();
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [];
    }

    public static function getVersion()
    {
        return '1.0.0';
    }
}
