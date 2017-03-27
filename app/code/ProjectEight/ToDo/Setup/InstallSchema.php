<?php


namespace ProjectEight\ToDo\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;

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

        $table_projecteight_task = $setup->getConnection()->newTable($setup->getTable('projecteight_task'));

        
        $table_projecteight_task->addColumn(
            'task_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            array('identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,),
            'Entity ID'
        );
        

        
        $table_projecteight_task->addColumn(
            'Name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => false],
            'Name'
        );
        

        
        $table_projecteight_task->addColumn(
            'Description',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => true],
            'Description'
        );
        

        
        $table_projecteight_task->addColumn(
            'Status',
            \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
            null,
            ['nullable' => false],
            'Status'
        );
        

        $setup->getConnection()->createTable($table_projecteight_task);

        $setup->endSetup();
    }
}
