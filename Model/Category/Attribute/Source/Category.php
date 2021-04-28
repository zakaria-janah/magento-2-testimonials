<?php

namespace Egio\Testimonials\Model\Category\Attribute\Source;

class Category implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('Pending')],
            ['value' => 1, 'label' => __('Approved')],
            ['value' => 2, 'label' => __('Disapproved')]
        ];
    }
}
