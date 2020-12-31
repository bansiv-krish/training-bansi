<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\OrderProcessingFee\Observer;

use Magento\Framework\Event\Observer as Event;
use Magento\Framework\Event\ObserverInterface;

class SalesAddtionalFees implements ObserverInterface
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
            $order = $event->getEvent()->getOrder();
            $quote_id=$order->getQuoteId();
            $quote=$this->quoteRepository->get($quote_id);
            $order->setProcessingFees($quote->getProcessingFees());
            $order->setFeesTitle(__('Processing Fee'));
        }
        return $this;
    }
}
