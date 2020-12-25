<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\CustomerLoginIp\Controller\Adminhtml\Index;

use Magento\Framework\App\ResponseInterface;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;
use TrainingBansi\CustomerLoginIp\Model\CustomerIpAddress;

/**
 * Catalog index page controller.
 */
class Delete extends \Magento\Backend\App\Action
{
    protected $forwardfactory;
    protected $model;
    protected $redirectFactory;
   
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        ForwardFactory $forwardfactory,
        CustomerIpAddress $customeripaddress,
        RedirectFactory $redirectFactory
    ) {
        parent::__construct($context);
        $this->forwardfactory = $forwardfactory;
        $this->redirectFactory = $redirectFactory;
        $this->model=$customeripaddress;
    }

    public function execute()
    {
        $resultredirect = $this->redirectFactory->create();
        $id=$this->getRequest()->getparam('id');
        if ($id) {
            $model=$this->model;
            $model->load($id);
            try {
                $model->delete();
                  $this->messageManager->addSuccessMessage(__('Ip Address Deleted Successfully'));
                  return $resultredirect->setPath('*/*/index');
            } catch (\Exception $e) {
                 $this->messageManager->addErrorMessage($e->getMessage());
                   return $resultredirect->setPath('*/*/edit', ['id'=>$model->getId(),'_current'=>true]);
            }
        }
        return $resultredirect->setPath('*/*/index');
    }
}
