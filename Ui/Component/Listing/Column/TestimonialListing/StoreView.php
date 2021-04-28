<?php

namespace Egio\Testimonials\Ui\Component\Listing\Column\TestimonialListing;

use Magento\Ui\Component\Listing\Columns\Column;

class StoreView extends Column
{

    public function prepareDataSource(array $dataSource)
    {

        $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();        
        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');

        if (isset($dataSource['data']['items'])) {

            foreach ($dataSource['data']['items'] as &$item) {

                if (isset($item['store_view']) && !empty($item['store_view'])) {
                    $storeViews = explode(',', $item['store_view']);

                    $storeViewsArr = [];
                    foreach ($storeViews as $storeView) {

                        $store = $storeManager->getStore($storeView);
                        $storeViewsArr[] = $store->getName();
                    }

                    $item['store_view'] = implode(', ', $storeViewsArr);
                }
            }
        }

        return $dataSource;
    }
}
