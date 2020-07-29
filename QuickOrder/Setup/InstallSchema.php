<?php

namespace Project\QuickOrder\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

use Project\QuickOrder\Api\Schema\StatusSchemaInterface;
use Project\QuickOrder\Api\Schema\QuickOrderSchemaInterface;

/**
 * Class InstallSchema
 * @package Project\QuickOrder\Setup
 */
class InstallSchema implements InstallSchemaInterface
{

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $this->createQuickOrderTable($setup);
        $this->createStatusTable($setup);

        $setup->getConnection()->addForeignKey(
            $setup->getFkName(
                $setup->getTable(QuickOrderSchemaInterface::TABLE_NAME),
                QuickOrderSchemaInterface::STATUS_COL_NAME,
                $setup->getTable(StatusSchemaInterface::TABLE_NAME),
                StatusSchemaInterface::STATUS_ID_COL_NAME
            ),
            $setup->getTable(QuickOrderSchemaInterface::TABLE_NAME),
            QuickOrderSchemaInterface::STATUS_COL_NAME,
            $setup->getTable(StatusSchemaInterface::TABLE_NAME),
            StatusSchemaInterface::STATUS_ID_COL_NAME,
            Table::ACTION_NO_ACTION
        );

        $setup->endSetup();
    }

    private function createQuickOrderTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()->newTable(
            $setup->getTable(QuickOrderSchemaInterface::TABLE_NAME)
        )->addColumn(
            QuickOrderSchemaInterface::ORDER_ID_COL_NAME,
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned'=> true],
            'ID'
        )->addColumn(
            QuickOrderSchemaInterface::NAME_COL_NAME,
            Table::TYPE_TEXT,
            32,
            ['nullable' => false],
            'Name'
        )->addColumn(
            QuickOrderSchemaInterface::PHONE_COL_NAME,
            Table::TYPE_INTEGER,
            32,
            ['nullable' => true],
            'Phone'
        )->addColumn(
            QuickOrderSchemaInterface::EMAIL_COL_NAME,
            Table::TYPE_TEXT,
            null,
            ['nullable' => true],
            'Email'
        )->addColumn(
            QuickOrderSchemaInterface::SKU_COL_NAME,
            Table::TYPE_TEXT,
            32,
            ['nullable' => true],
            'Name'
        )->addColumn(
            QuickOrderSchemaInterface::STATUS_COL_NAME,
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'unsigned'=> true]
        )->addColumn(
            QuickOrderSchemaInterface::CREATED_AT_COL_NAME,
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Date of Last Flag Update'
        )->addColumn(
            QuickOrderSchemaInterface::UPDATED_AT_COL_NAME,
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => true,  'default' => Table::TIMESTAMP_INIT_UPDATE]
        )->addIndex(
            $setup->getIdxName(
                $setup->getTable(QuickOrderSchemaInterface::TABLE_NAME),
                [QuickOrderSchemaInterface::NAME_COL_NAME],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            [QuickOrderSchemaInterface::NAME_COL_NAME],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->setComment(
            'Quick order'
        );
        $setup->getConnection()->createTable($table);
    }

    private function createStatusTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()->newTable(
            $setup->getTable(StatusSchemaInterface::TABLE_NAME)
        )->addColumn(
            StatusSchemaInterface::STATUS_ID_COL_NAME,
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned'=> true],
            'ID'
        )->addColumn(
            StatusSchemaInterface::STATUS_CODE_COL_NAME,
            Table::TYPE_TEXT,
            16,
            ['nullable' => false],
            'Status code'
        )->addColumn(
            StatusSchemaInterface::STATUS_LABEL_COL_NAME,
            Table::TYPE_TEXT,
            32,
            ['nullable' => true],
            'Status Label'
        )->addColumn(
            StatusSchemaInterface::IS_DEFAULT,
            Table::TYPE_SMALLINT,
            1,
            ['nullable' => false,  'default' => 0]
        )->addColumn(
            StatusSchemaInterface::IS_DELETED,
            Table::TYPE_SMALLINT,
            1,
            ['nullable' => false,  'default' => 0]
        )->setComment(
            'Status'
        );

        $setup->getConnection()->createTable($table);
    }
}