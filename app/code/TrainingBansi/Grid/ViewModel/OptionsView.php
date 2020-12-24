<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TrainingBansi\Grid\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use TrainingBansi\Grid\Model\Config\Source\Status;
use TrainingBansi\Grid\Model\Config\Source\Category;
use TrainingBansi\Grid\Model\Config\Source\EventType;

/**
 * Catalog index page controller.
 */
class OptionsView implements ArgumentInterface
{
     protected $status;
     protected $event_type;
     protected $category;

    public function __construct(
        Status $status,
        EventType $event_type,
        Category $category
    ) {
          $this->status = $status;
          $this->event_type = $event_type;
          $this->category = $category;
    }
    public function getStatus()
    {
         $array=$this->status->toOptionArray();
        return $array;
    }
    public function getPostType()
    {
          $array=$this->event_type->toOptionArray();
        return $array;
    }
    public function getCategories()
    {
          $array=$this->category->toOptionArray();
        return $array;
    }
}
