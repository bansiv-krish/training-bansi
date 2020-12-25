<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\CustomerLoginIp\Model\ResourceModel\CustomerIpAddress;

use TrainingBansi\CustomerLoginIp\Model\CustomerIpAddress;
use TrainingBansi\CustomerLoginIp\Model\ResourceModel\CustomerIpAddress as CustomerIpAddressresource;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(CustomerIpAddress::class, CustomerIpAddressresource::class);
    }
}
