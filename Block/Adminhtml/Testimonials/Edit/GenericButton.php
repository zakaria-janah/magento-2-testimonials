<?php

namespace Egio\Testimonials\Block\Adminhtml\Testimonials\Edit;

class GenericButton
{
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context
    ) {
        $this->context = $context;
    }

    public function getBackUrl()
    {
        return $this->getUrl('*/testimonials/');
    }

    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['object_id' => $this->getObjectId()]);
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
    
    public function getObjectId()
    {
        return $this->context->getRequest()->getParam('post_id');
    }
}
