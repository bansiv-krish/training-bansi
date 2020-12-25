<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\CustomerLoginIp\Controller\Adminhtml\Index;

use Magento\Framework\App\ResponseInterface;
use TrainingBansi\CustomerLoginIp\Model\CustomerIpAddress;
use Magento\Framework\Registry;

class Edit extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;
    protected $customeripaddress;
    protected $registry;
       
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        CustomerIpAddress $customeripaddress,
        Registry $registry
    ) {
        parent::__construct($context);
        $this->customeripaddress=$customeripaddress;
        $this->resultPageFactory = $resultPageFactory;
         $this->registry = $registry;
    }

    public function execute()
    {
        
        $id=$this->getRequest()->getparam('id');
        $model=$this->customeripaddress;

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Ip does not exist'));
                $result=$this->resultRedirectFactory->create();
                return $result->setPath('customeripgrid/index/index/');
            }
        }
   
        $data=$this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        
        $this->registry->register('customeripaddress', $model);
        $resultpage=$this->resultPageFactory->create();
        
        if ($id) {
            $resultpage->getConfig()->getTitle()->prepend('Edit');
        } else {
            $resultpage->getConfig()->getTitle()->prepend('Add');
        }
        return $resultpage;
    }
}
