<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\Grid\Block;

use Magento\Framework\App\Filesystem\DirectoryList;

class Create extends \Magento\Framework\View\Element\Template
{
     protected $_pageFactory;
     
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
         $this->_pageFactory = $pageFactory;
         return parent::__construct($context);
    }
 
    public function execute()
    {
         return $this->_pageFactory->create();
    }
}
