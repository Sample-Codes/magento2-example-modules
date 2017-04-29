<?php

namespace ProjectEight\AddExtensionAttributeExample\Block;

use Magento\Catalog\Block\Product\View;

class Features extends View
{
    /**
     * Get features attribute
     *
     * @return string
     */
    public function getFeatures()
    {
        return $this->getProduct()->getExtensionAttributes()->getFeatures();
    }
}