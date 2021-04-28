<?php

namespace Egio\Testimonials\Controller\AddNew;

use Magento\Framework\App\Filesystem\DirectoryList;

class Add extends \Magento\Framework\App\Action\Action
{
    protected $pageFactory;
    protected $dataPersistor;
    protected $dateTime;
    protected $testimonialLoader;
    protected $helperData;

    const ALLOWED_TYPES = ['jpg','jpeg','doc','docx'];
    const PATH_TO_SAVE = 'testimonial/';

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Egio\Testimonials\Model\Data $testimonialLoader,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Egio\Testimonials\Helper\General $helperData
    ) {
        $this->pageFactory = $pageFactory;
        $this->dataPersistor = $dataPersistor;
        $this->dateTime = $dateTime;
        $this->testimonialLoader = $testimonialLoader;
        $this->helperData = $helperData;
        return parent::__construct($context);
    }

    public function execute()
    {
        $post = $this->getRequest()->getPostValue();

        if (!$post) {
            $this->_redirect($this->_redirect->getRefererUrl());
            return;

        } else {
            
            $dataPersistors = $this->dataPersistor;
            $datetime = $this->dateTime;
            $date = $datetime->gmtDate('Y-m-d');
            $item = $this->testimonialLoader;

            try {
                $item->setTitle($post['title']);
                $item->setMessage($post['message']);
                $item->setStatus(0);
                $item->setStoreView($this->helperData->getStoreId());

                if (isset($_FILES['formimagedoc']['name']) && !empty($_FILES['formimagedoc']['name'])) {

                    if ($_FILES['formimagedoc']['size'] > 1000000) {
                        $result = ['error' => __('The file size exceeds the limit allowed and cannot be saved.')];

                    } else {

                        $uploader = $this->_objectManager->create(
                            'Magento\MediaStorage\Model\File\Uploader',
                            ['fileId' => 'formimagedoc']
                        );
                        $uploader->setAllowedExtensions(self::ALLOWED_TYPES);
                        $uploader->setAllowRenameFiles(true);
                        $uploader->setAllowCreateFolders(true);
                        $uploader->setFilesDispersion(true);
                        $ext = pathinfo($_FILES['formimagedoc']['name'], PATHINFO_EXTENSION);

                        if ($uploader->checkAllowedExtension($ext)) {

                            $path = $this->_objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(DirectoryList::MEDIA)
                                ->getAbsolutePath(self::PATH_TO_SAVE);
                            $uploader->save($path);
                            $fileName = $uploader->getUploadedFileName();

                            if ($fileName) {
                                $item->setImageDoc($fileName);
                            }

                        } else {
                            $result = ['error' => __('Disallowed file type.')];
                        }
                    }
                }

                if (isset($result) && key($result) == 'error') {

                    $this->messageManager->addErrorMessage($result['error']);
                    $dataPersistors->set('testimonial', $this->getRequest()->getParams());

                    return $this->resultRedirectFactory->create()->setPath('testimonials');

                } else {
                    
                    $item->save();
                    $this->messageManager->addSuccessMessage(
                        __('Thanks for your valuable time.')
                    );
                    $dataPersistors->clear('testimonials');

                    return $this->resultRedirectFactory->create()->setPath('testimonials');   
                }

            } catch (\Exception $e) {

                $this->messageManager->addErrorMessage(
                    __('An error occurred while processing your data. Please try again.')
                );
                $dataPersistors->set('testimonial', $this->getRequest()->getParams());

                return $this->resultRedirectFactory->create()->setPath('testimonials');
            }

        }
    }
}
