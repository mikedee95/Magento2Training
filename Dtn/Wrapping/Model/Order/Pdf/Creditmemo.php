<?php

namespace Dtn\Wrapping\Model\Order\Pdf;

class Creditmemo extends \Magento\Sales\Model\Order\Pdf\Creditmemo
{

    protected function insertTotalsIncludingGift($page, $source, $priceHelper)
    {
        $order = $source->getOrder();
        $giftWrapAmount = $order->getGiftWrapAmount();
        $totals = $this->_getTotalsList();
        $lineBlock = ['lines' => [], 'height' => 15];
        foreach ($totals as $total) {
            $total->setOrder($order)->setSource($source);

            if ($total->canDisplay()) {
                $total->setFontSize(10);
                foreach ($total->getTotalsForDisplay() as $totalData) {
                    if ($totalData['label']!='Giftwrap:') {
                        $lineBlock['lines'][] = [
                            [
                                'text' => $totalData['label'],
                                'feed' => 475,
                                'align' => 'right',
                                'font_size' => $totalData['font_size'],
                                'font' => 'bold',
                            ],
                            [
                                'text' => $totalData['amount'],
                                'feed' => 565,
                                'align' => 'right',
                                'font_size' => $totalData['font_size'],
                                'font' => 'bold'
                            ],
                        ];
                    }
                }
            }
        }
        $giftWrapInfo[] = [
            [
                'text' => 'Gift Wrap',
                'feed' => 475,
                'align' => 'right',
                'font_size' => 10,
                'font' => 'bold',
            ],
            [
                'text' => $priceHelper->currency($giftWrapAmount, true, false),
                'feed' => 565,
                'align' => 'right',
                'font_size' => 10,
                'font' => 'bold'
            ],
        ];
        array_splice($lineBlock['lines'], (count($lineBlock['lines'])-1), 0, $giftWrapInfo);

        $this->y -= 20;
        $page = $this->drawLineBlocks($page, [$lineBlock]);
        return $page;
    }
    /**
     * Draw header for gift table
     *
     * @param \Zend_Pdf_Page $page
     * @return void
     */
    protected function _drawGiftHeader(\Zend_Pdf_Page $page)
    {
        /* Add table head */
        $this->_setFontRegular($page, 10);
        $page->setFillColor(new \Zend_Pdf_Color_RGB(0.93, 0.92, 0.92));
        $page->setLineColor(new \Zend_Pdf_Color_GrayScale(0.5));
        $page->setLineWidth(0.5);
        $page->drawRectangle(25, $this->y, 570, $this->y - 15);
        $this->y -= 10;
        $page->setFillColor(new \Zend_Pdf_Color_RGB(0, 0, 0));

        //columns headers
        $lines[0][] = ['text' => __('Product'), 'feed' => 35];

        $lines[0][] = ['text' => __('SKU'), 'feed' => 210, 'align' => 'right'];

        $lines[0][] = ['text' => __('Gift Wrapper'), 'feed' => 230, 'align' => 'left'];

        $lines[0][] = ['text' => __('Gift Message'), 'feed' => 340, 'align' => 'left'];

        $lines[0][] = ['text' => __('Gift Wrap Price'), 'feed' => 565, 'align' => 'right'];

        $lineBlock = ['lines' => $lines, 'height' => 5];

        $this->drawLineBlocks($page, [$lineBlock], ['table_header' => true]);
        $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
        $this->y -= 20;
    }

    /**
     * Draw header for item table
     *
     * @param \Zend_Pdf_Page $page
     * @return void
     */
    protected function _drawGiftHeading(\Zend_Pdf_Page $page)
    {
        /* Add table head */
        $this->_setFontBold($page, 12);
        $this->y -= 20;
        $page->drawText(__('Gift Wrap Details:'), 25, $this->y, 'UTF-8');
        $this->y -= 10;
    }

