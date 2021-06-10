<?php
namespace Dtn\Office\Setup\Patch\Data;
use Dtn\Office\Setup\Patch\EmployeeSetupFactory;
use Dtn\Office\Model\DepartmentFactory;
use Dtn\Office\Model\EmployeeFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class InstallDefaultEmployees implements DataPatchInterface{
    private $moduleDataSetup;
    private $employeeSetupFactory;
    private $departmentFactory;
    private $employeeFactory;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup, EmployeeSetupFactory $employeeSetupFactory, DepartmentFactory $departmentFactory, EmployeeFactory $employeeFactory)
    {
            $this->moduleDataSetup = $moduleDataSetup;
            $this->employeeSetupFactory = $employeeSetupFactory;
            $this->employeeFactory = $employeeFactory;
            $this->departmentFactory = $departmentFactory;
    }

    public function apply()
    {
        $employeeSetup = $this->employeeSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $employeeSetup->installEntities();

        $itDepartment = $this->departmentFactory->create();
        $itDepartment->setName('IT');
        $itDepartment->save();

        $mktDepartment = $this->departmentFactory->create();
        $mktDepartment->setName('Marketing');
        $mktDepartment->save();

        $hrDepartment = $this->departmentFactory->create();
        $hrDepartment->setName('Human Resource');
        $hrDepartment->save();

        $employee1 = $this->employeeFactory->create();
        $employee1->setDepartmentId($itDepartment->getId())
                    ->setEmail('mikedee1295@gmail.com')
                    ->setFirstname('Mike')
                    ->setLastname('Wazowski')
                    ->setServiceYears(1)
                    ->setDob('1995-01-12')
                    ->setSalary(420)
                    ->setNote('Worried man with a worried mind');
        $employee1->save();

        $employee2 = $this->employeeFactory->create();
        $employee2->setDepartmentId($mktDepartment->getId())
                    ->setEmail('janet@gmail.com')
                    ->setFirstname('Jane')
                    ->setLastname('Doe')
                    ->setServiceYears(1)
                    ->setDob('1996-08-01')
                    ->setSalary(840)
                    ->setNote('Just some notes about Jane');
        $employee2->save();

        $employee3 = $this->employeeFactory->create();
        $employee3->setDepartmentId($hrDepartment->getId())
                    ->setEmail('johndoe124@gmail.com')
                    ->setFirstname('John')
                    ->setLastname('Doe')
                    ->setServiceYears(2)
                    ->setDob('1992-02-06')
                    ->setSalary(630)
                    ->setNote('Just some notes about this mf');
        $employee3->save();
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [];
    }
}
