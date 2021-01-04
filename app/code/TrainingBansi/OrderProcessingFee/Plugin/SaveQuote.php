<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\OrderProcessingFee\Plugin;

class SaveQuote
{
    protected $helperData;
    protected $quoteRepository;
    public function __construct(\TrainingBansi\OrderProcessingFee\Helper\Data $helperData, \Magento\Quote\Model\QuoteRepository $quoteRepository)
    {
        $this->helperData = $helperData;
        $this->quoteRepository = $quoteRepository;
    }
    public function afterSetProduct(
        \Magento\Quote\Model\Quote\Item $subject,
        $result
    ) {
         $isModuleEnabled=$this->helperData->isModuleEnabled();
        
        if ($isModuleEnabled==1) {
            $processing_fees=$this->helperData->processingFees();
            $quoteEvent=$subject->getQuote();
            $subtotal = $quoteEvent->getSubtotal();
          
             $setupFees =($subtotal*$processing_fees)/100;
            $quoteEvent->setProcessingFees($setupFees);
       
            $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
            $logger = new \Zend\Log\Logger();
            $logger->addWriter($writer);
            $logger->info('plugin function is calling');
            $logger->info($setupFees);
        }
    }
}
