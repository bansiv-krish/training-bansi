<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\Grid\Model\Index;

use Magento\Ui\DataProvider\AbstractDataProvider;
use TrainingBansi\Grid\Model\ResourceModel\Post\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    protected $collectionFactory;
    protected $loadedData;
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
       
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
    
    public function getData()
    {
    
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items=$this->collection->getItems();

        $this->loadedData=[];
        foreach ($items as $item) {
            $this->loadedData[$item->getId()]=$item->getData();
        }
         
        return $this->loadedData;
    }
}
