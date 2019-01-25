<?php

namespace Product\Inquiry\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    const XML_PATH_ITEMS_PER_PAGE     = 'inquiry/view/items_per_page';

    const MEDIA_PATH    = 'Inquiry';

    const MAX_FILE_SIZE = 1048576;

    const MIN_HEIGHT = 50;

    const MAX_HEIGHT = 8000;

    const MIN_WIDTH = 50;

    const MAX_WIDTH = 4024;

    public $imageSize   = [
        'minheight'     => self::MIN_HEIGHT,
        'minwidth'      => self::MIN_WIDTH,
        'maxheight'     => self::MAX_HEIGHT,
        'maxwidth'      => self::MAX_WIDTH,
    ];

    public $mediaDirectory;

    public $filesystem;

    public $httpFactory;

    public $fileUploaderFactory;

    public $ioFile;

    public $storeManager;

    public $scopeConfig;
    /**
     * @var string
     */
    protected $temp_id;

    protected $inlineTranslation;
    /**
     * @param Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     */

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\HTTP\Adapter\FileTransferFactory $httpFactory,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Framework\Filesystem\Io\File $ioFile,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Image\Factory $imageFactory
    ) {
        $this->scopeConfig = $context->getScopeConfig();
        $this->filesystem = $filesystem;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->httpFactory = $httpFactory;
        $this->fileUploaderFactory = $fileUploaderFactory;
        $this->ioFile = $ioFile;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $inlineTranslation;
        $this->_imageFactory = $imageFactory;
        parent::__construct($context);
        $this->_transportBuilder = $transportBuilder;
        $this->_storeManager = $storeManager;
    }

    public function getStore()
    {
        return $this->_storeManager->getStore();
    }

    public function generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        $template =  $this->_transportBuilder->setTemplateIdentifier($this->temp_id)
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND, /* here you can defile area and
                                                                                 store of template 
                                                                                 for which you prepare it */
                        'store' => $this->_storeManager->getStore()->getId(),
                    ]
                )
                ->setTemplateVars($emailTemplateVariables)
                ->setFrom($senderInfo)
                ->addTo($receiverInfo['email'], $receiverInfo['name']);
                return $this;
    }

    public function sendEmail($templatePath, $emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        
        $this->temp_id = $this->getTemplateId($templatePath);
        $this->inlineTranslation->suspend();
        $this->generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo);
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();
        $this->inlineTranslation->resume();
    }

    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ) . '/' . self::MEDIA_PATH;
    }

    public function getInquiryPerPage()
    {
        return abs(
            (int)$this->scopeConfig->getValue(
                self::XML_PATH_ITEMS_PER_PAGE,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            )
        );
    }
}
