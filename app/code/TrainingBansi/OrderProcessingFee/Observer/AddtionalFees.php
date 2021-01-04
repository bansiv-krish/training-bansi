<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\OrderProcessingFee\Observer;

use Magento\Framework\Event\Observer as Event;
use Magento\Framework\Event\ObserverInterface;

class AddtionalFees implements ObserverInterface
{
    protected $helperData;
    protected $quoteRepository;
    public function __construct(\TrainingBansi\OrderProcessingFee\Helper\Data $helperData, \Magento\Quote\Model\QuoteRepository $quoteRepository)
    {
        $this->helperData = $helperData;
        $this->quoteRepository = $quoteRepository;
    }

    public function execute(Event $event)
    {
  
        $isModuleEnabled=$this->helperData->isModuleEnabled();
        
        if ($isModuleEnabled==1) {
            $processing_fees=$this->helperData->processingFees();
            $quoteEvent = $event->getEvent()->getQuote();
            $subtotal = $quoteEvent->getSubtotal();
            $quote=$this->quoteRepository->get($quoteEvent->getId());
        
            $setupFees =($subtotal*$processing_fees)/100;
            $quote->setProcessingFees($setupFees);
            $this->quoteRepository->save($quote);
            $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/testa.log');
            $logger = new \Zend\Log\Logger();
            $logger->addWriter($writer);
            $logger->info('invoke function is calling');
            $logger->info($quoteEvent->getIsActive());
        }
        return $this;
    }
}
