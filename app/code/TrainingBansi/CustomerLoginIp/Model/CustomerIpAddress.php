<?php


namespace TrainingBansi\CustomerLoginIp\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\AbstractExtensibleModel;
use TrainingBansi\CustomerLoginIp\Model\ResourceModel\CustomerIpAddress as CustomerIpAddressResource;
use TrainingBansi\CustomerLoginIp\Api\Data\CustomerIpAddressInterface;

class CustomerIpAddress extends AbstractModel implements CustomerIpAddressInterface
{
    protected function _construct()
    {
        $this->_init(CustomerIpAddressResource::class);
    }
    /**
     * Retrieve  id.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(CustomerIpAddressInterface::ID);
    }
     /**
      * Get Ip
      *
      * @return string|null
      */
    public function getIp()
    {
        return $this->getData(CustomerIpAddressInterface::IP);
    }
    /**
     * Set  id.
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(CustomerIpAddressInterface::ID, $id);
    }
     /**
      * Set title.
      *
      * @param string Ip
      * @return $this
      */
    public function setIp($ip)
    {
        return $this->setData(CustomerIpAddressInterface::IP, $ip);
    }
}
