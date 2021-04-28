<?php


namespace Egio\Testimonials\Model;

use Magento\Framework\Model\AbstractModel;

class Data extends AbstractModel
{

    protected function _construct()
    {
        $this->_init(
            \Egio\Testimonials\Model\ResourceModel\Testimonial::class
        );
    }
}
