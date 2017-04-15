<?php

namespace ProjectEight\CurrencyPerCustomerExample\Setup;

use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
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
     * Creates a new attribute 'p8_assigned_currency' and adds it to the Customer entity and the admin Manage Customer form
     * '$setup->startSetup()' and '$setup->endSetup()' are intentionally omitted
     *
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var \Magento\Customer\Setup\CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $setup->startSetup();

        // These are all the possible fields for a customer attribute, not all of these are required
        $data = array (
            'backend' => NULL,
            'type' => 'varchar',
            'table' => NULL,
            'frontend' => NULL,
            'input' => 'text',
            'label' => 'Assigned Currency',
            'frontend_class' => NULL,
            'source' => NULL,
            'required' => true,
            'user_defined' => 1,
            'default' => 'GBP',
            'unique' => 0,
            'note' => 'Currency assigned to customer. The customer cannot change this.',
            'global' => 1,
            'visible' => 1,
            'system' => 0,
            'input_filter' => NULL,
            'multiline_count' => 0,
            'validate_rules' => NULL,
            'data_model' => NULL,
            'sort_order' => 0,
            'position' => 999,
        );

        $attributeSetId = $customerEntity->getDefaultAttributeSetId();
        /** @var $attributeSet AttributeSet */
        $attributeSet     = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
        $attributeCode = 'p8_assigned_currency';
        $customerSetup->addAttribute(Customer::ENTITY, $attributeCode, $data);

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

        $customerAttribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, $attributeCode);
        $customerAttribute->addData([
            'attribute_set_id'   => $attributeSetId,
            'attribute_group_id' => $attributeGroupId,
            'used_in_forms'      => ['adminhtml_customer'],
        ]);
        $customerAttribute->save();
        $setup->endSetup();
    }
}
