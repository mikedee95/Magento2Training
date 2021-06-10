<?php
namespace Dtn\Office\Block\Adminhtml\Department\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class ResetButton
 * @package Dtn\Office\Block\Adminhtml\Department\Edit
 */
class ResetButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Reset'),
            'on_click' => 'javascript: location.reload();',
            'class' => 'reset',
            'sort_order' => 30
        ];
    }
}
