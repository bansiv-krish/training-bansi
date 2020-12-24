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
                'value' => '0'
            ],
            1 => [
                'label' => 'Simple',
                'value' => '1'
            ],
        ];

        return $options;
    }
}
