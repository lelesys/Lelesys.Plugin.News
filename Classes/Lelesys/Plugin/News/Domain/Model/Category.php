<?php

namespace Lelesys\Plugin\News\Domain\Model;

/*                                                                         *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A Category
 *
 * @Flow\Entity
 */
class Category {

	/**
	 * The title
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $title;

	/**
	 * The children category
	 * @var \Doctrine\Common\Collections\Collection<\Lelesys\Plugin\News\Domain\Model\Category>
	 * @ORM\OneToMany(mappedBy="parentCategory", cascade={"persist", "detach"})
	 *
	 */
	protected $children;

	/**
	 * The parent categories
	 * @var \Lelesys\Plugin\News\Domain\Model\Category
	 * @ORM\ManyToOne(inversedBy="children", cascade={"persist", "detach"})
	 */
	protected $parentCategory;

	/**
	 * Constucts the category children object
	 */
	public function __construct() {
		$this->children = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * The image
	 * @var \TYPO3\Flow\Resource\Resource
	 * @ORM\ManyToOne(cascade={"persist", "detach"})
	 */
	protected $image;

	/**
	 * The description
	 * @ORM\Column(type="text")
	 * @var string
	 */
	protected $description;

	/**
	 * The create date
	 * @var \DateTime
	 */
	protected $createDate;

	/**
	 * The hidden
	 * @var boolean
	 */
	protected $hidden;

	/**
	 * The updated date
	 * @var \DateTime
	 */
	protected $updatedDate;

	/**
	 * The news
	 * @var \Doctrine\Common\Collections\Collection<Lelesys\Plugin\News\Domain\Model\News>
	 * @ORM\ManyToMany(mappedBy="categories")
	 */
	protected $news;

	/**
	 * Get the Category's title
	 *
	 * @return string The Category's title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets this Category's title
	 *
	 * @param string $title The Category's title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Get the Category's parent categories
	 *
	 * @return \Lelesys\Plugin\News\Domain\Model\Category The Category's parent categories
	 */
	public function getParentCategory() {
		return $this->parentCategory;
	}

	/**
	 * Sets this Category's parent categories
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $parentCategory The Category's parent categories
	 * @return void
	 */
	public function setParentCategory(\Lelesys\Plugin\News\Domain\Model\Category $parentCategory = NULL) {
		$this->parentCategory = $parentCategory;
	}

	/**
	 * Get the Category's image
	 *
	 * @return \TYPO3\Flow\Resource\Resource The Category's image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Sets this Category's image
	 *
	 * @param \TYPO3\Flow\Resource\Resource $image The Category's image
	 * @return void
	 */
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	 * Get the Category's description
	 *
	 * @return string The Category's description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets this Category's description
	 *
	 * @param string $description The Category's description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Get the Category's create date
	 *
	 * @return \DateTime The Category's create date
	 */
	public function getCreateDate() {
		return $this->createDate;
	}

	/**
	 * Sets this Category's create date
	 *
	 * @param \DateTime $createDate The Category's create date
	 * @return void
	 */
	public function setCreateDate($createDate) {
		$this->createDate = $createDate;
	}

	/**
	 * Get the Category's hidden
	 *
	 * @return boolean The Category's hidden
	 */
	public function getHidden() {
		return $this->hidden;
	}

	/**
	 * Sets this Category's hidden
	 *
	 * @param boolean $hidden The Category's hidden
	 * @return void
	 */
	public function setHidden($hidden) {
		$this->hidden = $hidden;
	}

	/**
	 * Get the Category's updated date
	 *
	 * @return \DateTime The Category's updated date
	 */
	public function getUpdatedDate() {
		return $this->updatedDate;
	}

	/**
	 * Sets this Category's updated date
	 *
	 * @param \DateTime $updatedDate The Category's updated date
	 * @return void
	 */
	public function setUpdatedDate($updatedDate) {
		$this->updatedDate = $updatedDate;
	}

	/**
	 * Get the Category's news
	 *
	 * @return \Doctrine\Common\Collections\Collection The Category's news
	 */
	public function getNews() {
		return $this->news;
	}

	/**
	 * Sets this Category's news
	 *
	 * @param \Doctrine\Common\Collections\Collection $news The Category's news
	 * @return void
	 */
	public function setNews(\Doctrine\Common\Collections\Collection $news) {
		$this->news = $news;
	}

	/**
	 * Returns uuid of this object
	 *
	 * @return string
	 */
	public function getUuid() {
		return $this->Persistence_Object_Identifier;
	}

	/**
	 *
	 * @return \Doctrine\Common\Collections\Collection The Category's children
	 */
	public function getChildren() {
		return $this->children;
	}

	/**
	 *
	 * @param \Doctrine\Common\Collections\Collection $children
	 * @return void
	 */
	public function setChildren(\Doctrine\Common\Collections\Collection $children) {
		$this->children = $children;
	}

	/**
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category
	 * @return void
	 */
	public function addChildren(\Lelesys\Plugin\News\Domain\Model\Category $category) {
		$this->children->add($category);
	}

	/**
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category
	 * @return void
	 */
	public function removeChildren(\Lelesys\Plugin\News\Domain\Model\Category $category) {
		$this->children->removeElement($category);
	}

	/**
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Category $category
	 * @return void
	 */
	public function removeParentCategory(\Lelesys\Plugin\News\Domain\Model\Category $category) {
		$this->parentCategory->removeElement($category);
	}

}

?>