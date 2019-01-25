<?php

namespace Product\Inquiry\Controller\Index;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Product\Inquiry\Model\InquiryFactory;

class Save extends \Magento\Framework\App\Action\Action
{

    public $pageFactory;
    public $modelNewsFactory;
    public $transportBuilder;
    public $inlineTranslation;
    public $storeManager;
    public $escaper;
    public $request;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        InquiryFactory $modelNewsFactory,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Escaper $escaper
    ) {
        $this->pageFactory = $pageFactory;
        $this->modelNewsFactory = $modelNewsFactory;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager;
        $this->escaper = $escaper;
        $this->request = $context->getRequest();
        return parent::__construct($context);
    }

    public function execute()
    {

        $post = $this->getRequest()->getPostValue();
        if (!$post) {
            $this->_redirect($this->request->getServer('HTTP_REFERER'));
            return;
        }
        
        try {
            $data = $this->getRequest()->getPost();
            $toEmail = $data['to_email'];
            $newsModel = $this->modelNewsFactory->create();
            $newsModel->setFirstName($data['first_name']);
            $newsModel->setLastName($data['last_name']);
            $newsModel->setEmail($data['email']);
            $newsModel->setTelephone($data['telephone']);
            $newsModel->setComment($data['comment']);
            $newsModel->setProductId($data['product_id']);
            $newsModel->setProductName($data['product_name']);
            $newsModel->setProductSku($data['product_sku']);
            $newsModel->save();
            $templateOptions = ['area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => $this->storeManager->getStore()->getId()];
                    $name = trim($post['first_name'])." ".trim($post['last_name']);
                    $email = trim($post['email']);
                    $telephone = trim($post['telephone']);
                    $productId = trim($post['product_id']);
                    $productName = trim($post['product_name']);
                    $productSku = trim($post['product_sku']);
                    $templateVars = [
                        'store' => $this->storeManager->getStore(),
                        'name' => $name,
                        'email'   => $email,
                        'telephone'   => $telephone,
                        'message'   => trim($post['comment']),
                        'product_id' => $productId,
                        'product_name' => $productName,
                        'product_sku' => $productSku
                    ];
                    $this->messageManager->addSuccess(
                        __("Thanks for contacting us with your comments and questions. We'll respond to you very soon.")
                    );
            $this->_redirect($this->request->getServer('HTTP_REFERER'));
        } catch (\Exception $e) {
            $this->messageManager->addError(
                __('We can\'t process your request right now. Sorry, that\'s all we know.')
            );
            $this->_redirect($this->request->getServer('HTTP_REFERER'));
            return;
        }
    }
}
