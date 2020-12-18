<?php
namespace TrainingBansi\LoginPopup\Plugin;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Registration;
use Magento\Customer\Model\Metadata\FormFactory;
use Magento\Customer\Api\Data\RegionInterfaceFactory;
use Magento\Customer\Api\Data\AddressInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Customer\Model\CustomerExtractor;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\UrlFactory;
use Magento\Framework\Message\MessageInterface;

class AjaxRegister  
{
	/**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;
    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $resultRedirectFactory;
    /**
     * @var \Magento\Customer\Model\Metadata\FormFactory
     */
    protected $formFactory;
    /**
     * @var \Magento\Customer\Api\Data\RegionInterfaceFactory
     */
    protected $regionDataFactory;

    /**
     * @var \Magento\Customer\Api\Data\AddressInterfaceFactory
     */
    protected $addressDataFactory;
     /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;
    /**
     * @var \Magento\Customer\Model\CustomerExtractor
     */
    protected $customerExtractor;
    /**
     * @var \Magento\Customer\Api\AccountManagementInterface
     */
    protected $accountManagement;
    /**
     * @var \Magento\Customer\Model\Url
     */
    protected $customerUrl;
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlModel;
    /**
     * Initialize AjaxRegister plugin
     *
     */
	public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory,
        Session $customerSession,
        Registration $registration,
        FormFactory $formFactory,
        RegionInterfaceFactory $regionDataFactory,
        AddressInterfaceFactory $addressDataFactory,
        DataObjectHelper $dataObjectHelper,
        CustomerExtractor $customerExtractor,
        AccountManagementInterface $accountManagement,
        CustomerUrl $customerUrl,
        UrlFactory $urlFactory
    ) {
        
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultRawFactory = $resultRawFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->session = $customerSession;
        $this->registration = $registration;
        $this->formFactory = $formFactory;
        $this->regionDataFactory = $regionDataFactory;
        $this->addressDataFactory = $addressDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->customerExtractor = $customerExtractor;
        $this->accountManagement = $accountManagement;
        $this->customerUrl = $customerUrl;
        $this->urlModel = $urlFactory->create();
        
    }
    public function aroundExecute(\Magento\Customer\Controller\Account\CreatePost $register,callable $proceed){ 
    
    	
	     if($register->getRequest()->isAjax() && $register->getRequest()->getParam('ajax_submit')=="1"){
	     	$resultRaw = $this->resultRawFactory->create();
	     	$resultRedirect = $this->resultRedirectFactory->create();
	        if ($this->session->isLoggedIn() || !$this->registration->isAllowed()) {
	            $resultRedirect->setPath('*/*/');
	            return $resultRedirect;
	        }

        if (!$register->getRequest()->isPost()
            || !$register->getRequest()->isXmlHttpRequest())
        {
            return $resultRaw->setHttpResponseCode($httpBadRequestCode);
        }
        $response = [
            'errors' => true,
            'message' => __('Login successful.')
        ];
      
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($response);
        }
        return $proceed();

   }
   /**
     * Add address to customer during create account
     *
     * @return AddressInterface|null
     */
    protected function extractAddress($register)
    {
        if (!$register->getRequest()->getPost('create_address')) {
            return null;
        }

        $addressForm = $this->formFactory->create('customer_address', 'customer_register_address');
        $allowedAttributes = $addressForm->getAllowedAttributes();

        $addressData = [];

        $regionDataObject = $this->regionDataFactory->create();
        $userDefinedAttr = $register->getRequest()->getParam('address') ?: [];
        foreach ($allowedAttributes as $attribute) {
            $attributeCode = $attribute->getAttributeCode();
            if ($attribute->isUserDefined()) {
                $value = array_key_exists($attributeCode, $userDefinedAttr) ? $userDefinedAttr[$attributeCode] : null;
            } else {
                $value = $register->getRequest()->getParam($attributeCode);
            }

            if ($value === null) {
                continue;
            }
            switch ($attributeCode) {
                case 'region_id':
                    $regionDataObject->setRegionId($value);
                    break;
                case 'region':
                    $regionDataObject->setRegion($value);
                    break;
                default:
                    $addressData[$attributeCode] = $value;
            }
        }
        $addressData = $addressForm->compactData($addressData);
        unset($addressData['region_id'], $addressData['region']);

        $addressDataObject = $this->addressDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $addressDataObject,
            $addressData,
            \Magento\Customer\Api\Data\AddressInterface::class
        );
        $addressDataObject->setRegion($regionDataObject);

        $addressDataObject->setIsDefaultBilling(
            $register->getRequest()->getParam('default_billing', false)
        )->setIsDefaultShipping(
            $register->getRequest()->getParam('default_shipping', false)
        );
        return $addressDataObject;
    }
     protected function checkPasswordConfirmation($password, $confirmation)
    {
        if ($password != $confirmation) {
            throw new InputException(__('Please make sure your passwords match.'));
        }
    }
    /**
     * Retrieve success message manager message
     *
     * @return MessageInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getMessageManagerSuccessMessage(): MessageInterface
    {
        if ($this->addressHelper->isVatValidationEnabled()) {
            if ($this->addressHelper->getTaxCalculationAddressType() == Address::TYPE_SHIPPING) {
                $identifier = 'customerVatShippingAddressSuccessMessage';
            } else {
                $identifier = 'customerVatBillingAddressSuccessMessage';
            }

            $message = $this->messageManager
                ->createMessage(MessageInterface::TYPE_SUCCESS, $identifier)
                ->setData(
                    [
                        'url' => $this->urlModel->getUrl('customer/address/edit'),
                    ]
                );
        } else {
            $message = $this->messageManager
                ->createMessage(MessageInterface::TYPE_SUCCESS)
                ->setText(
                    __('Thank you for registering with %1.', $this->storeManager->getStore()->getFrontendName())
                );
        }

        return $message;
    }
}
