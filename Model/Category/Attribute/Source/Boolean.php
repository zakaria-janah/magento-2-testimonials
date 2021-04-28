<?php

namespace Egio\Testimonials\Model\Category\Attribute\Source;

class Boolean implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [
            ['value' => 'Yes', 'label' => 'Yes'],
            ['value' => 'No', 'label' => 'No']
        ];
    }
}
