<?php
namespace TrainingBansi\OrderProcessingFee\Model;

use Magento\Checkout\Model\ConfigProviderInterface;

class AdditionalFeeConfigProvider implements ConfigProviderInterface
{
    /**
     * @var \TrainingBansi\PaymentFee\Helper\Data
     */
    protected $dataHelper;

    public function __construct(
        \TrainingBansi\OrderProcessingFee\Helper\Data $dataHelper
    ) {
        $this->dataHelper = $dataHelper;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $additionalVariables['isModuleEnabled'] = $this->dataHelper->isModuleEnabled();
        return $additionalVariables;
    }
}
