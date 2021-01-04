<?php
namespace TrainingBansi\OrderProcessingFee\Model;

use Magento\Sales\Model\Order\Pdf\Total\DefaultTotal;

class ProcessingFee extends DefaultTotal
{
    
    public function getTotalsForDisplay(): array
    {
        $extraFee = $this->getOrder()->getProcessingFees();
        if ($extraFee === null) {
            return [];
        }
        $amountInclTax = $this->getOrder()->formatPriceTxt($extraFee);
        $fontSize = $this->getFontSize() ? $this->getFontSize() : 7;

        return [
            [
                'amount' => $this->getAmountPrefix() . $amountInclTax,
                'label' => __($this->getOrder()->getFeesTitle()) . ':',
                'font_size' => $fontSize,
            ]
        ];
    }
}
