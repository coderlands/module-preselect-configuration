<?php

namespace CodeLands\PreSelected\Model\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class ConfigProvider
{
    private $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag('catalog/preselected/enabled', ScopeInterface::SCOPE_STORE);
    }

    public function getType()
    {
        return $this->scopeConfig->getValue('catalog/preselected/type', ScopeInterface::SCOPE_STORE);
    }
}
