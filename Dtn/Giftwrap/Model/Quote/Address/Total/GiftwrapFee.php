<?php

namespace Dtn\Giftwrap\Model\Quote\Address\Total;

class GiftwrapFee extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    protected $_helperData;
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * Collect grand total address amount
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this
     */
    protected $_quoteValidator = null;

    /**
     * Payment Fee constructor.
     *
     * @param \Magento\Quote\Model\QuoteValidator $quoteValidator
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Quote\Api\Data\PaymentInterface $payment
     * @param \Dtn\Fee\Helper\Data $helperData
     */
    public function __construct(
        \Magento\Quote\Model\QuoteValidator $quoteValidator,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Quote\Api\Data\PaymentInterface $payment,
        \Magento\Payment\Model\Config $paymentModelConfig,
        \Magento\Framework\App\Config\ScopeConfigInterface $appConfigScopeConfigInterface,
        \Dtn\Giftwrap\Model\GiftwrapquoteFactory $giftwrapquoteFactory,
        \Dtn\Giftwrap\Model\GiftwrapFactory $giftwrapFactory,
        \Dtn\Giftwrap\Helper\Data $helperData
    ) {
        $this->_quoteValidator                = $quoteValidator;
        $this->_helperData                    = $helperData;
        $this->_checkoutSession               = $checkoutSession;
        $this->_paymentModelConfig            = $paymentModelConfig;
        $this->_giftwrapQuote                 = $giftwrapquoteFactory;
        $this->_giftwrap                      = $giftwrapFactory;
        $this->_appConfigScopeConfigInterface = $appConfigScopeConfigInterface;

    }

    /**
     * Collect totals process.
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this
     */
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);
        if (!$quote) {
            return $this;
        }
        $giftwrapModel = $this->_giftwrap->create();
        $items         = $quote->getAllItems();
        $subtotal      = 0;
        foreach ($items as $item) {
            $subtotal += $item->getRowTotalInclTax();
        }

        $quoteEntityId = $quote->getEntityId();
        $collection    = $this->_giftwrapQuote->create()->getCollection()->addFieldToFilter('quote_id', $quoteEntityId);

        if (!empty($collection->getData()) || $collection->getData()) {
            $collectoinData = $collection->getFirstItem();
            $giftwrapItems  = $collectoinData->getGiftwrapItems();
            $wrapitems      = unserialize($giftwrapItems);
            $dataToBeSaved = array();
            $dataToBeSaved['data'] = $wrapitems;
            $totalWrapPrice = 0;
            $storeScope      = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $price           = $this->_appConfigScopeConfigInterface->getValue('giftwrap/cost_calculation/price', $storeScope);
            if(!$this->_appConfigScopeConfigInterface->getValue('giftwrap/cost_calculation/cost_calculation', $storeScope)){
                foreach ($wrapitems as $key => $value) {
                    if ($value['is_giftwrap']) {
                        if($value['giftwrap_id']){
                            $totalWrapPrice += $giftwrapModel->load($value['giftwrap_id'])->getPrice();
                        }
                        else{

                            $totalWrapPrice += $price;
                        }
                    }
                }
            } else{
                $totalWrapPrice = $price;
            }

            $dataToBeSaved['total'] = ['per_order' => $this->_appConfigScopeConfigInterface->getValue('giftwrap/cost_calculation/cost_calculation', $storeScope), 'price' => $totalWrapPrice];

            $totalWrapPrice = $this->convertPrice($totalWrapPrice);
            $grandTotal     = $total->getGrandTotal();
            $baseGrandTotal = $total->getBaseGrandTotal();
            $totals         = array_sum($total->getAllTotalAmounts());
            $baseTotals     = array_sum($total->getAllBaseTotalAmounts());

            $total->setTotalAmount('giftwrap_amount', $totalWrapPrice);
            $total->setBaseTotalAmount('giftwrap_amount', $totalWrapPrice);
            $total->setGiftwrapAmount($totalWrapPrice);
            $total->setBaseGiftwrapAmount($totalWrapPrice);
            if ($totalWrapPrice) {
                $quote->setGiftwrapAmount($totalWrapPrice);
                $quote->setBaseGiftwrapAmount($totalWrapPrice);
                $quote->setGiftWrapInfo(serialize($dataToBeSaved));
            }
            $total->setGrandTotal($total->getGrandTotal() + $totalWrapPrice);
            $total->setBaseGrandTotal($total->getBaseGrandTotal() + $totalWrapPrice);

        }

        return $this;
    }

    /**
     * Assign subtotal amount and label to address object
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function fetch(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {

        $result = '';
         $giftwrapModel = $this->_giftwrap->create();
      $quoteEntityId = $quote->getEntityId();
        $collection    = $this->_giftwrapQuote->create()->getCollection()->addFieldToFilter('quote_id', $quoteEntityId);
      if (!empty($collection->getData()) || $collection->getData()) {
            $collectoinData = $collection->getFirstItem();
            $giftwrapItems  = $collectoinData->getGiftwrapItems();
            $wrapitems      = unserialize($giftwrapItems);
            $totalWrapPrice = 0;
            $storeScope      = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $price           = $this->_appConfigScopeConfigInterface->getValue('giftwrap/cost_calculation/price', $storeScope);
            if(!$this->_appConfigScopeConfigInterface->getValue('giftwrap/cost_calculation/cost_calculation', $storeScope)){
                foreach ($wrapitems as $key => $value) {
                    if ($value['is_giftwrap']) {
                        if($value['giftwrap_id']){
                            $totalWrapPrice += $giftwrapModel->load($value['giftwrap_id'])->getPrice();
                        }
                        else{

                            $totalWrapPrice += $price;
                        }
                    }
                }
            } else{
                $totalWrapPrice = $price;
            }
            $totalWrapPrice = $this->convertPrice($totalWrapPrice);
            $Giftwrap_label = 'GiftWrap';
                $result = array(
                        'code'  => 'giftwrap_amount',
                        'title' => __($Giftwrap_label),
                        'value' => $totalWrapPrice,
                    );
        } else {

            $result = array(
                'code'  => 'giftwrap_amount',
                'title' => __('Not Calculated yet'),
                'value' => 0,
            );
        }

        if ($result == '') {
            return $total;
        }

        return $result;
    }

    /**
     * Convert fee to different currency
     *
     * @param $amount
     * @param null $store
     * @param null $currency
     * @return mixed
     */
    public function convertPrice($amount, $store = null, $currency = null)
    {
        $objectManager       = \Magento\Framework\App\ObjectManager::getInstance();
        $priceCurrencyObject = $objectManager->get('Magento\Framework\Pricing\PriceCurrencyInterface');
        $storeManager        = $objectManager->get('Magento\Store\Model\StoreManagerInterface');
        if ($store == null) {
            $store = $storeManager->getStore()->getStoreId();
        }
        // $rate = $priceCurrencyObject->convert($amount, $store, $currency); //it return price according to current store from base currency

        //If you want it in base currency then use:
        if($amount > 0 ) {
            $rate   = $priceCurrencyObject->convert($amount, $store) / $amount;
        $amount = $amount / $rate;
        }
         return $priceCurrencyObject->round($amount);
    }

    /**
     * Get Subtotal label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Gift Wrap Cost');
    }
}
