<?php
namespace TrainingBansi\CustomerLoginIp\Plugin;

use Magento\Framework\HTTP\PhpEnvironment\Request;
use Magento\Framework\App\Action\Context;
use TrainingBansi\CustomerLoginIp\Model\ResourceModel\CustomerIpAddress\CollectionFactory;
use Magento\Framework\Controller\Result\RedirectFactory;

class LoginPrevent
{
    /**
     * @var \Magento\Framework\HTTP\PhpEnvironment\Request
     */
    protected $_request;
    /**
     * @var \TrainingBansi\CustomerLoginIp\Model\ResourceModel\CustomerIpAddress\CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $resultRedirectFactory;
    /**
     * @var \Magento\Framework\App\Action\Context
     */
    protected $context;
     /**
      * Initialize LoginPrevent plugin
      * @param Request $request
      * @param CollectionFactory $collectionFactory
      * @param RedirectFactory $resultRedirectFactory
      * @param Context $context
      */
    public function __construct(Request $request, CollectionFactory $collectionFactory, RedirectFactory $resultRedirectFactory, Context $context)
    {
          $this->_request= $request;
          $this->resultRedirectFactory= $resultRedirectFactory;
          $this->collection = $collectionFactory->create();
          $this->messageManager = $context->getMessageManager();
    }
    /**
     *
     * @param \Magento\Customer\Controller\Account\LoginPost $register
     * @param callable $proceed
     * @return redirect | callable $proceed
     */
    public function aroundExecute(\Magento\Customer\Controller\Account\LoginPost $register, callable $proceed)
    {
        $ip_address =$this->_request->getClientIp();
        $items=$this->collection->getItems();
        $ip_address_array=[];
        foreach ($items as $item) {
                $ip_address_array[]=$item->getIp();
        }
        if (in_array($ip_address, $ip_address_array)) {
            return $proceed();
        } else {
            $this->messageManager->addErrorMessage(__('Ip Address is not alllowed to login.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('*/*/');
            return $resultRedirect;
        }
    }
}
