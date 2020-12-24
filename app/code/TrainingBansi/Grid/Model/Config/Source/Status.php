<?php


namespace TrainingBansi\Grid\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Status implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => 'Draft',
                'value' => '0'
            ],
            1 => [
                'label' => 'Pending',
                'value' => '1'
            ],
            2 => [
                'label' => 'Published',
                'value' => '2'
            ],
        ];

        return $options;
    }
}
