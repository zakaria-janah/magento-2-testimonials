<?php

namespace Egio\Testimonials\Controller\Adminhtml\Manage;

class Edit extends \Magento\Backend\App\Action
{

    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('testimonial_id');
        $resultPage = $this->resultPageFactory->create();

        $resultPage->getConfig()->getTitle()
            ->prepend($id ? __('Edit Testimonial') : __('Add New Testimonial'));
        $resultPage->setActiveMenu('Egio_Testimonials::testimonials_manage');
        
        return $resultPage;
    }
}
