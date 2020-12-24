<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\Grid\Block;

use Magento\Framework\App\Filesystem\DirectoryList;
 
class Index extends \Magento\Framework\View\Element\Template
{
     protected $_filesystem;
 
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \TrainingBansi\Grid\Model\PostFactory $postFactory
    ) {
         parent::__construct($context);
         $this->_postFactory = $postFactory;
    }
 
    public function getResult()
    {
         $post = $this->_postFactory->create();
         $collection = $post->getCollection();
         return $collection;
    }
}
