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
 * @category    AddProductAttributeExample
 * @package     InstallData.php
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

namespace ProjectEight\AddProductAttributeExample\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * Eav setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Constructor
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(\Magento\Eav\Setup\EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * Create a new attribute 'projecteight_notes' and add it to the Product entity
     *
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create();

        /*
         * Notes:
         * - These are all the possible fields for a product attribute, not all of these are required
         * - Note that apply_to can accept a string of product types, e.g. 'simple,configurable,grouped'
         *   or omit it to apply to all product types
         * - startSetup() and endSetup() are intentionally omitted
         */
        $data = array(
            'backend'                    => NULL,
            'type'                       => 'varchar',
            'table'                      => NULL,
            'frontend'                   => NULL,
            'input'                      => 'text',
            'label'                      => 'Projecteight Notes',
            'frontend_class'             => NULL,
            'source'                     => NULL,
            'required'                   => 0,
            'user_defined'               => 1,
            'default'                    => NULL,
            'unique'                     => 0,
            'note'                       => NULL,
            'global'                     => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'input_renderer'             => NULL,
            'visible'                    => 1,
            'searchable'                 => 0,
            'filterable'                 => 0,
            'comparable'                 => 0,
            'visible_on_front'           => 0,
            'is_html_allowed_on_front'   => 0,
            'is_used_for_price_rules'    => 0,
            'filterable_in_search'       => 0,
            'used_in_product_listing'    => 0,
            'used_for_sort_by'           => 0,
            'apply_to'                   => NULL,
            'visible_in_advanced_search' => 0,
            'position'                   => 999,
            'sort_order'                 => 999,
            'wysiwyg_enabled'            => 0,
            'used_for_promo_rules'       => 0,
            'is_required_in_admin_store' => 0,
            'is_used_in_grid'            => 0,
            'is_visible_in_grid'         => 0,
            'is_filterable_in_grid'      => 0,
            'search_weight'              => 0,
            'additional_data'            => 0,
            'is_configurable'            => 0,
            'group'                      => 'General',
        );

        $eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, 'projecteight_notes', $data);
    }
}
