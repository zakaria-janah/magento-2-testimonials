<?php

namespace Egio\Testimonials\Model;

use Egio\Testimonials\Model\ResourceModel\Testimonial\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $collection;
    protected $dataPersistor;
    protected $loadedData;
    protected $helperData;
    protected $assetRepo;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        \Egio\Testimonials\Helper\General $helperData,
        \Magento\Framework\View\Asset\Repository $assetRepo,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->helperData = $helperData;
        $this->assetRepo = $assetRepo;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        foreach ($items as $item) {

            if ($item->getData('image_doc') !== null) {
                
                $mediaUrl = $this->helperData->getMediaUrl();
                $mediaPath = $this->helperData->getMediaPath();

                $docImgUrl = $this->assetRepo->getUrl('Egio_Testimonials::images/document.png');
                $fileUrl = $mediaUrl . $item->getData('image_doc');
                $filePath = $mediaPath . $item->getData('image_doc');

                $mystring = '';
                if(is_file($filePath)) {
                    $mystring = mime_content_type($filePath);
                }
                $findme   = 'image';
                $pos = strpos($mystring, $findme);

                if ($pos !== false) {
                    $imageUrl = $fileUrl;
                } else {
                    $imageUrl = $docImgUrl;
                }

                $img = [];
                $img[0]['image_doc'] = $item->getData('image_doc');
                $img[0]['url'] = $imageUrl;
                $img[0]['size'] = '360';

                $item->setImageDoc($img);
            }

            $this->loadedData[$item->getId()] = $item->getData();
        }

        $data = $this->dataPersistor->get('egio_testimonials');
        if (!empty($data)) {
            $item = $this->collection->getNewEmptyItem();
            $item->setData($data);
            $this->loadedData[$item->getTestimonial_id()] = $item->getData();
            $this->dataPersistor->clear('egio_testimonials');
        }

        return $this->loadedData;
    }
}
