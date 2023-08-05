<?php

namespace CodeLands\PreSelected\Plugin\Controller\Adminhtml\Product;

use Magento\Catalog\Controller\Adminhtml\Product\Builder as CatalogProductBuilder;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Serialize\SerializerInterface;

class PreSelectConfigurableBuilder
{
    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }
    public function afterBuild(CatalogProductBuilder $subject, Product $product, RequestInterface $request)
    {
        $simpleProducts= $request->getPost("configurable-matrix-serialized");

        if ($simpleProducts) {
            $simpleProducts= $this->serializer->unserialize($simpleProducts);
            foreach ($simpleProducts as $simpleProduct) {
                if(isset($simpleProduct['checked']) && $simpleProduct['checked'] && $simpleProduct['qty'] > 0){
                    $product->setPreSelected(
                        $simpleProduct['id']
                    );
                }
            }
        }
        return $product;
    }
}
