<?php

namespace Product\Inquiry\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{

    public $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Product_Inquiry::inquiry_manage'
        )->addBreadcrumb(
            __('Inquiry'),
            __('Inquiry')
        )->addBreadcrumb(
            __('Manage Inquiry'),
            __('Manage Inquiry')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Inquiry'));
        return $resultPage;
    }
}
