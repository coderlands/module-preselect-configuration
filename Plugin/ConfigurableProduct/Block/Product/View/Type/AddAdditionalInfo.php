<?php

namespace CodeLands\PreSelected\Plugin\ConfigurableProduct\Block\Product\View\Type;

use Magento\ConfigurableProduct\Block\Product\View\Type\Configurable as Subject;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\InventorySalesApi\Api\Data\SalesChannelInterface;
use Magento\Store\Model\StoreManagerInterface;

class AddAdditionalInfo
{
    /**
     * @var Json
     */
    private $jsonSerializer;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param Json $jsonSerializer
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Json $jsonSerializer,
        StoreManagerInterface $storeManager
    ) {
        $this->jsonSerializer = $jsonSerializer;
        $this->storeManager = $storeManager;
    }

    public function afterGetJsonConfig(Subject $configurable, string $result): string
    {
        $jsonConfig = $this->jsonSerializer->unserialize($result);
        $product = $configurable->getProduct();
        $selectedProductId = $product->getPreSelected();
        if (isset($jsonConfig['index'][$selectedProductId])) {
            $preSelectedAttributeId = $jsonConfig['index'][$selectedProductId];
        } else {
            $selectedProductId = array_key_first($jsonConfig['sku']);
            $preSelectedAttributeId = $jsonConfig['index'][$selectedProductId];
        }

        $jsonConfig['pre_selected'] = [];

        foreach ($jsonConfig['attributes'] as $attributeId => $attribute) {
            if (isset($preSelectedAttributeId[$attributeId])) {
                $jsonConfig['pre_selected'][$attribute['code']] = $preSelectedAttributeId[$attributeId];
            }
        }

        return $this->jsonSerializer->serialize($jsonConfig);
    }
}
