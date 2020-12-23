<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\Grid\Controller\Adminhtml\Index;

use Magento\Framework\App\ResponseInterface;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;
use TrainingBansi\Grid\Model\Post;

/**
 * Catalog index page controller.
 */
class Save extends \Magento\Backend\App\Action
{
    protected $forwardfactory;
    protected $model;
    protected $redirectFactory;
    
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        ForwardFactory $forwardfactory,
        Post $post,
        RedirectFactory $redirectFactory
    ) {
        parent::__construct($context);
        $this->forwardfactory = $forwardfactory;
        $this->redirectFactory = $redirectFactory;
        $this->model=$post;
    }

    public function execute()
    {
        $data=$this->getRequest()->getPostValue();
        $resultforward = $this->forwardfactory->create();
        $resultredirect = $this->redirectFactory->create();
     
        if ($data) {
            $id=$this->getRequest()->getparam('id');
            if ($id) {
                $model=$this->model->load($id);
            }
            if (isset($data['category_id'])) {
                $data['category_id'] = is_array($data['category_id']) ? implode(',', $data['category_id']) : $data['category_id'];
            }
            $model=$this->model->setData($data);
        }
        try {
            $model->save();
            $this->messageManager->addSuccessMessage(__('Post Saved Successfully'));
            $this->_getSession()->setFormData(false);
            if ($this->getRequest()->getparam('back')) {
                return $resultredirect->setPath('*/*/edit', ['id'=>$model->getId(),'_current'=>true]);
            }
            return $resultredirect->setPath('*/*/index');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $resultredirect->setPath('*/*/index');
    }
}
