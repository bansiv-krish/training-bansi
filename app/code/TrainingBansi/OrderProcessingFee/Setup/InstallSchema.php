<?php

namespace TrainingBansi\OrderProcessingFee\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $quoteTable = 'quote';
        $orderTable = 'sales_order';
        
        //Quote tables
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteTable),
                'processing_fees',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length'=>'10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Fee'

                ]
            );
        
        //Order tables
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderTable),
                'processing_fees',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length'=>'10,2',
                    'default' => 0.00,
                    'nullable' => true,
                    'comment' =>'Fee'

                ]
            );
             $setup->getConnection()->addColumn(
                 $setup->getTable($orderTable),
                 'fees_title',
                 [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' =>'Fee title'

                 ]
             );
        
        $setup->endSetup();
    }
}
