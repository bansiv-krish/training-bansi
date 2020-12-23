<?php


namespace TrainingBansi\Grid\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class EventType implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => 'Event',
                'value' => '1'
            ],
            1 => [
                'label' => 'Simple',
                'value' => '0'
            ],
        ];

        return $options;
    }
}
