<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\Script\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\HTTP\Adapter\CurlFactory;

/**
 * Catalog index page controller.
 */
class Save extends \Magento\Framework\App\Action\Action
{
    
    protected $pageFactory;
    protected $curl;
    protected $storeManager;
    protected $curlFactory;
    public function __construct(PageFactory $pageFactory, Context $context, \Magento\Framework\HTTP\Client\Curl $curl, \Magento\Store\Model\StoreManagerInterface $storeManager, RedirectFactory $redirectFactory, CurlFactory $curlFactory)
    {
        $this->pageFactory=$pageFactory;
        parent::__construct($context);
        $this->curl = $curl;
        $this->storeManager=$storeManager;
        $this->redirectFactory = $redirectFactory;
        $this->curlFactory = $curlFactory;
    }
    
    public function execute()
    {
        $resultredirect = $this->redirectFactory->create();
        $base_url=$this->storeManager->getStore()->getBaseUrl();
        $sku = $this->_request->getParam('sku');
        $qty = $this->_request->getParam('qty');
        
        $url=$base_url.'rest/V1/products/'.$sku;
        $this->curl->addHeader("Authorization", "Bearer z6nx56yqxwg22jked0woz6ioeyx4kp9o");
        $this->curl->get($url);
        $result = $this->curl->getBody();
        $result =json_decode($result);
        if (isset($result->id)) {
            $product_id=$result->id;
       
            if ($qty<=0) {
                $in_stock=false;
            } else {
                $in_stock=true;
            }
            $data = [
            "stock_item" =>[
                "item_id"=> $product_id,
                    "qty"=>$qty,
                    "is_in_stock"=> $in_stock
            ]
            ];
            $items= json_encode($data);
            $updateurl=$base_url.'rest/V1/products/'.$sku.'/stockItems/'.$sku;

            // $ch = curl_init($updateurl);
            // curl_setopt($ch, CURLOPT_URL, $updateurl);
            // curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', "Authorization:Bearer z6nx56yqxwg22jked0woz6ioeyx4kp9o", 'Content-Length: ' . strlen($items)]);
            // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $items);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // $response  = curl_exec($ch);
            $httpAdapter = $this->curlFactory->create();
            /* Forth parameter is POST body */
            $httpAdapter->write(\Zend_Http_Client::PUT, $updateurl, '1.1', ["Content-Type:application/json","Authorization:Bearer z6nx56yqxwg22jked0woz6ioeyx4kp9o"], $items);
            $result = $httpAdapter->read();
            $body = \Zend_Http_Response::extractBody($result);
            $this->messageManager->addSuccessMessage(__('Product updated Successfully'));
            return $resultredirect->setPath('updatestockscript/index/index');
        } else {
            $this->messageManager->addError(__('Invalid Product Sku'));
            return $resultredirect->setPath('updatestockscript/index/index');
        }
    }
}
