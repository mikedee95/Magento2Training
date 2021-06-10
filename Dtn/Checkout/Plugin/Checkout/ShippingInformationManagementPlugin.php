<?php

namespace Dtn\Checkout\Plugin\Checkout;

class ShippingInformationManagementPlugin
{

    protected $quoteRepository;

    public function __construct(
        \Magento\Quote\Model\QuoteRepository $quoteRepository
    ) {
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param $cartId
     * @param \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
     */
    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ) {
        $extensionAttributes = $addressInformation->getShippingAddress()->getExtensionAttributes();
        $specialRequest = $extensionAttributes->getSpecialRequest();
        $quote = $this->quoteRepository->getActive($cartId);
        $quote->setSpecialRequest($specialRequest);
    }
}