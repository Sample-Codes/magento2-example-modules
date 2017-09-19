<?php
/* file: app/code/ProjectEight/AddCategoryAttributeExample/Setup/InstallData.php */

namespace ProjectEight\AddCategoryAttributeExample\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Model\Category;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * Eav Setup Factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

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
     * Create a new attribute 'p8_category_notes' and add it to the Category entity
     *
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        /*
         * Notes:
         * - These are all the possible fields for a category attribute, not all of these are required
         * - startSetup() and endSetup() are intentionally omitted
         * - As of 2.1, the following properties are all set in the view/adminhtml/ui_component/category_form.xml file
         *   If specified in the InstallData.php/UpgradeData.php file, they are simply ignored:
         *   label, input, sort_order, group
         */
        $data = [
            'backend'                  => null,
            'type'                     => 'varchar',
            'table'                    => null,
            'frontend'                 => null,
            'frontend_class'           => null,
            'source'                   => null,
            'required'                 => 0,
            'user_defined'             => 0,
            'default'                  => null,
            'unique'                   => 0,
            'note'                     => null,
            'global'                   => '\\Magento\\Eav\\Model\\Entity\\Attribute\\ScopedAttributeInterface::SCOPE_STORE',
            'visible'                  => 1,
            'is_visible_on_front'      => 0,
            'wysiwyg_enabled'          => 0,
            'is_html_allowed_on_front' => 0,
            'position'                 => 0,
        ];

        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'p8_category_notes', $data);
    }
}