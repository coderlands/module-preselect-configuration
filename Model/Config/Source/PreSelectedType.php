<?php

namespace CodeLands\PreSelected\Model\Config\Source;

class PreSelectedType implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Auto')],
            ['value' => 2, 'label' => __('First Option')],
            ['value' => 3, 'label' => __('Default-option Preselect')],
        ];
    }
}
