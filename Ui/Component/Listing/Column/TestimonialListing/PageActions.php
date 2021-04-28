<?php

namespace Egio\Testimonials\Ui\Component\Listing\Column\TestimonialListing;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class PageActions extends Column
{

    const TESTIMONIAL_URL_PATH_EDIT = 'testimonial/manage/edit';
    const TESTIMONIAL_URL_PATH_DELETE = 'testimonial/manage/delete';

    protected $urlBuilder;
    protected $editUrl;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::TESTIMONIAL_URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource["data"]["items"])) {
            foreach ($dataSource["data"]["items"] as & $item) {
                $name = $this->getData('name');
                if (isset($item['testimonial_id'])) {
                    $item[$name]['view'] = [
                        'href' => $this->urlBuilder
                            ->getUrl($this->editUrl, ['testimonial_id' => $item['testimonial_id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder
                            ->getUrl(
                                self::TESTIMONIAL_URL_PATH_DELETE,
                                ['testimonial_id' => $item['testimonial_id']]
                            ),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete testimonial'),
                            'message' => __('Are you sure you wan\'t to delete this record?')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
