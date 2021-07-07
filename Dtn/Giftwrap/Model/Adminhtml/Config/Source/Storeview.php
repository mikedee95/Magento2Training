<?php

namespace Dtn\Giftwrap\Model\Adminhtml\Config\Source;

class Storeview implements \Magento\Framework\Option\ArrayInterface
{
	public function toOptionArray()
    {
    	/** @var \Magento\Framework\App\ObjectManager $objectManager */
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		/** @var \Magento\Store\Model\StoreManagerInterface|\Magento\Store\Model\StoreManager $storeManager */
		$storeManager = $objectManager->get('Magento\Store\Model\StoreManagerInterface');
		$stores = $storeManager->getStores();
		$optionArray[0] = __('All Store Views');
		foreach ($stores as $store) {
			$optionArray[$store->getId()] = $store->getName();
		}
        return $optionArray;

    }
}
