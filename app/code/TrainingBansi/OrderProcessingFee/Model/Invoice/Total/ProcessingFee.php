<?php

namespace TrainingBansi\OrderProcessingFee\Model\Invoice\Total;

use Magento\Sales\Model\Order\Invoice\Total\AbstractTotal;

class ProcessingFee extends AbstractTotal
{
    /**
     * @param \Magento\Sales\Model\Order\Invoice $invoice
     * @return $this
     */
    public function collect(\Magento\Sales\Model\Order\Invoice $invoice)
    {
        $invoice->setProcessingFees(0);

        $amount = $invoice->getOrder()->getProcessingFees();
        $invoice->setProcessingFees($amount);
        $invoice->setGrandTotal($invoice->getGrandTotal() + $invoice->getProcessingFees());
        $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $invoice->getProcessingFees());

        return $this;
    }
}
