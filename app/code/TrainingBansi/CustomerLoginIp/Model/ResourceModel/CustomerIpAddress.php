<?php


namespace TrainingBansi\CustomerLoginIp\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CustomerIpAddress extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('customer_ipaddress', 'id');
    }
}
