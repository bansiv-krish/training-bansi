<?php
namespace TrainingBansi\OrderProcessingFee\Model\Quote\Total;

class ProcessingFee extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
   /**
    * Collect grand total address amount
    *
    * @param \Magento\Quote\Model\Quote $quote
    * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
    * @param \Magento\Quote\Model\Quote\Address\Total $total
    * @return $this
    */
    protected $quoteValidator = null;
    protected $helperData;

    public function __construct(\Magento\Quote\Model\QuoteValidator $quoteValidator, \TrainingBansi\OrderProcessingFee\Helper\Data $helperData)
    {
        $this->quoteValidator = $quoteValidator;
        $this->helperData = $helperData;
    }
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        $enabled = $this->helperData->isModuleEnabled();
        if ($enabled) {
       
            $fee = $quote->getProcessingFees();
        
            $total->setTotalAmount('fee', $fee);
            $total->setBaseTotalAmount('fee', $fee);

            $total->setProcessingFee($fee);
        // $total->setBaseFee($fee);
        // //var_dump($total->getBaseGrandTotal() + $fee);exit();
        // $total->setGrandTotal($total->getGrandTotal() + $fee);
        // $total->setBaseGrandTotal($total->getBaseGrandTotal() + $fee);
        }

        return $this;
    }

    protected function clearValues(Address\Total $total)
    {
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);
    }
    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array|null
     */
    /**
     * Assign subtotal amount and label to address object
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $enabled = $this->helperData->isModuleEnabled();
        $fee = $quote->getProcessingFees();
        $result = [];
        if ($enabled && $fee) {
            $result = [
            'code' => 'fee',
            'title' => __('Processing Fee'),
            'value' => $fee
            ];
        }
        return $result;
    }

    /**
     * Get Subtotal label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Processing Fee');
    }
}
