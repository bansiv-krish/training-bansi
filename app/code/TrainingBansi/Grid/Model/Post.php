<?php


namespace TrainingBansi\Grid\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\AbstractExtensibleModel;
use TrainingBansi\Grid\Model\ResourceModel\Post as PostResource;
use TrainingBansi\Grid\Api\Data\PostInterface;

class Post extends AbstractExtensibleModel implements PostInterface
{
    protected function _construct()
    {
        $this->_init(PostResource::class);
    }
    /**
     * Retrieve  id.
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(PostInterface::ID);
    }
     /**
      * Get title
      *
      * @return string|null
      */
    public function getTitle()
    {
        return $this->getData(PostInterface::TITLE);
    }

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->getData(PostInterface::DESCRIPTION);
    }
    /**
     * Get STATUS
     *
     * @return int|null
     */
    public function getStatus()
    {
        return $this->getData(PostInterface::STATUS);
    }
    /**
     * Get COLOR
     *
     * @return string|null
     */
    public function getColor()
    {
        return $this->getData(PostInterface::COLOR);
    }
    /**
     * Get IsEnabled
     *
     * @return int|null
     */
    public function getIsEnabled()
    {
        return $this->getData(PostInterface::IS_ENABLED);
    }
    /**
     * Get category_id
     *
     * @return int|null
     */
    public function getCategoryId()
    {
        return $this->getData(PostInterface::CATEGORY_ID);
    }
    /**
     * Get post_type
     *
     * @return int|null
     */
    public function getPostType()
    {
        return $this->getData(PostInterface::POST_TYPE);
    }
    /**
     * Set  id.
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(PostInterface::ID, $id);
    }
     /**
      * Set title.
      *
      * @param string title
      * @return $this
      */
    public function setTitle($title)
    {
        return $this->setData(PostInterface::TITLE, $title);
    }
     /**
      * Set description
      *
      * @param string title
      * @return string|null
      */
    public function setDescription($description)
    {
        return $this->setData(PostInterface::DESCRIPTION, $description);
    }
    /**
     * set status
     *
     * @param int status
     * @return int|null
     */
    public function setStatus($status)
    {
        return $this->setData(PostInterface::STATUS, $status);
    }
    /**
     * Set color
     *
     * @param string color
     * @return string|null
     */
    public function setColor($color)
    {
        return $this->setData(PostInterface::COLOR, $color);
    }
    /**
     * Set IsEnabled
     *
     * @param int is_enabled
     * @return int|null
     */
    public function setIsEnabled($is_enabled)
    {
        return $this->setData(PostInterface::IS_ENABLED, $is_enabled);
    }
    /**
     * Set category_id
     *
     * @param int category_id
     * @return int|null
     */
    public function setCategoryId($category_id)
    {
        return $this->setData(PostInterface::CATEGORY_ID, $category_id);
    }
    /**
     * Set post_type
     *
     * @param int post_type
     * @return int|null
     */
    public function setPostType($post_type)
    {
        return $this->setData(PostInterface::POST_TYPE, $post_type);
    }
}
