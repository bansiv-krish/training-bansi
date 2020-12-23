<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\Grid\Model\ResourceModel\Post;

use TrainingBansi\Grid\Model\Post;
use TrainingBansi\Grid\Model\ResourceModel\Post as Postresource;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Post::class, Postresource::class);
    }
}
