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
 * A File
 *
 * @Flow\Entity
 */
class File {

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
	 * The original resource
	 * @var \TYPO3\Flow\Resource\Resource
	 * @ORM\ManyToOne(cascade={"persist", "detach"})
	 */
	protected $originalFileResource;

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
	 * Get the File's create date
	 *
	 * @return \DateTime The File's create date
	 */
	public function getCreateDate() {
		return $this->createDate;
	}

	/**
	 * Sets this File's create date
	 *
	 * @param \DateTime $createDate The File's create date
	 * @return void
	 */
	public function setCreateDate($createDate) {
		$this->createDate = $createDate;
	}

	/**
	 * Get the File's updated date
	 *
	 * @return \DateTime The File's updated date
	 */
	public function getUpdatedDate() {
		return $this->updatedDate;
	}

	/**
	 * Sets this File's updated date
	 *
	 * @param \DateTime $updatedDate The File's updated date
	 * @return void
	 */
	public function setUpdatedDate($updatedDate) {
		$this->updatedDate = $updatedDate;
	}

	/**
	 * Get the File's title
	 *
	 * @return string The File's title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets this File's title
	 *
	 * @param string $title The File's title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Get the File's description
	 *
	 * @return string The File's description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets this File's description
	 *
	 * @param string $description The File's description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Get the File's original resource
	 *
	 * @return \TYPO3\Flow\Resource\Resource The File's original resource
	 */
	public function getOriginalFileResource() {
		return $this->originalFileResource;
	}

	/**
	 * Sets this File's original resource
	 *
	 * @param \TYPO3\Flow\Resource\Resource $originalFileResource The File's original resource
	 * @return void
	 */
	public function setOriginalFileResource($originalFileResource) {
		$this->originalFileResource = $originalFileResource;
	}

	/**
	 * Get the File's hidden
	 *
	 * @return boolean The File's hidden
	 */
	public function getHidden() {
		return $this->hidden;
	}

	/**
	 * Sets this File's hidden
	 *
	 * @param boolean $hidden The File's hidden
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