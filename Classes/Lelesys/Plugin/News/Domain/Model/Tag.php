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
 * A Tag
 *
 * @Flow\Entity
 */
class Tag {

	/**
	 * The title
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $title;

	/**
	 * The create date
	 * @var \DateTime
	 */
	protected $createDate;

	/**
	 * The updated date
	 * @var \DateTime
	 */
	protected $updatedDate;

	/**
	 * The hidden
	 * @var boolean
	 */
	protected $hidden;

	/**
	 * The news
	 * @var \Doctrine\Common\Collections\Collection<Lelesys\Plugin\News\Domain\Model\News>
	 * @ORM\ManyToMany(mappedBy="tags")
	 */
	protected $news;

	/**
	 * Constructs hidden default value
	 */
	public function __construct() {
		$this->setHidden(0);
	}

	/**
	 * Get the Tag's title
	 *
	 * @return string The Tag's title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets this Tag's title
	 *
	 * @param string $title The Tag's title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Get the Tag's create date
	 *
	 * @return \DateTime The Tag's create date
	 */
	public function getCreateDate() {
		return $this->createDate;
	}

	/**
	 * Sets this Tag's create date
	 *
	 * @param \DateTime $createDate The Tag's create date
	 * @return void
	 */
	public function setCreateDate($createDate) {
		$this->createDate = $createDate;
	}

	/**
	 * Get the Tag's updated date
	 *
	 * @return \DateTime The Tag's updated date
	 */
	public function getUpdatedDate() {
		return $this->updatedDate;
	}

	/**
	 * Sets this Tag's updated date
	 *
	 * @param \DateTime $updatedDate The Tag's updated date
	 * @return void
	 */
	public function setUpdatedDate($updatedDate) {
		$this->updatedDate = $updatedDate;
	}

	/**
	 * Get the Tag's news
	 *
	 * @return \Doctrine\Common\Collections\Collection The Tag's news
	 */
	public function getNews() {
		return $this->news;
	}

	/**
	 * Sets this Tag's news
	 *
	 * @param \Doctrine\Common\Collections\Collection $news The Tag's news
	 * @return void
	 */
	public function setNews(\Doctrine\Common\Collections\Collection $news) {
		$this->news = $news;
	}

	/**
	 * Get the Tag's hidden
	 *
	 * @return boolean The Tag's hidden
	 */
	public function getHidden() {
		return $this->hidden;
	}

	/**
	 * Sets this Tags's hidden
	 *
	 * @param boolean $hidden The Tag's hidden
	 * @return void
	 */
	public function setHidden($hidden) {
		$this->hidden = $hidden;
	}

}

?>