<?php
namespace TrainingBansi\Grid\Api\Data;

interface PostInterface
{
    const TITLE='title';
    const ID='id';
    const DESCRIPTION='description';
    const IS_ENABLED='is_enabled';
    const STATUS='status';
    const COLOR='color';
    const CATEGORY_ID='category_id';
    const POST_TYPE='post_type';
   /**
    * Retrieve  id.
    *
    * @return int|null
    */
    public function getId();
     /**
      * Get title
      *
      * @return string|null
      */
    public function getTitle();

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription();
    /**
     * Get STATUS
     *
     * @return int|null
     */
    public function getStatus();
    /**
     * Get COLOR
     *
     * @return string|null
     */
    public function getColor();
    /**
     * Get IsEnabled
     *
     * @return int|null
     */
    public function getIsEnabled();
    /**
     * Get category_id
     *
     * @return int|null
     */
    public function getCategoryId();
    /**
     * Get post_type
     *
     * @return int|null
     */
    public function getPostType();
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
      * @param string title
      * @return $this
      */
    public function setTitle($title);
     /**
      * Set description
      *
      * @param string title
      * @return string|null
      */
    public function setDescription($description);
    /**
     * set status
     *
     * @param int status
     * @return int|null
     */
    public function setStatus($status);
    /**
     * Set color
     *
     * @param string color
     * @return string|null
     */
    public function setColor($color);
    /**
     * Set IsEnabled
     *
     * @param int is_enabled
     * @return int|null
     */
    public function setIsEnabled($is_enabled);
    /**
     * Set category_id
     *
     * @param int category_id
     * @return int|null
     */
    public function setCategoryId($category_id);
    /**
     * Set post_type
     *
     * @param int post_type
     * @return int|null
     */
    public function setPostType($post_type);
}
