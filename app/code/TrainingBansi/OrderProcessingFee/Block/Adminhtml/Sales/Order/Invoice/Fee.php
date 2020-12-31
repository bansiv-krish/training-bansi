<?php

namespace TrainingBansi\OrderProcessingFee\Block\Adminhtml\Sales\Order\Invoice;

use Magento\Sales\Model\Order\Invoice;

class Fee extends \Magento\Framework\View\Element\Template
{
    protected $dataHelper;

    /**
     * Order invoice
     *
     * @var \Magento\Sales\Model\Order\Invoice|null
     */
    protected $_invoice = null;

    /**
     * @var \Magento\Framework\DataObject
     */
    protected $_source;

    /**
     * OrderFee constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \TrainingBansi\OrderProcessingFee\Helper\Data $dataHelper,
        array $data = []
    ) {
        $this->dataHelper = $dataHelper;
        parent::__construct($context, $data);
    }

    /**
     * Get data (totals) source model
     *
     * @return \Magento\Framework\DataObject
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }

    public function getInvoice()
    {
        return $this->getParentBlock()->getInvoice();
    }
    /**
     * Initialize payment fee totals
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
            $total = new \Magento\Framework\DataObject(
                [
                'code' => 'grand_total',
                'strong' => true,
                'value' => $this->_order->getGrandTotal(),
                'base_value' => $this->_order->getBaseGrandTotal(),
                'label' => __('Grand Total'),
                'area' => 'footer',
                ]
            );
            $parent->addTotal($total, 'grand_total');
        }

        return $this;
    }
}
