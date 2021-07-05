<?php

namespace Dtn\Wrapping\Controller\Index;

class Saveurl extends \Magento\Framework\App\Action\Action
{

    protected $_giftwrapQuote;
    protected $resultPageFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Dtn\Wrapping\Model\GiftWrapQuoteFactory $giftWrapQuoteFactory,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJson
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_giftWrapQuote    = $giftWrapQuoteFactory;
        $this->_scopeConfig = $scopeConfig;
        $this->_checkoutSession  = $checkoutSession;
        $this->_resultJson       = $resultJson;
        return parent::__construct($context);
    }
    public function execute()
    {
        $data          = $this->getRequest()->getPost('data');
        $toBeDeleted = $this->getRequest()->getPost('delete');
        $quoteEntityId = $this->getRequest()->getPost('quote_id');
        $giftWrapQuoteModel = $this->_giftWrapQuote->create();

        $dataCollection = $giftWrapQuoteModel->getCollection()->addFieldToFilter('quote_id', $quoteEntityId);
        if($toBeDeleted){
            $giftWrapQuoteModel->load($dataCollection->getFirstItem()->getGiftWrapId())->delete();
            $response = [
                'errors'  => false,
                'message' => 'Deletion & Re-calculation successful.',
            ];
            $resultJson = $this->_resultJson->create();
            $this->_checkoutSession->getQuote()->collectTotals()->save();
            return $resultJson->setData($response);
        }

        $itemsArray    = array_chunk($data, 5);

        $response = [
            'errors'  => false,
            'message' => 'Re-calculate successful.',
        ];
        try {
            $itemsFormatArray = array();
            foreach ($itemsArray as $key => $item) {
                foreach ($item as $k => $value) {
                    foreach ($value as $k1 => $value2) {
                        $itemsFormatArray[$key][$k1] = $value2;
                    }
                }
            }

            $finalGiftInfoArray = array();
            foreach ($itemsFormatArray as $item) {
                if($item['is_giftwrap'] != null && $item['giftwrap_id'] != null){
                    $finalGiftInfoArray[] = $item;
                }
            };

            $serializeData      = serialize($finalGiftInfoArray);
            
            $giftData                   = array();
            $giftData['quote_id']       = $quoteEntityId;
            $giftData['giftwrap_items'] = $serializeData;
            if (!$dataCollection->getData() || empty($dataCollection->getData())) {
                $giftWrapQuoteModel->setData($giftData);
                $giftWrapQuoteModel->save();
            } else {
                $giftWrapQuoteModel->load($dataCollection->getFirstItem()->getGiftWrapId())->addData($giftData);
                $giftWrapQuoteModel->save();
            }
            $this->_checkoutSession->getQuote()->collectTotals()->save();

        } catch (\Exception $e) {
            $response = [
                'errors'  => true,
                'message' => $e->getMessage(),
            ];
        }
        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultJson = $this->_resultJson->create();
        return $resultJson->setData($response);

    }
}
