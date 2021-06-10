<?php

namespace Dtn\Office\Block\Adminhtml\Department\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class BackButton
 * @package Dtn\Office\Block\Adminhtml\Department\Edit
 */
class BackButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href= '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Get Url for Back button
     * @return mixed
     */
    public function getBackUrl() {
        return $this->getUrl('*/*/');
    }
}


