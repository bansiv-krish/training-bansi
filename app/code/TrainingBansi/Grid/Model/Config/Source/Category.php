<?php


namespace TrainingBansi\Grid\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Category implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => 'Test',
                'value' => '1'
            ],
            1 => [
                'label' => 'Test1',
                'value' => '2'
            ],
            2 => [
                'label' => 'Test2',
                'value' => '3'
            ],
        ];

        return $options;
    }
}
