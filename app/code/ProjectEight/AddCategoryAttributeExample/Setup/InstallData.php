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
 * @package     AddCategoryAttributeExample
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

namespace ProjectEight\AddCategoryAttributeExample\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

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

        /*
         * Backend Models
         *
         * Required: NO
         * Default: null
         *
         * 'backend' maps to 'backend_model' in the eav_attribute table of the database.
         * Backend models are responsible for saving the values of the attribute and performing 'before' and 'after'
         * operations. They can also perform additional logic and validation before and after an attribute is saved,
         * loaded or deleted.
         *
         * To find all the available backend models in your system:
         * $ find ./vendor/ -type f -name "*.php" -path "./vendor/magento/module-*/Model/*/Attribute/Backend/*"
         *
         * You can also, of course, specify a custom model in the format:
         * <Namespace>\<ModuleName>\Model\Attribute\Backend\<BackendModelName>
         */
        // Question: Which backend model is used when 'null' is specified as the backend type?
        $data['backend'] = null;

        /*
         * Attribute types
         *
         * Required: YES
         * Default: 'static'
         *
         * 'type' maps to 'backend_type' in the eav_attribute table of the database.
         * The backend type determines the data type used to persist the values of the attribute to the database.
         * Different 'frontend' (frontend_input) types use different 'type's ('backend_type's) to save data,
         * e.g. Attributes with the 'text' frontend_input use the 'varchar' backend_type to persist text values
         * to the database.
         *
         * This table summarises the default backend types and the frontend input types they map to:
         * |-------------|------------------------------------------|--------------------------------------------------------------|
         * | Type        | Frontend Input                           | Description                                                  |
         * |-------------|------------------------------------------|--------------------------------------------------------------|
         * | static      | ?                                        | An attribute which is always present on the entity.          |
         * |             |                                          | Static attributes are added to the relevant entity table     |
         * |             |                                          | (e.g. catalog_category_entity) rather than added as records  |
         * |             |                                          | in the eav_attribute table                                   |
         * | varchar     | text, gallery, media_image, multiselect  | For use with single-line text attributes                     |
         * | text        | image, textarea                          | For use with multi-line text attributes                      |
         * | int         | select, boolean                          | For use with whole number attributes                         |
         * | datetime    | date                                     | For use with date and time attributes                        |
         * | decimal     | price, weight                            | For use with floating-point numeric attributes               |
         * |-------------|---------------------------------------------------------------------------------------------------------|
         * @see \Magento\Eav\Model\Entity\Attribute::getBackendTypeByInput
         *
         */
        $data['type'] = 'varchar';

        $data = [
            'table'                    => null,
            'frontend'                 => null,
            'frontend_class'           => null,
            'source'                   => null,
            'required'                 => 0,
            'user_defined'             => 0,
            'default'                  => null,
            'unique'                   => 0,
            'note'                     => null,
            'global'                   =>
                '\\Magento\\Eav\\Model\\Entity\\Attribute\\ScopedAttributeInterface::SCOPE_STORE',
            'visible'                  => 1,
            'is_visible_on_front'      => 0,
            'wysiwyg_enabled'          => 0,
            'is_html_allowed_on_front' => 0,
            'position'                 => 0,
        ];

        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'p8_category_notes', $data);
    }
}