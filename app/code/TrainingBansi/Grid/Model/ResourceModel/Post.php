<?php


namespace TrainingBansi\Grid\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('grid_post', 'id');
    }
}
