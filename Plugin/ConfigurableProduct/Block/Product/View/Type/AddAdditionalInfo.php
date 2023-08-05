<?php

namespace CodeLands\PreSelected\Plugin\ConfigurableProduct\Block\Product\View\Type;

use CodeLands\PreSelected\Model\Config\ConfigProvider;
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
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @param Json $jsonSerializer
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Json $jsonSerializer,
        ConfigProvider $configProvider
    ) {
        $this->jsonSerializer = $jsonSerializer;
        $this->configProvider = $configProvider;
    }

    public function afterGetJsonConfig(Subject $configurable, string $result): string
    {
        if (! $this->configProvider->isEnabled()) {
            return $result;
        }

        $type = $this->configProvider->getType();
        $jsonConfig = $this->jsonSerializer->unserialize($result);

        switch ($type) {
            case '1':
                $product = $configurable->getProduct();
                $selectedProductId = $product->getPreSelected();
                if (isset($jsonConfig['index'][$selectedProductId])) {
                    $preSelectedAttributeId = $jsonConfig['index'][$selectedProductId];
                } else {
                    $selectedProductId = array_key_first($jsonConfig['sku']);
                    $preSelectedAttributeId = $jsonConfig['index'][$selectedProductId];
                }

                break;
            case '2':
                $selectedProductId = array_key_first($jsonConfig['sku']);
                $preSelectedAttributeId = $jsonConfig['index'][$selectedProductId];
                break;
            case '3':
                $product = $configurable->getProduct();
                $selectedProductId = $product->getPreSelected();
                if (! isset($jsonConfig['index'][$selectedProductId])) {
                    return $result;
                }
                $preSelectedAttributeId = $jsonConfig['index'][$selectedProductId];
                break;
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
