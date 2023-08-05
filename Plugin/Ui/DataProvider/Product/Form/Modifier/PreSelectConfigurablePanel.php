<?php

namespace CodeLands\PreSelected\Plugin\Ui\DataProvider\Product\Form\Modifier;

class PreSelectConfigurablePanel
{
    public function afterModifyMeta(
        \Magento\ConfigurableProduct\Ui\DataProvider\Product\Form\Modifier\ConfigurablePanel $subject,
        array $meta
    ) {

        if (empty($meta['configurable']['children']['configurable-matrix']['children']['record']['children'])) {
            return $meta;
        }
        $rows = &$meta['configurable']['children']['configurable-matrix']['children']['record']['children'];
        $rows['default_container'] =[
            'arguments' => [
                'data' => [
                    'config' => [
                        'formElement' => \Magento\Ui\Component\Form\Element\Input::NAME,
                        'componentType' => \Magento\Ui\Component\Form\Field::NAME,
                        'component' => 'CodeLands_PreSelected/js/form/element/pre-selected',
                        'elementTmpl' => 'CodeLands_PreSelected/form/element/pre-selected',
                        'dataType' => \Magento\Ui\Component\Form\Element\DataType\Text::NAME,
                        'label' => __('Pre-selected'),
                        'dataScope' => 'pre_selected',
                        'dataName' => 'configurable-matrix[pre_selected]',
                        'sortOrder' => 0
                    ],
                ],
            ],
        ];

        return $meta;
    }
}
