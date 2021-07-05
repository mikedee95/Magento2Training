<?php

namespace Dtn\Wrapping\Block;

class GiftWrapStep extends \Magento\Framework\View\Elenment\Template
{
        protected $_giftWrapFactory;
        protected $session;
        public function __construct(
            \Magento\Framework\View\Element\Template\Context $context,
            \Dtn\Wrapping\Model\GiftwrapFactory $giftWrapFactory,
            \Magento\Checkout\Model\SessionFactory $session,
            \Dtn\Wrapping\Helper\Data $coreHelper,
            \Magento\Framework\Pricing\Helper\Data $priceHelper
        ) {
            $this->_giftWrapFactory               = $giftWrapFactory;
            $this->session                        = $session;
            $this->_priceHelper                   = $priceHelper;
            $this->storeManager                   = $context->getStoreManager();
            $this->_appConfigScopeConfigInterface = $context->getScopeConfig();
            parent::__construct($context);
        }
        protected function _prepareLayout()
        {
            parent::_prepareLayout();
        }
    
        public function getGiftWrapItems()
        {
            $mediaurl       = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
            $storeId        = $this->storeManager->getStore()->getId();
            $model          = $this->_giftwrapFactory->create();
            $collectionData = $model->getCollection()->addFieldToFilter('store', $storeId)
                ->addFieldToFilter('is_active', 1);
            $storeScope      = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $configPrice           = $this->_appConfigScopeConfigInterface->getValue('giftwrap/cost_calculation/price', $storeScope);
    
            $perOrder        = $this->_appConfigScopeConfigInterface->getValue('giftwrap/cost_calculation/cost_calculation', $storeScope);
    
            $giftItemArray = array();
            if (!empty($collectionData->getData()) || $collectionData->getData()) {
                foreach ($collectionData as $value) {
                    if(!$perOrder){
                        $price = $this->convertPrice($value->getPrice());
                    } else{
                        $price = 0;
                    }
                    $giftItemArray[] = array(
                        "giftwrap_id" => $value->getGiftwrapId(),
                        "name"        => $value->getTitle(),
                        "price"       => $price,
                        "formatted_price" => $this->_priceHelper->currency($price, true, false),
                        "image"       => $mediaurl . $value->getImage(),
                    );
                }
            } else {
    
                if(!$perOrder){
                    $price = $this->convertPrice($value->getPrice());
                } else{
                    $price = 0;
                }
                
                $title           = $this->_appConfigScopeConfigInterface->getValue('giftwrap/default_gift_wrap/label', $storeScope);
                
                $imagewraper     = $this->_appConfigScopeConfigInterface->getValue('giftwrap/default_gift_wrap/upload_image_id', $storeScope);
                $giftItemArray[] = array(
                    "giftwrap_id" => 0,
                    "name"        => __($title),
                    "price"       => $price,
                    "formatted_price" => $this->_priceHelper->currency($price, true, false),
                    "image"       => $mediaurl . 'default_gift_wrap/' . $imagewraper,
                );
    
            }
    
            return $giftItemArray;
    
        }
    
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
            if ($amount > 0) {
                $rate   = $priceCurrencyObject->convert($amount, $store) / $amount;
                $amount = $amount / $rate;
            }
            return $priceCurrencyObject->round($amount);
        }
    
        public function getQuote()
        {
            $checkout = $this->session->create()->getQuote();
            return $checkout->getAllVisibleItems();
        }
    
        public function getQuoteId()
        {
            $quoteId = $this->session->create()->getQuote()->getEntityId();
            return $quoteId;
        }
    
    }
    