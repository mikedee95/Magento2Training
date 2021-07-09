<?php

namespace Dtn\Office\Setup\Patch;

use Dtn\Office\Model\ResourceModel\Employee;
use Magento\Eav\Model\Entity\Attribute\Backend\Datetime;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;


class EmployeeSetup extends EavSetup
{

//    const ENTITY_TYPE_CODE = 9;
    public function getDefaultEntities()
    {
        return [
            'dtn_office_employee' => [
                'entity_model' => Employee::class,
                'table' => 'dtn_office_employee_entity',
                'attributes' => [
                    'department_id' => [
                        'type' => 'static',
                        'label' => 'Department ID',
                        'required' => false,
                        'sort_order' => 1,
                        'visible' => false,
                        'group' => 'General Information'
                    ],
                    'email' => [
                        'type' => 'static',
                        'label' => 'Email',
                        'required' => true,
                        'sort_order' => 2,
                        'visible' => true,
                        'group' => 'General Information'
                    ],
                    'firstname' => [
                        'type' => 'static',
                        'label' => 'First Name',
                        'required' => true,
                        'sort_order' => 3,
                        'visible' => true,
                        'group' => 'General Information'
                    ],
                    'lastname' => [
                        'type' => 'static',
                        'label' => 'Last Name',
                        'required' => true,
                        'sort_order' => 4,
                        'visible' => true,
                        'group' => 'General Information'
                    ],
                    'service_years' => [
                        'type' => 'int',
                        'label' => 'Service Years',
                        'input' => 'text',
                        'sort_order' => 5,
                        'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                        'group' => 'General Information'
                    ],
                    'dob' => [
                        'type' => 'datetime',
                        'label' => 'Date Of Birth',
                        'input' => 'date',
                        'backend' => Datetime::class,
                        'sort_order' => 6,
                        'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                        'group' => 'General Information'
                    ],
                    'salary' => [
                        'type' => 'decimal',
                        'label' => 'Salary',
                        'input' => 'text',
                        'sort_order' => 7,
                        'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                        'group' => 'General Information'
                    ],
                    'note' => [
                        'type' => 'text',
                        'label' => 'Note',
                        'input' => 'textarea',
                        'sort_order' => 9,
                        'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                        'wysiwyg_enabled' => true,
                        'is_html_allowed_on_front' => true,
                        'group' => 'General Information'
                    ]
                ]
            ]
        ];
    }
}
