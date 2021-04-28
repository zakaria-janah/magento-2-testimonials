<?php

namespace Egio\Testimonials\Controller\Adminhtml\Manage;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action
{

    protected $resultPageFactory = false;
    protected $testimonialLoader;
    protected $helperData;
    protected $imageUploader;

    const ALLOWED_TYPES = ['jpg','jpeg','doc','docx'];
    const PATH_TO_SAVE = 'testimonial/';

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Egio\Testimonials\Model\Data $testimonialLoader,
        \Egio\Testimonials\Helper\General $helperData,
        \Magento\Catalog\Model\ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->testimonialLoader = $testimonialLoader;
        $this->helperData = $helperData;
        $this->imageUploader = $imageUploader;
    }

    public function execute()
    {

        $resultRedirect = $this->resultRedirectFactory->create();

        $id = $this->getRequest()->getParam("testimonial_id");
        $message = $this->getRequest()->getParam("message");
        $title = $this->getRequest()->getParam("title");
        $status = $this->getRequest()->getParam("status");
        $sortOrder = $this->getRequest()->getParam("sort_order");
        $storeViews = $this->getRequest()->getParam("store_view");
        $imageDoc = $this->getRequest()->getParam("image_doc");

        try {
        
            $item = $this->testimonialLoader->load($id);

            $item->setMessage($message);
            $item->setTitle($title);
            $item->setStatus($status);
            $item->setSortOrder($sortOrder);

            if ($storeViews) {
                $temp = [];
                foreach ($storeViews as $storeView) {
                    $temp[] = $storeView;
                }

                $item->setStoreView(implode(',', $temp));
            }

            if (!empty($imageDoc)) {

                if (!isset($imageDoc[0]['image_doc'])) {

                    if (!empty($item->getImageDoc())) {
                        if (!$this->removeUploadedFile($item->getImageDoc())) {
                            $this->messageManager->addErrorMessage(__('The file cannot be deleted due to an error.'));
                        } else {
                            $item->setImageDoc(null);
                        }
                    }

                    if ($imageDoc[0]['size'] > 1000000) {
                        $result = ['error' => __('The file size exceeds the limit allowed and cannot be saved.')];

                    } else {

                        $imageDocName = $imageDoc[0]['name'];

                        if (isset($imageDoc[0]['tmp_name'])) {
                            $this->imageUploader->moveFileFromTmp($imageDocName);
                        }
                        
                        $item->setImageDoc('/' . $imageDocName);
                    }
                }
            } else {
                if (!empty($item->getImageDoc())) {
                    if (!$this->removeUploadedFile($item->getImageDoc())) {
                        $this->messageManager->addErrorMessage(__('The file cannot be deleted due to an error.'));
                    } else {
                        $item->setImageDoc(null);
                    }
                }
            }

            if (isset($result) && key($result) == 'error') {
                $this->messageManager->addErrorMessage($result['error']);

            } else {
                
                $item->save();
                $this->messageManager->addSuccessMessage(
                    __('Record updated successfully.')
                );
            }

            } catch (\Exception $e) {

                $this->messageManager->addErrorMessage(
                    __('An error occurred while processing the data. Please try again.')
                );
                $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $redirect->setUrl($this->_redirect->getRefererUrl());
                
                return $resultRedirect->setPath('*/testimonials/index');
            }

        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl($this->_redirect->getRefererUrl());

        return $resultRedirect->setPath('*/testimonials/index');
    }

    protected function removeUploadedFile($imageDoc) {
        
        $mediaPath = $this->helperData->getMediaPath();
        $filePath = $mediaPath . $imageDoc;

        if (is_file($filePath)) {
            if (unlink($filePath)) {
                return true;
            } else {
                return false;
            }
        } 
    }
}
