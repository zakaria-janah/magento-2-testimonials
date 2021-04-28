<?php

namespace Egio\Testimonials\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Testimonial extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('egio_testimonials', 'testimonial_id');
    }
}
