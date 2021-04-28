<?php

namespace Egio\Testimonials\Model\ResourceModel\Module;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Egio\Testimonials\Model\Module::class,
            \Egio\Testimonials\Model\ResourceModel\Module::class
        );
    }
}
