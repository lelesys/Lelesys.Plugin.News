<?php
namespace Lelesys\Plugin\News\Domain\Model;

/* *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Rating {

	/**
	 * The points
	 * 
	 * @var integer
	 * @ORM\Column(nullable=true)
	 */
	protected $points;

	/**
	 * The News
	 *
	 * @var \Lelesys\Plugin\News\Domain\Model\News
	 * @ORM\ManyToOne(inversedBy="ratings")
	 */
	protected $news;

	/**
	 * Get the Rating's points
	 *
	 * @return integer
	 */
	public function getPoints() {
		return $this->points;
	}

	/**
	 * Sets this Rating's points
	 *
	 * @param integer $points
	 * @return void
	 */
	public function setPoints($points) {
		$this->points = $points;
	}

	/**
	 * Gets the Rating's News
	 *
	 * @return \Lelesys\Plugin\News\Domain\Model\News
	 */
	public function getNews() {
		return $this->news;
	}

	/**
	 * Sets the Rating's News
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @return void
	 */
	public function setNews(\Lelesys\Plugin\News\Domain\Model\News $news) {
		$this->news = $news;
	}

}
?>