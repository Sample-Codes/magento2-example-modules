<?php

namespace ProjectEight\AddExtensionAttributeExample\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Model\Product;

class InstallData implements InstallDataInterface
{
    /**
     * EAV Setup Factory
     *
     * @var EavSetupFactory
     */
    protected $eavSetupFactory;

    /**
     * Constructor
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * Install 'features' attribute
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     *
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        // Add our "features" attribute
        $eavSetup->addAttribute(Product::ENTITY, 'features', [
            'type'                     => 'text',
            'label'                    => 'Features',
            'input'                    => 'textarea',
            'required'                 => false,
            'sort_order'               => 100,
            'global'                   => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'wysiwyg_enabled'          => true,
            'is_html_allowed_on_front' => true,
        ]);

        $setup->endSetup();
    }
}