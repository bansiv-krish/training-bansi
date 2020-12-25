<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\CustomerLoginIp\Controller\Adminhtml\Index;

use Magento\Framework\App\ResponseInterface;
use Magento\Backend\Model\View\Result\ForwardFactory;

/**
 * Catalog index page controller.
 */
class NewAction extends \Magento\Backend\App\Action
{
    protected $forwardfactory;
       
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        ForwardFactory $forwardfactory
    ) {
        parent::__construct($context);
        $this->forwardfactory = $forwardfactory;
    }

    public function execute()
    {
        $resultforward = $this->forwardfactory->create();
        return $resultforward->forward('edit');
    }
}
