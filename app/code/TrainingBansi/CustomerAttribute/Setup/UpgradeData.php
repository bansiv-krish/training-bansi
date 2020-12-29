<?php
namespace TrainingBansi\CustomerAttribute\Setup;

use Magento\Customer\Model\Customer;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Customer\Setup\CustomerSetupFactory;

class UpgradeData implements UpgradeDataInterface
{

    private $customerSetupFactory;

    public function __construct(
        CustomerSetupFactory $customerSetupFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
    }

/**
 * {@inheritdoc}
 */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '0.0.5', '<')) {
              $setup->startSetup();

              $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
              $customerSetup->addAttribute(
                  \Magento\Customer\Model\Customer::ENTITY,
                  "father_name",
                  [
                        'type' => 'text',
                        'label' => "Father's Name",
                        'input' => 'text',
                        'required' => false,
                        'visible' => true,
                        'user_defined' => false,
                        'sort_order' => 1000,
                        'position' => 1000,
                        'system' => 0,
                        'is_used_in_grid'=> true,
                        'is_visible_in_grid'=> true,
                        'is_filterable_in_grid' => true,
                        'is_searchable_in_grid' => true,
                    ]
              );

              $attribute = $customerSetup->getEavConfig()->getAttribute(\Magento\Customer\Model\Customer::ENTITY, 'father_name')
              ->addData(['used_in_forms' => [
               'adminhtml_customer',
               'adminhtml_checkout',
               'customer_account_create',
               'customer_account_edit'
              ]]);
              $attribute->save();

              $customerSetup->addAttribute(Customer::ENTITY, 'mother_name', [
                    'type' => 'varchar',
                    'label' => "Mother’s Name",
                    'input' => 'text',
                    'required' => false,
                    'visible' => true,
                    'user_defined' => false,
                    'sort_order' => 1000,
                    'position' => 1000,
                    'system' => 0,
                    'is_used_in_grid'=> true,
                    'is_visible_in_grid'=> true,
                    'is_filterable_in_grid' => true,
                    'is_searchable_in_grid' => true,
                ]);

              $attribute = $customerSetup->getEavConfig()->getAttribute(\Magento\Customer\Model\Customer::ENTITY, 'mother_name')
              ->addData(['used_in_forms' => [
               'adminhtml_customer',
               'adminhtml_checkout',
               'customer_account_create',
               'customer_account_edit'
              ]]);
              $attribute->save();

        }
    }
}
