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