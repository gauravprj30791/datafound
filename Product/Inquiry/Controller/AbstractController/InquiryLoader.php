<?php

namespace Product\Inquiry\Controller\AbstractController;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Registry;

class InquiryLoader implements InquiryLoaderInterface
{

    public $inquiryFactory;

    public $registry;

    public $url;

    public function __construct(
        \Product\Inquiry\Model\InquiryFactory $inquiryFactory,
        Registry $registry,
        \Magento\Framework\UrlInterface $url
    ) {
        $this->inquiryFactory = $inquiryFactory;
        $this->registry = $registry;
        $this->url = $url;
    }

    public function load(RequestInterface $request)
    {
        $id = (int)$request->getParam('id');
        if (!$id) {
            $request->initForward();
            $request->setActionName('noroute');
            $request->setDispatched(false);
            return false;
        }

        $inquiry = $this->inquiryFactory->create()->load($id);
        $this->registry->register('current_inquiry', $inquiry);
        return true;
    }
}
