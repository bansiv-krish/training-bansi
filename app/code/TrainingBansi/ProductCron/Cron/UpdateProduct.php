<?php

namespace TrainingBansi\ProductCron\Cron;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Api\CategoryLinkManagementInterface;

class UpdateProduct
{
    protected $productCollectionFactory;
    protected $catalogLink;

    public function __construct(CollectionFactory $productCollectionFactory, CategoryLinkManagementInterface $catalogLink)
    {
        $this->productCollectionFactory=$productCollectionFactory;
        $this->catalogLink=$catalogLink;
    }
    public function execute()
    {
        $to = strtotime(date("Y-m-d"));
        $from = strtotime('-3 day', $to);
        $from = date('Y-m-d h:i:s', $from);
        $to = date('Y-m-d h:i:s', $to);
        
        $collection = $this->productCollectionFactory->create();
        $collection->addFieldToFilter('created_at', ['gteq' => $from])
        ->addFieldToFilter('created_at', ['lteq' => $to]);
        $collection->addAttributeToSelect('*');
        $collection->setPageSize(10);
        $categoryIds = ['3','4'];
       
        foreach ($collection as $product) {
            $sku = $product->getSku();
            $this->catalogLink->assignProductToCategories($sku, $categoryIds);
            
        }
        return $this;
    }
}
