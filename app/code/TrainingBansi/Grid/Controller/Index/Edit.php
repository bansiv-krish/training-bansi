<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\Grid\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Catalog index page controller.
 */
class Edit extends \Magento\Framework\App\Action\Action
{
     protected $_pageFactory;
     protected $_request;
     protected $_coreRegistry;
 
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Registry $coreRegistry
    ) {
         $this->_pageFactory = $pageFactory;
         $this->_request = $request;
         $this->_coreRegistry = $coreRegistry;
         return parent::__construct($context);
    }
 
    public function execute()
    {
        $id = $this->_request->getParam('id');
        $this->_coreRegistry->register('editRecordId', $id);
         return $this->_pageFactory->create();
    }
}
