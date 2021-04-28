<?php

namespace Egio\Testimonials\Model\ResourceModel;

class Module extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        $this->_init('egio_testimonials', 'testimonial_id');
    }
}
