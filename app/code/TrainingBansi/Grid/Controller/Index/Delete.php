<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\Grid\Controller\Index;

class Delete extends \Magento\Framework\App\Action\Action
{
     protected $_pageFactory;
     protected $_request;
     protected $_postFactory;
 
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\App\Request\Http $request,
        \TrainingBansi\Grid\Model\PostFactory $postFactory
    ) {
         $this->_pageFactory = $pageFactory;
         $this->_request = $request;
         $this->_postFactory = $postFactory;
         return parent::__construct($context);
    }
 
    public function execute()
    {
         $id = $this->_request->getParam('id');
         $post = $this->_postFactory->create();
         $result = $post->setId($id);
         $result = $result->delete();
         return $this->_redirect('frontgrid/index/index');
    }
}
