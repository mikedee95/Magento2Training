<?php

namespace Dtn\Wrapping\Controller\AbstractController;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Registry;

class GiftWrapLoader implements GiftWrapLoaderInterface
{
    /**
     * @var \Dtn\Wrapping\Model\GiftWrapFactory
     */
    protected $giftWrapFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;

    /**
     * @param \Dtn\Wrapping\Model\GiftWrapFactory $giftWrapFactory
     * @param OrderViewAuthorizationInterface $orderAuthorization
     * @param Registry $registry
     * @param \Magento\Framework\UrlInterface $url
     */
    public function __construct(
        \Dtn\Wrapping\Model\GiftWrapFactory $giftWrapFactory,
        Registry $registry,
        \Magento\Framework\UrlInterface $url
    ) {
        $this->giftWrapFactory = $giftWrapFactory;
        $this->registry = $registry;
        $this->url = $url;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return bool
     */
    public function load(RequestInterface $request, ResponseInterface $response)
    {
        $id = (int)$request->getParam('id');
        if (!$id) {
            $request->initForward();
            $request->setActionName('noroute');
            $request->setDispatched(false);
            return false;
        }

        $giftwrap = $this->giftWrapFactory->create()->load($id);
        $this->registry->register('current_giftwrap', $giftwrap);
        return true;
    }
}
