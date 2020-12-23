<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\Grid\Controller\Adminhtml\Index;

use Magento\Ui\Component\MassAction\Filter;
use TrainingBansi\Grid\Model\ResourceModel\Post\CollectionFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;

/**
 * Catalog index page controller.
 */
class MassDelete extends \Magento\Backend\App\Action
{
    protected $filter;
    protected $collectionFactory;
    protected $rediretFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        RedirectFactory $rediretFactory
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->rediretFactory = $rediretFactory;
    }

    public function execute()
    {
       
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        foreach ($collection as $item) {
            $item->delete();
        }
    
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));

        $resultReditect=$this->rediretFactory->create();
        return $resultReditect->setPath('*/*/index');
    }
}
