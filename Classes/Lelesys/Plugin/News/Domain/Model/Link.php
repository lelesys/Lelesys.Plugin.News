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
 * A Link
 *
 * @Flow\Entity
 */
class Link {

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
	 * The title
	 * @var string
	 */
	protected $title;

	/**
	 * The description
	 * @var string
	 */
	protected $description;

	/**
	 * The uri
	 * @var string
	 */
	protected $uri;

	/**
	 * The hidden
	 * @var boolean
	 */
	protected $hidden;

	public function __construct() {
		$this->setCreateDate(new \DateTime());
		$this->setUpdatedDate(new \DateTime());
		$this->setHidden(0);
	}

		/**
	 * Get the Link's create date
	 *
	 * @return \DateTime The Link's create date
	 */
	public function getCreateDate() {
		return $this->createDate;
	}

	/**
	 * Sets this Link's create date
	 *
	 * @param \DateTime $createDate The Link's create date
	 * @return void
	 */
	public function setCreateDate($createDate) {
		$this->createDate = $createDate;
	}

	/**
	 * Get the Link's updated date
	 *
	 * @return \DateTime The Link's updated date
	 */
	public function getUpdatedDate() {
		return $this->updatedDate;
	}

	/**
	 * Sets this Link's updated date
	 *
	 * @param \DateTime $updatedDate The Link's updated date
	 * @return void
	 */
	public function setUpdatedDate($updatedDate) {
		$this->updatedDate = $updatedDate;
	}

	/**
	 * Get the Link's title
	 *
	 * @return string The Link's title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets this Link's title
	 *
	 * @param string $title The Link's title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Get the Link's description
	 *
	 * @return string The Link's description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets this Link's description
	 *
	 * @param string $description The Link's description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Get the Link's uri
	 *
	 * @return string The Link's uri
	 */
	public function getUri() {
		return $this->uri;
	}

	/**
	 * Sets this Link's uri
	 *
	 * @param string $uri The Link's uri
	 * @return void
	 */
	public function setUri($uri) {
		$this->uri = $uri;
	}

	/**
	 * Get the Link's hidden
	 *
	 * @return boolean The Link's hidden
	 */
	public function getHidden() {
		return $this->hidden;
	}

	/**
	 * Sets this Link's hidden
	 *
	 * @param boolean $hidden The Link's hidden
	 * @return void
	 */
	public function setHidden($hidden) {
		$this->hidden = $hidden;
	}

	/**
	 * Returns uuid of this object
	 *
	 * @return string
	 */
	public function getUuid() {
		return $this->Persistence_Object_Identifier;
	}

}

?>