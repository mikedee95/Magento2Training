<?php

namespace Dtn\Checkout\Plugin\Checkout;

class LayoutProcessorPlugin
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \Magento\Customer\Model\AddressFactory
     */
    protected $customerAddressFactory;

    /**
     * @var \Magento\Framework\Data\Form\FormKey
     */
    protected $formKey;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\CheckoutAgreements\Model\ResourceModel\Agreement\CollectionFactory $agreementCollectionFactory,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Customer\Model\AddressFactory $customerAddressFactory
    ) {
        $this->scopeConfig = $context->getScopeConfig();
        $this->checkoutSession = $checkoutSession;
        $this->customerAddressFactory = $customerAddressFactory;
    }
    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    )
    {
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['special_request'] = [
            'component' => 'Magento_Ui/js/form/element/textarea',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/textarea',
                'options' => [],
                'id' => 'special_request'
            ],
            'dataScope' => 'shippingAddress.special_request',
            'label' => 'Special Request',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 250,
            'id' => 'special_request'
        ];
        return $jsLayout;
    }

}