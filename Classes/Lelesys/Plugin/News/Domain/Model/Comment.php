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
 * A Comment
 *
 * @Flow\Entity
 */
class Comment {

	/**
	 * The name
	 *
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $name;

	/**
	 * The email
	 *
	 * @var string
	 * @Flow\Validate(type="EmailAddress")
	 */
	protected $email;

	/**
	 * The url
	 *
	 * @var string
	 * @ORM\Column(nullable=true)
	 */
	protected $url;

	/**
	 * The message
	 *
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 * @ORM\Column(type="text")
	 */
	protected $message;

	/**
	 * The created date
	 *
	 * @var \DateTime
	 */
	protected $createdDate;

	/**
	 * The updated date
	 *
	 * @var \DateTime
	 */
	protected $updatedDate;

	/**
	 * The set hidden
	 *
	 * @var boolean
	 */
	protected $setHidden;

	/**
	 * The children comment
	 *
	 * @var \Doctrine\Common\Collections\Collection<\Lelesys\Plugin\News\Domain\Model\Comment>
	 * @ORM\OneToMany(mappedBy="replyTo", cascade={"persist", "detach"})
	 */
	protected $children;

	/**
	 * The Reply to comment
	 *
	 * @var \Lelesys\Plugin\News\Domain\Model\Comment
	 * @ORM\ManyToOne(inversedBy="children", cascade={"persist", "detach"})
	 */
	protected $replyTo;

	/**
	 * The news
	 *
	 * @var \Lelesys\Plugin\News\Domain\Model\News
	 * @ORM\ManyToOne(inversedBy="comments")
	 */
	protected $news;

	/**
	 * The Constructor for comment
	 *
	 */
	public function __construct() {
		$this->setSetHidden(1);
		$this->setCreatedDate(new \DateTime());
		$this->setUpdatedDate(new \DateTime());
	}

	/**
	 * Get the Comment's name
	 *
	 * @return string The Comment's name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets this Comment's name
	 *
	 * @param string $name The Comment's name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Get the Comment's url
	 *
	 * @return string The Comment's url
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Sets this Comment's url
	 *
	 * @param string $url The Comment's url
	 * @return void
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * Get the Comment's email
	 *
	 * @return string The Comment's email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Sets this Comment's email
	 *
	 * @param string $email The Comment's email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Get the Comment's message
	 *
	 * @return string The Comment's message
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * Sets this Comment's message
	 *
	 * @param string $message The Comment's message
	 * @return void
	 */
	public function setMessage($message) {
		$this->message = $message;
	}

	/**
	 * Get the Comment's created date
	 *
	 * @return \DateTime The Comment's created date
	 */
	public function getCreatedDate() {
		return $this->createdDate;
	}

	/**
	 * Sets this Comment's created date
	 *
	 * @param \DateTime $createdDate The Comment's created date
	 * @return void
	 */
	public function setCreatedDate($createdDate) {
		$this->createdDate = $createdDate;
	}

	/**
	 * Get the Comment's updated date
	 *
	 * @return \DateTime The Comment's updated date
	 */
	public function getUpdatedDate() {
		return $this->updatedDate;
	}

	/**
	 * Sets this Comment's updated date
	 *
	 * @param \DateTime $updatedDate The Comment's updated date
	 * @return void
	 */
	public function setUpdatedDate($updatedDate) {
		$this->updatedDate = $updatedDate;
	}

	/**
	 * Get the Comment's set hidden
	 *
	 * @return boolean The Comment's set hidden
	 */
	public function getSetHidden() {
		return $this->setHidden;
	}

	/**
	 * Sets this Comment's set hidden
	 *
	 * @param boolean $setHidden The Comment's set hidden
	 * @return void
	 */
	public function setSetHidden($setHidden) {
		$this->setHidden = $setHidden;
	}

	/**
	 * Get the Comment's news
	 *
	 * @return \Lelesys\Plugin\News\Domain\Model\News The Comment's news
	 */
	public function getNews() {
		return $this->news;
	}

	/**
	 * Sets this Comment's news
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The Comment's news
	 * @return void
	 */
	public function setNews($news) {
		$this->news = $news;
	}

	/**
	 * Gets the comment children
	 *
	 * @return \Doctrine\Common\Collections\Collection The Comment's children
	 */
	public function getChildren() {
		return $this->children;
	}

	/**
	 * Sets the comment children
	 *
	 * @param \Doctrine\Common\Collections\Collection $children
	 * @return void
	 */
	public function setChildren(\Doctrine\Common\Collections\Collection $children) {
		$this->children = $children;
	}

	/**
	 * Get the Comment's reply to comment
	 *
	 * @return \Lelesys\Plugin\News\Domain\Model\Comment The Comment's Reply to comment
	 */
	public function getReplyTo() {
		return $this->replyTo;
	}

	/**
	 * Sets this Comment's reply to comment
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\Comment $replyTo The Comment's reply to comment
	 * @return void
	 */
	public function setReplyTo(\Lelesys\Plugin\News\Domain\Model\Comment $replyTo = NULL) {
		$this->replyTo = $replyTo;
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
	 * Returns the visible children comments
	 *
	 * @return array $visibleChildrenComments
	 */
	public function getVisibleChildren() {
		$visibleChildrenComments = array();
		$comments = $this->getChildren();
		if (count($comments) > 0) {
			foreach ($comments as $comment) {
				if ($comment->getSetHidden() !== TRUE) {
					$visibleChildrenComments[] = $comment;
				}
			}
		}
		return $visibleChildrenComments;
	}

}

?>