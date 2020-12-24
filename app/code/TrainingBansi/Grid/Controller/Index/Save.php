<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\Grid\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
 
class Save extends \Magento\Framework\App\Action\Action
{
     protected $_pageFactory;
     protected $_postFactory;
     protected $_filesystem;
 
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \TrainingBansi\Grid\Model\PostFactory $postFactory,
        \Magento\Framework\Filesystem $filesystem
    ) {
         $this->_pageFactory = $pageFactory;
         $this->_postFactory = $postFactory;
         $this->_filesystem = $filesystem;
         return parent::__construct($context);
    }
 
    public function execute()
    {
        if ($this->getRequest()->isPost()) {
             $input = $this->getRequest()->getPostValue();
             $post = $this->_postFactory->create();
 
            if (isset($input['editRecordId']) && !empty($input['editRecordId'])) {
                    $post->load($input['editRecordId']);
                    $post->addData($input);
                    $post->setId($input['editRecordId']);
                    $post->save();
            } else {
                 $post->setData($input)->save();
            }
 
            return $this->_redirect('frontgrid/index/index');
        }
    }
}
