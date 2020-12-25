<?php
namespace TrainingBansi\CustomerLoginIp\Plugin;

use Magento\Framework\HTTP\PhpEnvironment\Request;
use TrainingBansi\CustomerLoginIp\Model\ResourceModel\CustomerIpAddress\CollectionFactory;
use Magento\Framework\Controller\Result\JsonFactory;

class LoginAjaxPrevent
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
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;
    /**
     * Initialize LoginAjaxPrevent plugin
     * @param Request $request
     * @param CollectionFactory $collectionFactory
     * @param resultJsonFactory $resultJsonFactory
     */
    public function __construct(Request $request, CollectionFactory $collectionFactory, JsonFactory $resultJsonFactory)
    {
          $this->_request= $request;
          $this->resultJsonFactory= $resultJsonFactory;
          $this->collection = $collectionFactory->create();
    }
     /**
      *
      * @param \Magento\Customer\Controller\Ajax\Login $register
      * @param callable $proceed
      * @return array | callable $proceed
      */
    public function aroundExecute(\Magento\Customer\Controller\Ajax\Login $register, callable $proceed)
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
            $response = [
                'errors' => true,
                'message' => __('Ip Address is not alllowed to login.'),
            ];
            $resultJson = $this->resultJsonFactory->create();
            return $resultJson->setData($response);
        }
    }
}
