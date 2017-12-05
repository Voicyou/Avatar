<?php
/**
 * Copyright © 2017 Voicyou Softwares . All rights reserved.
 */
namespace Sourabh\CustomerApprove\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();
        $table = $installer->getConnection()
            ->newTable($installer->getTable('voicyou_customer_avatar'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Id'
            )
            ->addColumn(
                'customer_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                10,
                ['nullable' => false],
                'customer_id'
            )
            ->addColumn(
                'image_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                225,
                ['nullable' => false],
                'image_name'
            );
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}
