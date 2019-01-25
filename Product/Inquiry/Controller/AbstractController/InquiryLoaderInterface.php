<?php

namespace Product\Inquiry\Controller\AbstractController;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;

interface InquiryLoaderInterface
{
    public function load(RequestInterface $request);
}
