<?php

namespace Egio\Testimonials\Controller\Adminhtml\Manage;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Egio\Testimonials\Model\ResourceModel\Testimonial\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;

class MassApprove extends \Magento\Backend\App\Action
{

    protected $filter;
    protected $collectionFactory;

    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        foreach ($collection as $item) {
            $item->setStatus(1);
            $item->save();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been approved.', $collection->getSize()));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/testimonials/index');
    }
}
