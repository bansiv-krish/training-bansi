<?php

namespace TrainingBansi\OrderProcessingFee\Block\Adminhtml\Sales\Order;

class Fee extends \Magento\Framework\View\Element\Template
{
    protected $dataHelper;

    protected $_currency;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \TrainingBansi\OrderProcessingFee\Helper\Data $dataHelper,
        \Magento\Directory\Model\Currency $currency,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->dataHelper = $dataHelper;
        $this->_currency = $currency;
    }

    /**
     * Retrieve current order model instance
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        return $this->getParentBlock()->getOrder();
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }

    /**
     * @return string
     */
    public function getCurrencySymbol()
    {
        return $this->_currency->getCurrencySymbol();
    }

    /**
     *
     *
     * @return $this
     */
    public function initTotals()
    {
        $parent = $this->getParentBlock();
        $this->_order = $parent->getOrder();
        $this->_source = $parent->getSource();
        $store = $this->getStore();
        $enabled = $this->dataHelper->isModuleEnabled();
        if ($enabled) {
            $customAmount = new \Magento\Framework\DataObject(
                [
                    'code' => 'fee',
                    'strong' => false,
                    'value' => $this->_order->getProcessingFees(),
                    'label' => __('Processing Fees'),
                ]
            );
            $parent->addTotal($customAmount, 'fee');
        }
        return $this;
    }
}
