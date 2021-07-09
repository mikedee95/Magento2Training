<?php

namespace Dtn\Office\Block\Adminhtml\Employee\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save Employee'),
            'class' => 'save primary',
            'data_attribute' => [
                'form-role' => 'save',
            ],
            'on_click' => sprintf("location.href= '%s';", $this->getSaveUrl()),
            'sort_order' => 90,
        ];
    }

    /**
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('dtn/employee/save') ;
    }
}
