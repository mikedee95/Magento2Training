<?php

namespace Dtn\Wrapping\Controller\AbstractController;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;

interface GiftWrapLoaderInterface
{
    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Dtn\Wrapping\Model\GiftWrap
     */

    public function load(RequestInterface $request, ResponseInterface $response)
}