<?php

namespace Egio\Testimonials\Helper;

use Magento\Framework\File\Uploader;

class General extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $scopeConfig;
    protected $storeManager;
    protected $directoryList;

    const PATH_TO_SAVE = 'testimonial';

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->directoryList = $directoryList;
    }

    public function getConfigData()
    {
        return $this->scopeConfig
            ->getValue('testimonial/general/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getStoreId()
    {
        return $this->storeManager->getStore()->getStoreId();
    }

    public function getMediaUrl()
    {
        $mediaUrl = $this ->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . self::PATH_TO_SAVE;
        return $mediaUrl;
    }

    public function getMediaPath()
    {
        $path = $this->directoryList->getPath('media') . '/' . self::PATH_TO_SAVE;
        return str_replace("//", "/", $path);
    }
}
