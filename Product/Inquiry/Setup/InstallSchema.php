<?php

namespace Product\Inquiry\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        

        $installer->startSetup();
        $table = $installer->getConnection()->newTable(
            $installer->getTable('product_inquiry')
        )->addColumn(
            'inquiry_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Entity Id'
        )->addColumn(
            'product_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['default' => null],
            'Product Id'
        )
        ->addColumn(
            'product_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['default' => null],
            'Product Name'
        )
        ->addColumn(
            'product_sku',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['default' => null],
            'Product SKU'
        )
        ->addColumn(
            'first_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['default' => null],
            'First Name'
        )
        ->addColumn(
            'last_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['default' => null],
            'Last Name'
        )
        ->addColumn(
            'email',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['default' => null],
            'Email'
        )
        ->addColumn(
            'telephone',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['default' => null],
            'Telephone'
        )
        ->addColumn(
            'comment',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['default' => null],
            'Comment'
        )->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false],
            'Created At'
        )->addColumn(
            'published_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
            null,
            ['nullable' => true,'default' => null],
            'World publish date'
        )->addIndex(
            $installer->getIdxName(
                'product_inquiry',
                ['published_at'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
            ),
            ['published_at'],
            ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX]
        )->setComment(
            'Inquiry item'
        );
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}
