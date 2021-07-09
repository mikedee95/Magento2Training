<?php

namespace Dtn\Checkout\Block\Adminhtml\Order;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Quote\Api\Data\AddressExtensionInterface;

class SpecialRequest extends Template implements TabInterface
{

    /**
     * @var string
     */
    protected $_template = 'order/view/specialrequest.phtml';

    /**
     * @var \Magento\Framework\Registry|null
     */
    protected $_coreRegistry = null;

    /**
     * SpecialRequest constructor.
     * @param Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    )
    {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Get tab label
     * @return \Magento\Framework\Phrase|string
     */
    public function getTabLabel()
    {
        return __('Special Request');
    }

    /**
     * Get tab title
     * @return \Magento\Framework\Phrase|string
     */
    public function getTabTitle()
    {
        return __('Special Request');
    }

    /**
     * Ability to display tab
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Hidden checked
     * @return false
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Return order detail
     * @return mixed|null
     */
    public function getOrder()
    {
        return $this->_coreRegistry->registry('current_order');
    }

    /**
     * Return special request detail
     * @return mixed
     */
    public function getSpecialRequest()
    {
        return $this->getOrder()->getSpecialRequest();
    }
}
