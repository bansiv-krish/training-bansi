<?php
namespace TrainingBansi\CustomerLoginIp\Api\Data;

interface CustomerIpAddressInterface
{
    const IP='ip';
    const ID='id';
   /**
    * Retrieve  id.
    *
    * @return int|null
    */
    public function getId();
     /**
      * Get Ip
      *
      * @return string|null
      */
    public function getIp();
    /**
     * Set  id.
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);
     /**
      * Set title.
      *
      * @param string Ip
      * @return $this
      */
    public function setIp($ip);
}
