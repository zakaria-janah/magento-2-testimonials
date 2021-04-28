<?php

namespace Egio\Testimonials\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $pageFactory;
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->pageFactory = $pageFactory;
        $this->scopeConfig = $scopeConfig;
        return parent::__construct($context);
    }

    public function execute()
    {
        if (!$this->getConfigData()) {
            return $this->_redirect('404notfound');
        }
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }

    public function getConfigData()
    {
        return $this->scopeConfig
            ->getValue('testimonial/general/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
