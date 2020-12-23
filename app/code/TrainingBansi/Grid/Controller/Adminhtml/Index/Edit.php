<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\Grid\Controller\Adminhtml\Index;

use Magento\Framework\App\ResponseInterface;
use TrainingBansi\Grid\Model\Post;
use Magento\Framework\Registry;

class Edit extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;
    protected $post;
    protected $registry;
       
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Post $post,
        Registry $registry
    ) {
        parent::__construct($context);
        $this->post=$post;
        $this->resultPageFactory = $resultPageFactory;
         $this->registry = $registry;
    }

    public function execute()
    {
        
        $id=$this->getRequest()->getparam('id');
        $model=$this->post;

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This post does not exist'));
                $result=$this->resultRedirectFactory->create();
                return $result->setPath('admingrid/index/index/');
            }
        }
   
        $data=$this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        
        $this->registry->register('post', $model);
        $resultpage=$this->resultPageFactory->create();
        
        if ($id) {
            $resultpage->getConfig()->getTitle()->prepend('Edit');
        } else {
            $resultpage->getConfig()->getTitle()->prepend('Add');
        }
        return $resultpage;
    }
}
