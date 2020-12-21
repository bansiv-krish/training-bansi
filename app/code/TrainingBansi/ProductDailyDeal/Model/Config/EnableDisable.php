<?php
namespace TrainingBansi\ProductDailyDeal\Model\Config;

class EnableDisable extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    protected $_options;

    /**
     * getAllOptions
     *
     * @return array
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['value' => '1', 'label' => __('Enable')],
                ['value' => '0', 'label' => __('Disable')]
            ];
        }
        return $this->_options;
    }
    final public function toOptionArray()
    {
         return array(
            array('value' => '1', 'label' => __('Enable')),
            array('value' => '0', 'label' => __('Disable'))
         );
     }
}
