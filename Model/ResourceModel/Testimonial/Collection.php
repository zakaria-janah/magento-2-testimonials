<?php


namespace Egio\Testimonials\Model\ResourceModel\Testimonial;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(
            \Egio\Testimonials\Model\Data::class,
            \Egio\Testimonials\Model\ResourceModel\Testimonial::class
        );
    }

    public function getIdFieldName()
    {
        return 'testimonial_id';
    }
}
