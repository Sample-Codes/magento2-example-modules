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
 * @package     AddCustomerAddressAttributeExample
 * @copyright   Copyright (c) 2017 ProjectEight
 * @author      ProjectEight
 *
 */

namespace ProjectEight\AddCustomerAddressAttributeExample\Setup;

use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class InstallData implements InstallDataInterface
{
    /**
     * Customer setup factory
     *
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * Attribute Set factory
     *
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * Constructor
     *
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory  $attributeSetFactory
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory  = $attributeSetFactory;
    }

    /**
     * Creates a new attribute on the Customer entity and adds it to the admin edit Customer address form
     * and the edit address form on the frontend
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     *
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var \Magento\Customer\Setup\CustomerSetup $customerSetup */
        $customerSetup  = $this->customerSetupFactory->create(['setup' => $setup]);
        $customerEntity = $customerSetup->getEavConfig()->getEntityType(
            AddressMetadataInterface::ENTITY_TYPE_ADDRESS
        )
        ;

        $data = [
            'type'         => 'varchar',    // static, varchar, int, text, datetime, decimal
            'input'        => 'text',       // select, text, date, hidden, boolean, multiline,
                                            // textarea, image, multiselect, price, weight,
                                            // media_image, gallery
            'label'        => 'Address Nickname (Home, Work, etc)',
            'required'     => 0,
            'user_defined' => 1,
            'unique'       => 0,
            'global'       => 1,
            'system'       => 0,
            'visible'      => 1,
            'sort_order'   => 5,
            'position'     => 5,
        ];

        $attributeSetId = $customerEntity->getDefaultAttributeSetId();
        /** @var $attributeSet AttributeSet */
        $attributeSet     = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
        $attributeCode    = 'projecteight_address_nickname';
        $customerSetup->addAttribute(AddressMetadataInterface::ENTITY_TYPE_ADDRESS, $attributeCode, $data);

        /*
         *  Note you only need to worry about form codes if the customer attribute is_system == 0 and is_visible == 1
         *
         *  mysql> select distinct(form_code) from customer_form_attribute;
         *  +----------------------------+
         *  | form_code                  |
         *  +----------------------------+
         *  | adminhtml_checkout         |
         *  | adminhtml_customer         |
         *  | adminhtml_customer_address |
         *  | checkout_register          |
         *  | customer_account_create    |
         *  | customer_account_edit      |
         *  | customer_address_edit      |
         *  | customer_register_address  |
         *  +----------------------------+
         *  8 rows in set (0.00 sec)
         */

        $customerAddressAttribute = $customerSetup->getEavConfig()->getAttribute(
            AddressMetadataInterface::ENTITY_TYPE_ADDRESS,
            $attributeCode
        )
        ;
        $customerAddressAttribute->addData([
            'attribute_set_id'   => $attributeSetId,
            'attribute_group_id' => $attributeGroupId,
            'used_in_forms'      => ['adminhtml_customer_address', 'customer_address_edit'],
        ]);

        // There is no repository available for saving customer address attributes (as of 2.1.8),
        // so use the old method instead
        $customerAddressAttribute->save();
    }
}
