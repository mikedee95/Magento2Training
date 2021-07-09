<?php

namespace Dtn\Giftwrap\Controller\AbstractController;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;

interface GiftwrapLoaderInterface
{
    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Dtn\Giftwrap\Model\Giftwrap
     */
    public function load(RequestInterface $request, ResponseInterface $response);
}
