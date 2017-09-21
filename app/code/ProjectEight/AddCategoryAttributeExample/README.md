# Add Category Attribute Example

## Synopsis

This project is a collection of samples to demonstrate technologies introduced in Magento 2. You will find the most simple extension along with samples that incrementally add features to lead you through a exploration and education of the Magento 2 platform.

## Motivation

The intent is to learn by example, building up a library of examples of common use-cases for developing a modular site using Magento 2. In so doing, these modules will contain more comments than usual to explain the code.

## Purpose

This module demonstrates how to add a custom attribute to the category entity in Magento 2.

## Installation

Clone the module and copy-paste it into `{{MAGENTO2_BASE_DIR}}/app/code/`, then run `bin/magento setup:upgrade`.

## Compatibility

This module has been tested with Magento 2.1.8.

## Explanation

The module contains an `InstallData.php` script which adds a new text attribute, `p8_category_notes` to the category entity. 

The module also contains a UI component in `category_form.xml` which adds a form field for the attribute 
to the Admin, Products, Inventory, Categories section of the admin.

## Detailed Explanation

### `app/code/ProjectEight/AddCategoryAttributeExample/Setup/InstallData.php`

The install script for the module.

```php
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
    
    // Class continues...
}
```

An instance of the `EavSetupFactory` is injected into the constructor because categories are EAV entities.

## Disclaimer

These example modules are intended as a learning resource. If you choose to use them in a production environment then you do so entirely at your own risk.

## License

[Open Source License](LICENSE.txt)