    /**
     * Draw header for gift table
     *
     * @param \Zend_Pdf_Page $page
     * @return void
     */
    protected function _drawGiftItem(\Zend_Pdf_Page $page, $giftWrapData, $productData, $giftMessage, $priceHelper)
    {
        $lines[0][] = ['text' => $productData->getName(), 'feed' => 35];

        $lines[0][] = ['text' => $productData->getSku(), 'feed' => 210, 'align' => 'right'];

        $lines[0][] = ['text' => $giftWrapData['title'], 'feed' => 230, 'align' => 'left'];

        if(empty(trim($giftMessage))){
            $giftMessage = '----';
        }

        $lines[0][] = ['text' => $giftMessage, 'feed' => 340, 'align' => 'left'];

        $lines[0][] = ['text' => $priceHelper->currency($giftWrapData['price'], true, false), 'feed' => 565, 'align' => 'right'];

        $lineBlock = ['lines' => $lines, 'height' => 20];

        $this->drawLineBlocks($page, [$lineBlock], ['table_header' => true]);
        $page->setFillColor(new \Zend_Pdf_Color_GrayScale(0));
    }

    /**
     * Return PDF document
     *
     * @param  array $creditmemos
     * @return \Zend_Pdf
     */
    public function getPdf($creditmemos = [])
    {
        $this->_beforeGetPdf();
        $this->_initRenderer('creditmemo');

        $pdf = new \Zend_Pdf();
        $this->_setPdf($pdf);
        $style = new \Zend_Pdf_Style();
        $this->_setFontBold($style, 10);

        foreach ($creditmemos as $creditmemo) {
            if ($creditmemo->getStoreId()) {
                $this->_localeResolver->emulate($creditmemo->getStoreId());
                $this->_storeManager->setCurrentStore($creditmemo->getStoreId());
            }
            $page = $this->newPage();
            $order = $creditmemo->getOrder();
            /* Add image */
            $this->insertLogo($page, $creditmemo->getStore());
            /* Add address */
            $this->insertAddress($page, $creditmemo->getStore());
            /* Add head */
            $this->insertOrder(
                $page,
                $order,
                $this->_scopeConfig->isSetFlag(
                    self::XML_PATH_SALES_PDF_CREDITMEMO_PUT_ORDER_ID,
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
                    $order->getStoreId()
                )
            );
            /* Add document text and number */
            $this->insertDocumentNumber($page, __('Credit Memo # ') . $creditmemo->getIncrementId());
            /* Add table head */
            $this->_drawHeader($page);
            /* Add body */
            foreach ($creditmemo->getAllItems() as $item) {
                if ($item->getOrderItem()->getParentItem()) {
                    continue;
                }
                /* Draw item */
                $this->_drawItem($item, $page, $order);
                $page = end($pdf->pages);
            }
            // GIFT WRAP INFO

            $giftWrapInfo = unserialize($order->getData('gift_wrap_info'));
            if(is_array($giftWrapInfo)){
                // $this->y -= 10;
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $productModel = $objectManager->get('Magento\Catalog\Model\Product');
                $giftWrapModel = $objectManager->get('Dtn\Wrapping\Model\Giftwrap');
                $priceHelper = $objectManager->get('Magento\Framework\Pricing\Helper\Data');
                $this->_drawGiftHeading($page);
                $this->_drawGiftHeader($page);
                foreach ($giftWrapInfo as $giftWrap) {
                    foreach ($giftWrap as $giftWrapVal) {

                        // print_r($giftWrapVal['giftwrap_id']); die();
                        if(is_array($giftWrapVal)){
                            if (array_key_exists('is_giftwrap', $giftWrapVal) && !($giftWrapVal['is_giftwrap'])) {
                                continue;
                            }
                            $giftWrapData = $giftWrapModel->load($giftWrapVal['giftwrap_id'])->getData();
                            $productData = $productModel->load($productModel->getIdBySku($giftWrapVal['sku']));
                            $giftMessage = $giftWrapVal['message'];
                            $this->_drawGiftItem($page, $giftWrapData, $productData, $giftMessage, $priceHelper);
                        }
                    }
                }
                $this->insertTotalsIncludingGift($page, $creditmemo, $priceHelper);
            } else{
                /* Add totals */
                $this->insertTotals($page, $creditmemo);
            }
        }
        $this->_afterGetPdf();
        if ($creditmemo->getStoreId()) {
            $this->_localeResolver->revert();
        }
        return $pdf;
    }

}
