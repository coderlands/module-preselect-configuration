<?php

namespace CodeLands\PreSelected\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class PreSelected implements ModifierInterface
{
    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * @param LocatorInterface $locator
     */
    public function __construct(LocatorInterface $locator)
    {
        $this->locator = $locator;
    }

    public function modifyData(array $data)
    {
        $product = $this->locator->getProduct();
        $productId = $product->getId();
        if (empty($data[$productId]['configurable-matrix'])) {
            return $data;
        }

        $firstAvailableMatrix = false;
        $flag = false;

        foreach ($data[$productId]['configurable-matrix'] as $key => &$matrix) {
            if (! $firstAvailableMatrix && $matrix['qty'] > 0) {
                $firstAvailableMatrix = $key;
            }
            if (isset($matrix['id'], $matrix['qty']) && $matrix['id'] == $product->getPreSelected() && $matrix['qty'] > 0) {
                $matrix['checked'] = 1;
                $flag = true;
            }
        }
        if (! $flag && $firstAvailableMatrix) {
            $data[$productId]['configurable-matrix'][$firstAvailableMatrix]['checked'] = 1;
        }

        return $data;
    }

    public function modifyMeta(array $meta)
    {
        return $meta;
    }
}
