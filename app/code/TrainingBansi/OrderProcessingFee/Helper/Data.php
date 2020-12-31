<?php

namespace TrainingBansi\OrderProcessingFee\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * Custom fee config path
     */
    const CONFIG_CUSTOM_IS_ENABLED = 'orderFeeSection/orderFeeGroup/is_additional_fee';
    const CONFIG_PROCESSING_FEES = 'orderFeeSection/orderFeeGroup/order_fees';

    /**
     * @return mixed
     */
    public function isModuleEnabled()
    {

        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $isEnabled = $this->scopeConfig->getValue(self::CONFIG_CUSTOM_IS_ENABLED, $storeScope);
        return $isEnabled;
    }
    public function processingFees()
    {

        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $order_fees = $this->scopeConfig->getValue(self::CONFIG_PROCESSING_FEES, $storeScope);
        return $order_fees;
    }
}
