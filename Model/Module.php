<?php

namespace Egio\Testimonials\Model;

use Magento\Framework\Model\AbstractModel;

class Module extends AbstractModel
{

    protected function _construct()
    {
        $this->_init(\Egio\Testimonials\Model\ResourceModel\Module::class);
    }
}
