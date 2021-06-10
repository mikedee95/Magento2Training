<?php

namespace Dtn\Checkout\Block\Adminhtml\Order;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Quote\Api\Data\AddressExtensionInterface;

class SpecialRequest extends Template implements TabInterface
{
    protected $_template = 'order/view/specialrequest.phtml';
    protected $_coreRegistry = null;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    )
    {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    public function getTabLabel()
    {
        return __('Special Request');
    }

    public function getTabTitle()
    {
        return __('Special Request');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    public function getOrder()
    {
        return $this->_coreRegistry->registry('current_order');
    }

    public function getSpecialRequest()
    {
        return $this->getOrder()->getSpecialRequest();
    }
}
