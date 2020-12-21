<?php
namespace TrainingBansi\LoginPopup\Plugin;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Registration;
use Magento\Framework\Message\MessageInterface;
use Magento\Customer\Api\AccountManagementInterface;


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
     * @var Session
     */
    protected $session;
    /**
     * @var \Magento\Customer\Model\Registration
     */
    protected $registration;
     /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
     protected $storeManager;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;
      /**
     * @var AccountManagementInterface
     */
      protected $customerAccountManagement; 
      /**
     * @var SubscriptionManagerInterface
     */
      protected $subscriptionManager; 
    /**
     * Initialize AjaxRegister plugin
     *@param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     *@param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     *@param \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
     *@param \Magento\Store\Model\StoreManagerInterface $storeManager
     *@param \Magento\Customer\Model\CustomerFactory $customerFactory
     *@param Session $customerSession
     *@param Registration $registration
     *@param AccountManagementInterface $customerAccountManagement
     *@param \Magento\Newsletter\Model\SubscriptionManagerInterface $subscriptionManager
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        Session $customerSession,
        Registration $registration,
        AccountManagementInterface $customerAccountManagement,
        \Magento\Newsletter\Model\SubscriptionManagerInterface $subscriptionManager
    ) {

        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultRawFactory = $resultRawFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->session = $customerSession;
        $this->registration = $registration;
        $this->storeManager     = $storeManager;
        $this->customerFactory  = $customerFactory;
        $this->customerAccountManagement = $customerAccountManagement;
        $this->subscriptionManager = $subscriptionManager;
        
    }
    /**
     *
     * @param \Magento\Customer\Controller\Account\CreatePost $register
     * @param callable $proceed
     * @return array | callable $proceed
     */
    public function aroundExecute(\Magento\Customer\Controller\Account\CreatePost $register,callable $proceed)
    { 

    	
    if($register->getRequest()->isAjax() && $register->getRequest()->getParam('ajax_submit')=="1")
    {
         $resultRaw = $this->resultRawFactory->create();
         $resultRedirect = $this->resultRedirectFactory->create();
         if ($this->session->isLoggedIn() || !$this->registration->isAllowed()) 
         {
           $resultRedirect->setPath('*/*/');
           return $resultRedirect;
         }

       if (!$register->getRequest()->isPost()
        || !$register->getRequest()->isXmlHttpRequest())
       {
        return $resultRaw->setHttpResponseCode($httpBadRequestCode);
       }
    $response = [
        'errors' => false,
        'message' => __('Registration successful.')
    ];
    try{
        $firstname = $register->getRequest()->getParam('firstname');
        $lastname = $register->getRequest()->getParam('lastname');
        $email =  $register->getRequest()->getParam('email');
        $password = $register->getRequest()->getParam('password');

        $confirmation = $register->getRequest()->getParam('password_confirmation');
        $this->checkPasswordConfirmation($password, $confirmation);
        $is_subscribed=$register->getRequest()->getParam('is_subscribed', false);

        $websiteId  = $this->storeManager->getWebsite()->getWebsiteId();
        $storeId=$this->storeManager->getStore()->getId();

		        // Instantiate object (this is the most important part)
        $customer   = $this->customerFactory->create();
        $customer->setWebsiteId($websiteId);

		        // Preparing data for new customer
        $customer->setEmail($email); 
        $customer->setFirstname($firstname);
        $customer->setLastname($lastname);
        $customer->setPassword($password);

		        // Save data
        $customer->save();

            if($is_subscribed=="1"){

               $this->subscriptionManager->subscribeCustomer((int)$customer->getId(), (int)$storeId);
            }

        $customer = $this->customerAccountManagement->authenticate(
        $email,
        $password);

           $this->session->setCustomerDataAsLoggedIn($customer);
           $this->session->regenerateId();

        } 
        catch (StateException $e) {
             $response = [
               'errors' => true,
               'message' => $e->getMessage()
           ];

        } catch (InputException $e) {
          $response = [
           'errors' => true,
           'message' => $e->getMessage()
        ];
        } catch (LocalizedException $e) {
           $response = [
               'errors' => true,
               'message' => $e->getMessage()
           ];
        } catch (\Exception $e) {
          $response = [
           'errors' => true,
           'message' => $e->getMessage()
        ];
        }
            $resultJson = $this->resultJsonFactory->create();
            return $resultJson->setData($response);
    }
    return $proceed();

    }

    protected function checkPasswordConfirmation($password, $confirmation)
    {
        if ($password != $confirmation) {
            throw new InputException(__('Please make sure your passwords match.'));
        }
    }

}
