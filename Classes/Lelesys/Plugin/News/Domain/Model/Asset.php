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
 * A Asset
 *
 * @Flow\Entity
 */
class Asset {

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
	 * The deleted
	 * @var boolean
	 */
	protected $deleted;

	/**
	 * The original resource
	 * @var \TYPO3\Flow\Resource\Resource
	 * @ORM\ManyToOne(cascade={"persist", "detach"})
	 */
	protected $originalResource;

	/**
	 * The resource
	 * @var \TYPO3\Flow\Resource\Resource
	 * @ORM\ManyToOne(cascade={"persist","detach"})
	 */
	protected $thumbnailResource;

	/**
	 * The resource
	 * @var \TYPO3\Flow\Resource\Resource
	 * @ORM\ManyToOne(cascade={"persist","detach"})
	 */
	protected $iconResource;

	/**
	 * The Carousel resource
	 * @var \TYPO3\Flow\Resource\Resource
	 * @ORM\ManyToOne(cascade={"persist","detach"})
	 */
	protected $carouselResource;

	/**
	 * The caption
	 * @var string
	 */
	protected $caption;

	/**
	 * The copy right
	 * @var string
	 */
	protected $copyRight;

	public function __construct() {
		$this->setCreateDate(new \DateTime());
		$this->setUpdatedDate(new \DateTime());
		$this->setHidden(0);
		$this->setDeleted(0);
	}

	/**
	 * Get the Asset's create date
	 *
	 * @return \DateTime The Asset's create date
	 */
	public function getCreateDate() {
		return $this->createDate;
	}

	/**
	 * Sets this Asset's create date
	 *
	 * @param \DateTime $createDate The Asset's create date
	 * @return void
	 */
	public function setCreateDate($createDate) {
		$this->createDate = $createDate;
	}

	/**
	 * Get the Asset's updated date
	 *
	 * @return \DateTime The Asset's updated date
	 */
	public function getUpdatedDate() {
		return $this->updatedDate;
	}

	/**
	 * Sets this Asset's updated date
	 *
	 * @param \DateTime $updatedDate The Asset's updated date
	 * @return void
	 */
	public function setUpdatedDate($updatedDate) {
		$this->updatedDate = $updatedDate;
	}

	/**
	 * Get the Asset's hidden
	 *
	 * @return boolean The Asset's hidden
	 */
	public function getHidden() {
		return $this->hidden;
	}

	/**
	 * Sets this Asset's hidden
	 *
	 * @param boolean $hidden The Asset's hidden
	 * @return void
	 */
	public function setHidden($hidden) {
		$this->hidden = $hidden;
	}

	/**
	 * Get the Asset's deleted
	 *
	 * @return boolean The Asset's deleted
	 */
	public function getDeleted() {
		return $this->deleted;
	}

	/**
	 * Sets this Asset's deleted
	 *
	 * @param boolean $deleted The Asset's deleted
	 * @return void
	 */
	public function setDeleted($deleted) {
		$this->deleted = $deleted;
	}

	/**
	 * Get the Asset's original resource
	 *
	 * @return \TYPO3\Flow\Resource\Resource The Asset's original resource
	 */
	public function getOriginalResource() {
		return $this->originalResource;
	}

	/**
	 * Sets this Asset's original resource
	 *
	 * @param \TYPO3\Flow\Resource\Resource $originalResource The Asset's original resource
	 * @return void
	 */
	public function setOriginalResource($originalResource) {
		$this->originalResource = $originalResource;
	}

	/**
	 * Get the Asset's resource
	 *
	 * @return \Lelesys\Plugin\News\Domain\Model\TYPO3FlowResourceResource The Asset's resource
	 */
	public function getThumbnailResource() {
		return $this->thumbnailResource;
	}

	/**
	 * Sets this Digital asset's resource
	 *
	 * @param \TYPO3\Flow\Resource\Resource $thumbnailResource The Digital asset's resource
	 * @return void
	 */
	public function setThumbnailResource($thumbnailResource) {
		$this->thumbnailResource = $thumbnailResource;
	}

	/**
	 * Get the Asset's resource
	 *
	 * @return \Lelesys\Plugin\News\Domain\Model\TYPO3FlowResourceResource The Asset's resource
	 */
	public function getIconResource() {
		return $this->iconResource;
	}

	/**
	 * Sets this Asset's resource
	 *
	 * @param \TYPO3\Flow\Resource\Resource $iconResource The Asset's resource
	 * @return void
	 */
	public function setIconResource($iconResource) {
		$this->iconResource = $iconResource;
	}

	/**
	 * Get the Asset's carouselResource
	 *
	 * @return \Lelesys\Plugin\News\Domain\Model\TYPO3FlowResourceResource The Asset's carouselResource
	 */
	public function getCarouselResource() {
		return $this->carouselResource;
	}

	/**
	 * Sets this Asset's carouselResource
	 *
	 * @param \TYPO3\Flow\Resource\Resource $carouselResource The Asset's carouselResource
	 * @return void
	 */
	public function setCarouselResource($carouselResource) {
		$this->carouselResource = $carouselResource;
	}

	/**
	 * Get the Asset's caption
	 *
	 * @return string The Asset's caption
	 */
	public function getCaption() {
		return $this->caption;
	}

	/**
	 * Sets this Asset's caption
	 *
	 * @param string $caption The Asset's caption
	 * @return void
	 */
	public function setCaption($caption) {
		$this->caption = $caption;
	}

	/**
	 * Get the Asset's copy right
	 *
	 * @return string The Asset's copy right
	 */
	public function getCopyRight() {
		return $this->copyRight;
	}

	/**
	 * Sets this Asset's copy right
	 *
	 * @param string $copyRight The Asset's copy right
	 * @return void
	 */
	public function setCopyRight($copyRight) {
		$this->copyRight = $copyRight;
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