<?php
/**
 * ProjectEight
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future. If you wish to customize this module for your
 * needs please contact ProjectEight for more information.
 *
 * @category    ProjectEight
 * @package     AddExtensionAttributeExample
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

namespace ProjectEight\AddExtensionAttributeExample\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;

class ProductGet
{
    /**
     * Product Extension Factory
     *
     * @var \Magento\Catalog\Api\Data\ProductExtensionFactory
     */
    protected $productExtensionFactory;

    /**
     * Product Factory
     *
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;

    /**
     * ProductGet constructor.
     *
     * @param \Magento\Catalog\Api\Data\ProductExtensionFactory $productExtensionFactory
     * @param \Magento\Catalog\Model\ProductFactory             $productFactory
     */
    public function __construct(
        \Magento\Catalog\Api\Data\ProductExtensionFactory $productExtensionFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory
    ) {
        $this->productFactory          = $productFactory;
        $this->productExtensionFactory = $productExtensionFactory;
    }

    /**
     * Wrapper around the getById() method
     *
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $subject
     * @param \Closure                                        $proceed
     * @param int                                             $customerId
     *
     * @return ProductInterface
     */
    public function aroundGetById(
        \Magento\Catalog\Api\ProductRepositoryInterface $subject,
        \Closure $proceed,
        $customerId
    ) {
        /** @var ProductInterface $product */
        $product = $proceed($customerId);

        // If extension attribute is already set, return early.
        if ($product->getExtensionAttributes() && $product->getExtensionAttributes()->getFeatures()) {
            return $product;
        }

        // In the event that extension attribute class has not be instantiated yet, we create it ourselves.
        if (!$product->getExtensionAttributes()) {
            $productExtension = $this->productExtensionFactory->create();
            $product->setExtensionAttributes($productExtension);
        }

        // Fetch the raw product model (I have not found a better way), and set the data onto our attribute.
        $productModel = $this->productFactory->create()->load($product->getId());
        $product->getExtensionAttributes()
                ->setFeatures("This text was added by the extension attribute : " . $productModel->getData('features'))
        ;

        return $product;
    }
}