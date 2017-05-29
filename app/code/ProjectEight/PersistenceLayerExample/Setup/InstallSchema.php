<?php


namespace ProjectEight\PersistenceLayerExample\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        $table = $setup->getConnection()->newTable($setup->getTable('projecteight_whatsit'));


        $table->addColumn(
            'whatsit_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            NULL,
            [
                'identity' => true,
                'nullable' => false,
                'primary' => true,
                'unsigned' => true,
            ],
            'WhatsIt ID'
        );


        $table->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            NULL,
            [
                'nullable' => false
            ],
            'WhatsIt Title'
        );


        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
