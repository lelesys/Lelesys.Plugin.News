<?php

namespace Lelesys\Plugin\News\Domain\Model;

/* *
 * This script belongs to the TYPO3 Flow package "Lelesys.Plugin.News".   *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Folder {

	/**
	 * The title
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $title;

	/**
	 * The date time
	 * @var \DateTime
	 */
	protected $dateTime;

	public function __construct() {
		$this->setDateTime(new \DateTime());
	}

	/**
	 * The News
	 * @var \Doctrine\Common\Collections\Collection<\Lelesys\Plugin\News\Domain\Model\News>
	 * @ORM\OneToMany(mappedBy="folder" , cascade={"persist", "remove"})
	 */
	protected $news;

	/**
	 * The Category
	 * @var \Doctrine\Common\Collections\Collection<\Lelesys\Plugin\News\Domain\Model\Category>
	 * @ORM\OneToMany(mappedBy="folder" , cascade={"persist", "remove"})
	 */
	protected $categories;

	/**
	 * Returns uuid of this object
	 *
	 * @return string
	 */
	public function getUuid() {
		return $this->Persistence_Object_Identifier;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Get the News's created date
	 *
	 * @return \DateTime The News's created date
	 */
	public function getDateTime() {
		return $this->dateTime;
	}

	/**
	 * Sets this News's created date
	 *
	 * @param \DateTime $dateTime The News's created date
	 * @return void
	 */
	public function setDateTime($dateTime) {
		$this->dateTime = $dateTime;
	}

	/**
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getNews() {
		return $this->news;
	}

	/**
	 * @param \Doctrine\Common\Collections\Collection $news
	 * @return void
	 */
	public function setNews(\Doctrine\Common\Collections\Collection $news) {
		$this->news = $news;
	}

	/**
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * @param \Doctrine\Common\Collections\Collection $categories
	 * @return void
	 */
	public function setCategories(\Doctrine\Common\Collections\Collection $categories) {
		$this->categories = $categories;
	}

}

?>