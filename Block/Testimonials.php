<?php

namespace Egio\Testimonials\Block;

class Testimonials extends \Magento\Framework\View\Element\Template
{
    protected $moduleFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Egio\Testimonials\Model\ModuleFactory $moduleFactory,
        array $data = []
    ) {
        $this->moduleFactory = $moduleFactory;
        parent::__construct($context, $data);
    }

    public function getTestimonials()
    {
        $collection = $this->moduleFactory->create()->getCollection();
        $collection->addFieldToFilter('status', ['eq' => 1]);
        $collection->setOrder('sort_order', 'DESC');

        return $collection;
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getTestimonials()) {
            $this->getTestimonials()->load();
        }
        return $this;
    }

}
